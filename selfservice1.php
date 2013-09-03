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



<!--JQUERY VALIDATION-->

<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />

<?php 

if($_SESSION[lang]==''){

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

	ajaxRequest.open("GET", "selfservice_firstname.php" + "?tno=" + tno, true);

	ajaxRequest.send(null); 

}



function ageinfo()

{

	var age=$("#age").val();

	if(age <= 16){

		document.getElementById('gender').style.display='none';

		document.getElementById('parentid').style.display='';

	}else if(age > 16){

		document.getElementById('gender').style.display='';

		document.getElementById('parentid').style.display='none';

	}

}



function show_js(){	

	var textlang = document.getElementById('src').value;

	document.location.href='s_classic.php?textlang='+textlang;	

}



function get_arabic(){

	document.getElementById('ar_mytxt_src').value = document.getElementById('t4').value;

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



function showtextbox(){

	 if(document.getElementById('trcomment').style.display == 'none'){

		 document.getElementById('trcomment').style.display = '';

	 }else if(document.getElementById('trcomment').style.display == ''){

		 document.getElementById('trcomment').style.display = 'none';

	 }

}

</script>	

<!--JQUERY VALIDATION ENDS-->

<style>

.btn1{background:url(images/btn1.png) no-repeat;width:143px;height:25px;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bolder;color:#FFFFFF;border:none;

text-align:center;cursor:pointer;padding-bottom:5px;text-decoration:none;text-transform:uppercase;}



.new_textbox190{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:190px;height:15px;}

.new_textbox40{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:40px;height:15px;}

.new_textbox80{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:80px;height:15px;}

.new_textbox12{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:120px;height:15px;}

.new_textbox70{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:70px;height:15px;}

.new_textbox100{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:100px;height:15px;}

.new_textbox140{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:140px;height:15px;}

.new_textbox690{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:650px;height:15px;}



<!--For Arabic-->

.new_textbox1_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:150px;height:15px; text-align:right;}

.new_textbox190_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:190px;height:15px; text-align:right;}

.new_textbox40_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:40px;height:15px; text-align:right;}

.new_textbox80_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:80px;height:15px; text-align:right;}

.new_textbox12_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:120px;height:15px; text-align:right;}

.new_textbox70_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:70px;height:15px; text-align:right;}

.new_textbox100_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:100px;height:15px; text-align:right;}

.new_textbox140_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:140px;height:15px; text-align:right;}

