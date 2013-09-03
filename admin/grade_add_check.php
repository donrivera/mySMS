<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

//$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");

foreach($dbf->fetchOrder('grade',"tto>='$_REQUEST[frm]' and frm<='$_REQUEST[frm]'","id") as $val) {
	if($val["id"] > 0)
	{
		?>
        <table width="190" cellspacing="0" bordercolor="#FF9900" border="2" style="border-collapse:collapse;"> 
          <tr>
            <td align="center" valign="middle" style="font:Arial, Helvetica, sans-serif; color:#FF0000; font-size:12px;">This range already exist.</td>
          </tr>
        </table>
        <?php
		echo "";
		break;
	}	
}

foreach($dbf->fetchOrder('grade',"tto>='$_REQUEST[tto]' and tto<='$_REQUEST[tto]'","id") as $val1) {
	if($val1["id"] > 0)
	{
		?>
        <table width="190" cellspacing="0" bordercolor="#FF9900" border="2" style="border-collapse:collapse;"> 
          <tr>
            <td align="center" valign="middle" style="font:Arial, Helvetica, sans-serif; color:#FF0000; font-size:12px;">This range already exist.</td>
          </tr>
        </table>
        <?php
		break;
	}	
}
?>