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
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_ARF_MANAGE_REPORTDATE.'</span></td>
        <td width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_ARF_MANAGE_STUDENTNAME.'</span></td>
        <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_ARF_MANAGE_ACTIONOWENER.'</span></td>
		<td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_ARF_MANAGE_REPORTBY.'</span></td>
        <td width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_ARF_MANAGE_REPORTTO.'</span></td>
        <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Status</span></td>
      </tr>';
		$i = 1;
		$color="#ECECFF";
		$teacher_id=$_SESSION[id];
		//Concate the Condition
		$condition = $dbf->getSearchStrings($_REQUEST["fname"],$_REQUEST["stid"],$_REQUEST["mobile"],$_REQUEST["email"], $centre_id,"s."," And s.id=c.student_id AND c.teacher_id='$teacher_id'");
		//End 4.					
		$num=$dbf->countRows('student s, arf c', $condition);
		foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) 
		{	
			#$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val["dated"].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val['student_id']).'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[action_owner].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[arf_function].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[arf_function1].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">Submitted</td>
	</tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("arf.pdf", 'D');
	exit;
?>