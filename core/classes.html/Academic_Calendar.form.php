<?php
global $dir;
$st_date=new DateTime($this->start_date);
$en_date=new DateTime($this->end_date);
$start="";
$end="";
if($this->start_date)
{	$start=$st_date->format("d-m-Y");
	$guide['start_date']=$st_date->format("j F Y");
}
if($this->end_date)
{	$end=$en_date->format("d-m-Y");
	$guide['end_date']=$en_date->format("j F Y");
}
$form = <<<EOF
<div class="form-group {$class['start_date']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="start_date">From(dd-mm-yy):</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control date-control" type="text" id="start_date" name="start_date" value="{$start}" placeholder="{$st_date->format("d-m-Y")}"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block" id="altfrom">{$guide['start_date']}</div>
</div>
<div class="form-group {$class['end_date']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="end_date">To(dd-mm-yy):</label>
	<div class="col-lg-3 col-sm-4">
		<input class="form-control date-control" type="text" id="end_date" name="end_date" value="{$end}" placeholder="{$en_date->format("d-m-Y")}"/>
	</div>
	<div class="col-lg-6 col-sm-5 help-block" id="altto">{$guide['end_date']}</div>
</div>
<div class="form-group {$class['prog_id']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="prog_id">Programme:</label>
	<div class="col-lg-4 col-sm-5">
		<select class="form-control ajax-control" id="prog_id" name="prog_id" data-val="{$this->prog_id}">
			<option value=""></option>
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
	<div class="col-lg-5 col-sm-4 help-block" id="altfrom">{$guide['prog_id']}</div>
</div>
<div class="form-group {$class['semester']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="semester">Semester:</label>
	<div class="col-lg-3 col-sm-3">
		<select class="form-control ajax-control" id="semester" name="semester" data-val="{$this->semester}">
			<option value=""></option>
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
	<div class="col-lg-6 col-sm-6 help-block" id="altfrom">{$guide['semester']}</div>
</div>
EOF;
return sprintf($form);
?>