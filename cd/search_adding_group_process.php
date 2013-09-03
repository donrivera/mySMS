<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();
	
//Get select group
$group = $_REQUEST["group"];

//Get the Group details with Centre wise
$res_group = $dbf->strRecordID("student_group","*","id='$group'");

//SMS Gateway information from the database
$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

//Get the Mobile Number of the particular Teacher 
$res_teacher = $dbf->strRecordID("teacher","*","id='$res_group[teacher_id]'");

//Teacher mobile number
$student_mobile_no = $res_teacher['mobile'];	

//Note (About the group re-sizing)
//Sizes and number of units for groups are to be referenced from the (group_size) table in the admin panel rules.
//Start re-rezing >================================
		
//Get the Numbers of students in a particular Group with Centre wise
$num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");

$student_id = $_REQUEST["student_id"];
$room_id = $res_group["room_id"];
$centre_id = $_SESSION["centre_id"];
$course_id = $res_group["course_id"];

//This is the Previous (Count Number of Students)
//===============================================
if($num_student == 0){
		
	//Insert IN details table
	$str_d="parent_id='$group',student_id='$student_id',course_id='$course_id',centre_id='$centre_id',room_id='$room_id'";
	$dbf->insertSet("student_group_dtls",$str_d);
	//=====================================
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');
	
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='3'"); // Means If status is blank or Enrolled
	if($num_st > 0){
		$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
		$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
		
		$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
		$dbf->insertSet("student_moving_history",$string2);	
	}	
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		
	//Current date
	$current_date = date('Y-m-d');
	
	//Get Course fee
	$course = $dbf->strRecordID("course","*","id='$course_id'");
	$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$course_id' And status='1'");
	$course_fee = $course_fees;
		
	# Get active course fee
	$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
	
	//Insert / Update the Advance amount as Opening amount in ENROLLED Table
	$string="student_id='$student_id',centre_id='$centre_id',fee_id='$course_fee_id',group_id='$group',course_id='$course_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";				
	$dbf->insertSet("student_enroll",$string);
	
	# update enrollment status
	$is_enrollment = $dbf->countRows('student_enroll',"student_id='$student_id'");
	if($is_enrollment == 1){
		$string_status = "enrolled_status='New Enrollment'";
	}else{
		$string_status = "enrolled_status='Re-Enrollment'";
	}
	$dbf->updateTable("student_enroll", $string_status, "student_id='$student_id' And course_id='$course_id'");
	# End
		
	//Get number of student recently added
	$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
	
	//Get the range from (group_size) Table
	$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
			
	//update the Group ID to Student_group Table means we can get the student according to group_id
	$string_g="group_id='$sizegroup[group_id]'";
	$dbf->updateTable("student_group",$string_g,"id='$group'");
	
	//update in group details table
	$string_g1="group_id='$sizegroup[group_id]'";
	$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");

	}else{
	//Get Previous Group after re-arranged
	//====================================
	
	//Get number of student recently added
	$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$group'");
			
	//Get the range from (group_size) Table
	$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");
			
	//update the Group ID to Student_group Table means we can get the student according to group_id
	$prev_group_id = $prev_group[group_id];
	
	//Check whether selected group has been start or not
	$no_unit_finined = $dbf->countRows('ped_units',"group_id='$group'");
	
	if($no_unit_finined > 0){
		//Example : 70 units in admin panel
		//Get the Original Units which is entry By Administrator
		$original_unit = $prev_group[units];
		
		//Example : 10 units in (ped_units) Table
		//Finished points in Decimal value
		// $dec_point_finish = 10 / 70 = 0.1429
		$dec_point_finish = round($no_unit_finined / $original_unit,4);
		
		// $dec_point_100 =  0.142857143 * 100 = 14.29
		$dec_point_100 = $dec_point_finish * 100;
		
		//$pending_units = 70 (70 * 0.1429) = 60
		$pending_units = round($original_unit - ($original_unit * $dec_point_finish));
			
		//Insert query here	
		$str_d="parent_id='$group',student_id='$student_id',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
		$dbf->insertSet("student_group_dtls",$str_d);		
		
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		//=======================================================
		$date_time = date('Y-m-d H:i:s A');
		
		$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='4'"); // Means If status is blank or Enrolled
		if($num_st > 0){
			$string_st="group_id='$group',status_id='5'"; //Active Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
			
			$string2="student_id='$student_id',group_id='$group',course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
			$dbf->insertSet("student_moving_history",$string2);	
		}	
		//=======================================================
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
				
		//Current date
		$current_date = date('Y-m-d');
		
		//Get Course fee
		$course = $dbf->strRecordID("course","*","id='$course_id'");
		$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$course_id' And status='1'");
		$course_fee = $course_fees;
				
		# Get active course fee
		$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
		
		//Insert / Update the Advance amount as Opening amount in ENROLLED Table
		$string="student_id='$student_id',centre_id='$centre_id',fee_id='$course_fee_id',group_id='$group',course_id='$course_id',status_id='5',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";				
		$dbf->insertSet("student_enroll",$string);
		
		
		# update enrollment status
		$is_enrollment = $dbf->countRows('student_enroll',"student_id='$student_id'");
		if($is_enrollment == 1){
			$string_status = "enrolled_status='New Enrollment'";
		}else{
			$string_status = "enrolled_status='Re-Enrollment'";
		}
		$dbf->updateTable("student_enroll", $string_status, "student_id='$student_id' And course_id='$course_id'");
		# End
		
		//Get number of student recently added
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		
		//Get the range from (group_size) Table
		$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
		$my_group_id = $sizegroup["group_id"];
		
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$string_g="group_id='$my_group_id'";
		$dbf->updateTable("student_group",$string_g,"id='$group'");
		
		$string_g1="group_id='$my_group_id'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");	
		
		//Calculate And Previous group update here
		//========================================		
		//Original Unit of the Current Group => 80
		$curr_original_unit = $group[units];
				
		//Finished unit of the Current Group => (0.1429 * 80) => 11.43
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
		$dbf->updateTable("group_size",$string_g,"group_id='$prev_group_id'");
					
		//Get the effected group_size Table
		$sms_group_size = $dbf->strRecordID("group_size","*","group_id='$prev_group_id'");
		
		//Current Group
		$group3 = $dbf->strRecordID("common","*","id='$my_group_id'");
		$g3_name = $group3[name];		
		
		//Get the effected group Name
		$sms_group = $dbf->strRecordID("common","*","id='$prev_group_id'");
		
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
		$unit = $dec_right_value_is - $pending_units;
		
		//Centre director details
		$res_cd = $dbf->strRecordID("user","*","id='$_SESSION[id]'");	
		$from=$res_cd[email];
		
		//Get admin details
		$res_admin = $dbf->strRecordID("user","*","id='1'");
		$admin_mail = $res_admin[email];
								
		//This is for SMS to teacher
		if($student_mobile_no != ''){			
			// Your username
			$UserName=UrlEncoding($sms_gateway[user]);
			
			// Your password
			$UserPassword=UrlEncoding($sms_gateway[password]);
			
			// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
			$Numbers=UrlEncoding($student_mobile_no);
			
			// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
			$Originator=UrlEncoding($sms_gateway[your_name]);
			
			// Your Message in English or arabic or both.
			// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
			$sms = $_REQUEST['sms'];
			if($sms == "1" || $sms == "3"){
				if($no_student_remove == 1){
					$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='26'");
					$sms_cont = str_replace('%unit%',$unit,$sms_cont);
					$sms_cont = str_replace('%std%',$student,$sms_cont);
					$sms_cont = str_replace('%grp%',$g_name,$sms_cont);
					$msg = str_replace('%unt_fnd%',$no_unit_finined,$sms_cont);
				}else{
					$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='27'");
					$sms_cont = str_replace('%unit%',$unit,$sms_cont);
					$sms_cont = str_replace('%nos%',$no_student_remove,$sms_cont);					
					$sms_cont = str_replace('%grp%',$g_name,$sms_cont);					
					$sms_cont = str_replace('%std%',$student,$sms_cont);
					$sms_cont = str_replace('%ufin%',$no_unit_finined,$sms_cont);
					$msg = str_replace('%nos%',$no_student_remove,$sms_cont);
				}
				
				$Message=$msg;
				
				// Storing Sending result in a Variable.
				if($sms_gateway["status"]=='Enable'){
					SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
					
					$cr_date = date('Y-m-d H:i:s A');
					$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding Student Advisor (Search)',mobile='$student_mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
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
					
			$subject ="Group size has been changed Notification !!!";
			mail($to_user,$subject,$body1,$headers);
			
			//Start Save Mail	
			$dt = date('Y-m-d');
			$dttm = date('Y-m-d h:i:s');
			
			$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("email_history",$string);
			// End Save Mail				
		}											
		
		// End Save Mail
	}else{
		//Insert IN details table
		//Insert query here	
		$str_d="parent_id='$group',student_id='$student_id',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
		$dbf->insertSet("student_group_dtls",$str_d);			
		
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		//=======================================================
		$date_time = date('Y-m-d H:i:s A');
		
		$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='3'"); // Means If status is blank or Enrolled
		if($num_st > 0){
			$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
			
			$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);	
		}	
		//=======================================================
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE		
				
		//Current date
		$current_date = date('Y-m-d');
		
		//Get Course fee
		$course = $dbf->strRecordID("course","*","id='$course_id'");
		$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$course_id' And status='1'");
		$course_fee = $course_fees;
				
		# Get active course fee
		$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
		//Insert / Update the Advance amount as Opening amount in ENROLLED Table
		$string="student_id='$student_id',centre_id='$centre_id',fee_id='$course_fee_id',group_id='$group',course_id='$course_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";				
		$dbf->insertSet("student_enroll",$string);
		
		# update enrollment status
		$is_enrollment = $dbf->countRows('student_enroll',"student_id='$student_id'");
		if($is_enrollment == 1){
			$string_status = "enrolled_status='New Enrollment'";
		}else{
			$string_status = "enrolled_status='Re-Enrollment'";
		}
		$dbf->updateTable("student_enroll", $string_status, "student_id='$student_id' And course_id='$course_id'");
		# End
		
		
		//=====================================		
		//Get number of student recently added
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		
		//Get the range from (group_size) Table
		$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
				
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$string_g="group_id='$sizegroup[group_id]'";
		$dbf->updateTable("student_group",$string_g,"id='$group'");
		
		//update in group details
		$string_g1="group_id='$sizegroup[group_id]'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
	}
}
//End re-sizing   >================================

//SMS to student
$student_mobile = $dbf->getDataFromTable("student","student_mobile","id='$student_id'");
if($student_mobile != ''){
	
	// Your username
	$UserName=UrlEncoding($sms_gateway[user]);
	
	// Your password
	$UserPassword=UrlEncoding($sms_gateway[password]);
	
	// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
	$Numbers=UrlEncoding($student_mobile);
	
	// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
	$Originator=UrlEncoding($sms_gateway[your_name]);
	
	// Your Message in English or arabic or both.
	// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
	$sms = $_REQUEST['sms'];
	if($sms == "1" || $sms == "3"){
		
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");		
		$msg = str_replace('%date%',$res_group["start_date"],$sms_cont);
				
		$Message=$msg;
		
		// Storing Sending result in a Variable.
		if($sms_gateway["status"]=='Enable'){
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			$cr_date = date('Y-m-d H:i:s A');
			$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Student',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding Student Advisor (Search)',mobile='$student_mobile',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("sms_history",$string);
		}
	}
		
}
?>
<script type="text/javascript">
	self.parent.location.href='search_manage.php?student_id=<?php echo $student_id;?>';
	self.parent.tb_remove();
</script>