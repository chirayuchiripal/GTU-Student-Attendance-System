<?php
/*
	Returns Attendance Master Details
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
    @param  $faculty_id Bool        true, if need to match for current logged in faculty for verification
    @param  $now        Bool        true, if need to get current active academice calendars only
*/
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
function getMstMetaData(&$response,$mst_id,$faculty_id=true,$now=true)
{
	if(!ctype_digit($mst_id))
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
			"attd_mst_id" => $mst_id
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
			"Syllabus"
		);
		$join_on=array(
			"Academic_Calendar" => "Academic_Calendar.ac_id=Attendance_Master.ac_id",
			"Teaches" => "Attendance_Master.teaches_id=Teaches.teaches_id",
			"Syllabus" => "Teaches.syllabus_id=Syllabus.syllabus_id"
		);
		$join_columns=array(
			"Academic_Calendar" => array("start_date","end_date"),
			"Teaches" => array(/*"teaches_id","faculty_id"*/),
			"Syllabus" => array(/*"syllabus_id",*/"sub_id","sub_offered_sem","o_id")
		);
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
		$dbh->prepare();
		if($dbh->execute())
		{	$objs=$dbh->fetchAssoc();
			$meta_data['semester']=$objs[0]['sub_offered_sem'];
			$meta_data['start_date']=$objs[0]['start_date'];
			$meta_data['end_date']=$objs[0]['end_date'];
			$names=Offers_Master::getNames($objs[0]['o_id']);
			$meta_data['subject']=Sub_Master::getSubjectName($objs[0]['sub_id']);
			/*$meta_data['o_id']=$objs[0]['o_id'];
			$meta_data['sub_id']=$objs[0]['sub_id'];
			$meta_data['syllabus_id']=$objs[0]['syllabus_id'];
			$meta_data['teaches_id']=$objs[0]['teaches_id'];
			$meta_data['faculty_id']=$objs[0]['faculty_id'];*/
			if($names)
			{	$meta_data['inst_name']=$names['inst_name'];
				$meta_data['prog_name']=$names['prog_name'];
				$meta_data['dept_name']=$names['dept_name'];
			}
			//var_dump($meta_data);
			//var_dump($objs);
			$response=$meta_data;
            return true;
		}
		$response = array(
				   'code' => HTTP_Status::FORBIDDEN
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
	Returns Students Attendance Details given a Attendance Master Id
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
*/
function getStudentWiseAttendanceByMst(&$response,$mst_id)
{	
	try
	{	$dbh = new MyDbCon;
		$statement = $dbh->call('student_presence_from_master',array($mst_id));
		// Get 1st ResultSet : Division & Batchno
		$resultSet = $statement->fetchAll(\PDO::FETCH_ASSOC);
		$students['metadata']['division'] = intval($resultSet[0]['division']);
		$students['metadata']['batchno'] = intval($resultSet[0]['batchno']);
		// Get 2nd ResultSet : Students Presence
		$statement->nextRowSet();
		$resultSet = $statement->fetchAll(\PDO::FETCH_ASSOC);
		$students['data']=$resultSet;
		$response = $students;
		return true;
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
	Returns Lecture Details given a Attendance Master Id
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
*/
function getLectureWiseAttendanceByMst(&$response,$mst_id)
{	
	try
	{
		$dbh = new MyDbCon;
		$dbh->select("Lectures");
		$dbh->select->columns(array('lec_id','lec_date'));
		$dbh->select->where->equalTo('attd_mst_id',$mst_id);
        $dbh->select->where->equalTo('Lectures.active', 1);
		$dbh->join('Attendance','Lectures.lec_id = Attendance.lec_id',
					array(	'presence' => new Expression("sum(presence)"),
							'total' => new Expression("count(presence)"),
							'percentage' => new Expression("ROUND(sum(presence)/count(presence)*100,2)")
					),'left');
		$dbh->select->group('Lectures.lec_id');
		$dbh->select->order('lec_date ASC');
		$dbh->prepare();
		/*
		select Lectures.lec_id,lec_date,sum(presence) as presence,count(presence) as total,ROUND(sum(presence)/count(presence)*100,2) as percentage from Lectures left join Attendance
		on Attendance.lec_id=Lectures.lec_id
		where attd_mst_id = 9 and Lectures.active = 1
		group by Lectures.lec_id
		order by lec_date ASC
		*/
		if($dbh->execute())
		{	$res=$dbh->fetchAssoc();
			//var_dump($res);
			$response['data'] = $res;
			return true;
		}
		$response = array(
				   'code' => HTTP_Status::NOT_FOUND
				   );
		return false;
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code =	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err = "Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
					   'code' => HTTP_Status::FORBIDDEN,
					   'message' => $err
					   );
		return false;
	}
}

/*
	Returns Lecture Attendance Details given a Lecture Id
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
*/
function getStudentAttendanceByLec(&$response,$lec_id)
{	if(!ctype_digit($lec_id))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'Lec ID must be digits only'
						);
		return false;
	}
	/*
	select Attendance.stud_id,stud_rollno,stud_enrolmentno,CONCAT(stud_name,' ',stud_father_name,' ',stud_surname) as stud_name,presence 
	from Attendance join Student_Master
	on Student_Master.stud_id = Attendance.stud_id
	where lec_id = 4
    order by stud_rollno ASC
	*/
	try
	{
		$dbh = new MyDbCon;
		$dbh->select("Attendance");
		$dbh->select->columns(array('stud_id','presence'));
		$dbh->select->where->equalTo('lec_id',$lec_id);
		$dbh->join('Student_Master','Student_Master.stud_id = Attendance.stud_id',
					array(	'stud_rollno','stud_enrolmentno',
							'stud_name' => new Expression("CONCAT(stud_name,' ',IFNULL(stud_father_name,''),' ',IFNULL(stud_surname,''))")
					));
		$dbh->select->order('stud_rollno ASC');
		$dbh->prepare();
		if($dbh->execute())
		{	$response = $dbh->fetchAssoc();
			return true;
		}
		else
		{	$response = array(
				'code' => HTTP_Status::NOT_FOUND,
				'message' => 'No records Found'
			);
			return false;
		}
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code =	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err = "Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
					   'code' => HTTP_Status::FORBIDDEN,
					   'message' => $err
					   );
		return false;
	}
}

