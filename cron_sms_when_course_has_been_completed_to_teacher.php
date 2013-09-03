<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

$mobile_no = '';

// Loop each group (status = Completed, completed_date <> '', completed_date +3 days
// If today date = completed_date +3 days
// Then fired the mail to Centre director from Teacher

$today = date('Y-m-d');

foreach($dbf->fetchOrder('student_group',"status='Completed' And completed_date<>'0000-00-00'","","","") as $group){
	if($today == $group["completed_date"]){
		//Get teacher email id
		$teacher_mobile = $dbf->getDataFromTable("teacher","mobile","id='$group[teacher_id]'");
		$sa_mobile = $dbf->getDataFromTable("user","mobile","user_type='Student Advisor' And center_id='$group[centre_id]'");
		$teacher = $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");
		
		if($teacher_mobile != '' && $sa_mobile != ''){
			$mobile_no = $teacher_mobile.','.$sa_mobile;
		}else if($teacher_mobile != '' && $sa_mobile == ''){
			$mobile_no = $teacher_mobile;
		}else if($teacher_mobile == '' && $sa_mobile != ''){
			$mobile_no = $$sa_mobile;
		}
		//============
		// SMS
		//============
		$mobile_no = $dbf->getDataFromTable("user","mobile","user_type='Center Director' And center_id='$group[centre_id]'");
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
			//$msg = $teacher." has been completed the course so have to printing the certificate for the students";
			
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='22'");
			$msg = str_replace('%teacher%',$teacher,$sms_cont);
			
			$Message=$msg;
			
			$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
			if($is_enable > 0){
				
				//Get configuration of the SMS
				$res_sms = $dbf->strRecordID("sms_gateway","*","status='Enable'");
				
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				
				//================================
				//SAVED SMS
				//================================
				$cr_date = date('Y-m-d H:i:s A');				
				$string="dated='$cr_date',user_id='1',msg='$msg',send_to='Teacher and SA',mobile=$mobile_no',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$sms_id = $dbf->insertSet("sms_history",$string);					
				//================================
				//SAVED SMS
				//================================				
			}
		}
	}
}
?>
