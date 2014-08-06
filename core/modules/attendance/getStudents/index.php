<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "getStudents.lib.php";
function attd_error($status=HTTP_Status::INTERNAL_SERVER_ERROR,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	$try=array("req_aborted"=>true,"error"=>$err,"status"=>$status);
	$try = json_encode($try);
    header('Content-Length: '.strlen($try));
    header('Content-Type: application/json');
    echo $try;
	exit();
}
if('GET' == $_SERVER['REQUEST_METHOD'])
{	//var_dump($_GET);
	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		attd_error(HTTP_Status::UNAUTHORIZED);
	else if(!ctype_digit($_SESSION['faculty_id']) && !Privilege_Master::is_super($_SESSION['privilege_id']))
		attd_error(HTTP_Status::FORBIDDEN);
	else if(empty($_GET['mst']) || !ctype_digit($_GET['mst']))
		attd_error(HTTP_Status::BAD_REQUEST);
    $response=array();
    if(getStudentsByMst($response,$_GET['mst']))
    {   $response = json_encode($response);
        header('Content-Length: '.strlen($response));
        header('Content-Type: application/json');
        echo $response;
    }
    else
    {   attd_error($response['code'],isset($response['message'])?$response['message']:"");
    }	
}
?>