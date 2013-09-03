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

foreach($dbf->fetchOrder('teacher_vacation',"","","","") as $vac){
			
	// (-) minus 3 days according to
	if($vac["no_days"] <= 3){
		$startdate = $vac["tto"];
	}else{
		$startdate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($vac["tto"])) . "-3 day"));
	}
	if($today == $startdate){
				
		$teacher = $dbf->strRecordID("teacher","*","id='$vac[teacher_id]'");
		
		//Start Sending SMS if student is going RE-ENROLLMENT
		$mobile_no = '';
		foreach($dbf->fetchOrder('teacher_centre',"teacher_id='$vac[teacher_id]'","") as $tv){
			foreach($dbf->fetchOrder('user',"(user_type='Center Director' OR user_type='Student Advisor') And center_id='$tv[centre_id]'","") as $cd_sa){
				if($cd_sa["mobile"]){
					if($mobile_no == ''){
						$mobile_no = $cd["mobile"];
					}else{
						$mobile_no = $mobile_no.','.$cd["mobile"];
					}
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
			//$msg = $teacher["name"]." will be available on tommorrow";
			
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='15'");
			$msg = str_replace('%teacher%',$teacher["name"],$sms_cont);
			
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');			
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD And SA',mobile='CRON - SMS',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("sms_history",$string);
			//================================
			//SAVED SMS
			//================================
		}
	}
}
?>