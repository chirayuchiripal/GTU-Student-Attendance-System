<?php
class Faculty_Master extends Master
{	// Class Properties
	protected $faculty_id=NULL;
	protected $faculty_name=NULL;
	protected $faculty_father_name=NULL;
	protected $faculty_surname=NULL;
	protected $faculty_designation=NULL;
	protected $faculty_mail_id=NULL;
	protected $faculty_mobile=NULL;
	protected $faculty_address=NULL;
	protected $faculty_status=1;
	protected $faculty_joining_date=NULL;
	protected $o_id=NULL;
	// Class Constants
	const FAC_NAME_MAXLENGTH=30;
	const FAC_NAME_MINLENGTH=3;
	const FAC_DESG_MAXLENGTH=30;
	const FAC_DESG_MINLENGTH=2;
	const FAC_MAIL_MAXLENGTH=50;
	const FAC_MOB_MAXLENGTH=10;
	const FAC_ADDR_MAXLENGTH=100;
	const HEADING='Faculty';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['faculty_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['faculty_id']))
			$this->faculty_id =intval($arr['faculty_id']);
		// Validation Pending
		if(isset($arr['faculty_name']) && !empty($arr['faculty_name']))
		{	$this->faculty_name=ucfirst(strtolower($arr['faculty_name']));
			$suc['faculty_name']=true;
		}
		if(isset($arr['faculty_father_name']) && !empty($arr['faculty_father_name']))
		{	$this->faculty_father_name=ucfirst(strtolower($arr['faculty_father_name']));
		}
		$suc['faculty_father_name']=true;
		if(isset($arr['faculty_surname']) && !empty($arr['faculty_surname']))
		{	$this->faculty_surname=ucfirst(strtolower($arr['faculty_surname']));
		}
		$suc['faculty_surname']=true;
		if(isset($arr['faculty_designation']) && !empty($arr['faculty_designation']))
		{	$this->faculty_designation=ucfirst(strtolower($arr['faculty_designation']));
			$suc['faculty_designation']=true;
		}
		if(isset($arr['faculty_mail_id']) && !empty($arr['faculty_mail_id']))
		{	$this->faculty_mail_id=$arr['faculty_mail_id'];
		}
		$suc['faculty_mail_id']=true;
		if(isset($arr['faculty_mobile']) && !empty($arr['faculty_mobile']))
		{	$this->faculty_mobile=$arr['faculty_mobile'];
			$suc['faculty_mobile']=true;
		}
		if(isset($arr['faculty_address']) && !empty($arr['faculty_address']))
		{	$this->faculty_address=$arr['faculty_address'];
		}
		$suc['faculty_address']=true;
		$suc['faculty_status']=true;
		if(isset($arr['faculty_status']) && intval($arr['faculty_status'])===0)
		{	$this->faculty_status=0;
		}
		if(isset($arr['faculty_joining_date']) && !empty($arr['faculty_joining_date']))
		{	try
			{	$st=new DateTime($arr['faculty_joining_date']);
				$this->faculty_joining_date=$st->format("Y-m-d");
				
			}
			catch(Exception $e)
			{	
			}
		}
		$suc['faculty_joining_date']=true;
		if(isset($arr['o_id']) && ctype_digit($arr['o_id']))
		{	$this->o_id=$arr['o_id'];
			$suc['o_id']=true;
		}
		return $suc;
	}
}
?>