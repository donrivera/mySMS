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
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTNAME.'</span></td>
        <td width="14%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID.'</span></td>
        <td width="18%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO.'</span></td>
        <td width="10%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Address</span></td>
		<td width="40%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Class Time</span></td>
		<td width="10%"  align="center" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Schedule</span></td>
      </tr>';
		$i = 1;
		$color="#ECECFF";
		$sql=$dbf->genericQuery("	SELECT s.id,s.student_id,s.student_mobile,s.address,sg.group_start_time,sg.group_end_time,sg.start_date,sg.end_date
									FROM student s 
									INNER JOIN student_group_dtls sgd ON s.id=sgd.student_id
									INNER JOIN student_group sg ON sgd.parent_id=sg.id
									INNER JOIN area a ON s.area_code=a.code
									WHERE a.code='$_REQUEST[area_code]' AND sg.centre_id='$_REQUEST[centre_id]'");
		$i = 1;
		$color = "#ECECFF";
		$num=count($sql);
		foreach($sql as $val)
		{					 
	$html.='<tr bgcolor="'.$color.'">
	  <td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($val["id"]).'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.(empty($val['student_id'])?'':$val['student_id']).'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val[student_mobile].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val['address'].'</td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printClassTimeFormat($val['group_start_time'],$val['group_end_time']).'</span></td>
	  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$val['start_date']."&nbsp;TO&nbsp;".$val['end_date'].'</span></td>
  </tr>';
	  $i = $i + 1;
	  }
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_transport.pdf", 'D');
	exit;
?>