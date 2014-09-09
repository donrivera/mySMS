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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
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
						$date_hold=$dbf->strRecordID("student_hold","dated,course_id","student_id='$val[id]'");
						$course = $dbf->strRecordID("course","*","id='$date_hold[course_id]'");
						$lessons=$dbf->genericQuery("
														SELECT pu.material_overed as lesson
														FROM `ped_attendance` p
														INNER JOIN ped_units pu ON pu.course_id=p.course_id AND pu.units=p.unit
														WHERE p.student_id='$val[id]' 
														AND p.course_id='$date_hold[course_id]'
														AND (	p.shift1='X' 
																OR p.shift1='X' 
																OR p.shift2='X'
																OR p.shift3='X'
																OR p.shift4='X'
																OR p.shift5='X'
																OR p.shift6='X'
																OR p.shift7='X'
																OR p.shift8='X'
																OR p.shift9='X')
														ORDER BY pu.units DESC LIMIT 0,1
													");
						foreach($lessons as $l):$student_last_lesson=$l[lesson];endforeach;
					?>
                <tr>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $dbf->printStudentName($val["id"]);?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[email];?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $dt;?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_comment];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $course[name];?></td>
                  <td width="12%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $date_hold[dated];?></td>
				    <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo (empty($student_last_lesson)?"Beginning of Course":$student_last_lesson);?></td>
                  <? 
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>
<script type="text/javascript">
window.print();
</script>
