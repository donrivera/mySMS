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

$html = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
		  <tr>
			<td width="66" height="25" align="left" valign="middle">&nbsp;</td>
			<td width="352" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_TXT1.'</span> :&nbsp;';
			
			if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){				
				$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");			
				number_format($val_student["SUM(gs.units)"],0);
			}
			$html.='</td>
			<td width="103" align="left" valign="middle">&nbsp;</td>
			<td width="77" align="left" valign="middle">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="25" align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_TXT2.'</span>:';
			
			 if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
				 
				  $val_student1 = $dbf->strRecordID("student_group s,group_size gs","*","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
				  
				  $val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
		  			number_format($val_no_course['COUNT(course_id)'],0);
			}
			$html.='</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="25" align="center" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_TXT3.'</span></td>
			<td align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_STARTDAT.'</span></td>
			<td align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_ENDDAT.'</span></td>
		  </tr>';
			if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
				$cond="status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))";
			}else{
				$cond="";
			}			
			//Get Number of Rows
			$num=$dbf->countRows('student_group',$cond);			
			if($cond != ""){			
				//Loop start
				foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
				
				//Get course name
				$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
		  $html.='<tr>
			<td height="25" align="center" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">'.$val_course["name"].'</td>
			<td align="left" valign="middle">'.$val["start_date"].'</td>
			<td align="left" valign="middle">'.$val["end_date"].'</td>
		  </tr>';
			}}
		  $html.='<tr>
			<td height="25" align="center" valign="middle">&nbsp;</td>
			<td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STATISTIC_TXT5.'</span>:&nbsp;';
				if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
				number_format($val_student_no['COUNT(d.student_id)'],0);
				}
			$html.='</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">&nbsp;</td>
		  </tr>
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_statistic.pdf", 'D');
	exit;
?>	
