<?php
/*s_process.php action=edit*/
$student_id = $_REQUEST['student_id'];
	$res_photo = $dbf->strRecordID("student","*","id='$student_id'");
	if($_FILES['signature']['name']<>'')
	{
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
	
	$string="	first_name='$_REQUEST[mytxt_src]',
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
				id_type='$_REQUEST[id_type]'";
	
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
	
	$sid = $_POST['sidn'];
	$cid = $_REQUEST[country];
	
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
	
	/*if($_REQUEST[id_type] == "National ID"){
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
		}else{
			header("Location:s_edit.php?student_id=$student_id&token=0_k_0");
			exit;
		}
	}*/
		
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
		
	header("Location:search.php");
	exit;
	
	
	/*$student_id = $_REQUEST['student_id'];
	
	$_SESSION[gender] = $_REQUEST[gender];
	$_SESSION[gender1] = $_REQUEST[gender1];	
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	$_SESSION[classic_gname] = $_REQUEST[gname];
	
	$_SESSION[classic_name] = $first_name;
	$_SESSION[classic_fathername] = $father_name;
	$_SESSION[classic_gfathername] = $grandfather_name;
	$_SESSION[classic_familyname] = $family_name;
	
	$_SESSION[classic_sidn] = $_REQUEST[sidn];
	$_SESSION[classic_age] = $_REQUEST[age];
	$_SESSION[classic_email] = $_REQUEST[email];
	$_SESSION[classic_gname] = $_REQUEST[gname];
	
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
			$prev_file = "photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"photo/".$filename1);
		
		$string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$student_id'");
	}
		
	$student_name = $_REQUEST[txt_src].' '.$_REQUEST[txt_src3];
	
 $string="first_name='$student_name',first_name1='$_POST[t4]',father_name='$_POST[txt_src1]',grandfather_name='$_POST[txt_src2]',family_name='$_POST[txt_src3]',guardian_name='$_REQUEST[gname]',age='$_REQUEST[age]',guardian_contact='$_REQUEST[pcontact]',guardian_comment='$_REQUEST[information]',gender='$gender',country_id='$_POST[country]',alt_contact='$_POST[altmobile]',id_type='$_REQUEST[id_type]'";
	
	$dbf->updateTable("student",$string,"id='$student_id'");
	
	$grade_online = mysql_real_escape_string($_REQUEST[grade_online]);
	$grade_speak = mysql_real_escape_string($_REQUEST[grade_speak]);
	
	$string_st="grade_online='$grade_online',grade_speak='$grade_speak'"; //Potential Status		
	$dbf->updateTable("student_moving",$string_st,"student_id='$student_id'");
	
	//UPDATE THE STATUS OF THE STUDENT FOR STUDENT LIFE CYCLE
	//=======================================================
	$num_st = $dbf->countRows('student_moving',"student_id='$student_id' AND status_id <='1'"); // Means If status is blank or Enquiry
	if($num_st > 0){	
		
		$string_st="status_id='2'"; //Potential Status		
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
			$num=$dbf->countRows('student',"student_id='$student_id'");
			if($num>0){
				header("Location:s_edit.php?msg=idexist&student_id=$student_id");
				exit;
			}
		}
	}
	
	if($_REQUEST[id_type] == "National ID"){
		
		if($sid != ''){
			$stu_id = $std->check($student_id);
			if($stu_id > 0){
				header("Location:s_edit.php?msg=invalid&student_id=$student_id");
				exit;
			}				
		}
	}
	
	$dbf->updateTable("student","student_id='$_POST[sid]'","id='$student_id'"); 
			
	//Checking for duplcate Email Address
	$num_email=$dbf->countRows('student',"email='$_POST[email]' AND id!='$student_id'");
	if($num_email!=0){
		header("Location:s_edit.php?msg=emailexist&student_id=$student_id");
		exit;
	}else{
		$dbf->updateTable("student","email='$_POST[email]'","id='$student_id'"); 
	}
	
	//Checking for duplcate Mobile Number
	$num_mob=$dbf->countRows('student',"student_mobile='$_POST[mobile]' AND id!='$student_id'");
	if($num_mob!=0){
		header("Location:s_edit.php?msg=mobileexist&student_id=$student_id");
		exit;
	}else{
		$dbf->updateTable("student","student_mobile='$_POST[mobile]'","id='$student_id'"); 
	}
	
	$numc=$dbf->countRows('student_comment',"student_id='$student_id'");
	$dt = date('Y-m-d h:m:s');
	
	if($numc==0){
		if($newcomment!=''){			
			$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
			$dbf->insertSet("student_comment",$string2);
		}
	}else{
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
	exit;*/
?>