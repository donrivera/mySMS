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
		  <th width="3%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
		  <th width="14%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
		  <th width="20%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VACATION_CENTRE_MANAGE_STARTDATE.' / '.ADMIN_VACATION_CENTRE_MANAGE_ENDDATE.'</span></th>
		  <th width="21%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_COUNT_STU.'</span></th>
		  <th width="22%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_TOT_EN_AMOUNT.'</span></th>
		  <th width="20%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_TOT_BAL_AMOUNT.'</span></th>
		  </tr>';
			$i = 1;
			if($_REQUEST[group_id] == ''){
				$cond = "id > 0 And ()";
			}else{
				$cond = '';
				if($_REQUEST[student_id] == '' && $_REQUEST[balance] == ''){
					$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
				}else if($_REQUEST[student_id] != '' && $_REQUEST[balance] == ''){
					$cond = "student_id='$_REQUEST[student_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
				}else if($_REQUEST[student_id] == '' && $_REQUEST[balance] != ''){
					$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
				}else if($_REQUEST[student_id] != '' && $_REQUEST[balance] != ''){
					$cond = "student_id='$_REQUEST[student_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
				}
				$group = "id = '$_REQUEST[group_id]'";
			}
			$num=$dbf->countRows('student_fees', $group);
			//loop start
			foreach($dbf->fetchOrder('student_group', $group) as $valgroup) {
			
			//Count the number o students in student_group_dtls table
			$numofstudent=$dbf->countRows('student_group_dtls', "parent_id='$valgroup[id]'");
			
			//Get Enrollment Amount for a particular group
			$course_fee = 0;
			foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll) {
				if($course_fee == 0){
					$course_fee = $enroll["course_fee"];
				}else{
					$course_fee = $course_fee + $enroll["course_fee"];
				}
			}
			
			//Get Enrollment Amount for a particular group
			$en_amt = 0;
			foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll) {
				if($en_amt == 0){
					$en_amt = $enroll["course_fee"] - $enroll["discount"];
				}else{
					$en_amt = $en_amt + ($enroll["course_fee"] - $enroll["discount"]);
				}
			}					
			$bal_amt = $course_fee - $en_amt;
		$html.='<tr>
		  <td align="center" valign="middle">&nbsp;</td>
		  <td align="left" valign="middle">&nbsp;'.$valgroup["group_name"].' '.$valgroup["group_time"].'-'.$dbf->GetGroupTime($valgroup["id"]).'</td>
		  <td align="left" valign="middle">&nbsp;'.date("d-M-Y",strtotime($valgroup["start_date"])).'&nbsp;/&nbsp;'.date('d-M-Y',strtotime($valgroup["end_date"])).'</td>
		  <td align="center" valign="middle">&nbsp;'.$numofstudent.'</td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		</tr>';
			$i = $i + 1;
		}
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_group_ledger_report.pdf", 'D');
	exit;
?>