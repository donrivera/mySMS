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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
$red_edit_dtls = $dbf->strRecordID("student", "*", "id='$_REQUEST[id]'");
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
	$('#frm').submit(function() 
	{
		var t4=$('input:text[id=t4]').val();
		var t3=$('input:text[id=t3]').val();
		var t2=$('input:text[id=t2]').val();
		var t1=$('input:text[id=t1]').val();
		document.getElementById('ar_mytxt_src').value=t4;
		document.getElementById('ar_mytxt_src1').value=t3;
		document.getElementById('ar_mytxt_src2').value=t2;
		document.getElementById('ar_mytxt_src3').value=t1;
	});
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

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});
</script>
<!--UI JQUERY DATE PICKER-->

<script type="text/javascript">

function show_js(){
	
	var textlang = document.getElementById('src').value;
	//document.location.href='s_classic.php?textlang='+textlang;	
}

function get_arabic(){
	 //$("#t4").html(value);//$("#t4").val();
	//("input[id=ar_mytxt_src]").val(t4);
	//$("#ar_mytxt_src").val("yes");
	//document.getElementById('ar_mytxt_src').value =$('input:text[id=t4]').val();
	//document.getElementById('ar_mytxt_src1').value = $('input:text[id=t1]').val();
	//document.getElementById('ar_mytxt_src2').value = $('input:text[id=t2]').val();
	//document.getElementById('ar_mytxt_src3').value = $('input:text[id=t3]').val();
}
function get_val()
{
	//alert("TEST");
}
function chk_age(){
	if(document.getElementById('age').value == '' || document.getElementById('age').value == '0'){
		document.getElementById('age').focus();
		return false;
	}
	if(document.getElementById('email').value == ''){
		document.getElementById('email').focus();
		return false;
	}	
}

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
</head>
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
    <td height="104" align="right" valign="top" ><?php include 'header1.php';?></td>
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
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_QUICKADD");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"></td>
                    <td width="8%" align="left"><a href="student_manage.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_EDITSTUDENT");?></span></td>
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
                                  <input name="txt_src" type="text" class="new_textbox140" id="txt_src" value="<?php echo $red_edit_dtls["first_name"];?>" onblur="setvalue('mytxt_src',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src1" type="text" class="new_textbox140" id="txt_src1" value="<?php echo $red_edit_dtls["father_name"];?>" onblur="setvalue('mytxt_src1',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src2" type="text" class="new_textbox140" id="txt_src2" value="<?php echo $red_edit_dtls["grandfather_name"];?>" onblur="setvalue('mytxt_src2',this.value);"/></td>
                                <td align="left" valign="middle">
                                  <input name="txt_src3" type="text" class="new_textbox140" id="txt_src3" value="<?php echo $red_edit_dtls["family_name"];?>" onblur="setvalue('mytxt_src3',this.value);"/></td>
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
                                  <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $red_edit_dtls["family_name1"];?>"/></td><!--onblur="setvalue('ar_mytxt_src',this.value);"-->
                                <td align="left" valign="middle">
                                  <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $red_edit_dtls["grandfather_name1"];?>"/></td><!-- onblur="setvalue('ar_mytxt_src2',this.value);"-->
                                <td align="left" valign="middle">
                                  <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $red_edit_dtls["father_name1"];?>"/></td><!-- onblur="setvalue('ar_mytxt_src1',this.value);"-->
                                <td align="left" valign="middle">
                                  <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $red_edit_dtls["first_name1"];?>"/></td><!-- onblur="setvalue('ar_mytxt_src',this.value);"-->
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
                        
                        <form action="student_process.php?action=edit" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="7%">&nbsp;</td>
                              <td width="35%">
								<input name="txt_src" type="hidden" id="txt_src" value="<?php echo $red_edit_dtls["first_name"];?>"/>
							    <input name="mytxt_src" type="hidden" id="mytxt_src" value="<?php echo $red_edit_dtls["first_name"];?>"/>
                                <input name="mytxt_src1" type="hidden" id="mytxt_src1" value="<?php echo $red_edit_dtls["father_name"];?>"/>
                                <input name="mytxt_src2" type="hidden" id="mytxt_src2" value="<?php echo $red_edit_dtls["grandfather_name"];?>"/>
                                <input name="mytxt_src3" type="hidden" id="mytxt_src3" value="<?php echo $red_edit_dtls["family_name"];?>"/>
                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src"/>
								<input name="ar_mytxt_src1" type="hidden" id="ar_mytxt_src1"/>
								<input name="ar_mytxt_src2" type="hidden" id="ar_mytxt_src2"/>
								<input name="ar_mytxt_src3" type="hidden" id="ar_mytxt_src3"/>
                                <input name="stud_id" type="hidden" id="stud_id" value="<?php echo $_REQUEST["id"];?>"/>
                                </td>
                              <td width="1%">&nbsp;</td>
                              <td width="53%">&nbsp;</td>
                              <td width="4%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <?php if($red_edit_dtls['student_mobile'] == ''){
								  $mobile = '009665';
							  }else{
								  $mobile = $red_edit_dtls['student_mobile'];
							  }
							  ?>
                              <td align="left" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" onkeypress="return PhoneNo(event);" value="<?php echo $mobile;?>"  autocomplete="off"/></td> <!--onkeyup="show_mobile();" onfocus="get_arabic();"--> 
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_11"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_TEXT");?> </label> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                                
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <?php
							   $i=1;
								foreach($dbf->fetchOrder('common',"type='lead type'","") as $ress) {
									
									$is_exist = $dbf->countRows("student_lead", "student_id='$_REQUEST[id]' And lead_id='$ress[id]'");
							  ?>
                                <tr>
                                  <th width="8%" align="left" valign="middle" scope="col">
                                    <input type="checkbox" name="lead<?php echo $i; ?>" id="lead<?php echo $i;?>" value="<?php echo $ress['id'] ?>" <?php if($is_exist > 0){?> checked="checked" <?php }?> /></th>
                                  <th width="92%" align="left" valign="middle" class="mytext" scope="col"><?php echo $ress['name'] ?></th>
                                  </tr>
                                <?php $i++;}?>
                                <input type="hidden" name="count" id="count" value="<?php echo $i-1; ?>" />
                                </table></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_COMMENTS");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><textarea name="comment" class="validate[required]" id="comment" rows="5" cols="40" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;" onfocus="get_arabic();" ><?php echo $red_edit_dtls["student_comment"];?></textarea></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_APPOINTDT");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="app_date" type="text" class="datepick validate[required] new_textbox190" id="app_date"  readonly="readonly" value="<?php echo $red_edit_dtls['app_date'];?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
							 <tr>
							   <td height="10" colspan="5" align="left" valign="middle"></td>
							   </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
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
                            <td width="8%" align="left"><a href="student_manage.php"> 
                              <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                            <td width="22%">&nbsp;</td>
                            <td width="8%" align="left">&nbsp;</td>
                            <td width="8%" align="left"></td>
                            
                              <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_HEADINGTXT");?></td>
                            </tr>
                          </table></td>
                      </tr>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                    </tr>
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
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_EDITSTUDENT");?></span></td>
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
                                  <input name="txt_src" type="text" class="new_textbox140_ar" id="txt_src" value="<?php echo $red_edit_dtls["first_name"];?>" onblur="setvalue('mytxt_src',this.value);"/></td>
                                <td align="right" valign="middle">
                                  <input name="txt_src1" type="text" class="new_textbox140_ar" id="txt_src1" value="<?php echo $red_edit_dtls["father_name"];?>" onblur="setvalue('mytxt_src1',this.value);"/></td>
                                <td align="right" valign="middle">
                                  <input name="txt_src2" type="text" class="new_textbox140_ar" id="txt_src2" value="<?php echo $red_edit_dtls["grandfather_name"];?>" onblur="setvalue('mytxt_src2',this.value);"/></td>
                                <td align="center" valign="middle">
                                  <input name="txt_src3" type="text" class="new_textbox140_ar" id="txt_src3" value="<?php echo $red_edit_dtls["family_name"];?>" onblur="setvalue('mytxt_src3',this.value);"/></td>
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
                                  <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $red_edit_dtls["family_name1"];?>" onblur="setvalue('ar_mytxt_src',this.value);"/></td>
                                <td align="right" valign="middle">
                                  <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $Arabic->en2ar($red_edit_dtls["grandfather_name"]);?>"/></td>
                                <td align="right" valign="middle">
                                  <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $Arabic->en2ar($red_edit_dtls["father_name"]);?>"/></td>
                                <td align="center" valign="middle">
                                  <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $red_edit_dtls["student_first_name"];?>" /></td>
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
                        <form action="student_process.php?action=edit" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="6%">&nbsp;</td>
                              <td width="52%"><input name="mytxt_src" type="hidden" id="mytxt_src" value="<?php echo $red_edit_dtls["first_name1"];?>"/>
                                <input name="mytxt_src1" type="hidden" id="mytxt_src1" value="<?php echo $red_edit_dtls["father_name"];?>"/>
                                <input name="mytxt_src2" type="hidden" id="mytxt_src2" value="<?php echo $red_edit_dtls["grandfather_name"];?>"/>
                                <input name="mytxt_src3" type="hidden" id="mytxt_src3" value="<?php echo $red_edit_dtls["family_name"];?>"/>
                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src" value="<?php echo $red_edit_dtls["student_first_name"];?>"/>
                                <input name="stud_id" type="hidden" id="stud_id" value="<?php echo $_REQUEST["id"];?>"/>
                                </td>
                              <td width="1%">&nbsp;</td>
                              <td width="38%">&nbsp;</td>
                              <td width="3%">&nbsp;</td>
                            </tr>
                            <?php if($red_edit_dtls['student_mobile'] == ''){
								  $mobile = '009665';
							  }else{
								  $mobile = $red_edit_dtls['student_mobile'];
							  }
							  ?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190_ar" id="mobile" onkeypress="return PhoneNo(event);" onfocus="get_arabic();" value="<?php echo $mobile;?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="top">
                              
							  <table width="80%" border="0" cellspacing="0" cellpadding="0" style="float:right;">
                                  <?php
									$i1 = 1;
									foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) {
										
										$is_exist = $dbf->countRows("student_lead", "student_id='$_REQUEST[id]' And lead_id='$valc[id]'");							
									?>
                                  <tr>
                                    <td width="93%" align="right" valign="middle" class="mycon"><?php echo $valc["name"];?></td>
                                    <td width="7%" align="right" valign="middle">
                                    <input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>"  <?php if($is_exist > 0){?> checked="checked" <?php }?>>
                                    </td>
                                  </tr>
                                  <?php
									$i1 = $i1 + 1;
									}
									?>
                                </table>
							
							<input type="hidden" name="count" id="count" value="<?php echo $i1-1;?>"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu">: <label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?></label></td>
                              
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><textarea name="comment" id="comment" class="validate[required]" rows="5" cols="40" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999; text-align:right;" onfocus="get_arabic();"><?php echo $red_edit_dtls["student_comment"];?></textarea></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"><label class="description" for="element_7"><span class="nametext1">*</span> :<?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_COMMENTS");?> </label></td>
                              <td>&nbsp;</td>
                            </tr> 
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="right" valign="middle"><input name="app_date" type="text" class="datepick validate[required] new_textbox190_ar" id="app_date"  readonly="readonly" value="<?php echo $red_edit_dtls['app_date'];?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" class="leftmenu"><span class="nametext1">*</span> :<?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_APPOINTDT");?></td>
                              <td>&nbsp;</td>
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
