<?php
class Attendance extends Lectures
{	// Class Properties
	protected $lec_id=NULL;
	protected $stud_id=NULL;
	protected $presence=0;
	// Class Constants
	
	const HEADING='Attendance';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=parent::set_assoc_array($arr,$id_present);
		foreach($this as $key=>$val)
			$suc[$key]=false;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Validation
		if(isset($arr['lec_id']) && ctype_digit($arr['lec_id']))
		{	$this->lec_id=$arr['lec_id'];
			$suc['lec_id']=true;
		}
		if(isset($arr['stud_id']) && ctype_digit($arr['stud_id']))
		{	$this->stud_id=$arr['stud_id'];
			$suc['stud_id']=true;
		}
		$suc['presence']=true;
		if(isset($arr['presence']) && intval($arr['presence'])==1)
		{	$this->presence=1;
		}
		return $suc;
	}
}
?>