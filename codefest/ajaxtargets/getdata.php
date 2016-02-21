<?php
include "../phpscript/sqlconnect.php";

$userid = $_SESSION["loginID"];

$eid = $_POST['eid'];
$operation = $_POST['operation'];
if($operation == 'getinfo')
{
	echo json_encode(getTaskInfo($eid)->fetch_assoc());
}
else if($operation == 'prereqs')
{
	$obj = FindAllPrequisites($eid);
	array_push($obj, $_POST['row']);
	echo json_encode(  $obj  );
}



?>