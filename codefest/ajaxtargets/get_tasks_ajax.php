<?php
include "../phpscript/sqlconnect.php";

$userid = $_SESSION["loginID"];

$function = $_POST['operation'];
$ctime = $_POST['ctime'];

if($function == "upcoming")
{
	$count = $_POST['count'];
	$result = Upcoming($userid, $ctime, $count);
	$outarr = Array();
	while($row = $result->fetch_row())
	{
		array_push($outarr, $row);
	}
	
	echo json_encode($outarr);
}
else if($function == "all")
{
	$count = $_POST['count'];
	$result = All_Pending($userid, $ctime);
	$outarr = Array();
	while($row = $result->fetch_row())
	{
		array_push($outarr, $row);
	}
	
	echo json_encode($outarr);
}
?>