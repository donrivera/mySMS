<?php
ob_start();
session_start();
include_once 'includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="javascript" type="text/javascript">
function forgot(){
	
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	var emailid=document.frm.emailid.value;
	if(document.frm.emailid.value=="")
	{
		document.getElementById('lbl_error').innerHTML="Enter email Address.";
		document.frm.emailid.focus();
		return false;
	}	
	if(!emailid.match(emailExp))
	{
		document.getElementById('lbl_error').innerHTML = "Required valid mail ID.";
		document.frm.emailid.focus();
		return false;
	}	
}	
</script>

</head>
<style>
.btn1{
background:url(images/btn1.png) no-repeat;
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
<body>
<form id="frm" name="frm" method="post" action="forgotpass_process.php" onSubmit="return forgot()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%" align="left" valign="middle"><img src="logo/logo.png" alt="logo" width="100" height="30" /></td>
          <td width="61%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("RECOVER_HEADING");?></td>
          <td width="11%" align="center" valign="middle"><img src="images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
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
              <td width="31%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo constant("ADMIN_USER_MANAGE_EMAILID");?> :</td>
              <td width="3%">&nbsp;</td>
              <td width="66%" align="left" valign="middle">
                <input name="emailid" type="text" id="emailid" value="" size="45" style=" height:25px;
 border:solid 1px #c8c8c8;
 width:180px;" /></td>
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
          <td align="right" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn1" border="0" align="left" /></td>
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