.new_textbox690_ar{border:solid 1px;border-color:#999999;background-color:#ECF1FF;width:650px;height:15px; text-align:right;}



.btn2{background:url(images/btn2.png) no-repeat;width:143px;height:25px;font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bolder;

color:#FFFFFF;border:none;text-align:center;cursor:pointer;padding-bottom:5px;}

</style>

<link rel="icon" href="images/b.png">

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

        <td height="479" align="center" valign="top" class="loginbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="450" align="left" valign="top" ><table width="90%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>

              </tr>

              <?php if($_REQUEST[msg]=="exist") { ?>

              <tr>

                <td align="center" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">

                    <tr>

                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="images/close-btn.png" width="25" height="25" /></td>

                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>

                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>

                    </tr>

                </table></td>

              </tr>

              <?php } ?>

              <tr>

                <td height="200" align="center" valign="top">

				<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">

                  <tr>

                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td width="15" align="left" valign="top"><img src="images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>

                        <td width="100%" style="background:url(images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("QUICK_ADD");?></span></td>

                        <td width="15" align="right" valign="top"><img src="images/top_right_bg.png" width="15" height="31" /></td>

                      </tr>

                    </table></td>

                  </tr>

                  <tr>

                    <td align="left" valign="top">

                    <div id="free-translator" style="background-color:#EBEBEB;">

                        <link rel="stylesheet" href="sa/arabic_files/free-translator.css">

                        <script src="sa/arabic_files/Translate_002.js"></script>

						<script src="sa/arabic_files/Translate.js"></script>

                        <script type="text/javascript" src="sa/arabic_files/jsapi"></script>

                        <script src="sa/arabic_files/ga.js" async="" type="text/javascript"></script>

                        

                        <?php if($_REQUEST[textlang]=="en" || $_REQUEST[textlang]=="") { ?>

                        <script type="text/javascript" src="sa/arabic_files/free-translator-quick.js"></script>

                        <?php } else { ?>

                        <script type="text/javascript" src="sa/arabic_files/free-translator_ar-quick.js"></script>

                        <?php } ?>

                        <script src="sa/arabic_files/a" type="text/javascript"></script>

                        <script src="sa/arabic_files/defaulten_GB.js" type="text/javascript"></script>

                        

                        <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">

                    	<input id="lang_name" value="Arabic" type="hidden">

                    

					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >

                          <tr>

                            <td width="100%" colspan="5" align="left" valign="middle" id="lbljs"></td>

                          </tr>

                          <tr>

                            <td colspan="5" align="left" valign="middle" style="border-left:solid 1px; border-color:#CCC;  border-right:solid 1px; border-color:#CCC;">

                            

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td align="left" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>

                                <td align="left" valign="middle">&nbsp;</td>

                              </tr>

                            </table></td>

                            </tr>

                          

                          <tr>

                            <td height="10" colspan="5" align="left" valign="middle" class="leftmenu" style="border-top:dotted 1px; border-color:#000000; border-left:solid 1px; border-color:#CCC;  border-right:solid 1px; border-color:#CCC;">&nbsp;</td>

                          </tr>

                          <tr>

                            <td height="10" colspan="5" align="right" valign="middle" style="border-left:solid 1px; border-color:#CCC; border-right:solid 1px; border-color:#CCC;">

                            <table width="715" border="0" align="center" cellpadding="0" cellspacing="0">

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

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                  <tr>

                                    <td width="30%" align="left" valign="middle" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_FROM");?> : &nbsp;</td>

                                    <td width="70%" align="left" valign="middle">

                                    <select id="src" name="src" style="width:100px;" onChange="show_js();">

                                        <option value="en" <?php if($_REQUEST[textlang]=="" || $_REQUEST[textlang]=="en") {?> selected="" <?php } ?>>English</option>

                                        <option value="ar" <?php if($_REQUEST[textlang]=="ar") {?> selected="" <?php } ?>>Arabic</option>                                          

                                        </select>

                                    </td>

                                  </tr>

                                  <tr>

                                    <td align="left" valign="middle" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_TRANSLATE_TO");?> : &nbsp;</td>

                                    <td align="left" valign="middle">

                                    <select id="dst" name="dst" style="width:100px;">

                                        <option value="ar">Arabic</option>

                                        <option value="en">English</option>

                                        </select>

                                    </td>

                                  </tr>

                                </table>

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

                                  <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $_SESSION[classic_name1];?>" /></td>

                                <td align="left" valign="middle">

                                  <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $_SESSION[classic_fathername1];?>"/></td>

                                <td align="left" valign="middle">

                                  <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $_SESSION[classic_gfathername1];?>"/></td>

                                <td align="left" valign="middle">

                                  <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $_SESSION[classic_familyname1];?>" /></td>

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

							if(document.getElementById('id_typen').checked == true){

								alert(document.getElementById('sidn').value);

								if(document.getElementById('sidn').value == ''){									

									document.getElementById('sidn').focus();

									return false;

								}

							}

						}

						</script>

                        <form action="selfservice_process.php?action=classic" name="frm" method="post" id="frm" enctype="multipart/form-data" onsubmit="return checkid();">

                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >

                            <tr>

                              <td width="7%">&nbsp;</td>

                              <td width="35%"><input name="mytxt_src" type="hidden" id="mytxt_src"/>

                                <input name="mytxt_src1" type="hidden" id="mytxt_src1"/>

                                <input name="mytxt_src2" type="hidden" id="mytxt_src2"/>

                                <input name="mytxt_src3" type="hidden" id="mytxt_src3"/>

                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src"/>

                                <input type="hidden" name="mycentre_id" id="mycentre_id" value="<?php echo $page;?>" />
                                
                                <input type="hidden" name="my_pagename" id="my_pagename" value="<?php echo $page_name;?>" />

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

                          <div id="gender"> 

                          <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">

                          <tr>

                            

                            <td width="195" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?>:</td>

                            <td width="10">&nbsp;</td>

                            <td width="295" align="left" valign="middle" class="mycon">

                              <input name="gender" type="radio" id="gender3" value="male">

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>

                              <input type="radio" name="gender" id="gender3" value="female">

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>                           

                          </tr>

                          </table>

                          </div>

                          </td>

                          </tr>

                          <tr>

                          <td colspan="4" align="left">

                          <?php

						    if($_SESSION[gname] !='' && ($_SESSION[age] <= 16)){

								$dis1="";

							}else{

								$dis1="none";

							}

						  ?>

                          <div id="parentid" style="display:<?php echo $dis1;?>">

                          <table width="617" border="0" align="center" cellpadding="0" cellspacing="0">

                          <tr>

                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?> &nbsp;:</td>

                            <td width="7" align="left" valign="middle">&nbsp;</td>

                            <td width="346" align="left" valign="middle"><span class="mycon">

                              <input name="gender1" type="radio" id="gender4" value="male">

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>

                              <input type="radio" name="gender1" id="gender4" value="female">

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></span></td>

                          </tr>

                          <tr>

                            <td width="264" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?> :<span class="nametext1">*</span></td>

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

                              <textarea name="newcomment" id="newcomment" rows="5" cols="40" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>

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

                                    <td width="7%" align="left" valign="middle">

                                    <input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>" >

                                    </td>

                                    <td width="93%" align="left" valign="middle" class="mycon"><?php echo $valc["name"];?></td>

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

                                    <td width="7%" align="left" valign="middle">

                                    <input name="type<?php echo $t;?>" id="type<?php echo $t;?>" type="checkbox" value="<?php echo $valt["id"];?>">

                                    </td>

                                    <td width="93%" align="left" valign="middle" class="mycon"><?php echo $valt["name"];?></td>

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

        <td height="479" align="center" valign="top" class="loginbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="450" align="left" valign="top" ><table width="90%" border="0" cellspacing="0" cellpadding="0">

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

                <td height="200" align="center" valign="top">

				<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">

                          <tr>

                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td width="15" align="left" valign="top"><img src="images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>

                                <td width="100%" align="right" style="background:url(images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("QUICK_ADD");?></span></td>

                                <td width="15" align="right" valign="top"><img src="images/top_right_bg.png" width="15" height="31" /></td>

                              </tr>

                            </table></td>

                          </tr>

                          <tr>

                            <td align="right" valign="top">

                            <div id="free-translator" style="background-color:#EBEBEB;">

                                <link rel="stylesheet" href="sa/arabic_files/free-translator.css">

                                <script src="sa/arabic_files/Translate_002.js"></script>

                                <script src="sa/arabic_files/Translate.js"></script>

                                <script type="text/javascript" src="sa/arabic_files/jsapi"></script>

                                <script src="sa/arabic_files/ga.js" async="" type="text/javascript"></script>

                                

                                <?php if($_SESSION["lang"]=="EN" || $_SESSION["lang"]=="") { ?>

                                <script type="text/javascript" src="sa/arabic_files/free-translator-quick.js"></script>

                                <?php } else { ?>

                                <script type="text/javascript" src="sa/arabic_files/free-translator_ar-quick.js"></script>

                                <?php } ?>

                                <script src="sa/arabic_files/a" type="text/javascript"></script>

                                <script src="sa/arabic_files/defaulten_GB.js" type="text/javascript"></script>

                                

                                <form action="https://www.translation-services-usa.com/customers/short.php" enctype="multipart/form-data" method="post" name="translator_template">

                                <input id="lang_name" value="Arabic" type="hidden">

                            

                                <table width="100%" border="0" cellpadding="0" cellspacing="0" >

                                  <tr>

                                    <td width="100%" colspan="5" align="left" valign="middle" id="lbljs"></td>

                                  </tr>

                                  <tr>

                                    <td colspan="5" align="left" valign="middle" style="border-left:solid 1px; border-color:#CCC;  border-right:solid 1px; border-color:#CCC;">

                                    

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td align="right" valign="middle" class="shop2">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_S1_TXT");?></td>

                                        <td align="left" valign="middle">&nbsp;</td>

                                      </tr>

                                    </table></td>

                                    </tr>

                                  <tr>

                                    <td height="10" colspan="5" align="right" valign="middle" style="border-left:solid 1px; border-color:#CCC; border-right:solid 1px; border-color:#CCC;">

                                    <table width="715" border="0" align="center" cellpadding="0" cellspacing="0">

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

                                          <input name="t1" type="text" class="new_textbox140_ar" id="t1" value="<?php echo $_SESSION[classic_name1];?>"/></td>

                                        <td align="right" valign="middle">

                                          <input name="t2" type="text" class="new_textbox140_ar" id="t2" value="<?php echo $_SESSION[classic_fathername1];?>"/></td>

                                        <td align="right" valign="middle">

                                          <input name="t3" type="text" class="new_textbox140_ar" id="t3" value="<?php echo $_SESSION[classic_gfathername1];?>"/></td>

                                        <td align="center" valign="middle">

                                          <input name="t4" type="text" class="new_textbox140_ar" id="t4" value="<?php echo $_SESSION[classic_familyname1];?>" /></td>

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

							if(document.getElementById('id_typen').checked == true){

								alert(document.getElementById('sidn').value);

								if(document.getElementById('sidn').value == ''){									

									document.getElementById('sidn').focus();

									return false;

								}

							}

						}

						</script>

                        <form action="selfservice_process.php?action=classic" name="frm" method="post" id="frm" enctype="multipart/form-data" onsubmit="return checkid();">

                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >

                            <tr>

                              <td width="6%">&nbsp;</td>

                              <td width="52%"><input name="mytxt_src" type="hidden" id="mytxt_src"/>

                                <input name="mytxt_src1" type="hidden" id="mytxt_src1"/>

                                <input name="mytxt_src2" type="hidden" id="mytxt_src2"/>

                                <input name="mytxt_src3" type="hidden" id="mytxt_src3"/>

                                <input name="ar_mytxt_src" type="hidden" id="ar_mytxt_src"/>

                                <input type="hidden" name="mycentre_id" id="mycentre_id" value="<?php echo $page;?>" />
                                
                                <input type="hidden" name="my_pagename" id="my_pagename" value="<?php echo $page_name;?>" />

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

                            <td width="329" align="right" valign="middle" class="leftmenu"><?php

							$v = $_SESSION[gender];

							if($v == ''){ $v = 'male'; }

							?>

                              <input name="gender" type="radio" id="gender3" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>

                              <input type="radio" name="gender" id="gender3" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>

                              <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>

                            <td width="10">&nbsp;</td>

                            <td width="168" height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></td>                          </tr>

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

                            <td width="380" align="right" valign="middle"><span class="leftmenu">

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

                            <td width="227" height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span>: <?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?></td>

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

                                    <td width="92%" align="right" valign="middle" class="mycon"><?php echo $valc["name"];?></td>

                                    <td width="8%" align="right" valign="middle">

                                    <input name="course<?php echo $i;?>" id="course<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>"  onchange="get_interest_group();">

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

                              <textarea name="newcomment" id="newcomment" rows="3" cols="40" class="mytext" style="text-align:right;"></textarea></td>

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

                                    <td width="93%" align="right" valign="middle" class="mycon"><?php echo $valc["name"];?></td>

                                    <td width="7%" align="right" valign="middle">

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

                              <td height="5" align="left" valign="middle" class="leftmenu"></td>

                              <td height="5" align="right" valign="top" class="leftmenu"></td>

                              <td height="5"></td>

                              <td height="5" align="left" bgcolor="#CCCCCC"></td>

                              <td height="5"></td>

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

                                    <td width="93%" align="right" valign="middle" class="mycon"><?php echo $valt["name"];?></td>

                                    <td width="7%" align="right" valign="middle">

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