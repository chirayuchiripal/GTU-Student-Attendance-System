<?php
$status=array("A","C","D","L");
foreach($status as $val)
{	$stud_status[$val]="";
	if($this->stud_status==$val)
		$stud_status[$val]="selected";
}
global $dir;
$form = <<<EOF
<div class="form-group {$class['stud_enrolmentno']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="stud_enrolmentno">Enrolment No.:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="stud_enrolmentno" id="stud_enrolmentno" maxlength="%d" value="{$this->stud_enrolmentno}" placeholder="E.g. 100670107064"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_enrolmentno']}</div>
</div>
<div class="form-group {$class['stud_rollno']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="stud_rollno">Roll No.:</label>
	<div class="col-lg-2 col-sm-4">
		<input class="form-control" type="text" name="stud_rollno" id="stud_rollno" maxlength="%d" value="{$this->stud_rollno}" placeholder="E.g. 10CE001"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_rollno']}</div>
</div>
<div class="form-group {$class['stud_name']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="stud_name">Student Name:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="stud_name" id="stud_name" maxlength="%d" value="{$this->stud_name}" placeholder="E.g. Sachin"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_name']}</div>
</div>
<div class="form-group {$class['stud_father_name']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_father_name">Father's Name:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="stud_father_name" id="stud_father_name" maxlength="%d" value="{$this->stud_father_name}" placeholder="E.g. Ramesh"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_father_name']}</div>
</div>
<div class="form-group {$class['stud_surname']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_surname">Student Surname:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="stud_surname" id="stud_surname" maxlength="%d" value="{$this->stud_surname}" placeholder="E.g. Tendulkar"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_surname']}</div>
</div>
<div class="form-group {$class['stud_mail']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_mail">Student E-mail:</label>
	<div class="col-lg-4 col-sm-5">
		<input class="form-control" type="text" name="stud_mail" id="stud_mail" maxlength="%d" value="{$this->stud_mail}" placeholder="E.g. example@example.com"/>
	</div>
	<div class="col-lg-5 col-sm-4 help-block">{$guide['stud_mail']}</div>
</div>
<div class="form-group {$class['stud_contact']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_contact">Student Mobile Number:</label>
	<div class="col-lg-2 col-sm-3">
		<input class="form-control" type="text" name="stud_contact" id="stud_contact" maxlength="%d" value="{$this->stud_contact}" placeholder="E.g. 9876543210"/>
	</div>
	<div class="col-lg-7 col-sm-6 help-block">{$guide['stud_contact']}</div>
</div>
<div class="form-group {$class['stud_parent_contact']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_parent_contact">Parent's Mobile Number:</label>
	<div class="col-lg-2 col-sm-3">
		<input class="form-control" type="text" name="stud_parent_contact" id="stud_parent_contact" maxlength="%d" value="{$this->stud_parent_contact}" placeholder="E.g. 9876543210"/>
	</div>
	<div class="col-lg-7 col-sm-6 help-block">{$guide['stud_parent_contact']}</div>
</div>
<div class="form-group {$class['stud_address']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_address">Permanent Address:</label>
	<div class="col-lg-4 col-sm-5">
		<textarea class="form-control noresize" name="stud_address" id="stud_address" maxlength="%d" rows="4" placeholder="Enter upto 100 characters.">{$this->stud_address}</textarea>
	</div>
	<div class="col-lg-5 col-sm-4 help-block">{$guide['stud_address']}</div>
</div>
<div class="form-group {$class['stud_city']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_city">City:</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="stud_city" id="stud_city" maxlength="%d" value="{$this->stud_city}" placeholder="E.g. Ahmedabad"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_city']}</div>
</div>
%s
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="stud_sem">Current Sem:</label>
	<div class="col-lg-3 col-sm-3">
		<select class="form-control ajax-control" id="stud_sem" name="stud_sem" size="1" data-val="{$this->stud_sem}">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group {$class['stud_div']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_div">Division:</label>
	<div class="col-lg-1 col-sm-2">
		<input class="form-control" type="text" name="stud_div" id="stud_div" maxlength="%d" value="{$this->stud_div}" placeholder="E.g. A"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_div']}</div>
</div>
<div class="form-group {$class['stud_batchno']}">
	<label class="col-lg-3 col-sm-3 control-label" for="stud_batchno">Batch No.:</label>
	<div class="col-lg-1 col-sm-2">
		<input class="form-control" type="text" name="stud_batchno" id="stud_batchno" maxlength="%d" value="{$this->stud_batchno}" placeholder="E.g. 1"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block">{$guide['stud_batchno']}</div>
</div>
<div class="form-group">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="stud_status">Student Status:</label>
	<div class="col-lg-2 col-sm-3">
		<select class="form-control" id="stud_status" name="stud_status" size="1">
			<option value="A" {$stud_status['A']}>Alumni</option>
			<option value="C" {$stud_status['C']}>Continue</option>
			<option value="D" {$stud_status['D']}>Detain</option>
			<option value="L" {$stud_status['L']}>Left</option>
		</select>
	</div>
</div>
EOF;
return sprintf($form,$nm::STUD_ENROLL_MAXLENGTH,$nm::STUD_ROLL_MAXLENGTH,$nm::STUD_NAME_MAXLENGTH,$nm::STUD_NAME_MAXLENGTH,$nm::STUD_NAME_MAXLENGTH,$nm::STUD_MAIL_MAXLENGTH,$nm::STUD_MOB_MAXLENGTH,$nm::STUD_MOB_MAXLENGTH,$nm::STUD_ADDR_MAXLENGTH,$nm::STUD_NAME_MAXLENGTH,require_once("o_id.select.php"),$nm::STUD_DIV_MAXLENGTH,$nm::STUD_BATCH_MAXLENGTH);
?>