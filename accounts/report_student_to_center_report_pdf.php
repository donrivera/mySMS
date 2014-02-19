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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-collapse:collapse;">
		<tr>
		  <th width="8%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
		  <th width="10%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
		  <th width="8%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_WEEK_MANAGE_STATUS.'</span></th>
		  <th width="7%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_COURSEFEES.'</span></th>
		  <th width="9%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_COURSE_MANAGE_DISCOUNT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.DISCOUNT_PERCENT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_REPT_AMT.'</span></th>
		  <th width="10%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_SEARCH_INVOICE_BALANCEAMOUNT.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_TO_STUDENT.'</span></th>
		  </tr>';
        $i = 1;
        
        $cond = '';
		if($_REQUEST[centre_id] == ''){
			$cond = "(m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') ";
		}else if($_REQUEST[centre_id] != '' && $_REQUEST[start_date] !='' && $_REQUEST[end_date] !=''){
			$cond = "m.centre_id='$_REQUEST[centre_id]' And (m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') ";
		}else if($_REQUEST[centre_id] != '' && $_REQUEST[start_date] =='' && $_REQUEST[end_date] ==''){
			$cond = "m.centre_id='$_REQUEST[centre_id]' ";
		}
					
		//Get Number of Rows
		$num=$dbf->countRows('transfer_student_to_student m', $cond);
					
		//loop start
		foreach($dbf->fetchOrder('transfer_student_to_student m', $cond ,"m.id","m.*") as $transfer) {
					
			$student = $dbf->strRecordID("student","*","id='$transfer[student_id]'");
										
			$group = $dbf->strRecordID("student_group","*","id='$transfer[from_id]'");
			$course = $dbf->strRecordID("course","*","id='$group[course_id]'");
					
			$student_enroll = $dbf->strRecordID("student_enroll","*","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
			$enroll = $student_enroll["enrolled_status"];
			$to_id = $dbf->getDataFromTable("student","first_name","id='$transfer[to_student_id]'");
			$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$student_enroll[fee_id]'");
			$percentage=$dbf->getDiscountPercent($course_fees, $discount);
			$course_fee = $course_fees;
			$discount = $student_enroll["discount"];
			$en_amt = $course_fee - $discount;
			$paid_amt = $dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
			$bal_amt = $en_amt - $paid_amt;
        $html.='<tr>
		  <td align="left" valign="middle">'.$transfer["dated"].'</td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($student["id"]).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$enroll.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->getDataFromTable("student_status", "name", "id='$transfer[from_status_id]'").'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($course_fee)?"0":$course_fee."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($discount)?"0":$discount."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($discount)?"0":$percentage."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($en_amt)?"0":$en_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($paid_amt)?"0":$paid_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($bal_amt)?"0":$bal_amt."&nbsp;".$res_currency[symbol]).'</span></td>
		  <td align="left" valign="middle">'.$dbf->printStudentName($transfer["to_student_id"]).'</td>';
			$i = $i + 1;			  
		  }
		$html.='</tr>               
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_to_center_report.pdf", 'D');
	exit;
?>