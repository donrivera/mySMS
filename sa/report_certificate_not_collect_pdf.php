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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
		  <tr>
			<th width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_MANAGE_SL.'</span></th>
			<th width="18%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_NAME.'</span></th>
			<th width="18%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_MOBILE.'</span></th>
			<th width="28%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_EMAIL.'</span></th>
			<th width="7%" align="center" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_AUTO_SEARCH_AGE.'</span></th>
			</tr>';
			$k=1;			
			$color = "#ECECFF";
			
			if($_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
				$cond="certificate_collect='0' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And centre_id='$_SESSION[centre_id]'";
			}else{
				$cond="certificate_collect='0' And centre_id='$_SESSION[centre_id]'";
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
				<td width="18%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$val[first_name].' '.$Arabic->en2ar($dbf->StudentName($val["id"])).'</span></td>
				<td width="18%" align="left" valign="middle" >'.$val[student_mobile].'</td>
				<td width="28%" align="left" valign="middle" >'.$val[email].'</td>
				<td width="7%" align="center" valign="middle">'.$val[age].'</td>
			</tr>';
				$k++;
			}
		$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_certificate_not_collect.pdf", 'D');
	exit;
?>	
