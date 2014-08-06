<?php

$form = <<<EOF
	<div class="modal fade rights-dependency" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<img src="{$dir}images/rights_dependency.png" height="100%%" width="100%%"/>
			</div>
		</div>
	</div>
	<div class="form-group {$class['privilege_name']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="privilege_name">Privilege Level Name:</label>
		<div class="col-lg-3 col-sm-4">
		<input class="form-control" type="text" name="privilege_name" id="privilege_name" maxlength="%d" value="{$this->privilege_name}" placeholder="E.g. Faculty"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block"><a href="#" data-toggle="modal" data-target=".rights-dependency">Click here to view Rights Dependency Chart</a></div>
	</div>
EOF;
$props=$this->get_assoc_array();
unset($props['privilege_id']);
unset($props['privilege_name']);
unset($props['syllabus_access']);
unset($props['teaches_access']);
unset($props['reports']);
$labels=array(
	"faculty_master_access" => "Faculty Master",
	"inst_master_access" => "Institute Master",
	"prog_master_access" => "Programme Master",
	"dept_master_access" => "Department Master",
	"academic_calendar_access" => "Academic Calendar",
	"attendance_master_access" => "Attendance Master",
	"student_master_access" => "Student Master",
	"sub_master_access" => "Subject Master",
	"user_master_access" => "User Master",
	"privilege_master_access" => "Privilege Master",
	"offers_master_access" => "Offers Master"
);
foreach($props as $key=>$val)
{	$val = $this->get_by_key($key);
	$checked = array(
		1 => intval($val[0])==1 ? 'checked="checked"': "",
		2 => intval($val[1])==1 ? 'checked="checked"': "",
		3 => intval($val[2])==1 ? 'checked="checked"': ""
	);
	$form.=<<<EOF
	<div class="form-group {$class[$key]}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="{$key}">{$labels[$key]}:</label>
		<div class="col-lg-3 col-sm-4 ui-radio-3">
			<label for="{$key}_1">Search</label>
			<input type="checkbox" value="0" name="{$key}[]" id="{$key}_1" {$checked[1]}/>
			<label for="{$key}_2">Add</label>
			<input type="checkbox" value="1" name="{$key}[]" id="{$key}_2" {$checked[2]}/>
			<label for="{$key}_3">Update</label>
			<input type="checkbox" value="2" name="{$key}[]" id="{$key}_3" {$checked[3]}/>
		</div>
	</div>
EOF;
}
$checked[2] = intval($this->get_by_key('reports'))==1 ? 'checked="checked"' : "";
$checked[1] = empty($checked[2])? 'checked="checked"' : "";
$form.=<<<EOF
	<div class="form-group {$class['reports']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="reports">Report Generation:</label>
		<div class="col-lg-3 col-sm-4 ui-radio-2">
			<label for="reports_1">Not Allowed</label>
			<input type="radio" value="0" name="reports" id="reports_1" {$checked[1]}/>
			<label for="reports_2">Allowed</label>
			<input type="radio" value="1" name="reports" id="reports_2" {$checked[2]}/>
		</div>
	</div>
EOF;
return sprintf($form,$nm::PRIV_NAME_MAXLENGTH);
?>