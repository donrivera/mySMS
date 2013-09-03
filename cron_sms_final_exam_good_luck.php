<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
if($is_enable == 0){
	exit;
}

$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
$today = date('Y-m-d');

// Loop each course_fees structure (fee = Today)
// Then fired the SMS to All Students for BEST of Luck
$today = date('Y-m-d');

foreach($dbf->fetchOrder('student_group',"id>'0'","") as $group){
	
	$group_day = $group["end_date"];
	$lastday = date('Y-m-d',strtotime(date("Y-m-d", strtotime($group_day)) . "-1 day"));
	if($today == $lastday){
		
		$mobile_no = '';
		
		foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$group[id]'","") as $groupdtls){
			
			//Get student details
			$student_mobile = $dbf->strRecordID("student","*","id='$groupdtls[student_id]' And sms_status='0'");
			
			if($student_mobile["student_mobile"] != ''){
					
				if($mobile_no == ''){
					$mobile_no = $student_mobile["student_mobile"];
				}else{
					$mobile_no = $mobile_no.','.$student_mobile["student_mobile"];
				}
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
			$msg = $dbf->getDataFromTable("sms_templete","contents","id='17'");
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');
			
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='student',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);
			
			foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$group[id]'","") as $val_course)
			{	
				$string1="parent_id='$sms_id',student_id='$val_course[student_id]'";
				$dbf->insertSet("sms_history_dtls",$string1);	
			}			
			//================================
			//SAVED SMS
			//================================
		}			
	}	
}	
?>