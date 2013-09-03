<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" style="border-collapse:collapse;">
			<tr>
			  <th width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</th>
			  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE.'</span></th>
			  <th width="30%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_ENDDATE.'</span></th>
			  <th width="32%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_GROUPAFFECTED.'</span></th>
			  </tr>';					
				if($_REQUEST[teacher]!='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
					$cond="teacher_id='$_REQUEST[teacher]' And (frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
				}else if($_REQUEST[teacher]=='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
					$cond="(frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
				}else if($_REQUEST[teacher]!='' && $_REQUEST[start_date]=='' && $_REQUEST[end_date]==''){
					$cond="teacher_id='$_REQUEST[teacher]'";
				}else{
					$cond="";
				}
				$i = 1;
				$num=$dbf->countRows('teacher_vacation',$cond);					
				foreach($dbf->fetchOrder('teacher_vacation',$cond,"id DESC") as $val) {					
				$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
			$html.='<tr>
			  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">'.$i.'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">'.$val["frm"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;>'.$val["tto"].'</td>';
			  if($val["group_affect"]==0){
				$affect='NO';
			  }else{
				$affect='YES';
			  }
			  $html.='<td align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">'.$affect.'</td>';
				  $i = $i + 1;
				  }
			$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_leave_report.pdf", 'D');
	exit;

$filename = "report_teacher_leave_report.pdf";

$filepath="pdf_reports/".$filename;
$htmlFile = $baseUrl."report_teacher_leave_report_pdf_data.php?teacher=$_REQUEST[teacher]&start_date=$_REQUEST[start_date]&end_date=$_REQUEST[end_date]";
//$htmlFile =$baseUrl."report_invoice_on_arrival.php?quote_id=$_REQUEST[qoute_id]&id=$_REQUEST[pay_id]"; 
$buffer = file_get_contents($htmlFile); 
$pdf = new HTML2FPDF('L', 'mm', 'A3');
$pdf->AddPage(); 
$pdf->UseCSS(); 
$pdf->WriteHTML($buffer); 
$pdf->Output($filepath, 'F');

$file = $filepath;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Type: application/force-download");
    header('Content-Disposition: attachment; filename=' . urlencode(basename($file)));
    // header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

?>	
