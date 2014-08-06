<?php
//include_once "Teaches.class.php";
class Attendance_Master extends Teaches
{	// Class Properties
	protected $attd_mst_id=NULL;
	protected $teaches_id=NULL;
	protected $batchno="";
	protected $division="";
	protected $ac_id=NULL;
	// Class Constants
	const BATCHNO_MAXLENGTH=3;
	const DIVISION_MAXLENGTH=1;
	const HEADING='Attendance Master';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=parent::set_assoc_array($arr,$id_present);
		//echo "<br>Attendance Master<br>";
		$suc['attd_mst_id']=true;
		// Is ID Present
		if($id_present && isset($arr['attd_mst_id']) && ctype_digit($arr['attd_mst_id']))
			$this->attd_mst_id=$arr['attd_mst_id'];
		// Validation
		if(isset($arr['teaches_id']) && ctype_digit($arr['teaches_id']))
		{	$this->teaches_id=$arr['teaches_id'];
			$suc['teaches_id']=true;
		}
		if(isset($arr['division']) && !empty($arr['division']))
		{	$this->division=$arr['division'];
		}
		$suc['division']=true;
		// Careful...empty with integer value 0 will result false..Correct this part
		if(isset($arr['batchno']) && !empty($arr['batchno']) && $this->type!==0)
		{	$this->batchno=intval($arr['batchno']);
		}
		$suc['batchno']=true;
		if(isset($arr['ac_id']) && ctype_digit($arr['ac_id']))
		{	$this->ac_id=$arr['ac_id'];
			$suc['ac_id']=true;
		}
		return $suc;
	}
}

/*
$arr['teaches_id']=1;
$arr['syllabus_id']=2;
$abc=new Attendance_Master($arr);
var_dump($abc->get_assoc_array());
*/
?>