<?php
global $dir;
if(!isset($sub_type))
{	$type['0']=$this->type=='0'?"checked":"";
	$type['1']=$this->type=='1'?"checked":"";
}
if(!isset($fac_id))
	$fac_id = $this->faculty_id;
$form = <<<EOF
%s
<div class="form-group {$class['faculty_id']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="faculty_id">Select Faculty:</label>
	<div class="col-lg-5 col-sm-6">
		<select class="form-control ajax-control" id="faculty_id" name="faculty_id" size="1" data-val="{$fac_id}">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="type">Lecture Type:</label>
	<div id="type" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="type" id="type_0" value="0" {$type['0']}>
		<label for="type_0">Lecture</label>
		<input type="radio" name="type" id="type_1" value="1" {$type['1']}>
		<label for="type_1">Lab</label>
	</div>
</div>
EOF;
return sprintf($form,require_once("Syllabus.select.php"));
?>