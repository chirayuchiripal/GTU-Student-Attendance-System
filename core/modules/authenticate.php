<?php
// Default Error Printing Function
function default_error($status)
{	$err=HTTP_Status::getMessage($status);
	global $dir;
	echo $err;
	$footer=1;
	require_once $dir."core/footer.php";
	die();
}

// Check user defined error function is valid or not.
if(empty($error_func) || !function_exists($error_func))
	$error_func="default_error";
try
{
	// Check Valid Login & has enough rights
	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		call_user_func($error_func,HTTP_Status::UNAUTHORIZED);
	else if(!function_exists('get_rights') || empty($_GET['master']) || get_rights($_GET['master'])[$right_index]!='1')
		call_user_func($error_func,HTTP_Status::FORBIDDEN);
}catch(\Exception $e)
{	call_user_func($error_func,HTTP_Status::INTERNAL_SERVER_ERROR);
}
?>