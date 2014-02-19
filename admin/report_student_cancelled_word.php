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
header("Content-Disposition: attachment; Filename=report_student_cancelled.doc");
?>
<!--Important-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
        <tr class="logintext">
            <th width="11%" height="29" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
            <th width="10%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Cancellation Date Approved";?></th>
            <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "SA Comments";?> </th>
            <th width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "CD Comments";?> </th>
            <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Admin Comments";?> </th>
        </tr>
	</thead>
    <?php
		$i = 1;
		$num=$dbf->countRows('student s,student_moving m',"s.id = m.student_id AND m.status_id='7'");
		foreach($dbf->fetchOrder('student s,student_moving m',"s.id = m.student_id AND m.status_id='7'", "", "m.*") as $val) 
		{
			$sc=$dbf->strRecordID("student_cancel","*","student_id='$val[student_id]' AND admin_status='Approved'");
	?>
        <tr>
            <td height="25" align="left" valign="middle" bgcolor="#F8F9FB"  style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $dbf->printStudentName($val["student_id"]);?></td>
            <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $sc[admin_dated];?></td>
            <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $sc[comment];?></td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $sc[cd_comment];?></td>
            <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $sc[admin_comment];?></td>
            <? 
				$i = $i + 1;
		}
			?>
        </tr>
 </table>