<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.
if(!isset($suc['sub_code']) || $suc['sub_code'])
	$guide['sub_code']="Enter Subject Code as per GTU.";
else
	$guide['sub_code']="Enter Subject Code as per GTU.";
if(!isset($suc['sub_name']) || $suc['sub_name'])
	$guide['sub_name']="Enter Subject Name.";
else
	$guide['sub_name']="Enter Subject Name.";
//$guide['sub_type']="Regular or Elective Subject.";
//$guide['sub_status']="Active or Deactive Subject.";
?>