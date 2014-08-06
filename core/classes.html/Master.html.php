<?php
/***********************
This Document Contains HTML of Class.
***********************/
$html=<<<EOF
<div id="final-msg-box"></div>
<form class="form-horizontal" action="" method="post" name="{$_GET['master']}_{$_GET['act']}" id="addForm" enctype="multipart/form-data">
	%s
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-2 col-sm-offset-3 col-sm-3">
		<small>%s</small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-12 col-lg-offset-3 col-lg-5 col-sm-offset-3 col-sm-7">
		<button id="submit_btn" type="submit" data-loading-text="Adding..." class="btn btn-warning btn-ams">%s %s</button>
		<button id="reset_btn" type="reset" class="btn btn-primary btn-ams">Reset</button>
		</div>
	</div>
</form>
EOF;
return sprintf($html,$this->getHtmlForm($suc),IForm::TOC,ucfirst($_GET['act']),$_GET['master']::HEADING);
?>
