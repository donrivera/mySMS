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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
                <tr>
                  <th width="11%" height="29" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_S_MANAGE_STUDENTNAME.'</span></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_S10_MOBNO.'</span></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_EMAIL.'</span></th>
                  <th width="7%" align="center" valign="middle" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE.'</span></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT.'</span></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_COURSEPAUSED.'</span></th>
                 <th align="center" valign="middle" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_STUDENT_ON_HOLD_CSV_DATA_DATEPAUSED.'</span></th>
				   <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_ON_HOLD_LASTCHAPTED.'</span></th>
                </tr>';
					$i = 1;
					$color="#ECECFF";
					
					$centre_id = $_SESSION["centre_id"];
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%'  And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'  And s.centre_id='$centre_id'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'  And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id>'0' And s.centre_id='$centre_id'";
					}
					//End 4.
					
					$condition = $condition." And s.id = m.student_id And m.status_id='6'";
					
					$num=$dbf->countRows('student s,student_moving m', $condition);
					foreach($dbf->fetchOrder('student s,student_moving m', $condition , "", "m.*") as $val1) {
						
						$val = $dbf->strRecordID("student","*","id='$val1[student_id]'");
						if($val[register_date] == '0000-00-00'){
							$dt = '';
						}else{
							$dt = date('d-M-Y',strtotime($val[register_date]));
						}
						
						//get current course of the student
						$grp = $dbf->strRecordID("student_group g,student_group_dtls d","g.*","g.id=d.parent_id And g.status<>'Completed' And d.student_id='$val1[student_id]'");
						
						//get course name
						$course = $dbf->strRecordID("course","*","id='$grp[course_id]'");
                $html.='<tr>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" ><span id="result_box" lang="ar" xml:lang="ar">'.$val["first_name"].' '.$Arabic->en2ar($dbf->StudentName($val["id"])).'</span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["student_mobile"].'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["email"].'</td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" >'.$dt.'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$val["student_comment"].'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$course["name"].'</td>
                  <td width="11%" align="left" valign="middle" bgcolor="#F8F9FB" >&nbsp;</td>
				    <td align="left" valign="middle" bgcolor="#F8F9FB" >&nbsp;</td>';
					  $i = $i + 1;
					  }
                $html.='</tr>
            </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_on_hold.pdf", 'D');
	exit;
?>	