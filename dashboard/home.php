<?php
	if(!isset($dir))
		return;
?>
<br/>
<div class="col-lg-offset-1 col-md-offset-1 col-lg-4 col-md-5 col-xs-12 dash_btn">
	<a href="<?php echo $dir."dashboard/attendance/"?>">
		<span class="glyphicon glyphicon-pencil"></span>
		<div class="dash_btn_label double">Add Lecture Attendance</div>
	</a>
</div>
<div class="col-lg-offset-2 col-md-offset-1 col-lg-4 col-md-5 col-xs-12 dash_btn">
	<a href="<?php echo $dir."dashboard/attendance/?act=view"?>">
		<span class="glyphicon glyphicon-list"></span>
		<div class="dash_btn_label double">View Lecture Attendance</div>
	</a>
</div>
<?php
$lg_offset="col-lg-offset-1";
$right=get_rights("reports");
if(intval($right)==1)
{	$lg_offset="col-lg-offset-2";
?>
<div class="col-lg-offset-1 col-md-offset-1 col-lg-4 col-md-5 col-xs-12 dash_btn">
	<a href="<?php echo $dir."dashboard/reports/"?>">
		<span class="glyphicon glyphicon-file"></span>
		<div class="dash_btn_label double">Generate Reports</div>
	</a>
</div>
<?php
}
?>
<div class="<?php echo $lg_offset?> col-md-offset-1 col-lg-4 col-md-5 col-xs-12 dash_btn">
	<a href="<?php echo $dir."core/logout.php"?>">
		<span class="glyphicon glyphicon-log-out"></span>
		<div class="dash_btn_label single">Log Out</div>
	</a>
</div>