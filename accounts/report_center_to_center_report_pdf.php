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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
		<tr>
		  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
		  <th width="10%" height="30" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
		  <th width="8%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
		  <th width="7%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_COURSEFEE.'</span></th>
		  <th width="9%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
		  <th width="10%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">Balance</span></th>
		  <th width="10%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">From</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">To</span></th>
		  </tr>';
			$i = 1;
			$start_date = $_REQUEST[start_date];
			$end_date = $_REQUEST[end_date];
			$cond = "(m.dated BETWEEN '$start_date' And '$end_date') ";
			if($_REQUEST[centre_id] != '')
			{$cond = "m.centre_id='$_REQUEST[centre_id]' And (m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') ";}
			//Get Number of Rows
			$num=$dbf->countRows('transfer_centre_to_centre m', $cond);
			//loop start
			foreach($dbf->fetchOrder('transfer_centre_to_centre m', $cond ,"","m.*") as $transfer) 
			{
				$course = $dbf->strRecordID("course","*","id='$transfer[from_course_id]'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$transfer[from_course_id]'");
				$student_enroll = $dbf->strRecordID("student_enroll","*","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
				$discount = $student_enroll["discount"];
				$status = $dbf->getDataFromTable("student_status","name","id='$transfer[from_status_id]'");
				$percentage=$dbf->getDiscountPercent($course_fees, $discount);
				$en_amt = $course_fee - $discount;
				$paid_amt = $dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$transfer[student_id]' And course_id='$transfer[from_course_id]'");
				$from=$dbf->getDataFromTable("centre","name","id=$transfer[centre_from]");
				$to=$dbf->getDataFromTable("centre","name","id=$transfer[centre_to]");
				$bal_amt = $en_amt - $paid_amt;
		$html.='<tr>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$transfer["dated"].'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($transfer["student_id"]).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$status.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($course["name"])?"N/A":$course[name]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($course_fees)?"0":$course_fees."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($discount)?"0":$discount."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($discount)?"0":$percentage."&nbsp;".$res_currency[symbol]).'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($en_amt)?"0":$en_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($paid_amt)?"0":$paid_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($bal_amt)?"0":$en_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$from.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$to.'</span></td>';
			  $i = $i + 1;
		  }
		$html.='</tr>               
	</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_center_to_center_report.pdf", 'D');
	exit;
?>