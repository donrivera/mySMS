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
header("Content-Disposition: attachment; Filename=corporate_accounts.doc");
?>

<!--Important-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?php 
$details=$dbf->genericQuery("SELECT ctr.name as centre,corp.name as client FROM corporate corp INNER JOIN centre ctr ON ctr.id=corp.centre_id");
foreach($details as $dtl):
	$client=$dtl[client];
	$centre_name=$dtl[centre];
endforeach;
?>
<table>
	<tr>
		<td>Corporate Client:</td><td><?php echo $client;?></td>
	</tr>
	<tr>
		<td>Date Printed:</td><td><?php echo date('Y-m-d');?></td>
	</tr>
	<tr>
		<td>Center:</td><td><?php echo $centre_name;?></td>
	</tr>
	<tr><td></td></tr>
</table>
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
    <tr>
        <td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo "Account";?></td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Address";?> </td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo "Contact";?> </td>
    </tr>
	<?php
		$i = 1;
		$color="#ECECFF";
		$cond=(!empty($_REQUEST[account])?" AND cs.account=".$_REQUEST[account]:"");
		$query=$dbf->genericQuery(" 	SELECT DISTINCT(cs.account),c.*
										FROM corporate_students cs
										INNER JOIN corporate c ON c.code=cs.code
										WHERE cs.code='".$_REQUEST[code]."'".$cond);
		$num=count($query);
	foreach($query as $corp):
	?>
    <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $i;?></td>
        <td height='25' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $corp[account];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $corp[address];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $corp[contact];?></td>
    </tr>
	<tr>
        <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
        <td height="25" colspan="4" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
            <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
			<?php
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
            ?>
				<tr>
                    <td height="20" align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;">Sub Account</td>
                    <td align="left" align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;">Student Name</td>
                    <td align="center" align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;">Class</td>
                    <td align="right" align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;">ID</td>
                    <td align="center" align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;">Mobile</td>
                </tr>
            <?php  
				}
				$chk = ''; 
			?>
                <tr>
                    <td width="3%" align="center" valign="middle"><?php echo $student[sub_account];?></td>
                    <td width="20%" align="left" valign="middle" class="mycon"><?php echo $dbf->printStudentName($student[id]);?></td>
                    <td width="19%" align="center" valign="middle" class="mycon">
						<?php echo $student[group_name]."&nbsp;<BR/>".$student[start_date]."&nbsp;to&nbsp;".$student[end_date];?>
					</td>
                    <td width="11%" align="right" valign="middle" class="mycon"><?php echo $student[student_id];?></td>
                    <td width="12%" align="right" valign="middle" class="mycon"><?php echo $student[student_mobile];?></td>
				</tr>
			<?php
			endforeach;
			?>
			</table>
        </td>
    </tr>  
	<?php
	$i = $i + 1;
	endforeach;
	
	if($num==0)
	{
	?>
	<tr>
        <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
    </tr>	
    <?php
	}
	?>
</table>
</body>
</html>
