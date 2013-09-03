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

$html = '<table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
              <tr>
                <td height="25" align="left" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_TEACHER_COURSENAME.'</span></td>
                <td align="left" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></td>
                <td align="center" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT.'</span></td>
                <td align="center" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS.'</span></td>
              </tr>';
			
			$num=$dbf->countRows('student_group',"teacher_id='$_REQUEST[teacher]'","");
			 
			foreach($dbf->fetchOrder('student_group',"teacher_id='$_REQUEST[teacher]'","id","") as $val){
			
			$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");			
			$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");			
			$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");			
			$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
              
		  $html.='<tr>
			<td width="278" height="25" align="left" valign="middle" bgcolor="#FDF9F2">'.$val_course[name].'</td>
			<td width="430" align="left" valign="middle" bgcolor="#FDF9F2">'.$dbf->FullGroupInfo($val["id"]).'</td>
			<td width="127" align="center" valign="middle" bgcolor="#FDF9F2">'.$val_no["COUNT(id)"].'</td>
			<td width="126" align="center" valign="middle" bgcolor="#FDF9F2">'.$val[status].'</td>
		  </tr>';
		  }
		$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_schedule_teacher.pdf", 'D');
	exit;
?>