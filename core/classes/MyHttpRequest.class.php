<?php
use Zend\Http\ClientStatic;
abstract class MyHttpRequest extends HTTP_Status
{
	private static function initHeaders(array $additionalHeaders=array())
	{	$headers=getallheaders();
		unset($headers['Content-Type']);
		unset($headers['Content-Length']);
		$headers=array_merge($headers,$additionalHeaders);
		return $headers;
	}
	public static function getJSONTableData(&$response,$queryString="",array $postParam=array(),array $additionalHeaders=array())
	{
		$view_url="http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}".APP_NAME."/core/modules/view/get/";
		$headers=self::initHeaders($additionalHeaders);
        $httpResponse = ClientStatic::post($view_url.$queryString,$postParam,$headers);
        if (empty($httpResponse) || is_bool($httpResponse)) {
            throw new Exception("Unexpected or no response received from server: " . $httpResponse);
        } else if (!$httpResponse->isOk() || !$httpResponse->isSuccess()) {
            throw new Exception("Error: " . $httpResponse->renderStatusLine());
        }
		$response=json_decode($httpResponse->getContent(),true);
		if(isset($response[0]['status']) && $response[0]['status']==self::NOT_FOUND)
			return false;
		else if(!is_array($response) || isset($response[0]['status']))
			throw new Exception('Response format error.');
		return true;
	}
	public static function postTableData(&$response,$queryString="",array $postParam=array(),array $additionalHeaders=array())
	{
		$add_url="http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}".APP_NAME."/core/modules/add/post/";
		$headers=self::initHeaders($additionalHeaders);
		$response=json_decode(ClientStatic::post($add_url.$queryString,$postParam,$headers)->getContent(),true);
		if(isset($response['status']) && $response['status']==self::DUPLICATE)
			return false;
		else if(isset($response['status']))
			throw new Exception($response['status']);
		return true;
	}
	// No Checking for valid Key Column and Class is Done Inside
	// To insert record into a table if required, and returns Key Column value.
	public static function insertAndGetId($class,$keycol,array $postData=array())
	{	$obj=new $class;
		$suc=$obj->set_assoc_array($postData);
		if(Master::isLegit($suc))
		{
			$where=$obj->get_assoc_array();
			unset($where[$keycol]);
			$clms=array("CLM5"=>$keycol);
			$params=array_merge($where,$clms);
			$data=null;
			MyHttpRequest::postTableData($data,"?master={$class}",$postData);
			//print_r($data);
			MyHttpRequest::getJSONTableData($data,"?master={$class}",$params);
			//print_r($data);
			return $data[0][$keycol];
		}
		return false;
	}
    // @deprecated
	public static function getStudentsByMst(&$response,array $getParam=array(),array $additionalHeaders=array())
	{
		$view_url="http://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}".APP_NAME."/core/modules/attendance/getStudents/";
		$headers=self::initHeaders($additionalHeaders);
		$response=json_decode(ClientStatic::get($view_url,$getParam,$headers)->getContent(),true);
		if(isset($response['status']) || !isset($response))
			return false;
		return true;
	}
}
?>
