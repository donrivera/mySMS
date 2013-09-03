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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
		<tr>
		  <th width="3%" align="center" bgcolor="#CCCCCC">&nbsp;</th>
		  <th width="9%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
		  <th width="14%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
		  <th width="20%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
		  <th width="15%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
		  <th width="9%" align="right" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_DASHBOARD_AMOUNT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_PAYMENT_MANAGE_PAYMENTTYPE.'</span></th>
		  <th width="9%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_PRINT_INVOICE_INVOICENO.'</span></th>
		  <th width="12%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_RE_NO.'</span></th>
		  </tr>';
			$i = 1;
			
			$cond = '';
			if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] == ''){
				$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
			}else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] == ''){
				$cond = "centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
			}else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] != ''){
				$cond = "centre_id='$_REQUEST[centre_id]' And payment_type='$_REQUEST[payment_type]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
			}else if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] != ''){
				$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And payment_type='$_REQUEST[payment_type]'";
			}
							
			//Get Number of Rows
			$num=$dbf->countRows('student_fees',$cond);
			
			//loop start
			foreach($dbf->fetchOrder('student_fees', $cond." And status='1'" ,"paid_date") as $valfee) {
			
			//Check whether it is for New-Enrollment or Re-enrollment
			$student_enroll = $dbf->strRecordID('student_enroll',"*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
			$enroll = $student_enroll["enrolled_status"];
			
			//Get Student Name
			$student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
			//Get Course Name
			$course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
			//Get Payment Type
			$ptype = $dbf->strRecordID("common","*","id='$valfee[payment_type]'");
		$html.='<tr>
		  <td align="center" valign="middle">'.$i.'</td>
		  <td align="left" valign="middle" >'.$valfee["paid_date"].'</td>
		  <td align="center" valign="middle">'.$enroll.'</td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course["name"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$valfee["paid_amt"].' '.$res_currency["symbol"].'</span></td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$ptype["name"].'</span></td>
		  <td align="center" valign="middle" >'.$dbf->GetBillNo($valfee["student_id"], $valfee["course_id"]).'</td>
		  <td align="center" valign="middle" >'.$valfee["invoice_no"].'</td>';
			  $i = $i + 1;
		  }
		$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_transaction_report.pdf", 'D');
	exit;
?>