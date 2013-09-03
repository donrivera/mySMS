<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
$mobile_no = '';

// Loop each group (status = Completed, completed_date <> '', completed_date +180 days
// If today date = completed_date +180 days means (6 Months)
$today = date('Y-m-d');
$today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . "-180 day"));

foreach($dbf->fetchOrder('student_moving',"status_id='8'") as $valstatus){
	
	$group = $dbf->strRecordID("student_group","*","id='$valstatus[group_id]'");
	
	if($today == $group["completed_date"]){
		
		//Get all variable value
		$course_id = $valstatus["course_id"];
		$student_id = $valstatus["student_id"];

		$balance_amt = $dbf->BalanceAmount($student_id, $course_id);
		if($balance_amt > 0){
			
			//Update in student_enroll table
			$string_st="status_id='9'"; //Legally Critical Status
			$dbf->updateTable("student_enroll",$string_st,"student_id='$student_id' And course_id='$course_id'");
			
			//Update in student_moving table	
			$dbf->updateTable("student_moving",$string_st,"student_id='$student_id' And course_id='$course_id'");
			
			//Insert in student_moving_history table
			$date_time = date('Y-m-d H:i:s A');
			$string2="student_id='$student_id',course_id='$course_id',group_id='$valstatus[group_id]',date_time='$date_time',status_id='9'";
			$dbf->insertSet("student_moving_history",$string2);
			
		}
	}
}
?>