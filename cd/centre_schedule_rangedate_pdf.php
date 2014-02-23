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
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></td>
			<td height="25" align="center" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_GROUP.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS.'</span></td>
		  </tr>';
		
		 if($_REQUEST[startdate] !='' AND $_REQUEST[enddate] !=''){
        $cond="(start_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]') And centre_id='$_SESSION[centre_id]' ";
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
			<td width="202" align="center" valign="middle">'.$val_teacher[name].'</td>
			<td width="188" height="25" align="center" valign="middle" >'.$val_course[name].'</td>
			<td width="367" align="center" valign="middle">'.$dbf->FullGroupInfo($val["id"]).'</td>
			<td width="100" align="center" valign="middle">'.$val_no["COUNT(id)"].'</td>
			<td width="102" align="center" valign="middle">'.$val[status].'</td>
		  </tr>';
		 }		 
		$html.='</table>';
		
	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("centre_schedule_enddate_pdf.pdf", 'D');
	exit;
?>