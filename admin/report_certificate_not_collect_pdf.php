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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
			<tr>
			<th width="5%" height="25" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_MANAGE_SL.'</span></th>
			<th width="18%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_NAME.'</span></th>
			<th width="18%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_MOBILE.'</span></th>
			<th width="28%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_EMAIL.'</span></th>
			<th width="7%" align="center" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_AUTO_SEARCH_AGE.'</span></th>
			</tr>';
			$k=1;
			$i = 1;
			
			if($_REQUEST["start_date"]!='' && $_REQUEST["end_date"]!=''){
				$cond = "certificate_collect='0' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
			}else{
				$cond = "certificate_collect='0'";
			}
		
			//Get number of rows
			$num=$dbf->countRows('student_enroll', $cond);
			
			//Get currency
			$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
			
			//Loop start
			foreach($dbf->fetchOrder('student_enroll', $cond ,"","") as $val1){
				$val = $dbf->strRecordID("student","*","id='$val1[student_id]'");
		  $html.='<tr>
			<td width="5%" height="25" align="center" valign="middle">'.$k.'</td>
			<td width="21%" align="left" valign="middle" style="padding-left:1px;"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val[id]).'</span></td>
			<td width="18%" align="left" valign="middle" style="padding-left:5px;">'.$val["student_mobile"].'</td>
			<td width="28%" align="left" valign="middle" style="padding-left:5px;">'.$val["email"].'</td>
			<td width="7%" align="center" valign="middle" style="padding-left:5px;">'.$val["age"].'</td>
		  </tr>';
		  $k++;
			}
		$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_certificate_not_collect.pdf", 'D');
	exit;
?>	
