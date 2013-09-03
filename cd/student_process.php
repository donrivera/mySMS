<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

if($_REQUEST['action']=='insert'){
	
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
		
	$student_name = $first_name.' '.$family_name;
	$last_name_arabic = $Arabic->en2ar($family_name);
			
	//$_SESSION['quick_name'] = $_POST[name];
	$_SESSION['quick_mobile'] = $_POST[mobile];
	$_SESSION['quick_app_date'] = $_POST[app_date];
	$_SESSION['quick_comment'] = $_POST[enquire];
	
	$dt = date('Y-m-d h:i:s');
	
	$num=$dbf->countRows('student',"student_mobile='$_POST[mobile]'");
	if($num>0){
		header("Location:student_add.php?msg=existm");
		exit;
	}	
	
	$comm = mysql_real_escape_string($_POST[comment]);	
	$reg_dt = date('Y-m-d');
	
	$string="first_name='$student_name',first_name1='$first_name',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',student_mobile='$_REQUEST[mobile]',student_comment='$comm',created_datetime='$dt',centre_id='$_SESSION[centre_id]',app_date='$_POST[app_date]',register_date='$reg_dt',sms_status='1'";	
	$ids = $dbf->insertSet("student",$string);
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			$string="student_id='$ids',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
	
	//=========================================================
	//Insert in Student Life Cycle Table Table (student_moving)
		
	$string_move="student_id='$ids',status_id='1',date_time='$dt',user_id='$_SESSION[id]'";
	$dbf->insertSet("student_moving",$string_move);	
		
	$string2="student_id='$ids',date_time='$dt',user_id='$_SESSION[id]',status_id='1'";
	$dbf->insertSet("student_moving_history",$string2);	
	//==========================================================
	
	//==========================================================
	//Insert in Student Comments Table (student_comment)
	
	if($comm != ''){
		$string_move="student_id='$ids',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
	}
	//==========================================================
	
	//==========================================================
	// Student Appointment Table
	//==========================================================
	$string="dated='$_POST[app_date]',student_id='$ids',comments='$comm',user_id='$_SESSION[id]',status='1',centre_id='$_SESSION[centre_id]'";
	$dbf->insertSet("student_appointment",$string);
	
	unset($_SESSION['quick_name']);
	session_unregister('quick_name');
	
	unset($_SESSION['quick_mobile']);
	session_unregister('quick_mobile');
	
	unset($_SESSION['quick_app_date']);
	session_unregister('quick_app_date');
	
	unset($_SESSION['quick_comment']);
	session_unregister('quick_comment');
	
	header("Location:student_manage.php");
	exit;
}

if($_REQUEST['action']=='edit'){
	
	$num=$dbf->countRows('student',"student_mobile='$_POST[mobile]' And id <> '$_REQUEST[stud_id]'");
	if($num==0){
		$string="student_mobile='$_POST[mobile]'";
		$dbf->updateTable("student",$string,"id='$_REQUEST[stud_id]'");
	}
	
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
		
	$student_name = $first_name.' '.$family_name;
	$last_name_arabic = $Arabic->en2ar($family_name);
		
	$comm = mysql_real_escape_string($_POST["comment"]);
	
	$string="first_name='$student_name',first_name1='$first_name',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',student_mobile='$_REQUEST[mobile]',app_date='$_POST[app_date]',student_comment='$comm'";
	$dbf->updateTable("student",$string,"id='$_REQUEST[stud_id]'");
	
	$dbf->deleteFromTable("student_lead","student_id='$_REQUEST[stud_id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			$string="student_id='$_REQUEST[stud_id]',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}	
	
	//Update in Comments Table
	$string="comments='$comm'";
	$dbf->updateTable("student_comment",$string,"student_id='$_REQUEST[stud_id]' And status_id='1'");
	
	//Set Header Location
	header("Location:student_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("student","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_appointment","student_id='$_REQUEST[id]'");
	
	$dbf->deleteFromTable("student_comment","student_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_course","student_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_fees","student_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_lead","student_id='$_REQUEST[id]'");
	
	$dbf->deleteFromTable("student_material","student_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_moving","student_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_vacation","student_id='$_REQUEST[id]'");
	
	header("Location:student_manage.php");
}
?>
