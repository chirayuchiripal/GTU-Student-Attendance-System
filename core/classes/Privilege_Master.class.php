<?php
class Privilege_Master extends Master
{	// Class Properties
	protected $privilege_id=NULL;
	protected $privilege_name=NULL;
	protected $faculty_master_access="100";
	protected $inst_master_access="100";
	protected $prog_master_access="100";
	protected $dept_master_access="100";
	protected $academic_calendar_access="100";
	protected $attendance_master_access="100";
	protected $student_master_access="100";
	protected $sub_master_access="100";
	protected $user_master_access="100";
	protected $privilege_master_access="100";
	protected $offers_master_access="100";
	// Currently kept to allowed
	protected $syllabus_access="110";
	protected $teaches_access="110";
	protected $reports="1";
	// Class Constants
	const PRIV_NAME_MAXLENGTH=30;
	const HEADING='Privileges';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['privilege_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['privilege_id']))
			$this->privilege_id=intval($arr['privilege_id']);
		// Validation pending
		// Privilege Name
		if(!empty($arr['privilege_name']) && strlen($arr['privilege_name'])<=self::PRIV_NAME_MAXLENGTH)
		{	$this->privilege_name=$arr['privilege_name'];
			$suc['privilege_name']=true;
		}
		$regex='/^[01]{3}$/';
		// Faculty Master Access
		if(isset($arr['faculty_master_access']) && preg_match($regex, $arr['faculty_master_access']))
		{	$this->faculty_master_access=$arr['faculty_master_access'];
			$suc['faculty_master_access']=true;
		}
		// Institute Master Access
		if(isset($arr['inst_master_access']) && preg_match($regex, $arr['inst_master_access']))
		{	$this->inst_master_access=$arr['inst_master_access'];
			$suc['inst_master_access']=true;
		}
		// Programme Master Access
		if(isset($arr['prog_master_access']) && preg_match($regex, $arr['prog_master_access']))
		{	$this->prog_master_access=$arr['prog_master_access'];
			$suc['prog_master_access']=true;
		}
		// Department Master Access
		if(isset($arr['dept_master_access']) && preg_match($regex, $arr['dept_master_access']))
		{	$this->dept_master_access=$arr['dept_master_access'];
			$suc['dept_master_access']=true;
		}
		// Academic Calendar Access
		if(isset($arr['academic_calendar_access']) && preg_match($regex, $arr['academic_calendar_access']))
		{	$this->academic_calendar_access=$arr['academic_calendar_access'];
			$suc['academic_calendar_access']=true;
		}
		// Attendance Master Access
		if(isset($arr['attendance_master_access']) && preg_match($regex, $arr['attendance_master_access']))
		{	$this->attendance_master_access=$arr['attendance_master_access'];
			$suc['attendance_master_access']=true;
		}
		// Student Master Access
		if(isset($arr['student_master_access']) && preg_match($regex, $arr['student_master_access']))
		{	$this->student_master_access=$arr['student_master_access'];
			$suc['student_master_access']=true;
		}
		// Subject Master Access
		if(isset($arr['sub_master_access']) && preg_match($regex, $arr['sub_master_access']))
		{	$this->sub_master_access=$arr['sub_master_access'];
			$suc['sub_master_access']=true;
		}
		// User Master Access
		if(isset($arr['user_master_access']) && preg_match($regex, $arr['user_master_access']))
		{	$this->user_master_access=$arr['user_master_access'];
			$suc['user_master_access']=true;
		}
		// Privilege Master Access
		if(isset($arr['privilege_master_access']) && preg_match($regex, $arr['privilege_master_access']))
		{	$this->privilege_master_access=$arr['privilege_master_access'];
			$suc['privilege_master_access']=true;
		}
		// Offers Master Access
		if(isset($arr['offers_master_access']) && preg_match($regex, $arr['offers_master_access']))
		{	$this->offers_master_access=$arr['offers_master_access'];
			$suc['offers_master_access']=true;
		}
		$suc['syllabus_access']=true;
		$suc['teaches_access']=true;
		// Syllabus Access
		/*if(isset($arr['syllabus_access']) && preg_match($regex, $arr['syllabus_access']))
		{	$this->syllabus_access=$arr['syllabus_access'];
			$suc['syllabus_access']=true;
		}
		// Teaches Access
		if(isset($arr['teaches_access']) && preg_match($regex, $arr['teaches_access']))
		{	$this->teaches_access=$arr['teaches_access'];
			$suc['teaches_access']=true;
		}*/
		// Reports Access
		$suc['reports']=true;
		if(isset($arr['reports']) && intval($arr['reports'])==0)
		{	$this->reports=$arr['reports'];
		}
		return $suc;
	}
	public static function zero_rights()
	{	$rights=array();
		$obj=new Privilege_Master;
		$arr=$obj->get_assoc_array();
		foreach($arr as $key=>$val)
		{	if($key!="privilege_id" && $key!="privilege_name")
				$rights[$key]="000";
		}
		return $rights;
	}
	public static function is_super($priv_id)
	{	$dbh = new MyDbCon;
		$dbh->select("Privilege_Master");
		$dbh->select->where(array("privilege_id"=>$priv_id));
		$dbh->prepare();
		if($dbh->execute())
		{	$rights = $dbh->fetchAssoc()[0];
			unset($rights['privilege_id']);
			unset($rights['privilege_name']);
			foreach($rights as $val)
			{	for($i=0;$i<strlen($val);$i++)
				{	if(intval($val[$i])!==1)
						return false;
				}
			}
		}
		return true;
	}
}
?>