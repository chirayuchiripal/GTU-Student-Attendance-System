<?php
class Sub_Master extends Master
{	// Class Properties
	protected $sub_id=NULL;
	protected $sub_code=NULL;
	protected $sub_name=NULL;
	//protected $sub_type='R'; // Deprecated as of Database 0.3
	protected $sub_status=1;
	// Class Constants
	const SUB_NAME_MINLENGTH=2;
	const SUB_NAME_MAXLENGTH=30;
	const SUB_CODE_MINLENGTH=1;
	const SUB_CODE_MAXLENGTH=10;
	const HEADING='Subject';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['sub_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['sub_id']))
			$this->sub_id =intval($arr['sub_id']);
		// Validation
		// Subject Name Validation
		$regex='/^[a-zA-Z0-9\-\.\s,&]{'.self::SUB_NAME_MINLENGTH.','.self::SUB_NAME_MAXLENGTH.'}$/';
		if(isset($arr['sub_name']) && preg_match($regex, $arr['sub_name']))
		{	$this->sub_name=ucfirst(strtolower($arr['sub_name']));
			$suc['sub_name']=true;
		}
		// Subject Code Validation
		$regex='/^[a-zA-Z0-9\-\.\s]{'.self::SUB_CODE_MINLENGTH.','.self::SUB_CODE_MAXLENGTH.'}$/';
		if(isset($arr['sub_code']) && preg_match($regex, $arr['sub_code']))
		{	$this->sub_code=strtoupper($arr['sub_code']);
			$suc['sub_code']=true;
		}
		// Subject Status Validation
		$suc['sub_status']=true;
		if(isset($arr['sub_status']) && intval($arr['sub_status'])===0)
		{	$this->sub_status=0;
		}
		/*// Subject Type Validation
		$suc['sub_type']=true;
		if(isset($arr['sub_type']) && strtoupper($arr['sub_type'])==="E")
		{	$this->sub_type="E";
		}*/
		return $suc;
	}
	public static function getSubjectName($sub_id)
	{	$dbh=new MyDbCon;
		$dbh->select("Sub_Master");
		$dbh->select->columns(array("sub_name"));
		$dbh->select->where("sub_id={$sub_id}");
		$dbh->prepare();
		if($dbh->execute())
		{	$res=$dbh->fetchAssoc()[0];
			return $res["sub_name"];
		}
		return false;
	}
}
/*$abc = new Sub_Master;
$arr['sub_code']="160701";
//$arr['sub_status']="d";
$arr['sub_name']="MATHS-1";
//$arr['sub_type']="e";
var_dump($abc->set_assoc_array($arr));
var_dump($abc);*/
?>