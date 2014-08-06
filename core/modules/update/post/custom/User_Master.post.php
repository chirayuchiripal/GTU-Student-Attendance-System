<?php
// Check not accessed directly.
if(!isset($post_update))
{	echo "Are you searching for something? You maybe in wrong place then!!";
	return;
}
$dontUpdateIds=false;
require_once "./common.php";
?>