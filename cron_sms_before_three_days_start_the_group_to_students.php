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

$mobile_no = '';

// Loop each group (status = Not Started, start_date <> '', start_date -3 days
// If today date = completed_date -3 days
// Then fired the SMS to All Students who belongs to that group

$today = date('Y-m-d');

foreach($dbf->fetchOrder('student_group',"status='Not Started' And start_date<>'0000-00-00'","","","") as $group){
			
	// (-) minus 3 days according to 
	$startdate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($group[start_date])) . "-3 day"));
	
	if($today == $startdate){						
		//Original start date of the group
		$st_date = $group[start_date];
		
		//Loops start (Get all students belongs to that group)
		foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$group[id]'","","","") as $groupdtls)
		{			
			//Get student mobile number
			$student_mobile = $dbf->strRecordID("student","student_mobile","id='$groupdtls[student_id]' And sms_status='1'");
			
			if($student_mobile["student_mobile"] != ''){
				if($mobile_no == ''){
					$mobile_no = $student_mobile["student_mobile"];
				}else{
					$mobile_no = $mobile_no.",".$student_mobile["student_mobile"];
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
			//$msg = "Your course will be starting from ".$st_date;
			
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
			$msg = str_replace('%date%',$st_date,$sms_cont);
			
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');
			
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='student',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);
			
			foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$group[id]'","","","") as $val_course)
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