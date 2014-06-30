<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
      <tr>
        <td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("TEACHER_ARF_MANAGE_REPORTDATE")?></td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?> </td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONOWENER");?> </td>
		 <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY")?></td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_ARF_MANAGE_REPORTTO");?> </td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Status";?> </td>
      </tr>
	  <?php
		$i = 1;
		$color="#ECECFF";
		$teacher_id=$_SESSION[id];
		//Concate the Condition
		$condition = $dbf->getSearchStrings($_REQUEST["fname"],$_REQUEST["stid"],$_REQUEST["mobile"],$_REQUEST["email"], $centre_id,"s."," And s.id=c.student_id AND c.teacher_id='$teacher_id'");
		//End 4.					
		$num=$dbf->countRows('student s, arf c', $condition);
		foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) 
		{	
			#$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
		?>
      <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $i;?></td>
		<td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[dated];?></td>
        <td height='30' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->printStudentName($val['student_id']);?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[action_owner];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[arf_function];?></td>
		<td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[arf_function1];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo "Submitted";?></td>
        <?php
			$i = $i + 1;
		}
		?>		  
        </tr>
		<?php
		if($num==0)
		{
			?>
		
      <?php
		}
		?>
    </table>