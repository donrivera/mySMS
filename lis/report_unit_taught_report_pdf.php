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
/*
$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" style="border-collapse:collapse;">
			<tr>
				<th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
				<th width="7%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
				<th width="17%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</span></th>
				<th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_PAYMENT_AMOUNT.'</span></th>
				<th width="15%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
				<th width="15%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
				<th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_GROUP_MANAGE_GROUPSTART.'</span></th>
				<th width="10%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_DISCOUNT_AMOUNT.'</span></th>
				<th width="10%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
				<th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">Balance<span</th>
			</tr>';
			$i = 1;
			//loop start
			foreach($dbf->fetchOrder('student_enroll',"enroll_date<>'0000-00-00' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","enroll_date") as $valenroll) 
			{
				$enroll = $valenroll["enrolled_status"];
					
				//Get Student Name
				$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
				//Get Student Name
				$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
				//Get Course Name
				$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
				$payment=$dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]'");
				$en_amt = $valenroll[course_fee] - $valenroll[discount];
				$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
				$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
				$bal_amt = $en_amt - $re_amt;
				
				  
				$html.='<tr>
					<td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
					<td align="left" valign="middle" >'.$valenroll[payment_date].'</td>
					<td align="left" valign="middle" >&nbsp;'.$dbf->printStudentName($student[id]).'</td>
					<td align="right" valign="middle" >'.$payment.'&nbsp;</td>
					<td align="center" valign="middle" >&nbsp;'.$enroll.'</td>
					<td align="left" valign="middle" >&nbsp;'.$group["group_name"].'&nbsp;'.$dbf->printClassTimeFormat($group["group_start_time"],$group["group_end_time"]).'</td>
					<td align="right" valign="middle" >'.$group["start_date"].'<br>'.$group["end_date"].'&nbsp;</td>
					<td align="right" valign="middle" >'.$valenroll["discount"].'&nbsp;</td>
					<td align="right" valign="middle" >'.$valenroll['course_fee'].'&nbsp;</td>
					<td align="right" valign="middle" >'.$re_amt.'&nbsp;</td>';
					$i = $i + 1;
				
			}
		  $html.='</tr></table>';
*/
	$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
			<tr>
				<th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
				<th width="17%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
				<th width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_STU_EN_AR.'</th>
				<th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_PAYMENT_AMOUNT.'</span></th>
				<th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_NEW_EN.'</span></th>
				<th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_GROUP_MANAGE_GROUPNAME.'</span></th>
				<th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_GROUP_MANAGE_GROUPSTART.'</span></th>
				<th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_DISCOUNT_AMOUNT.'</span></th>
				<th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ACCOUNTANT_EN_AMT.'</span></th>
				<th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Balance</span></th>
			</tr>';
			$i = 1;
			//loop start
			foreach($dbf->fetchOrder('student_enroll',"enroll_date<>'0000-00-00' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","enroll_date") as $valenroll) 
			{
				$enroll = $valenroll["enrolled_status"];
					
				//Get Student Name
				$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
				//Get Student Name
				$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
				//Get Course Name
				$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
				$payment=$dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]'");
				$en_amt = $valenroll[course_fee] - $valenroll[discount];
				$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
				$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
				$bal_amt = $en_amt - $re_amt;
				
				  
				$html.='<tr>
					<td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
					<td align="left" valign="middle" >'.$valenroll[enroll_date].'</td>
					<td align="left" valign="middle" >&nbsp;'.$dbf->printStudentName($student[id]).'</td>
					<td align="right" valign="middle" >'.$payment.'&nbsp;</td>
					<td align="center" valign="middle" >&nbsp;'.$enroll.'</td>
					<td align="left" valign="middle" >&nbsp;'.$group["group_name"].'&nbsp;'.$dbf->printClassTimeFormat($group["group_start_time"],$group["group_end_time"]).'</td>
					<td align="right" valign="middle" >'.$group["start_date"].'<br>'.$group["end_date"].'&nbsp;</td>
					<td align="right" valign="middle" >'.$valenroll["discount"].'&nbsp;</td>
					<td align="right" valign="middle" >'.$valenroll['course_fee'].'&nbsp;</td>
					<td align="right" valign="middle" >'.$re_amt.'&nbsp;</td>';
					$i = $i + 1;
				
			}  
	$html.='</table>';
	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_unit_taught_report.pdf", 'D');
	exit;
?>