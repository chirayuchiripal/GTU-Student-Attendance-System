<?php
/*
    Returns Students Data from a particular master.
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
    @param  $faculty_id Bool        true, if need to match for current logged in faculty for verification
    @param  $now        Bool        true, if need to get current active academic calendars only
    
*/
use Zend\Db\Sql\Select;
function getStudentsByMst(&$response,$mst_id,$faculty_id=true,$now=true)
{   if(!ctype_digit($mst_id))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'Master ID must be digits only'
						);
		return false;
	}
	$meta_data=array(
		"batchno" => null,
		"division" => null,
		"inst_name" => null,
		"prog_name" => null,
		"dept_name" => null,
		"semester" => null,
		"subject" => null
	);
	try
	{	$dbh=new MyDbCon;
		$dbh->select("Attendance_Master");
		$dbh->select->where->equalTo("attd_mst_id",$mst_id);
		$dbh->prepare();
		if($dbh->execute())
		{	$tmp=$dbh->fetchAssoc()[0];
			$meta_data['batchno']=$tmp['batchno'];
			$meta_data['division']=$tmp['division'];
		}
		else
		{	$response = array(
                       'code' => HTTP_Status::FORBIDDEN
                       );
            return false;
        }
		$where_funcs=array(
			'=' => 'equalTo',
			'<' => 'lessThan',
			'>' => 'greaterThan',
			'<=' => 'lessThanOrEqualTo',
			'>=' => 'greaterThanOrEqualTo',
			'like' => 'like'
		);
		$where=array(
			"attd_mst_id" => $mst_id,
			"stud_status" => "C"
		);
        if($now)
        {   try
            {	$now=(new DateTime())->format("Y-m-d");
                //throw new Exception("asd");
            }catch(Exception $e)
            {	$response = array(
                       'code' => HTTP_Status::INTERNAL_SERVER_ERROR
                       );
                return false;
            }
            $where['end_date'] = "{$now}:>=";
            $where['start_date'] = "{$now}:<=";
        }
        if($faculty_id && !Privilege_Master::is_super($_SESSION['privilege_id']))
		{   $where['faculty_id'] = $_SESSION['faculty_id'];
        }
		$join_tables=array(
			"Academic_Calendar",
			"Teaches",
			"Syllabus",
			"Student_Master"
		);
		$join_on=array(
			"Academic_Calendar" => "Academic_Calendar.ac_id=Attendance_Master.ac_id",
			"Teaches" => "Attendance_Master.teaches_id=Teaches.teaches_id",
			"Syllabus" => "Teaches.syllabus_id=Syllabus.syllabus_id",
			"Student_Master" => "Student_Master.o_id=Syllabus.o_id AND Student_Master.stud_sem=Academic_Calendar.semester AND Student_Master.stud_div=Attendance_Master.division"
		);
		if(!empty($meta_data['batchno']))
			$join_on["Student_Master"].=" AND Student_Master.stud_batchno=Attendance_Master.batchno";
		$join_columns=array(
			"Academic_Calendar" => array("start_date","end_date"),
			"Teaches" => array(),
			"Syllabus" => array("sub_id"),
			"Student_Master" => array("stud_id","stud_enrolmentno","stud_rollno","stud_name","stud_father_name","stud_surname","stud_sem","stud_div","stud_batchno","o_id")
		);
		$meta_keys=array("stud_sem","stud_div","stud_batchno","o_id","sub_id","start_date","end_date");
		$dbh=new MyDbCon;
		$dbh->select("Attendance_Master");
		$dbh->select->columns(array());
		// Join Tables
		foreach($join_tables as $val)
		{	$cols=Select::SQL_STAR;
			if(isset($join_columns[$val]))
				$cols=$join_columns[$val];
			$dbh->join($val,$join_on[$val],$cols);
		}
		// Where Clause
		foreach($where as $key=>$val)
		{
			$vals=explode(':',$val);
			$wh=$where_funcs['='];
			if(!empty($vals[1]) && isset($where_funcs[$vals[1]]))
				$wh=$where_funcs[$vals[1]];
			$dbh->select->where->$wh($key,$vals[0]);
		}
		$dbh->select->order("stud_rollno ASC");
		$dbh->prepare();
		if($dbh->execute())
		{	$objs=$dbh->fetchAssoc();
			$meta_data['semester']=$objs[0]['stud_sem'];
			$meta_data['start_date']=$objs[0]['start_date'];
			$meta_data['end_date']=$objs[0]['end_date'];
			$names=Offers_Master::getNames($objs[0]['o_id']);
			$meta_data['subject']=Sub_Master::getSubjectName($objs[0]['sub_id']);
			if($names)
			{	$meta_data['inst_name']=$names['inst_name'];
				$meta_data['prog_name']=$names['prog_name'];
				$meta_data['dept_name']=$names['dept_name'];
			}
			foreach($objs as $row)
			{	foreach($meta_keys as $val)
					unset($row[$val]);
				if(!empty($row['stud_father_name']))
					$row['stud_name'].=" ".$row['stud_father_name'];
				if(!empty($row['stud_surname']))
					$row['stud_name'].=" ".$row['stud_surname'];
				unset($row['stud_father_name']);
				unset($row['stud_surname']);
			}
			//var_dump($meta_data);
			//var_dump($objs);
			$response=array(
				"metadata" => $meta_data,
				"data" => $objs
			);
            return true;
		}
		else
		{	$response = array(
                       'code' => HTTP_Status::FORBIDDEN
                       );
            return false;
        }
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
?>