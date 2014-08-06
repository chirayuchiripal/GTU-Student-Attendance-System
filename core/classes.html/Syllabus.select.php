<?php
if(!isset($sub_type))
{	$sub_type['1']=$this->sub_type=='R'?"checked":"";
	$sub_type['2']=$this->sub_type=='E'?"checked":"";
}
if(!isset($sub_id))
	$sub_id = $this->sub_id;
if(!isset($sub_offered_sem))
	$sub_offered_sem = $this->sub_offered_sem;
global $dir;
$form = <<<EOF
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_id">Select Subject:</label>
	<div class="col-lg-4 col-sm-3">
		<select class="form-control ajax-control" id="sub_id" name="sub_id" size="1" data-val="{$sub_id}">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
%s
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_offered_sem">Semester:</label>
	<div class="col-lg-3 col-sm-3">
		<select class="form-control ajax-control" id="sub_offered_sem" name="sub_offered_sem" size="1" data-val="{$sub_offered_sem}">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_type">Subject Type:</label>
	<div id="sub_type" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="sub_type" id="sub_type_1" value="R" {$sub_type['1']}>
		<label for="sub_type_1">Regular</label>
		<input type="radio" name="sub_type" id="sub_type_2" value="E" {$sub_type['2']}>
		<label for="sub_type_2">Elective</label>
	</div>
</div>
EOF;
return sprintf($form,require_once("o_id.select.php"));
?>