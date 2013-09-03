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

$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
			<tr>
			  <th width="5%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_MANAGE_SL.'</span></th>
			  <th width="34%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_STUDENT.'</span></th>
			  <th width="31%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_EMAIL.'</span></th>
			  <th width="23%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_SMS_GATEWAY_MANAGE_MOBILENO.'</span></th>
			  <th width="7%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_SMS_GATEWAY_MANAGE_STATUS.'</span></th>
			  </tr>';
			$k=1;
			$i = 1;
									
			//Loop start
			foreach($dbf->fetchOrder('student', "centre_id='$_REQUEST[centre_id]'","","") as $valstudent){
			
			$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$valstudent[id]'");
			$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
			$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
			
			$total_course_fees = 0;
			foreach($dbf->fetchOrder('student_group_dtls', "student_id='$valstudent[id]'","","") as $dtls){						
				$total_course_fees = $total_course_fees + $dbf->BalanceAmount($dtls["student_id"],$dtls["course_id"]);						
			}
			
			if($total_course_fees < 0){
		  $html.='<tr>
			<td width="5%" height="25" align="center" valign="middle">'.$k.'</td>
			<td width="34%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$valstudent["first_name"].' '.$Arabic->en2ar($dbf->StudentName($valstudent["id"])).'</span></td>
			<td width="31%" align="left" valign="middle">'.$valstudent["email"].'</td>
			<td width="23%" align="left" valign="middle">'.$valstudent["student_mobile"].'</td>
			<td width="7%" align="left" valign="middle" >'.$moving["name"].'</td>';
				$i = $i + 1;
				$html.='</tr>';
				$k++;
			}
			$total_course_fees = 0;
		}
		$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_credit_balance_report.pdf", 'D');
	exit;
?>