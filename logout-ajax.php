<?php
ob_start();
session_start();

include_once 'includes/class.Main.php';

//Object initialization
$dbf = new User();

//Set the Logout Time in Logn_info Table
if($_SESSION['id']){
	
	//Update for Offline
	$dbf->updateTable("user","is_online=0","id='$_SESSION[id]'");
}
?>