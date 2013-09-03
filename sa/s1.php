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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
<script language="javascript" type="text/javascript">
function postvalue(){
	var name = document.getElementById('txt_src').value;
	var name1 = document.getElementById('t4').value;
	
	if(name == ''){
		document.getElementById('txt_src').focus();
		return false;
	}
	if(name1 == ''){
		document.getElementById('t4').focus();
		return false;
	}
	
	var father_name = document.getElementById('txt_src1').value;
	var father_name1 = document.getElementById('t3').value;
	
	var grandfather_name = document.getElementById('txt_src2').value;
	var grandfather_name1 = document.getElementById('t2').value;
	
	var family_name = document.getElementById('txt_src3').value;
	var family_name1 = document.getElementById('t1').value;
	
	window.location.href='s1_process.php?action=stname&ename='+name+'&name1='+name1+'&father_name='+father_name+'&father_name1='+father_name1+'&grandfather_name='+grandfather_name+'&grandfather_name1='+grandfather_name1+'&family_name='+family_name+'&family_name1='+family_name1;
	
}
function checkTab(id){
	if(id=="txt_src3"){
		document.getElementById('t4').focus();
	}
	if(id=="t4"){
		document.getElementById('t3').focus();
	}
	if(id=="t3"){
		document.getElementById('t2').focus();
	}
	if(id=="t2"){
		document.getElementById('t1').focus();
	}
	if(id=="t1"){
		document.getElementById('submit').focus();
	}
}

