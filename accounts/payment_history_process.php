<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();
  
if($_REQUEST['action']=='edit_payment'){
	
	$student_id = $_REQUEST["student_id"];
	$course_id = $_REQUEST["course_id"];
	$fee_id = $_REQUEST["fee_id"];

	$amts = $_REQUEST["amts"];
	
	$prev_pay = $dbf->strRecordID("student_fees","*","id='$fee_id'");
	$paid_amt = $prev_pay[paid_amt];
	
	//Update in Fees Table		
	$string="paid_amt='$_REQUEST[amts]',fee_amt='$_REQUEST[amts]',payment_type='$_REQUEST[payment_type]'";
	$dbf->updateTable("student_fees",$string,"id='$fee_id'");
	//=====================================================================
	
	//Date and Time
	$dt = date('Y-m-d h:m:s');
	
	//Comment or Message
	$comments = mysql_real_escape_string($_REQUEST[msg]);
	
	//insert query here
	if($comments != ''){
		$string="student_id='$_REQUEST[student_id]',user_id='$_SESSION[id]',comments='$comments',date_time='$dt'";	
		$dbf->insertSet("student_comment",$string);
	}
	
	$student = $dbf->strRecordID("student","*","id='$student_id'");
		
	//Checked whether Previous record match with current record or not
	if($paid_amt != $amts){	
				
		//Mail to Student Advisor / Centre Director from Accountant
		//For changing the Price
		//Get teacher email id
		$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
		$from_name = $dbf->getDataFromTable("user","user_name","id='$_SESSION[id]'");
		
		//Get LOGO
		$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
		
		$to_cd = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
		$to_sa = $dbf->getDataFromTable("user","email","user_type='Student Advisor' And center_id='$_SESSION[centre_id]'");
		
		$to = $to_sa.",".$to_cd;
		
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From:".$from."\n";
		
		$email_cont = $dbf->strRecordID("email_templetes","*","id='7'");
		$email_msg = $email_cont["content"];
				
		$body1='<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
		  <tr>
			<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
		  </tr>
		  <tr>
			<td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a81b1;padding-left:55px;">'.$email_msg.'</td>
		  </tr>
		  <tr>
			<td height="30" align="center" valign="middle">
            <table width="70%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#CC9900">
			  <tr valign="middle">
			    <td height="25" colspan="2" align="center" valign="middle"  style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#369;font-weight:bold;">Changed Details</td>
		      </tr>
			  <tr valign="middle">
			    <td width="42%" height="25" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#960;font-weight:bold;">Student Name :</td>
			    <td width="58%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#960;font-weight:bold;">'.$student[first_name].'</td>
		      </tr>
			  <tr valign="middle">
			    <td height="25" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#960;font-weight:bold;">Previous Fee :</td>
			    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#960;font-weight:bold;">'.$paid_amt.'</td>
		      </tr>
			  <tr>
			    <td height="25" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#960;font-weight:bold;">Current Fee :</td>
			    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#960;font-weight:bold;">'.$amts.'</td>
		      </tr>
		    </table></td>
		  </tr>
		  <tr>
			<td height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:50px;">Thanks</td>
		  </tr>
		  <tr>
			<td height="30" align="right" valign="middle" class="nametext" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:28px;">Administrator</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>';	
		
		//$subject ="Payment has been changed by Accountant";
		$subject = $email_cont["title"];
		mail($to,$subject,$body1,$headers);
		
		//Start Save Mail
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='CD and SA',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='$subject',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
	}
	
	header("Location:payment_history.php?centre_id=$_REQUEST[centre_id]");
	exit;
}
?>
