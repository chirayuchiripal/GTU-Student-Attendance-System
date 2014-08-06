<?php
class Prog_Master extends Master
{	// Class Properties
	protected $prog_id=NULL;
	protected $prog_name=NULL;
	protected $no_of_sem=NULL;
	protected $prog_short_name=NULL;
	// Class Constants
	const PROG_NAME_MINLENGTH=2;
	const PROG_NAME_MAXLENGTH=50;
	const PROG_SNAME_MAXLENGTH=15;
	const PROG_SEM_MAXLENGTH=2;
	const PROG_SEM_MAX=15;
	const PROG_SEM_MIN=1;
	const HEADING='Programme';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['prog_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present True?
		if($id_present && isset($arr['prog_id']))
			$this->prog_id=intval($arr['prog_id']);
		// Validation
		// Programme Name Validation
		$regex='/^[a-zA-Z0-9\-\.\s,&]{'.self::PROG_NAME_MINLENGTH.','.self::PROG_NAME_MAXLENGTH.'}$/';
		if(isset($arr['prog_name']) && preg_match($regex, $arr['prog_name']))
		{	$this->prog_name=ucfirst(strtolower($arr['prog_name']));
			$suc['prog_name']=true;
		}
		// Programme Short Name Validation
		if(isset($arr['prog_short_name']) && !empty($arr['prog_short_name']) && strlen($arr['prog_short_name'])<=self::PROG_SNAME_MAXLENGTH)
		{	$this->prog_short_name=strtoupper($arr['prog_short_name']);
		}
		$suc['prog_short_name']=true;
		// No of Semester Validation
		if(isset($arr['no_of_sem']) && intval($arr['no_of_sem'])>=self::PROG_SEM_MIN && intval($arr['no_of_sem'])<=self::PROG_SEM_MAX)
		{	$this->no_of_sem=intval($arr['no_of_sem']);
			$suc['no_of_sem']=true;
		}
		return $suc;
	}
}
/*$abc=new Prog_Master;
$arr['prog_name']="      aas d&.-    ";
$arr['prog_short_name']="    abc32     ";
$arr['no_of_sem']="  8  ";
$arr['prog_id']=5;
var_dump($abc->set_assoc_array($arr,true));
var_dump($abc);*/
?>