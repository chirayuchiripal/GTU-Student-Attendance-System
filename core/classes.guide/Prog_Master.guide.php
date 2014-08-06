<?php
// GuideLines shown for each field in forms.
// $guide['field_name']="SOME TEXT";
// Sucess and Error Texts can be separated.
// $suc['field_name'] is set and set to true if successfully validated.
if(!isset($suc['prog_name']) || $suc['prog_name'])
	$guide['prog_name']="E.g. Bachlor of Engineering";
else
	$guide['prog_name']="Please Enter Valid Programme Name!!";
if(!isset($suc['prog_short_name']) || $suc['prog_short_name'])
	$guide['prog_short_name']="E.g. ME, BE, MBA etc.";
if(!isset($suc['no_of_sem']) || $suc['no_of_sem'])
	$guide['no_of_sem']="E.g. 8 for B.E./B.Tech.";
else
	$guide['no_of_sem']=sprintf("Enter a number (%d to %d)",self::PROG_SEM_MIN,self::PROG_SEM_MAX);
?>