/*
	Returns Student Attendance Details given a Attendance_Master Id and Stud_id
    @param  $response   MIXED       response variable contains error code or success data
    @param  $mst_id     INT         attendance master id
    @param  $stud_id    INT         stud id
*/
function getLectureWiseAttendanceOfStudByMst(&$response,$mst_id,$stud_id)
{	
	/*
		select Lectures.lec_id,lec_date,presence from Lectures 
		left join Attendance 
		on Attendance.lec_id=Lectures.lec_id and stud_id=65 
		where attd_mst_id=9 and Lectures.active = 1
		group by Lectures.lec_id 
		order by lec_date ASC
	*/
	if(!ctype_digit($mst_id) || !ctype_digit($stud_id))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'ID must be digits only'
						);
		return false;
	}
	try
	{
		$dbh = new MyDbCon;
		$dbh->select("Lectures");
		$dbh->select->columns(array('lec_id','lec_date'));
		$dbh->join('Attendance',new Expression("Lectures.lec_id = Attendance.lec_id and stud_id = {$stud_id}"),array('presence'),'left');
		$dbh->select->where->equalTo('attd_mst_id',$mst_id);
        $dbh->select->where->equalTo('Lectures.active', 1);
		$dbh->select->group('Lectures.lec_id');
		$dbh->select->order('lec_date ASC');
		$dbh->prepare();
		//echo $dbh->select->getSqlString($dbh->getAdapter()->getPlatform());
		$dbh->execute();
		$response = $dbh->fetchAssoc();
		return true;
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code =	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err = "Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
					   'code' => HTTP_Status::FORBIDDEN,
					   'message' => $err
					   );
		return false;
	}
}
?>