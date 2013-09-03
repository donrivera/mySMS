<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

//Object initialization of class validatesaid
include_once '../includes/validateSAID.class.php';
include("../includes/saudismsNET-API.php");
require '../I18N/Arabic.php';

//Object initialization
$std = new validateSAID();
$Arabic = new I18N_Arabic('Transliteration');

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
if($_REQUEST['action']=='classic'){

	if($_REQUEST[mytxt_src] == ''){
		$first_name=$_REQUEST[txt_src];
	}else{
		$first_name=$_REQUEST[mytxt_src];
	}
	
	$ar_first_name = $_REQUEST[ar_mytxt_src];
	
	if($_REQUEST[mytxt_src1] == ''){
		$father_name=$_REQUEST[txt_src1];
	}else{
		$father_name=$_REQUEST[mytxt_src1];
	}
	if($_REQUEST[mytxt_src2] == ''){
		$grandfather_name=$_REQUEST[txt_src2];
	}else{
		$grandfather_name=$_REQUEST[mytxt_src2];
	}
	if($_REQUEST[mytxt_src3] == ''){
		$family_name=$_REQUEST[txt_src3];
	}else{
		$family_name=$_REQUEST[mytxt_src3];
	}
	$last_name_arabic = $Arabic->en2ar($family_name);
	$student_name = $first_name.' '.$family_name;
	
	$_SESSION[gender] = $_REQUEST[gender];
	$_SESSION[gender1] = $_REQUEST[gender1];
	$_SESSION[id_type] = $_REQUEST[id_type];
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	$_SESSION[classic_gname] = $_REQUEST[gname];
	
	$_SESSION[classic_name] = $first_name;
	$_SESSION[classic_fathername] = $father_name;
	$_SESSION[classic_gfathername] = $grandfather_name;
	$_SESSION[classic_familyname] = $family_name;
	
	$_SESSION[classic_sidn] = $_REQUEST[sidn];
	$_SESSION[classic_age] = $_REQUEST[age];
	$_SESSION[classic_email] = $_REQUEST[email];
	
	//Get Gender from Session
	if($_SESSION[gender]==''){
		$gender = $_SESSION[gender1];
	}else{
		$gender = $_SESSION[gender];
	}
		
	$comment = mysql_real_escape_string($_REQUEST[comment]);
	$newcomment = mysql_real_escape_string($_REQUEST[newcomment]);
	
	$dt = date('Y-m-d h:m:s');
	
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_REQUEST[email]'");
	if($num_email!=0){
		header("Location:s_classic.php?msg=emailexist");
		exit;
	}else{
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
	}
	
	if($_REQUEST[mobile] != '009665'){
		$num=$dbf->countRows('student',"student_mobile='$_REQUEST[mobile]'");
		if($num>0){
			header("Location:s_classic.php?msg=mexist");
			exit;
		}
	}
	
	# Student National ID
	$national_id = $_REQUEST['sidn'];

	if($national_id != ''){
		//Duplicate checking student id
		$num = $dbf->countRows('student',"student_id='$national_id'");
		if($num > 0){
			//Error message sent to header
			header("Location:s_classic.php?student_id=$student_id&token=0_k_0&msg=idexist");
			exit;
		}
	}				
	if($national_id != ''){
		$stu_id = $std->check($national_id);
		//echo $stu_id;exit;
		if($stu_id > 0){
			//$dbf->updateTable("student","student_id='$national_id'","id='$sid'");
			//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
		}else{			
			header("Location:s_classic.php?student_id=$student_id&token=0_k_0&msg=invalid");
		}
	}
		
	if($_FILES['signature']['name']<>''){		
		$filename1=$_REQUEST[txt_src]."-".$_FILES['signature']['name'];
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
	}
	
	$string="first_name='$student_name',first_name1='$first_name',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',guardian_name='$_REQUEST[gname]',age='$_REQUEST[age]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',gender='$gender',student_id='$national_id',country_id='$_POST[country]',student_mobile='$_POST[mobile]',	alt_contact='$_REQUEST[altmobile]',email='$_REQUEST[email]',studentstatus_id='$_REQUEST[status]',student_comment='$comment',photo='$filename1',created_datetime='$dt',centre_id='$_SESSION[centre_id]',id_type='$_REQUEST[id_type]',sms_status='1'";
		
	$sid = $dbf->insertSet("student",$string);
			
	//Comments if not Blank
	if($newcomment!=''){
		$string2="student_id='$sid',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
		$dbf->insertSet("student_comment",$string2);
	}
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	//Potencial Status
	$string2="student_id='$sid',status_id='2',date_time='$date_time',user_id='$_SESSION[id]'";
	$dbf->insertSet("student_moving",$string2);	
	
	$string2="student_id='$sid',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
	$dbf->insertSet("student_moving_history",$string2);
	//========================================================
	
	//Interest course
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "course".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){			
			$string="student_id='$sid',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}
	
	// Lead
	$count = $_POST[leadcount];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){
			$string="student_id='$sid',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
	
	//Type
	$count = $_POST[tcount];
	for($i=1; $i<=$count; $i++){
		$c = "type".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){
			$string="student_id='$sid',type_id='$c'";
			$dbf->insertSet("student_type",$string);
		}
	}
	
	//Get select group
	$group = $_REQUEST["group"];
	
	if($group > 0){
		
		//Get the Group details with Centre wise
		$res_group = $dbf->strRecordID("student_group","*","id='$group'");
		
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
			$str_d="parent_id='$group',student_id='$sid',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
			$dbf->insertSet("student_group_dtls",$str_d);
									
			# Get active course fee
			$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
			
			//Insert in ENROLLED Table
			$string="student_id='$sid',centre_id='$centre_id',group_id='$group',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";	
			$dbf->insertSet("student_enroll",$string);
			
			# update enrollment status
			$is_enrollment = $dbf->countRows('student_enroll',"student_id='$sid'");
			if($is_enrollment == 1){
				$string_status = "enrolled_status='New Enrollment'";
			}else{
				$string_status = "enrolled_status='Re-Enrollment'";
			}
			$dbf->updateTable("student_enroll", $string_status, "student_id='$sid' And course_id='$course_id'");
			# End
			
			//=====================================
			
			//Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
			
			//Get the range from (group_size) Table
			$group_range = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$group_range[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$group'");
			
			//update in group details table
			$string_g1="group_id='$group_range[group_id]'";
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
							
				//insert into student_group_dtls table
				//====================================		
				$room_id = $res_group["room_id"];
				
				//Insert IN details table
				$str_d="parent_id='$group',student_id='$sid',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);				
												
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
				//Insert in ENROLLED Table
				$string="student_id='$sid',centre_id='$centre_id',group_id='$group',course_id='$course_id',fee_id='$course_fee_id',status_id='5',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("student_enroll",$string);			
				//=====================================
				
				# update enrollment status
				$is_enrollment = $dbf->countRows('student_enroll',"student_id='$sid'");
				if($is_enrollment == 1){
					$string_status = "enrolled_status='New Enrollment'";
				}else{
					$string_status = "enrolled_status='Re-Enrollment'";
				}
				$dbf->updateTable("student_enroll", $string_status, "student_id='$sid' And course_id='$course_id'");
				# End
	
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
				
				//Get the range from (group_size) Table
				$pgroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id

				$string_g="group_id='$pgroup[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$group'");
				
				$string_g1="group_id='$pgroup[group_id]'";
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
				}else {
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
				$group3 = $dbf->strRecordID("common","*","id='$res_group[group_id]'");
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
						$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='New student adding from Classic',mobile='$student_mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
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
					
					$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("email_history",$string);
					// End Save Mail
						
				}
				
								
				//===============
				// End Mail
				//===============
				
				//Start Save Mail	
				$dt = date('Y-m-d');
				$dttm = date('Y-m-d h:i:s');
				
				$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='SA',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("email_history",$string);
				// End Save Mail
			}else{
				
				//Insert IN details table		
				//Insert query here	
				$str_d="parent_id='$group',student_id='$sid',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);				
				
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_id' And status='1'");
				
				//Insert in ENROLLED Table
				$string="student_id='$sid',centre_id='$centre_id',group_id='$group',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("student_enroll",$string);				
				//=====================================
				
				# update enrollment status
				$is_enrollment = $dbf->countRows('student_enroll',"student_id='$sid'");
				if($is_enrollment == 1){
					$string_status = "enrolled_status='New Enrollment'";
				}else{
					$string_status = "enrolled_status='Re-Enrollment'";
				}
				$dbf->updateTable("student_enroll", $string_status, "student_id='$sid' And course_id='$course_id'");
				# End
				
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
				
				//Get the range from (group_size) Table
				$group_latest = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id
				$string_g="group_id='$group_latest[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$group'");
				
				//update in group details
				$string_g1="group_id='$group_latest[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
			}
		}
	}
	//End re-sizing   >================================
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');
	$res_group = $dbf->strRecordID("student_group","*","id='$group'");	
	if($group > 0){
		
		//Check the Group has been start or not
		$no_unit_finined = $dbf->countRows('ped_units',"group_id='$group'");	
		if($no_unit_finined > 0){
			
			//Active Status
			$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',status_id='5',date_time='$date_time',user_id='$_SESSION[id]'";
			$dbf->insertSet("student_moving",$string2);	
			
			$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
			$dbf->insertSet("student_moving_history",$string2);	
			
			//update in enroll table
			$string_g1="status_id='5'";
			$dbf->updateTable("student_enroll",$string_g1,"student_id='$sid' And course_id='$res_group[course_id]'");
			
		}else{
			
			//Enrolled Status
			$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',status_id='4',date_time='$date_time',user_id='$_SESSION[id]'";
			$dbf->insertSet("student_moving",$string2);	
			
			$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);
			
			//update in enroll table
			$string_g1="status_id='4'";
			$dbf->updateTable("student_enroll",$string_g1,"student_id='$sid' And course_id='$res_group[course_id]'");
		
		}
	}else{
			
		//Potencial Status
		$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',status_id='2',date_time='$date_time',user_id='$_SESSION[id]'";
		$dbf->insertSet("student_moving",$string2);	
		
		$string2="student_id='$sid',course_id='$res_group[course_id]',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
		$dbf->insertSet("student_moving_history",$string2);
		
		//update in enroll table
		$string_g1="status_id='2'";
		$dbf->updateTable("student_enroll",$string_g1,"student_id='$sid' And course_id='$res_group[course_id]'");
	}
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
	//Session destroyed	
	unset($_SESSION['gender']);
	session_unregister('gender');
	unset($_SESSION['gender1']);
	session_unregister('gender1');
	unset($_SESSION['pcontact']);
	session_unregister('pcontact');
	unset($_SESSION['information']);
	session_unregister('information');
	unset($_SESSION['classic_gname']);
	session_unregister('classic_gname');
	unset($_SESSION['classic_name']);
	session_unregister('classic_name');
	unset($_SESSION['classic_fathername']);
	session_unregister('classic_fathername');
	unset($_SESSION['classic_gfathername']);
	session_unregister('classic_gfathername');
	unset($_SESSION['classic_familyname']);
	session_unregister('classic_familyname');
	unset($_SESSION['classic_sidn']);
	session_unregister('classic_sidn');
	unset($_SESSION['classic_age']);
	session_unregister('classic_age');
	unset($_SESSION['classic_email']);
	session_unregister('classic_email');
	
	header("Location:search.php");
	exit;
}

