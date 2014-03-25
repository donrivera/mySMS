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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">
      <tr>
        <td width="3%" height="29" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</td>
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_S_MANAGE_STUDENTNAME.'</span></td>
        <td width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_S10_MOBNO.'</span></td>
        <td width="18%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_SEARCH_EMAIL.'</span></td>
        <td width="10%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_PRINT_AREA.'</span></td>
		<td width="40%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_PRINT_ADDRESS.'</span></td>
		<td width="10%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.CD_CENTRE_SCHEDULE_RANGEDATE_GROUP.'</span></td>
      </tr>';
		if($_REQUEST[area_code]!=''){
			$cond="s.area_code='$_REQUEST[area_code]'";
		}else{
			$cond="s.area_code=a.code";
		}
		
		$i = 1;
		$color="#ECECFF";
		
		//Get Number of Rows
		$num=$dbf->countRows('student s,area a',$cond,"");
		
		 //Loop start
		foreach($dbf->fetchOrder('student s,area a',$cond,"s.first_name ASC","s.id,s.first_name","s.id") as $val) {
		
		$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
		
		//Get Course Name
		$course = "";
		foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
		
			$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
			if($course==''){
				$course  = $c["name"];
			}else{
				$course  = $course.",".$c["name"];
			}
		}
		
		//Get Lead Information
		$lead = '';
		foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
		
			$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
			if($lead==''){
				$lead  = $c["name"];
			}else{
				$lead  = $lead.",".$c["name"];
			}
		}
		
		//Register date
		if($val["register_date"] == "0000-00-00"){
			$dt = '';
		}else{
			$dt = date('d-M-Y',strtotime($val_student["created_datetime"]));
		}
		
		//Last comment
		$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
		$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");
		$group=$dbf->genericQuery("SELECT sg.group_name,sg.start_date,sg.end_date,sg.group_start_time,sg.group_end_time
													FROM student_group sg
													INNER JOIN student_group_dtls sgd ON sgd.student_id='".$val_student[id]."'
													WHERE sg.status='Continue'
													ORDER BY sg.start_date DESC
													LIMIT 0,1
												");
		foreach($group as $g):
			$grp =  $g[group_name]."<BR/>";
			$grp .= $dbf->printClassTimeFormat($g[group_start_time],$g[group_end_time]);
			$grp .= "<BR/>".$g[start_date]."&nbsp;".$g[end_date];
		endforeach;
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val_student["id"]).'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["student_mobile"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["email"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->getDataFromTable("area","name","code='$val_student[area_code]'").'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["address"].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$grp.'</span></td>
  </tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_not_enrolled.pdf", 'D');
	exit;
?>