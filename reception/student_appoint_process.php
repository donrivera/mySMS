<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="dated='$_POST[date2]',student_id='$_POST[student]',comments='$_POST[comment]',entry_date='$cr_date',user_id='$_SESSION[id]',status='1',centre_id='$_SESSION[centre_id]'";
	$dbf->insertSet("student_appointment",$string);
	
	$student = $dbf->strRecordID("student","first_name","id='$_REQUEST[student]'");
	
	$mobile_no = $dbf->getDataFromTable("user","mobile","user_type='Student Advisor' And center_id='$_SESSION[centre_id]'");
	if($mobile_no != ''){
		
		// Your username
		$UserName=UrlEncoding($sms_gateway[user]);
		
		// Your password
		$UserPassword=UrlEncoding($sms_gateway[password]);
		
		// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
		//$Numbers=UrlEncoding("966000000000,966111111111");
		$Numbers=UrlEncoding($mobile_no);
		
		// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
		$Originator=UrlEncoding($sms_gateway[your_name]);
		
		// Your Message in English or arabic or both.
		// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
		//$msg = $student["first_name"]." have a Appointment on ".$_REQUEST["date"];
		$sms = $_REQUEST['sms'];
		if($sms == "1" || $sms == "3"){
			if($sms == "1"){
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='32'");
			}else if($sms == "3"){
				echo $sms_cont = $_REQUEST['contents'];
			}
			$sms_cont = str_replace('%first_name%',$teacher,$sms_cont);
			$msg = str_replace('%date%',$teacher,$sms_cont);
			$Message = $msg;
			
			$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
			if($is_enable > 0){
				
				//Get configuration of the SMS
				$res_sms = $dbf->strRecordID("sms_gateway","*","status='Enable'");
				
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				
				//================================
				//SAVED SMS
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="dated='$cr_date',user_id='1',msg='$msg',send_to='SA',mobile=$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("sms_history",$string);	
				//================================
				//SAVED SMS			
			}
		}
	}	
	
	header("Location:student_appoint_add.php?msg=added");
}


if($_REQUEST['action']=='edit'){
	
	$string="dated='$_POST[date]',student_id='$_POST[student]',comments='$_POST[comment]',user_id='$_SESSION[id]'";
	$dbf->updateTable("student_appointment",$string,"id='$_REQUEST[id]'");
	
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_appointment","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action']=='block'){
	$dbf->updateTable("student_appointment","status=0","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}

if($_REQUEST['action']=='unblock'){
	$dbf->updateTable("student_appointment","status=1","id='$_REQUEST[id]'");
	header("Location:student_appoint_manage.php");
}
?>
