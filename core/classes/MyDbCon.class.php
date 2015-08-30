<?php
// Database Operation Class
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Exception\ExceptionInterface;

interface IMyDbCon
{	public function insert(Master $obj);
	public function fetchAll();
	public function fetchAssoc($cols=array());
	public function select($from);
	public function prepare();
	public function execute();
	public function update(Master $obj,array $id_cols,$dontUpdateIds=true);
}
class MyDbCon implements IMyDbCon
{	private $adapter;
	public $sql;
	public $select;
	public $insert;
	public $update;
	public $statement;
	public $results;
	protected $table;
	protected $last_action=NULL;
	public function __construct()
	{	$configArray=require(__DIR__."/../config/db/credentials.db.php");
		$this->adapter=new Adapter($configArray);
		$this->sql=new Sql($this->adapter);
	}
    public function getAdapter()
    {   return $this->adapter;
    }
	public function call($proc_name,array $param=array())
	{	$con = $this->getAdapter()->getDriver()->getConnection();
		$args="";
		$i=0;
		foreach($param as $v)
		{	if($i)
				$args.=",";
			$args.=$v;
			$i++;
		}
		$result = $con->execute("CALL {$proc_name}({$args})");
		return $result->getResource();
	}
    public function getLastGeneratedValue()
    {   return $this->getAdapter()->getDriver()->getLastGeneratedValue();
    }
    public function beginTransaction()
    {   $this->getAdapter()->getDriver()->getConnection()->beginTransaction();
    }
    public function commit()
    {   $this->getAdapter()->getDriver()->getConnection()->commit();
    }
    public function rollback()
    {   $this->getAdapter()->getDriver()->getConnection()->rollback();
    }
    
    public function setInsert(Master $obj)
    {   $this->table=get_class($obj);
		$this->insert=$this->sql->insert();
		$this->insert->into($this->table);
        $this->last_action="insert";
    }
	public function insert(Master $obj)
	{	$this->setInsert($obj);
		$this->insert->values($obj->get_assoc_array());
		$this->last_action="insert";
	}
	public function update(Master $obj,array $id_cols,$dontUpdateIds=true)
	{	$this->table = get_class($obj);
		$this->update = $this->sql->update();
		$this->update->table($this->table);
		$values = $obj->get_assoc_array();
		if($dontUpdateIds)
		{	foreach($values as $key => $val)
			{	if(isset($id_cols[$key]))
					unset($values[$key]);
			}
		}
		//var_dump($values);
		$this->update->set($values);
		$this->update->where($id_cols);
		$this->last_action="update";
	}

    public function updateThese(Master $obj, array $id_cols, array $update_cols)
    {
        $this->table = get_class($obj);
        $this->update = $this->sql->update();
        $this->update->table($this->table);
        $data = $obj->get_assoc_array();
        $values = array();
        foreach($update_cols as $key) {
            $values[$key] = $data[$key];
        }
        $this->update->set($values);
        $this->update->where($id_cols);
        $this->last_action="update";
    }

    // Preferably For MySQL only
    public function multiInsert(array $objs)
    {   $this->table=get_class(current($objs));
        //echo $this->table;
        $sql="Insert Into {$this->table} ( ";
        $props=current($objs)->get_assoc_array();
        $keys_cnt=array();
        $i=0;
        foreach($props as $key=>$val)
        {   if($i)
                $sql.=', ';
            $keys_cnt[$key]=0;
            $sql.=$key;
            $i++;
        }
        $sql.=' ) ';
        $params=array();
        $sql_values='Values';
        $k=0;
        foreach($objs as $obj)
        {   if($k)
                $sql_values.=',';
            $sql_values.=' ( ';
            $obj_arr=$obj->get_assoc_array();
            $i=0;
            foreach($props as $key=>$val)
            {   if($i)
                    $sql_values.=', ';
                $sql_values.=':'.$key.$keys_cnt[$key];
                $params[$key.$keys_cnt[$key]]=$obj_arr[$key];
                $keys_cnt[$key]++;
                $i++;
            }
            $sql_values.=' )';
            $k++;
        }
        $sql.=$sql_values;
        $this->statement=$this->getAdapter()->createStatement($sql,$params);
        $this->last_action=NULL;
    }
	public function multiUpdate(array $objs,array $update_keys)
	{	$this->table=get_class(current($objs));
        //echo $this->table;
        $sql="Insert Into {$this->table} ( ";
        $props=current($objs)->get_assoc_array();
        $keys_cnt=array();
        $i=0;
        foreach($props as $key=>$val)
        {   if($i)
                $sql.=', ';
            $keys_cnt[$key]=0;
            $sql.=$key;
            $i++;
        }
        $sql.=' ) ';
        $params=array();
        $sql_values='Values';
        $k=0;
        foreach($objs as $obj)
        {   if($k)
                $sql_values.=',';
            $sql_values.=' ( ';
            $obj_arr=$obj->get_assoc_array();
            $i=0;
            foreach($props as $key=>$val)
            {   if($i)
                    $sql_values.=', ';
                $sql_values.=':'.$key.$keys_cnt[$key];
                $params[$key.$keys_cnt[$key]]=$obj_arr[$key];
                $keys_cnt[$key]++;
                $i++;
            }
            $sql_values.=' )';
            $k++;
        }
        $sql.=$sql_values;
		$sql.=" ON DUPLICATE KEY UPDATE ";
		$k=0;
		foreach($update_keys as $key)
		{	if($k)
				$sql.=",";
			$sql.="{$key} = VALUES({$key}) ";
			$k++;
		}
		//echo $sql;
        $this->statement=$this->getAdapter()->createStatement($sql,$params);
        $this->last_action=NULL;
	}
	public function select($from)
	{	if(is_array($from))
			$this->table=array_values($from)[0];
		else
			$this->table=$from;
		$this->select=$this->sql->select();
		$this->select->from($from);
		$this->last_action="select";
	}
	public function prepare()
	{	$str=$this->last_action;
		if(isset($str))
			$this->statement = $this->sql->prepareStatementForSqlObject($this->$str);
		$this->last_action=NULL;
	}
	public function execute()
	{	$this->results=$this->statement->execute();
		return $this->results->getAffectedRows();
	}
	public function fetchAll()
	{	if ($this->results instanceof ResultInterface && $this->results->isQueryResult())
		{	$resultSet = new HydratingResultSet(new ReflectionHydrator, new $this->table);
			$resultSet->initialize($this->results);
			$objs=array();
			foreach ($resultSet as $user)
				$objs[]=$user;
			return $objs;
		}
		return false;
	}
	public function fetchAssoc($cols=array())
	{	if ($this->results instanceof ResultInterface && $this->results->isQueryResult())
		{	$resultSet=new ResultSet;
			$resultSet->initialize($this->results);
			$res=array();
			foreach ($resultSet as $row)
				$res[]=$row;
			return $res;
		}
		return false;
	}
	/*************************************************************************
			MOST of the validation done in joins.php should be done here
	***************************************************************************/
	public function join($table,$on,$cols=Select::SQL_STAR,$type=Select::JOIN_INNER)
	{	$this->select->join($table,$on,$cols,$type);
	}
}
?>