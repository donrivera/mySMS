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
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_GROUP_GROUP.'</span></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VACATION_CENTRE_MANAGE_STARTDATE.'</span>/<span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VACATION_CENTRE_MANAGE_ENDDATE.'</span></th>
                  <th width="21%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALU.'</span></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_CONTRACTUNITS.'</span></th>
                   <th width="28%" height="25" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALH.'</span></th>
                  </tr>';					
					if($_REQUEST[teacher]!=0){
					 $cond="teacher_id='$_REQUEST[teacher]'";
					}else{
					$cond="";
					}					
					$i = 1;
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
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="padding-left:1px;">'.$val["group_name"].'&nbsp;'.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="padding-left:1px;">'.date('d-M-Y',strtotime($val["start_date"])).' To '.date('d-M-Y',strtotime($val[end_date])).'</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="padding-left:1px;">'.$unit["COUNT(id)"].'</span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" style="padding-left:1px;">'.$unit1["units"].'</td>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;">'.$over.'</td>';
					  $i = $i + 1;
					  }
                $html.='</tr>
            </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_overtime_report.pdf", 'D');
	exit;

$filename = "report_teacher_overtime_report.pdf";

$filepath="pdf_reports/".$filename;
$htmlFile = $baseUrl."report_teacher_overtime_report_pdf_data.php?teacher=$_REQUEST[teacher]";
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
