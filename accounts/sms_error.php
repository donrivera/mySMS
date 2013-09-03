<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
<body>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
            <td height="30" align="left" valign="middle" bgcolor="#FFA938" class="logintext"><?php echo constant("RECEPTION_SMS_ERROR_SMSBLOCKED");?></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top" bgcolor="#FFFFFF"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="title headingtext">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
				

				<table width="900" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="30" align="left" valign="top" >&nbsp;</td>
                      <td width="554" align="left" valign="top">
                      
                          <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                            <tr>
                              <td height="50" colspan="2" align="center" valign="middle"><img src="../images/errror.png" width="32" height="32"></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                                <tr>
                                  <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="10%" align="center" valign="middle"><img src="../images/mobile-phone.png" width="16" height="16"></td>
                                      <td width="90%" class="red_smalltext"><?php echo constant("RECEPTION_SMS_ERROR_TEXT");?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td width="19%" height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td width="66%" align="left" valign="middle">&nbsp;</td>
                            </tr>
                            </table>
                      
                      </td>
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
