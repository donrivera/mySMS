<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	
	//Current date
	$current_date = date('Y-m-d');
	
	//Get the logo path
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	//Get the Group details with Centre wise
	$res_group = $dbf->strRecordID("student_group","*","id='$_POST[group]'");
	
	//SMS Gateway information from the database
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	
	//Get the Mobile Number of the particular Teacher 
	$res_teacher = $dbf->strRecordID("teacher","*","id='$res_group[teacher_id]'");
	
	//Teacher mobile number
	$student_mobile_no = $res_teacher['mobile'];	
	
	//Admin details
	$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");			
	$admin_mail = $res_admin[email];
	
	$course_ids = $res_group["course_id"];
	
	//Note (About the group re-sizing)
	//Sizes and number of units for groups are to be referenced from the (group_size) table in the admin panel rules.
	//Start re-rezing >================================
			
	//Get the Numbers of students in a particular Group with Centre wise
	$num_student = $dbf->countRows('student_group_dtls',"parent_id='$_POST[group]'");
	
	//Get the Centre Invoice No
	$res_inv = $dbf->strRecordID("centre","invoice_from","id='$_SESSION[centre_id]'");
				
	//This is the Previous (Count Number of Students)
	//===============================================
	if($num_student == 0){
		//insert into student_group_dtls table
		//====================================		
		$room_id = $res_group["room_id"];
		$centre_id = $_SESSION["centre_id"];
		
		//Insert IN details table
		$count = $_REQUEST[count];
		for($i = 1; $i<=$count; $i++){
			$id1 = "id".$i;
			$id1 = $_REQUEST[$id1];
			if($id1 != ''){
				
				//Insert query here			
				$str_d="parent_id='$_POST[group]',student_id='$id1',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);		
								
				# Get active course fee
				$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_ids' And status='1'");
				
				//Insert in ENROLLED Table
				$string="student_id='$id1',centre_id='$centre_id',group_id='$_POST[group]',course_id='$course_ids',fee_id='$course_fee_id',created_by='$_SESSION[id]',enroll_date='$current_date'";	
				$dbf->insertSet("student_enroll",$string);
				
				# update enrollment status
				$is_enrollment = $dbf->countRows('student_enroll',"student_id='$id1'");
				if($is_enrollment == 1){
					$string_status = "enrolled_status='New Enrollment'";
				}else{
					$string_status = "enrolled_status='Re-Enrollment'";
				}
				$dbf->updateTable("student_enroll", $string_status, "student_id='$id1' And course_id='$course_ids'");
				# End
				
				# Delete from Student Moving Table Previous records of Particular student
				$dbf->deleteFromTable("student_moving", "student_id='$id1' And (course_id=0 OR course_ud='$course_ids')");
				
				//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
				//=======================================================
				//Moving History table
				$date_time = date('Y-m-d H:i:s A');
				
				$string_st="student_id='$id1',status_id='4',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]'"; //Enroll Status		
				$dbf->insertSet("student_moving",$string_st);
				
				$string2="student_id='$id1',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
				$dbf->insertSet("student_moving_history",$string2);	
				
				//=======================================================
				//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		
			}
		}
		//=====================================
		
		//Get number of student recently added
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_POST[group]'");
		
		//Get the range from (group_size) Table
		$group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
				
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$string_g="group_id='$group[group_id]'";
		$dbf->updateTable("student_group",$string_g,"id='$_POST[group]'");
		
		//update in group details table
		$string_g1="group_id='$group[group_id]'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_POST[group]'");
		
		//Start Sending SMS if student is going RE-ENROLLMENT
		if($dbf->countRows("student_group_dtls","student_id='$id1'") > 1){
			$student = $dbf->strRecordID("student","*","id='$id1' And sms_status='1'");
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
					//$msg = "Thanks for Re-enrollment.";
					$sms = $_REQUEST['sms'];
					if($sms == "1" || $sms == "3"){
						if($sms == "1" || $sms == "3"){
							$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='25'");
							$Message=$sms_cont;
						
							// Storing Sending result in a Variable.
							SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);					
							//================================
							//SAVED SMS
							//================================
							$cr_date = date('Y-m-d H:i:s A');
							
							$string="dated='$cr_date',user_id='0',msg='$Message',send_to='student',mobile='$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='For Re-Enrollment',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
							$sms_id = $dbf->insertSet("sms_history",$string);
		
							$string1="parent_id='$sms_id',student_id='$student[id]'";
							$dbf->insertSet("sms_history_dtls",$string1);
							
							//SAVED SMS
						}
					}
				}
			}
		}
		//End
	}else{
		//Get Previous Group after re-arranged
		//====================================
		
		//Get number of student recently added
		$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$_POST[group]'");
				
		//Get the range from (group_size) Table
		$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");
				
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$prev_group_id = $prev_group[group_id];
		
		//Check whether selected group has been start or not
		$no_unit_finined = $dbf->countRows('ped_units',"group_id='$_POST[group]'");
		
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
			$count = $_REQUEST[count];
			$no_student_remove = 0;
			for($i = 1; $i<=$count; $i++){
				$id2 = "id".$i;
				$id2 = $_REQUEST[$id2];
				if($id2 != ''){
					//Insert query here			
					$str_d="parent_id='$_POST[group]',student_id='$id2',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
					$dbf->insertSet("student_group_dtls",$str_d);				
										
					# Get active course fee
					$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_ids' And status='1'");
							
					//Insert in ENROLLED Table
					$string="student_id='$id2',centre_id='$centre_id',group_id='$_POST[group]',course_id='$course_ids',fee_id='$course_fee_id',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("student_enroll",$string);
					
					# update enrollment status
					$is_enrollment = $dbf->countRows('student_enroll',"student_id='$id2'");
					if($is_enrollment == 1){
						$string_status = "enrolled_status='New Enrollment'";
					}else{
						$string_status = "enrolled_status='Re-Enrollment'";
					}
					$dbf->updateTable("student_enroll", $string_status, "student_id='$id2' And course_id='$course_ids'");
					# End
					
					$no_student_remove = $no_student_remove+1;					
					
					# Delete from Student Moving Table Previous records of Particular student
					$dbf->deleteFromTable("student_moving", "student_id='$id1' And (course_id=0 OR course_ud='$course_ids')");
					
					//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
					//=======================================================
					//Moving History table
					$date_time = date('Y-m-d H:i:s A');
					
					$string_st="student_id='$id2',status_id='5',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]'"; //Active Status		
					$dbf->insertSet("student_moving",$string_st);
					
					$string2="student_id='$id2',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
					$dbf->insertSet("student_moving_history",$string2);	
					
					//=======================================================
					//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
										
					//Start Sending SMS if student is going RE-ENROLLMENT
					if($dbf->countRows("student_group_dtls","student_id='$id2'") > 1){
						$student = $dbf->strRecordID("student","*","id='$id2' And sms_status='1'");
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
								//$msg = "Thanks for Re-enrollment.";
								$sms = $_REQUEST['sms'];
								if($sms == "1" || $sms == "3"){
									if($sms == "1" || $sms == "3"){
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='25'");
										$Message=$sms_cont;
									
										// Storing Sending result in a Variable.
										SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);					
										//================================
										//SAVED SMS
										//================================
										$cr_date = date('Y-m-d H:i:s A');
										
										$string="dated='$cr_date',user_id='0',msg='$Message',send_to='student',mobile='$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='For Re-Enrollment',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
										$sms_id = $dbf->insertSet("sms_history",$string);
										
										$string1="parent_id='$sms_id',student_id='$id2'";
										$dbf->insertSet("sms_history_dtls",$string1);
										//SAVED SMS
									}
								}
							}
						}
					}
				}
			}
			//=====================================
			
			//Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_POST[group]'");
			
			//Get the range from (group_size) Table
			$group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$group[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$_POST[group]'");
			
			$string_g1="group_id='$group[group_id]'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_POST[group]'");
			
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
			if ($dec_right_value % 2 == 0){				//echo "number is even";
				$dec_right_value_is = substr($curr_pending_unit,0,2); // 18.66 => 18
			}else{
				//echo "number is odd";
				$dec_right_value_is = ceil($curr_pending_unit); // 63.44 => 64
			}
			
			//Update the previous Group here
			//========================================		
			$string_g="effect_units='$dec_right_value_is'";
			$dbf->updateTable("centre_group_size",$string_g,"centre_id='$_SESSION[centre_id]' And group_id='$prev_group_id'");
						
			// Check the Group which is middle o the Start group to End group
			// Example :G1 - G3 means (G2 is middle)
			
			//Get End unit of First group means => G1 group
			$first_unit = $prev_group["size_to"];
	
			//Get Start unit of Last group means => G3 group
			$last_unit = $group["size_from"];
			
			//Get the number group between two group (G1 to G3)
			$num_middle_group = $dbf->countRows('group_size',"(size_to > '$first_unit' And size_from < '$last_unit')");
			
			//If exist then do the work
			if($num_middle_group > 0){
			
				//Start Loop for middle group
				foreach($dbf->fetchOrder('group_size',"(size_to > '$first_unit' And size_from < '$last_unit')","id") as $valmiddle){
					
					//Get the value decimal point (68.57) => 68
					//echo $curr_finished_unit;
					$dec_right_value_middle = substr($curr_finished_unit,0,2);
					
					//Check Odd or Even Number
					if ($dec_right_value_middle % 2 == 0){
						//echo "number is even";
						$dec_right_value_is_middle = substr($dec_right_value_middle,0,2); // 18.66 => 18
					}else{
						//echo "number is odd";
						$dec_right_value_is_middle = ceil($curr_finished_unit); // 63.44 => 64
					}
					
					//Update the previous Group here
					//========================================		
					$string_g="effect_units='$dec_right_value_is_middle'";
					$dbf->updateTable("centre_group_size",$string_g,"centre_id='$_SESSION[centre_id]' And group_id='$valmiddle[group_id]'");					
				}//End Loop				
			}
						
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
				$sms = $_REQUEST['sms'];
				if($sms == "1" || $sms == "3"){
					if($sms == "1"){
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
						
						$Message=$msg;
						
						// Storing Sending result in a Variable.
						if($sms_gateway["status"]=='Enable'){
																		
							SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
						
							$cr_date = date('Y-m-d H:i:s A');
							$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Teacher',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='Adding student from Centre Director (Exception Processing)',page_full_path='$_SERVER[REQUEST_URI]'";	
							$dbf->insertSet("sms_history",$string);
						}
					}
				}
			}
			
			//======================
			// Start Mail to Teacher
			//======================
			
			//Teacher Email address
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
			//insert into student_group_dtls table
			//====================================		
			$room_id = $res_group["room_id"];
			$centre_id = $_SESSION[centre_id];
			
			//Insert IN details table
			$count = $_REQUEST[count];
			for($i = 1; $i<=$count; $i++){
				
				$id3 = "id".$i;
				$id3 = $_REQUEST[$id3];
				if($id3 != ''){
					
					//Insert query here			
					$str_d="parent_id='$_POST[group]',student_id='$id3',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
					$dbf->insertSet("student_group_dtls",$str_d);
										
					# Get active course fee
					$course_fee_id = $dbf->getDataFromTable("course_fee", "id", "course_id='$course_ids' And status='1'");
	
					//Insert in ENROLLED Table
					$string="student_id='$id3',centre_id='$centre_id',group_id='$_POST[group]',course_id='$course_ids',fee_id='$course_fee_id',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("student_enroll",$string);
					
					# update enrollment status
					$is_enrollment = $dbf->countRows('student_enroll',"student_id='$id3'");
					if($is_enrollment == 1){
						$string_status = "enrolled_status='New Enrollment'";
					}else{
						$string_status = "enrolled_status='Re-Enrollment'";
					}
					$dbf->updateTable("student_enroll", $string_status, "student_id='$id3' And course_id='$course_ids'");
					# End
					
					//Start Sending SMS if student is going RE-ENROLLMENT
					if($dbf->countRows("student_group_dtls","student_id='$id3'") > 1){
						$student = $dbf->strRecordID("student","*","id='$id3' And sms_status='1'");
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
								$sms = $_REQUEST['sms'];
								if($sms == "1" || $sms == "3"){
									if($sms == "1" || $sms == "3"){
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='25'");
										$Message=$sms_cont;
									
										// Storing Sending result in a Variable.
										SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);					
										//================================
										//SAVED SMS
										//================================
										$cr_date = date('Y-m-d H:i:s A');
										
										$string="dated='$cr_date',user_id='0',msg='$Message',send_to='student',mobile='$mobile_no',centre_id='$_SESSION[centre_id]',msg_from='For Re-Enrollment',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
										$sms_id = $dbf->insertSet("sms_history",$string);
										
										$string1="parent_id='$sms_id',student_id='$id3'";
										$dbf->insertSet("sms_history_dtls",$string1);
										//SAVED SMS
									}
								}
							}
						}
					}
					//End
					
					# Delete from Student Moving Table Previous records of Particular student
					$dbf->deleteFromTable("student_moving", "student_id='$id1' And (course_id=0 OR course_ud='$course_ids')");
					
					//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
					//=======================================================
					//Moving History table
					$date_time = date('Y-m-d H:i:s A');
					
					$string_st="student_id='$id3',status_id='4',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]'"; //Enroll Status		
					$dbf->insertSet("student_moving",$string_st);
					
					$string2="student_id='$id3',course_id='$course_ids',group_id='$_POST[group]',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
					$dbf->insertSet("student_moving_history",$string2);	
					
					//=======================================================
					//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
				}
			}
			//=====================================
			
			//Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$_POST[group]'");
			
			//Get the range from (group_size) Table
			$group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$group[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$_POST[group]'");
			
			//update in group details
			$string_g1="group_id='$group[group_id]'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$_POST[group]'");
		}
		//====================================
		//End
		//====================================	
		
	}
	
	
	// SMS for Alert to student course has been started from 04-Feb-2012
	//==================================================================
	$student_mobile_no1 = '';
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_POST[group]'","","","") as $val_course){
		
		$res_student = $dbf->strRecordID("student","student_mobile","id='$val_course[student_id]' And sms_status='1'");		
		// Check variable is black or not
		if($student_mobile_no1 == ''){
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				//First mobile Number in the variable
				$student_mobile_no1 = $res_student[student_mobile];			
			}
		}else{
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				//Concate the mobile Number in the variable
				$student_mobile_no1 = $student_mobile_no1.",".$res_student[student_mobile];
			}
		}		
	}
	
	//This is for SMS to student
	if($student_mobile_no1 != ''){	
		// Your username
		$UserName=UrlEncoding($sms_gateway[user]);
		
		// Your password
		$UserPassword=UrlEncoding($sms_gateway[password]);
		
		// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
		$Numbers=UrlEncoding($student_mobile_no1);
		
		// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
		$Originator=UrlEncoding($sms_gateway[your_name]);
		
		// Your Message in English or arabic or both.
		// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
		
		//Get group start date 
		$start_group = $dbf->strRecordID("student_group","start_date","id='$_POST[group]'");
		$dt = date('d-M-Y',strtotime($start_group["start_date"]));
		
		//Message
		//$msg = "Dear student, Your class will be start on ".$dt;		
		$sms = $_REQUEST['sms'];
		if($sms == "1" || $sms == "3"){
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='28'");
			$msg = str_replace('%date%',$dt,$sms_cont);
				
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			if($sms_gateway["status"]=='Enable'){
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
				$cr_date = date('Y-m-d H:i:s A');
				$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='student',type='0',centre_id='$_SESSION[centre_id]',msg_from='Adding student from Centre Director (Exception Processing)',mobile='$student_mobile_no1',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$sms_id = $dbf->insertSet("sms_history",$string);
				
				foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_POST[group]'","","","") as $val_course){
					$string1="parent_id='$sms_id',student_id='$val_course[student_id]'";
					$dbf->insertSet("sms_history_dtls",$string1);
				}				
			}
		}		
	}
	//==================================================================
	
	
	//mail to Administrator for Number students in All centre
	//=======================================================
	$num_grp = $dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]'");
	if($num_grp > 0){
		
		//Centre director details
		$res_cd = $dbf->strRecordID("user","*","id='$_SESSION[id]'");	
		$from=$res_cd[email];
			
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From:".$from."\n";
		
		$body1= '';
		
		foreach($dbf->fetchOrder('centre',"","","","") as $centre){
			$num_grp_student=$dbf->countRows('student_group',"centre_id='$centre[id]'");
			if($num_grp_student > 0){
				$body1=$body1.'<table width="700" border="1" bordercolor="#999999" cellspacing="0" cellpadding="0">
					  <tr>
					    <td height="30" align="left" valign="middle" bgcolor="#FF9900"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
					    <td align="left" valign="middle" bgcolor="#FF9900">&nbsp;</td>
  </tr>
					  <tr>
						<td width="168" height="30" align="left" valign="middle">
						<table width="100%" border="1" bordercolor="#00FF00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
						  <tr>
							<td height="30" align="center" valign="middle" bgcolor="#CC9900" style="font:Arial, Helvetica, sans-serif; font-weight:bold;">'.$centre[name].'</td>
						  </tr>
						</table></td>
						<td width="532">&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" style="padding-top:5px; padding-bottom:5px;">
						
						<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
						  <tr>
							<td width="22%" height="25" align="center" valign="middle" bgcolor="#000000" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#FFFFFF;">Group Name</td>
							<td width="17%" align="center" valign="middle" bgcolor="#000000" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#FFFFFF;">Group Type</td>
							<td width="18%" height="25" align="center" valign="middle" bgcolor="#000000" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#FFFFFF;">Start Date</td>
							<td width="19%" height="25" align="center" valign="middle" bgcolor="#000000" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#FFFFFF;">End Date</td>
							<td width="24%" height="25" align="center" valign="middle" bgcolor="#000000" style="font:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#FFFFFF;">No of Students</td>
						  </tr>';
							foreach($dbf->fetchOrder('student_group',"centre_id='$centre[id]'","id","","") as $group){
								//Get group name
								$res_commom = $dbf->strRecordID("common","*","id='$group[group_id]'");
								
								$res_no_students = $dbf->strRecordID("student_group_dtls","COUNT(parent_id)","parent_id='$group[id]'");
								$no_students = $res_no_students["COUNT(parent_id)"];
						  		$body1= $body1.'<tr>
								<td align="center" valign="middle" height="25" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">'.$group[group_name].'</td>
								<td align="center" valign="middle" height="25" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">'.$res_commom[name].'</td>
								<td align="center" valign="middle" height="25" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">'.date("d-M-Y",strtotime($group[start_date])).'</td>
								<td align="center" valign="middle" height="25" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">'.date("d-M-Y",strtotime($group[end_date])).'</td>
								<td align="center" valign="middle" height="25" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;">'.$no_students.'</td>
							  </tr>';
						  }
						$body1= $body1.'</table></td>
					  </tr>
					  <tr>
						<td height="2" bgcolor="#CCCCCC"></td>
						<td height="2" bgcolor="#CCCCCC"></td>
					  </tr>
				</table>';	
			}
		}
		
		$subject ="Alerts for number students in All centre !!!";
		mail($admin_mail,$subject,$body1,$headers);
		
		//Start Save Mail	
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
	
	}
	//=============================================================
	
	//Check the Exam vacation for a particular Centre
	//=============================================================
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
			foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_POST[group]'","id") as $val_student){
				
				//Get the student email address
				$res_s = $dbf->strRecordID("user","email","id='$val_student[student_id]' And email<>''");
				if($to == ''){
					$to = $res_s["email"];
				}else{
					$to = $to.",".$res_s["email"];
				}
			}
			
			//If mail exist
			if($to != ''){
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
	//=============================================================
	
	
	//=============================================================
	// Insert in Group History Table
	//=============================================================
	
	//Get centre id
	$centre_id = $_SESSION[centre_id];
	
	//Insert in history Main table
	
	$hdt = date('Y-m-d h:i:s');
	
	$string="dated='$hdt',centre_id='$_SESSION[centre_id]',group_id='$_POST[group]',user_id='$_SESSION[id]',type='0'";
	$hid = $dbf->insertSet("student_group_history",$string);

	//Insert IN details table
	$count = $_REQUEST[count];
	for($i = 1; $i<=$count; $i++){
		$id4 = "id".$i;
		$id4 = $_REQUEST[$id4];
		if($id4 != ''){
			
			//Insert query here			
			$str_d="parent_id='$hid',student_id='$id4'";
			$dbf->insertSet("student_group_history_dtls",$str_d);
			
			# ==========================================================
			# Insert in Student Comments Table (student_comment)
			$dt = date('Y-m-d h:i:s');
			$comm = mysql_real_escape_string($_REQUEST['comment']);
			
			if($comm != ''){
				$string_move="student_id='$id4',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
				$dbf->insertSet("student_comment",$string_move);
			}
			# ==========================================================
		}
	}	
	//=============================================================
	// End
	//=============================================================
	
	header("Location:ep_adding_student.php");   
}
?>