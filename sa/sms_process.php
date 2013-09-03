<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
if($res_sms[status] != ''){
	header("Location:sms.php?msg=block");
	exit;
}

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

$student_mobile_no = '';

if($_REQUEST['opval']=='student'){
	
	if($_POST[student] !=''){
		//Get the Mobile Number from Selected student
		$res_student = $dbf->strRecordID("student","*","id='$_POST[student]' And sms_status='1'");
		
		//Get student mobile Number
		$student_mobile_no = $res_student[student_mobile];
	
	}else{
		$student_mobile_no = $_POST[number];
	}	
}else if($_REQUEST['opval']=='group'){
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'","","","") as $val_course){
		
		$res_student = $dbf->strRecordID("student","*","id='$val_course[student_id]' And sms_status='1'");
		
		// Check variable is black or not
		if($student_mobile_no == ''){
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				//First mobile Number in the variable
				$student_mobile_no = $res_student[student_mobile];			
			}
		}else{
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				//Concate the mobile Number in the variable
				$student_mobile_no = $student_mobile_no.",".$res_student[student_mobile];
			}
		}		
	}
}else{
	$student_mobile_no = $_POST[number];;
}

//SMS details saved in Table
//==============================================================
$cr_date = date('Y-m-d H:i:s A');

if($_REQUEST['opval']=='student'){
	if($_POST[student] !=''){
		$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[textarea]',send_to='$_REQUEST[opval]',mobile='$_POST[number]',centre_id='$_SESSION[centre_id]'";	
	}else{
		$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[textarea]',send_to='$_REQUEST[opval]',mobile='$_POST[number]',type='1',centre_id='$_SESSION[centre_id]'";
	}
	$ids = $dbf->insertSet("sms_history",$string);
}else{
	$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[textarea]',send_to='$_REQUEST[opval]',mobile='$_POST[number]',centre_id='$_SESSION[centre_id]'";
	$ids = $dbf->insertSet("sms_history",$string);
}

if($_REQUEST['opval']=='student'){
	if($_POST[student] !=''){		
		$string1="parent_id='$ids',student_id='$_POST[student]'";
		$dbf->insertSet("sms_history_dtls",$string1);	
	}
}else if($_REQUEST['opval']=='group'){
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'","","","") as $val_course){	
		$string1="parent_id='$ids',student_id='$val_course[student_id]'";
		$dbf->insertSet("sms_history_dtls",$string1);	
	}
}else if($_REQUEST['opval']=='all'){
	foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]'","","","") as $val_course){	
		$string1="parent_id='$ids',student_id='$val_course[id]'";
		$dbf->insertSet("sms_history_dtls",$string1);	
	}
}

