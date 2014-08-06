<?php
//$sub_type['1']=$this->sub_type=='R'?"checked":"";
//$sub_type['2']=$this->sub_type=='E'?"checked":"";
$sub_status['1']=$this->sub_status==1?"checked":"";
$sub_status['2']=$this->sub_status==0?"checked":"";
/* Taken out of Form HereDoc statement and commented here
<!--<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_type">Subject Type:</label>
	<div id="sub_type" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="sub_type" id="sub_type_1" value="R" {$sub_type['1']}>
		<label for="sub_type_1">Regular</label>
		<input type="radio" name="sub_type" id="sub_type_2" value="E" {$sub_type['2']}>
		<label for="sub_type_2">Elective</label>
	</div>
</div>-->
*/
$form = <<<EOF
<div class="form-group {$class['sub_code']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_code">Subject Code:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="sub_code" id="sub_code" maxlength="%d" value="{$this->sub_code}" placeholder="E.g. 170701"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['sub_code']}</div>
</div>
<div class="form-group {$class['sub_name']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_name">Subject Name:</label>
	<div class="col-lg-4 col-sm-5">
		<input class="form-control" type="text" name="sub_name" id="sub_name" maxlength="%d" value="{$this->sub_name}" placeholder="E.g. Compiler Design"/>
	</div>
	<div class="col-lg-5 col-sm-4 help-block">{$guide['sub_name']}</div>
</div>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="sub_status">Subject Status:</label>
	<div id="sub_status" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="sub_status" id="sub_status_1" value="1" {$sub_status['1']}/>
		<label for="sub_status_1">Active</label>
		<input type="radio" name="sub_status" id="sub_status_2" value="0" {$sub_status['2']}/>
		<label for="sub_status_2">Deactive</label>
	</div>
</div>
EOF;
return sprintf($form,$nm::SUB_CODE_MAXLENGTH,$nm::SUB_NAME_MAXLENGTH);
?>