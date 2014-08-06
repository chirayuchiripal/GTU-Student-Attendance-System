<?php
if('POST' == $_SERVER['REQUEST_METHOD'])
{	
	/*
	$obj=new $_GET['master'];
	$wh=array();
	foreach($_POST as $key=>$val)
	{	if($obj->set_by_key($key,$val))
		{	$wh[$key]=$val;
		}
	}
	$dbh->select->where($wh);
	*/
	$master_tables=array();
	$master_tables[$_GET['master']]=true;
	if(isset($pre_joined_tables))
		$master_tables=array_merge($master_tables,$pre_joined_tables);
	$where_funcs=array(
		'=' => 'equalTo',
		'<' => 'lessThan',
		'>' => 'greaterThan',
		'<=' => 'lessThanOrEqualTo',
		'>=' => 'greaterThanOrEqualTo',
		'like' => 'like'
	);
	foreach($_POST as $key=>$val)
	{	foreach($master_tables as $table=>$bool)
		{	$obj=new $table;
			$tmp_cols=$obj->get_assoc_array();
			if(array_key_exists($key,$tmp_cols))
			{	
				$vals=explode(':',$val);
				$wh=$where_funcs['='];
				if(!empty($vals[1]) && isset($where_funcs[$vals[1]]))
					$wh=$where_funcs[$vals[1]];
				if($obj->set_by_key($key,$vals[0]))
				{	$dbh->select->where->$wh($key,$obj->get_by_key($key));
				}
				break;
			}
		}
	}
	//var_dump($dbh->select->where);
	$obj=new $_GET['master'];
	if(isset($_POST['CLM5']))
	{	$cols=explode(",",$_POST['CLM5']);
		$clm=array();
		foreach($cols as $val)
		{	if(property_exists($obj,$val))
				$clm[]=$val;
		}
		$dbh->select->columns($clm);
	}
	if(isset($_POST['ORD3l2']))
	{	$cols=explode(",",$_POST['ORD3l2']);
		$clm=array();
		foreach($cols as $val)
		{	if(property_exists($obj,$val))
				$clm[]=$val;
		}
		$dbh->select->order($clm);
	}
}
?>