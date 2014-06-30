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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">
      <tr>
        <td width="3%" height="29" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</td>
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_FROMDT.'</span></td>
        <td width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_TODT.'</span></td>
        <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_REASON.'</span></td>
		<td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_ATTACH.'</span></td>
        <td width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MANAGE_SICKLEAVE_STATUS.'</span></td>
      </tr>';
		$teacher_id = $_SESSION[uid];
		$start_date=($_REQUEST[start_date]!='')?$_REQUEST[start_date]:$dbf->MonthFirstDay(date('m'),date('Y'));
		$end_date=($_REQUEST[end_date]!='')?$_REQUEST[end_date]:$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
		$i = 1;
		$color = "#ECECFF";
		$cond = '';
		if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '')
		{
			$cond = "(from_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
		}else{$cond = "(from_date BETWEEN '$start_date' And '$end_date')";}
		$num=$dbf->countRows('sick_leave', $cond);
		foreach($dbf->fetchOrder('sick_leave',"teacher_id='$teacher_id' And ".$cond,"id") as $val) 
		{
			if($val[sick_status]== '0'){$status='Pending';}
			elseif($val[sick_status]== '1'){$status='Approved';}
			else{$status='Rejected';}
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[from_date].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[to_date].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[sick_reason].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[sick_attachment].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$status.'</td>
	</tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("sick_leave.pdf", 'D');
	exit;
?>