<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

//Object initialization of class validatesaid
include_once '../includes/validateSAID.class.php';
$std = new validateSAID();

if($_REQUEST['action']=='age'){
	$_SESSION[age] = $_REQUEST[age];
    $_SESSION[gname] = $_REQUEST[gname];
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	$_SESSION[gender] = $_REQUEST[gender];
	$_SESSION[gender1] = $_REQUEST[gender1];
	
	header("Location:s1.php");
}

if($_REQUEST['action']=='stname'){
	
	$_SESSION[name] = $_REQUEST[ename];
	$_SESSION[name1] = $_REQUEST[name1];
	
	$_SESSION[father_name] = $_REQUEST[father_name];
	$_SESSION[father_name1] = $_REQUEST[father_name1];
	
	$_SESSION[grandfather_name] = $_REQUEST[grandfather_name];
	$_SESSION[grandfather_name1] = $_REQUEST[grandfather_name1];
	
	$_SESSION[family_name] = $_REQUEST[family_name];
	$_SESSION[family_name1] = $_REQUEST[family_name1];		
	
	header("Location:s2.php");
	exit;	
}

if($_REQUEST['action']=='country'){
	if($_REQUEST[studentid] != ''){
		//Duplicate checking student id
		$num=$dbf->countRows('student',"student_id='$_REQUEST[studentid]'");
		if($num>0){
			//Error message sent to header
			header("Location:s2.php?msg=idexist");
			exit;
		}
	}
	
	$sid=$_REQUEST[studentid];
	$cid=$_REQUEST[country];
	
	$_SESSION[country] = $_REQUEST[country];
	$_SESSION[student_id] = $_REQUEST[studentid];
	$_SESSION[id_type] = $_REQUEST[id_type];

	//if($cid=='189'){
		/* most basic usage */
		//$var = 1;
		//echo $var_is_greater_than_two = ($var > 2 ? true : false);exit; // returns true
		if($_REQUEST[id_type] == "National ID"){
			if($sid != ''){
				$stu_id = $std->check($sid);
				if($stu_id > 0){
					$_SESSION[country] = $_REQUEST[country];
					$_SESSION[student_id] = $_REQUEST[studentid];
					header("Location:s3.php");
				}else{			
					header("Location:s2.php?msg=invalid");
				}
			}else{
				header("Location:s3.php");
				exit;
			}
		}else{
			header("Location:s3.php");
			exit;
		}
	/*}else{
		header("Location:s3.php");
	}*/	
}

if($_REQUEST['action']=='contact'){
	//Duplicate checking on Mobile Number
	$num=$dbf->countRows('student'," student_mobile='$_REQUEST[mobile_no]'");
	if($num>0){
		//Error message sent to header
		header("Location:s3.php?msg=mexist");
		exit;
	}
	
	$_SESSION[mobile_no] = $_REQUEST[mobile_no];
	$_SESSION[alt_no] = $_REQUEST[alt_no];
	header("Location:s4.php");
	exit;	
}

if($_REQUEST['action']=='email'){
	//Duplicate checking on Mobile Number
	$num=$dbf->countRows('student',"email='$_REQUEST[email]'");
	if($num>0){
		//Error message sent to header
		header("Location:s4.php?msg=exist");
		exit;
	}else{
		$_SESSION[email] = $_REQUEST[email];
		header("Location:s6.php");
		exit;
	}
}

if($_REQUEST['action']=='group'){
	$_SESSION[group] = $_REQUEST[group];	
	header("Location:s7.php");
}
 
if($_REQUEST['action']=='course'){
	$courseid='';
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "course".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			if($courseid == ''){
				$courseid=$c;
			}else{
				$courseid=$courseid.','.$c;
			}
		}
	}
	$_SESSION[courseid] = $courseid;
	header("Location:s_group.php");
}
 
if($_REQUEST['action']=='comment'){
	$str = mysql_real_escape_string($_POST[student_comment]);
	$_SESSION[student_comment] = $str;
	header("Location:s8.php");
}

