<?php
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}
if ( is_session_started() === FALSE ) session_start();

include "hash.php";

//$connection = mysqli_connect("localhost", "jeffers_root", "admingo", "jeffers_codefest");
$connection = mysqli_connect("localhost", "jeffers_codefest", "Cdfst#1z", "jeffers_codefest");

$_SESSION['sqlconnection'] = $connection;

if ($mysqli->connect_errno) {
	echo "! Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

function Query($query)
{
	$connection = $_SESSION['sqlconnection'];
	$result = $connection->query($query);
	if(!$result)
	{
		echo false;
	}
	return $result;
}

function Make_User($name, $email, $password)
{

	$salt = generate_salt(8);
	$password = hashpass($password, $salt);
	echo Query("INSERT INTO users (Name, Email, PasswordHash, PasswordSalt) VALUES ('".$name."', '".$email."', '".$password."', '".$salt."')");
}

function Check_User_Exists($email)
{
	$result = Query("SELECT * FROM users WHERE `Email`='".$email."'");
	if($result->num_rows > 0)
		return true;
	return false;
}

function Get_User($email)
{
	return Query("SELECT `ID`, `Name`, `Email`, `PasswordHash`, `PasswordSalt` FROM `users` WHERE `Email`='".$email."'");
}

function Push_Event($name, $descr, $time, $due, $priority, $uid, $req)
{
	return( Query("INSERT INTO Tasks (Name, Description, RequiredTime, Deadline, Owner, ReqTask, Priority) 
						VALUES ('".$name."', '".$descr."', '".$time."', '".$due."', '".$uid."', '".$req."', '".$priority."')") );
}
function Upcoming($uid, $timeNow, $maxcount)
{
	return( Query("SELECT * FROM Tasks WHERE `Deadline`>'".$timeNow."' AND `Owner`='".$uid."' ORDER BY `Deadline` ASC, `Priority` DESC LIMIT ".$maxcount) );
}
function All_Pending($uid, $timeNow)
{
	return( Query("SELECT * FROM Tasks WHERE `Deadline`>'".$timeNow."' AND `Owner`='".$uid."' ORDER BY `Deadline` ASC") );
}

function Get_Cookie($uid)
{
	return Query("SELECT `Cookie` FROM users WHERE `ID`='".$uid."'")->fetch_row[0];
}
function Cookie_Valid($uid, $cookie)
{
	return Query("SELECT * FROM users WHERE `ID`='".$uid."' AND `Cookie`='".$cookie."'")->num_rows > 0;
}
function Set_Cookie($uid, $cookie)
{
	return Query("UPDATE users SET `Cookie`='".$cookie."' WHERE `ID`='".$uid."'");
}
function Generate_Cookie($uid)
{
	$cookie = generate_salt(16);
	Set_Cookie($uid, $cookie);
	return $cookie;
}

function JS_All_Pending($uid, $timeNow)
{
	$result = All_Pending($uid, $timeNow);
	$outarr = Array();
	while($row = $result->fetch_assoc())
	{
		array_push($outarr, $row);
	}
	return json_encode($outarr);
}

function isValidOwner($owner, $eid)
{
	$result = Query("SELECT * FROM Tasks WHERE `ID`='".$eid."' AND `Owner`='".$owner."'");
	if($result->num_rows > 0)
		return true;
	return false;
}

function FindAllPrequisites($eid)
{
	$current = getTaskInfo($eid)->fetch_assoc();
	$arr = Array();
	array_push($arr, $current);
	while($current['ReqTask'] != -1 && count($arr) < 10)
	{
		$current = getTaskInfo($current['ReqTask'])->fetch_assoc();
		array_push($arr, $current);
	}
	if(count($arr) == 10)
		return Array();
	else
		return $arr;
}

function getTaskInfo($eid)
{
	return Query("SELECT * FROM Tasks WHERE `ID`='".$eid."'");
}
?>