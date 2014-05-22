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
$details=$dbf->genericQuery("SELECT ctr.name as centre,corp.name as client FROM corporate corp INNER JOIN centre ctr ON ctr.id=corp.centre_id");
foreach($details as $dtl):
	$client=$dtl[client];
	$centre_name=$dtl[centre];
endforeach;
$html .='<table>
			<tr>
				<td>Corporate Client:</td>
				<td>'.$client.'</td>
			</tr>
			<tr>
				<td>Date Printed:</td>
				<td>'.date('Y-m-d').'</td>
			</tr>
			<tr>
				<td>Center:</td>
				<td>'.$centre_name.'</td>
			</tr>
			<tr><td></td></tr>
		 </table>';
$html .= '<table width="1000" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">
      <tr>
        <td width="3%" height="29" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</td>
        <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Account</span></td>
        <td width="10%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Address</span></td>
        <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Contact</span></td>
      </tr>';
		$i = 1;
		$color="#ECECFF";
		$cond=(!empty($_REQUEST[account])?" AND cs.account=".$_REQUEST[account]:"");
		$query=$dbf->genericQuery(" 	SELECT DISTINCT(cs.account),c.*
										FROM corporate_students cs
										INNER JOIN corporate c ON c.code=cs.code
										WHERE cs.code='".$_REQUEST[code]."'".$cond);
		$num=count($query);
		foreach($query as $corp):
			$html.='<tr bgcolor="'.$color.'">
						<td height="25" align="center" valign="middle" class="contenttext">'.$i.'</td>
						<td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$corp['account'].'</span></td>
						<td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$corp['address'].'</span></td>
						<td align="left" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$corp['contact'].'</span></td>
					</tr>';
					
			$html .='<tr>
						<td height="29" align="center" valign="middle" bgcolor="#CDCDCD">&nbsp;</td>
						<td height="25" colspan="4" align="left" bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
							<table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">';
			
            //Loop start
			$chk = 'first';
			$query1=$dbf->genericQuery("SELECT cs.id,cs.sub_account,cs.student_id,s.address,s.student_id,s.student_mobile,c.name,sg.group_name,sg.start_date,sg.end_date 
										FROM corporate_students cs 
										INNER JOIN student s ON s.id=cs.student_id
										INNER JOIN student_group_dtls sgd ON sgd.course_id=cs.course_id	AND sgd.student_id=cs.student_id		
										INNER JOIN student_group sg ON sg.id=sgd.parent_id
										INNER JOIN course c ON c.id=cs.course_id
										WHERE cs.account='".$corp[account]."'");
			foreach($query1 as $student):
				if($chk == 'first')
				{
					$html .='
						<tr>
							<td height="20" align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Sub Account</span></td>
							<td align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Student Name</span></td>
							<td align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Class</span></td>
							<td align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">ID</span></td>
							<td align="left" valign="middle" bgcolor="#CDCDCD"><span id="result_box" lang="ar" xml:lang="ar">Mobile</span></td>
						</tr>';
				}
				$chk = ''; 
				$html .='
						<tr>
							<td width="3%"  valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$student[sub_account].'</span></td>
							<td width="20%" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">'.$dbf->printStudentName($student[id]).'</span></td>
							<td width="19%" valign="middle" ><span id="result_box" lang="ar" xml:lang="ar">
								'.$student[group_name]."&nbsp;<BR/>".$student[start_date]."&nbsp;to&nbsp;".$student[end_date].'
							</td>
							<td width="11%" align="right" valign="middle" class="mycon">'.$student[student_id].'</td>
							<td width="12%" align="right" valign="middle" class="mycon">'.$student[student_mobile].'</td>
						</tr>';
			
			endforeach;
			$html .='
			</table>
        </td>
    </tr>'; 
	  $i = $i + 1;
		endforeach;
	$html.='</table>';

	$mpdf = new mPDF('ar', 'A4-L');
	$mpdf->WriteHTML($html);
	$mpdf->Output("corporate_accounts.pdf", 'D');
	exit;
?>