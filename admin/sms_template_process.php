<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="name='$_POST[name]',contents='$_POST[textarea]',created_datetime='$cr_date'";
	$dbf->insertSet("sms_templete",$string);
	
	header("Location:sms_template_manage.php");	
}


if($_REQUEST['action']=='edit')
{
	
	$string="name='$_POST[name]',contents='$_POST[textarea]'";
	$dbf->updateTable("sms_templete",$string,"id='$_REQUEST[id]'");
	
	header("Location:sms_template_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("sms_templete","id='$_REQUEST[id]'");
	header("Location:sms_template_manage.php");
}
?>
