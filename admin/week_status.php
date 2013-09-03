<?php
ob_start();
session_start();
include_once '../includes/language.php';

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_status=$dbf->fetchSingle('working_day',"id='$_REQUEST[id]'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
</style>
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
</head>
<body>
<form id="frm" name="frm" method="post" action="week_process.php?action=status" >
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="22%" align="left" valign="middle" class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></td>
          <td width="60%" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_WEEK_MANAGE_SETOFHOLIDAY");?></td>
          <td width="11%"><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST[id];?>" /></td>
          <td width="7%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
        </tr>
        <tr>
          <td height="5" colspan="4" align="right" valign="middle"></td>
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
              <td width="31%" height="30" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?> : <span style="color:#FF0000; font-weight:bold;">*&nbsp;</span></td>
              <td width="3%">&nbsp;</td>
              <td width="66%" align="left" valign="middle">
              <select name="status" id="status" style="width:150px; border:solid 1px; border-color:#FF9900;">
              <option value="0" <?php if($res_status[status]=='0') { echo "Selected"; }?>>Working Day</option>
              <option value="1" <?php if($res_status[status]=='1') { echo "Selected"; }?>>Non-Working Day</option>
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
          <td align="right" valign="top" style="padding-right:8px;">
          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
