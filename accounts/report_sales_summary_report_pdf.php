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
$fl = $_REQUEST["radio"];

$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="25" colspan="6" align="left" valign="middle">&nbsp;</td>
			</tr>
		  <tr>
			<td align="right" valign="middle">&nbsp;</td>
			<td height="25" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_GROUP_SIZE_CENTRE.'</span> : </td>
			<td align="left" valign="middle">'.$dbf->getDataFromTable("centre","name","id='$_REQUEST[centre_id]'").'</td>
			<td align="right" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="right" valign="middle">&nbsp;</td>
		  </tr>';
		  if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '') {
		  $html='<tr>
			<td width="7%" align="right" valign="middle">&nbsp;</td>
			<td width="5%" height="25" align="left"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM.'</span> : &nbsp;</td>
			<td width="10%" align="left" valign="middle">'.$_REQUEST[start_date].'</td>
			<td width="3%" align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO.'</span> : &nbsp;</td>
			<td width="9%" align="left" valign="middle">'.$_REQUEST[end_date].'</td>
			<td width="3%" align="right" valign="middle">&nbsp;</td>
		  </tr>';
		  }
		  $html.='<tr>
			<td width="7%" align="right" valign="middle">&nbsp;</td>
			<td height="25" colspan="2" align="left" ></td>
			<td width="3%" align="center" valign="middle">&nbsp;</td>
			<td width="9%" align="left" valign="middle">&nbsp;</td>
			<td width="3%" align="right" valign="middle" >&nbsp;</td>
		  </tr>
		  <tr>
			<td height="5" colspan="6" align="left" valign="middle">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="5" colspan="6" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="6%">&nbsp;</td>
				<td width="94%"><table width="450" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
				  <tr>
					<td width="11%" height="25" bgcolor="#CCCCCC">&nbsp;</td>
					<td width="40%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_PAYMENT_MANAGE_PAYMENTTYPE.'</span></td>
					<td width="49%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_TEACHER_PROGRESS_TOTAL.'</span></td>
				  </tr>';
				$i = 1;
											   
				//Conditions
				$start_date = '';
				$end_date = '';
				if($fl == 'Date_Range'){
					$start_date = $_REQUEST[start_date];
					$end_date = $_REQUEST[end_date];
				}else if($fl == 'Today'){
					$start_date = date('Y-m-d');
					$end_date = date('Y-m-d');
				}else if($fl == 'This Week'){
					$start_date = $dbf->WeekStartDay(date('Y-m-d'));
					$end_date = $dbf->WeekEndDay(date('Y-m-d'));
				}else if($fl == 'Last Week'){
					$start_date = $dbf->LastWeekStartDay();
					$end_date = $dbf->LastWeekEndDay();
				}else if($fl == 'This Month'){
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}else if($fl == 'Last Month'){
					$start_date = date("Y-m",strtotime("-1 Months"));
					$start_date = $start_date.'-01';
					
					$end_date = date("Y-m",strtotime("-1 Months"));
					$end_date = $end_date.'-31';
				}else if($fl == 'Last 3 Months'){
					$start_date = date("Y-m",strtotime("-3 Months"));
					$start_date = $start_date.'-01';
					
					$end_date = date("Y-m",strtotime("-1 Months"));
					$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
				}else if($fl == 'Last 6 Months'){
					$start_date = date("Y-m",strtotime("-6 Months"));
					$start_date = $start_date.'-01';
					
					$end_date = date("Y-m",strtotime("-1 Months"));
					$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
				}else if($fl == 'This Year'){
					$start_date = date('Y').'-01-01';
					$end_date = date('Y').'-12-31';
				}else if($fl == 'Last 3 Years'){
					$last = date('Y') - 3;
					$first = date('Y') - 1;
					$start_date = $last.'-01-01';
					$end_date = $first.'-12-31';
				}
				//loop start
				foreach($dbf->fetchOrder('common',"type='payment type'","") as $valpay) {
								
					//Get Amount from Student fees Table with paid_date according to payment Type
					if($_REQUEST[centre_id] != ''){
						$cond = "payment_type='$valpay[id]' And centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$start_date' And '$end_date') And status='1'";
					}else{
						$cond = "payment_type='$valpay[id]' And (paid_date BETWEEN '$start_date' And '$end_date') And status='1'";
					}
					$amount = $dbf->getDataFromTable("student_fees","SUM(paid_amt)", $cond);
				  $html.='<tr>
					<td align="center" valign="middle" height="22">'.$i.'</td>
					<td align="left" valign="middle">'.$valpay["name"].'</td>
					<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$amount.' '.$res_currency["symbol"].'</span></td>
				  </tr>';
					  $i = $i + 1;  
				}
				$html.='</table></td>
			  </tr>
			</table></td>
		  </tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_sales_summary_report.pdf", 'D');
	exit;
?>