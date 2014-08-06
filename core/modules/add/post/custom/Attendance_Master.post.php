<?php
// Check not accessed directly.
if(!isset($post_add))
{	echo "Are you searching for something? You maybe in wrong place then!!";
	return;
}

$obj=new Attendance_Master;
$suc=$obj->set_assoc_array($_POST);

if(Master::isLegit($suc))
{	
	$_POST['syllabus_id']=MyHttpRequest::insertAndGetId("Syllabus","syllabus_id",$_POST);
	$_POST['teaches_id']=MyHttpRequest::insertAndGetId("Teaches","teaches_id",$_POST);
	require_once "./common.php";
}
else
	echo json_encode($suc);
?>