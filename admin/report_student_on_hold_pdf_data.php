<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';


//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			       <thead>
                <tr class="logintext">
                  <th width="11%" height="29" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?>  </th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> </th>
                  <th width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE");?> </th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?>  </th>
                  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_COURSEPAUSED");?> </th>
                 <th align="center" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_DATEPAUSED");?> </th>
				   <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" ><?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_LASTCHAPTED");?></th>
                </tr>
				</thead>
                 <?php
					$i = 1;
					$num=$dbf->countRows('student',"studentstatus_id='10'");
					foreach($dbf->fetchOrder('student',"studentstatus_id='10'","id DESC") as $val) {
						
						if($val[register_date] == '0000-00-00')
						{
							$dt = '';
						}
						else
						{
							$dt = date('d-M-Y',strtotime($val[register_date]));
						}
						
						//get current course of the student
						$grp = $dbf->strRecordID("student_group g,student_group_dtls d","g.*","g.id=d.parent_id And g.status<>'Completed' And d.student_id='$val[id]'");
						
						//get course name
						$course = $dbf->strRecordID("course","*","id='$grp[course_id]'");
					?>
                <tr>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></span></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;"><?php echo $dt;?></span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;"><?php echo $val[student_comment];?></span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;"><?php echo $course[name];?></span></td>
                  <td width="11%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">&nbsp;</td>
				    <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">&nbsp;</td>
                  <? 
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>