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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" style="border-collapse:collapse;">
			<tr>
			  <th width="2%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
			  <th width="7%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
			  <th width="17%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
			  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_PAYMENT_AMOUNT.'</span></th>
			  <th width="15%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
			  <th width="15%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
			  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_DISCOUNT_AMOUNT.'</span></th>
			  <th width="10%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
			  <th width="10%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
			  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'<span</th>
			  </tr>';
				$i = 1;
				foreach($dbf->fetchOrder('student_enroll',"payment_date<>'0000-00-00' And (payment_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","payment_date") as $valenroll) {
				
				//Check whether it is for New-Enrollment or Re-enrollment
				$enroll = $valenroll["enrolled_status"];
				
				//Get Student Name
				$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
				//Get Student Name
				$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
				//Get Course Name
				$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
				
				$en_amt = $valenroll[course_fee] - $valenroll[discount];
				$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]'");
				$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
				$bal_amt = $en_amt - $re_amt;
				if($bal_amt <= 0){
				  
				$html.='<tr>
				  <td align="center" valign="middle" >&nbsp;</td>
				  <td align="left" valign="middle" >'.$valenroll[payment_date].'</td>
				  <td align="left" valign="middle" >&nbsp;'.$student[first_name].'</td>
				  <td align="right" valign="middle" >'.$valenroll["course_fee"].'&nbsp;</td>
				  <td align="center" valign="middle" >&nbsp;'.$enroll.'</td>
				  <td align="left" valign="middle" >&nbsp;'.$group["group_name"].' '.$group["group_time"].'-'.$dbf->GetGroupTime($group["id"]).'</td>
				  <td align="right" valign="middle" >'.$valenroll["course_fee"].'&nbsp;</td>
				  <td align="right" valign="middle" >'.$en_amt.'&nbsp;</td>
				  <td align="right" valign="middle" >'.$re_amt.'&nbsp;</td>
				  <td align="right" valign="middle" >'.$bal_amt.'&nbsp;</td>';
					$i = $i + 1;
				}
		  }
		  $html.='</tr>
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_unit_taught_report.pdf", 'D');
	exit;
?>