<?php
class Offers_Master extends Master
{	// Class Properties
	protected $o_id=NULL;
	protected $inst_id=NULL;
	protected $prog_id=NULL;
	protected $dept_id=NULL;
	protected $active=1;
	// Class Constants
	const HEADING='IPD Mapping';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		$suc['o_id']=true;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Is ID Present
		if($id_present && isset($arr['o_id']))
			$this->o_id=intval($arr['o_id']);
		// Validation
		if(isset($arr['inst_id']))
		{	$this->inst_id = intval($arr['inst_id']);
			$suc['inst_id']=true;
		}
		if(isset($arr['prog_id']))
		{	$this->prog_id = intval($arr['prog_id']);
			$suc['prog_id']=true;
		}
		if(isset($arr['dept_id']))
		{	$this->dept_id = intval($arr['dept_id']);
			$suc['dept_id']=true;
		}
		$suc['active']=true;
		if(isset($arr['active']) && intval($arr['active'])===0)
		{	$this->active=0;
		}
		return $suc;
	}
	public function getUpdateForm(array $suc=array())
	{	$nm=get_class($this);
		global $dir;
		global $myjs_includes;
		$myjs_includes[]="ajax/o_id.select";
		$myjs_includes[]="offers_master.update";
		return require_once $dir."core/classes.html/Offers_Master.update.html.php";
	}
	public static function getNames($oid)
	{	$dbh=new MyDbCon;
		$dbh->select("Offers_Master");
		$dbh->select->columns(array());
		$dbh->select
		->join("Inst_Master","Inst_Master.inst_id=Offers_Master.inst_id",array("inst_name"))
		->join("Prog_Master","Prog_Master.prog_id=Offers_Master.prog_id",array("prog_name"))
		->join("Dept_Master","Dept_Master.dept_id=Offers_Master.dept_id",array("dept_name"));
		$dbh->select->where("o_id={$oid}");
		$dbh->prepare();
		if($dbh->execute())
		{	$res=$dbh->fetchAssoc()[0];
			return $res;
		}
		return false;
	}
	public static function getIds($oid)
	{	$dbh=new MyDbCon;
		$dbh->select("Offers_Master");
		$dbh->select->where("o_id={$oid}");
		$dbh->prepare();
		if($dbh->execute())
		{	$res=$dbh->fetchAssoc()[0];
			return $res;
		}
		return false;
	}
}
/*
$abc=new Offers_Master;
$arr['inst_id']=1;
//$arr['prog_id']=1;
$arr['dept_id']=1;
$arr['active']=0;
var_dump($abc->set_assoc_array($arr));
var_dump($abc);
*/
?>