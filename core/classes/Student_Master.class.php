<?php
//include_once "Master.class.php";
class Student_Master extends Master
{	// Class Properties
	protected $stud_id=NULL;
	protected $stud_enrolmentno=NULL;
	protected $stud_rollno=NULL;
	protected $stud_name=NULL;
	protected $stud_father_name=NULL;
	protected $stud_surname=NULL;
	protected $stud_mail=NULL;
	protected $stud_contact=NULL;
	protected $stud_parent_contact=NULL;
	protected $stud_address=NULL;
	protected $stud_city=NULL;
	protected $stud_sem=NULL;
	protected $stud_status="C";
	protected $o_id=NULL;
	protected $stud_div="";
	protected $stud_batchno="";
	// Class Constants
	const STUD_NAME_MAXLENGTH=30;
	const STUD_ENROLL_MAXLENGTH=15;
	const STUD_ROLL_MAXLENGTH=10;
	const STUD_NAME_MINLENGTH=3;
	const STUD_MAIL_MAXLENGTH=50;
	const STUD_ADDR_MAXLENGTH=100;
	const STUD_MOB_MAXLENGTH=10;
	const STUD_DIV_MAXLENGTH=1;
	const STUD_BATCH_MAXLENGTH=3;
	const HEADING='Student';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['stud_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['stud_id']))
			$this->stud_id=intval($arr['stud_id']);
		// Validation Pending
		if(isset($arr['stud_enrolmentno']) && !empty($arr['stud_enrolmentno']))
		{	$this->stud_enrolmentno=$arr['stud_enrolmentno'];
			$suc['stud_enrolmentno']=true;
		}
		if(isset($arr['stud_rollno']) && !empty($arr['stud_rollno']))
		{	$this->stud_rollno=$arr['stud_rollno'];
			$suc['stud_rollno']=true;
		}
		if(isset($arr['stud_name']) && !empty($arr['stud_name']))
		{	$this->stud_name=ucfirst(strtolower($arr['stud_name']));
			$suc['stud_name']=true;
		}
		if(isset($arr['stud_father_name']) && !empty($arr['stud_father_name']))
		{	$this->stud_father_name=ucfirst(strtolower($arr['stud_father_name']));
		}
		$suc['stud_father_name']=true;
		if(isset($arr['stud_surname']) && !empty($arr['stud_surname']))
		{	$this->stud_surname=ucfirst(strtolower($arr['stud_surname']));
		}
		$suc['stud_surname']=true;
		if(isset($arr['stud_mail']) && !empty($arr['stud_mail']))
		{	$this->stud_mail=$arr['stud_mail'];
		}
		$suc['stud_mail']=true;
		if(isset($arr['stud_contact']) && !empty($arr['stud_contact']))
		{	$this->stud_contact=$arr['stud_contact'];
		}
		$suc['stud_contact']=true;
		if(isset($arr['stud_parent_contact']) && !empty($arr['stud_parent_contact']))
		{	$this->stud_parent_contact=$arr['stud_parent_contact'];
		}
		$suc['stud_parent_contact']=true;
		if(isset($arr['stud_address']) && !empty($arr['stud_address']))
		{	$this->stud_address=$arr['stud_address'];
		}
		$suc['stud_address']=true;
		if(isset($arr['stud_city']) && !empty($arr['stud_city']))
		{	$this->stud_city=$arr['stud_city'];
		}
		$suc['stud_city']=true;
		if(isset($arr['stud_sem']) && !empty($arr['stud_sem']))
		{	$this->stud_sem=$arr['stud_sem'];
			$suc['stud_sem']=true;
		}
		if(isset($arr['stud_status']) && !empty($arr['stud_status']))
		{	$this->stud_status=$arr['stud_status'];
		}
		$suc['stud_status']=true;
		if(isset($arr['o_id']) && ctype_digit($arr['o_id']))
		{	$this->o_id=$arr['o_id'];
			$suc['o_id']=true;
		}
		if(isset($arr['stud_div']) && !empty($arr['stud_div']))
		{	$this->stud_div=strtoupper($arr['stud_div']);
		}
		$suc['stud_div']=true;
		if(isset($arr['stud_batchno']) && !empty($arr['stud_batchno']))
		{	$this->stud_batchno=intval($arr['stud_batchno']);
		}
		$suc['stud_batchno']=true;
		return $suc;
	}
}
/*$arr['stud_id']=1;
$arr['stud_rollno']=5;
$abc=new Student_Master($arr);
var_dump($abc->get_assoc_array());
*/
?>