<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
foreach($dbf->fetchOrder('group_size',"size_to>='$_REQUEST[frm]' and size_from<='$_REQUEST[frm]'","id") as $val) {
	if($val["id"] > 0)
	{
		//echo "aa";
		?>
		<table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#990000;">
          <tr>
            <td width="31" align="center" valign="middle" bgcolor="#FF0000"><img src="../images/errror.png" width="25" height="25"></td>
            <td width="169" align="left" valign="middle" bgcolor="#FF0000" class="leftmenu"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_RANGEEXIST");?></td>
          </tr>
        </table>
        <?php
		exit;
	}	
}

foreach($dbf->fetchOrder('group_size',"size_to>='$_REQUEST[tto]' and size_to<='$_REQUEST[tto]'","id") as $val1) {
	if($val1["id"] > 0)
	{
		?>
        <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#990000;">
          <tr>
            <td width="31" align="center" valign="middle" bgcolor="#FF0000"><img src="../images/errror.png" width="25" height="25"></td>
            <td width="169" align="left" valign="middle" bgcolor="#FF0000" class="leftmenu"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_RANGEEXIST");?></td>
          </tr>
        </table>
        <?php
		break;
	}	
}
?>