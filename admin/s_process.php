<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

//Object initialization of class validatesaid
include_once '../includes/validateSAID.class.php';
require '../I18N/Arabic.php';

//Object initialization
$std = new validateSAID();
$Arabic = new I18N_Arabic('Transliteration');

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");

if($_REQUEST['action']=='edit'){
	
	$student_id=$_REQUEST[student_id];
	$_SESSION[gender] = $_REQUEST[gender];
	$_SESSION[gender1] = $_REQUEST[gender1];
	//$_SESSION[gname] = $_REQUEST[gname];
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	
	//Get Gender from Session
	if($_SESSION[gender]==''){
		$gender = $_SESSION[gender1];
	}else{
		$gender = $_SESSION[gender];
	}
	
	$res_photo = $dbf->strRecordID("student","*","id='$student_id'");
	
	$comment = mysql_real_escape_string($_POST[comment]);
	$newcomment = mysql_real_escape_string($_POST[newcomment]);
			
	if($_FILES['signature']['name']<>''){
		
		//Remove the previous Image (Signature)
		$filename1=$res["first_name"]."-".$_FILES['signature']['name'];
		
		$prev_file = $res["photo"];
		if($prev_file != ""){
			$prev_file = "../sa/photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
	
	$first_name=$_REQUEST[txt_src];
	$family_name = $_REQUEST[txt_src3];
	
	$student_name = $first_name.' '.$family_name;
	
$string="first_name='$student_name',first_name1='$_REQUEST[t4]',father_name='$_POST[txt_src1]',grandfather_name='$_POST[txt_src2]',family_name='$family_name',guardian_name='$_REQUEST[gname]',age='$_REQUEST[age]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',gender='$gender',country_id='$_POST[country]',alt_contact='$_POST[altmobile]',id_type='$_REQUEST[id_type]'";
	
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
	
	if($_REQUEST[id_type] == "National ID"){
		if($sid != ''){
			$num=$dbf->countRows('student',"student_id='$sid'");
			if($num>0){
				header("Location:s_edit.php?msg=idexist&id=$student_id");
				exit;
			}
		}
	}
	//echo $_REQUEST[id_type];
	if($_REQUEST[id_type] == "National ID"){
		
		if($sid != ''){
			$stu_id = $std->check($sid);
			if($stu_id > 0){
				header("Location:s_edit.php?msg=invalid&id=$student_id");
				exit;
			}				
		}
	}
	
	$dbf->updateTable("student","student_id='$_POST[sid]'","id='$student_id'"); 
	
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_POST[email]' AND id!='$student_id'");
	if($num_email!=0){
		header("Location:s_edit.php?msg=emailexist&id=$student_id");
		exit;
	}else{
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
	}
	
	//Checking for duplcate Mobile Number
	$num_mob=$dbf->countRows('student',"student_mobile='$_POST[mobile]' AND id!='$student_id'");
	if($num_mob!=0){
		header("Location:s_edit.php?msg=mobileexist&id=$student_id");
		exit;
	}else{
		$dbf->updateTable("student","student_mobile='$_POST[mobile]'","id='$student_id'"); 
	}
	
	$numc=$dbf->countRows('student_comment',"student_id='$student_id'");
	$dt = date('Y-m-d h:m:s');
	if($numc==0){
		
		//insert into student-comments table
		if($newcomment!=''){			
			$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
			$dbf->insertSet("student_comment",$string2);
		}
	}else{
		
		//update student_comments table
		if($newcomment!=''){			
			$string2="comments='$newcomment'";
			$dbf->updateTable("student_comment",$string2,"student_id='$student_id'");
		}
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
	
	//Type
	//Delete from student course table
	$dbf->deleteFromTable("student_type","student_id='$student_id'");
	
	$count = $_POST[tcount];
	for($i=1; $i<=$count; $i++){
		$c = "type".$i;
		$c = $_REQUEST[$c];
		if($c != ''){
			$string="student_id='$student_id',type_id='$c'";
			$dbf->insertSet("student_type",$string);
		}
	}	
		
	header("Location:s_edit.php?student_id=$student_id&msg=add");
}

if($_REQUEST['action'] == 'edit_from_student_profile'){
	
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
	
	if($_REQUEST["txt_src"] == ''){
		$student_name = $_REQUEST[mytxt_src].' '.$_REQUEST[mytxt_src3];
	}else{		
		$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	}
	
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
	
	//Get Gender from Student Table
	if($res[age]>16){		
		$gender = $_REQUEST["gender"];
	}else{
		$gender = $_REQUEST["gender1"];
	}
	
	$string="first_name='$student_name',first_name1='$first_name1',father_name='$father_name',grandfather_name='$grandfather_name',family_name='$family_name',gender='$gender',country_id='$_POST[country]',alt_contact='$_POST[altmobile]',age='$_REQUEST[age]',guardian_name='$_REQUEST[gname]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',id_type='$_REQUEST[id_type]'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$date_time = date('Y-m-d H:i:s A');	
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' AND status_id <='1'"); // Means If status is blank or Enquiry
	if($num_st > 0){
		$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
		$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
		
		$string_st="status_id='2',grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
		$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
		
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
	
	//Checking for duplcate Student ID
	if($_REQUEST["sid"] > 0){
		$num_id=$dbf->countRows('student',"student_id='$_REQUEST[sid]' AND id<>'$student_id'");
		if($num_id == 0){
			$dbf->updateTable("student","student_id='$_REQUEST[sid]'","id='$student_id'"); 
		}
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
	
	$sid=$_POST['sid'];
	$cid=$_REQUEST[country];
	if($_REQUEST[id_type] == "National ID"){
		if($_REQUEST[student_id] != ''){
			//Duplicate checking student id
			$num=$dbf->countRows('student',"student_id='$_REQUEST[sid]'");
			if($num>0){
				//Error message sent to header
				header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=idexist");
				exit;
			}
		}				
		if($_POST['sid'] != ''){
			$stu_id = $std->check($sid);
			//echo $stu_id;exit;
			if($stu_id > 0){
				header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
			}else{			
				header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0&msg=invalid");
			}
		}else{
			header("Location:single-myprofile.php?student_id=$student_id&token=0_k_0");
			exit;
		}
	}
	
	$dbf->updateTable("student","student_id='$_POST[sid]'","id='$student_id'");
	
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
