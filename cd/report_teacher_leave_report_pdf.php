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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
			<tr>
			  <th width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</th>
			  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME.'</span></th>
			  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE.'</span></th>
			  <th width="30%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_ENDDATE.'</span></th>
			  <th width="32%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_GROUPAFFECTED.'</span></th>
			  </tr>';				
				if($_REQUEST[teacher]!='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
				{
				 $cond="teacher_id='$_REQUEST[teacher]' And (frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
				}
				else if($_REQUEST[teacher]=='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
				{
				 $cond="(frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
				}
				else if($_REQUEST[teacher]!='' && $_REQUEST[start_date]=='' && $_REQUEST[end_date]=='')
				{
				 $cond="teacher_id='$_REQUEST[teacher]'";
				}else{
				 $cond="";
				}

				$i = 1;
				$num=$dbf->countRows('teacher_vacation',$cond);				
				foreach($dbf->fetchOrder('teacher_vacation',$cond,"id DESC") as $val) {				
				$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
			$html.='<tr>
			  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
			  <td align="left" valign="middle">'.$res[name].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val[frm].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val[tto].'</td>';
				if($val[group_affect]==0){
					$affect='NO';
				}else{
					$affect='YES';
				} 
					$html.='<td align="left" valign="middle">'.$affect.'</td>';
					$i = $i + 1;
				}
			$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_leave_report.pdf", 'D');
	exit;
?>