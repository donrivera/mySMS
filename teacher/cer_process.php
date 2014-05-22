<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$teacher_id = $_SESSION[uid];

if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d');
	
	$string="
				teacher_id='$teacher_id',
				group_id='$_REQUEST[group_id]',
				units='$_REQUEST[units]',
				remarks='$_REQUEST[remarks]',
				status='Pending',
				date_added='$cr_date'
			";
	$ids = $dbf->insertSet("cer",$string);
	$from = $dbf->getDataFromTable("teacher","email","id='$_SESSION[uid]'");
	$to = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$_REQUEST[group_id]'");
	$centre_id = $dbf->getDataFromTable("student_group","centre_id","id='$_REQUEST[group_id]'");
	$cd = $dbf->getDataFromTable("user","user_name","user_type='Center Director' And center_id='$centre_id'");
	$teacher = $dbf->getDataFromTable("teacher","name","id='$teacher_id'");
	$group_name = $dbf->getDataFromTable("student_group","group_name","id='$_REQUEST[group_id]'");
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_msg="	Dear ".$cd.",
					I have filled the Class Extension Request for Group ".$group_name.". Please capture the Information.
					Thanks";
	
	$body1='<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
	  <tr>
		<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a81b1;font-weight:bold;padding-left:75px;">'.$email_msg.'</td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle">&nbsp;</td>
	  </tr>
	  <tr>
		<td height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:50px;">Thanks</td>
	  </tr>
	  <tr>
		<td height="30" align="right" valign="middle" class="nametext" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:28px;">'.$teacher.'</td>
	  </tr>
	  <tr>
		<td align="center" valign="top">&nbsp;</td>
	  </tr>
	</table>';	
	
	
	$subject ="New Class Extension Request from ".$teacher."!!!";
	mail($to,$subject,$body1,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	#header("Location:arf_manage.php?ids=$ids&msg=xAmX");
	header("Location:cer_manage.php");
	
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("cer","id='$_REQUEST[id]'");
	header("Location:cer_manage.php");
}

if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');
	echo var_dump($_REQUEST);
	$string="
				teacher_id='$teacher_id',
				group_id='$_REQUEST[group_id]',
				units='$_REQUEST[units]',
				remarks='$_REQUEST[remarks]',
				status='Pending',
				date_added='$cr_date'
			";
	$dbf->updateTable("cer",$string,"id='$_REQUEST[record_id]'");
	
	header("Location:cer_manage.php");
	/*
	//$string="teacher_id='$_SESSION[uid]',student_id='$_POST[student]',group_id='$_REQUEST[group_id]',dated='$_POST[dated]',nr='$_POST[nr]',action_owner='$_POST[owner]',report_by='$_POST[report_by]',report_to='$_POST[report_to]',customer='$_POST[customer]',teacher='$_POST[teacher]',reception1='$_POST[reception1]',cs1='$_POST[cs1]',other1='$_POST[other1]',reception2='$_POST[reception2]',lcd='$_POST[lcd]',lis='$_POST[lis]',cs2='$_POST[cs2]',other2='$_POST[other2]',instruction='$_POST[instruction]',material='$_POST[material]',programme='$_POST[programme]',premisses='$_POST[premisses]',administration='$_POST[administration]',other3='$_POST[other3]',last_updated='$cr_date',updated_by='$_SESSION[uid]'";
	$function=$_REQUEST["function"];
	$string="
				teacher_id='$_SESSION[id]',
				student_id='$_REQUEST[student]',
				centre_id='$_SESSION[centre_id]',
				group_id='$_REQUEST[group_id]',
				dated='$_REQUEST[dated]',
				nr='$_REQUEST[nr]',
				action_owner='$_REQUEST[report_by]',
				report_by='$_REQUEST[report_by]',
				report_to='$_REQUEST[report_to]',
				arf_function='$function',
				arf_function1='$_REQUEST[function1]',
				subject='$_REQUEST[subject]',
				other1='$_REQUEST[other1]',
				other2='$_REQUEST[other2]',
				other3='$_REQUEST[other3]',
				created_datetime='$cr_date',
				created_by='$SESSION[id]',
				action_report='$_REQUEST[action_report]',
				action_report_date='$_REQUEST[action_report_date]',
				action_taken='$_REQUEST[action_taken]',
				action_taken_date='$_REQUEST[action_taken_date]',
				result_check='$_REQUEST[result_check]',
				result_check_date='$_REQUEST[result_check_date]',
				sa_status='1',
				last_updated='',
				updated_by=''
			";
	$dbf->updateTable("arf",$string,"id='$_REQUEST[record_id]'");
	
	header("Location:arf_manage.php");
	*/
}
?>
