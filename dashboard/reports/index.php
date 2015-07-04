<?php
	$dir="../../";
	$title="Generate Reports";
	require_once $dir."dashboard/includes/dash_header.php";
?>
<div id="content" class="container white-gradient">
<?php
	function report_error($msg)
	{	global $dir;
		echo $msg."</div>";
		$footer=1;
		require_once $dir."core/footer.php";
		exit();
	}
	$right=get_rights("reports");
	if(intval($right)!=1)
		report_error(HTTP_Status::FORBIDDEN_MSG);
?>
<h1 class="form_heading purple-gradient">
<?php
	echo "Generate Reports";
?>
</h1>
<script>
var dir="../../";
</script>
<br/>
<form class="form-horizontal" action="<?php echo $dir?>core/modules/reports/" method="post" name="reportForm" id="reportForm" enctype="multipart/form-data">
<?php
	$class['o_id']=IForm::NORM_CLASS;
	$inst_id=$prog_id=$dept_id=-1;
	$myjs_includes[]="ajax/form";
	$myjs_includes[]="ajax/reports";
	$myjs_includes[]="ajax/populate_sem";
	$myjs_includes[]="ajax/o_id.select";
	$myjs_includes[]="ajax/acad_cal.select";
	echo include_once "{$dir}core/classes.html/o_id.select.php";
?>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_offered_sem">Semester:</label>
	<div class="col-lg-3 col-sm-3">
		<select class="form-control ajax-control" id="sub_offered_sem" name="sub_offered_sem" size="1">
		</select>
		<img class="ajax_loader" src="<?php echo $dir;?>images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group {$class['ac_id']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="ac_id">Academic Calendar:</label>
	<div class="col-lg-4 col-sm-6">
		<select class="form-control ajax-control" id="ac_id" name="ac_id" size="1">
		</select>
		<img class="ajax_loader" src="<?php echo $dir;?>images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label" for="sub_id">Select Subject(s):</label>
	<div class="col-lg-4 col-sm-3">
		<select class="form-control ajax-control" id="sub_id" name="sub_id[]" multiple="multiple">
		</select>
		<img class="ajax_loader" src="<?php echo $dir;?>images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="type">Lecture Type:</label>
	<div id="type" class="ui-radio-3 col-lg-3 col-sm-5">
		<input type="radio" name="type" id="type_0" value="0">
		<label for="type_0">Lecture</label>
		<input type="radio" name="type" id="type_1" value="1">
		<label for="type_1">Lab</label>
		<input type="radio" name="type" id="type_2" value="2" checked="checked">
		<label for="type_2">Both</label>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label" for="batchno">Batch No:</label>
	<div class="col-lg-2 col-sm-3">
	<input class="form-control" type="text" name="batchno" id="batchno" maxlength="2" placeholder="E.g. 1"/>
	</div>
	<span class="col-lg-4 col-sm-6 help-block"></span>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label" for="division">Division:</label>
	<div class="col-lg-2 col-sm-3">
	<input class="form-control" type="text" name="division" id="division" maxlength="2" placeholder="E.g. A"/>
	</div>
	<span class="col-lg-4 col-sm-6 help-block"></span>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label">Filter:</label>
	<div id="filter" class="col-lg-9 col-sm-9">
		<div class="col-lg-1 col-md-2 col-sm-2" style="padding:0px;padding-top:7px;text-align:right">
			<b>Attendance</b>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3">
			<select class="form-control" id="ltgt" name="ltgt">
				<option value="lte">&lt;=</option>
				<option value="gte">&gt;=</option>
			</select>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<input class="form-control" type="text" id="percentage" name="percentage" placeholder=" in %"/>
		</div>
		<div class="col-lg-4 col-md-5 col-sm-5">
			<select class="form-control" id="sub_filter" name="sub_filter">
				<option value="any">in any of the subject(s)</option>
				<option value="avg">average of all subject(s)</option>
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label mandatory" for="report_format">Select Format:</label>
	<div class="col-lg-3 col-sm-4">
		<select class="form-control" id="report_format" name="report_format">
			<option value="html">Live Edit (Print-Ready)</option>
			<option value="pdf">Portable Document Format (.pdf)</option>
			<option value="csv">CSV for MS Excel (.csv)</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 col-sm-3 control-label" for="rtitle">Report Title:</label>
	<div class="col-lg-3 col-sm-4">
	<input class="form-control" type="text" name="title" id="rtitle" placeholder="E.g. Detain List"/>
	</div>
	<span class="col-lg-4 col-sm-6 help-block"></span>
</div>
<div class="form-group">
	<div class="col-12 col-lg-offset-3 col-lg-2 col-sm-offset-3 col-sm-3">
	<small><?php echo IForm::TOC; ?></small>
	</div>
</div>
<div class="form-group">
	<div class="col-12 col-lg-offset-3 col-lg-5 col-sm-offset-3 col-sm-7">
	<button id="submit_btn" type="submit" data-loading-text="Generating.." class="btn btn-warning btn-ams">Generate Report</button>
	<button id="reset_btn" type="reset" class="btn btn-primary btn-ams">Reset</button>
	</div>
</div>
</form>
</div>
<?php	
	$footer=1;
	require_once $dir."core/footer.php";
?>