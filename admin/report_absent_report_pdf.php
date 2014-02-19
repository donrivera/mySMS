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
		  <td width="2%" height="25" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</td>
		  <td width="12%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_S_MANAGE_STUDENTNAME.'</span></td>
		  <td width="12%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></td>
		  <td width="7%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_GROUP.'</span></td>
		  <td width="13%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME.'</span></td>
		  <td width="15%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_MOBILENO.'</span></td>
		  <td width="17%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS.'</span></td>
		  <td width="11%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_LASTATTAND.'</span></td>
		  <td colspan="2" align="center" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT.'</span></td>
		</tr>';
			$i = 1;
			//Get Number of Rows
			$num=$dbf->countRows('student', $condition);					
			//loop start
			foreach($dbf->fetchOrder('student', $condition ,"first_name") as $val) {
					
			//Get Course
			$g = $dbf->strRecordID("student_group_dtls","*","student_id='$val[id]'");
					
			$course = $dbf->strRecordID("course","*","id='$g[course_id]'");
					
			//Get Total Absent
			$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","group_id='$g[parent_id]' AND student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
			$countid = $res_max["COUNT(id)"];
					
			//Get Last Attendance
			$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","group_id='$g[parent_id]' AND student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
			$maxid = $res_max["MAX(id)"];
					
			$reslast = $dbf->strRecordID("ped_attendance","*","group_id='$g[parent_id]' AND id<'$maxid' AND student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					
			$resp = $dbf->strRecordID("ped_attendance","*","group_id='$g[parent_id]' AND student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					
			//Get Name Of Groups
			$res = $dbf->strRecordID("student","*","id='$resp[student_id]'");
			$res2 = $dbf->strRecordID("student_group","group_name,teacher_id,start_date","id='$g[parent_id]'");
					
			//Get Name Of Teacher
			$res3 = $dbf->strRecordID("teacher","*","id='$res2[teacher_id]'");
			
			if($countid>0) {
		$html.='<tr>
		  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">&nbsp;</td>
		  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val[id]).'</span></td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($course[name])?'N/A':$course[name]).'</span></td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.(empty($res2[group_name])?'N/A':$res2[group_name]).'</span></td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.$res3["name"].'</span></td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$res["student_mobile"].'</td>
		  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$res["email"].'</td>';
			if($reslast["unit"] > 0)
			{	#"Unit(".$reslast["unit"].") ,".
				$last_attend=$reslast["attend_date"];
				$last = date('d/m/Y',strtotime($last_attend));
			}else{$last= date('d/m/Y',strtotime($res2["start_date"]));}
		  $html.='<td align="left" valign="middle" bgcolor="#F8F9FB">'.$last.'</td>
		  <td width="11%" align="center" valign="middle" bgcolor="#F8F9FB">'.$countid.'</td>';
			  $i = $i + 1;
			  }}
		$html.='</tr>
	</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("student_absence_report.pdf", 'D');
	exit;
?>	