if($_REQUEST['opval']!='student' || $_REQUEST['opval']!='group' || $_REQUEST['opval']!='all' || $_REQUEST['opval']!='teacher' || $_REQUEST['opval']!='staff'){
		
	if($_REQUEST['opval']=="Enquiry"){
		$status_id = 1;
	}else if($_REQUEST['opval']=="Potential"){
		$status_id = 2;
	}else if($_REQUEST['opval']=="Waiting - Payment Pending"){
		$status_id = 3;
	}else if($_REQUEST['opval']=="Waiting - Full Payment"){
		$status_id = 3;
	}else if($_REQUEST['opval']=="Enrolled - Payment Pending"){
		$status_id = 4;
	}else if($_REQUEST['opval']=="Enrolled - Full Payment"){
		$status_id = 4;
	}else if($_REQUEST['opval']=="Active - Payment Pending"){
		$status_id = 5;
	}else if($_REQUEST['opval']=="Active - Full Payment"){
		$status_id = 5;
	}else if($_REQUEST['opval']=="On Hold - Payment Pending"){
		$status_id = 6;
	}else if($_REQUEST['opval']=="On Hold - Full Payment"){
		$status_id = 6;
	}else if($_REQUEST['opval']=="Cancelled - Payment Pending"){
		$status_id = 7;
	}else if($_REQUEST['opval']=="Cancelled - Full Payment"){
		$status_id = 7;
	}else if($_REQUEST['opval']=="Cancelled - Refunded"){
		$status_id = 7;
	}else if($_REQUEST['opval']=="Completed - Payment Pending"){
		$status_id = 8;
	}else if($_REQUEST['opval']=="Completed - Full Payment"){
		$status_id = 8;
	}else if($_REQUEST['opval']=="Legally Critical"){
		$status_id = 9;
	} 
			  
	foreach($dbf->fetchOrder('student_moving',"status_id='$status_id'","","student_id","student_id") as $move){	
		
		//Check Balance amount as per condition
		if($_REQUEST['opval']=="Enquiry" || $_REQUEST['opval']=="Potential" || $_REQUEST['opval']=="Legally Critical" || $_REQUEST['opval']=="Cancelled - Refunded"){
			$res_student = $dbf->strRecordID("student","*","id='$move[student_id]' And sms_status='1' And centre_id='$_SESSION[centre_id]'");
		}
		
		if($_REQUEST['opval']=="Waiting - Payment Pending" || $_REQUEST['opval']=="Enrolled - Payment Pending" || $_REQUEST['opval']=="Active - Payment Pending" || $_REQUEST['opval']=="On Hold - Payment Pending" || $_REQUEST['opval']=="Cancelled - Payment Pending" || $_REQUEST['opval']=="Completed - Payment Pending"){
			$balance = $dbf->GetStudentPaidAmount($move['student_id']);
			if($balance > 0){
				$res_student = $dbf->strRecordID("student","*","id='$move[student_id]' And sms_status='1' And centre_id='$_SESSION[centre_id]'");
			}			
		}else{
			$res_student = $dbf->strRecordID("student","*","id='$move[student_id]' And sms_status='1' And centre_id='$_SESSION[centre_id]'");
		}		
		
		// Check variable is blank or not
		if($student_mobile_no == ''){
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				
				//First mobile Number in the variable
				$student_mobile_no = $res_student[student_mobile];
				
				$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[textarea]',send_to='$_REQUEST[opval]',mobile='$res_student[student_mobile]',centre_id='$_SESSION[centre_id]'";	
				$ids = $dbf->insertSet("sms_history",$string);
				
				$string1="parent_id='$ids',student_id='$move[student_id]'";
				$dbf->insertSet("sms_history_dtls",$string1);		
			}
		}else{
			//Check mobile Number is blank or not
			if($res_student[student_mobile] != ''){
				//Concate the mobile Number in the variable
				$student_mobile_no = $student_mobile_no.",".$res_student[student_mobile];
				
				$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_POST[textarea]',send_to='$_REQUEST[opval]',mobile='$res_student[student_mobile]',centre_id='$_SESSION[centre_id]'";	
				$ids = $dbf->insertSet("sms_history",$string);
				
				$string1="parent_id='$ids',student_id='$move[student_id]'";
				$dbf->insertSet("sms_history_dtls",$string1);
			}
		}
		
	}
}

if($student_mobile_no == ''){
	header("Location:sms.php?msg=error");
	exit;
}

// Your username
$UserName=UrlEncoding($sms_gateway["user"]);

// Your password
$UserPassword=UrlEncoding($sms_gateway["password"]);

// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
//$Numbers=UrlEncoding("966000000000,966111111111");
$Numbers=UrlEncoding($student_mobile_no);

// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
$Originator=UrlEncoding($sms_gateway["your_name"]);

// Your Message in English or arabic or both.
// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
$Message=$_POST["textarea"];

// Storing Sending result in a Variable.
if($sms_gateway["status"]=='Enable'){
	
	/*echo $UserName;
	echo '<br>';
	echo $UserPassword;
	echo  '<br>';
	echo $Numbers;
	echo '<br>';
	echo $Originator;
	echo '<br>';*/
	
	$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
	
}

header("Location:sms.php?msg=$SendingResult");
exit;
?>