<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");

$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
if($is_enable == 0){
	exit;
}

// Loop each group
// SMS to All Teacher whose course has been finished 50% completed

foreach($dbf->fetchOrder('student_group',"","","","") as $group){
	
	//To Get Orginal Unit
	$course_unit = $dbf->strRecordID("group_size","","group_id='$group[group_id]'");
	
	//To Get 50% of Unit
	$unit = $course_unit["units"]/2;
	  
	//Get no.of unit completed
    $num_cnt_unt = $dbf->countRows('ped_unit',"group_id='$group[id]'");	
	
	//To Get Mobile no. of Teacher
	$teacher_mob = $dbf->strRecordID("teacher","*","id=$group[teacher_id]");
	$mobile_no = $teacher_mob["mobile"];
	
	//Get The Course Name
    $course = $dbf->strRecordID("course","*","id=$group[course_id]");
	$course_name = $course["name"];
	
	 if($unit==$num_cnt_unt){
		 
		// Your username
		$UserName=UrlEncoding($sms_gateway[user]);
		
		// Your password
		$UserPassword=UrlEncoding($sms_gateway[password]);
		
		// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
		//$Numbers=UrlEncoding("966000000000,966111111111");
		$Numbers=UrlEncoding($mobile_no);
		
		// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
		$Originator=UrlEncoding($sms_gateway["your_name"]);
		
		// Your Message in English or arabic or both.
		// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
		//$msg = "The Course ".$course_name." is 50% Completed. Please filled up the Progress Report";
		
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='14'");
		$msg = str_replace('%course_name%',$course_name,$sms_cont);
		$Message=$msg;
		
		# Check whether SMS has been sent to Teacher of a particular group or not
		# If Zero means there are no SMS has been sent to Teacher of a particular group
		$is_sms_cron = $dbf->countRows("student_group", "is_sms_cron='0'");
		if($is_sms_cron > 0){
		
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');		
			$string="dated='$cr_date',user_id='1',msg='$msg',send_to='Teacher',mobile=$mobile_no',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);			
			//================================
			//SAVED SMS
			//================================
			
			//Update in student_group that SMS has been sent
			$dbf->updateTable("student_group", "is_sms_cron='1'", "id='$group[id]'");
		}
		
	 }
}
?>