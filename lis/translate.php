<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
	{
		header("Location:../index.php");
		exit;
	}
}
include_once '../includes/class.Main.php';
//Object initialization
$dbf = new User();

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

include_once '../includes/language.php';

include_once '../includes/class.Main.php';
//Object initialization
$dbf = new User();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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


</head>
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
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'translate_header.php';?></td>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_LANGUAGE_CONVERTER");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp; </td>
                    <td width="8%" align="left"><a href="home.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
              
			  
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                
                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 3px; border-color:#FFCC00;">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" valign="middle">
                    <div id="free-translator">
                    <link rel="stylesheet" href="../arabic_files/free-translator.css">
					<script src="../arabic_files/Translate_002.js"></script>
                    <script src="../arabic_files/Translate.js"></script>
                    <script type="text/javascript" src="../arabic_files/jsapi"></script>
                    <script src="../arabic_files/ga.js" async="" type="text/javascript"></script>
                    
                    <script type="text/javascript" src="../arabic_files/free-translator.js"></script>
                    <script src="../arabic_files/a" type="text/javascript"></script>
                    <script src="../arabic_files/defaulten_GB.js" type="text/javascript"></script>
                    <p><strong><?php echo constant("STUDENT_ADVISOR_TRANSLATE_TXTT1");?>:</strong></p>
                    <p class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_TXTT2");?></p>
                    <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">
                    <input id="lang_name" value="Arabic" type="hidden">
                    <textarea id="txt_src" cols="50" name="txt_src" rows="5" onkeyup="detectLanguage(); return false;" style="border:solid 2px; border-color:#CCCCCC;"></textarea>
                                <p style="display: block;" id="txt_dst" class="textarea"></p>
                                <div>
                                    <div>
                                        <label for="src" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_FROM");?>:</label>
                                        <select id="src" name="src">
                                          <option value="en">English</option>
                                            <option value="ar">Arabic</option>
                                      </select>
                                    </div>
                                    <div>
                                        <label for="dst" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_TO");?>:</label>
                                        <select id="dst" name="dst">
                                          <option value="ar">Arabic</option>
                                            <option value="en">English</option>
                                      </select>
                                    </div>
                                </div>
                    <a id="swap" href="#" title="Swap To / From Languages" onclick="swap(); return false;">Swap To / From Languages</a>
                   <div style="padding-left:30px;"><a id="translate-free" href="#" title="Get this text translated by machine for free." onclick="googleGetTranslation();return false;" class="free-translator-button"><?php echo constant("ADMIN_TRANSLATE_TRANSL");?></a></div>
                    <script type="text/javascript">
                        window.onload = function() {
                            $('body').append('<div id="overlay" style="background-color: transparent; background-image: url(arabic_files/overlay.png); display: none; position: absolute; top: 0px; left: 0px; z-index: 101; width: 100%; height: 100%;"><div id="overlay_message" style="background-color: #FFFFFF; position: absolute; width: 370px; border: #D2D2D2 3px solid; padding: 5px;"><p id="overlay_message_inner" style="text-align: center;">Processing your translation request...</p><p style="text-align: center;"><img alt="Loading..." src="arabic_files/processing.gif" /></p></div></div>'); 
                        };
                    </script>
                    <input name="text" value="" type="hidden">
                    <input name="source_language" value="Arabic" type="hidden">
                    <input name="target_language" value="English" type="hidden">
                    <input name="step" value="2" type="hidden">
                    </form>
                </div>
                    </td>
                    </tr>
                
                <script src="../arabic_files/jquery.js"></script>
                <script>window.jQuery || document.write("<script src='//scripts.translation-services-usa.com/general/jquery.min.js'>\x3C/script>")</script>
                <script src="../arabic_files/script.js"></script>
                <script src="../arabic_files/subpage.js"></script>
                <script gapi_processed="true" src="../arabic_files/plusone.js"></script>
                <script type="text/javascript">
                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', 'UA-2355965-12']);
                    _gaq.push(['_setDomainName', '.translation-services-usa.com']);
                    _gaq.push(['_trackPageview']);
                    (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                    })();
                </script>                
                </table>                
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
</body>
</html>
