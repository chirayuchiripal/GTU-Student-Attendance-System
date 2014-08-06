<?php	
	require_once "./core/session.php";
	my_session_start();
	if(!isset($_SESSION['login']))
		$_SESSION['login']=false;
	else if($_SESSION['login']===true)
	{	header('Location: ./dashboard/');
		exit();
	}
?>
<?php	
	$dir="./";
	$title="Login";
	$css_includes[]="login";
	require_once $dir."core/header.php";
?>
<?php
    require_once $dir."core/login.php";
?>
<div class="container text-center">
<div class="container well">
	<img src="<?php echo $dir; ?>images/logo.png" alt="SAL Technical Campus" /><h1>Attendance Management System</h1>
</div>
</div>
<div class="container">
<form class="form-horizontal" method="post" action="" name="login_form" autocomplete="off">
<fieldset>
	<legend><h2 class="text-center" style="color:#ffaf46">Please Log In</h2></legend>
	<?php
		if(isset($err))
		{	echo "<div class=\"form-group\"><div class=\"alert alert-danger col-lg-4 col-lg-offset-4 col-sm-offset-4 col-sm-5";
			echo "\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
			echo $err."</div></div>";
		}
	?>
	<div class="form-group">
		<label for="user" class="col-lg-offset-3 col-lg-2 col-md-offset-2 col-md-3 col-sm-offset-1 col-sm-3 control-label">Username:</label>
		<div class="col-lg-3 col-md-4 col-sm-5">
		<input type="text" class="form-control" id="user_name" name="user_name" maxlength="<?php echo User_Master::MAX_USR_LENGTH ?>" placeholder="Enter Username" autofocus>
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-lg-offset-3 col-lg-2 col-md-offset-2 col-md-3 col-sm-offset-1 col-sm-3 control-label">Password:</label>
		<div class="col-lg-3 col-md-4 col-sm-5">
		<input type="password" class="form-control" id="user_password" name="user_password" maxlength="<?php echo User_Master::MAX_PWD_LENGTH ?>" placeholder="Enter Password">
		</div>
	</div>
	<div class="form-group text-center">
		<div class="col-lg-12">
		<button type="submit" class="btn btn-primary btn-ams">Login</button>
		</div>
	</div>
 </fieldset>
</form>
</div>
<?php	$footer=1;
	require_once $dir."core/footer.php";
?>
