<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$num_user=$dbf->countRows('user',"user_id='$_REQUEST[tno]'");
if($num_user > 0)
{
?>
<table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
    <tr>
    <td width="73%" height="20" align="left" valign="middle" bgcolor="#FFECFF" class="nametext1">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_PASSWORD_EXITMSG");?></td>
    </tr>
</table>

<?php
}
?>