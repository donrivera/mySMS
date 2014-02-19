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

	$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-collapse:collapse;">
			<tr>
			  <th width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
			  <th width="22%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME.'</span></th>
			  <th width="24%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_MOBILENO.'</span></th>
			  <th width="27%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS.'</span></th>
			  <th width="13%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_LEVEL.'</span></th>
			  <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_STUDENT_AWAITING_TEXTD.'</span></th>
			 </tr>';
        $i = 1;
        $color="#ECECFF";
        
		if($_REQUEST[status]!='')
		{
			//$cond = "s.id = c.student_id And sf.student_id=c.student_id And sf.type='advance' And sf.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3' And s.centre_id='$_SESSION[centre_id]'";
			$query=$dbf->genericQuery("SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
										FROM student_moving c
										INNER JOIN student s ON s.id=c.student_id
										INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
										WHERE 
											c.status_id = '3' 
											AND s.centre_id='1' 
											AND sf.course_id = '$_REQUEST[status]'
											AND sf.type='advance' ORDER BY s.first_name");
		}
		else
		{
			//$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_SESSION[centre_id]' And sf.student_id=c.student_id And sf.type='advance'";
			$query=$dbf->genericQuery("SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
										FROM student_moving c
							            INNER JOIN student s ON s.id=c.student_id
							            INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
							            WHERE 
											c.status_id = '3' 
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
		  <td height="25" align="center" valign="middle" class="mycon">'.$i.'</td>
		  <td height="25" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val["id"]).'</span></td>
		  <td align="left" valign="middle">'.$val["student_mobile"].'</td>
		  <td align="left" valign="middle">'.$val["email"].'</td>
		  <td align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$course.'</span></td>
		  <td align="left" valign="middle">';
		  	if($val["date_time"] != "0000-00-00 00:00:00") {
				date('m/d/Y',strtotime($val["date_time"]));
			}
			$html.='</td>';
			  $i = $i + 1;
			  if($color=="#ECECFF"){
				  $color = "#FBFAFA";
			  }else{
				  $color="#ECECFF";
			  }
		  }
		$html.='</tr>
	</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_awaiting.pdf", 'D');
	exit;
?>	
