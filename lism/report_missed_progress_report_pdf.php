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
			  <th width="3%" height="30" align="center" valign="middle">&nbsp;</th>
			  <th width="9%" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.LISM_DUE_DATE.'</span></th>
			  <th width="21%" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
			  <th width="17%" height="30" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_CENTRE_MANAGE_CENTRENAME.'</span></th>
			  <th width="12%" align="left"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME.'</span></th>
			  <th width="15%" align="left"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></th>
			  <th width="11%" align="center"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_CD_GRAPHS_NOOFSTUDENT.'</span></th>
			  <th width="12%" align="left"><span id="result_box" lang="ar" xml:lang="ar">'.LISM_UPDATE_DATE.'</span></th>
			  </tr>';
				$i = 1;
				foreach($dbf->fetchOrder('student_group',"(preport_filled='' OR preport_filled='No') And centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'","id") as $val_leave) {
					$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'");
					$centre = $dbf->strRecordID("centre","*","id='$val_leave[centre_id]'");
					$course = $dbf->strRecordID("course","*","id='$val_leave[course_id]'");
					$no_of_students = $dbf->countRows("student_group_dtls","parent_id='$val_leave[id]'");               
			$html.='<tr>
			  <td align="center" valign="middle" class="mycon">&nbsp;</td>
			  <td align="left" valign="middle" class="mycon" >&nbsp;'.$val_leave[end_date].'</td>
			  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$teacher[name].'</td>
			  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$centre[name].'</td>
			  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$dbf->FullGroupInfo($val_leave["id"]).'</td>
			  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$course[name].'</td>
			  <td align="center" valign="middle" class="mycon" style="padding-left:5px;">'.$no_of_students.'</td>
			  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$val_leave[preport_update_date].'</td>';
				  $i = $i + 1;
			  }
			$html.='</tr>                   
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_missed_progress_report.pdf", 'D');
	exit;
?>