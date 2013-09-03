<?php
ob_start();
session_start();

include_once 'includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once 'includes/language.php';

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$page = $parts[count($parts) - 1];
$ext = substr($page,-4);
$page = str_replace($ext,"",$page);
$page_name = str_replace($ext,"",$page).'.php';
$page = str_replace("selfservice","",$page);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="sa/glowtabs.css" rel="stylesheet" type="text/css" />

<body>
<?php if($_SESSION['lang']=='EN'){?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="50" align="left" valign="middle" style="padding-left:5px; padding-top:25px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
      <tr>
        <td height="46" align="left" valign="top" background="images/title.png" >
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><img src="logo/logo.png" alt="logo" style="padding:0px; margin:0px;" /></td>
            <td>&nbsp;</td>
            <td align="right" valign="middle" style="padding-left:250px;">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <?php
		  if($_REQUEST["centre_id"] == ""){
			  $centre_id = $page;
			  $centre = $dbf->getDataFromTable("centre","name","cen_no='$centre_id'");
		  }else{
			  $centre_id = base64_decode(base64_decode($_REQUEST["centre_id"]));
		  }
		  $centre = $dbf->getDataFromTable("centre","name","id='$centre_id'");
		  ?>
          <tr>
            <td width="41%" align="left">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="47%" align="left" valign="middle" style="padding-left:50px;" class="heading"><?php echo ucwords($centre);?></td>
            <td width="2%" align="left" valign="middle">&nbsp;</td>
            <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page_name;?>"><img src="images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
            <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page_name;?>"><img src="images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
          </tr>
        </table>
        
        </td>
      </tr>
  
</table>
    
    </td>
  </tr>
  
  <tr>
    <td height="104" align="center" valign="middle" class="heading"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td align="left" valign="top" ><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td align="center" valign="top">
				<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo CONGRATULATION ?></span></td>
                        <td width="15" align="right" valign="top"><img src="images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB"><table width="70%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>&nbsp;</td>
                            <td height="50" align="left" valign="bottom" class="heading">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="8%">&nbsp;</td>
                            <td width="92%" align="left" valign="bottom" class="heading"><?php echo CONGRATULATION ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="pedtext">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="pedtext"><?php echo CONGRATULATION_MSG ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="pedtext">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="pedtext">Click <a href="<?php echo $_REQUEST["reg_page_name"];?>">here</a> to Register another student for this centre.</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="100" class="pedtext">&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                </td>
              </tr>
            </table></td>
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
<?php }else{ ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="50" align="left" valign="middle" style="padding-left:5px; padding-top:25px;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
      <tr>
        <td height="46" align="left" valign="top" background="images/title.png" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right" valign="middle" style="padding-left:250px;">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="right" valign="middle"><img src="logo/logo-ar.png" alt="logo" style="padding:0px; margin:0px;" /></td>
          </tr>
          <?php
		  if($_REQUEST["centre_id"] == ""){
			  $centre_id = $page;
			  $centre = $dbf->getDataFromTable("centre","name","cen_no='$centre_id'");
		  }else{
			  $centre_id = base64_decode(base64_decode($_REQUEST["centre_id"]));
		  }
		  $centre = $dbf->getDataFromTable("centre","name","id='$centre_id'");
		  ?>
          <tr>
            <td width="4%" align="right" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page_name;?>&centre_id=<?php echo $_REQUEST["center_id"];?>"><img src="images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
            <td width="4%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page_name;?>&centre_id=<?php echo $_REQUEST["center_id"];?>"><img src="images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
            <td width="45%" align="right" valign="middle" style="padding-left:50px;" class="heading"><?php echo ucwords($centre);?></td>
            <td width="6%" align="left" valign="middle">&nbsp;</td>
            <td width="5%" align="center" valign="middle"></td>
            <td width="36%" align="left" valign="middle"></td>
          </tr>
        </table>
        
        
        </td>
      </tr>
  
</table>
    
    </td>
  </tr>  
  <tr>
    <td height="104" align="center" valign="middle" class="heading"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" class="loginbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td align="left" valign="top" ><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td align="center" valign="top">
				<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(images/left_mid_bg.png) repeat-x;"><span class="logintext">
                        <?php echo CONGRATULATION ?></span></td>
                        <td width="15" align="right" valign="top"><img src="images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">
                    <table width="70%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td height="50" align="left" valign="bottom" class="heading">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="92%" align="right" valign="middle" class="heading"><?php echo CONGRATULATION ?></td>
                    <td width="8%" align="left" valign="bottom" class="heading"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" class="pedtext"><?php echo CONGRATULATION_MSG ?></td>
                    <td class="pedtext"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" class="pedtext"><?php echo CONGRATULATION_CLICK ?> <a href="<?php echo $_REQUEST["reg_page_name"];?>"><?php echo CONGRATULATION_HERE ?></a> <?php echo CONGRATULATION_LOGIN ?>&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="100" class="pedtext">&nbsp;</td>
                  </tr>
                </table>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                </td>
              </tr>
            </table></td>
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
<?php } ?>
</body>
</html>