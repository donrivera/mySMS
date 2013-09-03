<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

$teacher_id = $_REQUEST[teacher];

if($teacher_id > 0)
{
$resgroup = $dbf->strRecordID("student_group","*","id='$_REQUEST[teacher]'");
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
  <tr>
    <td width="87%" height="25" align="center" valign="middle" bgcolor="#E0E3FE" class="red_smalltext"><?php echo constant("CD_EP_CLASS_CANCEL_AJAX_GROUPSTARTON");?> <?php echo date('d-M-Y',strtotime($resgroup["start_date"]));?><?php echo constant("CD_EP_CLASS_CANCEL_AJAX_TO");?>  <?php echo date('d-M-Y',strtotime($resgroup["end_date"]));?></td>
  </tr>
</table>
<?php
}
else
{
?>
<table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
  <tr>
    <td width="87%" height="25" align="center" valign="middle" bgcolor="#E0E3FE" class="red_smalltext"><?php echo constant("CD_EP_CLASS_CANCEL_AJAX_SELECTGROUP");?></td>
  </tr>
</table>
  <?php
}
	  
?>