<?php
global $dir;
$form = <<<EOF
%s
<div class="form-group {$class['batchno']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="batchno">Batch No:</label>
	<div class="col-lg-2 col-sm-3">
	<input class="form-control" type="text" name="batchno" id="batchno" maxlength="%d" value="{$this->batchno}" placeholder="E.g. 1"/>
	</div>
	<span class="col-lg-4 col-sm-6 help-block">{$guide['batchno']}</span>
</div>
<div class="form-group {$class['division']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="division">Division:</label>
	<div class="col-lg-2 col-sm-3">
	<input class="form-control" type="text" name="division" id="division" maxlength="%d" value="{$this->division}" placeholder="E.g. A"/>
	</div>
	<span class="col-lg-4 col-sm-6 help-block">{$guide['division']}</span>
</div>
<div class="form-group {$class['ac_id']}">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="ac_id">Academic Calendar:</label>
	<div class="col-lg-4 col-sm-6">
		<select class="form-control ajax-control" id="ac_id" name="ac_id" size="1" data-val="{$this->ac_id}">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
EOF;
return sprintf($form,require_once("Teaches.select.php"),$nm::BATCHNO_MAXLENGTH,$nm::DIVISION_MAXLENGTH);
?>