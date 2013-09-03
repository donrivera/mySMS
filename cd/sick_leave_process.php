<?php 
	ob_start();
	session_start();
	include_once '../includes/class.Main.php';
	include("../includes/saudismsNET-API.php");
	
	//Object initialization
	$dbf = new User();
	
	//Query string
	$string="sick_status='$_POST[status]'";
	
	//Excute query
	$dbf->updateTable("sick_leave",$string,"id='$_REQUEST[id]'");
	
	//Mail start
	//===================================================================
	if($_POST[status]=="1"){
		$status = "Approved";
	}else{
		$status = "Rejected";
	}
	
	if($_POST[option]=="1"){
		$optionmsg = "Substitute Teacher";
	}else{
		$optionmsg = "Class is Cancelled";
	}
	
	$cd_id = $_SESSION[id];
	
	//Send a mail to centre director from teacher
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");

	$res_s = $dbf->strRecordID("sick_leave","*","id='$_REQUEST[id]'");

	//Get teacher email id
	$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
	$cd_name = $dbf->getDataFromTable("user_name","email","id='$cd_id'");
	
	$to = $dbf->getDataFromTable("teacher","email","id='$res_s[teacher_id]'");
	$teacher = $dbf->getDataFromTable("teacher","name","id='$res_s[teacher_id]'");
	
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";

		
	$email_cont = $dbf->strRecordID("email_templetes","*","id='8'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%teacher%',$teacher,$email_msg);
	$email_msg = str_replace('%status%',$status,$email_msg);
	$email_msg = str_replace('%leavefrom%',$res_s["from_date"],$email_msg);
	$email_msg = str_replace('%leaveto%',$res_s["to_date"],$email_msg);
	
	$body1='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
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
	$subject = str_replace('%status%',$status,$subj);
	
	//$subject ="Sick leave has been ".$status;
	mail($to,$subject,$body1,$headers);
	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail


// Mail End
//==================================================================

/*********Send Sms to Students if the class is cancelled************/
//Getting Stuidents Mobile No
$student_mobile_no='';	
if($_POST[option]=="2" && $_POST[status]=="1"){
	
	foreach($dbf->fetchOrder('student_group a ,student_group_dtls b',"a.teacher_id='$res_s[teacher_id]' and a.group_id!=0 and a.id=b.parent_id and a.group_id=b.group_id") as $val_gr){
		
		$res_student = $dbf->strRecordID("student","*","id='$val_gr[student_id]' And sms_status='1'");
			
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
}

//SMS details saved in Table
//==============================================================
$cr_date = date('Y-m-d H:i:s A');

$sms_gateway = $dbf->strRecordID("sms_gateway","*","");

// Storing Sending result in a Variable.
if($sms_gateway["status"]=='Enable'){
	
	// Your username
	$UserName=UrlEncoding($sms_gateway[user]);
	
	// Your password
	$UserPassword=UrlEncoding($sms_gateway[password]);
	
	// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
	//$Numbers=UrlEncoding("966000000000,966111111111");
	$Numbers=UrlEncoding($student_mobile_no);
	
	// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
	$Originator=UrlEncoding($sms_gateway[your_name]);
	
	$sms = $_REQUEST['sms'];
	if($sms == "1" || $sms == "3"){
		if($sms == "1"){
			$Message = $optionmsg;
		}else if($sms == "3"){
			$Message = $_REQUEST['contents'];
		}
		$msg = $Message;
		
		SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				
		$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$Message',send_to='Student',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='Centre Director (For Sick Leave Approved or Rejected)',mobile='$student_mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
		$sms_id = $dbf->insertSet("sms_history",$string);
		
		foreach($dbf->fetchOrder('student_group a ,student_group_dtls b',"a.teacher_id='$res_s[teacher_id]' and a.group_id!=0 and a.id=b.parent_id and a.group_id=b.group_id") as $val_gr1){	
			$string1="parent_id='$sms_id',student_id='$val_gr1[student_id]'";
			$dbf->insertSet("sms_history_dtls",$string1);	
		}
	}
	
}
/*********Send Sms to Students if the class is cancelled************/
?>
<script type="text/javascript">
	self.parent.location.href='sick_leave_manage.php';
	self.parent.tb_remove();
</script>