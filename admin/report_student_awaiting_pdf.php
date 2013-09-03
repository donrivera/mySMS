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
        
        if($_REQUEST["status"]!=''){
            $cond="s.id = c.student_id And c.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3'";
        }else{
            $cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3'";
        }                            
        //Get Number of Rows
        if($cond != ''){
            $num=$dbf->countRows('student s,student_moving c',$cond);
        }        
        //Loop start
        foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.first_name","s.*,c.date_time") as $val){
            $course = $dbf->getDataFromTable("course", "name", "id='$_REQUEST[status]'");                
		$html.='<tr>
		  <td height="25" align="center" valign="middle" class="mycon">'.$i.'</td>
		  <td height="25" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$val["first_name"].' '.$Arabic->en2ar($dbf->StudentName($val["id"])).'</span></td>
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

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_awaiting.pdf", 'D');
	exit;
?>	
