<?php
/*
	Returns Masters List from a given Faculty ID.
	@param  $response   MIXED       response variable contains error code or success data
	@param  $fac_id     INT         attendance master id
	@param  $now        Bool        true, if need to get current active academic calendars only
*/
use Zend\Db\Sql\Select;
function getMstByFaculty(&$response,$fac_id,$now=true)
{	if(!ctype_digit($fac_id) && !Privilege_Master::is_super($_SESSION['privilege_id']))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'Faculty ID must be digits only'
						);
		return false;
	}
	try
	{
		$where_funcs=array(
			'=' => 'equalTo',
			'<' => 'lessThan',
			'>' => 'greaterThan',
			'<=' => 'lessThanOrEqualTo',
			'>=' => 'greaterThanOrEqualTo',
			'like' => 'like'
		);
		if(!Privilege_Master::is_super($_SESSION['privilege_id']))
		{	$where=array(
				"Teaches.faculty_id" => $fac_id
			);
		}
        try
		{	$now=(new DateTime())->format("Y-m-d");
		}catch(Exception $e)
		{	$response = array(
				   'code' => HTTP_Status::INTERNAL_SERVER_ERROR
				   );
			return false;
		}
		$where['end_date'] = "{$now}:>=";
		$where['start_date'] = "{$now}:<=";
		$join_tables=array(
			"Academic_Calendar",
			"Teaches",
			"Syllabus",
			"Offers_Master",
			"Inst_Master",
			"Prog_Master",
			"Dept_Master",
			"Sub_Master",
			"Faculty_Master"
		);
		$join_on=array(
			"Academic_Calendar" => "Academic_Calendar.ac_id=Attendance_Master.ac_id",
			"Teaches" => "Attendance_Master.teaches_id=Teaches.teaches_id",
			"Syllabus" => "Teaches.syllabus_id=Syllabus.syllabus_id",
			"Offers_Master" => "Offers_Master.o_id=Syllabus.o_id",
			"Inst_Master" => "Inst_Master.inst_id=Offers_Master.inst_id",
			"Prog_Master" => "Prog_Master.prog_id=Offers_Master.prog_id",
			"Dept_Master" => "Dept_Master.dept_id=Offers_Master.dept_id",
			"Sub_Master" => "Sub_Master.sub_id=Syllabus.sub_id",
			"Faculty_Master" => "Faculty_Master.faculty_id=Teaches.faculty_id"
		);
		$join_columns=array(
			"Academic_Calendar" => array("start_date","end_date","semester"),
			"Teaches" => array("type"),
			"Syllabus" => array("sub_id"),
			"Offers_Master" => array("o_id"),
			"Inst_Master" => array("inst_name"),
			"Prog_Master" => array("prog_name"),
			"Dept_Master" => array("dept_name"),
			"Sub_Master" => array("sub_name"),
			"Faculty_Master" => array("faculty_name","faculty_father_name","faculty_surname")
		);
		$dbh=new MyDbCon;
		$dbh->select("Attendance_Master");
		$dbh->select->columns(array("attd_mst_id","batchno","division"));
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
		$dbh->prepare();
		if($dbh->execute())
		{	$objs=$dbh->fetchAssoc();
			foreach($objs as $row)
			{	if(!empty($row['faculty_father_name']))
					$row['faculty_name'].=" ".$row['faculty_father_name'];
				if(!empty($row['faculty_surname']))
					$row['faculty_name'].=" ".$row['faculty_surname'];
				unset($row['faculty_father_name']);
				unset($row['faculty_surname']);
			}
			$response = $objs;
			return true;
		}
		else
		{	$response = array(
				   'code' => HTTP_Status::NOT_FOUND
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