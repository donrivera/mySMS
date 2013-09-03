<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=student_absence_report.doc");

?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="2%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD"  style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
                  <th width="7%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"  style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME");?> </th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"> <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_MOBILENO");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_LASTATTAND");?></th>
                  <th colspan="2" align="center" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT");?></th>
                </tr>
				</thead>
                <?php
					$i = 1;
					//Get Number of Rows
					$num=$dbf->countRows('student');
					
					//loop start
					foreach($dbf->fetchOrder('student',"","first_name") as $val) {
					
					//Get Course
					$g = $dbf->strRecordID("student_group_dtls","*","student_id='$val[id]'");
					$course = $dbf->strRecordID("course","*","id='$g[course_id]'");
					$group_dtls = $dbf->strRecordID("student_group","*","id='$g[parent_id]'");
					//Get Total Absent
					$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A')");
					$countid = $res_max["COUNT(id)"];
					
					//Get Last Attendance
					$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A')");
					$maxid = $res_max["MAX(id)"];
					
					$reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[id]' AND (shift1='X' OR shift2='X')");
					$resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X')");
					
					//Get Name Of Groups
					$res = $dbf->strRecordID("student","*","id='$resp[student_id]'");
					$res2 = $dbf->strRecordID("common","*","id='$resp[group_id]'");
					
					//Get Name Of Teacher
					$res3 = $dbf->strRecordID("teacher","*","id='$resp[teacher_id]'");
					
					if($countid>0) {
					?>
                <tr>
                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[first_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $course[name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $group_dtls[group_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $res3[name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $res[student_mobile];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $res[email];?></td>
				  <?php
				  $last = '';
				  if($reslast["unit"] > 0)
				  {
				  		$last = "Unit No (".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
				  }
				  ?>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $last;?></td>
                  <td width="11%" align="center" valign="middle" bgcolor="#F8F9FB"><span class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $countid;?></span></td>
                  <? 
					  $i = $i + 1;
					  }}
					  ?>
                </tr>
               
            </table>