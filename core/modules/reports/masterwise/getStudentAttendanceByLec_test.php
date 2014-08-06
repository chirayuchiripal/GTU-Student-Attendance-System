<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "masterwise.lib.php";
if('GET' == $_SERVER['REQUEST_METHOD'])
{	$_SESSION['faculty_id']=5;
	if(getStudentAttendanceByLec($response,$_GET['lec_id'],true,true))
	{	var_dump($response);
	}
}
?>