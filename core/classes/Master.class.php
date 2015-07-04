<?php
/***********************
This Document Contains Abstract Class and Interface used by the Core Classes.
***********************/
interface IForm
{	const ERROR_CLASS="has-error";
	const NORM_CLASS="form-element";
	const TOC="* Mandatory Fields.";
	public function getHtmlForm(array $suc=array());
	public function getClass(array $suc=array());
	public function getGuidelines(array $suc=array());
	public function includeJs();
}
abstract class Master implements IForm,JsonSerializable
{	function __construct()
	{	$num=func_num_args();
		if($num)
			$this->set_assoc_array(func_get_arg(0),true);
	}
	abstract public function set_assoc_array(array $arr,$id_present=false);
	public function get_assoc_array($inherited=false)
	{	if($inherited)
			return get_object_vars($this);
        $arr = array();
		$refclass = new ReflectionClass($this);
		foreach ($refclass->getProperties() as $property)
		{	$name = $property->name;
			if ($property->class == $refclass->name)
				$arr[$property->name]=$this->$name;
		}
		return $arr;
	}
	public function get_by_key($key)
	{	if(property_exists($this,$key))
			return $this->$key;
		return null;
	}
	public function set_by_key($key,$val,$id_present=true)
	{	if(property_exists($this,$key))
		{	$arr=array($key=>$val);
			$suc=$this->set_assoc_array($arr,$id_present);
			return $suc[$key];
		}
		return FALSE;
	}
	public function __set($key,$val)
	{	set_by_key($key,$val);
	}
	public function __get($key)
	{	return get_by_key($key);
	}
	protected function trim_value(&$value)
	{	$value = trim($value);
	}
	public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
	public static function isLegit(array $suc)
	{	foreach($suc as $k)
			if($k!==true)
				return false;
		return true;
	}
	public function getClass(array $suc=array())
	{	$class=array();
		foreach($this as $key=>$val)
			$class[$key]= (!isset($suc[$key]) || $suc[$key])?IForm::NORM_CLASS:IForm::ERROR_CLASS;
		return $class;
	}
	public function getGuidelines(array $suc=array())
	{	$guide=array();
		foreach($this as $key=>$val)
			$guide[$key]="";
		$nm=get_class($this);
		global $dir;
		$filepath=$dir."core/classes.guide/{$nm}.guide.php";
		if(file_exists($filepath))
			include_once $filepath;
		return $guide;
	}
	public function getHtmlForm(array $suc=array())
	{	$guide=$this->getGuidelines($suc);
		$class=$this->getClass($suc);
		$nm=get_class($this);
		global $dir;
		$filepath=$dir."core/classes.html/{$nm}.form.php";
		if(file_exists($filepath))
			return require_once $filepath;
		return "Form not Found!!";
	}
	public function getHtml(array $suc=array())
	{	$nm=get_class($this);
		global $dir;
		$filepath=$dir."core/classes.html/{$nm}.html.php";
		if(!file_exists($filepath))
			$filepath=$dir."core/classes.html/Master.html.php";
		return require_once $filepath;
	}
	public function includeJs()
	{	$nm=get_class($this);
		global $js_includes;
		global $myjs_includes;
		global $js_pre_includes;
		global $dir;
		$filepath=$dir."core/classes.js/{$nm}.js.php";
		if(file_exists($filepath))
			require_once $filepath;
	}
}
?>
