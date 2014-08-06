<?php
//include_once "Master.class.php";
class Syllabus extends Master
{	// Class Properties
	protected $syllabus_id=NULL;
	protected $o_id=NULL;
	protected $sub_id=NULL;
	protected $sub_offered_sem=NULL;
	protected $sub_type="R";
	// Class Constants
	
	const HEADING='Syllabus';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		//echo "<br>Syllabus<br>";
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['syllabus_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['syllabus_id']) && ctype_digit($arr['syllabus_id']))
		{	$this->syllabus_id=$arr['syllabus_id'];
			$arr = self::fill($this->syllabus_id);
			//var_dump($arr);
		}
		// Validation Pending
		if(isset($arr['o_id']) && ctype_digit($arr['o_id']))
		{	$this->o_id=$arr['o_id'];
			$suc['o_id']=true;
		}
		if(isset($arr['sub_id']) && ctype_digit($arr['sub_id']))
		{	$this->sub_id=$arr['sub_id'];
			$suc['sub_id']=true;
		}
		if(isset($arr['sub_offered_sem']) && !empty($arr['sub_offered_sem']))
		{	$this->sub_offered_sem=$arr['sub_offered_sem'];
			$suc['sub_offered_sem']=true;
		}
		$suc['sub_type']=true;
		if(isset($arr['sub_type']) && strtoupper($arr['sub_type'])==="E")
		{	$this->sub_type="E";
		}
		return $suc;
	}
	public static function fill($syllabus_id)
	{	$dbh=new MyDbCon;
		$dbh->select("Syllabus");
		$dbh->select->where("syllabus_id={$syllabus_id}");
		$dbh->prepare();
		if($dbh->execute())
			return $dbh->fetchAssoc()[0];
		return false;
	}
}
?>