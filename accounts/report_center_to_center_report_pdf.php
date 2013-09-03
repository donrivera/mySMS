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
		  <th width="10%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'</span></th>
		  <th width="10%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_FROM_CENTER.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_TO_CENTER.'</span></th>
		  </tr>';
			$i = 1;
			
			$cond = '';
			if($_REQUEST[centre_id] == ''){
				$cond = "(m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And m.id=d.parent_id ";
			}else if($_REQUEST[centre_id] != ''){
				$cond = "m.centre_id='$_REQUEST[centre_id]' And (m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And m.id=d.parent_id ";
			}
			
			//Get Number of Rows
			$num=$dbf->countRows('transfer_centre_to_centre m,transfer_centre_to_centre_dtls d', $cond);
			
			//loop start
			foreach($dbf->fetchOrder('transfer_centre_to_centre m, transfer_centre_to_centre_dtls d', $cond ,"m.id","m.from_id,m.to_id,m.dated,d.*") as $transfer) {
								
			$student = $dbf->strRecordID("student","*","id='$transfer[student_id]'");
					
			$group = $dbf->strRecordID("student_group","*","id='$transfer[from_id]'");
			$course = $dbf->strRecordID("course","*","id='$group[course_id]'");
			
			$student_enroll = $dbf->strRecordID("student_enroll","*","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
			$enroll = $student_enroll["enrolled_status"];
			$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
			$from_group = $dbf->strRecordID("student_group","*","id='$transfer[from_id]'"); 
			
			$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
			$to_group = $dbf->strRecordID("student_group","*","id='$transfer[to_id]'");
			
			$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$student_enroll[fee_id]'");
			$course_fee = $course_fees;
			$discount = $student_enroll["discount"];
			$en_amt = $course_fee - $discount;
			$paid_amt = $dbf->getDataFromTable("student_fee","SUM(paid_amt)","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
			$bal_amt = $en_amt - $paid_amt;
		$html.='<tr>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$transfer["dated"].'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$enroll.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course["name"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course_fee.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$discount.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->getDiscountPercent($course_fees, $student_enroll["discount"]).'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$paid_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$from_id.' '.$from_group["group_time"].'-'.$dbf->GetGroupTime($from_group["id"]).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$to_id.' '.$to_group["group_time"].'-'.$dbf->GetGroupTime($to_group["id"]).'</span></td>';
			  $i = $i + 1;
		  }
		$html.='</tr>               
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_center_to_center_report.pdf", 'D');
	exit;
?>