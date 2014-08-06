<?php
spl_autoload_register(function ($class){
    global $dir;
	$path=$dir.'core/classes/'.$class.'.class.php';
	if(file_exists($path))
		require_once $path;
});
?>