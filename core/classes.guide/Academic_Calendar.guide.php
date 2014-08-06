<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.

if(!isset($suc['start_date']) || $suc['start_date'])
	$guide['start_date']="Enter date in dd-mm-yy format";
else
	$guide['start_date']="Please enter valid date in dd-mm-yy format";
if(!isset($suc['end_date']) || $suc['end_date'])
	$guide['end_date']="Enter date in dd-mm-yy format";
else
	$guide['end_date']="Please enter valid date in dd-mm-yy format";
$guide['prog_id']="Select the programme";
$guide['semester']="Select the semester";
?>