if($_REQUEST['action']=='edit'){
	
	$student_id = $_REQUEST['student_id'];
	$res_photo = $dbf->strRecordID("student","*","id='$student_id'");
				
	if($_FILES['signature']['name']<>''){
		
		//Remove the previous Image (Signature)
		$filename1 = $res["first_name"]."-".$_FILES['signature']['name']."-".$student_id;
		
		$prev_file = $res["photo"];
		if($prev_file != ""){
			$prev_file = "../sa/photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
	
	if($_REQUEST["txt_src"] == ''){
		$student_name = $_REQUEST[mytxt_src].' '.$_REQUEST[mytxt_src3];
	}else{		
		$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$first_name1 = $_REQUEST["mytxt_src"];
	}else{
		$first_name1 = $_REQUEST["txt_src"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$father_name = $_REQUEST["mytxt_src1"];
	}else{
		$father_name = $_REQUEST["txt_src1"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$grandfather_name = $_REQUEST["mytxt_src2"];
	}else{
		$grandfather_name = $_REQUEST["txt_src2"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$family_name = $_REQUEST["mytxt_src3"];
	}else{
		$family_name = $_REQUEST["txt_src3"];
	}
	$last_name_arabic = $Arabic->en2ar($family_name);
	
	//Get Gender from Student Table
	if($res[age]>16){		
		$gender = $_REQUEST["gender"];
	}else{
		$gender = $_REQUEST["gender1"];
	}
	
	$ar_first_name = $_REQUEST[ar_mytxt_src];
	
	$string="first_name='$student_name',first_name1='$first_name1',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',gender='$gender',country_id='$_POST[country]',alt_contact='$_POST[altmobile]',age='$_REQUEST[age]',guardian_name='$_REQUEST[gname]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',id_type='$_REQUEST[id_type]'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');	
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' AND status_id <='1'"); // Means If status is blank or Enquiry
	if($num_st > 0){
		$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
		$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
		
		$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
		$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
		
		//Moving History table		
		$string2="student_id='$student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
		$dbf->insertSet("student_moving_history",$string2);
	}	
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
	//Comments if not Blank
	$newcomment = mysql_real_escape_string($_REQUEST["newcomment"]);
	if($newcomment != ''){
		$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$date_time'";
		$dbf->insertSet("student_comment",$string2);
	}
	
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_REQUEST[email]' AND id <> '$student_id'");
	if($num_email == 0){		
		$dbf->updateTable("student","email='$_REQUEST[email]'","id='$student_id'"); 
	}
	
	//Checking for duplcate Mobile Number
	$num_mob=$dbf->countRows('student',"student_mobile='$_REQUEST[mobile]' AND id <> '$student_id'");
	if($num_mob == 0){
		$dbf->updateTable("student","student_mobile='$_REQUEST[mobile]'","id='$student_id'"); 
	}
			
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$student_id'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "course".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){			
			$string="student_id='$student_id',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}
	
	$sid = $_REQUEST['sidn'];
	$cid = $_REQUEST["country"];
	
	if($sid != ''){
		//Duplicate checking student id
		$num = $dbf->countRows('student',"student_id='$sid'");
		if($num > 0){
			//Error message sent to header
			header("Location:s_edit.php?student_id=$student_id&token=0_k_0&msg=idexist");
			exit;
		}
	}				
	if($sid != ''){
		$stu_id = $std->check($sid);
		//echo $stu_id;exit;
		if($stu_id > 0){
			$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
			//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
		}else{			
			header("Location:s_edit.php?student_id=$student_id&token=0_k_0&msg=invalid");
		}
	}
	
	/*if($_REQUEST[id_type] == "National ID"){
		if($sid != ''){
			//Duplicate checking student id
			$num = $dbf->countRows('student',"student_id='$sid'");
			if($num > 0){
				//Error message sent to header
				header("Location:s_edit.php?student_id=$student_id&token=0_k_0&msg=idexist");
				exit;
			}
		}				
		if($sid != ''){
			$stu_id = $std->check($sid);
			//echo $stu_id;exit;
			if($stu_id > 0){
				$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
				//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
			}else{			
				header("Location:s_edit.php?student_id=$student_id&token=0_k_0&msg=invalid");
			}
		}else{
			header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
			exit;
		}
	}*/
		
	//Delete from student course table
	$dbf->deleteFromTable("student_lead","student_id='$student_id'");
	
	$count = $_POST[leadcount];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){
			$string="student_id='$student_id',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
		
	header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
	exit;
}

if($_REQUEST['action'] == 'edit_from_student_profile'){
	
	$student_id = $_REQUEST['student_id'];
	$res_photo = $dbf->strRecordID("student","*","id='$student_id'");
				
	if($_FILES['signature']['name']<>''){
		
		//Remove the previous Image (Signature)
		$filename1 = $res["first_name"]."-".$_FILES['signature']['name']."-".$student_id;
		
		$prev_file = $res["photo"];
		if($prev_file != ""){
			$prev_file = "../sa/photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
	
	if($_REQUEST["txt_src"] == ''){
		$student_name = $_REQUEST[mytxt_src].' '.$_REQUEST[mytxt_src3];
	}else{		
		$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$first_name1 = $_REQUEST["mytxt_src"];
	}else{
		$first_name1 = $_REQUEST["txt_src"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$father_name = $_REQUEST["mytxt_src1"];
	}else{
		$father_name = $_REQUEST["txt_src1"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$grandfather_name = $_REQUEST["mytxt_src2"];
	}else{
		$grandfather_name = $_REQUEST["txt_src2"];
	}
	
	if($_REQUEST["txt_src"] == ''){
		$family_name = $_REQUEST["mytxt_src3"];
	}else{
		$family_name = $_REQUEST["txt_src3"];
	}
	$last_name_arabic = $Arabic->en2ar($family_name);
	
	//Get Gender from Student Table
	if($res[age]>16){		
		$gender = $_REQUEST["gender"];
	}else{
		$gender = $_REQUEST["gender1"];
	}
	
	$ar_first_name = $_REQUEST[ar_mytxt_src];
	
	$string="first_name='$student_name',first_name1='$first_name1',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',gender='$gender',country_id='$_POST[country]',alt_contact='$_POST[altmobile]',age='$_REQUEST[age]',guardian_name='$_REQUEST[gname]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',id_type='$_REQUEST[id_type]'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
	$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
	
	$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
	$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');	
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' AND status_id <='1'"); // Means If status is blank or Enquiry
	if($num_st > 0){
				
		//Moving History table		
		$string2="student_id='$student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
		$dbf->insertSet("student_moving_history",$string2);
	}	
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
	//Comments if not Blank
	$newcomment = mysql_real_escape_string($_REQUEST["newcomment"]);
	if($newcomment != ''){
		$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$date_time'";
		$dbf->insertSet("student_comment",$string2);
	}
		
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_REQUEST[email]' AND id <> '$student_id'");
	if($num_email == 0){		
		$dbf->updateTable("student","email='$_REQUEST[email]'","id='$student_id'"); 
	}
	
	//Checking for duplcate Mobile Number
	$num_mob=$dbf->countRows('student',"student_mobile='$_REQUEST[mobile]' AND id <> '$student_id'");
	if($num_mob == 0){
		$dbf->updateTable("student","student_mobile='$_REQUEST[mobile]'","id='$student_id'"); 
	}
			
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$student_id'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "course".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){			
			$string="student_id='$student_id',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}
	
	//Type Delete from student course table
	$dbf->deleteFromTable("student_type","student_id='$student_id'");
	
	$count = $_POST[tcount];
	for($i=1; $i<=$count; $i++){
		$c = "type".$i;
		$c = $_REQUEST[$c];
		if($c != ''){
			$string="student_id='$student_id',type_id='$c'";
			$dbf->insertSet("student_type",$string);
		}
	}
	
	
	//Delete from student course table
	$dbf->deleteFromTable("student_lead","student_id='$student_id'");
	
	$count = $_POST[leadcount];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){
			$string="student_id='$student_id',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
	
	$sid = $_REQUEST['sidn'];
	$cid = $_REQUEST["country"];
	
	if($sid != ''){
		//Duplicate checking student id
		$num = $dbf->countRows('student',"student_id='$sid'");
		if($num > 0){
			//Error message sent to header
			header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=idexist");
			exit;
		}
	}				
	if($sid != ''){
		$stu_id = $std->check($sid);
		//echo $stu_id;exit;
		if($stu_id > 0){
			$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
			//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
		}else{			
			header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=invalid");
		}
	}
	
	/*if($_REQUEST[id_type] == "National ID"){
		if($sid != ''){
			//Duplicate checking student id
			$num = $dbf->countRows('student',"student_id='$sid'");
			if($num > 0){
				//Error message sent to header
				header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=idexist");
				exit;
			}
		}				
		if($sid != ''){
			$stu_id = $std->check($sid);
			//echo $stu_id;exit;
			if($stu_id > 0){
				$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
				//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
			}else{			
				header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=invalid");
			}
		}else{
			header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
			exit;
		}
	}*/
				
	header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
	exit;
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("student","id='$_REQUEST[id]'");
	header("Location:s_manage.php");
}
?>
