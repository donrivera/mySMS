<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
if($is_enable == 0){
	exit;
}

// Loop each fees structure (fee = Today)
// Then fired the SMS to All Students whose payment date is equal to today
$today = date('Y-m-d');
$today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . "-5 day"));

foreach($dbf->fetchOrder('student_fees',"fee_date='$today' And status='0'","","","") as $group){
	
	//Get student mobile number
	$student_mobile = $dbf->strRecordID("student","*","id='$group[student_id]' And sms_status='1'");
	$course = $dbf->strRecordID("course","*","id='$group[course_id]'");
	
	if($student_mobile["student_mobile"] != ''){
		
		$mobile_no = $student_mobile["student_mobile"];
		
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
		//$msg = "Dear ".$student_mobile["first_name"].", your payment of ".$group["fee_amt"]." for Berlitz ".$course["name"]." is 5 days past due. Please expedite payment.";
			
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='20'");
		$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
		$sms_cont = str_replace('%fee_amt%',$group["fee_amt"],$sms_cont);
		$msg = str_replace('%course_name%',$course["name"],$sms_cont);
		$Message=$msg;
		
		// Storing Sending result in a Variable.
		SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
		
		//================================
		//SAVED SMS
		//================================
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="dated='$cr_date',user_id='0',msg='$msg',send_to='student',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$sms_id = $dbf->insertSet("sms_history",$string);
		
		$string1="parent_id='$sms_id',student_id='$group[student_id]'";
		$dbf->insertSet("sms_history_dtls",$string1);
		//================================
		//SAVED SMS
		//================================
	}
}
?>