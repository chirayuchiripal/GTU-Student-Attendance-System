<?php	
	$right_index=1;
	require_once $dir."core/modules/authenticate.php";
?>
<?php
	//require_once $dir."core/classes/".$_GET['master'].".class.php";
	$obj=new $_GET['master'];
	//var_dump($obj);
	$suc=array();
?>
<h1 class="form_heading purple-gradient">
<?php
	echo $_GET['act']." ".$_GET['master']::HEADING;
?>
</h1>
<br>
<?php	echo $obj->getHtml($suc);
?>
<?php
	$myjs_includes[]="ajax/form";
	$myjs_includes[]="url_var";
	$obj->includeJs();
?>