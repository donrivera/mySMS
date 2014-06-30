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
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT")?></td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?> </td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?> </td>
		<td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH")?></td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?> </td>
      </tr>
	  <?php
		$teacher_id = $_SESSION[uid];
		$start_date=($_REQUEST[start_date]!='')?$_REQUEST[start_date]:$dbf->MonthFirstDay(date('m'),date('Y'));
		$end_date=($_REQUEST[end_date]!='')?$_REQUEST[end_date]:$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
		$i = 1;
		$color = "#ECECFF";
		$cond = '';
		if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '')
		{
			$cond = "(from_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
		}else{$cond = "(from_date BETWEEN '$start_date' And '$end_date')";}
		$num=$dbf->countRows('sick_leave', $cond);
		foreach($dbf->fetchOrder('sick_leave',"teacher_id='$teacher_id' And ".$cond,"id") as $val) 
		{
			if($val[sick_status]== '0'){$status='Pending';}
			elseif($val[sick_status]== '1'){$status='Approved';}
			else{$status='Rejected';}
		?>
      <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $i;?></td>
		<td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[from_date];?></td>
        <td height='30' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[to_date];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[sick_reason];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[sick_attachment];?></td>
		<td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $status;?></td>
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