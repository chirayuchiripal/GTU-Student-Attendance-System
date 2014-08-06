<?php
class Lectures extends Attendance_Master
{	// Class Properties
	protected $lec_id=NULL;
	protected $lec_date=NULL;
	protected $attd_mst_id=NULL;
	// Class Constants
	
	const HEADING='Lecture';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=parent::set_assoc_array($arr,$id_present);
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['lec_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['lec_id']) && ctype_digit($arr['lec_id']))
			$this->lec_id=$arr['lec_id'];
		// Validation
		if(isset($arr['lec_date']) && !empty($arr['lec_date']))
		{	try
			{	$st=new DateTime($arr['lec_date']);
				$this->lec_date=$st->format("Y-m-d");
				$suc['lec_date']=true;
			}
			catch(Exception $e)
			{	
			}
		}
		if(isset($arr['attd_mst_id']) && ctype_digit($arr['attd_mst_id']))
		{	$this->attd_mst_id=$arr['attd_mst_id'];
			$suc['attd_mst_id']=true;
		}
		return $suc;
	}
}
?>