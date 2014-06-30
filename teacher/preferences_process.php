<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
//Object initialization
$dbf = new User();
if($_REQUEST['action']=='edit')
{
	$string="email='$_REQUEST[email]',mobile='$_REQUEST[mobile]'";
	$dbf->updateTable("user",$string,"id='$_REQUEST[record_id]'");
	$dbf->updateTable("teacher",$string,"id='$_SESSION[uid]'");
	header("Location:preferences.php");
}
?>
