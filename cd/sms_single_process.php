<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
if($res_sms[status] != ''){
	header("Location:single_sms.php?student_id=$_REQUEST[student_id]&msg=block");
	exit;
}

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

$student_mobile_no = $_REQUEST['mobile'];


//SMS details saved in Table
//==============================================================
$cr_date = date('Y-m-d H:i:s A');

$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[msg]',send_to='student',mobile='$_POST[mobile]',msg_from='Admin',page_full_path='$_SERVER[REQUEST_URI]'";
$ids = $dbf->insertSet("sms_history",$string);
	
$string1="parent_id='$ids',student_id='$_REQUEST[student_id]'";
$dbf->insertSet("sms_history_dtls",$string1);

//===================================================================
/////////////////////////////////////////////////////////////////////////
//    This is how to get your credits.
/////////////////////////////////////////////////////////////////////////
// Your username
//$UserName=UrlEncoding("demo");
// Your password
//$UserPassword=UrlEncoding("test");
// Storing your credits in a Variable.
//$MyCredits = GetCredits($UserName,$UserPassword);

/////////////////////////////////////////////////////////////////////////
//    This is how to Send SMS.
/////////////////////////////////////////////////////////////////////////
// Your username
$UserName=UrlEncoding($sms_gateway[user]);

// Your password
$UserPassword=UrlEncoding($sms_gateway[password]);

// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
//$Numbers=UrlEncoding("966000000000,966111111111");
$Numbers=UrlEncoding($student_mobile_no);

// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
$Originator=UrlEncoding($sms_gateway[your_name]);

// Your Message in English or arabic or both.
// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.

//Assign text Message to $Message variable
$Message = $_REQUEST[textarea];

// Storing Sending result in a Variable.
$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
	if($is_enable > 0){
		$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
	}else{
		$SendingResult = "SMS API disable by Administrator";
	}
header("Location:sms_single.php?student_id=$_REQUEST[student_id]&msg=$SendingResult");
exit;
?>