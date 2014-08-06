<?php
/*
if(!isset($_POST['user_name']))
	list_error(HTTP_Status::NOT_FOUND);
*/
$cols=$allowed_keys=array(
	"user_name",
	"email_id",
	"user_creation_date",
	"user_update_date",
	"user_status",
	"faculty_id",
	"privilege_id"
);
$obj=new User_Master;
$keys=array_keys($obj->get_assoc_array());
$restricted_keys=array_diff($keys,$allowed_keys);
foreach($restricted_keys as $k)
{	unset($_POST[$k]);
}
if(isset($_POST['CLM5']))
{	$cols=array_intersect($allowed_keys,explode(",",$_POST['CLM5']));
}
$_POST['CLM5']=implode(",",$cols);
$_SERVER['REQUEST_METHOD']="POST";
require_once "./common.php";
?>