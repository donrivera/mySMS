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
        <td width="13%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Group Name</span></td>
		<td width="13%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Center</span></td>
      </tr>';
	$query=$dbf->genericQuery("	SELECT s.id,sg.group_name,ctr.name as centre_name
								FROM student s
								INNER JOIN student_type stype ON stype.student_id = s.id
								INNER JOIN common c ON c.id = stype.type_id
								INNER JOIN student_group_dtls sgdtls ON sgdtls.student_id=s.id
								INNER JOIN student_group sg ON sg.id=sgdtls.parent_id
								INNER JOIN centre ctr ON ctr.id=s.centre_id
								WHERE c.id ='$_REQUEST[teacher]'
											");
					/*
						INNER JOIN student_group_dtls sgdtls ON sgdtls.student_id=s.id
						INNER JOIN student_group sg ON sg.id=sgdtls.parent_id
					*/
					if($_REQUEST[teacher]!=''){
						//$cond = "s.id=c.student_id AND c.status_id='$_REQUEST[teacher]'";
						$cond ="stype.student_id = st.id AND c.id = stype.type_id AND c.id = '$_REQUEST[teacher]' ";
					}else{
						//$cond = "s.id=c.student_id";
						$cond="stype.student_id = st.id AND c.id = stype.type_id";
					}
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					//$num=$dbf->countRows('student s,student_moving c',$cond,"");
					$num=count($query);//$dbf->countRows('student s,student_type stype,common c',$cond,"");
					 //Loop start
					//foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.id DESC","s.id","s.id") as $val) {
					  //foreach($dbf->fetchOrder('student s,student_type stype,common c',$cond,"s.id DESC","s.id","s.id") as $val) {
					foreach($query as $val){
					$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
					
					//Get Course Name
					$course = "";
					foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
					
						$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
						if($course==''){
							$course  = $c[name];
						}else{
							$course  = $course.",".$c[name];
						}
					}
					
					//Get Lead Information
					$lead = '';
					foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
					
						$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
						if($lead==''){
							$lead  = $c[name];
						}else{
							$lead  = $lead.",".$c[name];
						}
					}
					
					//Register date
					if($val[register_date] == "0000-00-00"){
						$dt = '';
					}else{
						$dt = date('d-M-Y',strtotime($val_student[created_datetime]));
					}
					
					//Last comment
					$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
					$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");	
		
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student[first_name].'&nbsp;'.$val_student[father_name].'&nbsp;'.$val_student[family_name].'&nbsp;('.$val_student[first_name1].'&nbsp;'.$val_student[father_name1].'&nbsp;'.$val_student[grandfather_name1].'&nbsp;'.$val_student[family_name1].')</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["student_mobile"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val_student["email"].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[group_name].'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[centre_name].'</span></td>
	 
  </tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_statuses.pdf", 'D');
	exit;
?>