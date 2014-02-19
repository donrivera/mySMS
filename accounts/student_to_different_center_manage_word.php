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
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=student_to_different_center_manage.doc");

?>	
<!--Important-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">		
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
	<thead>
        <tr class="logintext">
            <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
            <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
            <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
            <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
            <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
            <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
            <th width="6%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo "Status";?></th>
            <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Students</th>
            <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
            <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
        </tr>
	</thead>
    <?php					
		$i = 1;
		$color = "#ECECFF";
        $num=$dbf->countRows('transfer_different_centre',"centre_id='$_REQUEST[centre_id]'","");
					
		foreach($dbf->fetchOrder('transfer_different_centre',"centre_id='$_REQUEST[centre_id]'","id DESC ","*") as $transfer)
		{
		
			$status = $dbf->getDataFromTable("student_status","name","id='$transfer[from_status]'");
			$centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
			$centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
			$group_fr=$dbf->getDataFromTable("student_group","name","id='$transfer[from_id]'");
			$group_to=$dbf->getDataFromTable("student_group","name","id='$transfer[to_id]'");
	?>
		<tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
			<td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo (empty($group_fr)?"Group Removed":$group_fr);?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo (empty($group_to)?"Group Removed":$group_to);?></td>
			<td align="center" valign="middle" class="mycon"><?php echo $status;?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $dbf->printStudentName($transfer[from_student]);?></td>
			<td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
			<td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
        <?php
			$i = $i + 1;
			if($color=="#ECECFF"){$color = "#FBFAFA";}else{$color="#ECECFF";}
		}
		?>
    </tr>              
 </table>