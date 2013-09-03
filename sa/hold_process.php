<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
		
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	$dt = date('Y-m-d');
	$comment = mysql_real_escape_string($_REQUEST[comment]);
	
	$string="dated='$_REQUEST[dated]',student_id='$_REQUEST[student]',course_id='$_REQUEST[course_id]',centre_id='$_SESSION[centre_id]',comment='$comment',cd_status='Pending',created_date='$dt',created_by='$_SESSION[id]'";
	$dbf->insertSet("student_hold",$string);
	
	if($comment != ''){
		$dt1 = date('Y-m-d H:i:s A');
		$string_comments="student_id='$_REQUEST[student]',user_id='$_SESSION[id]',comments='$comment',date_time='$dt1'";
		$dbf->insertSet("student_comment",$string_comments);
	}
	
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
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='10'");
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
	$subject = str_replace('%username%',$teacher,$email_msg);
	
	//$subject ="Student on-hold request from ".$teacher;
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
		
	header("Location:hold_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_hold","id='$_REQUEST[hold_id]'");
	header("Location:hold_manage.php");
}
?>
