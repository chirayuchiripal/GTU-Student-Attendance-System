<?php
abstract class HTTP_Status
{	const UNAUTHORIZED=401;
	const UNAUTHORIZED_MSG="Please Login Again!";
	const FORBIDDEN=403;
	const FORBIDDEN_MSG="You don't have sufficient rights!";
	const NOT_FOUND=404;
	const NOT_FOUND_MSG="No Record Found!";
	const INTERNAL_SERVER_ERROR=500;
	const INTERNAL_SERVER_ERROR_MSG="Server is busy right now!";
	const DUPLICATE=23000;
	const DUPLICATE_MSG="Duplicate Entry!";
	const BAD_REQUEST=400;
	const BAD_REQUEST_MSG="The request cannot be fulfilled due to bad syntax.";
	public static function getMessage($status)
	{	$http_status=new ReflectionClass('HTTP_Status');
		$const=$http_status->getConstants();
		$const_name=null;
		foreach($const as $name=>$val)
		{	if($val==$status)
			{	$const_name=$name;
				break;
			}
		}
		if(!empty($const_name))
		{	$const_name.="_MSG";
			return $http_status->getConstant($const_name);
		}
		return "Some Error Occurred!";
	}
}
?>