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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" style="border-collapse:collapse;">
			<tr>
			  <th width="6%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
			  <th width="55%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME.'</span></th>
			  <th width="19%" align="center" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_CAPACITY_TOTALTEACH.'</span></th>
			  <th width="18%" align="center" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_CAPACITY_TOTALCONTRA.'</span></th>
			  </tr>';
				$i = 1;
				$color="#ECECFF";
				$centre_id = $_SESSION["centre_id"];
				$num=$dbf->countRows('user u',"u.user_type='Teacher'");
				foreach($dbf->fetchOrder('user u',"u.user_type='Teacher'","","u.*") as $val) {
					
					# Get Teacher details
					$res_teacher = $dbf->strRecordID("teacher", "*", "id='$val[uid]'");
					
					//Get the total units from the E-PED unit table of a particular teacher
					$res_unit = $dbf->strRecordID("ped_attendance","COUNT(unit)","teacher_id='$val[uid]' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
			$html.='<tr>
			  <td height="25" align="center" valign="middle">'.$i.'</td>
			  <td height="25" align="left" valign="middle">'.$res_teacher["name"].'</td>
			  <td align="center" valign="middle">'.$res_unit["COUNT(unit)"].'</td>
			  <td align="center" valign="middle">'.$res_teacher["unit"].'</td>';
			  $i = $i + 1;		  
			  }
			$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_capacity.pdf", 'D');
	exit;

$filename = "report_teacher_capacity.pdf";

$filepath="pdf_reports/".$filename;
$htmlFile = $baseUrl."report_teacher_capacity_pdf_data.php?centre_id=$_SESSION[centre_id]";
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
