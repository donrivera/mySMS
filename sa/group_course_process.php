<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	$_SESSION[gr_course_id] = $_REQUEST[course];
	header("Location:group.php");
}
if($_REQUEST['action']=='group'){
	$num_group=$dbf->countRows('student_group',"group_name='$_REQUEST[group]' And centre_id='$_SESSION[centre_id]'");
	if($num_group > 0){
		header("Location:group.php?msg=09061986");
	}else{
		$_SESSION[group_name] = $_REQUEST[group];
		header("Location:group_unit.php");
	}
}
if($_REQUEST['action']=='unit'){
	$_SESSION['gr_course_units'] = $_REQUEST[unit];
	$_SESSION["gr_course_total_units"] = $_REQUEST[totalunit];
	
	header("Location:group_teacher.php");
}
if($_REQUEST['action']=='teacher'){
	
	# Check time validate
	$teacher_id = $_REQUEST["teacher"];
	$choosen_date = $_REQUEST["dt"];
	$group_start_time = $_REQUEST['tm'];
			
	$perday = $dbf->getDataFromTable("common", "name", "id='$_SESSION[gr_course_units]'");
	
	//Time calculation
	$unit = $perday * 45;
	
	$group_s_time = date('H:i:s',strtotime($_REQUEST['tm']));
	
	$event_time = $group_s_time;
	$event_length = $unit;
	 
	$timestamp = strtotime("$event_time");
	
	$group_end_time = date('h:i A',strtotime("+$event_length minutes", $timestamp));
	
	$num = $dbf->teacherSlotAvailable($teacher_id, $choosen_date, $group_start_time, $group_end_time);
		
	$_SESSION["tm"] = $_REQUEST["tm"];
	$_SESSION["end_tm"] = $group_end_time;
	
	if($num == true){
		header("Location:group_teacher.php?msg=o0k9b4");
		exit;
	}else{
		
		$_SESSION["gr_course_teacher"] = $_REQUEST["teacher"];
		$_SESSION["gr_course_strdt"] = $_REQUEST["date_value"];
		$_SESSION["gr_course_endt"] = $_REQUEST["gr_course_endt"];
		$_SESSION["time_slot"] = $_REQUEST["time_slot"];
		
		$_SESSION["dt"] = $_REQUEST["dt"];
		$_SESSION["tm"] = $_REQUEST["tm"];
		
		header("Location:group_classroom.php");
		exit;
	}
	
}
if($_REQUEST['action']=='class'){
	$_SESSION[gr_class_room] = $_REQUEST[class_room];

	header("Location:group_review.php");
}

if($_REQUEST['action']=='finish'){
	
	$group_s_time = date('H:i:s',strtotime($_SESSION['tm']));
	
	$perday = $dbf->getDataFromTable("common", "name", "id='$_SESSION[gr_course_units]'");
	
	//Time calculation
	$unit = $perday * 45;
									
	$event_time = $group_s_time;
	$event_length = $unit;
	 
	$timestamp = strtotime("$event_time");
	$etime = strtotime("+$event_length minutes", $timestamp);
	$group_end_time = date('H:i:s', $etime);	
		
	$string="group_name='$_SESSION[group_name]',centre_id='$_SESSION[centre_id]',course_id='$_SESSION[gr_course_id]', teacher_id='$_SESSION[gr_course_teacher]', units='$_SESSION[gr_course_units]',status='Not Started',room_id='$_SESSION[gr_class_room]',start_date='$_SESSION[dt]',group_time='$_SESSION[tm]',group_time_end='$_SESSION[end_tm]', end_date='$_SESSION[gr_course_endt]',sa_id='$_SESSION[id]'";
	
	$dbf->insertset("student_group",$string);
	
	//Check the Exam vacation for a particular Centre
	$numv=$dbf->countRows('exam_vacation',"centre_id='$_SESSION[centre_id]'");
	
	//If vacation is exist
	if($numv > 0){
		
		$num_is=$dbf->countRows('exam_vacation',"(frm>='$_SESSION[gr_course_strdt]' And tto<='$_SESSION[gr_course_endt]') And centre_id='$_SESSION[centre_id]'");
		
		//Example
		//Vacation was 6th February 2012 to the 15th February 2012
		//Group create or 30th January 2012 to 1st March 2012
		//If yes then mail has been sent to all students
		if($num_is > 0){
			
			//Admin mail id
			$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
			$from = $res_admin[email];
			
			//Student mail id
			$to = '';
			
			//Get the all email id from students table
			foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]' And email<>''","id") as $val_student)
			{
				if($to == ''){
					$to = $val_student["email"];
				}else{
					$to = $to.",".$val_student["email"];
				}
			}
			
			//Get logo path
			$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
			
			//If mail exist
			if($to != '')
			{
				$headers .= 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From:".$from."\n";
				
				$email_cont = $dbf->strRecordID("email_templetes","*","id='11'");
				$email_msg = $email_cont["content"];
				
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
				mail($to,$subject,$body1,$headers);
				
				//Start Save Mail	
				$dt = date('Y-m-d');
				$dttm = date('Y-m-d h:i:s');
				
				$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("email_history",$string);
				// End Save Mail
		
			}
		}
	}
	
	//All session clear
	unset($_SESSION[gr_course_id]);
	session_unregister('gr_course_id');
	
	unset($_SESSION[group_name]);
	session_unregister('group_name');
	
	unset($_SESSION[gr_course_units]);
	session_unregister('gr_course_units');
	
	unset($_SESSION[gr_course_units]);
	session_unregister('gr_course_units');
	
	unset($_SESSION[gr_course_teacher]);
	session_unregister('gr_course_teacher');
	
	unset($_SESSION[gr_course_strdt]);
	session_unregister('gr_course_strdt');
	
	unset($_SESSION[gr_course_endt]);
	session_unregister('gr_course_endt');
	
	unset($_SESSION[time_slot]);
	session_unregister('time_slot');
	
	unset($_SESSION[dt]);
	session_unregister('dt');
	
	unset($_SESSION[tm]);
	session_unregister('tm');
	
	unset($_SESSION[end_tm]);
	session_unregister('end_tm');
	
	unset($_SESSION[gr_class_room]);
	session_unregister('gr_class_room');
	//End
	
	header("Location:group_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_group","id='$_REQUEST[id]'");
	header("Location:group_manage.php");
}

