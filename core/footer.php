<?php 	if(!isset($footer))
		die("Request Failed!!");
?>
<?php
$css_post_includes[]="main";
$css_post_includes[]="navbar";
$css_post_includes[]="form";
if(isset($css_post_includes))
{	foreach($css_post_includes as $inc)
	{	echo "\n\t<link href=\"".$dir."include/".$inc.".css\" type=\"text/css\" rel=\"stylesheet\">";
	}
}
?>

	<link href="<?php echo $dir; ?>include/print.css" media="print" type="text/css" rel="stylesheet">
	<script src="<?php echo $dir; ?>include/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<?php
if(isset($js_pre_includes))
{	foreach($js_pre_includes as $inc)
	{	echo "<script src=\"".$dir."include/js/".$inc.".js\" type=\"text/javascript\"></script>\n\t";
	}
}
?>
<script src="<?php echo $dir; ?>include/js/bootstrap.min.js" type="text/javascript"></script>
<?php
if(isset($js_includes))
{	foreach($js_includes as $inc)
	{	echo "<script src=\"".$dir."include/js/".$inc.".js\" type=\"text/javascript\"></script>\n\t";
	}
}
if(isset($myjs_includes))
{	foreach($myjs_includes as $inc)
	{	echo "<script src=\"".$dir."include/my_js/".$inc.".js\" type=\"text/javascript\"></script>\n\t";
	}
}
?>
</div>
</body>
</html>