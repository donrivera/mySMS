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

$html = '<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
		<tr>
		  <th width="2%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
		  <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME.'</span></th>
		  <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_GROUP_TO_FINISH_LEVEL.'</span></th>
		  <th width="7%"  align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_GROUP.'</span></th>
		  <th width="13%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME.'</span></th>
		  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_MOBILENO.'</span></th>
		  <th width="17%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS.'</span></th>
		  <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_LASTATTAND.'</span></th>
		  <th colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT.'</span></th>
		</tr>';
		$condition = '';
		//Concate the Condition
		//1.
		if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "s.email LIKE '$_REQUEST[email]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}
		//End 1.
		
		//2.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}
		//End 2.
		
		//3.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}
		//End 3.
		
		//4.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And  s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
		}
		//End 4.
		//"s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'"
		//loop start
		foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d', $condition ,"","d.*") as $val) {
			
			//Get Course
			$course = $dbf->strRecordID("course","*","id='$val[course_id]'");
			$group_dtls = $dbf->strRecordID("student_group","*","id='$val[parent_id]'");
			//Get Total Absent
			$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[student_id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
			$countid = $res_max["COUNT(id)"];
			
			//Get Last Attendance
			$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[student_id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
			$maxid = $res_max["MAX(id)"];
			
			$reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[student_id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
			$resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
			
			//Get Name Of Groups
			$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
			$res2 = $dbf->strRecordID("common","*","id='$val[parent_id]'");
			
			//Get Name Of Teacher
			$res3 = $dbf->strRecordID("teacher","*","id='$_SESSION[uid]'");
			
			if($countid>0) {
			$html.='<tr>
			  <td height="25" align="center" valign="middle" class="mycon">&nbsp;</td>
			  <td height="25" align="left" valign="middle"><span id="result_box" lang="ar" xml:lang="ar">'.$res[first_name].' '.$Arabic->en2ar($dbf->StudentName($res["id"])).'</span></td>
			  <td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$course[name].'</span></td>
			  <td height="30" align="left" valign="middle">'.$group_dtls[group_name].'</td>
			  <td align="left" valign="middle">'.$res3[name].'</td>
			  <td align="left" valign="middle">'.$res[student_mobile].'</td>
			  <td align="left" valign="middle">'.$res[email].'</td>';
			  $last = '';
			  if($reslast["unit"] > 0){
					$last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
			  }
			  $html.='<td align="left" valign="middle" bgcolor="#F8F9FB">'.$last.'</td>
			  <td width="11%" align="center" valign="middle" bgcolor="#F8F9FB">'.$countid.'</td>';
					  $i = $i + 1;
				}
			}
		$html.='</tr>
	</table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_absent_report.pdf", 'D');
	exit;
?>	