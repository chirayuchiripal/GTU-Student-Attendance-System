<?php 	
	if(!isset($dir))
		return;
	require_once $dir."core/session.php";
	my_session_start();
	session_write_close();
	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
	{	header('Location: ../');
		exit();
	}
?>
<?php
	$jquery_ui_css="ui-lightness/jquery-ui-1.10.3.custom";
	$jquery_ui_js="jquery-ui-1.10.3.custom.min";
	$css_includes[]="dashboard";
	$css_includes[]="mydropdown";
	$myjs_includes[]="mydropdown";
	$css_pre_includes[]=$jquery_ui_css;
	$js_pre_includes[]=$jquery_ui_js;
	$menu_valid=1;
	require_once $dir."core/header.php";
?>