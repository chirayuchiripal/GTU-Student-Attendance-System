<?php
	$dir="../";
	$title="Welcome";
	require_once $dir."dashboard/includes/dash_header.php";
?>
<div id="content" class="container white-gradient">
<?php	
		if(isset($_GET['act']) && isset($_GET['master']) && in_array($_GET['act'],$menu_sub_items) && in_array($_GET['master'],$menu_items))
		{	require_once $dir."core/modules/".$_GET['act']."/index.php";
		}
		else
		{	require_once $dir."dashboard/home.php";
		}
?>
</div>
<?php	
	$footer=1;
	require_once $dir."core/footer.php";
?>