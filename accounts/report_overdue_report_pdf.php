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
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_PAYMENT_AMOUNT.'</span></th>
		  <th width="14%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
		  <th width="8%" align="left"  bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
		  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
		  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
		  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'</span></th>
		  <th width="7%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_30_DAYS.'</span></th>
		  <th width="7%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_60_DAYS.'</span></th>
		  </tr>';
			$i = 1;
			
			//Get Number of Rows
			$num=$dbf->countRows('student_enroll',"centre_id='$_REQUEST[centre_id]'");
			
			//loop start
			foreach($dbf->fetchOrder('student_fees',"centre_id='$_REQUEST[centre_id]' And (fee_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","fee_date") as $valfee) {
			
			$student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
			$course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
			$group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
			$group = $dbf->strRecordID("student_group","*","id='$group_id'");
			
			$re_en =$dbf->strRecordID('student_enroll',"*","student_id='$valfee[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
			$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$re_en[fee_id]'");
			$enroll = $re_en["enrolled_status"];
					
			$en_amt = $course_fees - $re_en["discount"];
			$bal_amt = $en_amt - $valfee[paid_amt];
			
			$days = $dbf->dateDiff($valfee[fee_date],$valfee[paid_date]);		
			
			if($days > 29){
		$html.='<tr>
		  <td align="left" valign="middle">&nbsp;'.$valfee["fee_date"].'</td>
		  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$valfee["fee_amt"].'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$enroll.' '.$res_currency["symbol"].'</span></td>
		  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$group["group_name"].' '.$group["group_time"].'-'.$dbf->GetGroupTime($group["id"]).'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$re_en["discount"].'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->getDiscountPercent($course_fees, $re_en["discount"]).'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$valfee[paid_amt].'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'></span></td>
		  <td align="center" valign="middle" >';
		  if($days <= 30){
			  $days;
		  }
		  $html.='</td>
		  <td align="center" valign="middle" >';
		  if($days > 30){
			  $days;
		  }
		  $html.='</td>';
			  $i = $i + 1;
		  }
		$html.='</tr>';
			} // Days
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_overdue_report.pdf", 'D');
	exit;
?>