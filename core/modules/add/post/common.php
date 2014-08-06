<?php
// Check not accessed directly.
if(!isset($post_add))
{	echo "Are you searching for something? You maybe in wrong place then!!";
	return;
}
// Common Add Code for database
$obj=new $_GET['master'];
$suc=$obj->set_assoc_array($_POST);
//var_dump($suc);
//var_dump($obj);
if(Master::isLegit($suc))
{	//Database Part
	$dbh=new MyDbCon;
	$dbh->insert($obj);
	$dbh->prepare();
	if($dbh->execute())
	{	$final=sprintf("%s Added Successfully!!",$_GET['master']::HEADING);
		$done=true;
	}
	echo json_encode(array("done"=>$done,"final"=>$final));
}
else
	echo json_encode($suc);
?>