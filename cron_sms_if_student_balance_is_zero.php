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

// Loop each course_fees structure (fee = Today)
// Then fired the SMS to All Students whose payment date is equal to today
$today = date('Y-m-d');
foreach($dbf->fetchOrder('student_enroll',"balance_status_for_sms='0'","") as $group){
	
	//Get student details
	$student_mobile = $dbf->strRecordID("student","*","id='$group[student_id]' And sms_status='0'");
	
	//Check whether balance is zero or not
	// ================
	$course = $dbf->strRecordID("course_fee","*","id='$group[fee_id]'");
	
	$course_fee = $course["fees"]; 				// 1000
	$en_amt = $course_fee - $group["discount"]; // 1000 - 200 = 800
	$en_amt = $en_amt + $group["other_amt"]; 	// 800 + 200 = 1000
		
	//Get from the fees structure as student_fee Table
	$student_paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$group[student_id]' And course_id='$group[course_id]' and status='1'");
	$paid_amt = $paid_amt + $student_paid["SUM(paid_amt)"]; // 500
	
	$bal_amt = $en_amt - $paid_amt;				// 500 - 500 = 0
	
	// ================
	if($bal_amt == 0){
		if($student_mobile["student_mobile"] != ''){
			
			if($mobile_no == ''){
				$mobile_no = $student_mobile["student_mobile"];
			}else{
				$mobile_no = $mobile_no.','.$student_mobile["student_mobile"];
			}			
			//Update the balance_status_for_sms columns in student_enroll for already sms has been sent.
			$dbf->updateTable("student_enroll","balance_status_for_sms='1'","student_id='$group[student_id]' And course_id='$group[course_id]'");
		}
	}
		
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
		//$msg = "Dear ".$student_mobile["first_name"].", your payment of ".$group["fee_amt"]." for Berlitz ".$course["name"]." is due today. Please expedite payment.";
		
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='18'");
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
		
		$string1="parent_id='$sms_id',student_id='$student_mobile[id]'";
		$dbf->insertSet("sms_history_dtls",$string1);
		//================================
		//SAVED SMS
		//================================
	}
	
}
	
	
?>