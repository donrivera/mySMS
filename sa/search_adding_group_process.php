<?php

ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");
$dbf = new User();

$student_id = $_REQUEST["student_id"];
	
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
#corporate account
$corporate_account=$dbf->countRows('corporate_students',"account='$_REQUEST[account]'");
$corporate_student_limit=$dbf->getDataFromTable("corporate","no_of_students * no_of_class AS student_limit","code='$_REQUEST[corp_acct]'");
$corporate_student=$dbf->getDataFromTable("corporate_students","COUNT(id)","code='$_REQUEST[corp_acct]'");
$corporate_count_student=($corporate_student==0?0:$corporate_student + 1);
#corporate account
$room_id = $res_group["room_id"];
$centre_id = $_SESSION["centre_id"];
$course_id = $res_group["course_id"];
$res_inv = $dbf->strRecordID("centre","invoice_from","id='$centre_id'");
$studentSendSMS=0;
$student_reenroll=0;
if($num_student == 0)
{	
	$duplicate_course=$dbf->countRows('student_group_dtls',"course_id='$course_id' && student_id='$student_id'");
	if($duplicate_course==1)
	{
		echo '<script type="text/javascript">alert("Duplicate Course!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($corporate_account==1)
	{
		echo '<script type="text/javascript">alert("Corporate Account Exists!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($corporate_count_student > $corporate_student_limit)
	{
		echo '<script type="text/javascript">alert("Corporate Account Exceeded!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	else
	{	$studentSendSMS=1;
		//Insert IN details table
		$str_d="parent_id='$group',student_id='$student_id',course_id='$course_id',centre_id='$centre_id',room_id='$room_id'";
		$dbf->insertSet("student_group_dtls",$str_d);
		//=====================================
	
		//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
		//=======================================================
		$date_time = date('Y-m-d H:i:s A');
	
		$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id'"); // Means If status is blank or Enrolled // And status_id <='3'
		if($num_st > 0)
		{
			$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
		
			$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);	
		}
		else
		{
			$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
		
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
		$string="student_id='$student_id',centre_id='$centre_id',group_id='$group',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";				
		$dbf->insertSet("student_enroll",$string);
		# update enrollment status
		$is_enrollment = $dbf->countRows('student_enroll',"student_id='$student_id'");
		if($is_enrollment == 1)
		{
			$string_status = "enrolled_status='New Enrollment'";
		}
		else
		{
			$string_status = "enrolled_status='Re-Enrollment'";
			$student_reenroll=1;
		}
		$dbf->updateTable("student_enroll", $string_status, "student_id='$student_id' And course_id='$course_id'");
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
		$string_g="group_id='$sizegroup[group_id]'";
		$dbf->updateTable("student_group",$string_g,"id='$group'");
		$string_g1="group_id='$sizegroup[group_id]'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
		#corporate account insert to db
		if(!empty($_REQUEST['account']) && !empty($_REQUEST['corp_acct']))
		{$dbf->addCorporateStudent($_REQUEST['corp_acct'],$_REQUEST['account'],$student_id,$course_id,$_SESSION['id']);}
		#corporate account insert to db
	}
}
else
{	#Add Student to Existing Class...
	$validate = $dbf->countRows('student_group_dtls',"parent_id='$group' && student_id='$student_id'");
	//Get number of student recently added
	$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$group'");
	//Get the range from (group_size) Table
	$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");
	//DON CODE 09-18-2013
	$new_enrolee=$dbf->countRows('student',"id='$student_id'");
	$total_students=$prev_num + $new_enrolee;
	//check duplicate course
	$group_status = $dbf->strRecordID("student_group","status","id='$group'");
	$duplicate_course=$dbf->countRows('student_group_dtls',"course_id='$course_id' && student_id='$student_id'");
	$date_time = date('Y-m-d H:i:s A');
	$student_limit=$dbf->getDataFromTable("common","name","type='class limit'");
	if($group_status=='Completed')
	{
		echo '<script type="text/javascript">alert("Group Status: Completed");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($total_students >$student_limit)
	{
		echo '<script type="text/javascript">alert("Group has '.$student_limit.' students!!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($duplicate_course > 0)
	{
		echo '<script type="text/javascript">alert("Duplicate Course!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($validate > 0)
	{
		echo '<script type="text/javascript">alert("Duplicate Entry!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($corporate_account==1)
	{
		echo '<script type="text/javascript">alert("Corporate Account Exists!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	elseif($corporate_count_student > $corporate_student_limit)
	{
		echo '<script type="text/javascript">alert("Corporate Account Exceeded!");self.parent.location.href="search.php?";self.parent.tb_remove();</script>';
	}
	else
	{	$studentSendSMS=1;
		$_SESSION['group_id']=$_REQUEST["group"];
		#DON 9-18-2013
		$dbf->scheduleCall($prev_num,$student_id,$_REQUEST["group"],$res_group[teacher_id]);
		#DON 09-18-2013
		#corporate account insert to db
		if(!empty($_REQUEST['account']) && !empty($_REQUEST['corp_acct']))
		{$dbf->addCorporateStudent($_REQUEST['corp_acct'],$_REQUEST['account'],$student_id,$course_id,$_SESSION['id']);}
		#corporate account insert to db
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$prev_group_id = $prev_group[group_id];
		$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id'");
		if($num_st > 0)
		{
			$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
			$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);	
		}
		else
		{
			$string_st="group_id='$group',status_id='4'"; //Enrolled Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
			$string2="student_id='$student_id',course_id='$course_id',group_id='$group',date_time='$date_time',user_id='$_SESSION[id]',status_id='4'";
			$dbf->insertSet("student_moving_history",$string2);	
		}
		$str_d="parent_id='$group',student_id='$student_id',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
		$dbf->insertSet("student_group_dtls",$str_d);	
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
		$string="student_id='$student_id',centre_id='$centre_id',group_id='$group',course_id='$course_id',fee_id='$course_fee_id',status_id='4',created_by='$_SESSION[id]',enroll_date='$current_date',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("student_enroll",$string);
		# update enrollment status
		$is_enrollment = $dbf->countRows('student_enroll',"student_id='$student_id'");
		if($is_enrollment == 1)
		{
			$string_status = "enrolled_status='New Enrollment'";
		}
		else
		{	$student_reenroll=1;
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
		#SEND EMAIL
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
		if($to_user != '' || $from != '')
		{
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
				//Start Save Mail	
				$dt = date('Y-m-d');
				$dttm = date('Y-m-d h:i:s');
				$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to_user',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("email_history",$string);
				// End Save Mail
		}
	}
}
if($studentSendSMS==1)
{
	$student_mobile = $dbf->getDataFromTable("student","student_mobile","id='$student_id'");
	if($student_mobile != '')
	{
		
		$UserName=UrlEncoding($sms_gateway['user']);
		$UserPassword=UrlEncoding($sms_gateway['password']);
		$Numbers=UrlEncoding($student_mobile);
		$Originator=UrlEncoding($sms_gateway['your_name']);
		$sms = $_REQUEST['sms'];
		if($student_reenroll==1)
		{
			$msg=$dbf->getDataFromTable("sms_templete","contents","id='25'");	
		}
		else
		{
			switch($sms)
			{
				case '3':	{$msg=$_REQUEST['contents'];}break;
				default:	{
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");		
								$msg = str_replace('%date%',$res_group["start_date"],$sms_cont);
							}break;
			}
		}
		$Message=$msg;
		if($sms_gateway["status"]=='Enable')
		{
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
