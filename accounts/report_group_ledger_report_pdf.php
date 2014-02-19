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
			$start_date = $_REQUEST[start_date];
			$end_date = $_REQUEST[end_date];
			$group_status=$_REQUEST[group_status];
			if($_REQUEST[group_id] != '' && $group_status!=''){$group = "id='$_REQUEST[group_id]' AND status='$group_status'";}
			elseif($_REQUEST[group_id] == '' && $group_status!=''){$group="status='$group_status'";}
			elseif($_REQUEST[group_id] != '' && $group_status==''){$group="id='$_REQUEST[group_id]'";}
			elseif($group_status ==''){$group = "id > 0";}
			elseif($_REQUEST[group_id] == ''){$group = "id > 0";}
			else{$group = "id = '$_REQUEST[group_id]'";}
			$num=$dbf->countRows('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'");
					
			//loop start
			foreach($dbf->fetchOrder('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'","group_name") as $valgroup) {
			//Count the number o students in student_group_dtls table
			$numofstudent=$dbf->countRows('student_group_dtls', "parent_id='$valgroup[id]'");
       
			$course_fee=$dbf->getDataFromTable("course_fee", "fees", "id='$valgroup[course_id]'");
			$en_amt=$course_fee * $numofstudent;
			$payments=$dbf->getDataFromTable("student_enroll se INNER JOIN student_fees sf ON sf.student_id=se.student_id AND sf.course_id=se.course_id", "SUM(sf.paid_amt) as total", "se.group_id='$valgroup[id]'");
			$bal_amt=$en_amt-$payments;
		$html.='<tr>
		  <td align="center" valign="middle">&nbsp;</td>
		  <td align="left" valign="middle">&nbsp;'.$valgroup["group_name"].' '.$dbf->printClassTimeFormat($valgroup["group_start_time"],$valgroup["group_end_time"]).'</td>
		  <td align="left" valign="middle">&nbsp;'.date("d-M-Y",strtotime($valgroup["start_date"])).'&nbsp;/&nbsp;'.date('d-M-Y',strtotime($valgroup["end_date"])).'</td>
		  <td align="center" valign="middle">&nbsp;'.$numofstudent.'</td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$en_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		  <td align="center" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">&nbsp;'.$bal_amt.'&nbsp;'.$res_currency["symbol"].'</span></td>
		</tr>';
			$i = $i + 1;
		}
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_group_ledger_report.pdf", 'D');
	exit;
?>