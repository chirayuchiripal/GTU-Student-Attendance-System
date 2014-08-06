<?php	
if(!isset($title) || !isset($dir))
{	die("Request Failed!!");
}
require_once $dir.'core/class_autoloader.php';

?>
<!doctype HTML>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo $dir; ?>images/favicon.ico"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $dir; ?>images/favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php	
			if(isset($css_pre_includes))
			{	foreach($css_pre_includes as $inc)
				{	echo "<link href=\"".$dir."include/".$inc.".css\" type=\"text/css\" rel=\"stylesheet\">\n\t";
				}
			}
	?>
<link href="<?php echo $dir; ?>include/bootstrap.min.css" type="text/css" rel="stylesheet">
	<?php	if(isset($css_includes))
			{	foreach($css_includes as $inc)
				{	echo "<link href=\"".$dir."include/".$inc.".css\" type=\"text/css\" rel=\"stylesheet\">\n\t";
				}
			}
	?>
<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="<?php echo $dir; ?>include/js/html5shiv.js"></script>
  <script src="<?php echo $dir; ?>include/js/respond.min.js"></script>
<![endif]-->
<script src="<?php echo $dir; ?>include/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php echo $dir; ?>include/js/ChunkFive_400.font.js" type="text/javascript"></script>
	<script type="text/javascript">
			Cufon.replace('h1', {textShadow: '1px 1px #000000'});
			Cufon.replace('h2', {textShadow: '1px 1px #000000'});
	</script>
</head>	
<body>
<div class="navbar navbar-fixed-top my-nav purple-gradient">
  <div class="container">
	<div class="navbar-header">
    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
	<a href="<?php echo $dir?>" class="navbar-brand"><span class="glyphicon glyphicon-home"></span>&nbsp;SAL Attendance System</a>
	</div>
    <div class="navbar-collapse collapse bs-navbar-collapse">
    <?php 	
		require_once $dir."core/menu.php";
	?>
    </div>
  </div>
</div>
<div class="container">
