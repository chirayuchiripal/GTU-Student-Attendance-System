<?php
$opt="";
for($i=$nm::INST_ESTB_YEAR_MIN;$i<=intval(date('Y'));$i++)
{	$opt.= "\n<option value=\"".$i."\"";
	if($i==$this->inst_estb_year)
		$opt.= " selected";
		$opt.= ">".$i."</option>";
}
$form = <<<EOF
	<div class="form-group {$class['inst_name']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="inst_name">Institute Name:</label>
		<div class="col-lg-5 col-sm-5">
		<input class="form-control" type="text" name="inst_name" id="inst_name" maxlength="%d" value="{$this->inst_name}" placeholder="E.g. Sal Institute of Technology & Engineering Research"/>
		</div>
		<div class="col-lg-4 col-sm-4 help-block">{$guide['inst_name']}</div>
	</div>
	<div class="form-group {$class['inst_code']}">
		<label class="mandatory col-lg-3 col-sm-3 control-label" for="inst_code">Institute Code:</label>
		<div class="col-lg-2 col-sm-3">
		<input class="form-control" type="text" name="inst_code" id="inst_code" maxlength="%d" value="{$this->inst_code}" placeholder="E.g. 067"/>
		</div>
		<span class="col-lg-4 col-sm-6 help-block">{$guide['inst_code']}</span>
	</div>
	<div class="form-group {$class['inst_estb_year']}">
		<label for="inst_estb_year" class="col-lg-3 col-sm-3 control-label">Institute Established Year:</label>
		<div class="col-lg-2 col-sm-3">
		<select class="form-control" id="inst_estb_year" name="inst_estb_year" size="1">
			<option value=""></option>
			{$opt}
		</select>
		</div>
		<div class="col-lg-4 col-sm-6 help-block">{$guide['inst_estb_year']}</div>
	</div>
EOF;
return sprintf($form,$nm::INST_NAME_MAXLENGTH,$nm::INST_CODE_MAXLENGTH);
?>