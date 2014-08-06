<?php
$form = <<<EOF
<div class="form-group {$class['dept_name']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="dept_name">Department Name:</label>
	<div class="col-lg-4 col-sm-4">
	<input class="form-control" type="text" name="dept_name" id="dept_name" maxlength="%d" value="{$this->dept_name}" placeholder="E.g. Computer Engineering">
	</div>
	<div class="col-lg-4 col-sm-5 help-block">{$guide['dept_name']}</div>
</div>
<div class="form-group {$class['dept_code']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="dept_code">Department Code:</label>
	<div class="col-lg-2 col-sm-2">
	<input class="form-control" type="text" name="dept_code" id="dept_code" maxlength="" value="{$this->dept_code}" placeholder="E.g. 07">
	</div>
	<div class="col-lg-4 col-sm-5 help-block">{$guide['dept_code']}</div>
</div>
EOF;
return sprintf($form,$nm::DEPT_NAME_MAXLENGTH);
?>