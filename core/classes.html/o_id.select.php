<?php
global $dir;

if(empty($inst_id) || empty($prog_id) || empty($dept_id))
{	$inst_id = $prog_id = $dept_id = "";
	if(!empty($this->o_id))
	{	$obj = new Offers_Master;
		$ids = $obj->getIds($this->o_id);
		$inst_id = $ids['inst_id'];
		$prog_id = $ids['prog_id'];
		$dept_id = $ids['dept_id'];
	}
}
else
	$inst_id = $prog_id = $dept_id = "";
$names=array("","","");
if(isset($set_oid_name) && $set_oid_name===true)
	$names=array('name="inst_id"','name="prog_id"','name="dept_id"');
$p=<<<EOF
<div class="form-group {$class['o_id']} o_id_select">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="inst_id">Select Institute:</label>
	<div class="col-lg-5 col-sm-6">
		<select class="form-control ajax-control" {$names[0]} id="inst_id" size="1" data-val="%s">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group {$class['o_id']} o_id_select">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="prog_id">Select Programme:</label>
	<div class="col-lg-4 col-sm-5">
		<select class="form-control ajax-control" {$names[1]} id="prog_id" size="1" data-val="%s">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<div class="form-group {$class['o_id']} o_id_select">
	<label class="mandatory col-lg-3 col-sm-3 control-label" for="dept_id">Select Department:</label>
	<div class="col-lg-4 col-sm-5">
		<select class="form-control ajax-control" {$names[2]} id="dept_id" size="1" data-val="%s">
		</select>
		<img class="ajax_loader" src="{$dir}images/ajax-loader.gif"/>
	</div>
</div>
<input type="text" class="hidden" id="o_id" name="o_id" value=""/>
EOF;
return sprintf($p,$inst_id,$prog_id,$dept_id);
?>