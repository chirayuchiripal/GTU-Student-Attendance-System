<?php
$dir="../../../";
require_once $dir."core/post_pages_head.php";
function account_error($status=HTTP_Status::INTERNAL_SERVER_ERROR,$custom="")
{	if(!empty($custom))
		$err=$custom;
	else
		$err=HTTP_Status::getMessage($status);
	$try=array("done"=>false,"final"=>$err,"status"=>$status);
	$try = json_encode($try);
    header('Content-Length: '.strlen($try));
    header('Content-Type: application/json');
    echo $try;
	exit();
}
if('POST' == $_SERVER['REQUEST_METHOD'])
{	if(!isset($_SESSION['login']) || $_SESSION['login']!==true)
		account_error(HTTP_Status::UNAUTHORIZED);
	if(empty($_POST['user_password_old']) || empty($_POST['user_password']) || empty($_POST['user_password1']))
		account_error(HTTP_Status::BAD_REQUEST,"Please fill all the fields!");
	try
	{	$dbh = new MyDbCon;
		$dbh->select("User_Master");
		$dbh->select->where->equalTo("user_name",$_SESSION['user_name']);
		$dbh->prepare();
		$dbh->execute();
		$user = $dbh->fetchAll()[0];
		if($user->match_password($_POST['user_password_old']))
		{	$newUser = $user->get_assoc_array();
			$newUser['user_password'] = $_POST['user_password'];
			$newUser['user_password1'] = $_POST['user_password1'];
			$nu = new User_Master();
			$suc = $nu->set_assoc_array($newUser);
			if(Master::isLegit($suc))
			{	$dbh->update($nu,array("user_name"=>$_SESSION['user_name']));
				$dbh->prepare();
				$dbh->execute();
				$final = json_encode(array("done"=>true,"final"=>"Password Changed Successfully!"));
				header('Content-Length: '.strlen($final));
				header('Content-Type: application/json');
				echo $final;
			}
			else
			{	account_error(HTTP_Status::BAD_REQUEST,"Password do not match the given specification!!");
			}
		}
		else
		{	account_error(HTTP_Status::BAD_REQUEST,"Old Password do not match");
		}
	}catch(\Exception $e)
	{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
		$code =	$e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();
		$err = "Error Code: ".$code." <br/>Detailed Info: ".$message;
		$response = array(
					   'code' => HTTP_Status::FORBIDDEN,
					   'message' => $err
					   );
		return false;
	}
}
?>