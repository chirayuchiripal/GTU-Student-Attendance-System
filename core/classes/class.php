<?php
class Clas extends Master
{	// Class Properties
	
	// Class Constants
	
	const HEADING='';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc[]=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr[]))
			$this-> =intval($arr[]);
		// Validation
		
		return $suc;
	}
}
?>