<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

	$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
			<tr>
				<th width="17%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
				<th width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</th>
				<th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVEFROM.'</span></th>
				<th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_LEAVE_MANAGE_LEAVETO.'</span></th>
				<th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_LEAVE_TYPE.'</span></th>
				<th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS.'</span></th>
			</tr>';
				$i = 1;
				
				//Get Number of Rows
				$num=$dbf->countRows('sick_leave',"teacher_id='$_REQUEST[teacher_id]'");
					
				//loop start
				foreach($dbf->fetchOrder('sick_leave',"teacher_id='$_REQUEST[teacher_id]'","from_date") as $val_leave) {
				$teacher = $dbf->strRecordID("teacher","*","id='$_REQUEST[teacher_id]'");
	$html.='<tr>
			  <td align="left" valign="middle" >&nbsp;'.$val_leave[from_date].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$teacher[name].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$val_leave[from_date].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.$val_leave[to_date].'</td>
			  <td align="left" valign="middle" style="padding-left:5px;">'.TEACHER_MANAGE_SICKLEAVE_SICKLV.'</td>
			  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;">'.$val_leave["sick_reason"].'</td>';
				  $i = $i + 1;
			  }
			$html.='</tr>
		</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_sick_leave_report.pdf", 'D');
	exit;
?>