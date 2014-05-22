<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_corp_acct.doc");
?>

<!--Important-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
		<tr>
			<td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
			<td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Account";?> </td>
			<td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Course";?> </td>
		</tr>
	 <?php
		$i = 1;
		$color="#ECECFF";
		$query=$dbf->genericQuery(" SELECT s.id,cs.account,cs.sub_account,crs.name
									FROM student s
									INNER JOIN corporate_students cs ON cs.student_id=s.id
									INNER JOIN course crs ON crs.id=cs.course_id												
									INNER JOIN corporate c ON c.code=cs.code
									WHERE c.code='$_REQUEST[corp_code]'
								");
		$num=count($query);
		foreach($query as $val){
	  ?>		
      <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $i;?></td>
        <td height='25' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->printStudentName($val['id']);?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[account]."-".$val[sub_account];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val[name];?></td>
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
</body>
</html>