function gotfocus(){
  document.getElementById('txt_src').focus();
}
function show_js(){
	
	var textlang = document.getElementById('src').value;
	document.location.href='s1.php?textlang='+textlang;	
}
</script>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
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
<?php if($_SESSION[lang]=="EN"){?>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                    <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                  
                  <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_STUDENT_DETAILS");?></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                          <tr>
                            <td align="center" valign="top" bgcolor="#EBEBEB">
                              <div id="free-translator">
                                <link rel="stylesheet" href="arabic_files/free-translator.css">
                                <script src="arabic_files/Translate_002.js"></script>
                                <script src="arabic_files/Translate.js"></script>
                                <script type="text/javascript" src="arabic_files/jsapi"></script>
                                <script src="arabic_files/ga.js" async="" type="text/javascript"></script>
                                
                                <?php if($_REQUEST[textlang]=="en" || $_REQUEST[textlang]=="") { ?>
                                <script type="text/javascript" src="arabic_files/free-translator.js"></script>
                                <?php } else { ?>
                                <script type="text/javascript" src="arabic_files/free-translator_ar.js"></script>
                                <?php } ?>
                                <script src="arabic_files/a" type="text/javascript"></script>
                                <script src="arabic_files/defaulten_GB.js" type="text/javascript"></script>
                                <script type="text/javascript" language="javascript">
								function checkid(){		
									if(document.getElementById('txt_src').value == ''){
										document.getElementById('txt_src').focus();
										return false;
									}
									if(document.getElementById('txt_src3').value == ''){
										document.getElementById('txt_src3').focus();
										return false;
									}
								}
								</script>
                                <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template" onSubmit="return checkid();">
                                  <input id="lang_name" value="Arabic" type="hidden">
                                  
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                      <td colspan="5" align="left" valign="middle" id="lbljs"></td>
                                      </tr>
                                    <tr>
                                      <td colspan="5" align="left" valign="middle" class="shop2">&nbsp;
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td align="left" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>
                                            <td align="left" valign="middle">
                                              
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                                  <td width="55%" align="left" valign="middle" style="padding-left:2px;"><div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                                    <div class="meter-value" style="background-color:#847B7B; width:10%;">
                                                      <div class="meter-text"></div>
                                                      </div>
                                                    </div></td>
                                                  <td width="29%" align="left" valign="middle" class="shop2">10%</td>
                                                  </tr>
                                                </table>
                                              </td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    <tr>
                                      <td height="13" colspan="5" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="10" colspan="5" align="left" valign="middle" class="leftmenu" style="border-top:dotted 1px; border-color:#000000; ">&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="10" colspan="5" align="center" valign="middle" class="leftmenu"><table width="715" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="159" height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ENGNAME");?></td>
                                          <td width="155">&nbsp;</td>
                                          <td width="156">&nbsp;</td>
                                          <td width="145">&nbsp;</td>
                                          </tr>
                                        
                                        <tr>
                                          <td height="28" align="left" valign="middle">
                                            <input name="txt_src" type="text" class="new_textbox140" id="txt_src" value="<?php echo $_SESSION[name];?>"/></td>
                                          <td align="left" valign="middle">
                                            <input name="txt_src1" type="text" class="new_textbox140" id="txt_src1" value="<?php echo $_SESSION[father_name];?>"/></td>
                                          <td align="left" valign="middle">
                                            <input name="txt_src2" type="text" class="new_textbox140" id="txt_src2" value="<?php echo $_SESSION[grandfather_name];?>"/></td>
                                          <td align="left" valign="middle">
                                            <input name="txt_src3" type="text" class="new_textbox140" id="txt_src3" value="<?php echo $_SESSION[family_name];?>" onBlur="checkTab('txt_src3');"/></td>
                                          </tr>
                                        <tr class="shop2">
                                          <td height="20" align="left" valign="top" class="shop2"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="middle" class="leftmenu">
                                            <div style="display:'';">
                                              <div style="width:142px;">
                                                <label for="src" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_FROM");?>:</label>
                                                <select id="src" name="src" style="width:100px;" onChange="show_js();">
                                                  <option value="en" <?php if($_REQUEST[textlang]=="" || $_REQUEST[textlang]=="en") {?> selected="" <?php } ?>>English</option>
                                                  <option value="ar" <?php if($_REQUEST[textlang]=="ar") {?> selected="" <?php } ?>>Arabic</option>                                          
                                                  </select>
                                                </div>
                                              <div style="width:142px;">
                                                <label for="dst" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_TO");?>:</label>
                                                <select id="dst" name="dst" style="width:100px;">
                                                  <option value="ar">Arabic</option>
                                                  <option value="en">English</option>
                                                  </select>
                                                </div>
                                              </div>
                                            
                                            </td>
                                          <td height="40" colspan="2" align="center" valign="middle">
                                            <a id="translate-free" href="#" title="Get this text translated by machine for free." onClick="googleGetTranslation();return false;" class="free-translator-button"><?php echo constant("LANGUAGE_TRANSLATE");?></a>
                                            <script type="text/javascript">
									window.onload = function() {
										$('body').append('<div id="overlay" style="background-color: transparent; background-image: url(arabic_files/overlay.png); display: none; position: absolute; top: 0px; left: 0px; z-index: 101; width: 100%; height: 100%;"><div id="overlay_message" style="background-color: #FFFFFF; position: absolute; width: 370px; border: #D2D2D2 3px solid; padding: 5px;"><p id="overlay_message_inner" style="text-align: center;">Processing your translation request...</p><p style="text-align: center;"><img alt="Loading..." src="arabic_files/processing.gif" /></p></div></div>'); 
									};
								</script>
                                            </td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ARABICNAME");?></td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td height="28" align="left" valign="middle">
                                            <input name="t1" type="text" class="new_textbox140" id="t1" value="<?php echo $_SESSION[family_name1];?>" /></td>
                                          <td align="left" valign="middle">
                                            <input name="t2" type="text" class="new_textbox140" id="t2" value="<?php echo $_SESSION[grandfather_name1];?>" /></td>
                                          <td align="left" valign="middle">
                                            <input name="t3" type="text" class="new_textbox140" id="t3" value="<?php echo $_SESSION[father_name1];?>"/></td>
                                          <td align="left" valign="middle">
                                            <input name="t4" type="text" class="new_textbox140" id="t4" value="<?php echo $_SESSION[name1];?>" /></td>
                                          </tr>
                                        <tr class="shop2">
                                          <td height="20" align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                          <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    <tr>
                                      <td width="11%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td width="25%" height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td width="1%">&nbsp;</td>
                                      <td width="31%" align="left" valign="middle">&nbsp;</td>
                                      <td width="32%">&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="10" colspan="5" align="left" valign="middle"></td>
                                      </tr>
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="25" align="left" valign="middle" class="leftmenu">
                                        <a href="s_age.php">
                                          <input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" />
                                          </a></td>
                                      <td>&nbsp;</td>
                                      <td align="left" valign="middle">&nbsp;</td>
                                      <td align="left"><input type="button" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1" onClick="return postvalue();"//></td>
                                      </tr>
                                    <tr>
                                      <td height="10" colspan="5" align="left" valign="middle"></td>
                                      </tr>
                                    </table>
                                  <input name="text" value="" type="hidden">
                                  <input name="source_language" value="Arabic" type="hidden">
                                  <input name="target_language" value="English" type="hidden">
                                  <input name="step" value="2" type="hidden">
                                  </form>
                                <script src="arabic_files/jquery.js"></script>                
                                <script src="arabic_files/script.js"></script>
                                <script src="arabic_files/subpage.js"></script>
                                <script gapi_processed="true" src="arabic_files/plusone.js"></script>
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
                                </div>
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
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
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
  <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'translate_header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="exist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                          <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_STUDENT_DETAILS");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                                <tr>
                                  <td align="center" valign="top" bgcolor="#EBEBEB">
                                    <div id="free-translator">
                                      <link rel="stylesheet" href="arabic_files/free-translator.css">
                                      <script src="arabic_files/Translate_002.js"></script>
                                      <script src="arabic_files/Translate.js"></script>
                                      <script type="text/javascript" src="arabic_files/jsapi"></script>
                                      <script src="arabic_files/ga.js" async="" type="text/javascript"></script>
                                      
                                      <?php if($_REQUEST[textlang]=="en" || $_REQUEST[textlang]=="") { ?>
                                      <script type="text/javascript" src="arabic_files/free-translator.js"></script>
                                      <?php } else { ?>
                                      <script type="text/javascript" src="arabic_files/free-translator_ar.js"></script>
                                      <?php } ?>
                                      <script src="arabic_files/a" type="text/javascript"></script>
                                      <script src="arabic_files/defaulten_GB.js" type="text/javascript"></script>
                                      
                                      <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">
                                        <input id="lang_name" value="Arabic" type="hidden">
                                        
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                          <tr>
                                            <td colspan="5" align="left" valign="middle" id="lbljs"></td>
                                            </tr>
                                          <tr>
                                            <td colspan="5" align="left" valign="middle" class="shop2">&nbsp;
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  
                                                  <td align="left" valign="middle">
                                                    
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                      <td width="29%" align="right" valign="middle" class="shop2">10%</td>
                                                        
                                                        <td width="55%" align="left" valign="middle" style="padding-left:2px;"><div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                                          <div class="meter-value" style="background-color:#847B7B; width:10%;">
                                                            <div class="meter-text"></div>
                                                            </div>
                                                          </div></td>
                                                        <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                    <td align="right" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          <tr>
                                            <td height="13" colspan="5" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td height="10" colspan="5" align="left" valign="middle" class="leftmenu" style="border-top:dotted 1px; border-color:#000000; ">&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td height="10" colspan="5" align="left" valign="middle" class="leftmenu"><table width="715" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="145">&nbsp;</td>
                                                <td width="155">&nbsp;</td>
                                                <td width="156">&nbsp;</td>
                                                <td width="159" height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ENGNAME");?></td>
                                                </tr>
                                              
                                              <tr>
                                                <td height="28" align="right" valign="middle">
                                                  <input name="txt_src" type="text" class="new_textbox140_ar" id="txt_src" value="<?php echo $_SESSION[name];?>"/></td>
                                                <td align="right" valign="middle">
                                                  <input name="txt_src1" type="text" class="new_textbox140_ar" id="txt_src1" value="<?php echo $_SESSION[father_name];?>"/></td>
                                                <td align="right" valign="middle">
                                                  <input name="txt_src2" type="text" class="new_textbox140_ar" id="txt_src2" value="<?php echo $_SESSION[grandfather_name];?>"/></td>
                                                <td align="center" valign="middle">
                                                  <input name="txt_src3" type="text" class="new_textbox140_ar" id="txt_src3" value="<?php echo $_SESSION[family_name];?>" onBlur="checkTab('txt_src3');"/>&nbsp;</td>
                                                </tr>
                                              <tr class="shop2">
                                                <td height="20" align="right" valign="top" class="shop2"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                                </tr>
                                              <tr>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td height="40" colspan="2" align="center" valign="middle">
                                                  <a id="translate-free" href="#" title="Get this text translated by machine for free." onClick="googleGetTranslation();return false;" class="free-translator-button"><?php echo constant("LANGUAGE_TRANSLATE");?></a>
                                                  <script type="text/javascript">
									window.onload = function() {
										$('body').append('<div id="overlay" style="background-color: transparent; background-image: url(arabic_files/overlay.png); display: none; position: absolute; top: 0px; left: 0px; z-index: 101; width: 100%; height: 100%;"><div id="overlay_message" style="background-color: #FFFFFF; position: absolute; width: 370px; border: #D2D2D2 3px solid; padding: 5px;"><p id="overlay_message_inner" style="text-align: center;">Processing your translation request...</p><p style="text-align: center;"><img alt="Loading..." src="arabic_files/processing.gif" /></p></div></div>'); 
									};
								</script>
                                                  </td>
                                                  <td align="left" valign="middle" class="leftmenu">
                                                  <div style="display:'';">
                                                    <div style="width:142px;">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td width="70%" align="right"><select id="src" name="src" style="width:100px;" onChange="show_js();">
                                                        <option value="en" <?php if($_REQUEST[textlang]=="" || $_REQUEST[textlang]=="en") {?> selected="" <?php } ?>>English</option>
                                                        <option value="ar" <?php if($_REQUEST[textlang]=="ar") {?> selected="" <?php } ?>>Arabic</option>                                          
                                                        </select>&nbsp;</td>
                                                            <td width="30%" align="left" valign="top" class="red_smalltext"> : <?php echo constant("STUDENT_ADVISOR_TRANSLATE_FROM");?></td>
                                                          </tr>
                                                        </table>
                                                      </div>
                                                    <div style="width:142px;">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td width="70%" align="right"><select id="dst" name="dst" style="width:100px;">
                                                        <option value="ar">Arabic</option>
                                                        <option value="en">English</option>
                                                        </select>&nbsp;</td>
                                                            <td width="30%" align="left" valign="top" class="red_smalltext"> : <?php echo constant("STUDENT_ADVISOR_TRANSLATE_TO");?></td>
                                                          </tr>
                                                        </table>
                                                      </div>
                                                    </div>
                                                  
                                                  </td>                                                
                                              </tr>
                                              <tr>
                                                <td align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ARABICNAME");?></td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                </tr>
                                              <tr>
                                                <td height="28" align="right" valign="middle">
                                                  <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $_SESSION[family_name1];?>"/></td>
                                                <td align="right" valign="middle">
                                                  <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $_SESSION[grandfather_name1];?>"/></td>
                                                <td align="right" valign="middle">
                                                  <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $_SESSION[father_name1];?>"/></td>
                                                <td align="center" valign="middle">
                                                  <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $_SESSION[name1];?>"/></td>
                                                </tr>
                                              <tr class="shop2">
                                                <td height="20" align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                                </tr>
                                              </table></td>
                                            </tr>
                                          <tr>
                                            <td width="11%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                            <td width="25%" height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="31%" align="left" valign="middle">&nbsp;</td>
                                            <td width="32%">&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td height="10" colspan="5" align="left" valign="middle"></td>
                                            </tr>
                                          <tr>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                             <td align="left"><input type="button" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2" onClick="return postvalue();"//></td>
                                            <td>&nbsp;</td>
                                            <td align="left" valign="middle">&nbsp;</td>
                                            <td height="25" align="left" valign="middle" class="leftmenu">
                                              <a href="s_age.php">
                                                <input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" />
                                                </a></td>
                                           
                                            </tr>
                                          <tr>
                                            <td height="10" colspan="5" align="left" valign="middle"></td>
                                            </tr>
                                          </table>
                                        <input name="text" value="" type="hidden">
                                        <input name="source_language" value="Arabic" type="hidden">
                                        <input name="target_language" value="English" type="hidden">
                                        <input name="step" value="2" type="hidden">
                                        </form>
                                      <script src="arabic_files/jquery.js"></script>                
                                      <script src="arabic_files/script.js"></script>
                                      <script src="arabic_files/subpage.js"></script>
                                      <script gapi_processed="true" src="arabic_files/plusone.js"></script>
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
                                      </div>
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
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
