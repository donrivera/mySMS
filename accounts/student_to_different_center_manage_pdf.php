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

$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
		<tr>
		  <th width="8%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_STUDENT_TRANSFER_DATE.'</span></th>
		  <th width="11%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_STUDENT_CENTER_FROM.'</span></th>
		  <th width="10%" height="30" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_STUDENT_CENTER_FROMGROUP.'</span></th>
		  <th width="8%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_STUDENT_CENTER_TO.'</span></th>
		  <th width="7%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_STUDENT_CENTER_TOGROUP.'</span></th>
		  <th width="9%" align="left" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">Status</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">Students</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS.'</span></th>
		  <th width="9%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_WEEK_MANAGE_STATUS.'</span></th>
		 </tr>';
			$i = 1;
			$color = "#ECECFF";
			$num=$dbf->countRows('transfer_different_centre',"centre_id='$_REQUEST[centre_id]'","");
					
			foreach($dbf->fetchOrder('transfer_different_centre',"centre_id='$_REQUEST[centre_id]'","id DESC ","*") as $transfer)
			{
		
				$status = $dbf->getDataFromTable("student_status","name","id='$transfer[from_status]'");
				$centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
				$centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
				$group_fr=$dbf->getDataFromTable("student_group","name","id='$transfer[from_id]'");
				$group_to=$dbf->getDataFromTable("student_group","name","id='$transfer[to_id]'");
		$html.='<tr>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$transfer["dated"].'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$centre_from.'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($group_fr)?"Group Removed":$group_fr).'</span></td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$centre_to.'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($group_to)?"Group Removed":$group_to).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$status.'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($transfer[from_student]).'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$transfer[comment].'</span></td>
		  <td align="right" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$transfer[status].'</span></td>';
		  
			  $i = $i + 1;
		  }
		$html.='</tr>               
	</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_center_to_center_report.pdf", 'D');
	exit;
?>