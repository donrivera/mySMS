<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='transfer'){

	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	$reg_dt = date('Y-m-d');
	
	$student_id = $_REQUEST["student_id"];
	$tostudent_id = $_REQUEST["tostudent_id"];
	
	$string="dated='$_REQUEST[dated]',from_id='$_REQUEST[from_id]',to_id='$_REQUEST[to_id]',from_course_id='$_REQUEST[from_course_id]',to_course_id='$_REQUEST[to_course_id]',from_status_id='$_REQUEST[from_status]',to_status_id='$_REQUEST[to_status]',centre_id='$_SESSION[centre_id]',created_by='$_SESSION[id]',created_date='$reg_dt',status='Pending',comment='$comm',student_id='$student_id',to_student_id='$tostudent_id'";
	$parent_id = $dbf->insertSet("transfer_student_to_student",$string);
	
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');	
	if($comm != ''){
		$string_move="student_id='$student_id',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
		
		$string_move="student_id='$tostudent_id',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
	}
		
	//Mail
	//Get teacher email id
	$userfrom = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
	$from = $userfrom["email"];
	
	$userto = $dbf->strRecordID("user","*","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$to = $userto["email"];
	
	$mobile_no = $userto["mobile"];
	
	$cd = $userto["user_name"];
	$teacher = $userfrom["user_name"];
	
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='9'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%cd%',$cd,$email_msg);
	
	$body1='<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
	  <tr>
		<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a81b1;font-weight:normal;padding-left:25px;">'.$email_msg.'</td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle">&nbsp;</td>
	  </tr>
	  <tr>
		<td align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:50px;">Thanks</td>
	  </tr>
	  <tr>
		<td height="30" align="right" valign="middle" class="nametext" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:28px;">'.$teacher.'</td>
	  </tr>
	  <tr>
		<td align="center" valign="top">&nbsp;</td>
	  </tr>
	</table>';	
		
	$subj = $email_cont["title"];
	$subject = str_replace('%teacher%',$teacher,$subj);
	
	//$subject ="Request for transfer from (SA) ".$teacher;
	mail($to,$subject,$body1,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	//SMS
	if($dbf->countRows("sms_gateway","status='Enable'") > 0){
		
		$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
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
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='37'");
			$msg = str_replace('%teacher%',$teacher,$sms_cont);
			
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');
			
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='SA to CD',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("sms_history",$string);
			//================================
			//SAVED SMS
			//================================
		}
	}	
	header("Location:student_to_student_manage.php");
	exit;
}
if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("transfer_student_to_student","id='$_REQUEST[del_id]'");
	$dbf->deleteFromTable("transfer_student_to_student_dtls","parent_id='$_REQUEST[del_id]'");
	
	header("Location:student_to_student_manage.php");
	exit;
}
?>
