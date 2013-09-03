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

$html = '<table width="1000" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">            
		  <tr>
			<td height="25" align="left" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_GROUP_MANAGE_NAMETEACHER.'</span></td>
			<td align="left" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_STUDENT_MANAGE_GROUPNM.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE.'</span></td>
			<td align="center" valign="middle" bgcolor="#DDDDDD"><span id="result_box" lang="ar" xml:lang="ar">'.TEACHER_MY_GROUPS_STATUS.'</span></td>
		  </tr>';
		  
		//Get Number of Rows
		$num=$dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","");
		 
		foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","id","") as $val){
		
		$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");		
		$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");		
		$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");		
		$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
		
	  $html.='<tr>
		<td width="388" height="25" align="left" valign="middle"  class="mycon"><?php echo $val_teacher[name];?></td>
		<td width="138" align="left" valign="middle">'.$val[group_name].' '.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
		<td width="143" align="center" valign="middle"  class="mycon">'.$val_no["COUNT(id)"].'</td>
		<td width="123" align="center" valign="middle"  class="mycon">'.date("m/d/Y",strtotime($val[start_date])).'</td>
		<td width="130" align="center" valign="middle"  class="mycon">'.date("m/d/Y",strtotime($val[end_date])).'</td>
		<td width="96" align="center" valign="middle"  class="mycon">'.$val[status].'</td>
	  </tr>';
      }
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_schedule_table.pdf", 'D');
	exit;
?>	