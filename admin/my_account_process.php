<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='edit')
{	
	$string="email='$_REQUEST[email]',user_name='$_REQUEST[user_name]',mobile='$_REQUEST[mobile]'";
	$dbf->updateTable("user",$string,"id='$_SESSION[id]'");

	header("Location:my_account.php?msg=added");
}
?>
