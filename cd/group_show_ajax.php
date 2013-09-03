<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

$num_group=$dbf->countRows('student_group',"group_name='$_REQUEST[group]' And centre_id='$_SESSION[centre_id]'");
if($num_group > 0)
{
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="220" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
    <tr>
      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2F4"><img src="../images/errror.png" width="32" height="32" /></td>
      <td width="10" bgcolor="#FFF2F4">&nbsp;</td>
      <td width="253" align="left" valign="middle" bgcolor="#FFF2F4" class="home_head_text"><?php echo constant("CD_GROUP_GROUPNAMEEXIST");?> </td>
    </tr>
</table>
<?php } else{?>
<table width="220" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
    <tr>
     <td width="253" align="right" valign="middle" bgcolor="#FFF2F4" class="home_head_text"><?php echo constant("CD_GROUP_GROUPNAMEEXIST");?> </td>
      <td width="10" bgcolor="#FFF2F4">&nbsp;</td>
     <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2F4"><img src="../images/errror.png" width="32" height="32" /></td>
    </tr>
</table>
<?php }?>
<?php
}
?>
