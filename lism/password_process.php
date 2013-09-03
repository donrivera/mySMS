<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='edit')
{
	$num1=$dbf->countRows('user',"user_id='$_POST[uname]' AND id <> '$_SESSION[id]'");
	if($num1 > 0)
	{
		header("Location:password.php?msg=idexist");
		exit;
	}
	else
	{
		$string1="user_id='$_POST[uname]'";
		$dbf->updateTable("user",$string1,"id='$_SESSION[id]'");
	}
	
	$string1="mobile='$_POST[mobile]'";
	$dbf->updateTable("user",$string1,"id='$_SESSION[id]'");
	
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
