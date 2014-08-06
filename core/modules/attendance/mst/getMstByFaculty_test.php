<?php
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
require_once "mst.lib.php";
if('GET' == $_SERVER['REQUEST_METHOD'])
{	//var_dump($_SESSION);
	echo nl2br("Testing getMstByFaculty\n");
	getMstByFaculty($response,$_SESSION['faculty_id']);
	echo json_encode($response);
}
?>