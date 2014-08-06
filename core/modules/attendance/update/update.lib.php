<?php
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
require_once "../getStudents/getStudents.lib.php";
function authMst(&$response,$mst_id,$faculty_id)
{	/*
		select count(*) as cnt from Attendance_Master
		join Teaches
		on Attendance_Master.attd_mst_id = 9 and Attendance_Master.teaches_id = Teaches.teaches_id and Teaches.faculty_id = 5
	*/
	if(Privilege_Master::is_super($_SESSION['privilege_id']))
	{	return true;
	}
	else if(!ctype_digit($mst_id) || !ctype_digit($faculty_id))
	{	$response = array(
						'code' => HTTP_Status::BAD_REQUEST,
						'message' => 'ID must be digits only'
						);
		return false;
	}
	try
	{
		$dbh = new MyDbCon;
		$dbh->select("Attendance_Master");
		$dbh->select->columns(array("cnt" => new Expression("count(*)")));
		$dbh->join("Teaches",new Expression("Attendance_Master.attd_mst_id = {$mst_id} and Attendance_Master.teaches_id = Teaches.teaches_id and Teaches.faculty_id = {$faculty_id}"),array());
		$dbh->prepare();
		$dbh->execute();
		$cnt = $dbh->fetchAssoc()[0]['cnt'];
		if(intval($cnt)===1)
			return true;
		$response = array(
                       'code' => HTTP_Status::FORBIDDEN,
                       'message' => HTTP_Status::FORBIDDEN_MSG
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
function authStud(&$response,$mst_id,array $stud_id)
{	
	$faculty_id=true;
	if(Privilege_Master::is_super($_SESSION['privilege_id']))
		$faculty_id=false;
	if(!getStudentsByMst($response,$mst_id,$faculty_id))
		return false;
	foreach($stud_id as $id)
	{	$flag=false;
		foreach($response['data'] as $stud)
		{	if(strcmp($stud['stud_id'],$id)==0)
			{	$flag=true;
				break;
			}
		}
		if(!$flag)
			break;
	}
	if($flag)
	{	$response = true;
		return true;
	}
	$response = array(
						'code' => HTTP_Status::FORBIDDEN,
						'message' => HTTP_Status::FORBIDDEN_MSG
						);
	return false;
}
function authLec(&$response,$mst_id,array $lec_id)
{	if(!ctype_digit($mst_id))
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
		$dbh->select->columns(array("lec_id"));
		$dbh->select->where->equalTo("attd_mst_id",$mst_id);
		$dbh->prepare();
		if($dbh->execute())
		{	$res = $dbh->fetchAssoc();
			$ids = array();
			foreach($res as $lec)
				$ids[]=$lec['lec_id'];
			$dif = array_diff($lec_id,$ids);
			if(empty($dif))
				return true;
		}
		$response = array(
                       'code' => HTTP_Status::FORBIDDEN,
                       'message' => HTTP_Status::FORBIDDEN_MSG
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
function updateByStudId(&$response,$stud_id,array $attd)
{	
	$objs = array();
	foreach($attd as $k=>$v)
	{	$attd[$k]['stud_id'] = $stud_id;
		$attd[$k]['presence'] = $attd[$k]['p'] == 'P' ? 1 : 0;
		unset($attd[$k]['p']);
		$objs[] = new Attendance($attd[$k]);
	}
	if(updateAttd($response,$objs))
		return true;
	return false;
}
function updateByLecId(&$response,$lec_id,array $attd)
{	$objs = array();
	foreach($attd as $k=>$v)
	{	$attd[$k]['lec_id'] = $lec_id;
		$attd[$k]['presence'] = $attd[$k]['p'] == 'P' ? 1 : 0;
		unset($attd[$k]['p']);
		$objs[] = new Attendance($attd[$k]);
	}
	if(updateAttd($response,$objs))
		return true;
	return false;
}
function updateAttd(&$response,array $objs)
{	
	/*
	insert into Attendance(lec_id,stud_id,presence) VALUES(1,3,0),(1,6,1),(1,2,1)
	on duplicate key update presence = VALUES(presence)
	*/
	try
	{	$dbh = new MyDbCon;
		$dbh->multiUpdate($objs,array("presence"));
		$dbh->execute();
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
?>