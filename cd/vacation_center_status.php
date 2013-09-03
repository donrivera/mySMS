<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;width:143px;height:25px;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bolder;color:#FFFFFF;border:none;text-align:center;cursor:pointer;padding-bottom:5px;text-decoration:none;text-transform:uppercase;
}
.btn2{
background:url(../images/btn2.png) no-repeat;width:143px;height:25px;font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;font-size:12px;font-weight:bolder;color:#FFFFFF;border:none;text-align:center;cursor:pointer;padding-bottom:5px;
}
</style>
<?php if($_SESSION[lang] == "EN"){?>
<form id="frm" name="frm" method="post" action="vacation_center_process.php" >
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("CD_VACATION_CENTER_STATUS_CENTERLEAVE");?></td>
          <td width="19%"><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST[id];?>" /></td>
          <td width="11%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onClick="javascript:self.parent.tb_remove();"/></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="380" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" style="font-family:Arial, Helvetica, sans-serif; color:#FF0000; font-weight:normal; font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="31%" height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo constant("STUDENT_MYACCOUNT_STATUS");?> : <span style="color:#FF0000; font-weight:bold;">*&nbsp;</span></td>
              <td width="3%">&nbsp;</td>
              <td width="66%" align="left" valign="middle">
              <select name="status" id="status" style="width:150px; border:solid 1px; border-color:#FF9900;">
              <option value="1">Approved</option>
              <option value="2">Rejected</option>
              </select></td>
              </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php }else{?>
<form id="frm" name="frm" method="post" action="vacation_center_process.php" >
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="7%" align="left" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onClick="javascript:self.parent.tb_remove();"/></td>
          <td width="8%"><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST[id];?>" /></td>
          <td width="85%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("CD_VACATION_CENTER_STATUS_CENTERLEAVE");?>&nbsp;</td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="380" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" style="font-family:Arial, Helvetica, sans-serif; color:#FF0000; font-weight:normal; font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="67%" height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;">
			  <select name="status" id="status" style="width:150px; border:solid 1px; border-color:#FF9900;">
              <option value="1">Approved</option>
              <option value="2">Rejected</option>
              </select></td>
              <td width="2%">&nbsp;</td>
              <td width="31%" align="left" valign="middle"><span style="color:#FF0000; font-weight:bold;">*&nbsp;</span> : <?php echo constant("STUDENT_MYACCOUNT_STATUS");?></td>
              </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="left" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php } ?>