if($_REQUEST['action']=='aboutus'){
	
	$leadid='';
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			if($leadid == ''){
				$leadid=$c;
			}else{
				$leadid=$leadid.','.$c;
			}
		}
	}
	$_SESSION[leadid] = $leadid;
	
	$typeid='';
	$count = $_POST[tcount];
	for($i=1; $i<=$count; $i++){
		$c = "type".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			if($typeid == ''){
				$typeid=$c;
			}else{
				$typeid=$typeid.','.$c;
			}
		}
	}
	$_SESSION['typeid'] = $typeid;
		
	header("Location:s10.php");
}
 
if($_REQUEST['action']=='insert'){
	
	//Current date
	$current_date = date('Y-m-d');
	$dt1 = date('Y-m-d H:i:s A');
		
	//Get logo path
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
		
	//Get Gender from Session
	if($_SESSION[gender]==''){
		$gender = $_SESSION[gender1];
	}else{
		$gender = $_SESSION[gender];
	}
	
	$student_name = $_SESSION["name"].' '.$_SESSION["family_name"];
	
	//Insert into student table
	$string="first_name='$student_name',first_name1='$_SESSION[name]',father_name='$_SESSION[father_name]',grandfather_name='$_SESSION[grandfather_name]',family_name='$_SESSION[family_name]',age='$_SESSION[age]',guardian_name='$_SESSION[gname]',guardian_contact='$_SESSION[pcontact]',guardian_comment ='$_SESSION[information]', gender='$gender',country_id='$_SESSION[country]',id_type='$_SESSION[id_type]',student_id='$_SESSION[student_id]',student_mobile='$_SESSION[mobile_no]',alt_contact='$_SESSION[alt_no]',email='$_SESSION[email]',centre_id='$_SESSION[centre_id]',created_datetime='$dt1',created_by='$_SESSION[id]',sms_status='1'";
	
	$ids = $dbf->insertSet("student",$string);
	
	//Insert in Student Comments Table
	if($_SESSION[student_comment]!=''){
		$string_comments="student_id='$ids',user_id='$_SESSION[id]',comments='$_SESSION[student_comment]',date_time='$dt1'";
		$dbf->insertSet("student_comment",$string_comments);
	}
	
	//Get select group
	$group = $_SESSION[group];
	
	if($group > 0){
		
		//Get the Group details with Centre wise
		$res_group = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");
		
		$room_id = $res_group["room_id"];
		$centre_id = $_SESSION["centre_id"];
		$course_id = $res_group["course_id"];
		
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
		
		//This is the Previous (Count Number of Students)
		//===============================================
		if($num_student == 0){
			//insert into student_group_dtls table
			//====================================
			$str_d="parent_id='$_SESSION[group]',student_id='$ids',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
			$dbf->insertSet("student_group_dtls",$str_d);
									
			# Get active course fee
			$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
			//Insert in ENROLLED Table
			$string="student_id='$ids',centre_id='$centre_id',group_id='$_SESSION[group]',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";	
			$dbf->insertSet("student_enroll",$string);			
			//========================================================
			
			# update enrollment status
			$is_enrollment = $dbf->countRows('student_enroll',"student_id='$ids'");
			if($is_enrollment == 1){
				$string_status = "enrolled_status='New Enrollment'";
			}else{
				$string_status = "enrolled_status='Re-Enrollment'";
			}
			$dbf->updateTable("student_enroll", $string_status, "student_id='$ids' And course_id='$course_id'");
			# End
			
			//Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_SESSION[group]'");
			
			//Get the range from (group_size) Table
			$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$sizegroup[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$_SESSION[group]'");
			
			//update in group details table
			$string_g1="group_id='$sizegroup[group_id]'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_SESSION[group]'");
			
		}else{
			//Get Previous Group after re-arranged
			//====================================
			
			//Get number of student recently added
			$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$_SESSION[group]'");
					
			//Get the range from (group_size) Table
			$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$prev_group_id = $prev_group[group_id];
			
			//Check whether selected group has been start or not
			$no_unit_finined = $dbf->countRows('ped_units',"group_id='$_SESSION[group]'");
			
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
							
				//insert into student_group_dtls table
				//====================================		
				$room_id = $res_group["room_id"];
				$centre_id = $_SESSION[centre_id];
				
				//Insert IN details table
				$str_d="parent_id='$_SESSION[group]',student_id='$ids',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);			
												
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
				//Insert in ENROLLED Table
				$string="student_id='$ids',centre_id='$centre_id',group_id='$_SESSION[group]',course_id='$course_id',fee_id='$course_fee_id',status_id='5',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";	
				$dbf->insertSet("student_enroll",$string);
				
				# update enrollment status
				$is_enrollment = $dbf->countRows('student_enroll',"student_id='$ids'");
				if($is_enrollment == 1){
					$string_status = "enrolled_status='New Enrollment'";
				}else{
					$string_status = "enrolled_status='Re-Enrollment'";
				}
				$dbf->updateTable("student_enroll", $string_status, "student_id='$ids' And course_id='$course_id'");
				# End
				
				//=====================================
				
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_SESSION[group]'");
				
				//Get the range from (group_size) Table
				$pgroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id

				$string_g="group_id='$pgroup[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$_SESSION[group]'");
				
				$string_g1="group_id='$pgroup[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_SESSION[group]'");
				
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
				$group3 = $dbf->strRecordID("common","*","id='$group[group_id]'");
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
				$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
				$admin_mail = $res_admin[email];
				
				$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
					
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
					
					// Your Message in English or arabic or both.
					// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
					if($no_student_remove == 1){
						$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='26'");
						$sms_cont = str_replace('%unit%',$unit,$sms_cont);
						$sms_cont = str_replace('%std%',$student,$sms_cont);
						$sms_cont = str_replace('%grp%',$g_name,$sms_cont);
						$msg = str_replace('%unt_fnd%',$no_unit_finined,$sms_cont);
					
						//$msg = "Add ".$unit." units to this group due to adding a student to a ".$student." ".$g_name." group that has completed ".$no_unit_finined." units at the time of adding this student.";
					}else{
						$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='27'");
						$sms_cont = str_replace('%unit%',$unit,$sms_cont);
						$sms_cont = str_replace('%nos%',$no_student_remove,$sms_cont);					
						$sms_cont = str_replace('%grp%',$g_name,$sms_cont);					
						$sms_cont = str_replace('%std%',$student,$sms_cont);
						$sms_cont = str_replace('%ufin%',$no_unit_finined,$sms_cont);
						$msg = str_replace('%nos%',$no_student_remove,$sms_cont);
						
						//$msg = "Add ".$unit." units to this group due to adding ".$no_student_remove." student to a ".$student." ".$g_name." group that has completed ".$no_unit_finined." units at the time of adding these ".$no_student_remove." students.";
					}
					/*if($no_student_remove == 1){
						$msg = "Add ".$unit." units to this group due to adding a student to a ".$student." ".$g_name." group that has completed ".$no_unit_finined." units at the time of adding this student.";
					}else{
						$msg = "Add ".$unit." units to this group due to adding ".$no_student_remove." student to a ".$student." ".$g_name." group that has completed ".$no_unit_finined." units at the time of adding these ".$no_student_remove." students.";
					}*/
					
					$Message=$msg;
					
					// Storing Sending result in a Variable.
					if($sms_gateway["status"]=='Enable'){
						SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
						
						$cr_date = date('Y-m-d H:i:s A');
						$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding Student Advisor (Step by Step)',mobile='$student_mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
						$dbf->insertSet("sms_history",$string);
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
					
					$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to_user',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("email_history",$string);
					// End Save Mail
	
					
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
				//Insert IN details table		
				//Insert query here	
				$str_d="parent_id='$_SESSION[group]',student_id='$ids',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);				
												
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
				//Insert in ENROLLED Table
				$string="student_id='$ids',centre_id='$centre_id',group_id='$_SESSION[group]',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";	
				$dbf->insertSet("student_enroll",$string);				
				//=====================================
				
				# update enrollment status
				$is_enrollment = $dbf->countRows('student_enroll',"student_id='$ids'");
				if($is_enrollment == 1){
					$string_status = "enrolled_status='New Enrollment'";
				}else{
					$string_status = "enrolled_status='Re-Enrollment'";
				}
				$dbf->updateTable("student_enroll", $string_status, "student_id='$ids' And course_id='$course_id'");
				# End
				
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_SESSION[group]'");
				
				//Get the range from (group_size) Table
				$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id
				$string_g="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$_SESSION[group]'");
				
				//update in group details
				$string_g1="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_SESSION[group]'");
			}
		}
	}
	//End re-sizing   >================================
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');
	$res_group = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");	
	if($_SESSION["group"] > 0){
		
		//Check the Group has been start or not
		$no_unit_finined = $dbf->countRows('ped_units',"group_id='$_SESSION[group]'");	
		if($no_unit_finined > 0){
			
			//Active Status
			$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',status_id='5',date_time='$date_time',user_id='$_SESSION[id]'";
			$dbf->insertSet("student_moving",$string2);	
			
			$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
			$dbf->insertSet("student_moving_history",$string2);	
			
		}else{
			
			//Enrolled Status
			$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',status_id='4',date_time='$date_time',user_id='$_SESSION[id]'";
			$dbf->insertSet("student_moving",$string2);	
			
			$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);
		
		}
	}else{
			
		//Potencial Status
		$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',status_id='2',date_time='$date_time',user_id='$_SESSION[id]'";
		$dbf->insertSet("student_moving",$string2);	
		
		$string2="student_id='$ids',course_id='$res_group[course_id]',group_id='$_SESSION[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
		$dbf->insertSet("student_moving_history",$string2);
	}
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
	
	//Set in Session (New Student ID)
	$_SESSION['studentid'] = $ids;
	
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$_SESSION[studentid]'");
	
	//insert into student course table
	$courseid=explode(',',$_SESSION[courseid]);
	foreach($courseid as $val){
		if($val > 0){			
			$string="student_id='$_SESSION[studentid]',course_id='$val'";
			$dbf->insertSet("student_course",$string);
		}
	}	
	//Delete from student course table
	$dbf->deleteFromTable("student_lead","student_id='$_SESSION[studentid]'");
	
	//insert into student lead table
	$leadid=explode(',',$_SESSION[leadid]);
	foreach($leadid as $val2){
		if($val2 > 0){
			$string="student_id='$_SESSION[studentid]',lead_id='$val2'";
			$dbf->insertSet("student_lead",$string);
		}
	}	
	
	//insert into student lead table
	$typeid=explode(',',$_SESSION[typeid]);
	foreach($typeid as $valt){
		if($valt > 0){
			$string="student_id='$_SESSION[studentid]',type_id='$valt'";
			$dbf->insertSet("student_type",$string);
		}
	}
	
	$sid = $_SESSION['studentid'];		
	
	$group_id = $_SESSION[group];
	
	//Clear all previous session value
	unset($_SESSION['name']);
	session_unregister('name');
	
	unset($_SESSION['name1']);
	session_unregister('name1');
	
	unset($_SESSION['father_name']);
	session_unregister('father_name');
	
	unset($_SESSION['father_name1']);
	session_unregister('father_name1');
	
	unset($_SESSION['grandfather_name']);
	session_unregister('grandfather_name');
	
	unset($_SESSION['grandfather_name1']);
	session_unregister('grandfather_name1');
	
	unset($_SESSION['family_name']);
	session_unregister('family_name');
	
	unset($_SESSION['family_name1']);
	session_unregister('family_name1');
		
	unset($_SESSION['studentid']);
	session_unregister('studentid');
	
	unset($_SESSION['student_id']);
	session_unregister('student_id');
	
	unset($_SESSION['gname']);
	session_unregister('gname');
	
	unset($_SESSION['group']);
	session_unregister('group');
	
	unset($_SESSION['pcontact']);
	session_unregister('pcontact');
	
	unset($_SESSION['information']);
	session_unregister('information');
	
	unset($_SESSION['age']);
	session_unregister('age');
		
	unset($_SESSION['gender']);
	session_unregister('gender');
	
	unset($_SESSION['country']);
	session_unregister('country');
	
	unset($_SESSION['mobile_no']);
	session_unregister('mobile_no');
	
	unset($_SESSION['alt_no']);
	session_unregister('alt_no');
	
	unset($_SESSION['email']);
	session_unregister('email');
	
	unset($_SESSION['status']);
	session_unregister('status');
	
	unset($_SESSION['student_comment']);
	session_unregister('student_comment');
	
	unset($_SESSION['courseid']);
	session_unregister('courseid');
	
	unset($_SESSION['leadid']);
	session_unregister('leadid');
	
	unset($_SESSION['typeid']);
	session_unregister('typeid');
	
	unset($_SESSION['studentid']);
	session_unregister('studentid');
	
	if($group_id > 0){
		header("Location:search_manage.php?student_id=$sid");
	}else{
		header("Location:search.php");
	}
}

