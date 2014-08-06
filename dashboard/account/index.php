<?php
	$dir="../../";
	$title="Account Settings";
	require_once $dir."dashboard/includes/dash_header.php";
?>

<?php
	$myjs_includes[]="ajax/form";
	$myjs_includes[]="ajax/account_settings";
	$obj = new User_Master;
	$guide = $obj->getGuideLines();
	$class = $obj->getClass();
?>
<div id="content" class="container white-gradient">
<h1 class="form_heading purple-gradient">
Account Settings
</h1>
<br/>
<div id="final-msg-box"></div>
<form class="form-horizontal" action="" method="post" name="change_pwd" id="accntForm" enctype="multipart/form-data">
	<div class="form-group <?php echo $class['user_password']?>">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_password_old">Old Password:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="password" name="user_password_old" id="user_password_old" maxlength="<?php echo User_Master::MAX_PWD_LENGTH?>" autocomplete="off"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block"></div>
	</div>	
	<div class="form-group <?php echo $class['user_password']?>">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_password">New Password:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="password" name="user_password" id="user_password" maxlength="<?php echo User_Master::MAX_PWD_LENGTH?>" autocomplete="off"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block"><?php echo $guide['user_password']?></div>
	</div>
	<div class="form-group <?php echo $class['user_password']?>">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="user_password1">Re-type Password:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="password" name="user_password1" id="user_password1" maxlength="<?php echo User_Master::MAX_PWD_LENGTH?>" autocomplete="off"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block"></div>
	</div>
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-2 col-sm-offset-3 col-sm-3">
		<small><?php echo IForm::TOC?></small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-5 col-sm-offset-3 col-sm-7">
		<button id="submit_btn" type="submit" data-loading-text="Changing..." class="btn btn-warning btn-ams">Change Password</button>
		<button id="reset_btn" type="reset" class="btn btn-primary btn-ams">Reset</button>
		</div>
	</div>
</form>
</div>
<?php	
	$footer=1;
	require_once $dir."core/footer.php";
?>