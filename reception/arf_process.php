<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$teacher_id = $_SESSION[uid];

if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="teacher_id='$teacher_id',student_id='$_POST[student]',dated='$_POST[dated]',nr='$_POST[nr]',action_owner='$_POST[owner]',report_by='$_POST[report_by]',report_to='$_POST[report_to]',customer='$_POST[customer]',teacher='$_POST[teacher]',reception1='$_POST[reception1]',cs1='$_POST[cs1]',other1='$_POST[other1]',reception2='$_POST[reception2]',lcd='$_POST[lcd]',lis='$_POST[lis]',cs2='$_POST[cs2]',other2='$_POST[other2]',instruction='$_POST[instruction]',material='$_POST[material]',programme='$_POST[programme]',premisses='$_POST[premisses]',administration='$_POST[administration]',other3='$_POST[other3]',created_datetime='$cr_date',created_by='$_SESSION[uid]'";
	
	$dbf->insertSet("arf",$string);
	
	//Send a mail to centre director from teacher
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	//Get teacher email id
	$from = $dbf->getDataFromTable("teacher","email","user_type='Teacher' And uid='$teacher_id'");
	$to = $dbf->getDataFromTable("user","email","user_type='Student Advisor' And center_id='$_SESSION[centre_id]'");
	
	$cd = $dbf->getDataFromTable("user","user_name","user_type='Student Advisor' And center_id='$_SESSION[centre_id]'");
	$teacher = $dbf->getDataFromTable("teacher","name","id='$teacher_id'");
	
	$res_student = $dbf->strRecordID("student","*","id='$_POST[student]'");
	
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='13'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%cd%',$cd,$email_msg);
	$email_msg = str_replace('%studentname%',$res_student["first_name"],$email_msg);
	$email_msg = str_replace('%teacher%',$teacher,$email_msg);
	
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
	$subj = str_replace('%username%',$teacher,$subj);
	
	//$subject ="New ARF from ".$teacher;
	mail($to,$subject,$body1,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
		
	
	header("Location:arf_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("arf","id='$_REQUEST[id]'");
	header("Location:arf_manage.php");
}

if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="teacher_id='$_SESSION[uid]',student_id='$_POST[student]',dated='$_POST[dated]',nr='$_POST[nr]',action_owner='$_POST[owner]',report_by='$_POST[report_by]',report_to='$_POST[report_to]',customer='$_POST[customer]',teacher='$_POST[teacher]',reception1='$_POST[reception1]',cs1='$_POST[cs1]',other1='$_POST[other1]',reception2='$_POST[reception2]',lcd='$_POST[lcd]',lis='$_POST[lis]',cs2='$_POST[cs2]',other2='$_POST[other2]',instruction='$_POST[instruction]',material='$_POST[material]',programme='$_POST[programme]',premisses='$_POST[premisses]',administration='$_POST[administration]',other3='$_POST[other3]',last_updated='$cr_date',updated_by='$_SESSION[uid]'";
	
	$dbf->updateTable("arf",$string,"id='$_REQUEST[id]'");
	
	header("Location:arf_manage.php");
}
?>