if($_REQUEST['action']=='search'){
	
	//Current date and time
	$dt = date('Y-m-d h:m:s');	
	$c_dt = date('Y-m-d');
	
	$student_id = $_REQUEST['student_id'];
	$course_id = $_REQUEST['course_id'];
	$centre_id = $_SESSION['centre_id'];
	$invoice_note = mysql_real_escape_string($_REQUEST['note']);
	
	//Get data from student_enroll for checking the whether initial fee has been changed or not
	$res_en = $dbf->strRecordID("student_enroll","*","course_id='$_REQUEST[course_id]' And student_id='$student_id'");
	
	$string="level_complete='$_POST[level]',other_amt='$_POST[otheramt]',othertext='$_POST[othertext]',payment_type='$_POST[ptype]',web='$_POST[web]',discount='$_POST[discount]',invoice_note='$invoice_note'";
	$dbf->updateTable("student_enroll",$string,"course_id='$course_id' And student_id='$student_id'");
	
	# Check Opening balance
	$is_opeing = $dbf->countRows("student_fees", "course_id='$course_id' And student_id='$student_id' And type='opening'");
	if($is_opeing == 0){
		
		//Get Invoice Number
		# -------------------------------------------------------
		$inv_no = $dbf->GenerateInvoiceNo($centre_id);
		$inv_sl = substr($inv_no,5);
		//=======================================================
		
		# if not available then save
		$string2="student_id='$student_id',course_id='$course_id',paid_amt='$_REQUEST[payment]',fee_amt='$_REQUEST[payment]',comments='$invoice_note',fee_date='$c_dt',paid_date='$c_dt',payment_type='$_REQUEST[ptype]',centre_id='$centre_id',created_date=NOW(),created_by='$_SESSION[id]',type='opening',invoice_sl='$inv_sl',invoice_no='$inv_no',status='1'";
	
		$dbf->insertSet("student_fees",$string2);		
		
	}else{
		
		# if available then edit the opening balance
		$string="payment_type='$_POST[ptype]',paid_amt='$_POST[payment]',status='1',comments='$invoice_note',fee_amt='$_POST[payment]',created_date=NOW(),created_by='$_SESSION[id]'";
		$dbf->updateTable("student_fees",$string,"course_id='$course_id' And student_id='$student_id' And type='opening'");
	
	}
	
	//For record the previous data with current data if any changes with the any field
	if($res_en[other_amt] != $_POST[otheramt]){
		
		$string2="fld_name='Other Amount',chg_from='$res_en[other_amt]',chg_to='$_POST[otheramt]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
	}
	if($res_en[payment_type] != $_POST[ptype]){
		
		$res_com_from = $dbf->strRecordID("common","*","id='$res_en[payment_type]'");
		$res_com_to = $dbf->strRecordID("common","*","id='$_REQUEST[payment_type]'");
		
		$string2="fld_name='Payment Type',chg_from='$res_com_from[name]',chg_to='$res_com_to[name]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
		
	}
	if($res_en[discount] != $_POST[discount]){
		
		$string2="fld_name='Discount  Amount',chg_from='$res_en[discount]',chg_to='$_POST[discount]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
		
	}
	//=================================================================================
	
	//insert into student_comment table	
	$newcomment=mysql_real_escape_string($_POST[newcomment]);
	if($newcomment!=''){
		$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
		$dbf->insertSet("student_comment",$string2);
	}
	
	//Delete from student material table
	$dbf->deleteFromTable("student_material","course_id='$_REQUEST[course]' And student_id='$student_id'");
	
	//Insert in student material table
	//---------------------------------------------------
	$totrow_cont = $_REQUEST['mcount'];

	for($i=1; $i<=$totrow_cont;$i++){
		$name = "material".$i;
		$name = $_REQUEST[$name];
		
		if($name != ""){
			$string="student_id='$student_id',course_id='$_REQUEST[course]',mate_id='$name'";
			$dbf->insertSet("student_material",$string);
		}
	}
	//----------------------------------------------------
	
	//Insert in student fees table
	$tot = $_REQUEST['count'];

	for($k=1; $k<=$tot;$k++){
		$name = "pdate".$k;
		$name = $_REQUEST[$name];
		
		$amt = "amt".$k;
		$amt = $_REQUEST[$amt];
		
		if($name != "" && $amt != ""){
			$string="student_id='$student_id',course_id='$_REQUEST[course]',fee_date='$name',fee_amt='$amt',created_date='$dt',created_by='$_SESSION[id]',centre_id='$_SESSION[centre_id]'";
			$dbf->insertSet("student_fees",$string);
		}
	}
	//----------------------------------------------------	
	header("Location:search_manage_mail.php?student_id=$student_id&course_id=$_REQUEST[course_id]");
	exit;
}

