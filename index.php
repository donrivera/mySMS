<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
require 'I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

if(isset($_COOKIE['cook_username'])){
	$username = $_COOKIE['cook_username'];	// Select the username from the cookie
	$password = base64_decode(base64_decode($_COOKIE['cook_password']));	// Select the password from the cookie
}

$username = "";	// Select the username from the cookie
$password = "";

if(isset($_REQUEST["lang"])==''){
	$_SESSION["lang"] = "EN";
}else{
	$_SESSION["lang"] = $_REQUEST["lang"];
	
	$username = $_REQUEST["uname"];	// Select the username from the cookie
	$password = $_REQUEST["password"];	// Select the password from the cookie
}

include_once 'includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz-KSA</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="modal/thickbox.css" type="text/css" media="screen" />
<link rel="icon" href="images/b.png">
<style>
input:focus, textarea:focus, select:focus{
background-color:#FDE7C8;
}
</style>
<script type="text/javascript"  src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="modal/thickbox.js"></script>
<script language="javascript" type="text/javascript">
function checkprofile(){
	if(document.frm.uname.value == ''){
		//document.getElementById('lblname').innerHTML = "Enter Username.";
		document.frm.uname.focus();
		return false;
	}else{
		//document.getElementById('lblname').innerHTML = "";
	}
	
	if(document.frm.password.value==''){
		//document.getElementById('lblname').innerHTML = "Enter Password.";
		document.frm.password.focus();
		return false;
	}else{
		//document.getElementById('lblname').innerHTML = "";
	}	
}
function gotfocus(){
	document.getElementById('uname').focus();
}
</script>
</head>
<body onLoad="gotfocus();">
<form id="frm" name="frm" method="post" action="login_process.php" onSubmit="return checkprofile();">
<?php if($_SESSION["lang"] == "EN"){?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
  	<?php
    if(isset($_REQUEST["lang"])=='' || isset($_REQUEST["lang"]) == 'EN'){
		$logo = "logo/logo.png";
	}else{
		$logo = "logo/logo-ar.png";
	}
	?>
    <td height="50" align="left" valign="middle" style="padding-left:5px; padding-top:25px;"><img src="<?php echo $logo;?>" alt="logo" style="padding:0px; margin:0px;" /></td>
  </tr>
  <tr>
    <td height="104">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="1008" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="479" align="center" valign="top" class="loginbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="36">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top"><img src="images/welcome.png" alt="welcome-img" width="276" height="29" /></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="205">&nbsp;</td>
                <td width="552" align="left" valign="top"><table width="552" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <?php
                  if($_SESSION["lang"]=='EN'){
                        $hh = "loginheading";
                    }else{
                        $hh = "loginheading_ar";
                    }
					?>
                    <td align="left" valign="middle" class="login-top-bg"><span class="<?php echo $hh;?>"> <?php echo constant("INDEX_LOGIN");?></span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top" background="images/login-mid-bg.png" class="login-mid-bg"><table width="515" border="0" cellspacing="0" cellpadding="0">
                      <?php if(isset($_REQUEST["msg"])=="denied") { ?>
					  <tr>
                        <td height="30" align="right" valign="middle">
						<table width="240" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#996633;">
                          <tr>
                            <td width="6%" height="25" bgcolor="#FEFCDA">&nbsp;</td>
                            <td width="11%" align="center" valign="middle" bgcolor="#FEFCDA"><img src="images/block.png" width="16" height="16"></td>
                            <td width="83%" align="left" valign="middle" bgcolor="#FEFCDA" class="activemenutext">Access denied !!!</td>
                            </tr>
                        </table></td>
                        <td>&nbsp;</td>
                      </tr>
					  <?php } ?>
                      <?php if(isset($_REQUEST["msg"])=="fail") { ?>
					  <tr>
                        <td height="30" align="right" valign="middle">
						<table width="240" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#996633;">
                          <tr>
                            <td width="6%" height="25" bgcolor="#F9DFE1">&nbsp;</td>
                            <td width="10%" align="center" valign="middle" bgcolor="#F9DFE1"><img src="images/block.png" width="16" height="16"></td>
                            <td width="84%" align="left" valign="middle" bgcolor="#F9DFE1" class="activemenutext">Invalid user name or password !!!</td>
                            </tr>
                        </table></td>
                        <td>&nbsp;</td>
                      </tr>
					  <?php } ?>
                      <tr>
                        <td width="297" align="left" valign="top"><table width="297" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="20">&nbsp;</td>
                            <td height="20" valign="middle" class="nametext1" id="lblname">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="87" height="20">&nbsp;</td>
                            <td width="245" height="20">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="87" align="left" valign="middle" class="login_text"><?php echo constant("INDEX_USER_NAME");?></td>
                            <td align="left" valign="middle" class="textboxbg">
							<input name="uname" type="text" class="textfield" id="uname" size="45" value="<?php echo $username;?>" /></td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="login_text"><?php echo constant("INDEX_PASSWORD");?></td>
                            <td align="left" valign="middle" class="textboxbg">
                            <input name="password" type="password" class="textfield" id="password" value="<?php echo $password;?>" size="45" /></td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="login_text"><?php echo constant("INDEX_LANG");?></td>
                            <td align="left" valign="middle">
							 <select name="lang" id="lang" class="combo" onChange="javascript:document.frm.action='index.php',document.frm.submit();">
								<option value="EN" <?php if(isset($_REQUEST["lang"])=="EN") {?> selected="selected" <?php } ?>>English - الإنجليزية</option>
								<option value="AR" <?php if(isset($_REQUEST["lang"])=="AR") {?> selected="selected" <?php } ?>>Arabic - العربية</option>
							  </select>							
                              </td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="top"><input type="image" src="images/login-btn.jpg" alt="login-btn" width="94" height="40" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="middle">
                            <table width="275" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="center" valign="middle" class="forgotbg" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;font-weight:bold;"><a href="forgot_password.php?page=forgot_password.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("INDEX_FORGOT");?></a></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                        <td width="218" align="center" valign="middle"><img src="images/pencil-img.png" alt="pencil-img" width="218" height="186" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/login-bottom.png" alt="login-bottom" width="548" height="14" /></td>
                  </tr>
                </table></td>
                <td align="left" valign="top"><img src="images/st-img.png" alt="student-img" width="233" height="256" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="footer"><span class="footertext1">Copyright &copy; <?php echo date("Y");?> Berlitz AlAhsa, a Dar  Al-Khibra Human Resources Development Company. All Rights Reserved.</span></td>
  </tr>
</table>
<?php } else { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
  	<?php
    if($_REQUEST["lang"]=='' || $_REQUEST["lang"] == 'EN'){
		$logo = "logo/logo.png";
	}else{
		$logo = "logo/logo-ar.png";
	}
	?>
    <td height="50" align="right" valign="middle" style="padding-left:5px; padding-top:25px;"><img src="<?php echo $logo;?>" alt="logo" style="padding:0px; margin:0px;" /></td>
  </tr>
  <tr>
    <td height="104">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="1008" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="479" align="center" valign="top" class="loginbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="896">&nbsp;</td>
            <td width="94">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="middle" dir="rtl" style=" font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:24px; color:#1C449C;">مرحبا بكم في الأحساء بيرلتز</td>
            <td height="40" align="right" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="205" align="center" valign="top"><img src="images/st-img.png" alt="student-img" width="233" height="256" /></td>
                <td width="552" align="left" valign="top"><table width="552" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <?php
                  if($_SESSION["lang"]=='EN'){
                        $hh = "loginheading";
                    }else{
                        $hh = "loginheading_ar";
                    }
					//echo $_SESSION[lang];
					?>
                    <td align="right" valign="middle" class="login-top-bg"><span class="<?php echo $hh;?>"> <?php echo constant("INDEX_LOGIN");?></span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top" background="images/login-mid-bg.png" class="login-mid-bg"><table width="515" border="0" cellspacing="0" cellpadding="0">
                      <?php if($_REQUEST["msg"]=="denied") { ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td width="240" align="right" valign="middle"><table width="240" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#996633;">
                          <tr>
                            <td width="83%" align="right" valign="middle" bgcolor="#FEFCDA" class="activemenutext"><?php echo $Arabic->en2ar('Access denied');?></td>
                            <td width="11%" align="center" valign="middle" bgcolor="#FEFCDA"><img src="images/block.png" width="16" height="16" /></td>
                            <td width="6%" height="25" bgcolor="#FEFCDA">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php } ?>
                      <?php if($_REQUEST["msg"]=="fail") { ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td width="240" align="right" valign="middle"><table width="240" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#996633;">
                          <tr>
                            <td width="84%" align="right" valign="middle" bgcolor="#F9DFE1" class="activemenutext"><?php echo $Arabic->en2ar('Invalid user name or password');?></td>
                            <td width="10%" align="center" valign="middle" bgcolor="#F9DFE1"><img src="images/block.png" width="16" height="16" /></td>
                            <td width="6%" height="25" bgcolor="#F9DFE1">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td align="left" valign="top"><img src="images/pencil-img.png" alt="pencil-img" width="218" height="186" /></td>
                        <td colspan="2" align="left" valign="top"><table width="297" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td width="87" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle" class="textboxbg">
                            <input name="uname" type="text" class="textfield" id="uname" size="45" style="text-align:right;" value="<?php echo $username;?>" />
                              &nbsp;&nbsp; </td>
                            <td align="left" valign="middle" class="login_text">: <?php echo constant("INDEX_USER_NAME");?></td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2"></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle" class="textboxbg"><input name="password" type="password" class="textfield" id="password" style="text-align:right;" value="<?php echo $password;?>" size="45" />
                              &nbsp;&nbsp; </td>
                            <td align="left" valign="middle" class="login_text">: <?php echo constant("INDEX_PASSWORD");?></td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2"></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle" style="padding-right:3px;"><select name="lang2" dir="rtl" id="lang2" class="combo" onChange="javascript:document.frm.action='index.php',document.frm.submit();">
                              <option value="EN" <?php if($_REQUEST["lang"]=="EN") {?> selected="selected" <?php } ?>>English - الإنجليزية</option>
                              <option value="AR" <?php if($_REQUEST["lang"]=="AR") {?> selected="selected" <?php } ?>>Arabic - العربية</option>
                            </select></td>
                            <td align="left" valign="middle" class="login_text">: <?php echo constant("INDEX_LANG");?></td>
                          </tr>
                          <tr>
                            <td height="5" colspan="2"></td>
                          </tr>
                          <tr>
                            <td align="right" valign="top" style="direction:rtl;"><input type="submit" name="button" class="loginbtn" id="button" value="دخول" style="width:94px;"></td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right" valign="middle"><table width="275" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="center" valign="middle"><a href="forgot_password.php?page=forgot_password.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("INDEX_FORGOT");?>
                                  
                                </a></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="218">&nbsp;</td>
                        <td width="240">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/login-bottom.png" alt="login-bottom" width="548" height="14" /></td>
                  </tr>
                </table></td>
                <td width="205" align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include 'footer.php';?>
</table>
</table>
<?php } ?>
</form>
</body>
</html>
