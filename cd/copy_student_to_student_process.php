<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='update')
{
	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	$reg_dt = date('Y-m-d');
	
	$tran_id = $_REQUEST["tran_id"];
	$dtls = $dbf->strRecordID("transfer_student_to_student","*","id='$tran_id'");
		
	$string="status='$_REQUEST[status]',cd_comment='$comm'";
	//$dbf->updateTable("transfer_student_to_student",$string,"id='$tran_id'");
	
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != '')
	{
		$ids = $dbf->strRecordID("transfer_student_to_student", "*", "id='$tran_id'");
		
		$string_move="student_id='$ids[student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		//$dbf->insertSet("student_comment",$string_move);

		$string_move="student_id='$ids[to_student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		//$dbf->insertSet("student_comment",$string_move);		
	}
	//==========================================================
	
	if($_REQUEST["status"] == 'Approved')
	{
		
		# Source Group
		$source_group = $dtls["from_id"];
		
		# Source Student
		$source_student_id = $dtls["student_id"];
		
		# Destination Group
		$destination_group = $dtls["to_id"];
		
		# Destination Student (where student will be override)
		$destination_student_id = $dtls["to_student_id"];
		
		# From course id
		$from_course_id = $dtls["from_course_id"];
		
		# To course id
		$to_course_id = $dtls["to_course_id"];
		
		$enroll_dtls = $dbf->strRecordID("student_enroll","*","course_id='$from_course_id' And student_id='$source_student_id'");
		
		$string="discount=discount+'$enroll_dtls[discount]',other_amt=other_amt+'$enroll_dtls[other_amt]'";			
		//$dbf->updateTable("student_enroll",$string,"course_id='$to_course_id' And student_id='$destination_student_id'");
		
		$string="discount='0',other_amt='0'";
		$from_status=$dtls["from_status_id"];
		$to_status=$dtls["to_status_id"];
		
		switch($from_status)
		{
			case '3':	{
							switch($to_status)
							{
								case '3':
								case '4':	{
												echo "Update Fee...";
												//studentTransferFee($f_sdt,$f_stat,$cou_id,$t_sdt,$comm,$user,$ctr);
											}break;
							}
						}break;
			case '4':	{
							switch($to_status)
							{
								case '3':
								case '4':	{
												echo "Removed Student 1 and Update Fee...";
											}break;
							}
						}break;
			case '5':	{
							switch($to_status)
							{
								case '3':
								case '4':
								case '5':	{
												echo "Removed Student 1 and Update Fee...";
											}break;
							}
						}
			case '6':
			case '7':	{
							switch($to_status)
							{
								
								case '4':	{
												echo "Removed Student 1 and Update Fee...";
											}break;
							}
						}break;
			default:	{
							echo '
									<script type="text/javascript">
										alert("Select Status for Student 1!");
										self.parent.location.href="student_to_student_manage.php";
										self.parent.tb_remove();
									</script>
								';
						}break;
		}
		//$dbf->updateTable("student_enroll",$string,"course_id='$from_course_id' And student_id='$source_student_id'");
		//$person1=$dtls["from_status_id"];
		//$person2=$dtls["to_status_id"];
		/*
			1- Enquiry
			2- Potential
			3- Waiting
			4- Enrolled
			5- Active
			6- On Hold
			7- Cancelled
			8- Completed
			9- Legally Critical
			$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$_REQUEST[to_id]'");
			$group_string="parent_id='$_REQUEST[to_id]'";
			$dbf->updateTable("student_group_dtls",$group_string,"parent_id='$_REQUEST[from_id]' AND student_id='$student_id'");
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[to_id]'");
			//UPDATE NEW TRANSFER 
			$dbf->pullSchedule($_REQUEST[from_id]);
			$dbf->scheduleCall($prev_num,$student_id,$_REQUEST[to_id],$res_group[teacher_id]);
			//UPDATE NEW TRANSFER
		*/
/*		
		# If Waiting to Waitng
		if(($dtls["from_status_id"] == '3' || $dtls["from_status_id"] == '7') && ($dtls["to_status_id"] == '3' || $dtls["to_status_id"] == '7'))
		{
			$dbf->updateTable("student_fees", "student_id='$destination_student_id'", "course_id='$from_course_id' And student_id='$source_student_id'");
			# If Waiting to Enrolled or Active
		}
		else if(($dtls["from_status_id"] == '3' || $dtls["from_status_id"] == '7') && ($dtls["to_status_id"] == '4' || $dtls["to_status_id"] == '5'))
		{
			$dbf->updateTable("student_fees", "student_id='$destination_student_id'", "course_id='$from_course_id' And student_id='$source_student_id'");
			# If Enrolled to Enrolled
		}
		else if($dtls["from_status_id"] == '4'  && ($dtls["to_status_id"] == '4' || $dtls["to_status_id"] == '5'))
		{
			
			$dbf->updateTable("student_fees", "student_id='$destination_student_id'", "course_id='$from_course_id' And student_id='$source_student_id'");
			# Removing from Fees / Enrollment Table
			$dbf->deleteFromTable("student_enroll","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_group_dtls","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_fees","course_id='$from_course_id' And student_id='$source_student_id'");
			# Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$source_group'");
			# Get the range from (group_size) Table
			$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");		
			$my_group_id = $sizegroup["group_id"];
			if($prev_num_student == 0){	$my_group_id = 0;}
			# update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$my_group_id'";
			$dbf->updateTable("student_group",$string_g,"id='$source_group'");
			# update in group details table
			$string_g1="group_id='$my_group_id'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$source_group'");
			#d Destination Student Status (Potential Status)
			$date_time = date('Y-m-d H:i:s A');
			$string2="status_id='3',group_id='0'";
			$dbf->updateTable("student_moving",$string2,"course_id='$from_course_id' And student_id='$source_student_id'");	
			$string2="student_id='$source_student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='3'";
			$dbf->insertSet("student_moving_history",$string2);
			# If Enrolled to Waitng
		}
		else if(($dtls["from_status_id"] == '4' || $dtls["from_status_id"] == '5' || $dtls["from_status_id"] == '6') && $dtls["to_status_id"] == '3')
		{
			$dbf->updateTable("student_fees", "student_id='$destination_student_id'", "course_id='$from_course_id' And student_id='$source_student_id'");
			
			# Removing from Fees / Enrollment Table
			$dbf->deleteFromTable("student_enroll","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_group_dtls","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_fees","course_id='$from_course_id' And student_id='$source_student_id'");
						
			# Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$source_group'");
			
			# Get the range from (group_size) Table
			$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");		
			$my_group_id = $sizegroup["group_id"];
			
			if($prev_num_student == 0){	$my_group_id = 0;}
			
			# update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$my_group_id'";
			$dbf->updateTable("student_group",$string_g,"id='$source_group'");
			
			# update in group details table
			$string_g1="group_id='$my_group_id'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$source_group'");
			
			#d Destination Student Status (Potential Status)
			$date_time = date('Y-m-d H:i:s A');
			
			$string2="status_id='3',group_id='0'";
			$dbf->updateTable("student_moving",$string2,"course_id='$from_course_id' And student_id='$source_student_id'");	
			
			$string2="student_id='$source_student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='3'";
			$dbf->insertSet("student_moving_history",$string2);				
			
		# If Active / Hold to Active / Enrolled
		}
		else if(($dtls["from_status_id"] == '5' || $dtls["from_status_id"] == '6') && ($dtls["to_status_id"] == '4' || $dtls["to_status_id"] == '5' || $dtls["to_status_id"] == '6'))
		{
		
			$dbf->updateTable("student_fees", "student_id='$destination_student_id'", "course_id='$from_course_id' And student_id='$source_student_id'");
						
			# Removing from Fees / Enrollment Table
			$dbf->deleteFromTable("student_enroll","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_group_dtls","course_id='$from_course_id' And student_id='$source_student_id'");
			$dbf->deleteFromTable("student_fees","course_id='$from_course_id' And student_id='$source_student_id'");
						
			# Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$source_group'");
			
			# Get the range from (group_size) Table
			$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");		
			$my_group_id = $sizegroup["group_id"];
			
			if($prev_num_student == 0){	$my_group_id = 0;}
			
			# update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$my_group_id'";
			$dbf->updateTable("student_group",$string_g,"id='$source_group'");
			
			# update in group details table
			$string_g1="group_id='$my_group_id'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$source_group'");
			
			#d Destination Student Status (Potential Status)
			$date_time = date('Y-m-d H:i:s A');
			
			$string2="status_id='3',group_id='0'";
			$dbf->updateTable("student_moving",$string2,"course_id='$from_course_id' And student_id='$source_student_id'");	
			
			$string2="student_id='$source_student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='3'";
			$dbf->insertSet("student_moving_history",$string2);			
		}
*/
	}
/*	
	//Start SMS
	if($dbf->countRows("sms_gateway","status='Enable'") > 0){
		
		$userto = $dbf->strRecordID("user","*","id='$dtls[created_by]'");
		$mobile_no = $userto["mobile"];
		
		if($mobile_no != ''){
			
			$sms = $_REQUEST['sms'];
			if($sms == "1"){
				
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
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='43'");
				$msg = str_replace('%status%',$_REQUEST["status"],$sms_cont);
				
				//$msg = "Centre Director has been ".$_REQUEST["status"]." your request for transfer";
				$Message=$msg;
				
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				
				//================================
				//SAVED SMS
				//================================
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CD to SA',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("sms_history",$string);
				//================================
				//SAVED SMS
				//================================
			}
		}
	}
	//End SMS
*/
}
?>
<!--
<script type="text/javascript">
	self.parent.location.href='student_to_student_manage.php';
	self.parent.tb_remove();
</script>
-->