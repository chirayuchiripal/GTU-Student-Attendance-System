<?php
$fac_status['1']=$this->faculty_status==1?"checked":"";
$fac_status['2']=$this->faculty_status==0?"checked":"";
$form = <<<EOF
<div class="form-group {$class['faculty_name']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="faculty_name">Faculty Name:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="faculty_name" id="faculty_name" maxlength="%d" value="{$this->faculty_name}" placeholder="E.g. Sachin"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['faculty_name']}</div>
</div>
<div class="form-group {$class['faculty_father_name']}">
	<label class="col-lg-3 col-sm-3 control-label" for="faculty_father_name">Faculty Father Name:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="faculty_father_name" id="faculty_father_name" maxlength="%d" value="{$this->faculty_father_name}" placeholder="E.g. Ramesh"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['faculty_father_name']}</div>
</div>
<div class="form-group {$class['faculty_surname']}">
	<label class="col-lg-3 col-sm-3 control-label" for="faculty_surname">Faculty Surname:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="faculty_surname" id="faculty_surname" maxlength="%d" value="{$this->faculty_surname}" placeholder="E.g. Tendulkar"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['faculty_surname']}</div>
</div>
<div class="form-group {$class['faculty_designation']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="faculty_designation">Faculty Designation:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="faculty_designation" id="faculty_designation" maxlength="%d" value="{$this->faculty_designation}" placeholder="E.g. Associate Professor"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['faculty_designation']}</div>
</div>
<div class="form-group {$class['faculty_mail_id']}">
	<label class="col-lg-3 col-sm-3 control-label" for="faculty_mail_id">Faculty E-mail:</label>
	<div class="col-lg-4 col-sm-5">
		<input class="form-control" type="text" name="faculty_mail_id" id="faculty_mail_id" maxlength="%d" value="{$this->faculty_mail_id}" placeholder="E.g. example@example.com"/>
	</div>
	<div class="col-lg-5 col-sm-4 help-block">{$guide['faculty_mail_id']}</div>
</div>
<div class="form-group {$class['faculty_mobile']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="faculty_mobile">Faculty Mobile Number:</label>
	<div class="col-lg-2 col-sm-3">
		<input class="form-control" type="text" name="faculty_mobile" id="faculty_mobile" maxlength="%d" value="{$this->faculty_mobile}" placeholder="E.g. 9876543210"/>
	</div>
	<div class="col-lg-7 col-sm-6 help-block">{$guide['faculty_mobile']}</div>
</div>
<div class="form-group {$class['faculty_address']}">
	<label class="col-lg-3 col-sm-3 control-label" for="faculty_address">Faculty Address:</label>
	<div class="col-lg-4 col-sm-5">
		<textarea class="form-control noresize" name="faculty_address" id="faculty_address" maxlength="%d" rows="4" placeholder="Enter upto 100 characters.">{$this->faculty_address}</textarea>
	</div>
	<div class="col-lg-5 col-sm-4 help-block">{$guide['faculty_address']}</div>
</div>
<div class="form-group {$class['faculty_joining_date']}">
	<label class="col-lg-3 col-sm-3 control-label" for="faculty_joining_date">Faculty Joining Date:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control date-control" type="text" name="faculty_joining_date" id="faculty_joining_date" value="{$this->faculty_joining_date}" placeholder="E.g. 09/08/2013"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['faculty_joining_date']}</div>
</div>
%s
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="faculty_status">Faculty Status:</label>
	<div id="faculty_status" class="ui-radio-2 col-lg-3 col-sm-5">
		<input type="radio" name="faculty_status" id="faculty_status_1" value="1" {$fac_status['1']}/>
		<label for="faculty_status_1">Active</label>
		<input type="radio" name="faculty_status" id="faculty_status_2" value="0" {$fac_status['2']}/>
		<label for="faculty_status_2">Deactive</label>
	</div>
</div>
EOF;
return sprintf($form,$nm::FAC_NAME_MAXLENGTH,$nm::FAC_NAME_MAXLENGTH,$nm::FAC_NAME_MAXLENGTH,$nm::FAC_DESG_MAXLENGTH,$nm::FAC_MAIL_MAXLENGTH,$nm::FAC_MOB_MAXLENGTH,$nm::FAC_ADDR_MAXLENGTH,require_once("o_id.select.php"));
?>