<?php
include "../phpscript/sqlconnect.php";
$function = $_POST['operation'];
if($function == "login")
{
	$password = make_sql_safe ($_POST['password']);
	$email = make_sql_safe ($_POST['email']);
	
	if(!Check_User_Exists($email))
	{
		echo "0Invalid username/password";
	}
	else
	{
		$result = Get_User($email)->fetch_assoc();
		if($result['PasswordHash'] == hashpass($password, $result['PasswordSalt']))
		{
			$_SESSION['loginEmail'] = $email;
			$_SESSION['loginID'] = Get_User($email)->fetch_row()[0];
			
			setcookie("userid", $_SESSION['loginID'], time() + (86400 * 30), "/");
			setcookie("securecode", Generate_Cookie($_SESSION['loginID']), time() + (86400 * 30), "/");
			echo "1";
		}
		else
			echo"0Invalid username/password";
	}
}
else if($function == "register")
{
	$name = make_sql_safe($_POST['name']);
	$password = make_sql_safe($_POST['password']);
	$email = make_sql_safe($_POST['email']);
	
	if(Check_User_Exists($email))
	{
		echo "0That email is already in use";
	}
	else
	{
		Make_User($name, $email, $password);
		$_SESSION['loginID'] = Get_User($email)->fetch_row()[0];
		$_SESSION['loginEmail'] = $email;
		setcookie("userid", $_SESSION['loginID'], time() + (86400 * 30), "/");
		setcookie("securecode", Generate_Cookie($_SESSION['loginID']), time() + (86400 * 30), "/");
		echo "1 Login Succeeded, id:".$_SESSION['loginID'];
	}
}
else if($function == "cookie_login")
{
	if(isset($_COOKIE['userid']))
	{
		if(Cookie_Valid($_COOKIE['userid'],$_COOKIE['securecode']))
		{
			$_SESSION['loginID'] = $_COOKIE['userid'];
			$_SESSION['loginEmail'] = Query("SELECT `Email` FROM users WHERE `ID`='".$_SESSION['loginID']."'")->fetch_row()[0];
			echo "1";
		}
	}
	echo "0";
}
?>