if($_REQUEST['action']=='advance'){
	
	$student_id = $_REQUEST["student_id"];
	$course_id = $_REQUEST["course_id"];
	$centre_id = $_SESSION["centre_id"];
	$ad_comment = mysql_real_escape_string($_REQUEST[ad_comment]);
	$date_time = date('Y-m-d H:i:s A');
	
	//Get Invoice Number
	# -------------------------------------------------------
	$inv_no = $dbf->GenerateInvoiceNo($centre_id);
	$inv_sl = substr($inv_no,5);
	//=======================================================
	
	//insert into student_fee table
	$string2="student_id='$student_id',course_id='$course_id',paid_amt='$_REQUEST[amts]',fee_amt='$_REQUEST[amts]',comments='$ad_comment',fee_date='$_REQUEST[dated]',paid_date='$_REQUEST[dated]',payment_type='$_REQUEST[payment_type]',centre_id='$centre_id',created_date=NOW(),created_by='$_SESSION[id]',type='advance',invoice_sl='$inv_sl',invoice_no='$inv_no',status='1'";	
	$dbf->insertSet("student_fees",$string2);
	
	# UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	$is_multi_advance = $dbf->countRows("student_fees", "student_id='$student_id' And course_id='$course_id' And type='advance'");
	if($is_multi_advance == 0){
		
		# Delete previous data of a particular student which is less then 2 means Enquiry or Potential
		$dbf->deleteFromTable("student_moving", "student_id='$student_id' And status_id <='2'");
		
		$date_time = date('Y-m-d H:i:s A');
		
		$string_st="student_id='$student_id',status_id='3',course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]'"; //Waiting Status		
		$dbf->insertSet("student_moving",$string_st);
		
		$string2="student_id='$student_id',course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='3'";
		$dbf->insertSet("student_moving_history",$string2);	
		
	}
	# UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		
	$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
	if($is_enable > 0){
	
		$res_sms = $dbf->strRecordID("sms_gateway","*","status<>''");
		$student_mobile = $dbf->strRecordID("student","*","id='$student_id' And sms_status='1'");
		$mobile_no = $student_mobile["student_mobile"];
	
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
			//$msg = "Dear ".$student_mobile["0"].", your initial payment of ".$_REQUEST["ad_amt"]." has been received by Berlitz.";
			
			$sms = $_REQUEST['sms'];
			if($sms == "1" || $sms == "3"){
				if($sms == "1"){
					$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
				}else if($sms == "3"){
					$sms_cont = $_REQUEST['contents'];
				}
				$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
				$msg = str_replace('%ad_amt%',$_REQUEST["ad_amt"],$sms_cont);
				
				$Message=$msg;
			
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				
				//================================
				//SAVED SMS
				//================================
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$msg',send_to='student',mobile='$mobile_no',centre_id='$centre_id',msg_from='Initial Payment as Advance',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$sms_id = $dbf->insertSet("sms_history",$string);
				
				$string1="parent_id='$sms_id',student_id='$student_id'";
				$dbf->insertSet("sms_history_dtls",$string1);
				//================================
				//SAVED SMS
				//================================
			}
		}
	}
		
	//insert into student_comment table
	if($ad_comment!=''){
		$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$ad_comment',date_time='$date_time'";
		$dbf->insertSet("student_comment",$string2);
	}
	
	header("Location:search_advance.php?student_id=$student_id&course_id=$course_id");
	exit;
}

