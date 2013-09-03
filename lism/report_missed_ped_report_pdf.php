<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

	$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" style="border-collapse:collapse;">
			<tr>
			  <th width="3%" height="30" align="center" valign="middle">&nbsp;</th>
			  <th width="9%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.LISM_DUE_DATE.'</span></th>
			  <th width="21%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
			  <th width="17%" height="30" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_CENTRE_MANAGE_CENTRENAME.'</span></th>
			  <th width="12%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME.'</span></th>
			  <th width="15%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></th>
			  <th width="11%" align="center" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_CD_GRAPHS_NOOFSTUDENT.'</span></th>
			  <th width="12%" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.LISM_UPDATE_DATE.'</span></th>
			  </tr>';
        $i = 1;
        
        $num=$dbf->countRows('ped_daily_status_dtls',"centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'");
        
        //loop start
        foreach($dbf->fetchOrder('ped_daily_status_dtls',"centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'","id") as $val_leave) {
            $group = $dbf->strRecordID("student_group","*","id='$val_leave[group_id]'");
            $teacher = $dbf->strRecordID("teacher","*","id='$group[teacher_id]'");
            $centre = $dbf->strRecordID("centre","*","id='$group[centre_id]'");
            $course = $dbf->strRecordID("course","*","id='$group[course_id]'");
            $no_of_students = $dbf->countRows("student_group_dtls","parent_id='$group[id]'");
            $tdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($val_leave["dated"])) . "-2 day"));            
		$html.='<tr>
		  <td align="center" valign="middle" class="mycon">&nbsp;</td>
		  <td align="left" valign="middle" >&nbsp;'.$tdt.'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$teacher[name].'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$centre[name].'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$dbf->FullGroupInfo($group["id"]).'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$course[name].'</td>
		  <td align="center" valign="middle" style="padding-left:1px;">'.$no_of_students.'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$val_leave[dated].'</td>';
		  }
		$html.='</tr>                   
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_missed_ped_report.pdf", 'D');
	exit;
?>