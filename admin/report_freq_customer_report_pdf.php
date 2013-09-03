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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
			<tr>
			<th width="2%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
			<th width="23%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME.'</span></th>
			<th width="16%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_FREQ_CUSTOMER_REPORT_EMAILADDRESS.'</span></th>
			<th width="20%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_FREQ_CUSTOMER_REPORT_PHONENO.'</span></th>
			<th width="26%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_FREQ_CUSTOMER_REPORT_COURSESATTENDED.'</span></th>
			</tr>';
			$i = 1;
			$color="#ECECFF";
			
			$centre_id = $_SESSION["centre_id"];
			$condition = '';
			//Concate the Condition
			//1.
			if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%')";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "s.student_id LIKE '$_REQUEST[stid]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "s.email LIKE '$_REQUEST[email]%'";
			}
			//End 1.
			
			//2.
			else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'";
			}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
			}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
			}
			//End 2.
			
			//3.
			else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
			}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
			}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
			}
			//End 3.
			
			//4.
			else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
			}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "s.id>'0'";
			}
			//End 4.
			
			$num = 0;			
			foreach($dbf->fetchOrder('student s', $condition ,"s.first_name") as $faq) {				
			
			$is_multi = $dbf->countRows("student_enroll", "student_id='$faq[id]'");
			
			foreach($dbf->fetchOrder('student_enroll',"student_id='$faq[id]'","") as $valc){							
				$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
				if($course == ''){
					$course  = $c[name];
				}else{
					$course  = $course.",".$c[name];
					$num++;
				}
			}
			if($is_multi > 1){
			$html.='<tr>
			<td height="25" align="center" valign="middle" >'.$i.'</td>
			<td height="25" align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$faq["first_name"].'&nbsp;'.$Arabic->en2ar($dbf->StudentName($faq["id"])).'</span></td>
			<td align="left" valign="middle">'.$faq["email"].'</td>
			<td align="left" valign="middle" >'.$faq["student_mobile"].'</td>
			<td align="left" valign="middle" >'.$course.'</td>';
				  $i = $i + 1;
			}
			$course = '';
			$html.='</tr>';
			}
		$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_vip_students.pdf", 'D');
	exit;
?>	
