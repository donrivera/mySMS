<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

//echo base64_encode(base64_encode("admin"));exit;

$pwd = base64_encode(base64_encode($_REQUEST['password'])); // Get password
$uname = addslashes($_REQUEST['uname']);	// Get user name
$time = time();								// Gets the current server time
$check = $_REQUEST['setcookie'];			// Checks if the remember me button was ticked

$num = $dbf->countRows("user", "user_id='$uname' and password='$pwd'");
$fet = $dbf->strRecordID("user","*","user_id='$uname' and password='$pwd'");

if($num > 0){

	if($fet["user_status"] == "1"){
		header("location:index.php?msg=denied");
		exit;
	}
	
	//Set in Cookies (If checked the Remember Me in Login Page)
	if($check !=''){ // Check to see if the 'setcookie' box was ticked to remember the user
		setcookie("cook_username", $uname, $time + 3600);    	// Sets the cookie username
		setcookie("cook_password", $pwd, $time + 3600);	// Sets the cookie password
	}
	//--- End ---------------------------
	
	//Update for Online as Online
	$dbf->updateTable("user","is_online=1","id='$fet[id]'");
	
	// Session
	$_SESSION["user_name"] = $fet["user_name"];
	$_SESSION["students_user_name"] = $fet["user_name"];
	$_SESSION["id"] = $fet["id"];
	$_SESSION["user_entry"] = $fet["id"];
	
	$_SESSION["user_type"] = $fet["user_type"];
	$_SESSION["students_user_type"] = $fet["user_type"];
		
	# $_SESSION["lang"] = $_REQUEST["lang"];
	$_SESSION["uid"] = $fet["uid"];
	
	$_SESSION["students_uid"] = $fet["uid"];
	$_SESSION["centre_id"] = $fet["center_id"];
		
	//Set Active Time
	$_SESSION['timeout'] = time();
	
	if($fet["user_type"] == "Administrator"){
		header("location:admin/home.php");
		exit;
	}
	if($fet["user_type"] == "Center Director"){
		header("location:cd/home.php");
		exit;
	}
	if($fet["user_type"] == "Student Advisor"){
		header("location:sa/home.php");
		exit;
	}
	if($fet["user_type"] == "Receptionist"){
		header("location:reception/home.php");
		exit;
	}
	if($fet["user_type"] == "Student"){
		header("location:student/home.php");
		exit;
	}
	if($fet["user_type"] == "Teacher"){
		
		//Sending the mail If teacher has not been filled up the e-PEDCARD (Previous date)
		//================================================================================

		//Admin mail id
		$admin = $dbf->strRecordID("user","*","id='1'");
		$from = $admin["email"];
		
		//Receipent Email address
		//Teacher mail id
		$user = $dbf->strRecordID("user","*","uid='$_SESSION[uid]'");
		//$email = $user["email"];
		
		$mobile_no = $user["mobile"];
		
		//Teacher name
		$teachername = $user["user_name"];
					
		//Current date
		$current_dt = date('Y-m-d');
		
		//Today date (-) 2 day
		$tdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . "-2 day"));
		
		//Get number of record in ped_daily_status table for particular teacher And with the date
		$numt=$dbf->countRows('ped_daily_status',"teacher_id='$_SESSION[uid]' And dated<='$tdt'");		
		if($numt == '0'){
			
			//Check Mail already sent to the teacher or not for a particular Days.
			$num_mail_sent = $dbf->countRows('ped_daily_status_dtls',"dated='$current_dt' And teacher_id='$_SESSION[uid]'");			
			if($num_mail_sent == 0){
			
				//Get logo path
				$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
				
				//Get group Name
				$resg = $dbf->strRecordID("ped_daily_status","*","teacher_id='$_SESSION[uid]'");
				$resc = $dbf->strRecordID("student_group","*","id='$resg[group_id]'");
				
				$gname = $resc["group_name"];
				
				//Get centre director mobile no
				$centre_user = $dbf->strRecordID("user","mobile","user_type='Center Director' And center_id='$resg[centre_id]'");
				$cd_mobile = $centre_user["mobile"];
				
				if($cd_mobile != ''){
					$mobile_no = $mobile_no.','.$cd_mobile;
				}
				
				$email_cont = $dbf->strRecordID("email_templetes","*","id='3'");
				$email_msg = $email_cont["content"];
				
				$email_msg = str_replace('%teacher%',$teachername,$email_msg);
				$email_msg = str_replace('%att_dt%',$tdt,$email_msg);
				$email_msg = str_replace('%groupname%',$gname,$email_msg);
				
				//Start Mail here
				//===============				
				$headers = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				$headers .= "From:".$from."\n";
				
				$body='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
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
				
				//$subject = "e-PEDCARD Alert Message !!!";
				$subject = $email_cont["title"];
				mail($email,$subject,$body,$headers);				
				//End Mail
				//========
				
				//Insert into ped_daily_status_dtls Table with current date, teacher_id					
				//Query string
				$string="dated='$current_dt',teacher_id='$_SESSION[uid]',group_id='$resg[group_id]',centre_id='$resg[centre_id]'";				
				$dbf->insertSet("ped_daily_status_dtls",$string);
				// End
				
				//Start SMS to Teacher
				if($mobile_no != ''){
					
					$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
					if($is_enable > 0){
						
						//SMS Gateway details
						$res_sms = $dbf->strRecordID("sms_gateway","*","status='Enable'");
						
						// Your username
						$UserName=UrlEncoding($sms_gateway[user]);
						
						// Your password
						$UserPassword=UrlEncoding($sms_gateway[password]);
						
						// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
						//$Numbers=UrlEncoding("966000000000,966111111111");
						$Numbers=UrlEncoding($mobile_no);
						
						// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
						$Originator=UrlEncoding($sms_gateway[your_name]);
						
						// Your Message in English or arabic or both.
						// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
						//$msg = $teachername." has not been updated the e-PEDcard last 2 days.";
						
						$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='23'");
						$msg = str_replace('%teacher%',$teachername,$sms_cont);
						
						$Message=$msg;
						
						// Storing Sending result in a Variable.						
						SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
						
						//================================
						//SAVED SMS
						//================================
						$cr_date = date('Y-m-d H:i:s A');
						
						$string="dated='$cr_date',user_id='0',msg='$msg',send_to='Teacher',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
						$dbf->insertSet("sms_history",$string);
						//================================
						//SAVED SMS
						//================================
						
					}					
				}
				//End SMS
			}				
		}
		//================================================================================
						
		//Email to Teacher for Alerts to complete the Progress reports 
		//if 50% course has been completed
		//================================================================================		
		$course_is_complete = "";
		
		//Check running courses of the particular teacher
		foreach($dbf->fetchOrder('student_group',"group_id<>'0' And teacher_id='$_SESSION[uid]'","id") as $val_group){
			
			//Get the original unit from group_size table
			$res_group_size = $dbf->strRecordID("group_size","*","group_id='$val_group[group_id]'");
			
			$original_unit = $res_group_size[units];
			
			$original_unit = $original_unit / 2;
			
			//Get the completed units from e-Pedcard
			$res_ped = $dbf->strRecordID("ped_units","COUNT(id)","group_id='$val_group[id]'");
			
			$completed_unit = $res_ped["COUNT(id)"];
			
			if($completed_unit > $original_unit){
				$course_is_complete = "true";
			}
		}

		if($course_is_complete == "true"){
			
			$headers .= 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:".$from."\n";
			
			$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
			
			$email_cont = $dbf->strRecordID("email_templetes","*","id='4'");
			$email_msg = $email_cont["content"];
			
			$email_msg = str_replace('%teacher%',$teachername,$email_msg);
			
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
			
			//$subject ="Alerts for complete the Progress reports";
			$subject = $email_cont["title"];
			mail($email,$subject,$body1,$headers);
		}
		//===============================================================================
		
		header("location:teacher/home.php");
		exit;
	}
		
	if($fet["user_type"] == "Accountant"){
		header("location:accounts/home.php");
		exit;
	}
	if($fet["user_type"] == "LIS"){
		header("location:lis/home.php");
		exit;
	}
	if($fet["user_type"] == "LIS Manager"){
		header("location:lism/home.php");
		exit;
	}
}else{
	header("location:index.php?msg=fail");
	exit;
}
?>