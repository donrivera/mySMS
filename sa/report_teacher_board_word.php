<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_teacher_board.doc");

?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
<thead>
<tr>
  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("STUDENT_ADVISOR_PED_TNAME");?></th>
  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CURRENTGROUP");?> </th>
  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" > <?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?></th>
  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?> </th>
  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_NUMBEROFSTUD");?> </th>
  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CLASSROOM");?></th>
  </tr>
</thead>
<?php
    $i = 1;
    $num=$dbf->countRows('student_group',"teacher_id='$_REQUEST[teacher]' And centre_id='$_SESSION[centre_id]'");
	foreach($dbf->fetchOrder('student_group',"teacher_id='$_REQUEST[teacher]' And centre_id='$_SESSION[centre_id]'","id") as $val) {
	
		$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
		$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
		$std = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$val[id]'");
		$room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
		$num1=$dbf->countRows('student_group_dtls',"parent_id='$val[id]'");
    ?>
<tr>
  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $i;?></td>
  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $res[name];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[start_date];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[end_date];?></td>
  
  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $std["COUNT(student_id)"];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $room["name"];?></td>
  <?php
      $i = $i + 1;
      }
      ?>
</tr>
</table>
