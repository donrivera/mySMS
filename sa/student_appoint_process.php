<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d H:i:s ');
		
	$string="dated='$_POST[date]',student_id='$_POST[student]',comments='$_POST[comment]',user_id='$_SESSION[id]',entry_date='$cr_date',centre_id='$_SESSION[centre_id]'";
	$dbf->insertSet("student_appointment",$string);
	
	header("Location:student_appoint_add.php?msg=added");
}


if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s ');
	
	$string="dated='$_POST[date]',student_id='$_POST[student]',comments='$_POST[comment]',user_id='$_SESSION[id]',entry_date='$cr_date'";
	$dbf->updateTable("student_appointment",$string,"id='$_REQUEST[id]'");
	
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("student_appointment","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}


if($_REQUEST['action']=='block')
{
	$dbf->updateTable("student_appointment","status=1","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action']=='unblock')
{
	$dbf->updateTable("student_appointment","status=0","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action'] == 'setstatus'){

	if($dbf->countRows("student_appointment","id='$_REQUEST[aid]' And action_status='1'") > 0){
		$dbf->updateTable("student_appointment","action_status='0'","id='$_REQUEST[aid]'");
	}else{
		$dbf->updateTable("student_appointment","action_status='1'","id='$_REQUEST[aid]'");
	}
	header("Location:student_appoint_manage.php");
	exit;
}
?>
