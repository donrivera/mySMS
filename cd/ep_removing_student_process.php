<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='delete'){
	//Get the logo path
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	//Get the Group details with Centre wise
	$res_group = $dbf->strRecordID("student_group","*","id='$_POST[group]'");
	
	//Get group id which is choose on the frontend
	$prev_group_id = $res_group[group_id];
	
	//Get the Group details with Centre wise
	$curr_group = $dbf->strRecordID("group_size","*","group_id='$res_group[group_id]'");
	
	$course_id = $res_group["course_id"];
	
	//SMS Gateway information from the database
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	
	//Get the Mobile Number of the particular Teacher 
	$res_teacher = $dbf->strRecordID("teacher","*","id='$res_group[teacher_id]'");
	
	//Get mobile number of the teacher
	$student_mobile_no = $res_teacher['mobile'];
	
	//Calculate current group
	//=======================
	
	//Check whether selected group has been start or not
	$no_unit_finined = $dbf->countRows('ped_units',"group_id='$_POST[group]'");
	
	if($no_unit_finined > 0){
		//Example : 80 units in admin panel
		//Get the Original Units which is entry By Administrator
		$original_unit = $curr_group[units];
		
		//Example : 18 units in (ped_units) Table
		//Finished points in Decimal value
		// $dec_point_finish = 18 / 80 = 0.225
		$dec_point_finish = round($no_unit_finined / $original_unit,4);
		
		// $dec_point_100 =  0.225 * 100 = 22.5
		$dec_point_100 = $dec_point_finish * 100;
		
		//$pending_units = 80 (80 * 0.225) = 62
		$pending_units = round($original_unit - ($original_unit * $dec_point_finish));		
		
		//Delete IN details table
		$count = $_REQUEST[count];
		$no_student_remove = 0;
		for($i = 1; $i<=$count; $i++){
			$id1 = "id".$i;
			$id1 = $_REQUEST[$id1];
			if($id1 != ''){
				
				//Delete from grouping details table
				$dbf->deleteFromTable("student_group_dtls","parent_id='$_REQUEST[group]' AND student_id='$id1'");				
				$dbf->deleteFromTable("student_enroll","group_id='$_REQUEST[group]' AND student_id='$id1' And centre_id='$_SESSION[centre_id]'");				
				$dbf->deleteFromTable("student_fees","course_id='$course_id' And student_id='$id1' And centre_id='$_SESSION[centre_id]'");
								
				$no_student_remove = $no_student_remove+1;				
			}
		}
	
		//Get number of student recently removed
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_REQUEST[group]'");
		
		//Get the range from (group_size) Table
		$group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
				
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$string_g="group_id='$group[group_id]'";
		$dbf->updateTable("student_group",$string_g,"id='$_REQUEST[group]'");
		
		//update the Group ID to student_group_dtls Table means we can get the student according to parent_id
		$string_g1="group_id='$group[group_id]'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_REQUEST[group]'");
			
		//Calculate And Previous group update here
		//========================================		
		//Original Unit of the Current Group => 80
		$curr_original_unit = $group[units];
				
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
		$dbf->updateTable("centre_group_size",$string_g,"centre_id='$_SESSION[centre_id]' And group_id='$prev_group_id'");			
		
		//Get the effected group_size Table
		$sms_group_size = $dbf->strRecordID("group_size","*","group_id='$prev_group_id'");
		
		//Get the effected group Name
		$sms_group = $dbf->strRecordID("common","*","id='$prev_group_id'");
		$g3_name = $sms_group[name];
		
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
		
		//This is for SMS
		if($student_mobile_no != ''){
			// Your username
			$UserName=UrlEncoding($sms_gateway[user]);
			
			// Your password
			$UserPassword=UrlEncoding($sms_gateway[password]);
			
			// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
			$Numbers=UrlEncoding($student_mobile_no);
			
			// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
			$Originator=UrlEncoding($sms_gateway[your_name]);
						
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='29'");
			$sms_cont = str_replace('%u%',$unit,$sms_cont);
			$sms_cont = str_replace('%nos%',$no_student_remove,$sms_cont);
			$sms_cont = str_replace('%std%',$student,$sms_cont);
			$sms_cont = str_replace('%grp%',$g_name,$sms_cont);
			$sms_cont = str_replace('%uf%',$no_unit_finined,$sms_cont);
			$msg = str_replace('%nos%',$no_student_remove,$sms_cont);
						
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			$sms = $_REQUEST['sms'];
			if($sms == "1" || $sms == "3"){
				if($sms_gateway["status"]=='Enable'){
					SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
					
					$cr_date = date('Y-m-d H:i:s A');
					$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='Remove student from Centre Director (Exception Processing)',mobile='$student_mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("sms_history",$string);
				}
			}			
		}
		
		//======================
		// Start Mail to Teacher
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
			
		//===============
		// End Mail
		//===============
		
		//Start Save Mail	
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
		
	}else{
		//Delete IN details table
		$count = $_REQUEST[count];
		$no_student_remove = 0;
		for($i = 1; $i<=$count; $i++){
			$id2 = "id".$i;
			$id2 = $_REQUEST[$id2];
			if($id2 != ''){
				//Delete from grouping details table
				$dbf->deleteFromTable("student_group_dtls","parent_id='$_REQUEST[group]' AND student_id='$id2'");								
				$dbf->deleteFromTable("student_enroll","group_id='$_REQUEST[group]' AND student_id='$id2' And centre_id='$_SESSION[centre_id]'");				
				$dbf->deleteFromTable("student_fees","course_id='$course_id' And student_id='$id2' And centre_id='$_SESSION[centre_id]'");
			}
		}
	}
	// End =======================
	
	//=============================================================
	// Insert in Group History Table
	//=============================================================
	
	//Get centre id
	$centre_id = $_SESSION[centre_id];
	
	//Current date and time	
	$hdt = date('Y-m-d h:i:s');
	
	//Insert in history Main table	
	$string="dated='$hdt',centre_id='$_SESSION[centre_id]',group_id='$_REQUEST[group]',user_id='$_SESSION[id]',type='1'";
	$hid = $dbf->insertSet("student_group_history",$string);

	//Insert IN details table
	$count = $_REQUEST[count];
	for($i = 1; $i<=$count; $i++){
		$id3 = "id".$i;
		$id3 = $_REQUEST[$id3];
		if($id3 != ''){
			
			//Insert query here			
			$str_d="parent_id='$hid',student_id='$id3'";
			$dbf->insertSet("student_group_history_dtls",$str_d);
			
			# ==========================================================
			# Insert in Student Comments Table (student_comment)
			$dt = date('Y-m-d h:i:s');
			$comm = mysql_real_escape_string($_REQUEST['comment']);
			
			if($comm != ''){
				$string_move="student_id='$id3',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
				$dbf->insertSet("student_comment",$string_move);
			}
			# ==========================================================
		}
	}	
	//=============================================================
	// End
	//=============================================================
	
	header("Location:ep_removing_student.php");
	exit;
}
?>
