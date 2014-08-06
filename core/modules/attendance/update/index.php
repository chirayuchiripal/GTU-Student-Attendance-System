<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "update.lib.php";
function attd_error($status=HTTP_Status::INTERNAL_SERVER_ERROR,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	$try=array("done"=>false,"final"=>$err,"status"=>$status);
	$try = json_encode($try);
    header('Content-Length: '.strlen($try));
    header('Content-Type: application/json');
	echo $try;
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
	/*var_dump($_POST);
	var_dump(authMst($response,$queries['mst'],$_SESSION['faculty_id']));
	var_dump($response);*/
	/*var_dump(authStud($response,$queries['mst'],array($_POST['stud_id'])));
	var_dump($response);*/
	/*var_dump(authLec($response,$queries['mst'],array($_POST['lec_id'])));
	var_dump($response);*/
	$flag = false;
	if(!authMst($response,$queries['mst'],$_SESSION['faculty_id']))
		attd_error(HTTP_Status::FORBIDDEN);
	if(!empty($_POST['c']) && !empty($_POST['stud_id']) && authStud($response,$queries['mst'],array($_POST['stud_id'])))
	{	$ids = array();
		foreach($_POST['c'] as $v)
			$ids[] = $v['lec_id'];
		if(authLec($response,$queries['mst'],$ids))
			$flag = true;
	}
	else if(!empty($_POST['lec_id']) && !empty($_POST['c']) && authLec($response,$queries['mst'],array($_POST['lec_id'])))
	{	$ids = array();
		foreach($_POST['c'] as $v)
			$ids[] = $v['stud_id'];
		if(authStud($response,$queries['mst'],$ids))
			$flag = true;
	}
	if((!empty($_POST['stud_id']) && $flag && updateByStudId($response,$_POST['stud_id'],$_POST['c'])) ||
	(!empty($_POST['lec_id']) && $flag && updateByLecId($response,$_POST['lec_id'],$_POST['c'])))
	{	$response = json_encode(array('done'=>true,'final'=>'Attendance Updated Successfully!'));
		header('Content-Length: '.strlen($response));
		header('Content-Type: application/json');
		echo $response;
	}
	else
	{	$code = HTTP_Status::BAD_REQUEST;
		$err = HTTP_Status::BAD_REQUEST_MSG;
		if(isset($response))
		{	$code = $response['code'];
			$err = $response['message'];
		}
		attd_error($code,$err);
	}
}
?>