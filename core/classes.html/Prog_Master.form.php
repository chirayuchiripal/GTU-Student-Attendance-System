<?php
$form = <<<EOF
<div class="form-group {$class['prog_name']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="prog_name">Programme Name:</label>
	<div class="col-lg-4 col-sm-4">
	<input class="form-control" type="text" name="prog_name" id="prog_name" maxlength="%d" value="{$this->prog_name}" placeholder="E.g. Bachelor of Engineering"/>
	</div>
	<div class="col-lg-4 col-sm-5 help-block">{$guide['prog_name']}</div>
</div>
<div class="form-group {$class['prog_short_name']}">
	<label for="prog_short_name" class="col-lg-3 col-sm-3 control-label">Programme Abbreviation:</label>
	<div class="col-lg-2 col-sm-3">
	<input class="form-control" type="text" name="prog_short_name" id="prog_short_name" maxlength="%d" value="{$this->prog_short_name}" placeholder="E.g. BE"/>
	</div>
	<div class="col-lg-4 col-sm-6 help-block">{$guide['prog_short_name']}</div>
</div>
<div class="form-group {$class['no_of_sem']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="no_of_sem">No. of Sem:</label>
	<div class="col-lg-1 col-sm-2">
	<input class="form-control" type="text" name="no_of_sem" id="no_of_sem" maxlength="%d" value="{$this->no_of_sem}" placeholder="E.g. 8"/>
	</div>
	<div class="col-lg-4 col-sm-7 help-block">{$guide['no_of_sem']}</div>
</div>
EOF;
return sprintf($form,$nm::PROG_NAME_MAXLENGTH,$nm::PROG_SNAME_MAXLENGTH,$nm::PROG_SEM_MAXLENGTH);
?>