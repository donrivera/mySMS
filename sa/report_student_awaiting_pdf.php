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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" >
		  <tr >
			  <td width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" ></td>
			  <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_VIEW_COMMENTS_MANAGE_STUDENT.'</span></td>
			  <td width="16%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_MOBILENUMBER.'</span></td>
			  <td width="25%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_TEACHER1_MANAGE_EMAIL.'</span></td>
			  <td width="9%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></td>
			  <td width="24%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_REPORT_STUDENT_AWAITING_CSV_DATA_DATEWAIT.'</span></td>
		  </tr>';
		if($_REQUEST[status]!='')
		{
			//$cond = "s.id = c.student_id And sf.student_id=c.student_id And sf.type='advance' And sf.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3' And s.centre_id='$_SESSION[centre_id]'";
			$query=$dbf->genericQuery("	SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
										FROM student_moving c
										INNER JOIN student s ON s.id=c.student_id
										INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
										WHERE 
											c.status_id = '3' 
											AND s.centre_id='1' 
											AND sf.course_id = '$_REQUEST[status]'
											AND s.centre_id='$_SESSION[centre_id]'
											AND sf.type='advance' ORDER BY s.first_name");
		}
		else
		{
			//$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_SESSION[centre_id]' And sf.student_id=c.student_id And sf.type='advance'";
			$query=$dbf->genericQuery("	SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
										FROM student_moving c
							            INNER JOIN student s ON s.id=c.student_id
							            INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
							            WHERE 
											c.status_id = '3' 
											AND s.centre_id='$_SESSION[centre_id]'
											AND sf.type='advance' ORDER BY s.first_name");
		}
		$i = 1;
		$color="#ECECFF";
		$num=count($query);#$dbf->countRows('student s,student_moving c',$cond);
		#$query=$dbf->fetchOrder('student s,student_moving c,student_fees sf',$cond,"s.first_name","s.*,c.date_time,sf.course_id")
		//Loop start
		foreach($query as $val){
			$course = $dbf->getDataFromTable("course", "name", "id='$val[course_id]'");
			$html.='<tr>
			  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" >'.$i.'</td>
			  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val["id"]).'</span></td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB"  >'.$val[student_mobile].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB" >'.$val[email].'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB"  >'.$course.'</td>
			  <td align="left" valign="middle" bgcolor="#F8F9FB"  >';
			  if($val[date_time] != '0000-00-00 00:00:00') { date('m/d/Y',strtotime($val[date_time]));}
			  $html.='</td>
		  </tr>';
			   $i = $i + 1;
			   }
		$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_awaiting.pdf", 'D');
	exit;
?>	
