<?php
//include_once "Syllabus.class.php";
class Teaches extends Syllabus
{	// Class Properties
	protected $teaches_id=NULL;
	protected $faculty_id=NULL;
	protected $syllabus_id=NULL;
	protected $type=0;
	// Class Constants
	
	const HEADING='Teaches';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=parent::set_assoc_array($arr,$id_present);
		//echo "<br>Teaches<br>";
		$suc['teaches_id']=true;
		// Is ID Present
		if($id_present && isset($arr['teaches_id']) && ctype_digit($arr['teaches_id']))
		{	$this->teaches_id=$arr['teaches_id'];
			$arr = (array) self::fill($this->teaches_id);
			//var_dump($arr);
			$suc=parent::set_assoc_array($arr,$id_present);
			$suc['teaches_id']=true;
		}
		// Validation
		if(isset($arr['faculty_id']) && ctype_digit($arr['faculty_id']))
		{	$this->faculty_id=$arr['faculty_id'];
			$suc['faculty_id']=true;
		}
		if(isset($arr['syllabus_id']) && ctype_digit($arr['syllabus_id']))
		{	$this->syllabus_id=$arr['syllabus_id'];
			$suc['syllabus_id']=true;
		}
		$suc['type']=true;
		if(isset($arr['type']) && intval($arr['type'])===1)
		{	$this->type=intval($arr['type']);
		}
		return $suc;
	}
	public static function fill($teaches_id)
	{	$dbh=new MyDbCon;
		$dbh->select("Teaches");
		$dbh->select->where("teaches_id={$teaches_id}");
		$dbh->prepare();
		if($dbh->execute())
			return $dbh->fetchAssoc()[0];
		return false;
	}
}

?>