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
		<th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</th>
		<th width="15%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE.'</span></th>
		<th width="14%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_GROUPSAED.'</span></th>
		<th width="21%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALU.'</span></th>
		<th width="19%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_CONTRACTUNITS.'</span></th>
		<th width="28%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALH.'</span></th>
		</tr>';
		$centre_id = $_SESSION["centre_id"];
		if($_REQUEST[teacher] != 0 && $_REQUEST[start_date]=='' && $_REQUEST[end_date] == ''){
			$cond = "teacher_id = '$_REQUEST[teacher]' And centre_id='$centre_id'";
		}else if($_REQUEST[teacher] != 0 && $_REQUEST[start_date]!='' && $_REQUEST[end_date] != ''){
			$cond = "teacher_id='$_REQUEST[teacher]' And centre_id='$centre_id' And (start_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
		}else{
			$cond="centre_id='$centre_id'";
		}
		
		$i = 1;
		$color="#ECECFF";
		
		$num=$dbf->countRows('student_group',$cond);
		
		foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
		
		$res = $dbf->strRecordID("common","*","id='$val[group_id]'");
		$res_total_unit = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
							
		$unit = $dbf->strRecordID("ped_units","COUNT(id)","teacher_id='$val[teacher_id]' And group_id='$val[group_id]' And course_id='$val[course_id]'");
		
		$unit1 = $dbf->strRecordID("group_size","*","group_id='$val[group_id]'");
		
		$over = $unit["COUNT(id)"] - $unit1["units"];
		
		if($over < 0){
			$over = 'No overtime yet...';
		}
		$html.='<tr>
		  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["group_name"].' '.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.date("d-M-Y",strtotime($val[start_date]))." To ".date('d-M-Y',strtotime($val[end_date])).'</td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$unit["COUNT(id)"].'</td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$unit1["units"].'</td>
		  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB">'.$over.'</td>';
			  $i = $i + 1;
			  }
		$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_overtime.pdf", 'D');
	exit;
?>	