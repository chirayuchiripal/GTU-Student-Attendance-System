<?php
// Check not accessed directly.
if(!isset($post_add))
{	echo "Are you searching for something? You maybe in wrong place then!!";
	return;
}
$keys=array(
	"faculty_master_access",
	"inst_master_access",
	"prog_master_access",
	"dept_master_access",
	"academic_calendar_access",
	"attendance_master_access",
	"student_master_access",
	"sub_master_access",
	"user_master_access",
	"privilege_master_access",
	"offers_master_access"
);
foreach($keys as $k)
{	$right = "000";
	if(isset($_POST[$k]))
	{	foreach($_POST[$k] as $r)
		{	$r=intval($r);
			if($r>=0 && $r<=2)
			{	$right[$r]='1';
			}
		}
	}
	$_POST[$k] = $right;
}
$_POST['reports']='0';
if(isset($_POST['reports']) && intval($_POST['reports'])==1)
	$_POST['reports']='1';
//var_dump($_POST);
require_once "./common.php";

?>