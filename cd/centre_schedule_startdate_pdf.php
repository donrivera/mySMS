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

$html = '<table width="1000" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">            
		  <tr>
			<td height="25" align="left" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></td>
			<td align="left" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_GROUP.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS.'</span></td>
		</tr>';
		  
		
if($_REQUEST[startdate] !=''){
  $cond="start_date >='$_REQUEST[startdate]' And centre_id='$_SESSION[centre_id]'";
}else{
  $cond="centre_id='$_SESSION[centre_id]'";
}

//Get Number of Rows
 $num=$dbf->countRows('student_group',$cond);
//echo $num;

//Loop start
foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){

//Get no of students
$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");

//Get group name
$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");

//Get course name
$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");

//Get teacher name
$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
		
	  $html.='<tr>
		<td width="138" align="left" valign="middle">'.$val_teacher[name].'</td>
		<td width="143" align="center" valign="middle"  class="mycon">'.$val_course[name].'</td>
		<td width="123" align="center" valign="middle"  class="mycon">'.$dbf->FullGroupInfo($val["id"]).'</td>
		<td width="130" align="center" valign="middle"  class="mycon">'.$val_no["COUNT(id)"].'</td>
		<td width="96" align="center" valign="middle"  class="mycon">'.$val[status].'</td>
	  </tr>';
      }
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_schedule_table.pdf", 'D');
	exit;
?>	