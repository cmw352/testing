<?php
include "../phpscript/sqlconnect.php";

$userid = $_SESSION["loginID"];

$name = make_sql_safe($_POST['name']);
$description = make_sql_safe($_POST['description']);
$time = make_sql_safe($_POST['time']);
$due = make_sql_safe($_POST['due']);
$priority = make_sql_safe($_POST['priority']);
$prereq = make_sql_safe($_POST['req']);


echo Push_Event($name, $description, $time, $due, $priority, $userid, $prereq);
echo "done " . $prereq;
?>