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
			  <th width="8%" height="30" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
			  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
			  <th width="14%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
			  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
			  <th width="12%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_COURSENAME.'</span></th>
			  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
			  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
			  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
			  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
			  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'</span></th>
			  <th width="7%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_30_DAYS.'</span></th>
			  <th width="7%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_60_DAYS.'</span></th>
			  </tr>';
			  
				$i = 1;
				$num=$dbf->countRows('student_enroll',"centre_id='$_REQUEST[centre_id]' And beddebt_amt > 0 And (enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
				
				//loop start
				foreach($dbf->fetchOrder('student_enroll',"centre_id='$_REQUEST[centre_id]' And beddebt_amt > 0 And (enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","payment_date") as $valfee) {
				
				$student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
				$course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
				$group = $dbf->strRecordID("student_group","*","id='$valfee[group_id]'");
				
				//Check whether it is for New-Enrollment or Re-enrollment
				$enroll = $valfee["enrolled_status"];	
				
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valfee[fee_id]'");
				$en_amt = ($course_fees - $valfee["discount"]) + $valfee["other_amt"];
				
				$paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","status='1' And student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
				$paid = $paid["SUM(paid_amt)"];
				
				$bal_amt = $dbf->BalanceAmount($valfee["student_id"],$valfee["course_id"]);
				$days = $dbf->dateDiff($group["end_date"],date('Y-m-d'));
			$html.='<tr>
			  <td align="left" valign="middle" >&nbsp;'.$valfee["payment_date"].'</td>
			  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
			  <td align="center" valign="middle" >'.$enroll.'</td>
			  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$group["group_name"].' '.$group["group_time"].' '.$dbf->GetGroupTime($group["id"]).'</span></td>
			  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$course["name"].'</span></td>
			  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$valfee["discount"].'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->getDiscountPercent($course_fees, $valfee["discount"]).'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$paid.'&nbsp;'.$res_currency["symbol"].'</span></td>
			  <td align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
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
			$html.='</tr>               
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_beddebt_report.pdf", 'D');
	exit;
?>