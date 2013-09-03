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
                  <th width="11%" height="29" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> </th>
                  <th width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE");?> </th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?> </th>
                  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_COURSEPAUSED");?> </th>
                 <th align="center" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_DATEPAUSED");?> </th>
				   <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_LASTCHAPTED");?></th>
                </tr>
				</thead>
                <?php
					$i = 1;
					$num=$dbf->countRows('student',"studentstatus_id='10'");
					foreach($dbf->fetchOrder('student',"studentstatus_id='10'","id DESC") as $val) {
					?>
                <tr>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB"  style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[first_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[email];?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $dt;?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_comment];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $course[name];?></td>
                  <td width="11%" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">&nbsp;</td>
				    <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">&nbsp;</td>
                  <? 
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>