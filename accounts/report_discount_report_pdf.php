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
			  <th width="9%" align="left" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
			  <th width="16%" align="left" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
			  <th width="11%" align="left" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
			  <th width="13%" align="left" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
			  <th width="10%" align="left" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
			  <th width="9%" align="center" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
			  <th width="12%" align="center" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
			  <th width="12%" align="center" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
			  <th width="10%" align="center" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
			  <th width="10%" align="center" bgcolor="#99CC99"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'</span></th>
			  </tr>';
				$i = 1;
				$cond = '';
				if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				if($_REQUEST["discount_from"] == ''){
					$discount_from = 100;
				}else{
					$discount_from = $_REQUEST["discount_from"];
				}
				if($_REQUEST["discount_to"] == ''){
					$discount_to = 500;
				}else{
					$discount_to = $_REQUEST["discount_to"];
				}
				if($discount_from == '0' && $discount_to == '0'){
					$cond = "(enroll_date BETWEEN '$start_date' And '$end_date')";
				}else if($discount_from != '' && $discount_to != ''){
					$cond = "(discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
				}else{
					$cond = "(enroll_date BETWEEN '$start_date' And '$end_date') And (discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
				}
				
				//Get Number of Rows
				$num=$dbf->countRows('student_enroll', $cond);
				
				//loop start
				foreach($dbf->fetchOrder('student_enroll', $cond,"enroll_date") as $valenroll) {
				
				//Get Student Name
				$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
				
				//Get Course Name
				$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
				
				//Check whether it is for New-Enrollment or Re-enrollment
				$enroll = $valenroll["enrolled_status"];
									
				//Get Group Name
				$group = $dbf->strRecordID("student_group","*","id='$valenroll[course_id]'");
				$course_fees = $dbf->getDataFromTable("course_fee", "fees", "id='$valenroll[fee_id]'");
				
				//Enrollment Amount
				$en_amt = $course_fees;
				
				$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
				$re_amt = $re_amt["SUM(paid_amt)"];
									
				$bal_amt = $en_amt - $re_amt - $valenroll["discount"];
				$discount = number_format($valenroll["discount"],0);
				
				if($course_fees > 0){
					$discount_percent = number_format($dbf->getDiscountPercent($course_fees, $valenroll["discount"]),0);
				}else{
					$discount_percent = 0;
				}
			$html.='<tr>
			  <td align="left" valign="middle">&nbsp;'.date("d-M-Y",strtotime($valenroll["payment_date"])).'</td>
			  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
			  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$course["name"].'</span></td>
			  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$enroll.'</span></td>
			  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->FullGroupInfo($group["id"]).'</span></td>
			  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$discount.'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$discount_percent.'%</span></td>
			  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$re_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>';
			  
				  $i = $i + 1;
			  }
			$html.='</tr>		   
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_discount_report.pdf", 'D');
	exit;
?>