<?php
include "../phpscript/sqlconnect.php";

$userid = $_SESSION["loginID"];

$field = $_POST['field'];
$data = $_POST['value'];
$eid = $_POST['eid'];

if($field == "deadline")
{
	$res = Query("UPDATE Tasks SET `Deadline`='".$data."' WHERE `ID`='".$eid."'");
	if($res)
		echo "Done";
	else
		echo "Fail";
}
else if($field == "priority")
{
	$res = Query("UPDATE Tasks SET `Priority`='".$data."' WHERE `ID`='".$eid."'");
	if($res)
		echo "Done";
	else
		echo "Fail";
}
else if($field == "timeleft")
{
	$res = Query("UPDATE Tasks SET `RequiredTime`='".$data."' WHERE `ID`='".$eid."'");
	if($res)
		echo "Done";
	else
		echo "Fail";
}
else if($field == "kill")
{
	$res = Query("DELETE FROM Tasks WHERE `ID`='".$eid."'");
	if($res)
		echo "Done";
	else
		echo "Fail";
}
?>