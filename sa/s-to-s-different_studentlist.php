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
	if($_REQUEST['centre_from'] != '')
	{
		?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		<tr>
			<td width="5%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			<td width="29%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="26%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
			<td width="17%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
		</tr>
		<?php
			$course_id=$_REQUEST['course_id'];
			$i = 1;
			if(($_REQUEST['from_status'] !='') && ($_REQUEST['course_id'] !=''))
			{
				$query=$dbf->genericQuery("	SELECT s.*,sf.total,sf.course_id
											FROM student s
											LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
											INNER JOIN student_moving sm ON sm.student_id=s.id
											WHERE s.centre_id='$_REQUEST[centre_from]' AND sf.course_id='$_REQUEST[course_id]' AND sm.status_id='$_REQUEST[from_status]'");
			}
			elseif($_REQUEST['from_status'] !='')
			{
				$query=$dbf->genericQuery("	SELECT s.*,sf.total,sf.course_id
											FROM student s
											LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
											INNER JOIN student_moving sm ON sm.student_id=s.id
											WHERE s.centre_id='$_REQUEST[centre_from]' AND sm.status_id='$_REQUEST[from_status]'");
			}
			elseif($_REQUEST['course_id'] !='')
			{
				$query=$dbf->genericQuery("	SELECT s.*,sf.total,sf.course_id
											FROM student s
											LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
											WHERE s.centre_id='$_REQUEST[centre_from]' AND sf.course_id='$_REQUEST[course_id]'");
			}
			else
			{
				$query=$dbf->genericQuery("	SELECT s.*,sf.total,sf.course_id
											FROM student s
											LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
											WHERE s.centre_id='$_REQUEST[centre_from]' ORDER BY sf.total DESC LIMIT 0,10 ");
				//$query=$dbf->fetchOrder('student',"centre_id='$_REQUEST[centre_from]'");
			}
			foreach($query as $student) 
			{	$cou_id=($course_id =='' ? $student["course_id"] :$course_id );
				//$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				$course_fee = $dbf->printBalanceAmount($student["id"], $cou_id);
		?>
		<tr>
			<td align="center" valign="middle" bgcolor="#FFFFFF" >
				<input type="radio" name="student_id" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />
			</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
			<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
			<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
		</tr>
		<?php 
			$i++; 
			} 
		?>
		<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
		<?php	
	}
	elseif($_REQUEST['group'] != '')
	{
		?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		<tr>
			<td width="5%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			<td width="29%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="26%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
			<td width="17%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
		</tr>
		<?php
			$i = 1;
			foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) 
			{
				$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				$course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
		?>
		<tr>
			<td align="center" valign="middle" bgcolor="#FFFFFF" >
				<input type="radio" name="student_id" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />
			</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
			<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
			<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
		</tr>
	<?php 
			$i++; 
			} 
		?>
		<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
    <?php 
	} 
	else 
	{ 
	?>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
      <tr>
        <td width="5%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
        <td width="29%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
        <td width="26%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
        <td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
        <td width="17%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
      </tr>
	  <?php
      $i = 1;
      
      $status_id = $_REQUEST["from_status"];
	  $course_id = $_REQUEST["course_id"];
	  foreach($dbf->fetchOrder('student m,student_moving d',"m.id=d.student_id And d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$_REQUEST[centre_from]' And m.first_name<>''","","m.*") as $student) 
		{
			$course_fee = $dbf->BalanceAmount($student["id"], $course_id);
		  
    ?>
			<tr>
				<td align="center" valign="middle" bgcolor="#FFFFFF" >
					<input type="radio" name="student_id>" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />
				</td>
				<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
				<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
				<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
			</tr>
  	<?php 
			$i++; 
		} 
	?>
		<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
	</table>
    <?php 
	} 
	?>

	<?php 
} 
else
{
	if($_REQUEST['centre_from'] != '')
	{
		?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		<tr>
			<td width="5%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			<td width="29%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="26%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
			<td width="17%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
		</tr>
		<?php
			$i = 1;
			foreach($dbf->fetchOrder('student_group_dtls',"centre_id='[centre_from]'") as $mygroup) 
			{
				$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				$course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
		?>
		<tr>
			<td align="center" valign="middle" bgcolor="#FFFFFF" >
				<input type="radio" name="student_id" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />
			</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
			<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
			<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
		</tr>
		<?php 
			$i++; 
			} 
		?>
		<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
		<?php	
	}
	elseif($_REQUEST['group'] != '')
	{
	?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		<tr>
			<td width="17%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;<?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td> 
			<td width="19%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
			<td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
		</tr>
    <?php
		$i = 1;
		foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) 
		{
            $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
            $course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
    ?>
			<tr>
				<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>
				<td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
				<td align="center" valign="middle" bgcolor="#FFFFFF" >
					<input type="checkbox" name="student_id" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />   
				</td>
			</tr>
    <?php 
			$i++; 
		} 
	?>
			<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
    <?php
	}
	else
	{
	?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
			<tr>
				<td width="17%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;<?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td> 
				<td width="19%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
				<td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
				<td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
				<td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			</tr>
	<?php
		$i = 1;
		$status_id = $_REQUEST["from_status"];
		$course_id = $_REQUEST["course_id"];
		foreach($dbf->fetchOrder('student m,student_moving d',"m.id=d.student_id And d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$_REQUEST[centre_from]' And m.first_name<>''","","m.*") as $student)
		{
			$course_fee = $dbf->BalanceAmount($student["id"], $course_id);
	?>
			<tr>
				<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>
				<td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
				<td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
				<td align="center" valign="middle" bgcolor="#FFFFFF" >
					<input type="checkbox" name="student_id" id="student_id" value="<?php echo $student["id"];?>" onchange="show_save();" />   
				</td>
			</tr>
	<?php 
			$i++; 
		} 
	?>
			<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
	<?php
	}
}
?>