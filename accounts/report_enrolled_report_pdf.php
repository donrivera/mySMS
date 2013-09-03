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
		  <th width="15%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_STUDENT.'</span></th>
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
		  <th width="12%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
		  <th width="12%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_COURSEFEE.'</span></th>
		  <th width="9%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
		  <th width="8%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
		  </tr>';
			$i = 1;
			
			//Get Number of Rows
			$num=$dbf->countRows('student_enroll',"(enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
			$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
			
			//loop start
			foreach($dbf->fetchOrder('student_enroll',"(enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","enroll_date") as $valenroll) {
				
			$enroll = $valenroll["enrolled_status"];
			
			//Get Student Name
			$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
			//Get Student Name
			$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
			//Get Course Name
			$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
			
			$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valenroll[fee_id]'");
			$en_amt = $course_fees - $valenroll["discount"];
			
			$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
			$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
		$html.='<tr>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$student["first_name"].' '.$Arabic->en2ar($dbf->StudentName($student["id"])).'</span></td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$enroll.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$group["group_name"].' '.$group["group_time"].'-'.$dbf->GetGroupTime($group["id"]).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course["name"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$valenroll["course_fee"].'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$valenroll["discount"].'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.number_format($dbf->getDiscountPercent($course_fees, $valenroll["discount"]),0).'%</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$re_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>';
			  $i = $i + 1;
		  }
		$html.='</tr>
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_enrolled_report.pdf", 'D');
	exit;
?>