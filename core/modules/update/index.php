<?php	
	$right_index=1;
	require_once $dir."core/modules/authenticate.php";
	require_once $dir."core/modules/update/id.mapping.php";
if(!empty($_GET['id']))
{
?>
<?php
	//require_once $dir."core/classes/".$_GET['master'].".class.php";
	$obj=new $_GET['master'];
	//var_dump($obj);
	$postParam = array (
		$id_mapping[$_GET['master']]=> $_GET['id']
	);
	if(MyHttpRequest::getJSONTableData($response,"?master={$_GET['master']}",$postParam))
	{	
		$suc=$obj->set_assoc_array($response[0],true);
		//var_dump($obj);
?>
<h1 class="form_heading purple-gradient">
<?php
		echo $_GET['act']." ".$_GET['master']::HEADING;
?>
</h1>
<br>
<?php	
		$myjs_includes[]="ajax/form";
		$myjs_includes[]="url_var";
		if(method_exists($obj,'getUpdateForm'))
			echo $obj->getUpdateForm($suc);
		else
			echo $obj->getHtml($suc);
?>
<?php
		$obj->includeJs();
	}
	else
		echo HTTP_Status::NOT_FOUND_MSG;
}
else
{	echo HTTP_Status::BAD_REQUEST_MSG;
}
?>