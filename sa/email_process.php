<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
$logo_url = $res_logo["name"];

//Get the Sender Email address
$from = $dbf->getDataFromTable("user", "email", "id='$_SESSION[id]'");

if($_REQUEST['opval']=='student'){
	
	$res_student = $dbf->strRecordID("student","*","id='$_POST[student_2]'");
	
	//Get student mobile Number
	$to = $res_student["email"];
	
}else if($_REQUEST['group'] != ''){
	
	$to = '';
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'","","","") as $val_course){
		
		$res_student = $dbf->strRecordID("student","*","id='$val_course[student_id]'");
		
		// Check variable is black or not
		if($to == ''){
			//Check email address is blank or not
			if($res_student[email] != ''){
				//Check valid email address or not
				if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $res_student[email])){
					//First email in the variable
					$to = $res_student[email];
				}				
			}
		}else{
			//Check email address is blank or not
			if($res_student[email] != ''){
				//Check valid email address or not
				if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $res_student[email])){
					//Concate the email address in the variable
					$to = $to.",".$res_student[email];
				}
			}
		}
	}
}else if($_REQUEST['opval']=='teacher'){
	
	$res_teacher = $dbf->strRecordID("teacher","*", "id='$_POST[student_2]'");
	$to = $res_teacher["email"];
	
}else if($_REQUEST['opval']=='staff'){
	
	$res_teacher = $dbf->strRecordID("user","*","id='$_POST[student_2]'");
	$to = $res_teacher["email"];
}

//Start Save Mail	
$dt = date('Y-m-d');
$dttm = date('Y-m-d h:i:s');

$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Manual',page_full_path='$_SERVER[REQUEST_URI]'";
$dbf->insertSet("email_history",$string);
// End Save Mail

$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= "From:".$from."\n";

$body = $_POST[content];
$subject = $_POST[subject];	
mail($to,$subject,$body,$headers);

header("Location:email.php?msg=sent");
exit;
?>
