<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.
if(!isset($suc['faculty_name']) || $suc['faculty_name'])
	$guide['faculty_name']="Enter First Name.";
else
	$guide['faculty_name']="Please enter First Name.";
if(!isset($suc['faculty_father_name']) || $suc['faculty_father_name'])
	$guide['faculty_father_name']="Enter name of the father.";
else
	$guide['faculty_father_name']="Please enter name of the father.";
if(!isset($suc['faculty_surname']) || $suc['faculty_surname'])
	$guide['faculty_surname']="Enter Surname of the faculty.";
else
	$guide['faculty_surname']="Please enter Surname of the faculty.";
if(!isset($suc['faculty_designation']) || $suc['faculty_designation'])
	$guide['faculty_designation']="Enter Designation of the faculty.";
else
	$guide['faculty_designation']="Please enter Designation of the faculty.";
if(!isset($suc['faculty_mail_id']) || $suc['faculty_mail_id'])
	$guide['faculty_mail_id']="Enter E-mail address.";
else
	$guide['faculty_mail_id']="Please enter valid email address.";
if(!isset($suc['faculty_mobile']) || $suc['faculty_mobile'])
	$guide['faculty_mobile']="Enter 10 digit Mobile Number.";
else
	$guide['faculty_mobile']="Please enter valid 10 digit mobile number.";
$guide['faculty_address']="Enter Permanent Address.";
if(!isset($suc['faculty_joining_date']) || $suc['faculty_joining_date'])
	$guide['faculty_joining_date']="Select joining date of the faculty.";
else
	$guide['faculty_joining_date']="Please select valid date.";
?>