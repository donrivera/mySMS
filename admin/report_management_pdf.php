<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

$centre_id = $_REQUEST["centre_id"];

	$html = '<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="12%" height="30" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_GROUP_SIZE_CENTRE.'</span>: &nbsp;</td>
				<td width="22%" align="left" valign="middle">';
					foreach($dbf->fetchOrder('centre',"","name") as $valc) {
					if($valc["id"]==$_REQUEST["centre_id"]){
						echo $valc[name];
					}
					}
                $html.='</td>
				<td width="12%" align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM.'</span>: &nbsp;</td>
				<td width="20%" align="left" valign="middle">'.$_REQUEST[start_date].'</td>
				<td width="6%" align="right" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO.'</span> : &nbsp;</td>
				<td width="18%" align="left" valign="middle">'.$_REQUEST[end_date].'</td>
				<td width="9%" align="right" valign="middle"></td>
				</tr>
			</table>
			<table width="600" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="67%" height="25" align="left" valign="middle">&nbsp;Date :</td>
                    <td width="27%" align="center" valign="middle">'.$_REQUEST[start_date].'&nbsp;/&nbsp;'.$_REQUEST[end_date].'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Count of interviews by appointments :&nbsp;</td>';
					
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$appoint.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Count of interviews conducted :&nbsp;</td>';
					
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","status='1' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
										
                    $html.='<td align="center" valign="middle" class="pedtext">'.$appoint.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of new enrollments :&nbsp;</td>';
					
					//loop start
					$enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re == 1){
							$enroll = $enroll + 1;
						}
					}
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$enroll.'</td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of re-enrollments :&nbsp;</td>';
					
					//loop start
					$re_enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re > 1){
							$re_enroll = $re_enroll + 1;
						}
					}
					$total_enroll = $enroll+$re_enroll;
                    $html.='<td align="center" valign="middle" class="pedtext">'.$re_enroll.'</td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="67%" height="25" align="left" valign="middle" class="lable1">&nbsp;Sum of number of new and re-enrollments :&nbsp;</td>
                    <td width="27%" align="center" valign="middle" class="pedtext">'.$total_enroll.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of certificates issued :&nbsp;</td>';
					
					$no_of_certificat = 0;
					foreach($dbf->fetchOrder('teacher_progress_certificate', "(print_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_certificat = $no_of_certificat + 1;
						}
					}					
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$no_of_certificat.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of progress reports issued :&nbsp;</td>';
					
					$no_of_progress = 0;
					foreach($dbf->fetchOrder('teacher_progress', "(progress_report_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_progress = $no_of_progress + 1;
						}
					}					
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$no_of_progress.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of students absent :&nbsp;</td>';
					
					$no_of_attand = 0;
					foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_attand = $no_of_attand + 1;
						}
					}
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$no_of_attand.'</td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of students SMS (automatically by the system) :&nbsp;</td>';
					
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='Yes' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$sms.'</td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="67%" height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of students cancelled :&nbsp;</td>';
					
					$cancel = $dbf->strRecordID("student_cancel","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$cancel = $cancel["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$cancel.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of students transferred :&nbsp;</td>
                    <td align="center" valign="middle" class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of new groups started &nbsp;</td>';
					
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Continue' And (created_datetime BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$group.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of groups completed :&nbsp;</td>';
					
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Completed' And (completed_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$group.'</td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="lable1">&nbsp;Sum of total sales :&nbsp;</td>
                    <td align="center" valign="top" style="padding-top:2px; padding-bottom:2px;">
                    <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">';
					
					$total = 0;
					foreach($dbf->fetchOrder('common',"type='payment type'","id DESC") as $valpay) {						
						
						# it is sum amount from fees structures 
						$amts = $dbf->strRecordID("student_fees","SUM(paid_amt)","payment_type='$valpay[id]' And centre_id='$centre_id' And (paid_date BETWEEN '$start_date' And '$end_date')");
						$amts = $amts["SUM(paid_amt)"];
						
						$total = $total + $amts;
						
						# it is sum amount from student enrolled table (first payment or initial payment)
						$amts_ob = $dbf->strRecordID("student_enroll","SUM(ob_amt)","payment_type='$valpay[id]' And centre_id='$centre_id' And (payment_date BETWEEN '$start_date' And '$end_date')");
						$amts = $amts_ob["SUM(ob_amt)"];
						
						$total = $total + $amts;
						
                      $html.='<tr class="mymenutext">
                        <td width="51%" align="center" valign="middle">'.$valpay["name"].'</td>
                        <td width="49%" align="center" valign="middle" class="pedtext">'.$amts.'&nbsp;'.$res_currency[symbol].'</td>
                      </tr>';
                      }
                      $html.='<tr class="mymenutext">
                        <td height="20" colspan="2" align="center" valign="middle">Total :&nbsp; '.$total.'&nbsp;'.$res_currency["symbol"].'</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="67%" height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of teaching units :&nbsp;</td>
                    <td width="27%" align="center" valign="middle" class="pedtext">';
					
					$unit = 0;
					foreach($dbf->fetchOrder('student_group g,ped_attendance a',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')","","a.unit","a.unit") as $valpay) {
						$unit = $unit + 1;
					}
					$unit;
					
					$html.='</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of SMS sent :&nbsp;</td>';
					
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$sms.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of emails sent :&nbsp;</td>';
					
					$email = $dbf->strRecordID("email_history","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$email = $email["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$email.'</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1">&nbsp;Total number of ARF logged :&nbsp;</td>';
					
					$arf = $dbf->strRecordID("arf","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$arf = $arf["COUNT(id)"];
					
                    $html.='<td align="center" valign="middle" class="pedtext">'.$arf.'</td>
                  </tr>
                </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_management.pdf", 'D');
	exit;
?>	