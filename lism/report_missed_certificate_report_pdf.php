<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

	$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
				<tr>
				  <th width="21%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
				  <th width="17%" height="30" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_CENTRE_MANAGE_CENTRENAME.'</span></th>
				  <th width="12%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME.'</span></th>
				  <th width="15%" align="left" bgcolor="#CCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME.'</span></th>
				  <th width="11%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_CD_GRAPHS_NOOFSTUDENT.'</span></th>
				</tr>';
	$i = 1;
	$teacher_id=$_REQUEST['teacher_id'];
	$centre_id=$_REQUEST['centre_id'];
	$query=$dbf->genericQuery("SELECT sg.id , CEIL( sg.units / MAX( p.units ) *100 ) AS percentage
								FROM student_group sg
								INNER JOIN ped_units p ON p.group_id = sg.id
								WHERE sg.teacher_id =  '$teacher_id'
								AND centre_id =  '$centre_id'
								AND p.dated !=  ''");
	//echo var_dump($query);
	foreach($query as $q)
	{
		$percent=$q['percentage'];
		$group_id=$q['id'];
		$progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id'"); 
		if($percent>=50 && empty($progress))
		{
			$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
										FROM student_group sg
										INNER JOIN course c ON c.id = sg.course_id
										INNER JOIN centre ctr ON ctr.id=sg.centre_id
										INNER JOIN teacher t ON t.id = sg.teacher_id
										INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
										WHERE sg.id ='$group_id'");
			$num=count($data);
		}
		else
		{
			$check_progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id' AND progress_report_date=''"); 
			if(!empty($check_proress))
			{
				$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
											FROM student_group sg
											INNER JOIN course c ON c.id = sg.course_id
											INNER JOIN centre ctr ON ctr.id=sg.centre_id
											INNER JOIN teacher t ON t.id = sg.teacher_id
											INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
											WHERE sg.id ='$group_id'");
				$num=count($data);
			}
			else{$num=0;}
		}
		foreach($data as $row)
		{
			$html.='<tr>
						<td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$row[teacher_name].'</td>
						<td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$row[centre_name].'</td>
						<td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$dbf->FullGroupInfo($group_id).'</td>
						<td align="left" valign="middle" class="mycon" style="padding-left:5px;">'.$row[course_name].'</td>
						<td align="center" valign="middle" class="mycon" style="padding-left:5px;">'.$row[total].'</td>';
					  $i = $i + 1;
		}
	}
				$html.='</tr>                   
			</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_missed_certificate_report.pdf", 'D');
	exit;
?>