<?php
$dir="../../../";
require_once $dir."core/post_pages_head.php";
require_once "core.lib.php";
function report_error($msg)
{	echo $msg." Please Go Back and try again!!";
	exit();
}
if('POST' == $_SERVER['REQUEST_METHOD'])
{	$report_formats=array(
		"pdf","csv","html"
	);
	
	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		report_error(HTTP_Status::UNAUTHORIZED_MSG);
	$right=get_rights("reports");
	if(intval($right)!=1)
		report_error(HTTP_Status::FORBIDDEN_MSG);
	if(empty($_POST['o_id']) || !ctype_digit($_POST['o_id']) ||
	   empty($_POST['sub_offered_sem']) || !ctype_digit($_POST['sub_offered_sem']) ||
	   empty($_POST['ac_id']) || !ctype_digit($_POST['ac_id']) ||
	   !isset($_POST['type']) || !ctype_digit($_POST['type']) || intval($_POST['type'])<0 || intval($_POST['type'])>2 ||
	   empty($_POST['report_format']) || !in_array($_POST['report_format'],$report_formats) ||
	   empty($_POST['ltgt']) || empty($_POST['sub_filter'])
	  )
	{	report_error(HTTP_Status::BAD_REQUEST_MSG." Please Fill all mandatory fields!!");
	}
	$_POST['title'] = empty($_POST['title']) ? "" : $_POST['title'];
	$_POST['batchno'] = empty($_POST['batchno']) ? null : $_POST['batchno'];
	$_POST['division'] = empty($_POST['division']) ? "" : $_POST['division'];
	$_POST['percentage'] = empty($_POST['percentage']) ? null : floatval($_POST['percentage']);
	if(strcmp($_POST['ltgt'],"lt")==0)
		$_POST['ltgt'] = "<";
	else if(strcmp($_POST['ltgt'],"gt")==0)
		$_POST['ltgt'] = ">";
	else
		$_POST['ltgt'] = null;
	$_POST['sub_id'] = !isset($_POST['sub_id']) || !is_array($_POST['sub_id']) ? array() : $_POST['sub_id'];
	//var_dump($_POST);
	if(strcmp($_POST['report_format'],"pdf")==0 && generatePDFReport($data,$_POST['title'],$_POST['o_id'],$_POST['sub_offered_sem'],$_POST['ac_id'],$_POST['division'],$_POST['sub_id'],$_POST['type'],$_POST['batchno'],$_POST['ltgt'],$_POST['percentage'],$_POST['sub_filter']));
	else if(strcmp($_POST['report_format'],"html")==0 && generateHTMLReport($data,$_POST['title'],$_POST['o_id'],$_POST['sub_offered_sem'],$_POST['ac_id'],$_POST['division'],$_POST['sub_id'],$_POST['type'],$_POST['batchno'],$_POST['ltgt'],$_POST['percentage'],$_POST['sub_filter']))
	{	$html=<<<EOF
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<TITLE>Report - {$_POST['title']}</TITLE>
		<LINK href="{$dir}include/bootstrap.min.css" media="screen" type="text/css" rel="stylesheet">
		<LINK rel="stylesheet" href="{$dir}include/report_print.css" type="text/css" media="print"/>
		<LINK rel="stylesheet" href="{$dir}include/report_screen.css" type="text/css" media="screen"/>
		<LINK href="{$dir}include/main.css" media="screen" type="text/css" rel="stylesheet">
		<script src="{$dir}include/js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="{$dir}include/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="{$dir}include/my_js/report_edit.js" type="text/javascript"></script>
		<style media="screen" type="text/css">
			body{
				padding-top:0px;
				background:#fff;
			}
		</style>
	</HEAD>
	<BODY>
		{$data}
		<center><input type="button" onClick="window.print()" class="btn btn-primary no-print prn-btn" value="Print This Page"/></center>
	</BODY>
</HTML>
EOF;
		echo $html;
	}
	else if(strcmp($_POST['report_format'],"csv")==0 && generateCSVReport($data,$_POST['title'],$_POST['o_id'],$_POST['sub_offered_sem'],$_POST['ac_id'],$_POST['division'],$_POST['sub_id'],$_POST['type'],$_POST['batchno'],$_POST['ltgt'],$_POST['percentage'],$_POST['sub_filter']));
	else
	{	report_error(nl2br("\nStatus: ".$data['code']."\nMessage: ".(isset($data['message'])?$data['message']:HTTP_Status::getMessage($data['code']))));
	}
}
else
{	report_error(HTTP_Status::BAD_REQUEST_MSG);
}
?>