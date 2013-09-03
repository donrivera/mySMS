<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$teacher_id =  $_REQUEST[teacher_id];

if($teacher_id == '')
{
?>
<table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF99FF;">
  <tr>
    <td align="center" valign="middle" bgcolor="#FFECFF" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT5");?></td>
  </tr>
</table>
<?php
}
else
{
	$is_exist = '';
	foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'","id") as $val_group){
		
		$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$_REQUEST[sdt]' BETWEEN start_date And end_date)");
		if($num>0){
			$is_exist = 'true';
			break;
		}		
	}
	
	if($is_exist == 'true'){
	?>
    <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF99FF;">
      <tr>
        <td align="center" valign="middle" bgcolor="#FFECFF" class="red_smalltext"><?php echo constant("CD_SLOT_MANAGE_BOOKEDSLOT");?></td>
      </tr>
    </table>
<?php
	}
}
?>