if($_REQUEST['action']=='invoice'){
	
	$student_id = $_REQUEST['student_id'];
	$course_id = $_REQUEST['course_id'];
	$centre_id = $_SESSION['centre_id'];
		
    $comments = mysql_real_escape_string($_POST[comment]);
	
	//Get Invoice Number
	# -------------------------------------------------------
	$inv_no = $dbf->GenerateInvoiceNo($centre_id);
	$inv_sl = substr($inv_no,5);
	//=======================================================
	
	$dt = date('Y-m-d h:m:s');
	
	$string="paid_date='$_POST[dated]',	payment_type='$_POST[payment_type]',paid_amt='$_POST[amt]',status='1',comments='$comments',fee_amt='$_POST[amt]',created_date=NOW(),created_by='$_SESSION[id]',type='direct',invoice_sl='$inv_sl',invoice_no='$inv_no'";
	
	$dbf->updateTable("student_fees",$string,"id='$_REQUEST[schid]'");
	
	// insert into student_comment table	
	if($comments != ''){
		$string1="student_id='$student_id',user_id='$_SESSION[id]',comments='$comments',date_time='$dt'";
		$dbf->insertSet("student_comment",$string1);
	}
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	$mobile_no = '';
	$student_id = $_REQUEST['student_id'];
	//============
	// SMS
	//============
	$mobile_no = $dbf->getDataFromTable("student","student_mobile","sms_status='1' And id='$student_id'");
	
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
			if($sms == "1"){
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
			}else if($sms == "3"){
				$sms_cont = $_REQUEST['contents'];
			}
			$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
			$msg = str_replace('%ad_amt%',$_REQUEST["amt"],$sms_cont);
			
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
}

