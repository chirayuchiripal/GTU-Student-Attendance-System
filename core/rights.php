<?php	$menu_items=array(
		"a" => "Academic_Calendar",
		"b" => "Attendance_Master",
		"c" => "Dept_Master",
		"d" => "Faculty_Master",
		"e" => "Inst_Master",
		"f" => "Prog_Master",
		"g" => "Student_Master",
		"h" => "Sub_Master",
		"i" => "User_Master",
		"j" => "Privilege_Master",
		"k" => "Offers_Master"
	);
	$menu_items_label=array(
		"a" => "Academic Calendar",
		"b" => "Attendance Master",
		"c" => "Departments",
		"d" => "Faculties",
		"e" => "Institutes",
		"f" => "Programmes",
		"g" => "Students",
		"h" => "Subjects",
		"i" => "User Accounts",
		"j" => "Privileges",
		"k" => "IPD Mapping"
	);
	$menu_sub_items=array(
		0 => "view",
		1 => "add",
		2 => "update"
	);
	$menu_sub_items_label=array(
		0 => "Search",
		1 => "Add"
	);
	function get_rights($for="")
	{	try
		{	$dbh=new MyDbCon;
			$dbh->select("Privilege_Master");
			$dbh->select->where(array("privilege_id"=>$_SESSION['privilege_id']));
			$dbh->prepare();
			if($dbh->execute())
			{	$obj=$dbh->fetchAll()[0];
				$rights=$obj->get_assoc_array();
				if(empty($for))
					return $rights;
				$for=strtolower($for);
				if(isset($rights[$for]))
					return $rights[$for];
				$for.="_access";
				if(isset($rights[$for]))
					return $rights[$for];
			}
		}
		/*catch(\Zend\Db\Adapter\Exception\ExceptionInterface $e)
		{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
			print "Error: ".$message."<br/>";
		}catch(\Exception $e)
		{	print "Error: ".$e->getMessage()."<br/>";
		}*/
		catch(\Exception $e)
		{	throw $e;
		}
		if(!empty($for))
			return "000";
		return Privilege_Master::zero_rights();
	}
?>