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

if($_REQUEST['action']=='classic')
{ 	
	$student_name = $first_name.' '.$family_name;
	$last_name_arabic = $Arabic->en2ar($family_name);
	
	$ar_familyname=(empty($_REQUEST['ar_mytxt_src3'])?$_SESSION['classic_familyname1']:$_REQUEST['ar_mytxt_src3']);
	$ar_gfathrname=(empty($_REQUEST['ar_mytxt_src2'])?$_SESSION['classic_gfathername1']:$_REQUEST['ar_mytxt_src2']);
	$ar_fathername=(empty($_REQUEST['ar_mytxt_src1'])?$_SESSION['classic_fathername1']:$_REQUEST['ar_mytxt_src1']);
	$ar_firstname=(empty($_REQUEST['ar_mytxt_src'])?$_SESSION['classic_name1']:$_REQUEST['ar_mytxt_src']);
	$en_firstname=(empty($_REQUEST['mytxt_src'])?$_SESSION['classic_name']:$_REQUEST['mytxt_src']);
	$en_fathername=(empty($_REQUEST['mytxt_src1'])?$_SESSION['classic_fathername']:$_REQUEST['mytxt_src1']); 
	$en_gfathername=(empty($_REQUEST['mytxt_src2'])?$_SESSION['classic_gfathername']:$_REQUEST['mytxt_src2']);
	$en_familyname=(empty($_REQUEST['mytxt_src3'])?$_SESSION['classic_familyname']:$_REQUEST['mytxt_src3']); 
	
	$_SESSION[gender] = $_REQUEST[gender];
	$_SESSION[gender1] = $_REQUEST[gender1];
	$_SESSION[id_type] = $_REQUEST[id_type];		
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	$_SESSION[classic_gname] = $_REQUEST[gname];
	
	$_SESSION[classic_name] = $_REQUEST[mytxt_src];
	$_SESSION[classic_fathername] = $_REQUEST[mytxt_src1];
	$_SESSION[classic_gfathername] = $_REQUEST[mytxt_src2];
	$_SESSION[classic_familyname] = $_REQUEST[mytxt_src3];
	$_SESSION[classic_name1] = $_REQUEST[ar_mytxt_src];
	$_SESSION[classic_fathername1] = $_REQUEST[ar_mytxt_src1];
	$_SESSION[classic_gfathername1] = $_REQUEST[ar_mytxt_src2];
	$_SESSION[classic_familyname1] = $_REQUEST[ar_mytxt_src3];
	
	$_SESSION[classic_sidn] = $_REQUEST[sidn];
	$_SESSION[classic_age] = $_REQUEST[age];
	$_SESSION[classic_email] = $_REQUEST[email];
	
	

	//Get Gender from Session
	if($_SESSION[gender]==''){
		$gender = $_SESSION[gender1];
	}else{
		$gender = $_SESSION[gender];
	}
			
	$comment = mysql_real_escape_string($_POST[comment]);
	$newcomment = mysql_real_escape_string($_POST[newcomment]);
	
	$dt = date('Y-m-d h:m:s');
		
	//Checking for duplcate Email Address
	if(empty($_POST['email']) || $_POST['email']==null)
	{
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'");
	}
	else
	{
		$num_email=$dbf->countRows('student',"email='$_POST[email]'");
		if($num_email>0)
		{
			header("Location:s_classic.php?msg=emailexist");
			exit;
		}
		else
		{
			$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
		}
	}
	if($_REQUEST[mobile] != '009665'){
		$num=$dbf->countRows('student',"student_mobile='$_POST[mobile]'");
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
	if($_REQUEST['id_type']=='National ID')
	{
		if($national_id != '')
		{
			$stu_id = $std->check($national_id);
			//echo $stu_id;exit;
			if($stu_id > 0)
			{
				//$dbf->updateTable("student","student_id='$national_id'","id='$sid'");
				//header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
			}else{header("Location:s_classic.php?student_id=$student_id&token=0_k_0&msg=invalid");exit;}
		}
	}
	#Corporate Account
	$corporate_account=count($dbf->genericQuery("SELECT student_id FROM corporate_students WHERE account='$_REQUEST[account]' AND sub_account='$_REQUEST[sub_account]'"));
	$corporate_student_limit=$dbf->getDataFromTable("corporate","no_of_students * no_of_class AS student_limit","code='$_REQUEST[corp_acct]'");
	$corporate_student=$dbf->getDataFromTable("corporate_students","COUNT(id)","code='$_REQUEST[corp_acct]'");
	$corporate_count_student=($corporate_student==0?0:$corporate_student + 1);
	
	if(!empty($_REQUEST['account']) && !empty($_REQUEST['corp_acct']))
	{
		if($corporate_account==1){header("Location:s_classic.php?msg=corp_acct_exist");exit;}
		if($corporate_count_student > $corporate_student_limit){header("Location:s_classic.php?msg=corp_acct_exceed");exit;}
		
	}
	#Corporate Account
	#Group Validation
	if(!empty($_REQUEST["group"]))
	{
		$student_limit=$dbf->getDataFromTable("common","name","type='class limit'");
		$total_student_group=$dbf->getDataFromTable("student_group_dtls","COUNT(student_id)","parent_id='$_REQUEST[group]'");
		$total_students=$total_student_group + 1;
		if($total_students >$student_limit)
		{
			header("Location:s_classic.php?msg=group_exceed");exit;
		}
	}
	#Group Validation
	if($_FILES['signature']['name']<>''){
		
		$filename1=$_REQUEST[txt_src]."-".$_FILES['signature']['name'];
		move_uploaded_file($_FILES[signature][tmp_name],"photo/".$filename1);
	}
	$address = mysql_real_escape_string($_POST[address]);	
	$string="	first_name='$en_firstname',
				first_name1='$ar_firstname',
				father_name='$en_fathername',
				father_name1='$ar_fathername',
				grandfather_name='$en_gfathrname',
				grandfather_name1='$ar_gfathrname',
				family_name='$en_familyname',
				family_name1='$ar_familyname',
				guardian_name='$_REQUEST[gname]',
				age='$_REQUEST[age]',
				guardian_contact='$_REQUEST[pcontact]',
				guardian_comment='$_REQUEST[information]',
				gender='$gender',
				country_id='$_REQUEST[country]',
				student_id='$national_id',
				student_mobile='$_REQUEST[mobile]',
				alt_contact='$_REQUEST[altmobile]',
				email='$_REQUEST[email]',
				student_comment='$comment',
				photo='$filename1',
				created_datetime='$dt',
				centre_id='$_SESSION[centre_id]',
				id_type='$_POST[id_type]',
				sms_status='1',
				area_code='$_REQUEST[area_code]',
				address='$address'";
		
	$sid = $dbf->insertSet("student",$string);
	
	//Comments if not Blank
	if($newcomment!=''){
		$string2="student_id='$sid',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
		$dbf->insertSet("student_comment",$string2);
	}
		
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
	#$count = $_POST[tcount];
	#for($i=1; $i<=$count; $i++){
	#	$c = "type".$i;
	#	$c = $_REQUEST[$c];		
	#	if($c != ''){
	#		$string="student_id='$sid',type_id='$c'";
	#		$dbf->insertSet("student_type",$string);
	#	}
	#}

	#$check_type=$dbf->countRows('student_type',"student_id='$sid'");
	#if(empty($check_type))
	#{	
		$string_student_type="student_id='$sid',type_id='$_REQUEST[type]'";
		$dbf->insertSet("student_type",$string_student_type);
	#}else{$dbf->updateTable("student_type","type_id='$_REQUEST[type]'","student_id='$student_id'");}
	
	//Get select group
	$group = $_REQUEST["group"];
	
	if($group > 0)
	{
		
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
			$group_range = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$group_range[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$group'");
			
			//update in group details table
			$string_g1="group_id='$group_range[group_id]'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
			#corporate account insert to db
			if(!empty($_REQUEST['account']) && !empty($_REQUEST['corp_acct']))
			{$dbf->addCorporateStudent($_REQUEST['corp_acct'],$_REQUEST['account'],$_REQUEST['sub_account'],$sid,$course_id,$_SESSION['id']);}
			#corporate account insert to db
		}else
		{
			
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
			$dbf->scheduleCall($prev_num,$sid,$_REQUEST["group"],$res_group[teacher_id]);//adjust schedules
			#corporate account insert to db
			if(!empty($_REQUEST['account']) && !empty($_REQUEST['corp_acct']))
			{$dbf->addCorporateStudent($_REQUEST['corp_acct'],$_REQUEST['account'],$_REQUEST['sub_account'],$sid,$course_id,$_SESSION['id']);}
			#corporate account insert to db
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
						/*
						$sms_cont = str_replace('%unit%',$unit,$sms_cont);
						$sms_cont = str_replace('%std%',$student,$sms_cont);
						$sms_cont = str_replace('%grp%',$g_name,$sms_cont);
						$msg = str_replace('%unt_fnd%',$no_unit_finined,$sms_cont);
						*/
/*
						$search = array('%unit%','%std%','%grp%','%unt_fnd%');
						$replace = array($unit,$student,$g_name,$no_unit_finined);
						$msg=str_replace($search, $replace, $sms_cont); 
					
					}else{
						$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='27'");
						/*
						$sms_cont = str_replace('%unit%',$unit,$sms_cont);
						$sms_cont = str_replace('%nos%',$no_student_remove,$sms_cont);					
						$sms_cont = str_replace('%grp%',$g_name,$sms_cont);					
						$sms_cont = str_replace('%std%',$student,$sms_cont);
						$sms_cont = str_replace('%ufin%',$no_unit_finined,$sms_cont);
						$msg = str_replace('%nos%',$no_student_remove,$sms_cont);	
						*/

						$search = array('%unit%','%nos%','%grp%','%std%','%ufin%');
						$replace = array($unit,$no_student_remove,$g_name,$no_unit_finined,$no_student_remove);
						$msg=str_replace($search, $replace, $sms_cont); 
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
				$grp_email_dtl=$dbf->genericQuery("
													SELECT sg.units, sg.group_name, sg.end_date, sgd.total
													FROM student_group sg
													LEFT JOIN (	SELECT COUNT( student_id ) AS total, parent_id
																FROM student_group_dtls
																WHERE parent_id='$group'
																)sgd ON sgd.parent_id = sg.id
													WHERE sg.id =  '$group'
												");
				foreach($grp_email_dtl as $ged):
					$send_units=$ged['units'];
					$send_gname=$ged['group_name'];
					$send_enddate=$ged['end_date'];
					$send_total=$ged['total'];
				endforeach;
				$to_user = $res_teacher[email];
				$from = $dbf->getDataFromTable("user","email","user_type='Administrator");
				if($to_user != '' || $admin_mail != ''){
					
					$headers .= 'MIME-Version: 1.0' . "\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
					$headers .= "From:".$from."\n";
					$email_cont = $dbf->strRecordID("email_templetes","*","id='6'");
					$email_msg = $email_cont["content"];
					$email_msg = str_replace('%teacher%',$res_teacher["name"],$email_msg);
					$search = array('%teacher%', '%unit%', '%group_name%','%students%','%end_date%');
					$replace = array($res_teacher["name"],$send_units,$send_gname,$send_total,$send_enddate);
					$email_msg=str_replace($search, $replace, $email_msg); 
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
		#PROCESS PAYMENT
		$dbf->processPayment($_POST["pay_status"],$sid,$course_id,$_POST["pay_type"],$_POST["pay_amt"],$_POST["discount"]);
		#PROCESS PAYMENT

	}
	//End re-sizing   >================================
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d h:i:s');
	$res_group = $dbf->strRecordID("student_group","*","id='$group'");	
	if($group > 0)
	{
		
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
	unset($_SESSION['classic_name1']);
	session_unregister('classic_name1');
	unset($_SESSION['classic_fathername1']);
	session_unregister('classic_fathername1');
	unset($_SESSION['classic_gfathername1']);
	session_unregister('classic_gfathername1');
	unset($_SESSION['classic_familyname1']);
	session_unregister('classic_familyname1');
	unset($_SESSION['classic_sidn']);
	session_unregister('classic_sidn');
	unset($_SESSION['classic_age']);
	session_unregister('classic_age');
	unset($_SESSION['classic_email']);
	session_unregister('classic_email');
	
	if($group > 0)
	{	
		header("Location:single-payment.php?student_id=$sid&course_id=$course_id");exit;
	}
	else
	{
		#POST ADVANCE PAYMENT
		if($_POST["pay_status"]!='' && $_POST["pay_type"]!='' && empty($group))
		{
			$count = $_POST[count];
			for($i=1; $i<=$count; $i++)
			{
				$c = "course".$i;
				$c = $_REQUEST[$c];		
				if($c != '')
				{$course_id=$c;}
			}
			$dbf->processPayment($_POST["pay_status"],$sid,$course_id,$_POST["pay_type"],$_POST["pay_amt"],$_POST["discount"]);
			header("Location:search_advance.php?student_id=$sid&course_id=$course_id");exit;
		}else{header("Location:search.php");exit;}
		#POST ADVANCE PAYMENT
	}

}

if($_REQUEST['action']=='edit'){
$student_id = $_REQUEST['student_id'];
	$res_photo = $dbf->strRecordID("student","*","id='$student_id'");
				
	if($_FILES['signature']['name']<>''){
		
		//Remove the previous Image (Signature)
		$filename1 = $res["first_name"]."-".$_FILES['signature']['name']."-".$student_id;
		
		$prev_file = $res["photo"];
		if($prev_file != ""){
			$prev_file = "photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
	
	if($_REQUEST["txt_src"] == ''){
		$student_name = $_REQUEST[mytxt_src].' '.$_REQUEST[mytxt_src3];
	}else{		
		$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	}
	
	$ar_first_name = $_REQUEST[ar_mytxt_src];
	
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
	$ar_familyname=$_REQUEST[ar_mytxt_src3];//aaaa
	$ar_gfathrname=$_REQUEST[ar_mytxt_src2];//bbbb
	$ar_fathername=$_REQUEST[ar_mytxt_src1];//cccc
	$ar_firstname=$_REQUEST[ar_mytxt_src];//dddd
	//Get Gender from Student Table
	if($res[age]>16){		
		$gender = $_REQUEST["gender"];
	}else{
		$gender = $_REQUEST["gender1"];
	}
	$address = mysql_real_escape_string($_POST[address]);
	$string="	first_name='$_POST[mytxt_src]',
				first_name1='$ar_firstname',
				father_name='$father_name',
				father_name1='$ar_fathername',
				grandfather_name='$grandfather_name',
				grandfather_name1='$ar_gfathrname',
				family_name='$family_name',
				family_name1='$ar_familyname',
				gender='$gender',
				country_id='$_POST[country]',
				alt_contact='$_POST[altmobile]',
				age='$_REQUEST[age]',
				guardian_name='$_REQUEST[gname]',
				guardian_contact='$_REQUEST[pcontact]',
				guardian_comment='$_REQUEST[information]',
				id_type='$_REQUEST[id_type]',
				area_code='$_POST[area_code]',
				address='$address'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
	$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
	
	$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
	$status=$dbf->getDataFromTable("student_moving","status_id","student_id='$student_id'");
	switch($status)
	{
		case 4:	{}break;
		default:{$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");}break;
	}
	
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
	#$dbf->deleteFromTable("student_type","student_id='$student_id'");
	
	#$count = $_POST[tcount];
	#for($i=1; $i<=$count; $i++){
	#	$c = "type".$i;
	#	$c = $_REQUEST[$c];
	#	if($c != ''){
	#		$string="student_id='$student_id',type_id='$c'";
	#		$dbf->insertSet("student_type",$string);
	#	}
	#}
	
	$check_type=$dbf->countRows('student_type',"student_id='$student_id'");
	if(empty($check_type))
	{	$string_student_type="student_id='$student_id',type_id='$_REQUEST[type]'";
		$dbf->insertSet("student_type",$string_student_type);
	}else{$dbf->updateTable("student_type","type_id='$_REQUEST[type]'","student_id='$student_id'");}
	
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
	if($_REQUEST["id_type"] == "Passport"){
		$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
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
			$prev_file = "photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
	
	if($_REQUEST["txt_src"] == ''){
		$student_name = $_REQUEST[mytxt_src].' '.$_REQUEST[mytxt_src3];
	}else{		
		$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	}
	
	$ar_first_name = $_REQUEST[ar_mytxt_src];
	
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
	$ar_familyname=$_REQUEST[ar_mytxt_src3];//aaaa
	$ar_gfathrname=$_REQUEST[ar_mytxt_src2];//bbbb
	$ar_fathername=$_REQUEST[ar_mytxt_src1];//cccc
	$ar_firstname=$_REQUEST[ar_mytxt_src];//dddd
	//Get Gender from Student Table
	if($res[age]>16){		
		$gender = $_REQUEST["gender"];
	}else{
		$gender = $_REQUEST["gender1"];
	}
	$address = mysql_real_escape_string($_POST[address]);
	$string="	first_name='$_POST[mytxt_src]',
				first_name1='$ar_firstname',
				father_name='$father_name',
				father_name1='$ar_fathername',
				grandfather_name='$grandfather_name',
				grandfather_name1='$ar_gfathrname',
				family_name='$family_name',
				family_name1='$ar_familyname',
				gender='$gender',
				country_id='$_POST[country]',
				alt_contact='$_POST[altmobile]',
				age='$_REQUEST[age]',
				guardian_name='$_REQUEST[gname]',
				guardian_contact='$_REQUEST[pcontact]',
				guardian_comment='$_REQUEST[information]',
				student_mobile='$_REQUEST[mobile]',
				id_type='$_REQUEST[id_type]',
				area_code='$_POST[area_code]',
				address='$address',
				corporate='$_POST[corp_acct]'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
	$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
	
	$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
	$status=$dbf->getDataFromTable("student_moving","status_id","student_id='$student_id'");
	/*
	switch($status)
	{
		case 4:	
		{}break;
		default:{$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");}break;
	}
	*/
	if($status<3)
	{$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");}
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
	#$dbf->deleteFromTable("student_type","student_id='$student_id'");
	#$count = $_POST[tcount];
	#for($i=1; $i<=$count; $i++){
	#	$c = "type".$i;
	#	$c = $_REQUEST[$c];
	#	if($c != ''){
	#		$string="student_id='$student_id',type_id='$c'";
	#		$dbf->insertSet("student_type",$string);
	#	}
	#}
	
	$check_type=$dbf->countRows('student_type',"student_id='$student_id'");
	if(empty($check_type))
	{	$string_student_type="student_id='$student_id',type_id='$_REQUEST[type]'";
		$dbf->insertSet("student_type",$string_student_type);
	}else{$dbf->updateTable("student_type","type_id='$_REQUEST[type]'","student_id='$student_id'");}
	 
	
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
			//header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=idexist");
			//header("Location:search.php");
			//$_SERVER['HTTP_REFERER'];
			if (preg_match("/s_edit.php/", $_SERVER['HTTP_REFERER'])) 
			{header("Location:search.php");
				
			} else {header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=idexist");}
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
	if($_REQUEST["id_type"] == "Passport"){
		$dbf->updateTable("student","student_id='$sid'","id='$student_id'");
	}
	header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
	
	exit;
	
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("student","id='$student_id'");
	header("Location:search.php");
	exit;
}

?>
