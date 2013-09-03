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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
		<tr>
		  <th width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
		  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_NEWS_MANAGE_DATE.'</span></th>
		  <th width="80%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.LIS_COUNT.'</span></th>
		</tr>';
		
        $i = 1;
        $num=$dbf->countRows('student_fees', $group);
        $days = $dbf->dateDiff($_REQUEST[start_date],$_REQUEST[end_date]);
        
        $status = $_REQUEST[status];
        
        //loop start
		$j = 0;
        for($k = 0; $k <= $days; $k++){
            if($k == 0){
                $st = $_REQUEST[start_date];
            }else{
                $st = date('Y-m-d',strtotime(date("Y-m-d", strtotime($st)) . "1 day"));
            }
            $no_stu = $dbf->countRows("ped_attendance","(shift1='$status' OR shift2='$status' || shift3='$status' OR shift4='$status' OR shift5='$status' || shift6='$status' OR shift7='$status' OR shift8='$status' || shift9='$status') And attend_date='$st'");
        	
			$j = $k + 1;
			
    $html.='<tr>
      <td align="center" valign="middle" class="mycon">'.$j.'</td>
      <td align="left" valign="middle" class="mycon">&nbsp;'.$st.'</td>
      <td align="left" valign="middle" class="mycon">&nbsp;'.$no_stu.'</td>
      </tr>';
        $i = $i + 1;
    }
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_eped_status_report.pdf", 'D');
	exit;
?>