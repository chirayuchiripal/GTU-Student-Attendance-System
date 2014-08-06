<?php
function list_error($status=HTTP_Status::INTERNAL_SERVER_ERROR,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	$try=array("req_aborted"=>true,"error"=>$err,"status"=>$status);
	$final = json_encode(array($try));
	header('Content-Length: '.strlen($final));
    header('Content-Type: application/json');
	echo $final;
	exit();
}
$dir="../../../../";
require_once $dir."core/post_pages_head.php";
$error_func="list_error";
$right_index=0;
require_once $dir."core/modules/authenticate.php";
try
{
	$dbh=new MyDbCon;
	$dbh->select($_GET['master']);
	include "./joins.php";
	$filepath="./custom/{$_GET['master']}.get.php";
	if(file_exists($filepath))
		require_once $filepath;
	else
		require_once "./common.php";
	$dbh->prepare();
	if($dbh->execute())
	{	if(isset($clm))
		{	$res=$dbh->fetchAssoc();
			$final=json_encode($res);
		}
		else
		{	$objs=$dbh->fetchAll();
            $final=json_encode($objs);
		}
        header('Content-Length: '.strlen($final));
        header('Content-Type: application/json');
        echo $final;
	}
	else
		list_error(HTTP_Status::NOT_FOUND);
}catch(\Exception $e)
{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
	$code=	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
	$err="Error Code: ".$code." <br/>Detailed Info: ".$message;
	list_error(HTTP_Status::INTERNAL_SERVER_ERROR,$err);
}
?>