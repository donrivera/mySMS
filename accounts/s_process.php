<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

//Object initialization of class validatesaid
include_once '../includes/validateSAID.class.php';

//Object initialization
$std = new validateSAID();

if($_REQUEST['action'] == 'edit_from_student_profile'){

	$ar_familyname=$_REQUEST[ar_mytxt_src3];//aaaa
	$ar_gfathrname=$_REQUEST[ar_mytxt_src2];//bbbb
	$ar_fathername=$_REQUEST[ar_mytxt_src1];//cccc
	$ar_firstname=$_REQUEST[ar_mytxt_src];//dddd
	
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
		
	$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	$address = mysql_real_escape_string($_POST[address]);
	$string="	first_name='$_REQUEST[mytxt_src]',
				first_name1='$ar_firstname',
				father_name='$_REQUEST[mytxt_src1]',
				father_name1='$ar_fathername',
				grandfather_name='$_REQUEST[mytxt_src2]',
				grandfather_name1='$ar_gfathrname',
				family_name='$_REQUEST[mytxt_src3]',
				family_name1='$ar_familyname',
				gender='$_POST[gender]',
				country_id='$_POST[country]',
				alt_contact='$_POST[altmobile]',
				area_code='$_POST[area_code]',
				address='$address'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================	
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' AND status_id <='1'"); // Means If status is blank or Enquiry
	if($num_st > 0){
		$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
		$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
		
		$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
		$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
		
		//Moving History table
		$date_time = date('Y-m-d H:i:s A');
		
		$string2="student_id='$student_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='2'";
		$dbf->insertSet("student_moving_history",$string2);
	}	
	//=======================================================
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	
	//Checking for duplcate Student ID
	if($_POST[sid] > 0){
		$num_id=$dbf->countRows('student',"student_id='$_POST[sid]' AND id<>'$student_id'");
		if($num_id == 0){
			$dbf->updateTable("student","student_id='$_POST[sid]'","id='$student_id'"); 
		}
	}
	
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_POST[email]' AND id!='$student_id'");
	if($num_email == 0){		
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
	}
	
	//Checking for duplcate Mobile Number
	$num_mob=$dbf->countRows('student',"student_mobile='$_POST[mobile]' AND id!='$_REQUEST[id]'");
	if($num_mob == 0){
		$dbf->updateTable("student","student_mobile='$_POST[mobile]'","id='$student_id'"); 
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
		
	header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
	exit;

}
?>
