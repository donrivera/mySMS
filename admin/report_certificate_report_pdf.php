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

$html = '<table width="1000" border="1" cellpadding="0" cellspacing="0"  bordercolor="#909999" style="border-collapse:collapse;">
			<thead>
                <tr>
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"></th>
                  <th width="22%" align="left" bgcolor="#CCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME.'</span></th>
                  <th width="13%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_IDNUMBER.'</span></th>
                  <th width="20%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME.'</span></th>
                  <th width="15%" align="center" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_PERCENT.'</span></th>
                  <th width="27%" align="left" bgcolor="#CCCCCC"><span id="result_box" lang="ar" xml:lang="ar">'.ADMIN_REPORT_CERTIFICATE_REPORT_GROUPSAED.'</span></th>
                  </tr>
				  </thead>';
					if($_REQUEST["cmbgroup"] != ""){
						$cond="g.id=d.parent_id And s.id=d.student_id And g.id='$_REQUEST[cmbgroup]'"; //certificate_collect='0' And 
					}
										
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					if($cond!=''){
						
						$num=$dbf->countRows('student s,student_group g,student_group_dtls d', $cond);
						
						//Loop Start
						foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d', $cond,"s.first_name","s.*") as $val){
													
						   //Get the Group Name
							$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
							
							//Get the Group Name
							$group = $dbf->strRecordID("common","*","id='$_REQUEST[cmbgroup]'");
							
							//Get Percentage from teacher_progress_certificate Table
							$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$res_group[course_id]' And student_id='$val[id]'");					
							$percentage = $res_per["final_percent"];
                $html.='<tr>
                  <td height="25" align="center" valign="middle" >'.$i.'</td>
                  <td height="25" align="left" valign="middle" style="padding-left:1px;"><span id="result_box" lang="ar" xml:lang="ar">'.$val["first_name"].'&nbsp;'.$Arabic->en2ar($dbf->StudentName($val["id"])).'</span></td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$val["student_id"].'</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$res_group["group_name"].' '.$res_group["group_time"].'-'.$dbf->GetGroupTime($res_group["id"]).'</td>
                  <td align="center" valign="middle" style="padding-left:1px;">'.$percentage.'%</td>
                  <td align="left" valign="middle" style="padding-left:1px;">'.$res_group["start_date"] .' And '. $res_group["end_date"].'</td>';
						  $i = $i + 1;
						}
					}
                $html.='</tr>
            </table>';

	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("report_student_results.pdf", 'D');
	exit;
?>	
