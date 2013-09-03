<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$uid = $_SESSION['uid'];

function get_percent($input){
	if($input > 0){
		$out = 18 - (3 * $input);					
		return $out;
	}					
}

if($_REQUEST['action']=='insert'){
	
	$narration = mysql_real_escape_string($_REQUEST[narration]);
	
	$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
	
	//Check duplicate
	$num=$dbf->countRows('teacher_progress',"teacher_id='$uid' and group_id='$_POST[group_id]'");
	if($num==0){
		
		//Query string
		$string="teacher_id='$uid',group_id='$_POST[group_id]',course_id='$res_group[course_id]',grade_submit='$_POST[grade_submit]',report_print='$_POST[report_print]',report_print_by='$_POST[report_print_by]',certificate_print='$_POST[certificate_print]',certificate_print_by='$_POST[certificate_print_by]', progress_report_date='$_POST[progress_report_date]', certificate='$_POST[certificate]',narration='$narration'";
		
		//Excute the query And Get the recent Insert ID
		$ids = $dbf->insertSet("teacher_progress",$string);		
		
		//==============================
		// CERTIFICATE REPORTS
		//==============================
		$res_group = $dbf->strRecordID("student_group","*","id='$_POST[group_id]'");
		$res_size = $dbf->strRecordID("group_size","*","group_id='$res_group[group_id]'");
		
		$student_count = $_POST[student_count1];		
		for($m=1; $m<=$student_count; $m++){
			
			$total_units=$_POST[hidAttend];
			
			//student_id1_1
			$student_id = "student_id1"."_".$m;
			$student_id = $_REQUEST[$student_id];
			
			$fluency = "fluency"."_".$m;
			$fluency = $_REQUEST[$fluency];
			
			$pronunciation = "pronunciation"."_".$m;
			$pronunciation = $_REQUEST[$pronunciation];
			
			$grammer = "grammer"."_".$m;
			$grammer = $_REQUEST[$grammer];
			
			$vocabulary = "vocabulary"."_".$m;
			$vocabulary = $_REQUEST[$vocabulary];
			
			$listening = "listening"."_".$m;
			$listening = $_REQUEST[$listening];
			
			$end_of_level = "end_of_level"."_".$m;
			$end_of_level = $_REQUEST[$end_of_level];
			
			$attendance = "attendance"."_".$m;
			$attendance = $_REQUEST[$attendance];
						
			$attend = $attendance;
			$totalunits = $res_size[units];
			
			if($totalunits!=0){
				$attend_calc=round((($attend/$totalunits)*100)/10);
			}
			
			if($end_of_level > 0){
				$grade_sheet = $dbf->strRecordID("grade_sheet","*","'$end_of_level' BETWEEN frm and tto");					
				$nos = $grade_sheet[nos];
				$benifit = 18 - (3 * $nos);
			}
			
			$final_grade = get_percent($fluency);
			$final_grade = $final_grade + get_percent($pronunciation);
			$final_grade = $final_grade + get_percent($grammer);
			$final_grade = $final_grade + get_percent($vocabulary);
			$final_grade = $final_grade + get_percent($listening);
			$final_grade = $final_grade + $attend_calc;
			
			if($end_of_level > 0){
				$final_grade = $final_grade + $benifit;
			}
			
			$res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");
			$grade_id = $res_grade["id"];
			$grade_name = $res_grade["name"];
			
			//Check duplicate
			$num=$dbf->countRows('teacher_progress_certificate',"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			if($num==0){
				//Insert in progress certificate table
				$string="teacher_id='$uid',group_id='$_POST[group_id]',course_id='$res_group[course_id]',student_id='$student_id',fluency='$fluency',fluency_perc='$fluency_perc', pronunciation='$pronunciation',pronunciation_perc='$pronunciation_perc',grammer='$grammer',grammer_perc='$grammer_perc',vocabulary='$vocabulary',vocabulary_perc='$vocabulary_perc', listening='$listening',listening_perc='$listening_perc',end_of_level='$end_of_level',end_of_level_perc='$end_of_level_perc', attendance='$attendance', attendance_perc='$attend_calc',parent_id='$ids',final_percent='$final_grade',grade_id='$grade_id'";
				
				$dbf->insertSet("teacher_progress_certificate",$string);
			}else{
				//update progress certificate table
				$string="fluency='$fluency',fluency_perc='$fluency_perc',pronunciation='$pronunciation',pronunciation_perc='$pronunciation_perc', grammer='$grammer',grammer_perc='$grammer_perc',vocabulary='$vocabulary',vocabulary_perc='$vocabulary_perc',listening='$listening',listening_perc='$listening_perc',  end_of_level='$end_of_level',end_of_level_perc='$end_of_level_perc',attendance='$attendance', attendance_perc='$attend_calc',parent_id='$ids',final_percent='$final_grade',grade_id='$grade_id'";
				
			$dbf->updateTable("teacher_progress_certificate",$string,"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			
			}
			
			//SMS start
			$student_id = $student_id;
			$res_student = $dbf->strRecordID("student","*","id='$student_id' And sms_status='1'");
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
																
				$res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
				if($res_sms[status] == '') {
					
					//Get centre ID from select Group
					$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					$centre_id = $res_group["centre_id"];
					
					$cr_date = date('Y-m-d H:i:s A');
					$dt = date('Y-m-d');
					
					//Check (Once SMS has been sent to a particular student in a particular date with his same teacher and belongs to that centre)
					$num_sms = $dbf->countRows('sms_history',"user_id='$_SESSION[id]' and mobile='$student_mobile_no' And centre_id='$centre_id' And msg_from='Progress Reports'");
					
					if($num_sms == 0) {
										
						// Storing Sending result in a Variable.
						if($sms_gateway["status"]=='Enable'){
							
							$sms = $_REQUEST['sms'];
							if($sms == "1" || $sms == "3"){
								if($sms == "1"){
									$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='36'");
								}else if($sms == "3"){
									$sms_cont = $_REQUEST['contents'];
								}
								$sms_cont = str_replace('%grade_name%',$grade_name,$sms_cont);
								$msg = str_replace('%final_grade%',$final_grade,$sms_cont);
								
								$Message = $msg;
							
								SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
													
								//SMS save in the Table (sms_history)
								//====================================
								$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='student',mobile='$student_mobile_no',centre_id='$centre_id',send_date='$dt',msg_from='Progress Reports',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
								$sms_id = $dbf->insertSet("sms_history",$string);	
			
								$string1="parent_id='$sms_id',student_id='$student_id'";
								$dbf->insertSet("sms_history_dtls",$string1);	
							}
						}
					}					
				}				
			}
		}
		
		//==============================
		// PROGRESS REPORTS
		//==============================
		$student_count = $_POST[student_count];
		for($j=1; $j<=$student_count; $j++)
		{
			$total_units=$_POST[hidAttend];
			
			$student_id = "student_id"."_".$j;
			$student_id = $_REQUEST[$student_id];
			
			$course_partication = "course_partication"."_".$j;
			$course_partication = $_REQUEST[$course_partication];
			$course_partication_perc= get_percent($course_partication,$total_units,10);
			
			$course_homework = "course_homework"."_".$j;
			$course_homework = $_REQUEST[$course_homework];
			$course_homework_perc= get_percent($course_homework,$total_units,10);
			
			$course_fluency = "course_fluency"."_".$j;
			$course_fluency = $_REQUEST[$course_fluency];
			$course_fluency_perc= get_percent($course_fluency,$total_units,10);
			
			$course_pro = "course_pro"."_".$j;
			$course_pro = $_REQUEST[$course_pro];
			$course_pro_perc= get_percent($course_pro,$total_units,15);
			
			$course_grammer = "course_grammer"."_".$j;
			$course_grammer = $_REQUEST[$course_grammer];
			$course_grammer_perc= get_percent($course_grammer,$total_units,15);
			
			$course_voca = "course_voca"."_".$j;
			$course_voca = $_REQUEST[$course_voca];
			$course_voca_perc= get_percent($course_voca,$total_units,15);
			
			$course_listen = "course_listen"."_".$j;
			$course_listen = $_REQUEST[$course_listen];
			$course_listen_perc= get_percent($course_listen,$total_units,15);
			
			$course_attendance = "course_attendance"."_".$j;
			$course_attendance = $_REQUEST[$course_attendance];
			$course_attendance_perc= get_percent($course_attendance,$total_units,10);
			
			//Check duplicate
			$num=$dbf->countRows('teacher_progress_course',"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			if($num==0)
			{
				//Insert in Progress course table	
				$string="teacher_id='$uid',group_id='$_POST[group_id]',course_id='$res_group[course_id]',student_id='$student_id',course_partication='$course_partication',course_partication_perc='$course_partication_perc',course_homework='$course_homework', course_homework_perc='$course_homework_perc', course_fluency='$course_fluency', course_fluency_perc='$course_fluency_perc', course_pro='$course_pro',course_pro_perc='$course_pro_perc', course_grammer='$course_grammer', course_grammer_perc='$course_grammer_perc', course_voca='$course_voca', course_voca_perc='$course_voca_perc',course_listen='$course_listen',course_listen_perc='$course_listen_perc',course_attendance='$course_attendance',course_attendance_perc='$course_attendance_perc',parent_id='$ids'";
				
				$dbf->insertSet("teacher_progress_course",$string);
			}
			else
			{
				//update Progress course table	
				$string="course_partication='$course_partication',course_partication_perc='$course_partication_perc',course_homework='$course_homework', course_homework_perc='$course_homework_perc',course_fluency='$course_fluency', course_fluency_perc='$course_fluency_perc', course_pro='$course_pro', course_pro_perc='$course_pro_perc',course_grammer='$course_grammer', course_grammer_perc='$course_grammer_perc', course_voca='$course_voca', course_voca_perc='$course_voca_perc', course_listen='$course_listen',course_listen_perc='$course_listen_perc',course_attendance='$course_attendance',course_attendance_perc='$course_attendance_perc',parent_id='$ids'";
				
			$dbf->updateTable("teacher_progress_course",$string,"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			
			}
			
		}
		// -- End
		
		//Header location
		header("Location:report_teacher_progress.php?msg=added&group_id=$_POST[group_id]");
	}	
	else
	{
		
		//Query string
 		$string="report_print='$_POST[report_print]',report_print_by='$_POST[report_print_by]',certificate_print='$_POST[certificate_print]',certificate_print_by='$_POST[certificate_print_by]', progress_report_date='$_POST[progress_report_date]', certificate='$_POST[certificate]',grade_submit='$_POST[grade_submit]',narration='$narration'";
		
		//Excute the query
		$dbf->updateTable("teacher_progress",$string,"teacher_id='$uid' and group_id='$_POST[group_id]' and course_id='$res_group[course_id]'");	
		
		//==============================
		// CERTIFICATE REPORTS
		//==============================
		
		$res_group = $dbf->strRecordID("student_group","*","id='$_POST[group_id]'");
		$res_size = $dbf->strRecordID("group_size","*","group_id='$res_group[group_id]'");

		$student_count = $_POST[student_count1];
		for($m=1; $m<=$student_count; $m++)
		{	
			
			$total_units=$_POST[hidAttend];
			
			$student_id = "student_id1"."_".$m;
			$student_id = $_REQUEST[$student_id];
			
			$fluency = "fluency"."_".$m;
			$fluency = $_REQUEST[$fluency];
			
			$pronunciation = "pronunciation"."_".$m;
			$pronunciation = $_REQUEST[$pronunciation];
			
			$grammer = "grammer"."_".$m;
			$grammer = $_REQUEST[$grammer];
			
			$vocabulary = "vocabulary"."_".$m;
			$vocabulary = $_REQUEST[$vocabulary];
			
			$listening = "listening"."_".$m;
			$listening = $_REQUEST[$listening];
			
			$end_of_level = "end_of_level"."_".$m;
			$end_of_level = $_REQUEST[$end_of_level];
			
			$attendance = "attendance"."_".$m;
			$attendance = $_REQUEST[$attendance];
			
			$attend = $attendance;
			$totalunits = $res_size[units];
				
			if($totalunits!=0)
			{
				$attend_calc=round((($attend/$totalunits)*100)/10);
			}
			
			if($end_of_level > 0)
			{
				$grade_sheet = $dbf->strRecordID("grade_sheet","*","'$end_of_level' BETWEEN frm and tto");					
				$nos = $grade_sheet[nos];
				$benifit = 18 - (3 * $nos);
			}
			
			$final_grade = get_percent($fluency);
			$final_grade = $final_grade + get_percent($pronunciation);
			$final_grade = $final_grade + get_percent($grammer);
			$final_grade = $final_grade + get_percent($vocabulary);
			$final_grade = $final_grade + get_percent($listening);
			$final_grade = $final_grade + $attend_calc;
			
			if($end_of_level > 0)
			{
				$final_grade = $final_grade + $benifit;
			}
			
			$res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");
			$grade_id = $res_grade["id"];
			
			//Check duplicate
			$num=$dbf->countRows('teacher_progress_certificate',"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			if($num==0)
			{
				//Insert in progress certificate table
				$string="teacher_id='$uid',group_id='$_POST[group_id]',course_id='$res_group[course_id]',student_id='$student_id',fluency='$fluency',fluency_perc='$fluency_perc', pronunciation='$pronunciation',pronunciation_perc='$pronunciation_perc',grammer='$grammer',grammer_perc='$grammer_perc',vocabulary='$vocabulary',vocabulary_perc='$vocabulary_perc', listening='$listening', listening_perc='$listening_perc',end_of_level='$end_of_level', end_of_level_perc='$end_of_level_perc', attendance='$attendance', attendance_perc='$attend_calc',parent_id='$ids',final_percent='$final_grade',grade_id='$grade_id'";
				
				$dbf->insertSet("teacher_progress_certificate",$string);
			}
			else
			{
				//update progress certificate table
				echo $string="fluency='$fluency',fluency_perc='$fluency_perc', pronunciation='$pronunciation', pronunciation_perc='$pronunciation_perc', grammer='$grammer',grammer_perc='$grammer_perc',vocabulary='$vocabulary',vocabulary_perc='$vocabulary_perc', listening='$listening', listening_perc='$listening_perc', end_of_level='$end_of_level',end_of_level_perc='$end_of_level_perc', attendance='$attendance', attendance_perc='$attend_calc', parent_id='$ids',final_percent='$final_grade',grade_id='$grade_id'";
				
			$dbf->updateTable("teacher_progress_certificate",$string,"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			
			}
			
		}
		
		//==============================
		// PROGRESS REPORTS
		//==============================
		
		//Insert in Progress table		
		$student_count = $_POST[student_count];
		for($j=1; $j<=$student_count; $j++)
		{
			$student_id = "student_id"."_".$j;
			$student_id = $_REQUEST[$student_id];
			
			$course_partication = "course_partication"."_".$j;
			$course_partication = $_REQUEST[$course_partication];
			$course_partication_perc= get_percent($course_partication,$total_units,10);
			
			$course_homework = "course_homework"."_".$j;
			$course_homework = $_REQUEST[$course_homework];
			$course_homework_perc= get_percent($course_homework,$total_units,10);
			
			$course_fluency = "course_fluency"."_".$j;
			$course_fluency = $_REQUEST[$course_fluency];
			$course_fluency_perc= get_percent($course_fluency,$total_units,10);
			
			$course_pro = "course_pro"."_".$j;
			$course_pro = $_REQUEST[$course_pro];
			$course_pro_perc= get_percent($course_pro,$total_units,15);
			
			$course_grammer = "course_grammer"."_".$j;
			$course_grammer = $_REQUEST[$course_grammer];
			$course_grammer_perc= get_percent($course_grammer,$total_units,15);
			
			$course_voca = "course_voca"."_".$j;
			$course_voca = $_REQUEST[$course_voca];
			$course_voca_perc= get_percent($course_voca,$total_units,15);
			
			$course_listen = "course_listen"."_".$j;
			$course_listen = $_REQUEST[$course_listen];
			$course_listen_perc= get_percent($course_listen,$total_units,15);
			
			$course_attendance = "course_attendance"."_".$j;
			$course_attendance = $_REQUEST[$course_attendance];
			$course_attendance_perc= get_percent($course_attendance,$total_units,10);
			
			//Check duplicate
			$num=$dbf->countRows('teacher_progress_course',"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			if($num==0)
			{
				$string="teacher_id='$uid',group_id='$_POST[group_id]',course_id='$_REQUEST[course_id]',student_id='$student_id',course_partication='$course_partication',course_partication_perc='$course_partication_perc',course_homework='$course_homework', course_homework_perc='$course_homework_perc', course_fluency='$course_fluency', course_fluency_perc='$course_fluency_perc', course_pro='$course_pro',course_pro_perc='$course_pro_perc', course_grammer='$course_grammer', course_grammer_perc='$course_grammer_perc', course_voca='$course_voca', course_voca_perc='$course_voca_perc',course_listen='$course_listen',course_listen_perc='$course_listen_perc',course_attendance='$course_attendance',course_attendance_perc='$course_attendance_perc',parent_id='$ids'";
				
				$dbf->insertSet("teacher_progress_course",$string);
			}
			else
			{
				$string="course_partication='$course_partication',course_partication_perc='$course_partication_perc',course_homework='$course_homework', course_homework_perc='$course_homework_perc', course_fluency='$course_fluency', course_fluency_perc='$course_fluency_perc', course_pro='$course_pro', course_pro_perc='$course_pro_perc',course_grammer='$course_grammer', course_grammer_perc='$course_grammer_perc', course_voca='$course_voca', course_voca_perc='$course_voca_perc', course_listen='$course_listen',course_listen_perc='$course_listen_perc',course_attendance='$course_attendance',course_attendance_perc='$course_attendance_perc',parent_id='$ids'";
				
			$dbf->updateTable("teacher_progress_course",$string,"teacher_id='$uid' AND group_id='$_POST[group_id]' AND course_id='$res_group[course_id]' AND student_id='$student_id'");
			
			}
			
			
		}
		//End 1st
		
		//Header location
		header("Location:report_teacher_progress.php?msg=added&group_id=$_POST[group_id]");
	}
}
?>
