<?php
include_once 'includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST["action"] == "clear"){

	mysql_query("TRUNCATE TABLE arf");
	mysql_query("TRUNCATE TABLE cd_makeup_class");
	mysql_query("TRUNCATE TABLE cd_makeup_class_dtls");
	mysql_query("TRUNCATE TABLE email_history");
	mysql_query("TRUNCATE TABLE ped");
	mysql_query("TRUNCATE TABLE ped_attendance");
	mysql_query("TRUNCATE TABLE ped_comment");
	mysql_query("TRUNCATE TABLE ped_daily_status");
	mysql_query("TRUNCATE TABLE ped_daily_status_dtls");
	mysql_query("TRUNCATE TABLE ped_units");
	mysql_query("TRUNCATE TABLE sms_history");
	mysql_query("TRUNCATE TABLE sms_history_dtls");
	mysql_query("TRUNCATE TABLE student");
	mysql_query("TRUNCATE TABLE student_appointment");
	mysql_query("TRUNCATE TABLE student_cancel");
	mysql_query("TRUNCATE TABLE student_certificate");
	mysql_query("TRUNCATE TABLE student_comment");
	mysql_query("TRUNCATE TABLE student_course");
	mysql_query("TRUNCATE TABLE student_enroll");
	mysql_query("TRUNCATE TABLE student_fees");
	mysql_query("TRUNCATE TABLE student_fee_edit_history");
	mysql_query("TRUNCATE TABLE student_group");
	mysql_query("TRUNCATE TABLE student_group_dtls");
	mysql_query("TRUNCATE TABLE student_group_history");
	mysql_query("TRUNCATE TABLE student_group_history_dtls");
	mysql_query("TRUNCATE TABLE student_hold");
	mysql_query("TRUNCATE TABLE student_lead");
	mysql_query("TRUNCATE TABLE student_material");
	mysql_query("TRUNCATE TABLE student_moving");
	mysql_query("TRUNCATE TABLE student_moving_history");
	mysql_query("TRUNCATE TABLE student_type");
	mysql_query("TRUNCATE TABLE student_vacation");
	mysql_query("TRUNCATE TABLE teacher_progress");
	mysql_query("TRUNCATE TABLE teacher_progress_certificate");
	mysql_query("TRUNCATE TABLE teacher_progress_course");
	mysql_query("TRUNCATE TABLE transfer_centre_to_centre");
	mysql_query("TRUNCATE TABLE transfer_centre_to_centre_dtls");
	mysql_query("TRUNCATE TABLE transfer_different_centre");
	mysql_query("TRUNCATE TABLE transfer_different_centre_dtls");
	mysql_query("TRUNCATE TABLE transfer_student_to_student");
	mysql_query("TRUNCATE TABLE transfer_student_to_student_dtls");
	
	header("Location:student_clean.php?b0l1e2t=b0l1e2t");
	exit;
}
?>
<title>Clean DB</title>
<br />
<br />
<br />
<script language="javascript" type="text/javascript">
function chk(){
	var x;
	x = confirm("Are you sure want to delete ?");
	if(x){
		return true;
	}else{
		return false;
	}
}
</script>
<form id="frm" name="frm" action="student_clean.php?action=clear" method="post" onsubmit="return chk();">
<table width="400" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
  <tr>
    <td width="224" height="40" align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#F00; font-size:11px;">Please click &quot;Clear&quot; button to clean the Student Database !!!</td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#063; font-size:11px;"><?php if($_REQUEST["b0l1e2t"]=="b0l1e2t"){?>You have successully clear the Student Database.<?php }?></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><input type="image" src="images/db_clean.png" width="83" height="79" title="Clear here to Clean" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</form>