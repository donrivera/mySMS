<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

	$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
                <tr>
                  <th width="3%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
                  <th width="9%" align="left"  bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
                  <th width="17%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
                  <th width="10%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVEFROM.'</span></th>
                  <th width="9%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVETO.'</span></th>
                  <th width="10%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.LIS_LEAVE_TYPE.'</span></th>
                  <th width="34%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS.'</span></th>
                  <th width="8%" align="center" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_ATTACH.'</span></th>
				</tr>';
					$i = 1;
					foreach($dbf->fetchOrder('teacher_vacation',"status='0'","frm") as $val_leave) {
						$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'");
                $html.='<tr>
                  <td align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td align="left" valign="middle" >&nbsp;'.$val_leave[frm].'</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$teacher[name].'</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$val_leave[frm].'</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$val_leave[tto].'</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$val_leave[type].'></td>
                  <td align="left" valign="middle" style="padding-left:1px;"></td>
                  <td align="center" valign="middle" style="padding-left:5px;"> - </td>';
                  }
                $html.='</tr>
          </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_outstanding_report.pdf", 'D');
	exit;
?>