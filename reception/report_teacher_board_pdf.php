<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

ini_set('memory_limit', '-1');

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
			<tr>
			  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
			  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
			  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_CURRENTGROUP.'</th>
			  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE.'</span></th>
			  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE.'</span></th>
			  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_NUMBEROFSTUD.'</span></th>
			  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_CLASSROOM.'</span></th>
			  </tr>';
				$i = 1;
				$num=$dbf->countRows('student_group',"teacher_id='$_REQUEST[teacher]' And centre_id='$_SESSION[centre_id]'");
				foreach($dbf->fetchOrder('student_group',"teacher_id='$_REQUEST[teacher]' And centre_id='$_SESSION[centre_id]'","id") as $val) {
				
					$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
					$std = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$val[id]'");
					$room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
					$num1=$dbf->countRows('student_group_dtls',"parent_id='$val[id]'");
			$html.='<tr>
			  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
			  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB">'.$res["name"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["group_name"].' '.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["start_date"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$val["end_date"].'</td>			  
			  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$std["COUNT(student_id)"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$room["name"].'</td>';
			  $i = $i + 1;
			  }
			$html.='</tr>
			</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_board.pdf", 'D');
	exit;
?>	