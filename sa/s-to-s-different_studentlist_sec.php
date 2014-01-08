<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
if($_SESSION['lang']=='EN')
{
?>
	<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		<tr>
			<td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			<td width="38%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="33%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
		</tr>
	<?php
		
		if(($_REQUEST['status'] !='') && ($_REQUEST['course_id'] !='') && $_REQUEST['group'] !='')
		{
			$query=$dbf->genericQuery("	SELECT s.*,sf.total
										FROM student s
										LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
										INNER JOIN student_moving sm ON sm.student_id=s.id
										INNER JOIN student_group_dtls sgd ON sgd.student_id=s.id 
										WHERE s.centre_id='$_REQUEST[centre_from]' AND sf.course_id='$_REQUEST[course_id]' 
										AND sm.status_id='$_REQUEST[status]' AND  sgd.parent_id='$_REQUEST[group]'");
		}
		elseif($_REQUEST['status'] !='')
		{
			$query=$dbf->genericQuery("	SELECT s.*,sf.total
										FROM student s
										LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
										INNER JOIN student_moving sm ON sm.student_id=s.id
										WHERE s.centre_id='$_REQUEST[centre_from]' AND sm.status_id='$_REQUEST[status]'");
		}
		elseif($_REQUEST['course_id'] !='')
		{
			$query=$dbf->genericQuery("	SELECT s.*,sf.total
										FROM student s
										LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
										WHERE s.centre_id='$_REQUEST[centre_from]' AND sf.course_id='$_REQUEST[course_id]'");
		}
		elseif($_REQUEST['group'] !='')
		{
			$query=$dbf->genericQuery("	SELECT s.*,sf.total
										FROM student s
										LEFT  JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
										INNER JOIN student_group_dtls sgd ON sgd.student_id=s.id 
										WHERE s.centre_id='$_REQUEST[centre_from]' AND sgd.parent_id='$_REQUEST[group]'");
		}
		else
		{
			$query=$dbf->genericQuery("	SELECT s.*,sf.total,sf.course_id
										FROM student s
										LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id  
										WHERE s.centre_id='$_REQUEST[centre_from]' ORDER BY sf.total DESC LIMIT 0,10");
			//$query=$dbf->fetchOrder('student',"centre_id='$_REQUEST[centre_from]'");
		}
		$i = 1;
		foreach($query as $student) 
		{
	?>
		<tr>
			<td align="center" valign="middle" bgcolor="#FFFFFF" >
				<input type="radio" name="tostudent_id" id="tostudent_id" value="<?php echo $student["id"];?>" onchange="show_save();" />
			</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
			<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
		</tr>
	<?php 
			$i++; 
		} 
	?>
		</table>
	<?php 
} 
else
{
	?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
			<tr> 
				<td width="23%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
				<td width="33%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
				<td width="38%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
				<td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			</tr>
	<?php
		$i = 1;
		//$query=$dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'");
		foreach($query as $mygroup) 
		{
			$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
	?>
			<tr>
				<td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
				<td align="center" valign="middle" bgcolor="#FFFFFF" ></td>
			</tr>
	<?php 
			$i++; 
		}
	?>
		</table>
	<?php 
}
	?>