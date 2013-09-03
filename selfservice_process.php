<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include_once 'includes/validateSAID.class.php';
include("includes/saudismsNET-API.php");
require 'I18N/Arabic.php';

//Object initialization
$dbf = new User();
$std = new validateSAID();
$Arabic = new I18N_Arabic('Transliteration');

if($_REQUEST['action']=='classic'){
		
	if($_REQUEST["mytxt_src"] == ''){
		$first_name=$_REQUEST["txt_src"];
	}else{
		$first_name=$_REQUEST["mytxt_src"];
	}
	
	$ar_first_name = $_REQUEST["ar_mytxt_src"];
	$mycentre_id = $_REQUEST["mycentre_id"];
	
	if($_REQUEST["mytxt_src1"] == ''){
		$father_name = $_REQUEST["txt_src1"];
	}else{
		$father_name=$_REQUEST["mytxt_src1"];
	}
	if($_REQUEST["mytxt_src2"] == ''){
		$grandfather_name=$_REQUEST["txt_src2"];
	}else{
		$grandfather_name=$_REQUEST["mytxt_src2"];
	}
	if($_REQUEST["mytxt_src3"] == ''){
		$family_name=$_REQUEST["txt_src3"];
	}else{
		$family_name=$_REQUEST["mytxt_src3"];
	}
		
	$student_name = $first_name.' '.$family_name;
	$last_name_arabic = $Arabic->en2ar($family_name);
	
	$_SESSION["gender"] = $_REQUEST["gender"];
	$_SESSION["gender1"] = $_REQUEST["gender1"];
	$_SESSION["id_type"] = $_REQUEST["id_type"];		
	$_SESSION["pcontact"] = $_REQUEST["pcontact"];
	$_SESSION["information"] = $_REQUEST["information"];
	$_SESSION["classic_gname"] = $_REQUEST["gname"];
	
	$_SESSION["classic_name"] = $first_name;
	$_SESSION["classic_fathername"] = $father_name;
	$_SESSION["classic_gfathername"] = $grandfather_name;
	$_SESSION["classic_familyname"] = $family_name;
	
	$_SESSION["classic_sidn"] = $_REQUEST["sidn"];
	$_SESSION["classic_age"] = $_REQUEST["age"];
	$_SESSION["classic_email"] = $_REQUEST["email"];
	
	//Get Gender from Session
	if($_SESSION["gender"]==''){
		$gender = $_SESSION["gender1"];
	}else{
		$gender = $_SESSION["gender"];
	}
			
	$comment = mysql_real_escape_string($_POST["comment"]);
	$newcomment = mysql_real_escape_string($_POST["newcomment"]);
	
	$dt = date('Y-m-d h:m:s');
		
	//Checking for duplcate Email Address
	$num_email = $dbf->countRows('student',"email='$_POST[email]'");
	if($num_email > 0){
		header("Location:$_REQUEST[my_pagename]?msg=emailexist");
		exit;
	}else{
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
	}
	
	if($_REQUEST[mobile] != '009665'){
		$num=$dbf->countRows('student',"student_mobile='$_POST[mobile]'");
		if($num>0){
			header("Location:$_REQUEST[my_pagename]?msg=mexist");
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
			header("Location:$_REQUEST[my_pagename]?token=0_k_0&msg=idexist");
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
			//header("Location:s_classic.php?student_id=$student_id&token=0_k_0&msg=invalid");
		}
	}
	
	if($_FILES['signature']['name']<>''){
		
		$filename1=$_REQUEST[txt_src]."-".$_FILES['signature']['name'];
		move_uploaded_file($_FILES[signature][tmp_name],"sa/photo/".$filename1);
	}
		
	 $string="first_name='$student_name',first_name1='$first_name',student_first_name='$ar_first_name',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',family_name1='$last_name_arabic',guardian_name='$_REQUEST[gname]',age='$_REQUEST[age]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',gender='$gender',country_id='$_REQUEST[country]',student_id='$national_id',student_mobile='$_REQUEST[mobile]',	alt_contact='$_REQUEST[altmobile]',email='$_REQUEST[email]',student_comment='$comment',photo='$filename1',created_datetime='$dt',centre_id='$mycentre_id',id_type='$_POST[id_type]',sms_status='1'";
	
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
	$count = $_POST[tcount];
	for($i=1; $i<=$count; $i++){
		$c = "type".$i;
		$c = $_REQUEST[$c];		
		if($c != ''){
			$string="student_id='$sid',type_id='$c'";
			$dbf->insertSet("student_type",$string);
		}
	}	
		
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');
	//Potencial Status
	$string2="student_id='$sid',course_id='0',group_id='0',status_id='2',date_time='$date_time',user_id='0'";
	$dbf->insertSet("student_moving",$string2);	
	
	$string2="student_id='$sid',course_id='0',group_id='0',date_time='$date_time',user_id='0',status_id='2'";
	$dbf->insertSet("student_moving_history",$string2);
	
	//update in enroll table
	$string_g1="status_id='2'";
	$dbf->updateTable("student_enroll",$string_g1,"student_id='$sid'");
	
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
		
	header("Location:sucess.php?reg_page_name=$_REQUEST[my_pagename]");
	exit;
}
?>
