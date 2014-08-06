<?php
class Dept_Master extends Master
{	// Class Properties
	protected $dept_id=NULL;
	protected $dept_name=NULL;
	protected $dept_code=NULL;
	// Class Constants
	const DEPT_NAME_MINLENGTH=2;
	const DEPT_CODE_MINLENGTH=1;
	const DEPT_NAME_MAXLENGTH=100;
	const DEPT_CODE_MAXLENGTH=10;
	const HEADING='Department';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['dept_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['dept_id']))
			$this->dept_id=intval($arr['dept_id']);
		// Validation
		// Department Name Validation
		$regex='/^[a-zA-Z0-9\-\.\s,&]{'.self::DEPT_NAME_MINLENGTH.','.self::DEPT_NAME_MAXLENGTH.'}$/';
		if(isset($arr['dept_name']) && preg_match($regex, $arr['dept_name']))
		{	$this->dept_name=ucfirst(strtolower($arr['dept_name']));
			$suc['dept_name']=true;
		}
		// Department Code Validation
		if(isset($arr['dept_code']) && strlen($arr['dept_code'])<=self::DEPT_CODE_MAXLENGTH && strlen($arr['dept_code'])>=self::DEPT_CODE_MINLENGTH)
		{	$this->dept_code=strtoupper($arr['dept_code']);
			$suc['dept_code']=true;
		}
		return $suc;
	}
}
/*$abc=new Dept_Master;
$arr['dept_id']="    5    ";
$arr['dept_name']="  Caaaaaaaaaa    ";
var_dump($abc->set_assoc_array($arr,true));
var_dump($abc);*/
?>