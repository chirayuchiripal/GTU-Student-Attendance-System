<?php
    if('POST' == $_SERVER['REQUEST_METHOD'])
	{	// Validation
		$user=trim($_POST['user_name']);
		$pass=trim($_POST['user_password']);
		if(!isset($user) || !isset($pass) || empty($user) || empty($pass))
		{	$err="Wrong Username/Password!!";
		}
		// Database Part
		else
		{	try
			{	$con=new MyDbCon;
				$con->select("User_Master");
				$con->select->where(array("user_name"=>$user));
				$con->prepare();
				if($con->execute())
				{	$obj=$con->fetchAll()[0];
					if($obj->match_password($pass))
					{	$status=$obj->get_by_key('user_status');
						if($status!=0)
						{	$_SESSION['login']=true;
							$_SESSION['privilege_id']=$obj->get_by_key('privilege_id');
							$_SESSION['user_name']=$user;
							$_SESSION['faculty_id']=$obj->get_by_key('faculty_id');
							header('Location: ./dashboard/');
							exit();
						}
						else
							$err="Your Account is Locked!!";
					}
					else
						$err="Wrong Username/Password!!";
				}
				else
					$err="Wrong Username/Password!!";
			}catch(\Zend\Db\Adapter\Exception\ExceptionInterface $e)
			{	$message = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
				die("Error: ".$message."<br/>");
			}catch(\Exception $e)
			{	die("Error: ".$e->getMessage()."<br/>");
			}
		}
	}
?>
