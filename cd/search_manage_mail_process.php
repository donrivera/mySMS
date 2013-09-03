<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

$mobile_no = '';
$student_id = $_REQUEST['student_id'];
//============
// SMS
//============
$mobile_no = $dbf->getDataFromTable("student","student_mobile","id='$student_id' And sms_status='1'");

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
	
	$sms = $_REQUEST['sms'];
	if($sms == "1" || $sms == "3"){
		if($sms == "1"){
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
		}else if($sms == "3"){
			$sms_cont = $_REQUEST['contents'];
		}
		$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
		$msg = str_replace('%ad_amt%',$_REQUEST["ad_amt"],$sms_cont);
		
		$Message=$msg;
	
		// Storing Sending result in a Variable.
		if($sms_gateway["status"]=='Enable'){
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			$cr_date = date('Y-m-d H:i:s A');
			$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Student',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='Centre Director (For Payment)',mobile='$mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);
			
			$string1="parent_id='$sms_id',student_id='$student_id'";
			$dbf->insertSet("sms_history_dtls",$string1);
		}
	}
}
header("Location:search_manage.php?student_id=$student_id");
exit;
?>
