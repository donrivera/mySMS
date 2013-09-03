<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$num=$dbf->countRows('sms_gateway',"");

if($num==0)
{
	if($_REQUEST[status]=='')
	{
		$status = "Disable";
	}
	else
	{
		$status = "Enable";
	}
	$string="user='$_POST[user]',password='$_POST[password]',mobile='$_POST[mobile]',your_name='$_POST[your_name]',status='$status'";
	$dbf->insertSet("sms_gateway",$string);
	
	header("Location:sms_gateway_manage.php?msg=added");
}
else
{
	if($_REQUEST[status]=='')
	{
		$status = "Disable";
	}
	else
	{
		$status = "Enable";
	}
	$string="user='$_POST[user]',password='$_POST[password]',mobile='$_POST[mobile]',your_name='$_POST[your_name]',status='$status'";
	$dbf->updateTable("sms_gateway",$string,"user<>''");
	
	header("Location:sms_gateway_manage.php?msg=added");
}
?>
