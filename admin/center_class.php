<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$tno=$_REQUEST[tno];
?>
<table width="333" cellpadding="2" cellspacing="0">
  <tr>
    <th width="151" bgcolor="#003399" class="footertext" scope="col"><font color="#FFFFFF"><?php echo constant("ADMIN_CENTRE_MANAGE_CLASSROOM");?></font></th>
    <th width="11" bgcolor="#003399" class="footertext" scope="col">&nbsp;</th>
    <th width="155" align="center" bgcolor="#003399" class="footertext" scope="col"><font color="#FFFFFF"><?php echo constant("ADMIN_CENTRE_MANAGE_NUMBEROFCHAIRS");?></font></th>
  </tr>
  <?php
   for($i=1;$i<=$tno;$i++)
   {
   $j = $i - 1;
   
	$res = $dbf->strRecordID("centre_room","*","centre_id='$_REQUEST[cid]' LIMIT $j,1");
	
	if($res["no"]>0)
	{
		$c = $res["name"];
	}
	else
	{
		$c="Classroom"." ".$i;
	}
	
   ?>
  <tr>
    <th align="center" valign="middle" scope="col"><input name="c<?php echo $i;?>" type="text" class="new_textbox1" id="c<?php echo $i;?>" size="45" value="<?php echo $c;?>" /></th>
    <th scope="col">&nbsp;</th>
    <th align="center" valign="middle" scope="col"><input name="r<?php echo $i;?>" type="text" class="new_textbox1" id="r<?php echo $i;?>" size="45" value="<?php echo $res["no"];?>"/></th>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><input type="hidden" id="count" name="count" value="<?php echo $i-1;?>"></td>
  </tr>
</table>
