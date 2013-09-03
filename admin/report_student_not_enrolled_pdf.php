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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">
      <tr>
        <td width="3%" height="29" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</td>
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_S_MANAGE_STUDENTNAME.'</span></td>
        <td width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_S10_MOBNO.'</span></td>
        <td width="18%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_EMAIL.'</span></td>
        <td width="11%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE.'</span></td>
        <td width="15%" align="left" valign="middle" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT.'</span></td>
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_LEADINFO.'</span></td>
        <td width="13%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_INTRESTEDIN.'</span></td>
      </tr>';
		if($_REQUEST["teacher"]!=''){
			$cond = "s.id=c.student_id AND c.status_id='$_REQUEST[teacher]'";
		}else{
			$cond = "s.id=c.student_id";
		}
		
		$i = 1;
		$color="#ECECFF";
		
		//Get Number of Rows
		$num=$dbf->countRows('student s,student_moving c',$cond,"");
		
		 //Loop start
		foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.id DESC","s.id","s.id") as $val) {
		
		$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
		
		//Get Course Name
		$course = "";
		foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
		
			$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
			if($course==''){
				$course  = $c["name"];
			}else{
				$course  = $course.",".$c["name"];
			}
		}
		
		//Get Lead Information
		$lead = '';
		foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
		
			$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
			if($lead==''){
				$lead  = $c["name"];
			}else{
				$lead  = $lead.",".$c["name"];
			}
		}
		
		//Register date
		if($val["register_date"] == "0000-00-00"){
			$dt = '';
		}else{
			$dt = date('d-M-Y',strtotime($val_student["created_datetime"]));
		}
		
		//Last comment
		$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
		$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");
		
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["first_name"].'&nbsp;'.$Arabic->en2ar($dbf->StudentName($val_student["id"])).'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["student_mobile"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["email"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dt.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$com["comments"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$lead.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$course.'</span></td>
  </tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_statuses.pdf", 'D');
	exit;
?>