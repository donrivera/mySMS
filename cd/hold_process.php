<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='update'){
		
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	$dt = date('Y-m-d');
	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	
	$string="cd_dated='$_REQUEST[dated]',cd_comment='$comm',cd_status='$_REQUEST[status]'";
	$dbf->updateTable("student_hold",$string,"id='$_REQUEST[cancel_id]'");
	
	//==========================================================
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != ''){
		$ids = $dbf->getDataFromTable("student_hold", "student_id", "id='$_REQUEST[cancel_id]'");
		
		$string_move="student_id='$ids',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
	}
	//==========================================================
	
	$stu_cancel = $dbf->strRecordID("student_hold",'*',"id='$_REQUEST[cancel_id]'");
		
	$student_id = $stu_cancel['student_id'];
	$course_id = $stu_cancel['course_id'];	
	$centre_id = $stu_cancel["centre_id"];
	
	//Get group id
	$groupdtls = $dbf->strRecordID("student_enroll","group_id","student_id='$student_id' And course_id='$course_id'");
	$group = $groupdtls["group_id"];
	
	//Resize if Approved here
	if($_REQUEST["status"] == 'Approved'){
		
		//Previous group id
		$prev_group_id = $dbf->getDataFromTable("student_group","group_id","id='$group'");
		
		# update in the student_enroll table for Hold
		# 6 = Status in the database
		$string="status_id='6'";
		$dbf->updateTable("student_enroll",$string,"student_id='$student_id' And course_id='$course_id'");
		
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		//=======================================================
		$string_st="status_id='6'"; //Cancal Status
		$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
		
		//Moving History table
		$date_time = date('Y-m-d H:i:s A');
			
		$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='6'";
		$dbf->insertSet("student_moving_history",$string2);			
		//=======================================================
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		
		//Delete from student_group_dtls table
		$dbf->deleteFromTable("student_group_dtls","parent_id='$group' AND student_id='$student_id' And course_id='$course_id'");
					
		//Get number of student recently removed
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		
		//Get the range from (group_size) Table
		$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
		if($prev_num_student == 0){
			$my_group_id = 0;
		}else{
			$my_group_id = $sizegroup["group_id"];
		}
		//update the Group ID to Student_group Table means we can get the student according to group_id
		
		$string_g="group_id='$my_group_id'";
		$dbf->updateTable("student_group",$string_g,"id='$group'");
		
		//update the Group ID to student_group_dtls Table means we can get the student according to parent_id
		$string_g1="group_id='$my_group_id'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
			
		//Calculate And Previous group update here
		//========================================		
		//Original Unit of the Current Group => 80
		$curr_original_unit = $group["units"];
				
		//Finished unit of the Current Group => (0.1429 * 70) => 11.43
		$curr_finished_unit = round($dec_point_finish * $curr_original_unit,2);
		
		//Pending unit of the Currect Group => (80 - 11.43) => 68.57
		$curr_pending_unit = $curr_original_unit - $curr_finished_unit;
		
		//Get the value decimal point (68.57) => 68
		$dec_right_value = substr($curr_pending_unit,0,2);
		
		//Check Odd or Even Number
		if ($dec_right_value % 2 == 0){
			//echo "number is even";
			$dec_right_value_is = substr($curr_pending_unit,0,2); // 18.66 => 18
		}else{
			//echo "number is odd";
			$dec_right_value_is = ceil($curr_pending_unit); // 63.44 => 64
		}
						
		//Update the previous Group here
		//========================================
		$string_g="effect_units='$dec_right_value_is'";
		$dbf->updateTable("centre_group_size",$string_g,"centre_id='$centre_id' And group_id='$prev_group_id'");			
		
		//Get the effected group_size Table
		$sms_group_size = $dbf->strRecordID("group_size","*","group_id='$prev_group_id'");
		
		//Get the effected group Name
		$sms_group = $dbf->strRecordID("common","*","id='$prev_group_id'");
		$g3_name = $sms_group["name"];
		
		//Admin id
		$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
		$from=$res_admin[email];
		
		//Group Name
		$g_name = $sms_group["name"];
		
		if($sms_group_size["size_from"] != '0' && $sms_group_size["size_to"] == '0'){
			$student = $sms_group_size["total_size"]."-student"; //12-student
		}else if($sms_group_size["size_from"] != '0' && $sms_group_size["size_to"] != '0'){
			$student = $sms_group_size["size_to"]."-student"; //9-student
		}else if($sms_group_size["size_from"] == '0' && $sms_group_size["size_to"] == '0'){
			$student = ""; //Flex
		}
		
		//Calculate units (Effected Unit - No of class has been finished)
		// 8 = 68 - 60
		$unit = $pending_units - $dec_right_value_is;
			
		//======================
		//Teacher Email address
		$to_user = $res_teacher["email"];
		$admin_mail = $dbf->getDataFromTable("user","email","user_type='Administrator");

		if($to_user != '' || $admin_mail != ''){
	
			$headers .= 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:".$from."\n";	
			
			$email_cont = $dbf->strRecordID("email_templetes","*","id='6'");
			$email_msg = $email_cont["content"];
			
			$email_msg = str_replace('%teacher%',$res_teacher["name"],$email_msg);
			$email_msg = str_replace('%pending_units%',$pending_units,$email_msg);
			$email_msg = str_replace('%groupname%',$g_name,$email_msg);
			$email_msg = str_replace('%dec_right_value_is%',$dec_right_value_is,$email_msg);
			$email_msg = str_replace('%g3_name%',$g3_name,$email_msg);
			$email_msg = str_replace('%unit%',$unit,$email_msg);
			
			$email_msg = str_replace('%no_student_remove%',$no_student_remove,$email_msg);
			$email_msg = str_replace('%student%',$student,$email_msg);
			$email_msg = str_replace('%no_unit_finined%',$no_unit_finined,$email_msg);
			
			$body1='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
  <tr>
	<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
  </tr>
  <tr>
	<td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
	<td height="50" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#999999; padding-left:5px;">'.$email_msg.'</td>
  </tr>		  
  <tr>
	<td align="center" valign="top">&nbsp;</td>
  </tr>
</table>';	
			
			$subject = $email_cont["title"];				
			//$subject ="Group size has been changed Notification !!!";
			
			mail($to_user,$subject,$body1,$headers);
			mail($admin_mail,$subject,$body1,$headers);
			
			//Start Save Mail
			$dt = date('Y-m-d');
			$dttm = date('Y-m-d h:i:s');
			
			$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Teacher',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("email_history",$string);
			//End Save Mail					
		}
		
		
		// End Mail
		//===============
		
		//Start Save Mail	
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
		
		// Insert in Group History Table
		//Current date and time	
		$hdt = date('Y-m-d h:i:s');
		
		//Insert in history Main table	
		$string="dated='$hdt',centre_id='$centre_id',group_id='$group',user_id='$_SESSION[id]',type='1'";
		$hid = $dbf->insertSet("student_group_history",$string);
		
		//Insert query here			
		$str_d="parent_id='$hid',student_id='$student_id'";
		$dbf->insertSet("student_group_history_dtls",$str_d);
		// End ==============================================	
	}	
	
	// Start Mail to Student Advisor
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
	
	
	$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
	$from_name = $dbf->getDataFromTable("user","user_name","id='$_SESSION[id]'");
	
	$to = $dbf->getDataFromTable("user","email","id='$stu_cancel[created_by]'"); //who has sending the request
	$to_name = $dbf->getDataFromTable("user","user_name","id='$stu_cancel[created_by]'");	
		
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
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='12'");
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
	
	//$subject ="On Hold request has been ".$_REQUEST["status"]." By ".$from_name;
	$subj = $email_cont["title"];	
	$subject = str_replace('%status%',$_REQUEST["status"],$subj);
	$subject = str_replace('%username%',$from_name,$subj);
	
	mail($to,$subject,$body1,$headers);
	// End Mail
	
	//Start Save Mail
	$string="dated='$dt',user_id='$_SESSION[id]',msg='$subject',comment='$comment',send_to='Administrator and Accountant',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Centre Director for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);	
	// End Save Mail
	
	header("Location:hold_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_hold","id='$_REQUEST[cancel_id]'");
	header("Location:hold_manage.php");
}
?>
