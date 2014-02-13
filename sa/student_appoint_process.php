<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");
//Object initialization
$student_id=$_POST['student'];
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d H:i:s ');
		
	$string="dated='$_POST[date]',student_id='$_POST[student]',comments='$_POST[comment]',user_id='$_SESSION[id]',entry_date='$cr_date',centre_id='$_SESSION[centre_id]'";
	$dbf->insertSet("student_appointment",$string);
	$string2="student_id='$_POST[student]',user_id='$_SESSION[id]',comments='$_POST[comment]',date_time='$cr_date'";
	$dbf->insertSet("student_comment",$string2);
	#SMS
	$mobile_no = $dbf->getDataFromTable("student","student_mobile","sms_status='1' And id='$_POST[student]'");
	$student_mobile=$dbf->strRecordID("student","first_name","id='$student_id'");
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	if($mobile_no != '')
	{
		
		$UserName=UrlEncoding($sms_gateway['user']);
		$UserPassword=UrlEncoding($sms_gateway['password']);
		$Numbers=UrlEncoding($mobile_no);
		$Originator=UrlEncoding($sms_gateway['your_name']);
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='32'");
		$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
		$msg = str_replace('%date%',$_POST['date'],$sms_cont);
		$Message=$msg;
		if($sms_gateway["status"]=='Enable')
		{
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			$cr_date = date('Y-m-d H:i:s A');
			$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$msg',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding Student Advisor (Search)',mobile='$mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);
			$string1="parent_id='$sms_id',student_id='$student_id'";
			$dbf->insertSet("sms_history_dtls",$string1);
		}
	}
	#SMS
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
