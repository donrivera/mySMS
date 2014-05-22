<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
      <tr>
		<td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTNAME");?></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?> </td>
        <?php if($_REQUEST['mobile']=='Yes'):?>
		<td width='12%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo  constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?> </td>
        <?php endif;?>
		<td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo "Address";?> </td>
        <td width='40%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo "Class Time";?> </td>
		<td width='40%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo "Schedule";?> </td>
	  </tr>
	  <?php
					
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
		?>
      <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB'><?php echo $i;?></td>
        <td height='25' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->printStudentName($val[id]);?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo (empty($val['student_id'])?'':$val['student_id']);?></td>
        <?php if($_REQUEST['mobile']=='Yes'):?>
		<td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[student_mobile];?></td>
		<?php endif;?>
		<td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val['address'];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->printClassTimeFormat($val['group_start_time'],$val['group_end_time']);?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val['start_date']."&nbsp;TO&nbsp;".$val['end_date'];?></td>
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
<script type="text/javascript">
window.print();
</script>

</body>
</html>
