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
$course_id= $_REQUEST['course_id'];
//============
// SMS
//============
$mobile_no = $dbf->getDataFromTable("student","student_mobile","sms_status='1' And id='$student_id'");
$amt=$dbf->getDataFromTable("student_fees","paid_amt","course_id='$course_id' AND id='$student_id' AND type='opening'");
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
	
	//$msg = "You have paid ".$amt." for initial payment";
	$sms = $_REQUEST['sms'];
	if($sms == "1" || $sms == "3"){
		if($sms == "1")
		{
			$balance=$dbf->BalanceAmount($student_id, $course_id);
			if($balance==0)
			{$template_id=44;}
			else
			{$template_id=34;}
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='$template_id'");
		}
		else if($sms == "3")
		{
			$sms_cont = $_REQUEST['contents'];
		}
		switch($template_id)
		{
			case '44':	{
							$student_grp=$dbf->genericQuery("	SELECT g.group_name
																FROM student_group g
																INNER JOIN student_group_dtls sgd ON sgd.parent_id = g.id
																WHERE sgd.student_id ='$student_id' AND sgd.course_id ='$course_id'");
							foreach($student_grp as $sdt_grp):echo$sdt_grp_nme=$sdt_grp['group_name'];endforeach;
							$msg = str_replace('%course_name%',$sdt_grp_nme,$sms_cont);
						}break;
			default:	{
							//$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
							$msg = str_replace('%amount%',$_REQUEST["amt"],$sms_cont);
						}break;
		}
		//$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
		//$msg = str_replace('%amount%',$amt,$sms_cont);
		$Message=$msg;
	
		// Storing Sending result in a Variable.
		if($sms_gateway["status"]=='Enable'){
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
		
			$cr_date = date('Y-m-d H:i:s A');
			$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$msg',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding Student Advisor (Search)',mobile='$mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
			$sms_id = $dbf->insertSet("sms_history",$string);
			
			$string1="parent_id='$sms_id',student_id='$student_id'";
			$dbf->insertSet("sms_history_dtls",$string1);
		}
	}
}
header("Location:search_manage.php?student_id=$student_id&course_id=$course_id");
exit;
?>
