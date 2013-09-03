<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

	$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA"  style="border-collapse:collapse;">
			<thead>
			<tr >
			  <th width="3%" align="left" valign="middle" bgcolor="#CDCDCD">&nbsp;</th>
			  <th width="23%" height="25" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_CURRENTGROUP.'</span></th>
			  <th width="18%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE.'</span></th>
			  <th width="19%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE.'</span></th>
			  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_NUMBEROFSTUD.'</span></th>
			  <th width="15%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_CLASSROOM.'</span></th>
			  </tr>
			</thead>';		
			if($_REQUEST[teacher]!=''){
				$cond = "teacher_id='$_REQUEST[teacher]'";
			}else{
				$cond = "";
			}
			$i = 1;
			$num1 = $dbf->countRows('student_group',$cond);
			if($num1!=0){
				foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
				$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
				$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
				$std = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$val[id]'");
				$room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
			$html.='<tr>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
			  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB">'.$val["group_name"].'&nbsp;'.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["start_date"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["end_date"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$std["COUNT(student_id)"].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$room["name"].'</td>';
			  $i = $i + 1;
				}
			  }			  
			$html.='</tr>			
		</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_teacher_schedule.pdf", 'D');
	exit;
?>	
