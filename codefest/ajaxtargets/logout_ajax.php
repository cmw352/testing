<?php session_start();
unset($_SESSION['loginEmail']);
unset($_SESSION['loginID']);

setcookie("userid", $_SESSION['loginID'], time()-100, "/");
setcookie("securecode", Generate_Cookie($_SESSION['loginID']), time()-100, "/");
echo "DONE";
?>