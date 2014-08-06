<?php
// Check not accessed directly.
if(!isset($post_update))
{	echo "Are you searching for something? You maybe in wrong place then!!";
	return;
}

// Common Update Code for database
$obj=new $_GET['master'];
$suc=$obj->set_assoc_array($_POST);
//var_dump($suc);
//var_dump($obj);
if(Master::isLegit($suc))
{	//Database Part
	$dbh=new MyDbCon;
	$dbh->update($obj,array($id_mapping[$_GET['master']] => $queries['id']),$dontUpdateIds);
	$dbh->prepare();
	$dbh->execute();
	$final=sprintf("%s Updated Successfully!!",$_GET['master']::HEADING);
	echo json_encode(array("done"=>true,"final"=>$final));
}
else
	echo json_encode($suc);
?>