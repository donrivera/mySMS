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
$valc = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");

$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
			<td align="center" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="25" colspan="6" align="left" valign="middle">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="10%" height="25" align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_DASHBOARD_STUDENT.'</span> :&nbsp;</td>
				<td width="35%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$valc["first_name"].' '.$Arabic->en2ar($dbf->StudentName($valc["id"])).'</span></td>
				<td width="4%" align="left" valign="middle">&nbsp;</td>
				<td width="16%" align="right" valign="middle" >&nbsp;</td>
				<td width="6%" align="center" valign="middle">&nbsp;</td>
				<td width="29%" align="left" valign="middle">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="5" colspan="6" align="left" valign="middle">&nbsp;</td>
				</tr>
			</table>';
			
			$num = $dbf->countRows("student_group_dtls", "student_id='$_REQUEST[student_id]'");
			foreach($dbf->fetchOrder('student_group m,student_group_dtls d', "m.id=d.parent_id And d.student_id='$_REQUEST[student_id]'" ,"m.id","m.start_date,m.end_date,m.id,d.*") as $valfee) {
				$enroll = $dbf->strRecordID("student_enroll", "*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
				$course = $dbf->strRecordID("course", "*", "id='$valfee[course_id]'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valfee[fee_id]'");
				
				$cr_tot = $course_fees + $enroll["other_amt"];
				$dr_tot = $enroll["discount"];
				
			$html.='<table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
			  <tr>
				<td width="14%" height="25" align="right" valign="middle" class="leftmenu">Group Name :</td>
				<td width="52%" align="left" valign="middle">'.$dbf->FullGroupInfo($valfee["parent_id"]).'</td>
				<td width="9%">&nbsp;</td>
				<td width="19%" align="center" valign="middle">&nbsp;</td>
				<td width="6%" align="left" valign="middle"></td>
			  </tr>
			  <tr>
				<td height="25" align="right" valign="middle">Course / Level :</td>
				<td align="left" valign="middle">&nbsp;<span id="result_box" lang="ar" xml:lang="ar">'.$course["name"].'</span></td>
				<td>&nbsp;</td>
				<td align="center" valign="middle"></td>
				<td align="left" valign="middle">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="right" valign="middle">Invoice No :</td>
				<td align="left" valign="middle">&nbsp;'.$dbf->GetBillNo($valfee["student_id"],$valfee["course_id"]).'</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="1" colspan="5" align="right" valign="middle" bgcolor="#CCCCCC"></td>
			  </tr>
			  <tr>
				<td align="right" valign="middle">&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="5" align="center" valign="middle" class="leftmenu">
				<table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
				  <tr>
					<td width="7%" height="25" align="center" valign="middle" bgcolor="#EEEEEE">Sl</td>
					<td width="45%" align="left" valign="middle" bgcolor="#EEEEEE">Particulars</td>
					<td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Date</td>
					<td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Amount</td>
					<td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Course Fees</td>
				  </tr>
				  <tr>
					<td height="22" align="center" valign="middle">1</td>
					<td align="left" valign="middle">&nbsp;Course Fee</td>
					<td align="left" valign="middle">&nbsp;</td>
					<td align="right" valign="middle">&nbsp;</td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course_fees.'&nbsp;'.$res_currency["symbol"].'</span></td>
				  </tr>
				  <tr>
					<td height="22" align="center" valign="middle">2</td>
					<td align="left" valign="middle">&nbsp;Discount</td>
					<td align="left" valign="middle">&nbsp;</td>
					<td align="right" valign="middle">';
					if($course_fees > 0){
					$discount = $dbf->getDiscountPercent($course_fees, $enroll["discount"]);
					if($discount > 0){
						$discount = number_format($discount);
					}
$html.='<span id="result_box" lang="ar" xml:lang="ar">'.$enroll["discount"].'&nbsp;['.$discount.'&nbsp;'.$res_currency["symbol"].'%]</span>';
					
					}
					$html.='</td>
					<td align="right" valign="middle">&nbsp;</td>
				  </tr>
				  <tr>
					<td height="22" align="center" valign="middle">3</td>
					<td align="left" valign="middle">&nbsp;Other Amount</td>
					<td align="left" valign="middle">&nbsp;</td>
					<td align="right" valign="middle">&nbsp;</td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$enroll["other_amt"].'&nbsp;'.$res_currency["symbol"].'</span></td>
				  </tr>';
				  
				  $k = 4;
					foreach($dbf->fetchOrder('student_fees', "status='1' And student_id='$valfee[student_id]' And course_id='$valfee[course_id]'" ,"id") as $feedtls){
					$dr_tot = $dr_tot + $feedtls["paid_amt"];
					
				  $html.='<tr>
					<td height="22" align="center" valign="middle">'.$k.'</td>
					<td align="left" valign="middle">&nbsp;<i>Ref.No</i>'.$feedtls["invoice_no"].'</td>
					<td align="center" valign="middle">';
					if($feedtls["paid_date"] != '0000-00-00') {
						date('d/M/Y',strtotime($feedtls["paid_date"]));
					}
					$html.='</td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$feedtls["paid_amt"].'&nbsp;'.$res_currency["symbol"].'</span></td>
					<td align="right" valign="middle">&nbsp;</td>
				  </tr>';
				  $k++; }
				  $html.='<tr>
					<td height="22" colspan="3" align="right" valign="middle" class="shop1">Total :</td>
					<td align="right" bgcolor="#EEEEEE"><span id="result_box" lang="ar" xml:lang="ar">'.$dr_tot.'&nbsp;'.$res_currency["symbol"].'</span></td>
					<td align="right" bgcolor="#EEEEEE"><span id="result_box" lang="ar" xml:lang="ar">'.$cr_tot.'&nbsp;'.$res_currency["symbol"].'</span></td>
				  </tr>';
				  if($dr_tot != $cr_tot){
				  $html.='<tr>
					<td height="22" colspan="3" align="right" valign="middle">';
					if($dr_tot < $cr_tot) {
						$html.='Balance';
					}else{
						$html.='Refund';
					}
					$html.=':</td>
					<td align="right" valign="middle">';
					$tot = $cr_tot - $dr_tot;
					if($dr_tot < $cr_tot){
						$tot;
					}
					$res_currency["symbol"];
					$html.='</td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">';
					
					if($dr_tot > $cr_tot){
						$my_tot = abs($dr_tot - $cr_tot);
						$my_tot;
					}
					$res_currency["symbol"];
					$html.='</span></td>
				  </tr>';
				  }
				  if($dr_tot != $cr_tot){
				  $html.='<tr>
					<td height="22" colspan="3" align="right" valign="middle" class="shop1">Total : </td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">';
					if($dr_tot < $cr_tot){
						$cr_tot;
					} else { $dr_tot; 
					}
					$res_currency["symbol"].'</span></td>
					<td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">';
					if($dr_tot > $cr_tot){
						$dr_tot;
					}else { 
						$cr_tot;
					}
					$res_currency["symbol"];
					$html.='</span></td>
				  </tr>';
				  }
				$html.='</table></td>
			  </tr>
			  <tr>
				<td align="right" valign="middle">&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
			  </tr>
			</table>
			<br>';
			}
			$html.='</td>
		  </tr>	  
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_ledger_report.pdf", 'D');
	exit;
?>