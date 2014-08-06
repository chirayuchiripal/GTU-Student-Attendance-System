<?php
class Academic_Calendar extends Master
{	// Class Properties
	protected $ac_id=NULL;
	protected $start_date=NULL;
	protected $end_date=NULL;
	protected $prog_id=NULL;
	protected $semester=NULL;
	// Class Constants
	const HEADING='Academic Calendar';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['ac_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['ac_id']))
			$this->ac_id = intval($arr['ac_id']);
		// Validation
		// Start Date Validation
		if(isset($arr['start_date']) && !empty($arr['start_date']))
		{	if(strcmp($arr['start_date'],"NOW()")==0)
				$arr['start_date']="";
			try
			{	$st=new DateTime($arr['start_date']);
				$this->start_date=$st->format("Y-m-d");
				$suc['start_date']=true;
			}
			catch(Exception $e)
			{	
			}
		}
		// End Date Validation
		if(isset($arr['end_date']) && !empty($arr['end_date']))
		{	if(strcmp($arr['end_date'],"NOW()")==0)
				$arr['end_date']="";
			try
			{	$en=new DateTime($arr['end_date']);
				$this->end_date=$en->format("Y-m-d");
				$suc['end_date']=true;
				if(isset($st))
				{	$interval=$st->diff($en);
					if($interval->invert)
					{	$suc['start_date']=false;
						$suc['end_date']=false;
						$this->start_date=NULL;
						$this->end_date=NULL;
					}
				}
			}
			catch(Exception $e)
			{	
			}
		}
		// Prog_id Validation
		$regex='/^[\d]+$/';
		if(isset($arr['prog_id']) && preg_match($regex,$arr['prog_id']))
		{	$this->prog_id=intval($arr['prog_id']);
			$suc['prog_id']=true;
		}
		// Semester Validation
		if(isset($arr['semester']))
		{	$this->semester=intval($arr['semester']);
			$suc['semester']=true;
		}
		return $suc;
	}
}
/*$abc = new Academic_Calendar;
$arr=array();
$abc->set_assoc_array($arr);*/
?>