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
$today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . "-3 day"));

foreach($dbf->fetchOrder('student_group',"status='Completed' And completed_date<>'0000-00-00'","","","") as $group){
	if($today == $group["completed_date"]){
		//Get teacher email id
		$from = $dbf->getDataFromTable("teacher","email","id='$group[teacher_id]'");
		$to = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$group[centre_id]'");
		$cd = $dbf->getDataFromTable("user","user_name","user_type='Center Director' And center_id='$group[centre_id]'");
		$teacher = $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");
		
		$email_cont = $dbf->strRecordID("email_templetes","*","id='1'");
		$email_msg = $email_cont["content"];
		
		$email_msg = str_replace('%cd%',$cd,$email_msg);
		$email_msg = str_replace('%teacher%',$teacher,$email_msg);
				
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From:".$from."\n";
		
		$body1='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; 

border-color:#FFCC00;">
		  <tr>
			<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img 

src="'.$res_logo[name].'" width="105" height="30" /></td>
		  </tr>
		  <tr>
		    <td align="left" valign="middle">&nbsp;</td>
  		  </tr>
		  <tr>
			<td height="50" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; 

font-size:12px; font-weight:normal; color:#999999; padding-left:5px;">'.$email_msg.'</td>
		  </tr>		  
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>';	
		
		$subject = $email_cont["title"];
		mail($to,$subject,$body1,$headers);
		
		//============
		// SMS
		//============
		$mobile_no = $dbf->getDataFromTable("user","mobile","user_type='Center Director' And 

center_id='$group[centre_id]'");
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
			// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 

Credit.
			//$msg = $teacher." has been completed his course before 3 days. So you have to printing the certificate for the students";
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='13'");
			$msg = str_replace('%teacher%',$teacher,$sms_cont);
			
			$Message = $msg;
			
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
				

$string="dated='$cr_date',user_id='1',msg='$msg',send_to='CD',mobile=$mobile_no',centre_id='$group[centre_id]',msg_from='CRON'

,automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$sms_id = $dbf->insertSet("sms_history",$string);				
				//================================
				//SAVED SMS
				//================================				
			}
		}
	}
}
?>