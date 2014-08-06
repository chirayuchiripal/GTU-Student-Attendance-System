<?php
	$dir="../../";
    $acts=array(
        "view" => "View",
        "add" => "Add"
    );
    if(!isset($_GET['act'],$acts[$_GET['act']]))
        $_GET['act']="add";
    $title=$acts[$_GET['act']]." Attendance";
	require_once $dir."dashboard/includes/dash_header.php";
?>
<?php
	$css_post_includes[]="theme.bootstrap";
	$css_post_includes[]="jquery.tablesorter.pager";
	$css_post_includes[]="viewtable";
	$js_includes[]="jquery.tablesorter";
	$js_includes[]="jquery.tablesorter.widgets";
	$js_includes[]="jquery.tablesorter.pager";
	$js_includes[]="widgets/widget-columnSelector";
	$myjs_includes[]="filtertable_defaults";
	$myjs_includes[]="datepicker_defaults";
	$myjs_includes[]="ajax/view_table";
    $myjs_includes[]="ajax/form";
    $myjs_includes[]="url_var";
	if(empty($_GET['mst']))
	{	$myjs_includes[]="ajax/Attendance";
	}
	else
	{	$css_post_includes[]="attendance";
        if(strcmp($_GET['act'],"add")==0)
        {   $myjs_includes[]="ajax/getStudents";
            $myjs_includes[]="ajax/addAttd";
        }
        else if(strcmp($_GET['act'],"view")==0)
        {   $myjs_includes[]="ajax/viewAttd";
            $myjs_includes[]="ajax/viewAttd_studwise";
            $myjs_includes[]="ajax/viewAttd_lecwise";
            $myjs_includes[]="ajax/updateAttd";
        }
	}
?>
<div id="content" class="container white-gradient">
<h1 class="form_heading purple-gradient">
<?php
	echo $acts[$_GET['act']]." Attendance";
?>
</h1>
<script>
var getUrl="../../core/modules/attendance/mst/";
</script>
<?php 
if(!empty($_GET['mst']))
{
?>
	<script>
	var	calendar_base_url="../../";
	</script>
    <div id="final-msg-box"></div>
<?php
    if(strcmp($_GET['act'],"add")==0)
    {   $spec_field['date']=true;
    }
    else if(strcmp($_GET['act'],"view")==0)
    {   $spec_field['radio_2']=true;
        $spec_field['radio_2_id']="view_type";
        $spec_field['radio_2_label']="Lecture/Student wise";
        $spec_field['radio_2_1']="Student wise";
        $spec_field['radio_2_2']="Lecture wise";
    }
    include $dir."dashboard/attendance/widgets/lecture_summary.php";
}
?>
<!-- Show/Hide Columns Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Show/Hide Columns</h4>
			</div>
			<div class="modal-body">
				<div class="columnSelectorWrapper" id="columnSelectorDiv">
					
					<table id="columnSelector" class="table table-striped columnSelector">
						<thead>
							<tr><th><label for="SelectAllColumns" class="select-none">Select All</label></th><th><input type="checkbox" id="SelectAllColumns"></th></tr>
						</thead>
						<tbody>
						<!-- this is where the column selector is added -->
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="table-responsive" id="view_table">
	<table class="tablesorter">
	<thead>
		<tr>
		</tr>
	</thead>
	<tfoot>
		<tr class="ams-perma ams-pager-row">
			<th class="ts-pager form-horizontal" colspan="0">
				<button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
				<button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
				<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
				<button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
				<button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
				<input type="text" class="pagesize input-mini" title="# of records/page" size="3" />
				<select class="pagenum input-mini" title="Select page number"></select>
				<button class="btn" data-toggle="modal" data-target="#myModal">Show/Hide Columns</button>
				<button type="button" class="reset btn" data-column="0" data-filter=""><i class="icon-white icon-refresh glyphicon glyphicon-refresh"></i> Reset filters</button>
			</th>
		</tr>
	</tfoot>
	<tbody>
	</tbody>
	</table>
</div>
<?php
if(!empty($_GET['mst']) && strcmp($_GET['act'],"add")==0)
{
?>
<div class="form-group" id="submit_btn_div">
	<div class="col-12 col-lg-offset-5 col-lg-5 col-sm-offset-5 col-sm-7">
	<button id="submit_btn" type="button" data-loading-text="Adding..." class="btn btn-warning btn-ams">Add Attendance</button>
	</div>
</div>
<?php
}
?>
</div>
<?php	
	$footer=1;
	require_once $dir."core/footer.php";
?>