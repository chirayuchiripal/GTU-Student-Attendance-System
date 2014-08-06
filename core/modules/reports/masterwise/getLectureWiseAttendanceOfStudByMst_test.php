<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "masterwise.lib.php";
if('GET' == $_SERVER['REQUEST_METHOD'])
{	
	if(getLectureWiseAttendanceOfStudByMst($response,$_GET['mst'],$_GET['stud']))
	{	var_dump($response);
	}
}
?>