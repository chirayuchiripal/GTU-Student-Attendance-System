<?php
global $dir;
require_once "{$dir}core/ui-widgets/selectableItemsBox.php";
$inst_list=selectableItemsBox("Select Institute(s)","col-lg-4","inst_list");
$prog_list=selectableItemsBox("Select Programme(s)","col-lg-4","prog_list");
$dept_list=selectableItemsBox("Select Department(s)","col-lg-4","dept_list");
$linked=selectableItemsBox("Institute X Programme X Department Mapping","col-lg-12","mapped_ipd");
$html=<<<EOF
<div class="container">
	{$inst_list}
	{$prog_list}
	{$dept_list}
</div>
<div class="col-lg-12 text-center btm-divider">
	<button class="btn btn-success" id="link_btn" data-loading-text="Adding..">Map Selected</button>
</div>
<div>
	{$linked}
	<div class="col-lg-12 text-center">
	<button class="btn btn-warning" id="submit_btn">Add All</button>
	<button class="btn btn-primary" id="remove_ipd_btn">Remove Selected</button>
	</div>
</div>
<div id="forms"></div>
EOF;
return sprintf($html);
?>