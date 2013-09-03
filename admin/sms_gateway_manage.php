<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

$res = $dbf->strRecordID("sms_gateway","*","");

include_once '../includes/language.php';

?>	

<link href="css/style.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="dropdowntabs.js"></script>
<script language="javascript" type="text/javascript">
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}
</script>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#000000">
            <td height="30" align="left" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_SMSGATEWAYCONFIGURATION");?></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top" bgcolor="#FFFFFF"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="title headingtext">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="340" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28"></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB"><span class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></span></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
				

				<table width="900" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="30" align="left" valign="top" >&nbsp;</td>
                      <td width="554" align="left" valign="top">
                      <form action="sms_gateway_process.php" name="frm" method="post" id="frm">
                          <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                            <tr>
                              <td width="12%">&nbsp;</td>
                              <td colspan="2" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="3" align="center"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                                <tr>
                                  <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="10%" align="center" valign="middle"><img src="../images/mobile-phone.png" width="16" height="16"></td>
                                      <td width="90%" class="red_smalltext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_TEXT1");?></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_USERID");?> : <span class="nametext1">*</span></td>
                              <td align="left" valign="middle">
                              <input name="user" type="text" class="textfield1" id="user" value="<?php echo $res["user"];?>" /></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_PASSWORD");?> : <span class="nametext1">*</span></td>
                              <td align="left" valign="middle"><input name="password" type="password" class="textfield1" id="password" value="<?php echo $res["password"];?>" /></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?> : <span class="nametext1">*</span></td>
                              <td align="left" valign="middle"><input name="mobile" type="text" class="textfield1" id="mobile" value="<?php echo $res["mobile"];?>"/></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td width="22%" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_NAME");?> : <span class="nametext1">*</span> </td>
                              <td width="66%" align="left" valign="middle">
                            <input name="your_name" type="text" class="textfield1" id="your_name" value="<?php echo $res["your_name"];?>"/>
                         	</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="2" align="left" valign="middle" class="leftmenu"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                                <tr>
                                  <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="10%" align="center" valign="middle"><img src="../images/ip_block.png" width="16" height="16"></td>
                                      <td width="90%" class="red_smalltext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_TEXT2");?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td height="30" align="center" valign="middle" bgcolor="#FEF7D8" class="mytext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="29%" align="right" valign="middle">
                                      <input type="checkbox" name="status2" id="status2" value="Enable" checked="checked" disabled="disabled"></td>
                                      <td width="20%" align="left" valign="middle" class="mytext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_ENABLE");?></td>
                                      <td width="8%" align="center" valign="middle" class="red_smalltext">
                                      <input type="checkbox" name="status3" id="status3" disabled="disabled"></td>
                                      <td width="43%" align="left" valign="middle" class="mytext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_DISABLE");?></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_STATUS");?> :</td>
                              <td align="left" valign="middle">
                              <input type="checkbox" name="status" id="status" value="Enable" <?php if($res[status]=="Enable") {?> checked="checked" <?php } ?>></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="3" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                              </tr>
                            <tr>
                              <td height="10" colspan="3" align="left" valign="middle"></td>
                            </tr>
                          </table>
                      </form></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>
                </table>

				</td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
</body>
</html>
