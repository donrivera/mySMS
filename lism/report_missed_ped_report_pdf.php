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
			  <th width="9%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.LISM_DUE_DATE.'</span></th>
			  <th width="21%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
			  <th width="17%" height="30" align="left" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_CENTRE_MANAGE_CENTRENAME.'</span></th>
			  <th width="12%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME.'</span></th>
			  <th width="15%" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></th>
			  <th width="11%" align="center" ><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_CD_GRAPHS_NOOFSTUDENT.'</span></th>
			  </tr>';
        $i = 1;
        $teacher_id=$_REQUEST['teacher_id'];
		$centre_id=$_REQUEST['centre_id'];
        $query=$dbf->genericQuery("SELECT DISTINCT(p.dated),p.teacher_id,p.group_id,sg.group_name,sg.course_id,c.name as centre_name,t.name as teacher_name
													FROM ped_units p
													INNER JOIN student_group sg ON sg.id=p.group_id
													INNER JOIN teacher t ON t.id=p.teacher_id
													INNER JOIN centre c ON c.id=sg.centre_id
													WHERE p.dated NOT IN(SELECT attend_date FROM ped_attendance)
													AND p.teacher_id='$teacher_id' AND sg.centre_id='$centre_id'");
		$num=count($query);
		foreach($query as $ped)
		{
			$tdt=$ped['dated'];
			$group_id=$ped['group_id'];
			$course_id=$ped['course_id'];
			$no_of_students=$dbf->getDataFromTable("student_group_dtls","COUNT(id)","parent_id='$group_id'");
			$course_name=$dbf->getDataFromTable("course","name","id='$course_id'");            
		$html.='<tr>
		  <td align="left" valign="middle" >&nbsp;'.$tdt.'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$ped['teacher_name'].'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$ped['centre_name'].'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$dbf->FullGroupInfo($group_id).'</td>
		  <td align="left" valign="middle" style="padding-left:1px;">'.$course_name.'</td>
		  <td align="center" valign="middle" style="padding-left:1px;">'.$no_of_students.'</td>';
		  }
		$html.='</tr>                   
	</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_missed_ped_report.pdf", 'D');
	exit;
?>