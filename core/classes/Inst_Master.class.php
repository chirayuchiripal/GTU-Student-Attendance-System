<?php
class Inst_Master extends Master
{	// Class Properties
	protected $inst_id=NULL;
	protected $inst_name=NULL;
	protected $inst_code=NULL;
	protected $inst_estb_year=NULL;
	// Class Constants
	const INST_ESTB_YEAR_MIN=1900;
	const INST_CODE_MINLENGTH=1;
	const INST_CODE_MAXLENGTH=10;
	const INST_NAME_MINLENGTH=2;
	const INST_NAME_MAXLENGTH=255;
	const HEADING="Institute";
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['inst_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present True?
		if($id_present && isset($arr['inst_id']))
			$this->inst_id=intval($arr['inst_id']);
		// Validation
		// Institute Name Validation
		$regex='/^[a-zA-Z\-\.\s,&]{'.self::INST_NAME_MINLENGTH.','.self::INST_NAME_MAXLENGTH.'}$/';
		if(isset($arr['inst_name']) && preg_match($regex, $arr['inst_name']))
		{	$this->inst_name=ucfirst(strtolower($arr['inst_name']));
			$suc['inst_name']=true;
		}
		// Institute Code Validation
		if(isset($arr['inst_code']) && strlen($arr['inst_code'])>=self::INST_CODE_MINLENGTH && strlen($arr['inst_code'])<=self::INST_CODE_MAXLENGTH)
		{	$this->inst_code=strtoupper($arr['inst_code']);
			$suc['inst_code']=true;
		}
		// Institute Year Validation
		$suc['inst_estb_year']=true;
		if(isset($arr['inst_estb_year']) && intval($arr['inst_estb_year'])>=self::INST_ESTB_YEAR_MIN && intval($arr['inst_estb_year'])<=intval(date('Y')))
		{	$this->inst_estb_year=intval($arr['inst_estb_year']);
		}
		return $suc;
	}
}
/*$abc= new Inst_Master;
$arr['inst_id']=1;
$arr['inst_name']="SAL";
$arr['inst_estb_year']="2013";
var_dump($abc->set_assoc_array($arr,true));
var_dump($abc);*/
?>