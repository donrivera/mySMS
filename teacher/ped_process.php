<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$uid = $_SESSION['uid'];

//Check list string
if($_POST[checklist]!=''){
	$chklist = implode(",",$_POST[checklist]);
}
if($_POST[ini_feedback]!=''){
	$ini_feedback = implode(",",$_POST[ini_feedback]);
}
if($_POST[counselling]!=''){
	$counselling = implode(",",$_POST[counselling]);
}
if($_POST[mate]!=''){
	$mate = implode(",",$_POST[mate]);
}

$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
$course_id = $res_group[course_id];

//Check duplicate
$num=$dbf->countRows('ped',"teacher_id='$uid' and group_id='$_REQUEST[cmbgroup]' and course_id='$course_id'");
if($num == 0){
	
	$string="teacher_id='$uid',group_id='$_POST[cmbgroup]',course_id='$course_id',estart_date='$_POST[estart_date]',material='$mate',bl='$_POST[bl]',arf_submit='$_POST[arf]',level='$_POST[level]',comments='$_POST[comments]',location='$_POST[location]',checklist='$chklist',point_cover1='$_POST[point_cover1]',point_date1='$_POST[point_date1]', point_cover2='$_POST[point_cover2]', point_date2='$_POST[point_date2]', ini_feedback='$ini_feedback', inst1='$_POST[inst1]', date1='$_POST[date1]',arf1='$_POST[arf1]', dby1='$_POST[dby1]', dby1_date1='$_POST[dby1_date1]', cby1='$_POST[cby1]', cby1_date1='$_POST[cby1_date1]', inst2='$_POST[inst2]', inst2_date2='$_POST[inst2_date2]', counselling='$counselling', inst3='$_POST[inst3]', inst3_date3='$_POST[inst3_date3]', inst4='$_POST[inst4]', inst4_date4='$_POST[inst4_date4]', not_apply='$_POST[not_apply]',distrbute_by='$_POST[distrbute_by]',distrbute_date='$_POST[distrbute_date]',collect_by='$_POST[collect_by]',collect_date='$_POST[collect_date]',pro_report='$_POST[pro_report]'";
	
	//Excute the query And Get the recent Insert ID
	$id = $dbf->insertSet("ped",$string);
		
	//Insert in PED Units table
	$ucount = $_POST[ucount];
	for($i=1; $i<=$ucount; $i++){
		$dt = "u_dated".$i;
		$dt = $_REQUEST[$dt];
		
		$material_overed = "material_overed".$i;
		$material_overed = $_REQUEST[$material_overed];
		
		$homework = "homework".$i;
		$homework = $_REQUEST[$homework];
		
		if($dt != ''){
			//Check duplicate
			$num=$dbf->countRows('ped_units',"units='$i' AND teacher_id='$uid' and group_id='$_POST[cmbgroup]' and course_id='$course_id'");
			if($num==0){
				$string="ped_id='$id',teacher_id='$uid', group_id='$_POST[cmbgroup]',course_id='$course_id', units='$i',dated='$dt', material_overed='$material_overed', homework='$homework'";
				$dbf->insertSet("ped_units",$string);
			}else{
				$string="dated='$dt',material_overed='$material_overed',homework='$homework'";
				$dbf->updateTable("ped_units",$string,"teacher_id='$uid' AND units='$i' and group_id='$_POST[cmbgroup]' and course_id='$course_id'");
			}
		}
	}
	// -- End
	
	$count = $_POST[no_unit];
	
	$c_count = $_POST['count_course'];
			
	//No of Course belongs
	//Start => Loop 1st (Course)
	for($i=1; $i<=$c_count; $i++){
		
		$s_count = 's_count'.$i;
		$s_count = $_REQUEST[$s_count];
			
		//Start => Loop 2nd (No of Student)
		for($j=1; $j<=$s_count; $j++){
			
			//No of columns
			//Start => Loop 3rd
			for($k=1; $k<=$count; $k++){
				
				$attend_date = "attend_date".$k;
				$attend_date = $_REQUEST[$attend_date];
				
				$student_id = "student_id".$j."_".$i;
				$student_id = $_REQUEST[$student_id];
				
				$shift1 = "shift1_".$j."_".$k."_".$i;
				$shift1 = $_REQUEST[$shift1];
				
				$shift2 = "shift2_".$j."_".$k."_".$i;
				$shift2 = $_REQUEST[$shift2];
				
				$shift3 = "shift3_".$j."_".$k."_".$i;
				$shift3 = $_REQUEST[$shift3];
				
				$shift4 = "shift4_".$j."_".$k."_".$i;
				$shift4 = $_REQUEST[$shift4];
				
				$shift5 = "shift5_".$j."_".$k."_".$i;
				$shift5 = $_REQUEST[$shift5];
				
				$shift6 = "shift6_".$j."_".$k."_".$i;
				$shift6 = $_REQUEST[$shift6];
				
				$shift7 = "shift4_".$j."_".$k."_".$i;
				$shift7 = $_REQUEST[$shift7];
				
				$shift8 = "shift5_".$j."_".$k."_".$i;
				$shift8 = $_REQUEST[$shift8];
				
				$shift9 = "shift6_".$j."_".$k."_".$i;
				$shift9 = $_REQUEST[$shift9];

				$course_id = "course_id".$i;
				$course_id = $_REQUEST[$course_id];

				//Check duplicate
				$num=$dbf->countRows('ped_attendance',"ped_id='$id' AND teacher_id='$uid' AND course_id='$course_id' AND student_id='$student_id' AND unit='$k' and group_id='$_POST[cmbgroup]'");
				if($num>0){
					
				$string="shift1='$shift1',shift2='$shift2',shift3='$shift3',shift4='$shift4',shift5='$shift5',shift6='$shift6',shift7='$shift7',shift8='$shift8',shift9='$shift9',attend_date='$attend_date'";
					
					$dbf->updateTable("ped_attendance",$string,"ped_id='$id' AND teacher_id='$uid' AND course_id='$course_id' AND student_id='$student_id' AND unit='$k' and group_id='$_POST[cmbgroup]'");
				}else{
					
					$dt = date('Y-m-d');
					$string="ped_id='$id',teacher_id='$uid',course_id='$course_id',student_id='$student_id',unit='$k',shift1='$shift1',shift2='$shift2',shift3='$shift3',dated='$dt', group_id='$_POST[cmbgroup]',attend_date='$attend_date'";
					
					$dbf->insertSet("ped_attendance",$string);
				}
			}
		}
	}
	//End => Loop 1st
	
	//======================================
	//Start Insert in daily status
	//======================================
	$today = date('Y-m-d');	
	$string="dated='$today',teacher_id='$uid',group_id='$_POST[cmbgroup]',course_id='$course_id',ped_id='$id'";	
	$dbf->insertSet("ped_daily_status",$string);
	//End status	
	
	//Update the status when newly attandance has been made !!!
	//=========================================================
	$string = "status='Continue'";
	$dbf->updateTable("student_group",$string,"id='$_POST[cmbgroup]'");
	//=========================================================
			
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');
	
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_POST[cmbgroup]'") as $ingroup){
		
		$student_id = $ingroup["student_id"];
		$course_id = $ingroup["course_id"];
		
		$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='4'"); // Means If status is blank or Enrolled
		if($num_st > 0){
			$string_st="group_id='$_POST[cmbgroup]',status_id='5'"; //Active Status		
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
			
			$string2="student_id='$student_id',group_id='$_POST[cmbgroup]',course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
			$dbf->insertSet("student_moving_history",$string2);
			
			$string_st="status_id='5'"; //Completed Status
			$dbf->updateTable("student_enroll",$string_st,"student_id='$student_id' And course_id='$course_id'");
		}
	}	
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
}else{
	
	//Query string
	$string="level='$_POST[level]',estart_date='$_POST[estart_date]',material='$mate',bl='$_POST[bl]',arf_submit='$_POST[arf]',comments='$_POST[comments]',location='$_POST[location]',checklist='$chklist',point_cover1='$_POST[point_cover1]',point_date1='$_POST[point_date1]',point_cover2='$_POST[point_cover2]', point_date2='$_POST[point_date2]', ini_feedback='$ini_feedback', inst1='$_POST[inst1]', date1='$_POST[date1]', arf1='$_POST[arf1]',dby1='$_POST[dby1]',dby1_date1='$_POST[dby1_date1]', cby1='$_POST[cby1]', cby1_date1='$_POST[cby1_date1]', inst2='$_POST[inst2]', inst2_date2='$_POST[inst2_date2]',counselling='$counselling',inst3='$_POST[inst3]', inst3_date3='$_POST[inst3_date3]', inst4='$_POST[inst4]',inst4_date4='$_POST[inst4_date4]', not_apply='$_POST[not_apply]',distrbute_by='$_POST[distrbute_by]',distrbute_date='$_POST[distrbute_date]',collect_by='$_POST[collect_by]',collect_date='$_POST[collect_date]',pro_report='$_POST[pro_report]'";
		
	//Excute the query
	$dbf->updateTable("ped",$string,"teacher_id='$uid' and group_id='$_POST[cmbgroup]' and course_id='$course_id'");	
	
	//======================================
	//Start Insert in daily status
	//======================================
	$today = date('Y-m-d');	
	
	//Check duplicate
	$num=$dbf->countRows('ped_daily_status',"dated='$today' And teacher_id='$uid' And group_id='$_POST[cmbgroup]' And course_id='$course_id'");
	if($num==0){
	
		$string="dated='$today',teacher_id='$uid',group_id='$_POST[cmbgroup]',course_id='$course_id',ped_id='$id'";		
		$dbf->insertSet("ped_daily_status",$string);
	}

	//======================================
	//End status
	//======================================
		
	//Insert in PED Units table
	$ucount = $_POST[ucount];
	for($i=1; $i<=$ucount; $i++){
		
		$dt = "u_dated".$i;
		$dt = $_REQUEST[$dt];
		
		$material_overed = "material_overed".$i;
		$material_overed = $_REQUEST[$material_overed];
		
		$homework = "homework".$i;
		$homework = $_REQUEST[$homework];
		
		if($dt != ''){
			//Check duplicate
			$num=$dbf->countRows('ped_units',"units='$i' AND teacher_id='$uid' and group_id='$_POST[cmbgroup]' and course_id='$course_id'");
			if($num==0){
				$string="ped_id='$_POST[ped_id]', teacher_id='$uid',group_id='$_POST[cmbgroup]', course_id='$course_id', units='$i',dated='$dt', material_overed='$material_overed',homework='$homework'";
				$dbf->insertSet("ped_units",$string);
			}else{
				$string="dated='$dt',material_overed='$material_overed',homework='$homework'";
				$dbf->updateTable("ped_units",$string,"teacher_id='$uid' AND units='$i' and group_id='$_POST[cmbgroup]' and course_id='$course_id'");
			}
		}
	}
	// -- End
					
	
	$count = $_POST[no_unit];	
	$c_count = $_POST['count_course'];	
	
	//No of Course belongs
	//Start => Loop 1st (Course)
	for($i=1; $i<=$c_count; $i++){
		$s_count = 's_count'.$i;
		$s_count = $_REQUEST[$s_count];
			
		//Start => Loop 2nd (No of Student)
		for($j=1; $j<=$s_count; $j++){
			
			//No of columns
			//Start => Loop 3rd
			for($k=1; $k<=$count; $k++){
				
				$attend_date = "attend_date".$k;
				$attend_date = $_REQUEST[$attend_date];
				
				$student_id = "student_id".$j."_".$i;
				$student_id = $_REQUEST[$student_id];
				
				$shift1 = "shift1_".$j."_".$k."_".$i;
				$shift1 = $_REQUEST[$shift1];
				
				$shift2 = "shift2_".$j."_".$k."_".$i;
				$shift2 = $_REQUEST[$shift2];
				
				$shift3 = "shift3_".$j."_".$k."_".$i;
				$shift3 = $_REQUEST[$shift3];
										
				$course_id = "course_id".$i;
				$course_id = $_REQUEST[$course_id];
													
				//Check duplicate
				$num=$dbf->countRows('ped_attendance',"ped_id='$_POST[ped_id]' AND teacher_id='$uid' AND course_id='$course_id' AND student_id='$student_id' AND unit='$k' and group_id='$_POST[cmbgroup]'");
				if($num>0){
					
					$string="shift1='$shift1',shift2='$shift2',shift3='$shift3',attend_date='$attend_date'";
					//echo '<br>';
					$dbf->updateTable("ped_attendance",$string,"ped_id='$_POST[ped_id]' AND teacher_id='$uid' AND course_id='$course_id' AND student_id='$student_id' AND unit='$k' and group_id='$_POST[cmbgroup]'");
					
				}else{
					
					$dt = date('Y-m-d');
					$string="ped_id='$_POST[ped_id]',teacher_id='$uid',course_id='$course_id',student_id='$student_id',unit='$k',shift1='$shift1',shift2='$shift2',shift3='$shift3',dated='$dt',group_id='$_POST[cmbgroup]',attend_date='$attend_date'";
					
					$dbf->insertSet("ped_attendance",$string);
				}
			}
		}
	}
	//End => Loop 1st	
		
	//======================================
	//Start Insert in daily status
	//======================================
	$today = date('Y-m-d');		
	$string="dated='$today',teacher_id='$uid',group_id='$_POST[cmbgroup]',course_id='$course_id',ped_id='$id'";	
	$dbf->insertSet("ped_daily_status",$string);	
	//End status
			
	//Get logo path
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	//E-mail for alert to the Teacher, course has been completed
	//==========================================================
	
	$group_type = $res_group[group_id];
	$group_size = $dbf->strRecordID("group_size","*","group_id='$group_type'");
	
	$original_unit = $group_size["units"];
	
	$group_size = $dbf->strRecordID("ped_units","COUNT(id)","group_id='$_POST[cmbgroup]'");
	$pending_unit = $group_size["COUNT(id)"];	
	
	//teacher
	$res_teacher=$dbf->fetchSingle("teacher","id='$uid'");
	$to = $res_teacher[email];
		
	if($pending_unit == $original_unit){
		
		foreach($dbf->fetchOrder('student_moving',"status_id='5' And group_id='$_REQUEST[cmbgroup]'") as $move){
		
			//Update in student_enroll table
			$string_st="status_id='8'"; //Completed Status
			$dbf->updateTable("student_enroll",$string_st,"student_id='$move[student_id]' And course_id='$course_id'");
			
			//Update in student_moving table	
			$dbf->updateTable("student_moving",$string_st,"student_id='$move[student_id]' And course_id='$course_id'");
			
			//Insert in student_moving_history table
			$date_time = date('Y-m-d H:i:s A');
			$string2="student_id='$move[student_id]',course_id='$course_id',group_id='$_REQUEST[cmbgroup]',date_time='$date_time',user_id='$_SESSION[id]',status_id='8'";
			$dbf->insertSet("student_moving_history",$string2);
		
		}
				
		$string = "status='Completed',completed_date='$today'";
		$dbf->updateTable("student_group",$string,"id='$_POST[cmbgroup]'");
		
		//admin
		$res_admin=$dbf->fetchSingle("user","user_type='Administrator'");
		$from = $res_admin[email];
		
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From:".$from."\n";
		
		$email_cont = $dbf->strRecordID("email_templetes","*","id='14'");
		$email_msg = $email_cont["content"];
		
		$email_msg = str_replace('%teachername%',$res_teacher["name"],$email_msg);
		
		$body='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
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
		//$subject = "Your course has finished. Please filled up the Progress Reports";		
		mail($to,$subject,$body,$headers);	
		
		//Start Save Mail	
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
			
	}else{
		
		// Moving to Life Cycle
		foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_POST[cmbgroup]'") as $ingroup){
		
			$student_id = $ingroup["student_id"];
			$course_id = $ingroup["course_id"];
			
			$num_st = $dbf->countRows('student_moving',"student_id='$student_id' And course_id='$course_id' And status_id <='4'"); // Means If status is blank or Enrolled
			if($num_st > 0){
				$string_st="group_id='$_POST[cmbgroup]',status_id='5'"; //Active Status		
				$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
				
				$string2="student_id='$student_id',group_id='$_POST[cmbgroup]',course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
				$dbf->insertSet("student_moving_history",$string2);
				
				$string_st="status_id='5'"; //Completed Status
				$dbf->updateTable("student_enroll",$string_st,"student_id='$student_id' And course_id='$course_id'");
			}
		}
		// Moving to Life Cycle
	}
	
	//=========================================================================
	//Sent email from teacher to student who has 3 units of absent in e-PEDCARD
	//=========================================================================
	$from = $res_teacher[email];

	foreach($dbf->fetchOrder('ped_attendance',"ped_id='$_POST[cmbgroup]'","","student_id","student_id") as $val_at){
		$at_count = 0;
		
		//Get per units
		foreach($dbf->fetchOrder('ped_attendance',"ped_id='$_POST[cmbgroup]' And student_id='$val_at[student_id]'","","","") as $val_ab){
			
			//Get per units
			$nnn = $dbf->countRows('ped_attendance',"ped_id='$_POST[cmbgroup]' And student_id='$val_at[student_id]' And unit='$val_ab[unit]' And (shift1='A' Or shift2='A' Or shift3='A' Or shift4='A' Or shift5='A' Or shift6='A' Or shift7='A' Or shift8='A' Or shift9='A')");
			
			if($nnn > 0){
				$at_count = $at_count + 1;
			}			
		}
				
		if($at_count == 3 || $at_count == 6 || $at_count == 9 || $at_count == 12 || $at_count == 15 || $at_count == 18 || $at_count == 21 || $at_count == 24 || $at_count == 27 || $at_count == 30 || $at_count == 33 || $at_count == 36 || $at_count == 39 || $at_count == 42 || $at_count == 45 || $at_count == 48 || $at_count == 51 || $at_count == 54 || $at_count == 57 || $at_count == 60|| $at_count == 63 || $at_count == 66 || $at_count == 69|| $at_count == 72 || $at_count == 75 || $at_count == 78 || $at_count == 81){
			
			//Student details
			$res_student=$dbf->fetchSingle("student","id='$val_at[student_id]' And sms_status='1'");
			$student_name = $res_student["first_name"];
						
			$teacher_name = $res_teacher["name"];
			
			$temp_group = $dbf->strRecordID("student_group","centre_id","id='$_POST[cmbgroup]'");
			$centre_id = $temp_group[centre_id];
			
			//Get Student Advisor mail id
			$res_cd=$dbf->fetchSingle("user","user_type='Student Advisor' And center_id='$centre_id'");
			$to = $res_cd["email"];
			$name = $res_cd["user_name"];
			
			$headers .= 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:".$from."\n";
			
			$email_cont = $dbf->strRecordID("email_templetes","*","id='13'");
			$email_msg = $email_cont["content"];
			
			$email_msg = str_replace('%cd%',$name,$email_msg);
			$email_msg = str_replace('%studentname%',$student_name,$email_msg);
			$email_msg = str_replace('%noof_days%',$at_count,$email_msg);
			
			$body='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
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
			
			$subj = $email_cont["title"];
			$subj = str_replace('%noof_days%',$at_count,$subj);
			$subject = str_replace('%studentname%',$student_name,$subj);
			
			//$subject = $student_name. " absent for ".$at_count." days";			
			mail($to,$subject,$body,$headers);
							
			//--- End mail --------------------------------------------------------
			
			//Start Save Mail	
			$dt = date('Y-m-d');
			$dttm = date('Y-m-d h:i:s');
			
			$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("email_history",$string);
			// End Save Mail
	
			
			//SMS start
			$student_id = $res_student["id"];
			$student_mobile_no = $res_student["student_mobile"];
			
			if($student_mobile_no != ''){
				
				$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
				
				// Your username
				$UserName=UrlEncoding($sms_gateway[user]);
				
				// Your password
				$UserPassword=UrlEncoding($sms_gateway[password]);
				
				// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
				//$Numbers=UrlEncoding("966000000000,966111111111");
				$Numbers=UrlEncoding($student_mobile_no);
				
				// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
				$Originator=UrlEncoding($sms_gateway[your_name]);
				
				// Your Message in English or arabic or both.
				// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
				//$msg = "You are absent from last ".$at_count." days. Please get back to us with appropriate reasons.";
				$sms = $_REQUEST['sms'];
				if($sms == "1" || $sms == "3"){
					if($sms == "1"){
						$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='35'");
					}else if($sms == "3"){
						$sms_cont = $_REQUEST['contents'];
					}
					$msg = str_replace('%at_count%',$at_count,$sms_cont);
					$Message = $msg;
					
					$res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
					if($res_sms[status] == '') {
						
						$cr_date = date('Y-m-d H:i:s A');
						$dt = date('Y-m-d');
						
						//Check (Once SMS has been sent to a particular student in a particular date with his same teacher and belongs to that centre)
						$num_sms = $dbf->countRows('sms_history',"user_id='$_SESSION[id]' and mobile='$student_mobile_no' And centre_id='$centre_id' And send_date='$dt'");					
						if($num_sms == 0) {
								
							// Storing Sending result in a Variable.
							if($sms_gateway["status"]=='Enable'){
								SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
													
								//SMS save in the Table (sms_history)
								//====================================
								$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='student',mobile='$student_mobile_no',centre_id='$centre_id',send_date='$dt',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
								$sms_id = $dbf->insertSet("sms_history",$string);	
			
								$string1="parent_id='$sms_id',student_id='$student_id'";
								$dbf->insertSet("sms_history_dtls",$string1);
							}						
						}					
					}
				}				
			}			
		}
				
	}
	
}
//Header location
header("Location:ped.php?msg=added&cmbgroup=$_POST[cmbgroup]");
exit;
//Update the status when newly attandance has been made !!!
//=========================================================
/*$num=$dbf->countRows('ped_attendance',"group_id='$_REQUEST[cmbgroup]'");
if($num>0){
	
	//Update the student_group table where teacher_id='$uid' and group_id='$_POST[cmbgroup]' and course_id='$course_id'
	$string = "status='Continue'";
	$dbf->updateTable("student_group",$string,"id='$_REQUEST[cmbgroup]'");
	
	foreach($dbf->fetchOrder('student_moving',"status_id='4' And group_id='$_REQUEST[cmbgroup]'") as $move){
		
		//Update in student_enroll table
		$string_st="status_id='5'"; //Active Status
		$dbf->updateTable("student_enroll",$string_st,"student_id='$move[student_id]' And course_id='$course_id'");
		
		//Update in student_moving table	
		$dbf->updateTable("student_moving",$string_st,"student_id='$move[student_id]' And course_id='$course_id'");
		
		//Insert in student_moving_history table
		$date_time = date('Y-m-d H:i:s A');
		$string2="student_id='$move[student_id]',course_id='$course_id',group_id='$_REQUEST[cmbgroup]',date_time='$date_time',user_id='$_SESSION[id]',status_id='5'";
		$dbf->insertSet("student_moving_history",$string2);
		
	}
}*/
//=========================================================
?>
