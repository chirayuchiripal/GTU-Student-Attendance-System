<?php
// ID Present is used to distinguish between insert or update/view operation
class User_Master extends Master
{	// Class Properties
	protected $user_name=NULL;
	protected $email_id=NULL;
	protected $enc_algo=1;
	protected $salt_type=1;
	protected $salt=NULL;
	protected $user_password=NULL;
	protected $user_status=1;
	protected $user_creation_date=NULL;
	protected $user_update_date=NULL;
	protected $faculty_id=NULL;
	protected $privilege_id=NULL;
	// Class Constants
	const MAX_PWD_LENGTH=50;
	const MIN_PWD_LENGTH=8;
	const MAX_USR_LENGTH=50;
	const MIN_USR_LENGTH=5;
	const HEADING='User';
	// Class Functions
	public function set_assoc_array(array $arr,$id_present=false)
	{	// Initialize Success Variable
		$suc=array();
		foreach($this as $key=>$val)
			$suc[$key]=false;
		// Trim Values
		array_walk($arr,array($this,'trim_value'));
		// Validation
		// Username validation
		if(!empty($arr['user_name']))
		{	$this->user_name=$arr['user_name'];
			$suc['user_name']=true;
		}
		// Email validation
		if(!empty($arr['email_id']))
		{	$this->email_id=$arr['email_id'];
			$suc['email_id']=true;
		}
		// Encryption Algorithm Validation
		$suc['enc_algo']=true;
		if(isset($arr['enc_algo']) && $id_present===true)
		{	$this->enc_algo=intval($arr['enc_algo']);
		}
		// Salt Type Validation
		$suc['salt_type']=true;
		if(isset($arr['salt_type']) && $id_present===true)
		{	$this->salt_type=intval($arr['salt_type']);
		}
		// Salt Validation
		$suc['salt']=true;
		if(isset($arr['salt']) && $id_present===true)
		{	$this->salt=$arr['salt'];
		}
		// Retype User Password Verification
		if(isset($arr['user_password1']) && isset($arr['user_password']))
		{	if(strcmp($arr['user_password'],$arr['user_password1']))
				$suc['user_password1']=false;
		}
		// User Password Validation
		if(isset($arr['user_password']) && !empty($arr['user_password']))
		{	if($id_present!==true && $this->check_password($arr['user_password']))
			{	$this->crypt($arr['user_password']);
				$suc['user_password']=true;
			}
			else if($id_present===true)
			{	$this->user_password=$arr['user_password'];
				$suc['user_password']=true;
			}
		}
		// User Status
		$suc['user_status']=true;
		if(isset($arr['user_status']) && intval($arr['user_status'])===0)
		{	$this->user_status=0;
		}
		// User Creation Date
		$suc['user_creation_date']=true;
		if(isset($arr['user_creation_date']) && $id_present===true)
		{	$this->user_creation_date=$arr['user_creation_date'];
		}
		else
		{	try
			{	$st=new DateTime();
				$this->user_creation_date=$st->format("Y-m-d H:i:s");
			}
			catch(Exception $e)
			{	
			}
		}
		// User Update Date
		$suc['user_update_date']=true;
		if(isset($arr['user_update_date']) && $id_present===true)
		{	$this->user_update_date=$arr['user_update_date'];
		}
		// Faculty Id
		$suc['faculty_id']=true;
		if(isset($arr['faculty_id']) && !empty($arr['faculty_id']))
		{	$this->faculty_id=intval($arr['faculty_id']);
		}
		// Privilege ID
		if(isset($arr['privilege_id']) && !empty($arr['privilege_id']))
		{	$this->privilege_id=intval($arr['privilege_id']);
			$suc['privilege_id']=true;
		}
		return $suc;
	}
	protected function algo($a)
	{	if($a===1)
			return "whirlpool";
		return "whirlpool";
	}
	protected function salt_method($m)
	{	if($m===1)
			return "append";
		return "append";
	}
	protected function append($pass)
	{	return $pass.$this->salt;
	}
	protected function generate_salt()
	{	return uniqid(mt_rand(),true);
	}
	protected function crypt($pass)
	{	$this->salt=$this->generate_salt();
		$fn=$this->salt_method($this->salt_type);
		$this->user_password=hash($this->algo($this->enc_algo),$this->$fn($pass));
	}
	protected function check_password($pass)
	{	/* Password must have:
			minimum length : 8
			max length: 50 characters
			digits : 2
			special character : 1
		*/
		$nod=0;
		$nos=0;
		$max_len=self::MAX_PWD_LENGTH;
		$min_len=self::MIN_PWD_LENGTH;
		$min_dig=2;
		$min_spc=1;
		$pl=strlen($pass);
		if($pl<$min_len || $pl>$max_len)
			return false;
		for($i=0;$i<$pl;$i++)
		{	if(ctype_digit($pass[$i]))
				$nod++;
			if(!ctype_alnum($pass[$i]))
				$nos++;
		}
		if($nod<$min_dig || $nos<$min_spc)
			return false;
		return true;
	}
	public function match_password($password)
	{	$this->trim_value($password);
		$fn=$this->salt_method($this->salt_type);
		$pass=hash($this->algo($this->enc_algo),$this->$fn($password));
		if($this->user_password===$pass)
			return true;
		return false;
	}
}
/*$a=new User_Master;
//$arr['user_name']="   Chirayu";
$arr['user_password']="  @dmin.12";
//$arr['enc_algo']=1;
//$arr['salt_type']=1;
$abc['user_password']="5bfa6548ed74bfe9bb8396e52d10222ca274eb8376a2b24d323a7a5a7cd5c368f1f1c2163cca172a6f836d727c7a77fa4e7ced9ff0a53caf120071f15604ed75";
$abc['salt']="5502270520611a146ed63.60627028";
$s=$a->set_assoc_array($abc,true);
var_dump($a->match_password($arr['user_password']));
var_dump($s);
var_dump($a);
*/
?>