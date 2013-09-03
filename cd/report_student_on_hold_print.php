<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';


//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			       <thead>
                <tr class="logintext">
                  <th width="11%" height="29" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><span class="menutext"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></span></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?> </th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> </th>
                  <th width="9%" align="center" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE");?> </th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?> </th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"> <?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_COURSEPAUSED");?></th>
                 <th align="center" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_DATEPAUSED");?> </th>
				   <th width="18%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_LASTCHAPTED");?></th>
                </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					$num=$dbf->countRows('student_moving',"status_id='6'");
					foreach($dbf->fetchOrder('student_moving',"status_id='6'","id DESC") as $val1) {
						
						$val = $dbf->strRecordID("student","*","id='$val1[student_id]'");
						if($val[register_date] == '0000-00-00'){
							$dt = '';
						}else{
							$dt = date('d-M-Y',strtotime($val[register_date]));
						}
						
						//get current course of the student
						$grp = $dbf->strRecordID("student_group g,student_group_dtls d","g.*","g.id=d.parent_id And g.status<>'Completed' And d.student_id='$val1[student_id]'");
						
						//get course name
						$course = $dbf->strRecordID("course","*","id='$grp[course_id]'");
					?>
                <tr>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[first_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[email];?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $dt;?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_comment];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $course[name];?></td>
                  <td width="12%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">&nbsp;</td>
				    <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">&nbsp;</td>
                  <? 
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>
<script type="text/javascript">
window.print();
</script>
