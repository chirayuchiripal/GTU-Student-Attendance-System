<?php
/***********************
This Document Contains HTML of Class.
***********************/
$active['1']=$this->active==1?"checked":"";
$active['2']=$this->active==0?"checked":"";
$html=<<<EOF
<div id="final-msg-box"></div>
<form class="form-horizontal" action="" method="post" name="{$_GET['master']}_{$_GET['act']}" id="addForm" enctype="multipart/form-data">
	%s
	<div class="form-group">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="active">Status:</label>
		<div id="active" class="ui-radio-2 col-lg-3 col-sm-5">
			<input type="radio" name="active" id="active_1" value="1" {$active['1']}/>
			<label for="active_1">Active</label>
			<input type="radio" name="active" id="active_2" value="0" {$active['2']}/>
			<label for="active_2">Deactive</label>
		</div>
	</div>
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-2 col-sm-offset-3 col-sm-3">
		<small>%s</small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-5 col-sm-offset-3 col-sm-7">
		<button id="submit_btn" type="submit" data-loading-text="Adding..." class="btn btn-warning btn-ams">%s %s</button>
		<button id="reset_btn" type="reset" class="btn btn-primary btn-ams">Reset</button>
		</div>
	</div>
	<script>
		var ac_bit=0;
	</script>
</form>
EOF;
$guide=$this->getGuidelines($suc);
$class=$this->getClass($suc);
$nm=get_class($this);
global $dir;
$set_oid_name=true;
return sprintf($html,require_once($dir."core/classes.html/o_id.select.php"),IForm::TOC,ucfirst($_GET['act']),$_GET['master']::HEADING);
?>