<?php
// Add into Database: core/modules/add/post
function insert_error($status,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	echo json_encode(array("done"=>false,"final"=>$err,"status"=>$status));
	exit();
}
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
$error_func="insert_error";
$right_index=1;
require_once $dir."core/modules/authenticate.php";
try
{
	if('POST' == $_SERVER['REQUEST_METHOD'])
	{	$post_add=true;
		$filepath="./custom/{$_GET['master']}.post.php";
		if(file_exists($filepath))
			require_once $filepath;
		else
			require_once "./common.php";
	}
}catch(\Exception $e)
{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
	$code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
	$status=HTTP_Status::INTERNAL_SERVER_ERROR;
	if($code=='23000')
	{	$status=HTTP_Status::DUPLICATE;
		$message="Integrity Constraint Violation: Duplicate Entry!!";
	}
	$err="Failed to add entry!! Error Code: ".$code."<br/>Detailed Info: ".$message;
	insert_error($status,$err);
}
?>