if($_REQUEST['action']=='setstatus'){
	$status = 0;
	if($_REQUEST[val]=="true"){
		$status = 1;
	}
	if($_REQUEST['type']=='book'){
		$string="book_received='$status'";
		$dbf->updateTable("student_group_dtls",$string,"parent_id='$_REQUEST[pid]' AND student_id='$_REQUEST[sid]' AND course_id='$_REQUEST[cid]'");
	}
	exit;
}

if($_REQUEST['action']=='quick_add_group'){
	
	//Get the Centre Invoice No
	$centre_id = $_SESSION['centre_id'];
	$course_id = $_REQUEST['course'];
	
	# Check time validate
	$teacher_id = $_REQUEST["teacher"];
	$choosen_date = $_REQUEST["dt"];
	$group_start_time = $_REQUEST['tm'];
			
	$perday = $dbf->getDataFromTable("common", "name", "id='$_REQUEST[unit]'");
	
	//Time calculation
	$unit = $perday * 45;
	
	$group_s_time = date('H:i:s',strtotime($_REQUEST['tm']));
	
	$event_time = $group_s_time;
	$event_length = $unit;
	 
	$timestamp = strtotime("$event_time");
	
	$group_end_time = date('h:i A',strtotime("+$event_length minutes", $timestamp));
	
	$num = $dbf->teacherSlotAvailable($teacher_id, $choosen_date, $group_start_time, $group_end_time);
		
	$_SESSION["tm"] = $_REQUEST["tm"];
	$_SESSION["end_tm"] = $group_end_time;
	
	if($num == true){
		header("Location:group_quick.php?msg=o0k9b4");
		exit;
	}
	
	$string="group_name='$_REQUEST[group]',centre_id='$centre_id',course_id='$course_id',teacher_id='$_REQUEST[teacher]',units='$_REQUEST[unit]',status='Not Started',room_id='$_REQUEST[class_room]',start_date='$_REQUEST[date_value]',group_time='$_REQUEST[tm]',end_date='$_REQUEST[gr_course_endt]',sa_id='$_SESSION[id]'";
	
	$my_group_id = $dbf->insertset("student_group",$string);
	
	//Check the Exam vacation for a particular Centre
	$numv = $dbf->countRows('exam_vacation',"centre_id='$centre_id'");
	
	//If vacation is exist
	if($numv > 0){
		$num_is=$dbf->countRows('exam_vacation',"(frm>='$_SESSION[gr_course_strdt]' And tto<='$_SESSION[gr_course_endt]') And centre_id='$centre_id'");
		
		//Example
		//Vacation was 6th February 2012 to the 15th February 2012
		//Group create or 30th January 2012 to 1st March 2012
		//If yes then mail has been sent to all students
		if($num_is > 0){
			//Admin mail id
			$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
			$from = $res_admin[email];
			
			//Student mail id
			$to = '';
			
			//Get the all email id from students table
			foreach($dbf->fetchOrder('student',"centre_id='$centre_id' And email<>''","id") as $val_student){
				if($to == ''){
					$to = $val_student["email"];
				}else{
					$to = $to.",".$val_student["email"];
				}
			}
			
			//Get logo path
			$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
			
			//If mail exist
			if($to != ''){
				$headers .= 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From:".$from."\n";
				
				$body1='<table width="700" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
						  <tr>
						    <td height="40" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						      <tr>
						        <td width="22%" height="50" align="center" valign="middle" bgcolor="#FF9900"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
						        <td width="78%" bgcolor="#FF9900">&nbsp;</td>
					          </tr>
					        </table></td>
  </tr>
						  <tr>
							<td width="96" height="40" align="center" valign="middle"><table width="610" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td align="center" valign="middle" bgcolor="#CC9900" style="font:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">Alerts for creating a group has been scheduled within a school/university date !!! </td>
							  </tr>
							</table></td>
						  </tr>
						  <tr>
							<td height="25" align="left" valign="middle" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; padding-left:25px;">Dear All Students,</td>
						  </tr>
						  <tr>
							<td height="25" align="left" valign="middle" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; padding-left:60px;">Are you aware that there is a school or university exam during this course.</td>
						  </tr>
						  <tr>
							<td height="25" align="left" valign="middle" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; padding-left:25px;">&nbsp;</td>
						  </tr>
						  <tr>
							<td height="25" align="right" valign="middle" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; padding-right:22px;">Thanks</td>
						  </tr>
						  <tr>
							<td height="25" align="right" valign="middle" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;">Administrator</td>
					  </tr>
					</table>';
				
				$subject ="Alerts for creating a group has been scheduled within a school/university date !!!";
				mail($to,$subject,$body1,$headers);
				
				//Start Save Mail	
				$dt = date('Y-m-d');
				$dttm = date('Y-m-d h:i:s');
				
				$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("email_history",$string);
				// End Save Mail
			}
		}
	}
	
	//Count the Nymber of Students
	$scount = $_REQUEST["scount"];
	
	//If greater than Zero
	if($scount > 0){
		
		//Loop start here
		for($k = 1; $k <= $scount; $k++){
			
			//Concate o the Control
			$student_id = "student_id".$k;
			
			//Get value according to Control
			$student_id = $_REQUEST[$student_id];
			
			//I that control has been Checked
			if($student_id != ''){
				
				//insert into student_group_dtls Table here
				//Insert query here			
				$str_d="parent_id='$my_group_id',student_id='$student_id',course_id='$course_id',centre_id='$centre_id',room_id='$_REQUEST[class_room]'";
				$dbf->insertSet("student_group_dtls",$str_d);		
				
				//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
				//=======================================================
				$date_time = date('Y-m-d H:i:s A');
				
				$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='3'"); // Means If status is blank or Enrolled
				if($num_st > 0){
					$string_st="group_id='$my_group_id',status_id='4'"; //Enrolled Status		
					$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
					
					$string2="student_id='$student_id',course_id='$course_id',group_id='$my_group_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
					$dbf->insertSet("student_moving_history",$string2);	
				}	
				//=======================================================
				//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE					
																
				////Get Invoice Number
				# -------------------------------------------------------
				$inv_no = $dbf->GenerateInvoiceNo($centre_id);
				$inv_sl = substr($inv_no,5);
				//=======================================================
				
				//Current date
				$current_date = date('Y-m-d');
				
				//Get Course fee
				$course = $dbf->strRecordID("course","*","id='$course_id'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$course_id' And status='1'");
				$course_fee = $course_fees;
								
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
				//Insert / Update the Advance amount as Opening amount in ENROLLED Table
				$string="student_id='$student_id',fee_id='$course_fee_id',centre_id='$centre_id',group_id='$my_group_id',course_id='$course_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";			
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
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$my_group_id'");
				
				//Get the range from (group_size) Table
				$group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id
				$string_g="group_id='$group[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$my_group_id'");
				
				//update in group details table
				$string_g1="group_id='$group[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$my_group_id'");
								
				//Start Sending SMS to student for when class has been started
				$student = $dbf->strRecordID("student","*","id='$student_id' And sms_status='1'");
				$mobile_no = $student["student_mobile"];
				
				if($mobile_no){
					$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
					if($is_enable > 0){
						$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
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
						/*$msg = "Your class will be start on ".$_REQUEST[date_value];
						$Message=$msg;*/										
						
						$sms = $_REQUEST['sms'];
						if($sms == "1" || $sms == "3"){
							if($sms == "1"){
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
							}else if($sms == "3"){
								$sms_cont = $_REQUEST['contents'];
							}
							
							$msg = str_replace('%date%',$_REQUEST["date_value"],$sms_cont);							
							$Message = $msg;
							
							SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
							
							$cr_date = date('Y-m-d H:i:s A');
							
							$string="dated='$cr_date',user_id='0',msg='$msg',send_to='student',mobile='$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='For Class Start',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
							$sms_id = $dbf->insertSet("sms_history",$string);
							
							$string1="parent_id='$sms_id',student_id='$student_id'";
							$dbf->insertSet("sms_history_dtls",$string1);
						}
						//================================
						//SAVED SMS
						//================================
					}
				}
				//End								
			}
		}
		
		//Start Sending SMS if student is going RE-ENROLLMENT
		$cd = $dbf->strRecordID("student","*","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
		$mobile_no = $cd["mobile"];
		if($mobile_no){
			
			$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
			if($is_enable > 0){
				$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
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
				//$msg = $scount." No of students waiting for this group.";
				
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='30'");
				$msg = str_replace('%no_of_students%',$scount,$sms_cont);
				
				$Message=$msg;
				
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);					
				//================================
				//SAVED SMS
				//================================
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD',mobile='$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='For Waiting Students',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("sms_history",$string);
				//================================
				//SAVED SMS
				//================================
			}
		}//End
	}
	
	unset($_SESSION['tm']);
	session_unregister('tm');
	unset($_SESSION['end_tm']);
	session_unregister('end_tm');
	
	header("Location:group_manage.php");
	exit;
}
?>