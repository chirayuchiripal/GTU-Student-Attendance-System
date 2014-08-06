<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.
if(!isset($suc['dept_name']) || $suc['dept_name'])
	$guide['dept_name']="Enter department name.";
else
	$guide['dept_name']="Please enter valid department name.";
if(!isset($suc['dept_code']) || $suc['dept_code'])
	$guide['dept_code']="Enter department code.";
else
	$guide['dept_code']="Please enter valid department code.";
?>