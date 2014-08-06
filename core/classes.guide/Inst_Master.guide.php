<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.
if(!isset($suc['inst_name']) || $suc['inst_name'])
	$guide['inst_name']="Enter Institute Name.";
else
	$guide['inst_name']="Please Enter Valid Institute Name!!";
if(!isset($suc['inst_code']) || $suc['inst_code'])
	$guide['inst_code']="Enter Institute Code as per GTU.";
else
	$guide['inst_code']="Please Enter Institute Code!!";
if(!isset($suc['inst_estb_year']) || $suc['inst_estb_year'])
	$guide['inst_estb_year']="Select Institute Establsihed Year.";
else
	$guide['inst_estb_year']="Select Institute Establsihed Year.";
?>