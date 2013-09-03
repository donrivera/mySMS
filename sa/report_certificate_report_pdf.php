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
			  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
			  <th width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME.'</span></th>
			  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_IDNUMBER.'</span></th>
			  <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME.'</span></th>
			  <th width="15%" align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_PERCENT.'</span></th>
			  <th width="27%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_CERTIFICATE_REPORT_CSV_DATA_GRSTARTEND.'</span></th>
			  </tr>';
				if($_REQUEST[cmbgroup]!=""){
					$cond="g.id=d.parent_id And s.id=d.student_id And g.id='$_REQUEST[cmbgroup]'"; //certificate_collect='0' And 
				}
									
				$i = 1;
				$color="#ECECFF";
				
				//Get Number of Rows
				if($cond!=''){
					
					$num=$dbf->countRows('student s,student_group g,student_group_dtls d', $cond);
					
					//Loop Start
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d', $cond,"s.first_name","s.*") as $val){
					
						//Get Student Name
						$ress = $dbf->strRecordID("student","*","id='$res[student_id]'");
						
					   //Get the Group Name
						$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
						
						//Get the Group Name
						$group = $dbf->strRecordID("common","*","id='$_REQUEST[cmbgroup]'");
						
						//Get Percentage from teacher_progress_certificate Table
						$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$res_group[course_id]' And student_id='$val[id]'");					
						$percentage = $res_per[final_percent];
			$html.='<tr>
			  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" >'.$i.'</td>
			  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.$val[first_name].' '.$Arabic->en2ar($dbf->StudentName($val["id"])).'</span></td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val[student_id].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$res_group[group_name].' '.$res_group["group_time"].'-'.$dbf->GetGroupTime($res_group["id"]).'</td>
			  <td align="center" valign="middle" bgcolor="#F8F9FB">'.$percentage.'%</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$res_group[start_date] .' / '. $res_group[end_date].'</td>';
			  $i = $i + 1;
			  }
		  }
		$html.='</tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_certificate_report_report.pdf", 'D');
	exit;
?>	
