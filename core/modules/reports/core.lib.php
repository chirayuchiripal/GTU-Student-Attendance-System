<?php
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
/*
	Generates Report Data in Raw format
    @param  $response   	MIXED       response variable contains error code or success data
    @param  $o_id    		INT         Branch Id
    @param  $sem     		INT         Semester
    @param  $ac_id     		INT         Academic Year Id
    @param  $div     		CHAR        Division
    @param  $sub_id    		ARRAY       Array of subjects
    @param  $lec_type  		INT         Lab/Lecture/Both
    @param  $batchno  		INT         Batchno if lab
    @param  $ltgt   		STRING      Less Than or equal/ Greater Than or equal(Filters)
    @param  $percentage		INT         Threshold Attendance (Filters)
    @param  $sub_filter		STRING      Avg of Subjects / For Any Subject (Filters)
*/
function generateReportData(&$response,$o_id,$sem,$ac_id,$div,array $sub_id=array(),$lec_type=2,$batchno=null,$ltgt=null,$percentage=null,$sub_filter=null)
{	if(!ctype_digit($o_id) || !ctype_digit($ac_id))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'ID must be digits only'
						);
		return false;
	}
	/*
	select attd_mst_id from Attendance_Master
	join Teaches
	on Teaches.teaches_id = Attendance_Master.teaches_id and Teaches.type = 1
	join Syllabus
	on Syllabus.syllabus_id = Teaches.syllabus_id and Syllabus.o_id = 1 and Syllabus.sub_offered_sem = 8 and Syllabus.sub_id IN (1,4)
	where ac_id = 3 and division = '' and batchno = 2
	*/
	try
	{
		$dbh = new MyDbCon;
		$dbh->select("Attendance_Master");
		$dbh->select->columns(array("attd_mst_id","batchno"));
		$jt="Teaches";
		$jo="Teaches.teaches_id=Attendance_Master.teaches_id";
		$jc=array();
		if($lec_type==0 || $lec_type==1)
			$jo.=" and Teaches.type = {$lec_type}";
		$dbh->join($jt,new Expression($jo),$jc);
		$jt="Syllabus";
		$jo="Syllabus.syllabus_id = Teaches.syllabus_id and Syllabus.o_id = {$o_id} and Syllabus.sub_offered_sem = {$sem}";
		$jc=array("sub_id");
		if(!empty($sub_id))
			$jo.=" and Syllabus.sub_id IN (".implode(",",$sub_id).")";
		$dbh->join($jt,new Expression($jo),$jc);
		$jt="Sub_Master";
		$jo="Syllabus.sub_id=Sub_Master.sub_id";
		$jc=array("sub_code","sub_name");
		$dbh->join($jt,$jo,$jc);
		$dbh->select->where->equalTo("ac_id",$ac_id);
		$dbh->select->where->equalTo("division",$div);
		if($lec_type==1 && isset($batchno))
			$dbh->select->where->equalTo('batchno',$batchno);
		$dbh->prepare();
		if($dbh->execute())
		{	$res = $dbh->fetchAssoc();
			//var_dump($res);
			$attd=array();
            if ($res) {
                foreach($res as $mst)
                {	if(isset($attd[$mst['sub_id']]))
                    {	$attd[$mst['sub_id']]['masters'][]=$mst['attd_mst_id'];
                    }
                    else
                    {	$attd[$mst['sub_id']]=array(
                            'sub_name' => $mst['sub_name'],
                            'sub_code' => $mst['sub_code'],
                            'masters'  => array($mst['attd_mst_id'])
                        );
                    }
                }
            } else {
                $response = array(
                   'code' => HTTP_Status::INTERNAL_SERVER_ERROR
                   );
                return false;
            }
			/*
			select Attendance.stud_id,CONCAT(stud_name,' ',stud_father_name,' ',stud_surname) as stud_name,stud_rollno,stud_enrolmentno,sum(presence) as presence,count(presence) as total,ROUND((sum(presence) / count(presence))*100,2) as percentage 
			from Attendance 
			join Student_Master
			on Student_Master.stud_id = Attendance.stud_id
			where lec_id in(select lec_id from Lectures where attd_mst_id=mst_id) group by Attendance.stud_id order by stud_rollno ASC;
			*/
			//$attd_by_mst=array();
			$attendance=array();
			foreach($attd as $sub_attd)
			{	
				$mst = implode(',',$sub_attd['masters']);
				//var_dump($mst);
				$dbh = new MyDbCon;
				$dbh->select("Attendance");
				$dbh->select->columns(array(
					"stud_id",
					"presence" => new Expression("sum(presence)"),
					"total" => new Expression("count(presence)"),
					"percentage" => new Expression("ROUND((sum(presence) / count(presence))*100,2)")
				));
				$dbh->join("Student_Master","Student_Master.stud_id = Attendance.stud_id",array("stud_name" => new Expression("CONCAT(stud_name,' ',stud_father_name,' ',stud_surname)"),
					"stud_rollno",
					"stud_enrolmentno"));
				$dbh->select->where("lec_id in(select lec_id from Lectures where attd_mst_id IN ({$mst}))");
				$dbh->select->group("Attendance.stud_id");
				$dbh->select->order("stud_enrolmentno ASC");
				$dbh->prepare();
				if($dbh->execute())
				{	$tmp_res=$dbh->fetchAssoc();
                    if ($tmp_res) {
                        foreach($tmp_res as $s)
                        {	if(isset($attendance[$s['stud_id']]))
                            {	$attendance[$s['stud_id']]['attendance'][$sub_attd['sub_code']] = number_format(floatval($s['percentage']), 2, '.', '');
                            }
                            else
                            {	$attendance[$s['stud_id']]=array(
                                    "stud_name" => $s['stud_name'],
                                    "stud_rollno" => $s['stud_rollno'],
                                    "stud_enrolmentno" => $s['stud_enrolmentno'],
                                    "attendance" => array(
                                        $sub_attd['sub_code'] => number_format(floatval($s['percentage']), 2, '.', '')
                                    )
                                );
                            }
                        }
                    } else {
                        $response = array(
                           'code' => HTTP_Status::INTERNAL_SERVER_ERROR
                           );
                        return false;
                    }
				}
			}
			if(isset($ltgt,$percentage,$sub_filter))
			{	foreach($attendance as $id=>$stud)
				{	$flag=false;
					if(strcmp($sub_filter,"any")==0)
					{	foreach($stud['attendance'] as $attd)
						{	if( (strcmp($ltgt,"<=")==0 && $attd <= $percentage)||
								(strcmp($ltgt,">=")==0 && $attd >= $percentage))
							{	$flag = true;
								break;
							}
						}
					}
					else if(strcmp($sub_filter,"avg")==0)
					{	$sum = array_sum($stud['attendance']);
						$cnt = count($stud['attendance']);
						$avg = $sum/$cnt;
						//echo $avg." ";
						if( (strcmp($ltgt,"<=")==0 && $avg <= $percentage)||
							(strcmp($ltgt,">=")==0 && $avg >= $percentage))
						{	$flag = true;
						}
					}
					if(!$flag)
						unset($attendance[$id]);
						//$attendance[$id]=false;
				}
			}
			if(empty($attendance))
			{	$response = array(
				   'code' => HTTP_Status::NOT_FOUND
				   );
				return false;
			}
			$response = $attendance;
			return true;
		}
		$response = array(
				   'code' => HTTP_Status::NOT_FOUND
				   );
		return false;
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err="Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
                       'code' => HTTP_Status::FORBIDDEN,
                       'message' => $err
                       );
        return false;
	}
}
/*
	Generates Report Data in HTML Table Format
    @param  $response   	MIXED       response variable contains error code or success data
	@param 	$title			STRING		Title of the Report
    @param  $o_id    		INT         Branch Id
    @param  $sem     		INT         Semester
    @param  $ac_id     		INT         Academic Year Id
    @param  $div     		CHAR        Division
    @param  $sub_id    		ARRAY       Array of subjects
    @param  $lec_type  		INT         Lab/Lecture/Both
    @param  $batchno  		INT         Batchno if lab
    @param  $ltgt   		STRING      Less Than/ Greater Than (Filters)
    @param  $percentage		INT         Threshold Attendance (Filters)
    @param  $sub_filter		STRING      Avg of Subjects / For Any Subject (Filters)
*/
function generateHTMLReport(&$response,$title,$o_id,$sem,$ac_id,$div,array $sub_id=array(),$lec_type=2,$batchno=null,$ltgt=null,$percentage=null,$sub_filter=null)
{	try
	{	$dbh = new MyDbCon;
		$dbh->select("Offers_Master");
		$dbh->select->columns(array());
		$dbh->join("Inst_Master",new Expression("Inst_Master.inst_id = Offers_Master.inst_id and Offers_Master.o_id = {$o_id}"),array("inst_name"));
		$dbh->join("Prog_Master",new Expression("Prog_Master.prog_id = Offers_Master.prog_id and Offers_Master.o_id = {$o_id}"),array("prog_name"));
		$dbh->join("Dept_Master",new Expression("Dept_Master.dept_id = Offers_Master.dept_id and Offers_Master.o_id = {$o_id}"),array("dept_name"));
		$dbh->prepare();
		$dbh->execute();
		$class_details = $dbh->fetchAssoc()[0];
		$class_details['semester'] = $sem;
		$title=strtoupper($title);
		foreach($class_details as $key=>$val)
		{	$class_details[$key] = strtoupper($val);
		}
		//var_dump($class_details);
		if(generateReportData($data,$o_id,$sem,$ac_id,$div,$sub_id,$lec_type,$batchno,$ltgt,$percentage,$sub_filter))
		{	//var_dump($data);
			$first=current($data);
			$cols = count($first['attendance']) + 1;
			$batch_label=$div_label="";
			$cols_arr=array();
			$now = (new DateTime)->format("d/m/Y");
            $lec_label = "";
			if(intval($lec_type)==2)
				$lec_label="Lecture & Lab ";
			else if(intval($lec_type==1))
				$lec_label="Lab ";
			else if(intval($lec_type==0))
				$lec_label="Lecture ";
			if(!empty($div))
				$div_label=" | Division: {$div}";
			if($lec_type==1)
			{	$batch_label = " | Batch No.: ".(empty($batchno)?"All":$batchno);
			}
			$html=<<<EOF
<table class="report_table table table-striped table-bordered table-hover" border="1" cellpadding="3" align="center" style="">
	<thead>
		<tr>
			<th colspan="{$cols}" style="font-weight:bold">{$class_details['inst_name']}</th>
		</tr>
		<tr>
			<th colspan="{$cols}" style="font-weight:bold">{$class_details['prog_name']}, {$class_details['dept_name']}</th>
		</tr>
		<tr>
			<th colspan="{$cols}" class="report-sem" style="font-weight:bold">Semester: {$sem}{$div}{$batch_label}</th>
		</tr>
EOF;
		if(isset($ltgt,$percentage,$sub_filter))
		{	$filter_label = "";
            if(strcmp($sub_filter,"any")==0)
				$filter_label="in any of the subject(s)";
			else if(strcmp($sub_filter,"avg")==0)
				$filter_label="average of all subject(s)";
			$html.='<tr><th colspan="'.$cols.'" style="font-weight:bold">'.$lec_label.'Attendance '.htmlspecialchars($ltgt).' '.$percentage.'% '.$filter_label.'</th></tr>';
		}
		$html.=<<<EOF
		<tr>
			<th colspan="{$cols}" class="report-title" style="font-weight:bold">{$title} ({$now})</th>
		</tr>
		<tr>
			<th style="font-weight:bold">Enrolment No.</th>
EOF;
			foreach($first['attendance'] as $col=>$attd)
			{	$html.='<th style="font-weight:bold">'.$col."</th>";
				$cols_arr[]=$col;
			}
$html.=<<<EOF
	</tr>
	<tr>
EOF;
			for($i=0;$i<$cols;$i++)
				$html.="<td>&nbsp;</td>";
$html.=<<<EOF
	</tr>
	</thead>
	<tbody>
EOF;
			foreach($data as $stud)
			{	$html.='<tr><td>'.$stud['stud_enrolmentno']."</td>";
				foreach($cols_arr as $col)
				{	$html.='<td>';
					$con="-";
					if(isset($stud['attendance'][$col]))
						$con = $stud['attendance'][$col]."%";
					$html.=$con."</td>";
				}
				$html.="</tr>";
			}
$html.=<<<EOF
	</tbody>
</table>
EOF;
			$response = $html;
			return true;
		}
		$response = $data;
		return false;
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err="Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
                       'code' => HTTP_Status::FORBIDDEN,
                       'message' => $err
                       );
        return false;
	}
}
/*
	Generates Report Data in HTML Table Format
    @param  $response   	MIXED       response variable contains error code or success data
	@param 	$title			STRING		Title of the Report
    @param  $o_id    		INT         Branch Id
    @param  $sem     		INT         Semester
    @param  $ac_id     		INT         Academic Year Id
    @param  $div     		CHAR        Division
    @param  $sub_id    		ARRAY       Array of subjects
    @param  $lec_type  		INT         Lab/Lecture/Both
    @param  $batchno  		INT         Batchno if lab
    @param  $ltgt   		STRING      Less Than/ Greater Than (Filters)
    @param  $percentage		INT         Threshold Attendance (Filters)
    @param  $sub_filter		STRING      Avg of Subjects / For Any Subject (Filters)
*/
function generateCSVReport(&$response,$title,$o_id,$sem,$ac_id,$div,array $sub_id=array(),$lec_type=2,$batchno=null,$ltgt=null,$percentage=null,$sub_filter=null)
{	global $dir;
	try
	{	$dbh = new MyDbCon;
		$dbh->select("Offers_Master");
		$dbh->select->columns(array());
		$dbh->join("Inst_Master",new Expression("Inst_Master.inst_id = Offers_Master.inst_id and Offers_Master.o_id = {$o_id}"),array("inst_name"));
		$dbh->join("Prog_Master",new Expression("Prog_Master.prog_id = Offers_Master.prog_id and Offers_Master.o_id = {$o_id}"),array("prog_name"));
		$dbh->join("Dept_Master",new Expression("Dept_Master.dept_id = Offers_Master.dept_id and Offers_Master.o_id = {$o_id}"),array("dept_name"));
		$dbh->prepare();
		$dbh->execute();
		$class_details = $dbh->fetchAssoc()[0];
		$class_details['semester'] = $sem;
		$title=strtoupper($title);
		foreach($class_details as $key=>$val)
		{	$class_details[$key] = strtoupper($val);
		}
		//var_dump($class_details);
		if(generateReportData($data,$o_id,$sem,$ac_id,$div,$sub_id,$lec_type,$batchno,$ltgt,$percentage,$sub_filter))
		{	//var_dump($data);
			$first=current($data);
			$cols = count($first['attendance']) + 1;
			$batch_label=$div_label="";
			$cols_arr=array();
            $lec_label = "";
			if(intval($lec_type)==2)
				$lec_label=" | Lecture/Lab";
			else if(intval($lec_type==1))
				$lec_label=" | Lab";
			else if(intval($lec_type==0))
				$lec_label=" | Lecture";
			if(!empty($div))
				$div_label=" | Division: {$div}";
			if($lec_type==1)
				$batch_label = " | Batch No.: {$batchno}";
			$html=<<<EOF
"{$class_details['inst_name']}"
"{$class_details['prog_name']}",{$class_details['dept_name']}
"Semester: {$sem}{$div}{$lec_label}{$batch_label}"

EOF;
		if(isset($ltgt,$percentage,$sub_filter))
		{	$filter_label = "";
            if(strcmp($sub_filter,"any")==0)
				$filter_label="in any of the subject(s)";
			else if(strcmp($sub_filter,"avg")==0)
				$filter_label="average of all subject(s)";
			$html.='"Attendance '.$ltgt.' '.$percentage.'% '.$filter_label.'"';
		}
		$html.=<<<EOF

"{$title}"

"Enrolment No."
EOF;
			foreach($first['attendance'] as $cols=>$attd)
			{	$html.=','.$cols;
				$cols_arr[]=$cols;
			}
			$html.="\n";
			foreach($data as $stud)
			{	$html.="\n\"=\"\"".$stud['stud_enrolmentno']."\"\"\",";
				foreach($cols_arr as $col)
				{	
					$con="-";
					if(isset($stud['attendance'][$col]))
						$con = "\"".$stud['attendance'][$col]."\"";
					$html.=$con.",";
				}
			}
			$filename=$dir.'tmp/'.uniqid().'.csv';
			$file=fopen($filename,"w") or exit("Unable to create file!");
			fwrite($file,$html);
			fclose($file);
			$now = (new DateTime())->format("d-m-Y");
			header("Content-type:text/csv");
			header("Content-Disposition:attachment;filename=report_{$now}.csv");
			readfile($filename);
			ob_end_flush();
			unlink($filename);
			return true;
		}
		$response = $data;
		return false;
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err="Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
                       'code' => HTTP_Status::FORBIDDEN,
                       'message' => $err
                       );
        return false;
	}
}
/*
	Generates Report Data in HTML Table Format
    @param  $response   	MIXED       response variable contains error code or success data
	@param 	$title			STRING		Title of the Report
    @param  $o_id    		INT         Branch Id
    @param  $sem     		INT         Semester
    @param  $ac_id     		INT         Academic Year Id
    @param  $div     		CHAR        Division
    @param  $sub_id    		ARRAY       Array of subjects
    @param  $lec_type  		INT         Lab/Lecture/Both
    @param  $batchno  		INT         Batchno if lab
    @param  $ltgt   		STRING      Less Than/ Greater Than (Filters)
    @param  $percentage		INT         Threshold Attendance (Filters)
    @param  $sub_filter		STRING      Avg of Subjects / For Any Subject (Filters)
*/
function generatePDFReport(&$response,$title,$o_id,$sem,$ac_id,$div,array $sub_id=array(),$lec_type=2,$batchno=null,$ltgt=null,$percentage=null,$sub_filter=null)
{	if(generateHTMLReport($data,$title,$o_id,$sem,$ac_id,$div,$sub_id,$lec_type,$batchno,$ltgt,$percentage,$sub_filter))
	{	//echo $data;
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('SAL AMS');
		$pdf->SetTitle('Report - '.strtoupper($title));
		$pdf->SetSubject('Attendance Report');
		//var_dump($_SESSION);
		$pdf->SetHeaderData(null, 0, strtoupper($title), "Attendance Management System\nDate: ".(new DateTime())->format("d-m-Y"));
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// set image scale factor
		//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// add a page
		$pdf->AddPage();
		// Write HTML table to PDF document
		$pdf->SetFont('times', '', 12);
		$pdf->writeHTML($data, true, false, false, false, '');
		//Close and output PDF document
		header('Content-type: application/pdf');
		$pdf->Output('Report_'.(new DateTime())->format("d-m-Y"), 'I');
		return true;
	}
	$response = $data;
	return false;
}
?>