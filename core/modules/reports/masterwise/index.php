<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "masterwise.lib.php";
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
if('GET' == $_SERVER['REQUEST_METHOD'])
{	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		attd_error(HTTP_Status::UNAUTHORIZED);
	else if((!ctype_digit($_SESSION['faculty_id']) && !Privilege_Master::is_super($_SESSION['privilege_id'])) || empty($_SERVER['HTTP_REFERER']))
		attd_error(HTTP_Status::FORBIDDEN);
	parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $queries);
	if(empty($queries['mst']) || !ctype_digit($queries['mst']))
		attd_error(HTTP_Status::BAD_REQUEST);
	if ( getMstMetaData($metadata,$queries['mst']) &&
		((isset($_GET['step2']) && !empty($_GET['stud_id']) && getLectureWiseAttendanceOfStudByMst($response,$queries['mst'],$_GET['stud_id'])) ||
		(isset($_GET['step2']) && !empty($_GET['lec_id']) && getStudentAttendanceByLec($response,$_GET['lec_id'])) ||
		(!isset($_GET['lecwise']) && getStudentWiseAttendanceByMst($response,$queries['mst'])) || 
		getLectureWiseAttendanceByMst($response,$queries['mst'])))
	{	
		if(isset($metadata) && !isset($_GET['step2']))
			$response['metadata'] = $metadata;
		$response = json_encode($response);
        header('Content-Length: '.strlen($response));
        header('Content-Type: application/json');
        echo $response;
    }
    else
    {   if(!isset($response))
			$response=$metadata;
		attd_error($response['code'],isset($response['message'])?$response['message']:"");
    }	
}
?>