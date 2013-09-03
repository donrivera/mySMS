<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
if($_REQUEST[tno]=='') { exit; }

$num=$dbf->countRows('teacher',"name='$_REQUEST[tno]'");
if($num > 0)
{
?>
<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle" class="nametext1" style="padding-left:5px;"><?php echo constant("ADMIN_TEACHER1_CHECK_TEACHEREXIST");?></td>
  </tr>
</table>
<?php } ?>