if($_REQUEST['action']=='edit_payment'){
	
	//Current date and time
	$dt = date('Y-m-d h:m:s');
	
	//Current date and time
	$c_dt = date('Y-m-d');
	
	//Insert Original Records for a particular Payment According to schid
	$prev_pay = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'");
	
	//For record the previous data with current data if any changes with the any field
	if($prev_pay[comments] != $comments){
		
		$string2="fld_name='Comments',chg_from='$prev_pay[comments]',chg_to='$comments',by_user='$_SESSION[id]',date_time='$dt',student_id='$_REQUEST[id]',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
	}
	
	if($prev_pay[payment_type] != $_POST[payment_type]){
		
		$res_com_from = $dbf->strRecordID("common","*","id='$prev_pay[payment_type]'");
		$res_com_to = $dbf->strRecordID("common","*","id='$_REQUEST[payment_type]'");
		
		$string2="fld_name='Payment Type',chg_from='$res_com_from[name]',chg_to='$res_com_to[name]',by_user='$_SESSION[id]',date_time='$dt',student_id='$_REQUEST[id]',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
		
	}
	if($prev_pay[paid_amt] != $_POST[amt]){
		
		$string2="fld_name='Paid   Amount',chg_from='$prev_pay[paid_amt]',chg_to='$_POST[amt]',by_user='$_SESSION[id]',date_time='$dt',student_id='$_REQUEST[id]',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
		
	}
	//=================================================================================
		
	header("Location:search_manage.php?id=$_REQUEST[ids]&course_id=$_REQUEST[course_id]");
}

if($_REQUEST['action']=='sch_del'){
	$dbf->deleteFromTable("student_fees","id='$_REQUEST[schid]'");	
	header("Location:search_manage.php?id=$_REQUEST[ids]&course_id=$_REQUEST[course_id]");
}
?>
