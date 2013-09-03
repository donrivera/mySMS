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
			  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
			  <th width="17%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
			  <th width="10%" height="30" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVEFROM.'</span></th>
			  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVETO.'</span></th>
			  <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_LEAVE_TYPE.'</span></th>
			  <th width="34%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS.'</span</th>
			  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_ATTACH.'</span></th>
			  </tr>';
				$i = 1;
				
				$num=$dbf->countRows('teacher_vacation',"teacher_id='$_REQUEST[teacher_id]'");
				
				foreach($dbf->fetchOrder('teacher_vacation',"teacher_id='$_REQUEST[teacher_id]'","frm") as $val_leave) {
					$teacher = $dbf->strRecordID("teacher","*","id='$_REQUEST[teacher_id]'");
			$html.='<tr>
			  <td align="center" valign="middle" >&nbsp;</td>
			  <td align="left" valign="middle" >&nbsp;'.$val_leave[frm].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$teacher[name].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$val_leave[frm].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$val_leave[tto].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$val_leave[type].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;"></td>
			  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"> - </td>';
				  $i = $i + 1;
			  }
			$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_sick_leave_report.pdf", 'D');
	exit;
?>