<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>
<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>		
		
<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()
});

// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
function validate2fields(){
	if($("#firstname").val() =="" ||  $("#lastname").val() == ""){
		return false;
	}else{
		return true;
	}
}

function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->
<script type="text/javascript">
function showtextbox(){
	 if(document.getElementById('trcomment').style.display == 'none'){
		 document.getElementById('trcomment').style.display = '';
	 }else if(document.getElementById('trcomment').style.display == ''){
		 document.getElementById('trcomment').style.display = 'none';
	 }
}
 
function gotfocus(){
  document.getElementById('txt_src').focus();
}

function show_firstname(input, output){
	var ajaxRequest;  // The variable that makes Ajax possible!	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			document.getElementById(output).value="---";
		}
		if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById(output).value=c;	
		}
	}
	var tno = document.getElementById(input).value;
	ajaxRequest.open("GET", "s_classic_firstname.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}

function get_interest_group(){

	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lbl_show_group').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById('lbl_show_group').innerHTML=c;
		}
	}

	var course_id = '';
	
	// Get interest course id
	var i_count = document.getElementById('count').value;
	for(k = 1; k <= i_count; k++){
		
		var c_id = "course"+k;
		if(document.getElementById(c_id).checked == true){
			if(course_id == ''){
				course_id = document.getElementById(c_id).value;
			}else{
				course_id = course_id + ',' + document.getElementById(c_id).value;
			}
		}
	}
	ajaxRequest.open("GET", "s_classic_group.php" + "?course_id=" + course_id, true);
	ajaxRequest.send(null); 
}
</script>
<style>
.mytext{border:solid 1px; background-color:#ECF1FF; border-color:#999999;}
.mycombo {background-color:#ECF1FF;width:192px; border:solid 1px; border-color:#999999;}
</style>
</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function ageinfo()
{
	var age=$("#age").val();
	if(age <= 16)
	{

		document.getElementById('gender').style.display='none';
		document.getElementById('parentid').style.display='';
	}
	else if(age > 16)
	{
		document.getElementById('gender').style.display='';
		document.getElementById('parentid').style.display='none';
	}
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

function get_arabic(){
	document.getElementById('ar_mytxt_src').value = document.getElementById('t4').value;
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                <table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_HEADINGTXT");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"><a href="home.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="add") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_ADDMSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="idexist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_EXITMSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <?php if($_REQUEST[msg]=="emailexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("EMAIL_EXIST");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
			   <?php if($_REQUEST[msg]=="invalid") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INVALIDMSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="mexist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBMSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                 
				  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("QUICK_ADD");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <div id="free-translator" style="background-color:#EBEBEB;">
                        <link rel="stylesheet" href="arabic_files/free-translator.css">
                        <script src="arabic_files/Translate_002.js"></script>
						<script src="arabic_files/Translate.js"></script>
                        <script type="text/javascript" src="arabic_files/jsapi"></script>
                        <script src="arabic_files/ga.js" async="" type="text/javascript"></script>
                        
                        <?php if($_REQUEST[textlang]=="en" || $_REQUEST[textlang]=="") { ?>
                        <script type="text/javascript" src="arabic_files/free-translator-quick.js"></script>
                        <?php } else { ?>
                        <script type="text/javascript" src="arabic_files/free-translator_ar-quick.js"></script>
                        <?php } ?>
                        <script src="arabic_files/a" type="text/javascript"></script>
                        <script src="arabic_files/defaulten_GB.js" type="text/javascript"></script>
                        
                        <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">
                    	<input id="lang_name" value="Arabic" type="hidden">
                    
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="100%" colspan="5" align="left" valign="middle" id="lbljs"></td>
                          </tr>
                          <tr>
                            <td colspan="5" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="left" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>
                                <td align="left" valign="middle">&nbsp;</td>
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
                            <td height="10" colspan="5" align="right" valign="middle" class="leftmenu"><table width="715" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="41" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                <td width="179" height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ENGNAME");?></td>
                                <td width="169">&nbsp;</td>
                                <td width="158">&nbsp;</td>
                                <td width="168">&nbsp;</td>
                                </tr>
                              <script language="javascript" type="text/javascript">
							  function setvalue(ctrl, val){
								  document.getElementById(ctrl).value = val;
							  }
							  </script>
                              <tr>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td height="28" align="left" valign="middle">
                                  <input name="txt_src" type="text" class="new_textbox140" id="txt_src" value="<?php echo $_SESSION[classic_name];?>" onblur="setvalue('mytxt_src',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src1" type="text" class="new_textbox140" id="txt_src1" value="<?php echo $_SESSION[classic_fathername];?>" onblur="setvalue('mytxt_src1',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src2" type="text" class="new_textbox140" id="txt_src2" value="<?php echo $_SESSION[classic_gfathername];?>" onblur="setvalue('mytxt_src2',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src3" type="text" class="new_textbox140" id="txt_src3" value="<?php echo $_SESSION[classic_familyname];?>" onblur="setvalue('mytxt_src3',this.value);"/></td>
                                </tr>
                              <tr class="shop2">
                                <td align="left" valign="top" class="shop2">&nbsp;</td>
                                <td height="20" align="left" valign="top" class="shop2"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                </tr>
                              <tr>
                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ARABICNAME");?></td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                </tr>
                              <tr>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td height="28" align="left" valign="middle">
                                  <input name="t1" type="text" class="new_textbox140" id="t1" value="<?php echo $_SESSION[classic_name1];?>" onBlur="checkTab('t1');"/></td>
                                <td align="left" valign="middle">
                                  <input name="t2" type="text" class="new_textbox140" id="t2" value="<?php echo $_SESSION[classic_fathername1];?>" onBlur="checkTab('t2');"/></td>
                                <td align="left" valign="middle">
                                  <input name="t3" type="text" class="new_textbox140" id="t3" value="<?php echo $_SESSION[classic_gfathername1];?>" onBlur="checkTab('t3');"/></td>
                                <td align="left" valign="middle">
                                  <input name="t4" type="text" class="new_textbox140" id="t4" value="<?php echo $_SESSION[classic_familyname1];?>" onBlur="checkTab('t4');"/></td>
                                </tr>
                              <tr class="shop2">
                                <td align="left" valign="top">&nbsp;</td>
                                <td height="20" align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                <td align="left" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                </tr>
                              </table></td>
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
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
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
							if(document.getElementById('t1').value == ''){
								document.getElementById('t1').focus();
								return false;
							}
							if(document.getElementById('t4').value == ''){
								document.getElementById('t4').focus();
								return false;
							}
							if(document.getElementById('age').value == '' || document.getElementById('age').value == '0'){
								document.getElementById('age').focus();
								return false;
							}
							if(document.getElementById('email').value == ''){
								document.getElementById('email').focus();
								return false;
							}
							if(document.getElementById('id_typen').checked == true){
								alert(document.getElementById('sidn').value);
								if(document.getElementById('sidn').value == ''){									
									document.getElementById('sidn').focus();
									return false;
								}
							}							
						}
						</script>
                        <form action="s_process.php?action=classic" name="frm" method="post" id="frm" enctype="multipart/form-data" onsubmit="return checkid();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="7%">&nbsp;</td>
                              <td width="35%">
                                <input name="mytxt_src" type="hidden" id="mytxt_src"/>
                                <input name="mytxt_src1" type="hidden" id="mytxt_src1"/>
                                <input name="mytxt_src2" type="hidden" id="mytxt_src2"/>
                                <input name="mytxt_src3" type="hidden" id="mytxt_src3"/>
                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src"/>
                              </td>
                              <td width="1%">&nbsp;</td>
                              <td width="53%">&nbsp;</td>
                              <td width="4%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NATIONALITY");?> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                                <select name="country" id="country" class="mycombo">
                                  <option value="">--- Select Country ---</option>
                                  <?php
								$cid = "189";
								foreach($dbf->fetchOrder('countries',"","") as $resc) {
								?>
                                  <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                  <?php } ?>
                                  </select></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" class="mycon">&nbsp;<input name="age" type="text" class="validate[required] new_textbox40" id="age" value="<?php echo $_SESSION[classic_age];?>" maxlength="2" autocomplete="off" onKeyPress="return isNumberKey(event);" onKeyUp="ageinfo();" onfocus="get_arabic();"></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                          <td colspan="4" align="left">
                          <?php
						    if($_SESSION[gender]!='' && ($_SESSION[age] > 16)){
								$dis = "";
							}else{
								$dis = "none";
							}
						  ?>
                          <div id="gender" style="display:<?php echo $dis; ?>"> 
                          <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            
                            <td width="206" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?>:</td>
                            <td>&nbsp;</td>
                            <td width="294" align="left" valign="middle" class="leftmenu"><?php
							$v = $_SESSION[gender];
							if($v == ''){ $v = 'male'; }
							?>
                              <input name="gender" type="radio" id="gender3" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                              <input type="radio" name="gender" id="gender3" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>                           
                          </tr>
                          </table>
                          </div>
                          </td>
                          </tr>
                          <tr>
                          <td colspan="4" align="left">
                          <?php
						    if($_SESSION[gname]!='' && ($_SESSION[age] <= 16)){
								$dis1="";
							}else{
								$dis1="none";
							}

						  ?>
                          <div id="parentid" style="display:<?php echo $dis1;?>">
                          <table width="617" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?> &nbsp;:</td>
                            <td width="10" align="left" valign="middle">&nbsp;</td>
                            <td width="340" align="left" valign="middle"><span class="leftmenu">
                              <?php
							$v = $_SESSION[gender1];
							if($v == ''){ $v = 'male'; }
							?>
                              <input name="gender1" type="radio" id="gender4" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                              <input type="radio" name="gender1" id="gender4" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></span></td>
                          </tr>
                          <tr>
                            <td width="267" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?> :<span class="nametext1">*</span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle"><span class="leftmenu">
                              <input name="gname" type="text" class="validate[required] new_textbox190" id="gname" value="<?php echo $_SESSION[classic_gname];?>"/>
                            </span></td>
                          </tr>
                          <tr>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTSCONTACT");?> :<span class="nametext1">*</span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle"><span class="leftmenu">
                              <input name="pcontact" type="text" class="validate[required] new_textbox190" id="pcontact" value="<?php echo $_SESSION[pcontact];?>"/>
                            </span></td>
                          </tr>
                          <tr>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_TEXT");?> :</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle"><span class="leftmenu">
                              <input name="information" type="text" class="new_textbox190" id="information" value="<?php echo $_SESSION[information];?>"/>
                            </span></td>
                          </tr>
                          </table>
                          </div>
                          </td>
                          </tr>
                          <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ID_TYPE");?> :&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              
                              <table width="99%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="5%" align="left" valign="middle" class="hometest_name">
                                <input name="id_type" type="radio" id="id_typen" value="National ID" <?php if($v == "National ID") { ?> checked="checked" <?php } ?>></td>
                                <td width="34%" align="left" valign="middle" class="mycon">
								<?php echo constant("NATIONAL_ID_IQAMA");?></td>
                                <td width="5%" align="left" valign="middle" class="hometest_name">
                                <input type="radio" name="id_type" id="id_typep" value="Passport" <?php if($v != "National ID") { ?> checked="checked" <?php } ?>></td>
                                <td width="56%" align="left" valign="middle" class="mycon"><?php echo constant("PASSPORT");?></td>
                              </tr>
                            </table>
                              
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_IDNUMB");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input name="sidn" type="text" class="validate[required] new_textbox190" id="sidn" size="45" minlength="4" onkeypress="return PhoneNo(event);" value="<?php echo $_SESSION[classic_sidn];?>"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="mobile" value="009665" type="text" class="validate[required] new_textbox190" id="mobile" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L9");?> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input name="altmobile" type="text" class="new_textbox190" value="009665" id="altmobile" size="45" minlength="4" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_EMAILADDRESS");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox190" id="email" value="<?php echo $_SESSION[classic_email];?>" onfocus="get_arabic();"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_11"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INTERESTIN");?> </label>
                                <span> </span>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  
                            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                                  <?php
							$i = 1;
							foreach($dbf->fetchOrder('course',"","") as $valc) {							
							$n=$dbf->countRows('student_course',"student_id='$student_id' AND course_id='$valc[id]'");							
							?>
                                  <tr>
                                    <td width="6%" align="left" valign="middle">
                                    <input name="course<?php echo $i;?>" id="course<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" onchange="get_interest_group();" >
                                    </td>
                                    <td width="94%" align="left" valign="middle" class="mycon"><?php echo $valc["name"];?></td>
                                  </tr>
                                  <?php
							$i = $i + 1;
							}
							?>
                                </table>							
							
							<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>"></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr style="display:none;">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_COMMENTS");?> </label>
                                :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                              <td>&nbsp;</td>
                            </tr>
							 <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="button" value="<?php echo constant("btn_new_comments");?>" class="btn1" border="0" align="left" onclick="showtextbox();"/></td>
                              <td>&nbsp;</td>
                             </tr> 
							 <tr id="trcomment" style="display:none">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NOWCOMMENTS");?></label>
                                :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <textarea name="newcomment" id="newcomment" rows="5" cols="40" class="mytext"></textarea></td>
                              <td>&nbsp;</td>
                             </tr> 
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?></label></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="top">
                              
							  <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                                 <?php
							$i1 = 1;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) {							
							?> 
                                  <tr>
                                    <td width="6%" align="left" valign="middle">
                                    <input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>" >
                                    </td>
                                    <td width="94%" align="left" valign="middle" class="mycon"><?php echo $valc["name"];?></td>
                                  </tr>
                                  <?php
							$i1 = $i1 + 1;
							}
							?>
                                </table>
							
							<input type="hidden" name="leadcount" id="leadcount" value="<?php echo $i1-1;?>"></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="5" align="left" valign="middle" class="leftmenu"></td>
                              <td height="5" align="right" valign="top" class="leftmenu"></td>
                              <td height="5"></td>
                              <td height="5" align="left" valign="top" bgcolor="#CCCCCC"></td>
                              <td height="5"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("TYPE_OF_STUDENTS");?></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="top">
                              
                                <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                                 <?php
								$t = 1;
								foreach($dbf->fetchOrder('common',"type='Type'","") as $valt){
								?> 
                                  <tr>
                                    <td width="6%" align="left" valign="middle">
                                    <input name="type<?php echo $t;?>" id="type<?php echo $t;?>" type="checkbox" value="<?php echo $valt["id"];?>">
                                    </td>
                                    <td width="94%" align="left" valign="middle" class="mycon"><?php echo $valt["name"];?></td>
                                  </tr>
                                  <?php
								$t = $t + 1;
								}
								?>
                                </table>
								
								<input type="hidden" name="tcount" id="tcount" value="<?php echo $t-1;?>">
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STDPHOTO");?> : </td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle"><input type="file" name="signature" id="signature" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <?php
							$select_first_value = constant("SELECT_GROUP");					
							?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?> : </td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle" id="lbl_show_group">
                              <select name="group" class="combo" id="group" style="width:370px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" >
                                <option value=""><?php echo $select_first_value;?></option>
                                <?php
							foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And course_id in (".$interest_course.")","") as $res_g) {
							  ?>
                                <option value="<?php echo $res_g['id']?>"><?php echo $res_g['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_g['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_g['end_date'])) ?>,  <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></option>
                                </option>
                                <?php }?>
                                </select>
                              </td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" /></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>
                      </form>
                        
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
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                        <table width="100%" border="0" cellspacing="0">
                          <tr>
                            <td width="8%" align="left"><a href="home.php"> 
                              <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                            <td width="22%">&nbsp;</td>
                            <td width="8%" align="left">&nbsp;</td>
                            <td width="8%" align="left">&nbsp;</td>
                            
                              <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_HEADINGTXT");?></td>
                            </tr>
                          </table></td>
                      </tr>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="exist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="add") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_ADDMSG");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="idexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_EXITMSG");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="invalid") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INVALIDMSG");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="mexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBMSG");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("QUICK_ADD");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top">
                    <div id="free-translator" style="background-color:#EBEBEB;">
                        <link rel="stylesheet" href="arabic_files/free-translator.css">
                        <script src="arabic_files/Translate_002.js"></script>
						<script src="arabic_files/Translate.js"></script>
                        <script type="text/javascript" src="arabic_files/jsapi"></script>
                        <script src="arabic_files/ga.js" async="" type="text/javascript"></script>
                        
                        <?php if($_REQUEST[textlang]=="en" || $_REQUEST[textlang]=="") { ?>
                        <script type="text/javascript" src="arabic_files/free-translator-quick.js"></script>
                        <?php } else { ?>
                        <script type="text/javascript" src="arabic_files/free-translator_ar-quick.js"></script>
                        <?php } ?>
                        <script src="arabic_files/a" type="text/javascript"></script>
                        <script src="arabic_files/defaulten_GB.js" type="text/javascript"></script>
                        
                        <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">
                    	<input id="lang_name" value="Arabic" type="hidden">
                    
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="100%" colspan="5" align="left" valign="middle" id="lbljs"></td>
                          </tr>
                          <tr>
                            <td colspan="5" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="right" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>
                                <td align="left" valign="middle">&nbsp;</td>
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
                            <td height="10" colspan="5" align="right" valign="middle" class="leftmenu"><table width="715" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="41" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                <td width="179" height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ENGNAME");?></td>
                                <td width="169">&nbsp;</td>
                                <td width="158">&nbsp;</td>
                                <td width="168">&nbsp;</td>
                                </tr>
                              <script language="javascript" type="text/javascript">
							  function setvalue(ctrl, val){
								  document.getElementById(ctrl).value = val;
							  }
							  </script>
                              <tr>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td height="28" align="right" valign="middle">
                                  <input name="txt_src" type="text" class="new_textbox140_ar" id="txt_src" value="<?php echo $_SESSION[classic_name];?>" onblur="setvalue('mytxt_src',this.value);"/></td>
                                <td align="right" valign="middle">
                                  <input name="txt_src1" type="text" class="new_textbox140_ar" id="txt_src1" value="<?php echo $_SESSION[classic_fathername];?>" onblur="setvalue('mytxt_src1',this.value);"/></td>
                                <td align="right" valign="middle">
                                  <input name="txt_src2" type="text" class="new_textbox140_ar" id="txt_src2" value="<?php echo $_SESSION[classic_gfathername];?>" onblur="setvalue('mytxt_src2',this.value);"/></td>
                                <td align="center" valign="middle">
                                  <input name="txt_src3" type="text" class="new_textbox140_ar" id="txt_src3" value="<?php echo $_SESSION[classic_familyname];?>" onblur="setvalue('mytxt_src3',this.value);"/></td>
                                </tr>
                              <tr class="shop2">
                                <td align="left" valign="top" class="shop2">&nbsp;</td>
                                <td height="20" align="right" valign="top" class="shop2"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                <td align="center" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                </tr>
                              <tr>
                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                <td align="left" valign="middle" class="leftmenu">
                                                                    
                                  </td>
                                <td height="40" colspan="2" align="center" valign="middle">
                                  <a id="translate-free" href="#" title="Get this text translated by machine for free." onClick="googleGetTranslation();return false;" class="free-translator-button"><?php echo constant("LANGUAGE_TRANSLATE");?></a>
                                  <script type="text/javascript">
									window.onload = function() {
										$('body').append('<div id="overlay" style="background-color: transparent; background-image: url(arabic_files/overlay.png); display: none; position: absolute; top: 0px; left: 0px; z-index: 101; width: 100%; height: 100%;"><div id="overlay_message" style="background-color: #FFFFFF; position: absolute; width: 370px; border: #D2D2D2 3px solid; padding: 5px;"><p id="overlay_message_inner" style="text-align: center;">Processing your translation request...</p><p style="text-align: center;"><img alt="Loading..." src="arabic_files/processing.gif" /></p></div></div>'); 
									};
								</script>
                                  </td>
                                <td align="center" valign="top">
                                <div style="display:'';">
                                    <div style="width:142px;">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="75%" align="right" valign="middle">
                                            <select id="src" name="src" style="width:100px;" onChange="show_js();">
                                        <option value="en" <?php if($_REQUEST[textlang]=="" || $_REQUEST[textlang]=="en") {?> selected="" <?php } ?>>English</option>
                                        <option value="ar" <?php if($_REQUEST[textlang]=="ar") {?> selected="" <?php } ?>>Arabic</option>                                          
                                        </select>
                                            </td>
                                            <td width="25%" align="left" valign="middle" class="red_smalltext">: <?php echo constant("STUDENT_ADVISOR_TRANSLATE_FROM");?></td>
                                          </tr>
                                        </table>                                      
                                        <label for="src" class="red_smalltext"></label>
                                      </div>
                                    <div style="width:142px;">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="75%" align="right" valign="middle">
                                            <select id="dst" name="dst" style="width:100px;">
                                        <option value="ar">Arabic</option>
                                        <option value="en">English</option>
                                        </select>
                                            </td>
                                            <td width="25%" align="left" valign="middle" class="red_smalltext">: <?php echo constant("STUDENT_ADVISOR_TRANSLATE_TO");?></td>
                                          </tr>
                                        </table>
                                      
                                        <label for="dst" class="red_smalltext"></label>
                                      </div>
                                    </div>
                                </td>
                                </tr>
                              <tr>
                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S1_ARABICNAME");?></td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                </tr>
                              <tr>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td height="28" align="right" valign="middle">
                                  <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $_SESSION[classic_name1];?>" onBlur="checkTab('t1');"/></td>
                                <td align="right" valign="middle">
                                  <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $_SESSION[classic_fathername1];?>" onBlur="checkTab('t2');"/></td>
                                <td align="right" valign="middle">
                                  <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $_SESSION[classic_gfathername1];?>" onBlur="checkTab('t3');"/></td>
                                <td align="center" valign="middle">
                                  <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $_SESSION[classic_familyname1];?>" onBlur="checkTab('t4');"/></td>
                                </tr>
                              <tr class="shop2">
                                <td align="left" valign="top">&nbsp;</td>
                                <td height="20" align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_LASTNAME");?></td>
                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_GRANDFATHERSNAME");?></td>
                                <td align="right" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FATHERNAME");?></td>
                                <td align="center" valign="top"><?php echo constant("STUDENT_ADVISOR_S1_FIRSTNAME");?></td>
                                </tr>
                              </table></td>
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
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
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
							if(document.getElementById('t1').value == ''){
								document.getElementById('t1').focus();
								return false;
							}
							if(document.getElementById('t4').value == ''){
								document.getElementById('t4').focus();
								return false;
							}
							if(document.getElementById('age').value == '' || document.getElementById('age').value == '0'){
								document.getElementById('age').focus();
								return false;
							}
							if(document.getElementById('email').value == ''){
								document.getElementById('email').focus();
								return false;
							}
							if(document.getElementById('id_typen').checked == true){
								alert(document.getElementById('sidn').value);
								if(document.getElementById('sidn').value == ''){									
									document.getElementById('sidn').focus();
									return false;
								}
							}
						}
						</script>
                        <form action="s_process.php?action=classic" name="frm" method="post" id="frm" enctype="multipart/form-data" onsubmit="return chk_age();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="6%">&nbsp;</td>
                              <td width="52%">
                                <input name="mytxt_src" type="hidden" id="mytxt_src"/>
                                <input name="mytxt_src1" type="hidden" id="mytxt_src1"/>
                                <input name="mytxt_src2" type="hidden" id="mytxt_src2"/>
                                <input name="mytxt_src3" type="hidden" id="mytxt_src3"/>
                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src"/>                                
                                </td>
                              <td width="1%">&nbsp;</td>
                              <td width="38%">&nbsp;</td>
                              <td width="3%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle">
                                <select name="country" id="country" class="mycombo">
                                  <option value="">--- Select Country ---</option>
                                  <?php
								$cid = "189";
								foreach($dbf->fetchOrder('countries',"","") as $resc) {
								?>
                                  <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                  <?php } ?>
                                  </select></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NATIONALITY");?></td>                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle" class="mycon">&nbsp;<input name="age" type="text" class="validate[required] new_textbox40_ar" id="age" value="<?php echo $_SESSION[classic_age];?>" maxlength="2" autocomplete="off" onKeyPress="return isNumberKey(event);" onKeyUp="ageinfo();"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                          <td colspan="4" align="left">
                          <?php
						    if($_SESSION[gender]!='' && ($_SESSION[age] > 16)){
								$dis = "";
							}else{
								$dis = "none";
							}
						  ?>
                          <div id="gender" style="display:<?php echo $dis; ?>"> 
                          <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="331" align="right" valign="middle" class="leftmenu"><?php
							$v = $_SESSION[gender];
							if($v == ''){ $v = 'male'; }
							?>
                              <input name="gender" type="radio" id="gender3" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                              <input type="radio" name="gender" id="gender3" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>
                            <td width="10">&nbsp;</td>
                            <td width="166" height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></td>                          </tr>
                          </table>
                          </div>
                          </td>
                          </tr>
                          <tr>
                          <td colspan="4" align="left">
                          <?php
						    if($_SESSION[gname]!='' && ($_SESSION[age] <= 16)){
								$dis1="";
							}else{
								$dis1="none";
							}
						  ?>
                          <div id="parentid" style="display:<?php echo $dis1;?>">
                          <table width="617" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="386" align="right" valign="middle"><span class="leftmenu">
                              <?php
							$v = $_SESSION[gender1];
							if($v == ''){ $v = 'male'; }
							?>
                              <input name="gender1" type="radio" id="gender4" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                              <input type="radio" name="gender1" id="gender4" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></span></td>
                            <td width="10" align="left" valign="middle">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><span class="leftmenu">
                              <input name="gname" type="text" class="validate[required] new_textbox190_ar" id="gname" value="<?php echo $_SESSION[classic_gname];?>"/>
                            </span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td width="225" height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span>: <?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><span class="leftmenu">
                              <input name="pcontact" type="text" class="validate[required] new_textbox190_ar" id="pcontact" value="<?php echo $_SESSION[pcontact];?>"/>
                            </span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTSCONTACT");?></td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><span class="leftmenu">
                              <input name="information" type="text" class="new_textbox190_ar" id="information" value="<?php echo $_SESSION[information];?>"/>
                            </span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S_PARENT_TEXT");?></td>
                          </tr>
                          </table>
                          </div>
                          </td>
                          </tr>
                              <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">
                              
                              <table width="99%" border="0" cellspacing="0" cellpadding="0">
                              <?php
								$g = $_SESSION[id_type];
								if($g == ''){ $g = 'National ID'; }
								?>
                              <tr>
                                <td width="62%" align="right" valign="middle" class="mycon">
								<?php echo constant("NATIONAL_ID_IQAMA");?></td>
                                <td width="6%" align="left" valign="middle" class="hometest_name">
                                <input name="id_type" type="radio" id="id_typen" value="National ID" <?php if($g == "National ID") { ?> checked="checked" <?php } ?>></td>
                                <td width="27%" align="right" valign="middle" class="mycon"><?php echo constant("PASSPORT");?></td>
                                <td width="5%" align="left" valign="middle" class="hometest_name">
                                <input type="radio" name="id_type" id="id_typep" value="Passport" <?php if($g == "Passport") { ?> checked="checked" <?php } ?>></td>
                              </tr>
                              </table>
                              </td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("ID_TYPE");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle">
                              <input name="sidn" type="text" class="validate[required] new_textbox190_ar" id="sidn" size="45" minlength="4" onkeypress="return PhoneNo(event);" value="<?php echo $_SESSION[classic_sidn];?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_IDNUMB");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input name="mobile" value="009665" type="text" class="validate[required] new_textbox190_ar" id="mobile" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle">
                              <input name="altmobile" type="text" class="new_textbox190_ar" value="009665" id="altmobile" size="45" minlength="4" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L9");?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox190_ar" id="email" size="45" minlength="4" value="<?php echo $_SESSION[classic_email];?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_EMAILADDRESS");?></td>
                              <td>&nbsp;</td>
                             </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle">
							  
                            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:right;">
                                 <?php
							$i = 1;
							foreach($dbf->fetchOrder('course',"","") as $valc) {							
							$n=$dbf->countRows('student_course',"student_id='$student_id' AND course_id='$valc[id]'");							
							?> 
                                  <tr>
                                    <td width="94%" align="right" valign="middle" class="mycon"><?php echo $valc["name"];?></td>
                                    <td width="6%" align="right" valign="middle">
                                    <input name="course<?php echo $i;?>" id="course<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" >
                                    </td>
                                  </tr>
                                  <?php
							$i = $i + 1;
							}
							?>
                                </table>							
							
							<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu"><span> </span>:<label class="description" for="element_11"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INTERESTIN");?> </label>
                                </td>
                              
                              <td>&nbsp;</td>
                              </tr>
                            <tr style="display:none;">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"> : <label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_COMMENTS");?> </label></td>
                              <td>&nbsp;</td>
                            </tr>
							 <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input type="button" value="<?php echo constant("btn_new_comments");?>" class="btn2" border="0" align="left" onclick="showtextbox();"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" class="leftmenu">&nbsp;</td>
                              
                              <td>&nbsp;</td>
                             </tr> 
							 <tr id="trcomment" style="display:none">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle">
                              <textarea name="newcomment" id="newcomment" rows="5" cols="40" class="mytext"></textarea></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"> : <label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NOWCOMMENTS");?></label></td>
                              <td>&nbsp;</td>
                             </tr> 
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="top">
                              
							  <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:right;">
                                 <?php
							$i1 = 1;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) {							
							?> 
                                  <tr>
                                    <td width="94%" align="right" valign="middle" class="mycon"><?php echo $valc["name"];?></td>
                                    <td width="6%" align="right" valign="middle">
                                    <input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>" >
                                    </td>
                                  </tr>
                                  <?php
							$i1 = $i1 + 1;
							}
							?>
                                </table>
							
							<input type="hidden" name="leadcount" id="leadcount" value="<?php echo $i1-1;?>"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu">: <label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?></label></td>
                              
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="2" align="left" valign="middle" class="leftmenu"></td>
                              <td height="2" align="right" valign="top" class="leftmenu"></td>
                              <td height="2"></td>
                              <td height="2" align="left" bgcolor="#CCCCCC"></td>
                              <td height="2"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="top">
                              
                                <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:right;">
                                  <?php
								$t = 1;
								foreach($dbf->fetchOrder('common',"type='Type'","") as $valt){
								?>
                                <tr>
                                    <td width="94%" align="right" valign="middle" class="mycon"><?php echo $valt["name"];?></td>
                                    <td width="6%" align="right" valign="middle">
                                    <input name="type<?php echo $t;?>" id="type<?php echo $t;?>" type="checkbox" value="<?php echo $valt["id"];?>">
                                    </td>
                                  </tr>
                                  <?php
								$t = $t + 1;
								}
								?>
                                </table>
								
								<input type="hidden" name="tcount" id="tcount" value="<?php echo $t-1;?>">
                              </td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu">: <?php echo constant("TYPE_OF_STUDENTS");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input type="file" name="signature" id="signature" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STDPHOTO");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle" id="lbl_show_group">
                              <select name="group" id="group" style="width:370px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;text-align:right;" >
                                <option value=""><?php echo constant('SELECT_GROUP');?></option>
                                <?php
							foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And course_id in (".$interest_course.")","") as $res_g) {
							  ?>
                                <option value="<?php echo $res_g['id']?>" <?php if($res_g["id"]==$_SESSION[group]) { echo "Selected"; }?>><?php echo $res_g['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_g['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_g['end_date'])) ?>,  <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></option>
                                </option>
                                <?php }?>
                                </select>
                              </td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                              <td>&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>
                      </form>
                        
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
