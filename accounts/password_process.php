<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='edit')
{
	$pwd = base64_encode(base64_encode($_POST[oldpassword]));
	
	$newpwd = base64_encode(base64_encode($_POST[newpassword]));
	
	$num=$dbf->countRows('user',"password='$pwd' AND id='$_SESSION[id]'");
	if($num>0)
	{
		$string="password='$newpwd'";
		$dbf->updateTable("user",$string,"id='$_SESSION[id]'");
		header("Location:password.php?msg=added");
	}
	else
	{
		header("Location:password.php?msg=invalid");
	}
}
?>
