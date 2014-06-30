<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

#$teacher_id = $_SESSION[uid];
/*
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
*/
if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');
	$group_id=$_REQUEST['group_id'];
	$status=$_REQUEST['status'];
	$units_extend=$_REQUEST['units'];
	switch($status)
	{
		case 'Approved':	{
								echo "<BR/>Update Status and Push Algorithm...<BR/>";
								$unit_per_day=$dbf->getDataFromTable("student_group","unit_per_day","id='$group_id'");
								$units=$dbf->getDataFromTable("student_group","units","id='$group_id'");
								$total_units=$units + $units_extend;
								$no_days=$units_extend/$unit_per_day;
								$dbf->extendSchedule($group_id,$no_days,$total_units);
							}break;
		case 'Rejected':	{
								echo "<BR/>Update Status...<BR/>";
								
							}break;
		default:			{echo "<BR/>No Selected Status...<BR/>";}break;
	}
	$cer_string="approved_by='$_SESSION[id]',status='$status'";
	$group=$dbf->strRecordID("student_group","*","id='$group_id'");
	$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
	$to = $dbf->getDataFromTable("teacher","email","id='$group[teacher_id]'");
	$teacher = $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");
	$cd = $dbf->getDataFromTable("user","user_name","id='$_SESSION[id]'");
	$sa = $dbf->getDataFromTable("user","email","user_type='Student Advisor' And center_id='$_SESSION[centre_id]'");
	$group_name = $group["group_name"];
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "From:".$from."\n";
	$headers .= "Cc:".$sa."\n";
	$email_msg="	Dear ".$teacher.",
					I have approved the Class Extension Request for Group ".$group_name.". Please capture the Information.";
	
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
		<td height="30" align="right" valign="middle" class="nametext" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:28px;">'.$cd.'</td>
	  </tr>
	  <tr>
		<td align="center" valign="top">&nbsp;</td>
	  </tr>
	</table>';	
	
	
	$subject ="Class Extension Request Status";
	mail($to,$subject,$body1,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	
	$dbf->updateTable("cer",$cer_string,"id='$_REQUEST[record_id]'");
	
	header("Location:cer_manage.php");
	
}
?>
