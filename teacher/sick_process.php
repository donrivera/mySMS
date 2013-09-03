<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

$hidsick=0;
$teacher_id = $_SESSION[uid];

if($_REQUEST['action']=='save'){
	
	$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
	$res_sms = $dbf->strRecordID("sms_gateway","*","status='Enable'");
	
	$hidsick=$_REQUEST[hidsick];
	
	if($hidsick==0){
		
		//Check duplicate
		$num=$dbf->countRows('sick_leave',"teacher_id='$teacher_id' and from_date='$_POST[from_date]'");
		if($num==0){
			$filename=$_FILES['sick_attach']['name'];
			
			if($_FILES['sick_attach']['name']<>''){
				move_uploaded_file($_FILES['sick_attach']['tmp_name'],"sickleave/".$filename);
			}
			
			//Query string
			$string="teacher_id='$teacher_id', from_date='$_POST[from_date]', to_date='$_POST[to_date]', sick_reason='$_POST[sick_reason]', sick_attachment='$filename', sick_notes='$_POST[sick_note]'";
					
			//Excute the query And Get the recent Insert ID
			$ids = $dbf->insertSet("sick_leave",$string);
									
			//Send a mail to centre director from teacher
			$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
			
			//Get teacher email id and name
			$res_teacher = $dbf->strRecordID("teacher","*","id='$teacher_id'");
			$from = $res_teacher["email"];
			$teacher = $res_teacher["name"];
			
			$headers .= 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From:".$from."\n";
												
			//Loop start from student_group table
			//Condition = Sick leave date -> match with student_group table with date range -> get the centre id from student_group table -> According to centre id get the centre.			
			$prev_centre = '';
			foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And (start_date<='$_REQUEST[to_date]' And end_date >='$_REQUEST[from_date]')","centre_id") as $leave_group){
				
				if($prev_centre != $leave_group["centre_id"]){
					
					$cd_id = $leave_group["centre_id"];
																
					$rec_cd = $dbf->strRecordID("user","*","center_id='$cd_id' And user_type='Center Director'");
					$to = $rec_cd["email"];
					$cd = $rec_cd["user_name"];
					$mobile_no = $rec_cd["mobile"];
					
					$email_cont = $dbf->strRecordID("email_templetes","*","id='16'");
					$email_msg = $email_cont["content"];
					
					$email_msg = str_replace('%cd%',$cd,$email_msg);
					$email_msg = str_replace('%from_date%',$_REQUEST["from_date"],$email_msg);
					$email_msg = str_replace('%to_date%',$_REQUEST["to_date"],$email_msg);
					
					//Message body
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
					
					$subj = $email_msg["title"];
					$subject = str_replace('%teacher%',$teacher,$email_msg);
					
					//$subject ="Sick leave from ".$teacher;
					mail($to,$subject,$body1,$headers);
					
					// Assign current centre id
					$prev_centre = $leave_group["centre_id"];			
					
					if($is_enable > 0){
					
						if($mobile_no != ''){
					
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
							$msg = $subject;
							$Message=$msg;
							
							// Storing Sending result in a Variable.
							$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
							////////////////////////////////////////////////////////////////////////////
							
							//================================
							//SAVED SMS
							//================================
							$cr_date = date('Y-m-d H:i:s A');
							
							$string="dated='$cr_date',user_id='0',msg='$msg',send_to='Teacher',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='Sick Leave',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
							$dbf->insertSet("sms_history",$string);
							//================================
							//SAVED SMS
							//================================
						}
					}
				}				
			}
			
			//Insert in sick_leave_centre
			foreach($dbf->fetchOrder('teacher_centre',"teacher_id='$teacher_id'","") as $teacher_center){
				
				$cd_id = $teacher_center["centre_id"];
						
				//Query string for inserting into sick_leave_centre
				$string="parent_id='$ids',centre_id='$cd_id'";
				$dbf->insertSet("sick_leave_centre",$string);
			}
			
									
			//Header location
			header("Location:manage_sick_leave.php");
		}else{
			//Header location
			header("Location:sick_leave.php?msg=exist");
		}	
	}else{
		
		//Check duplicate
		$num=$dbf->countRows('sick_leave',"teacher_id='$teacher_id' and from_date='$_POST[from_date]' and id!='$_REQUEST[hidsick]'");
		if($num==0){
			
			$filename=$_FILES['sick_attach']['name'];

			if($_FILES['sick_attach']['name']<>''){
				
				$res_sick = $dbf->strRecordID("sick_leave","*","id='$_REQUEST[hidsick]' and teacher_id='$teacher_id'");
				$path="sickleave/".$res_sick[sick_attachment];

				unlink($path);
				
				move_uploaded_file($_FILES['sick_attach']['tmp_name'],"sickleave/".$filename);
			 
				//Query string
				$string="teacher_id='$teacher_id', from_date='$_POST[from_date]', to_date='$_POST[to_date]', sick_reason='$_POST[sick_reason]', sick_attachment='$filename', sick_notes='$_POST[sick_note]'";
				
				$dbf->updateTable("sick_leave",$string,"teacher_id='$teacher_id' AND id='$_REQUEST[hidsick]'");
				
				//Send a mail to centre director from teacher
				$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
				
				//Get teacher email id and name
				$res_teacher = $dbf->strRecordID("teacher","*","id='$teacher_id'");
				$from = $res_teacher["email"];
				$teacher = $res_teacher["name"];
				
				$headers .= 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From:".$from."\n";		
								
				//Loop start from student_group table
				//Condition = Sick leave date -> match with student_group table with date range -> get the centre id from student_group table -> According to centre id get the centre.			
				$prev_centre = '';
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And (start_date<='$_REQUEST[to_date]' And end_date >='$_REQUEST[from_date]')","centre_id") as $leave_group){
					
					if($prev_centre != $leave_group["centre_id"]){
						
						$cd_id = $leave_group["centre_id"];
																
						$rec_cd = $dbf->strRecordID("user","*","center_id='$cd_id' And user_type='Center Director'");
						$to = $rec_cd["email"];
						$cd = $rec_cd["user_name"];
						$mobile_no = $rec_cd["mobile"];
						
						$email_cont = $dbf->strRecordID("email_templetes","*","id='16'");
						$email_msg = $email_cont["content"];
						
						$email_msg = str_replace('%cd%',$cd,$email_msg);
						$email_msg = str_replace('%from_date%',$_REQUEST["from_date"],$email_msg);
						$email_msg = str_replace('%to_date%',$_REQUEST["to_date"],$email_msg);
						
						//Message body
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
					
						$subj = $email_msg["title"];
						$subject = str_replace('%teacher%',$teacher,$email_msg);
						
						//$subject ="Sick leave from ".$teacher;
						mail($to,$subject,$body1,$headers);
												
						//Start Save Mail	
						$dt = date('Y-m-d');
						$dttm = date('Y-m-d h:i:s');
						
						$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
						$dbf->insertSet("email_history",$string);
						// End Save Mail
						
						// Assign current centre id
						$prev_centre = $leave_group["centre_id"];
						
						if($is_enable > 0){
							
							if($mobile_no != ''){
					
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
								$msg = $subject;
								$Message=$msg;
								
								// Storing Sending result in a Variable.
								$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
								////////////////////////////////////////////////////////////////////////////
								
								//================================
								//SAVED SMS
								//================================
								$cr_date = date('Y-m-d H:i:s A');
								
								$string="dated='$cr_date',user_id='0',msg='$msg',send_to='Teacher',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='Sick Leave',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
								$dbf->insertSet("sms_history",$string);
								//================================
								//SAVED SMS
								//================================
							}
						}
					}				
				}				
							
				//Header location
				header("Location:manage_sick_leave.php");
				exit;
			}else{
				//Query string
				$string="teacher_id='$teacher_id', from_date='$_POST[from_date]', to_date='$_POST[to_date]', sick_reason='$_POST[sick_reason]',sick_notes='$_POST[sick_note]'";
				
				$dbf->updateTable("sick_leave",$string,"teacher_id='$teacher_id' AND id='$_REQUEST[hidsick]'");
				
				//Send a mail to centre director from teacher
				$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
				
				//Get teacher email id and name
				$res_teacher = $dbf->strRecordID("teacher","*","id='$teacher_id'");
				$from = $res_teacher["email"];
				$teacher = $res_teacher["name"];
				
				$headers .= 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From:".$from."\n";
								
				//Loop start from student_group table
				// -> Condition = Sick leave date 
				// -> match with student_group table with date range
				// -> get the centre id from student_group table 
				// -> According to centre id get the centre.			
				$prev_centre = '';
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And (start_date<='$_REQUEST[to_date]' And end_date >='$_REQUEST[from_date]')","centre_id") as $leave_group){
					
					if($prev_centre != $leave_group["centre_id"]){
						
						$cd_id = $leave_group["centre_id"];
						
						//Query string for inserting into sick_leave_centre
						$string="parent_id='$ids',centre_id='$cd_id'";
						$ids = $dbf->insertSet("sick_leave_centre",$string);
											
						$rec_cd = $dbf->strRecordID("user","*","center_id='$cd_id' And user_type='Center Director'");
						$to = $rec_cd["email"];
						$cd = $rec_cd["user_name"];
						$mobile_no = $rec_cd["mobile"];
						
						$email_cont = $dbf->strRecordID("email_templetes","*","id='16'");
						$email_msg = $email_cont["content"];
						
						$email_msg = str_replace('%cd%',$cd,$email_msg);
						$email_msg = str_replace('%from_date%',$_REQUEST["from_date"],$email_msg);
						$email_msg = str_replace('%to_date%',$_REQUEST["to_date"],$email_msg);
						
						//Message body
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
						
						$subj = $email_msg["title"];
						$subject = str_replace('%teacher%',$teacher,$email_msg);
						
						//$subject ="Sick leave from ".$teacher;
						mail($to,$subject,$body1,$headers);
						
						//Start Save Mail	
						$dt = date('Y-m-d');
						$dttm = date('Y-m-d h:i:s');
						
						$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
						$dbf->insertSet("email_history",$string);
						// End Save Mail
						
						// Assign current centre id
						$prev_centre = $leave_group["centre_id"];
						
						if($is_enable > 0){
							
							if($mobile_no != ''){
					
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
								$msg = $subject;
								$Message=$msg;
								
								// Storing Sending result in a Variable.
								$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
								////////////////////////////////////////////////////////////////////////////
								
								//================================
								//SAVED SMS
								//================================
								$cr_date = date('Y-m-d H:i:s A');
								
								$string="dated='$cr_date',user_id='0',msg='$msg',send_to='Teacher',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='Sick Leave',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
								$dbf->insertSet("sms_history",$string);
								//================================
								//SAVED SMS
								//================================
							}
						}
					}					
				}
				//Header location
				header("Location:manage_sick_leave.php");
			}			
		}else{
			//Header location
			header("Location:sick_leave.php?msg=exist");
		}	
	}	
}
?>