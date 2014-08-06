<?php
/*******************************************************

NEED A BETTER FLEXIBLE IMPLEMENTATION
METHOD 1:
-> JT1: JOIN TABLE NAME (MANDATORY)
-> JO1: JOIN ON (MANDATORY)
-> JC1: JOIN COLUMNS (OPTIONAL)
 AND LIKE WISE JT2,JO2,JC2

METHOD 2: (Accepted)
-> JT: semicolon(;) separated table names
-> JO: "			"			on fields respectively
-> JC: "			"			columns for each join respectively
		where columns are comma(,) separated for particular join


->Check columns(on also) are actually property of given Table
->Check rights on all tables (masters and JT's)
 
 PARAMS GET: master=Offer_Master
 PARAMS POST: JT=Inst_Master&JO=inst_id&JC=inst_name
 
-> Keep backward compatibilty for a while.
-> Implement this new method for search records and test it.


**********************************************************/
/********************************************************
		POOR OLD CODE (KEEPING FOR BACKWARD COMPAT.)
		
	use $dbh->select->join() instead of $dbh->join()
	new implementation will break this in future otherwise
*********************************************************/
if(isset($_GET['j']))
{	$code=$_GET['j'];
	if(isset($_GET['iid']))
	{	if(ctype_digit($_GET['iid']))
			$iid=$_GET['iid'];
		else
			$iid=0;
	}
	if(isset($_GET['pid']))
	{	if(ctype_digit($_GET['pid']))
			$pid=$_GET['pid'];
		else
			$pid=0;
	}
	$ac_bit=1;
	if(isset($_GET['ac']) && intval($_GET['ac'])==0)
		$ac_bit = 0;
	// Join - Prog_Master with Offers Master where inst_id
	if(strcmp($code,"jxUiQ3Gh8xC")==0 && strcmp($_GET['master'],"Prog_Master")==0)
	{	$dbh->select(array("pm"=>"Prog_Master"));
		$dbh->select->quantifier("DISTINCT");
		$dbh->join(array("om"=>"Offers_Master"),"pm.prog_id=om.prog_id",array("prog_id"));
		$where="";
		if(!empty($ac_bit))
			$where="om.active=1";
		if(isset($iid))
		{	if(!empty($ac_bit))
				$where.=" AND ";
			$where.="om.inst_id=".$iid;
		}
		$dbh->select->where($where);
	}
	// Join - Dept_Master with Offers Master where prog_id AND inst_id
	else if(strcmp($code,"yUlxT0qW3b")==0 && strcmp($_GET['master'],"Dept_Master")==0)
	{	$dbh->select(array("dm"=>"Dept_Master"));
		$dbh->select->quantifier("DISTINCT");
		$dbh->join(array("om"=>"Offers_Master"),"dm.dept_id=om.dept_id",array("dept_id"));
		$where="";
		if(!empty($ac_bit))
			$where="om.active=1";
		if(isset($iid))
		{	if(!empty($ac_bit))
				$where.=" AND ";
			$where.=" om.inst_id=".$iid;
		}
		if(isset($pid))
			$where.=" AND om.prog_id=".$pid;
		$dbh->select->where($where);
	}
}
/***********************************************************
				NEW IMPLEMENTATION
				
	Validation done here should be done in
			MyDbCon class
// Check User_Master allowed keys
***********************************************************/
if(!empty($_POST["JT"]) && !empty($_POST["JO"]) && !empty($_GET['master']))
{	$tables=explode(";",$_POST["JT"]);
	$joinon=explode(";",$_POST["JO"]);
	if(!empty($_POST["JC"]))
		$join_columns=explode(";",$_POST["JC"]);
	/*if(!empty($_POST["J3"]))
		$join_type=explode(";",$_POST["J3"]);*/
	$pre_joined_tables=array();
	foreach($tables as $key=>$table)
	{	// Check rights for each table
		if(!function_exists('get_rights') || empty($table) || get_rights($table)[$right_index]!='1')
		{	//echo $table;
			call_user_func($error_func,HTTP_Status::FORBIDDEN);
		}
		if(class_exists($table) && !empty($joinon[$key]))
		{	$obj=new $table;
			$vars=$obj->get_assoc_array();
			$jo=explode(":",$joinon[$key]);
			// Default Table 2
			$obj2=new $_GET['master'];
			$table2=$_GET['master'];
			if(isset($jo[1]) && !empty($pre_joined_tables[$tables[$jo[1]]]))
			{	//echo "table 2 : ".$jo[1];
				$obj2=new $tables[$jo[1]];
				$table2=$tables[$jo[1]];
			}
			$vars2=$obj2->get_assoc_array();
			// Check Join Tables are instance of IForm
			// Check join on columns are in both tables.
			if($obj instanceof IForm && $obj2 instanceof IForm && array_key_exists($jo[0],$vars) && array_key_exists($jo[0],$vars2))
			{	//echo "arrr";
				$jc=array();
				if(!empty($join_columns[$key]))
				{	$cols=explode(",",$join_columns[$key]);
					foreach($cols as $c)
					{	if(array_key_exists($c,$vars))
							$jc[]=$c;
					}
				}
				$on="{$table2}.{$jo[0]}={$table}.{$jo[0]}";
				
				// Check Columns given, if not use SQL START
				if(empty($jc))
					$jc=Zend\Db\Sql\Select::SQL_STAR;

				// Set Default join type
				$j_type=Zend\Db\Sql\Select::JOIN_LEFT;
				// Check join type specified
				if(!empty($join_type[$key]))
				{	$types=array(
									Zend\Db\Sql\Select::JOIN_INNER,								
									Zend\Db\Sql\Select::JOIN_OUTER,								
									Zend\Db\Sql\Select::JOIN_LEFT,								
									Zend\Db\Sql\Select::JOIN_RIGHT,								
								);
					
					if(in_array($join_type[$key],$types))
					{	$j_type=$join_type[$key];
						echo $j_type;
					}
				}
				$dbh->join($table,$on,$jc,$j_type);
				$pre_joined_tables[$table]=true;
			}
			else
			{	//echo "error at".$table.$table2;
				list_error(HTTP_Status::BAD_REQUEST);
			}
		}
		else
			list_error(HTTP_Status::BAD_REQUEST);
	}
}
?>