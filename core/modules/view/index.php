<?php	
	$right_index=0;
	require_once $dir."core/modules/authenticate.php";
?>
<?php
	$css_post_includes[]="theme.bootstrap";
	$css_post_includes[]="jquery.tablesorter.pager";
	$css_post_includes[]="viewtable";
	$js_includes[]="jquery.tablesorter";
	$js_includes[]="jquery.tablesorter.widgets";
	$js_includes[]="jquery.tablesorter.pager";
	$js_includes[]="widgets/widget-columnSelector";
	$myjs_includes[]="ajax/form";
	$myjs_includes[]="url_var";
	$myjs_includes[]="filtertable_defaults";
	$myjs_includes[]="ajax/view_table";
	$myjs_includes[]="view/{$_GET['master']}.view";
?>
<?php
	//require_once $dir."core/classes/".$_GET['master'].".class.php";
	$obj=new $_GET['master'];
	//var_dump($obj);
	$suc=array();
?>
<h1 class="form_heading purple-gradient">
<?php
	echo $_GET['act']." ".$_GET['master']::HEADING;
?>
</h1>
<script>
var getUrl="../core/modules/view/get/?master=";
</script>
<!-- Show/Hide Columns Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Show/Hide Columns</h4>
			</div>
			<div class="modal-body">
				<div class="columnSelectorWrapper">
					
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
		<tr class="ams-pager-row">
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