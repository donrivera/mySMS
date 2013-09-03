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

$html = '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" bgcolor="#999999"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS.'</span></td>
		  </tr>
		  <tr>
			<td height="5" align="left" valign="middle"></td>
		  </tr>';
		 $res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
		  $html.='<tr>
			<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_S2_NAME.' : '.$res["first_name"].' '.$Arabic->en2ar($dbf->StudentName($res["id"])).'</span></td>
		  </tr>
		  <tr>
			<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_IDNO.' : '.$res["student_id"].'</span></td>
		  </tr>
		  <tr>
			<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL.' : &nbsp;'.$res["email"].'</span></td>
		  </tr>
	</table>
	<br />
	<table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#cccccc" style="border-collapse:collapse;">
          <tr>
            <td width="8%" height="25" align="center" valign="middle" bgcolor="#999999">&nbsp;</td>
            <td width="31%" align="left" valign="middle" bgcolor="#999999" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></td>
            <td width="27%" align="center" valign="middle" bgcolor="#999999"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE.'</span></td>
            <td width="34%" align="center" valign="middle" bgcolor="#999999"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE.'</span></td>
          </tr>';
            $i = 1;
            
            $num=$dbf->countRows('grade');
            foreach($dbf->fetchOrder('student_group_dtls',"student_id='$res[id]'","id DESC") as $val) {
            
            $res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");					
            if($res_course[name] !='') {
                
            //Get percentage
            $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$val[course_id]' And student_id='$_REQUEST[student_id]'");					
            $mark = $res_per[final_percent];
            
            //Get Average
            $grade = $dbf->strRecordID("grade","*","(tto>='$mark' And frm<='$mark')");
            $grade_name = $grade[name];
          $html.='<tr>
            <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">&nbsp;</td>
            <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" ><span id="result_box" lang="ar" xml:lang="ar">'.$res_course["name"].'</span></td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" >'.$mark.'%</td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" >'.$grade_name.'</td>';
            }
		  $i = $i + 1;
		  }
          $html.='</tr>
        </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("details_students_results.pdf", 'D');
	exit;
?>	