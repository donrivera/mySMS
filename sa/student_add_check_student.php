<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$num_student = $dbf->countRows("student","first_name='$_REQUEST[name]'");
if($num_student > 0)
{
 if($_SESSION['lang']=='EN'){?>

<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
  <tr>
    <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE"><img src="../images/errror.png" width="32" height="32" /></td>
    <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
    <td width="253" align="left" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_NAMEEXT");?> </td>
  </tr>
</table>
<?php
} else{
?>
<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
  <tr>
  <td width="253" align="right" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_NAMEEXT");?> </td>
    
    <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
    <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE"><img src="../images/errror.png" width="32" height="32" /></td>
  </tr>
</table>
<?php }}?>