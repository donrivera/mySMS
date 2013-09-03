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
                  <th width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
                  <th width="23%" align="left" valign="middle" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_GROUP_MANAGE_GROUPNAME.'</span></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_PED_TNAME.'</span></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_PED_STARTDT.'</span></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE.'</span></th>
                  <th width="23%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
                  </tr>';
					$i = 1;
					if($_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
					 $cond="status<>'Completed' And (start_date <= '$_REQUEST[end_date]' And end_date >= '$_REQUEST[start_date]')";
					}
					else
					{
					$cond="status<>'Completed'";
					}
					$num=$dbf->countRows('student_group',$cond);
					
					foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
						
					$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
					$course = $dbf->strRecordID("course","*","id='$val[course_id]'");
                $html.='<tr>
                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB">'.$val[group_name].' '.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$res[name].'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val[start_date].'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val[end_date].'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$course[name].'</td>';
					  $i = $i + 1;
					  }
                $html.='</tr>
            </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_group_to_finish.pdf", 'D');
	exit;
?>	
