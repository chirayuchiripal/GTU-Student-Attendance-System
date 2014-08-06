<?php
$dir="../../../";
require_once $dir."core/post_pages_head.php";
require_once "getStudents/getStudents.lib.php";
function attd_error($status=HTTP_Status::INTERNAL_SERVER_ERROR,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	$try=array("done"=>false,"final"=>$err,"status"=>$status);
	echo json_encode($try);
	exit();
}
if('POST' == $_SERVER['REQUEST_METHOD'])
{	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		attd_error(HTTP_Status::UNAUTHORIZED);
	else if(!ctype_digit($_SESSION['faculty_id']) && !Privilege_Master::is_super($_SESSION['privilege_id']))
		attd_error(HTTP_Status::FORBIDDEN);
	parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $queries);
	if(empty($queries['mst']) || !ctype_digit($queries['mst']))
		attd_error(HTTP_Status::BAD_REQUEST);
	if(getStudentsByMst($students,$queries['mst']))
	{	$abs_ids=array();
		if(isset($_POST['abs']) && is_array($_POST['abs']))
		{	$abs_ids = $_POST['abs'];
		}
        //var_dump($students);
        try
        {   $today=new DateTime();
            $lec_date=new DateTime($_POST['date']);
            $st_date=new DateTime($students['metadata']['start_date']);
            $end_date=new DateTime($students['metadata']['end_date']);
        }
        catch(\Exception $e)
        {   attd_error(HTTP_Status::BAD_REQUEST,"Invalid lecture date format.");
        }
        if($lec_date < $st_date || $lec_date > $today)
            attd_error(HTTP_Status::BAD_REQUEST,"Lecture date must be within ".$st_date->format("d-m-Y")." to ".$today->format("d-m-Y").".");
        $lec_date=$lec_date->format("Y-m-d");
        try
        {   $db=new MyDbCon;
            $db->beginTransaction();
            $obj=new Lectures(array(
                'lec_date' => $lec_date,
                'attd_mst_id' => $queries['mst']
            ));
            $db->insert($obj);
            $db->prepare();
            $db->execute();
			$lec_id=$db->getLastGeneratedValue();
            $db->setInsert(new Attendance);
			$abs_objs=array();
			foreach($students['data'] as $stud)
			{   //$ids[]=$stud['stud_id'];
				$presence = 1;
				if(in_array($stud['stud_id'],$abs_ids))
					$presence = 0;
				$abs_objs[] = new Attendance(array(
					'lec_id' => $lec_id,
					'stud_id' => $stud['stud_id'],
					'presence' => $presence
				));
			}
			$db->multiInsert($abs_objs);
            $db->execute();
            $db->commit();
            echo json_encode(array('done'=>true,'final'=>'Attendance Added Successfully!'));
        }
        catch(\Exception $e)
        {	$db->rollback();
            $message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
            $code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
            $err="Error Code: ".$code." <br/>Detailed Info: ".$message;
            attd_error(HTTP_Status::INTERNAL_SERVER_ERROR,$err);
        }
	}
    else
        attd_error($students['code'],isset($students['message'])?$students['message']:"");
}
?>