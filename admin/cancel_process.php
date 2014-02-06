<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//Object initialization
$dbf = new User();
if($_REQUEST['action']=='update')
{
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	$dt = date('Y-m-d');
	$comm = mysql_real_escape_string($_REQUEST['comment']);
	
	$string="admin_dated='$_REQUEST[dated]',admin_comment='$comm',admin_status='$_REQUEST[status]'";
	$dbf->updateTable("student_cancel",$string,"id='$_REQUEST[cancel_id]'");
	//==========================================================
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != ''){
		$ids = $dbf->getDataFromTable("student_cancel", "student_id", "id='$_REQUEST[cancel_id]'");
		
		$string_move="student_id='$ids',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);
	}
	//==========================================================
	$stu_cancel = $dbf->strRecordID("student_cancel",'*',"id='$_REQUEST[cancel_id]'");
	$student_id = $stu_cancel['student_id'];
	$course_id = $stu_cancel['course_id'];
	$centre_id = $stu_cancel["centre_id"];
	$my_prev_group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$student_id' And course_id='$course_id'");
	$res_group = $dbf->strRecordID("student_group","*","id='$my_prev_group_id'");
	$res_teacher = $dbf->strRecordID("teacher","*","id='$res_group[teacher_id]'");
	$dbf->pullSchedule($my_prev_group_id);
	$dbf->deleteFromTable("student_group_dtls","parent_id='$my_prev_group_id' AND student_id='$student_id'");
	$dbf->deleteFromTable("student_enroll","course_id='$course_id' And student_id='$student_id'");
	$string_fees="type='cancelled student'";
	$dbf->updateTable("student_fees",$string_fees,"student_id='$student_id' And course_id='$course_id'");
	$date_time = date('Y-m-d H:i:s A');
	$dbf->updateTable("student_moving","status_id='7'","student_id='$student_id'");
	$string2="course_id='$course_id',date_time='$date_time',user_id='$_SESSION[id]',status_id='7'";
	$dbf->updateTable("student_moving_history",$string2,"group_id='$my_prev_group_id' AND student_id='$student_id'");
	$grp_email_dtl=$dbf->genericQuery("
										SELECT sg.units, sg.group_name, sg.end_date, sgd.total
										FROM student_group sg
										LEFT JOIN (	SELECT COUNT( student_id ) AS total, parent_id
													FROM student_group_dtls
													WHERE parent_id='$my_prev_group_id'
												   )sgd ON sgd.parent_id = sg.id
												WHERE sg.id =  '$my_prev_group_id'
									");
	foreach($grp_email_dtl as $ged):
		$send_units=$ged['units'];
		$send_gname=$ged['group_name'];
		$send_enddate=$ged['end_date'];
		$send_total=$ged['total'];
	endforeach;
	$to_user = $res_teacher["email"];
	$admin_mail = $dbf->getDataFromTable("user","email","user_type='Administrator");
	$cc = $dbf->getDataFromTable("user","email","user_type='Accountant' ");
	if($to_user != '' || $admin_mail != '')
	{
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-6' . "\r\n";
		$headers .= "From:".$from."\n";
		$headers .= "Cc:".$cc."\r\n";						
		$email_cont = $dbf->strRecordID("email_templetes","*","id='6'");
		$email_msg = $email_cont["content"];
		$email_msg = str_replace('%teacher%',$res_teacher["name"],$email_msg);
		$search = array('%teacher%', '%unit%', '%group_name%','%students%','%end_date%');
		$replace = array($res_teacher["name"],$send_units,$send_gname,$send_total,$send_enddate);
		$email_msg=str_replace($search, $replace, $email_msg); 
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
		$subject = $email_cont["title"];				
		//$subject ="Group size has been changed Notification !!!";
		mail($to_user,$subject,$body1,$headers);
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Teacher and Accountant',email='$to_user',centre_id='',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
	}
	$hdt = date('Y-m-d h:i:s');
	$string="dated='$hdt',centre_id='$_SESSION[centre_id]',group_id='$my_prev_group_id',user_id='$_SESSION[id]',type='1'";
	$hid = $dbf->insertSet("student_group_history",$string);
	$str_d="parent_id='$hid',student_id='$student_id'";
	$dbf->insertSet("student_group_history_dtls",$str_d);
	header("Location:cancel_manage.php");
	exit;
}
if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("student_cancel","id='$_REQUEST[cancel_id]'");
	header("Location:cancel_manage.php");
}

?>
