<?php
ob_start();
session_start();

include("../mpdf/mpdf.php");
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

ini_set('memory_limit', '-1');

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
		<thead>
		<tr class="logintext">
		  <th width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
		  <th width="23%" align="left" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.RECEPTION_GROUP_MANAGE_GROUPNAME.'</span></th>
		  <th width="16%" align="left" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME.'</span></th>
		  <th width="20%" align="left" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_STARTDT.'</span></th>
		  <th width="14%" align="left" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_ENDDT.'</span></th>
		  <th width="23%" align="left" bgcolor="#CDCDCD" ><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_LEVEL.'</span></th>
		  </tr>
		  </thead>';
    $i = 1;
    if($_REQUEST["start_date"]!='' && $_REQUEST["end_date"]!=''){
		$cond="status<>'Completed' And (start_date <= '$_REQUEST[end_date]' And end_date >= '$_REQUEST[start_date]')";
    }else{
    	$cond = "status<>'Completed'";
    }
    $num=$dbf->countRows('student_group',$cond);
    
    foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
        
    $res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
    $grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
    $course = $dbf->strRecordID("course","*","id='$val[course_id]'");
	$html.='<tr>
	  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB">'.$i.'</td>
	  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" ><span id="result_box" lang="ar" xml:lang="ar">'.$val["group_name"].'&nbsp;'.$val["group_time"].'-'.$dbf->GetGroupTime($val["id"]).'</span></td>
	  <td align="left" valign="middle" bgcolor="#F8F9FB"><span id="result_box" lang="ar" xml:lang="ar">'.$res["name"].'</span></td>
	  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["start_date"].'</td>
	  <td align="left" valign="middle" bgcolor="#F8F9FB">'.$val["end_date"].'</td>
	  <td align="left" valign="middle" bgcolor="#F8F9FB" ><span id="result_box" lang="ar" xml:lang="ar">'.$course["name"].'</span></td>';
		  $i = $i + 1;
		  }
	$html.='</tr>
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_group_to_finish.pdf", 'D');
	exit;
?>	
