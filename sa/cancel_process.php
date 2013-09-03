<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
		
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	$dt = date('Y-m-d');
	$comm = mysql_real_escape_string($_REQUEST[comment]);
	
	$string="dated='$_REQUEST[dated]',student_id='$_REQUEST[student]',course_id='$_REQUEST[course_id]',centre_id='$_SESSION[centre_id]',comment='$comm',cd_status='Pending',admin_status='Pending',created_date='$dt',created_by='$_SESSION[id]'";
	$dbf->insertSet("student_cancel",$string);
	
	//==========================================================
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != ''){		
		$string_move="student_id='$_REQUEST[student]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
	}
	//==========================================================
	
	$student_id = $_REQUEST['student'];
	$course_id = $_REQUEST['course_id'];
	$stu = $dbf->strRecordID("student",'*',"id='$student_id'");
	$enroll = $dbf->strRecordID("student_enroll",'*',"student_id='$student_id' And course_id='$course_id'");
	$course = $dbf->strRecordID("course",'*',"id='$course_id'");
	$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
	
	$course_fee = $course_fees;
	$discount = $enroll["discount"];
	$other_amt = $enroll["other_amt"];
	
	$en_amt = $course_fee - $discount;
	$course_fee_final = $en_amt + $other_amt;
	
	$fee = $dbf->strRecordID("student_fees",'SUM(paid_amt)',"student_id='$student_id' And course_id='$course_id'");
	$paid_amt = $fee["SUM(paid_amt)"];
	$bal_amt = $course_fee_final - $paid_amt;
	
	// Start Mail to Centre Director
	//Get teacher email id
	$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
	$to = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$cd = $dbf->getDataFromTable("user","user_name","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$teacher = $dbf->getDataFromTable("user","user_name","id='$_SESSION[id]'");
	?>
    <style>
	.mycon{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-weight:normal;
	font-size:12px;
	}
	.shop1{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
	color:#204B9A;
	padding-left:2px;
	font-weight:bold;
	}
	</style>
    <?php
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='5'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%cd%',$cd,$email_msg);
	
	$body1='<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
	  <tr>
		<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#6a81b1;font-weight:bold;padding-left:45px;">'.$email_msg.'</td>
	  </tr>
	  <tr>
		<td height="30" align="center" valign="top">        
        <table width="250" border="1" cellspacing="0" cellpadding="0" bordercolor="#9999FF" style="border-collapse:collapse;">
          <tr>
            <td width="54%" height="20" align="right" valign="middle" class="mycon">Student Name : &nbsp;</td>
            <td width="46%" align="left" valign="middle" class="shop2">&nbsp;'.$stu["first_name"].'</td>
          </tr>
          <tr>
            <td width="54%" height="20" align="right" valign="middle" class="mycon">Course : &nbsp;</td>
            <td width="46%" align="left" valign="middle" class="shop2">&nbsp;'.$course["name"].'</td>
          </tr>
          <tr class="mycon">
            <td colspan="2" align="center" valign="middle"><u class="mymenutext">Payment Details</u> &nbsp;</td>
          </tr>
          <tr>
            <td width="54%" align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
            <td width="46%" align="left" valign="middle" bgcolor="#999999" class="shop2">&nbsp;'.$course_fee.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Discount (-) : &nbsp;</td>
            <td align="left" valign="middle" class="shop2">&nbsp;'.$discount.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Enrollment Amount : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFF99" class="shop2">&nbsp;'.$en_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Other Amount : &nbsp;</td>
            <td align="left" valign="middle" class="shop2">&nbsp;'.$other_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#9D9DFF" class="shop2">&nbsp;'.$course_fee_final.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Paid Amount : &nbsp;</td>
            <td align="left" valign="middle" class="shop2" >&nbsp;'.$paid_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Balance Amount : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#006699" class="logintext" >&nbsp;'.$bal_amt.'</td>
          </tr>
        </table>        
        </td>
	  </tr>
	  <tr>
	    <td align="right" valign="middle">&nbsp;</td>
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
	$subject = str_replace('%username%',$from_name,$subj);
	
	//$subject ="Cancellation request from ".$teacher;
	mail($to,$subject,$body1,$headers);
	// End Mail
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	//Start Save Mail
	$string="dated='$dt',user_id='$_SESSION[id]',msg='$body1',comment='$comment',send_to='Centre Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Student Advisor for Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);	
	// End Save Mail
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	$mobile_no = '';
	$is_enable = $dbf->countRows("sms_gateway","*","status='Enable'");
	if($is_enable > 0){
		//Start Sending SMS if student is going RE-ENROLLMENT
		$mobile_no = '';
		foreach($dbf->fetchOrder('user',"(user_type='Center Director' OR user_type='Student Advisor') And center_id='$_SESSION[centre_id]'","") as $cd_sa){
			if($cd_sa["mobile"]){
				if($mobile_no == ''){
					$mobile_no = $cd["mobile"];
				}else{
					$mobile_no = $mobile_no.','.$cd["mobile"];
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
			//$msg = $stu["first_name"]." is applying for cancellaion of class";
			//$msg = "%first_name% is applying for cancellaion of class";
			$sms = $_REQUEST['sms'];
			if($sms == "1" || $sms == "3"){
				if($sms == "1"){
					$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='33'");
				}else if($sms == "3"){
					$sms_cont = $_REQUEST['contents'];
				}
				$msg = str_replace('%first_name%',$stu["first_name"],$sms_cont);
				
				$Message = $msg;
			
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
	
	header("Location:cancel_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_cancel","id='$_REQUEST[cancel_id]'");
	header("Location:cancel_manage.php");
}
?>
