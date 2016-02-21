<?php 

if(!isset($_SESSION['loginID']) || !isset($_SESSION['loginEmail']))
{
	header( 'Location: about.php' ) ;
}

?>