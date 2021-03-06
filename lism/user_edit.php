<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
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

$res_usr = $dbf->strRecordID("user","*","id='$_REQUEST[id]'");
$pwd = base64_decode(base64_decode($res_usr[password]));
?>	
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
}
else
{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN')
{
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR')
{
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>
		
<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()	
	//$.validationEngine.loadValidation("#date")
	//alert($("#formID").validationEngine({returnIsValid:true}))
	//$.validationEngine.buildPrompt("#date","This is an example","error")	 		 // Exterior prompt build example
	//$.validationEngine.closePrompt(".formError",true) 							// CLOSE ALL OPEN PROMPTS
});

// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
function validate2fields(){
	if($("#firstname").val() =="" ||  $("#lastname").val() == ""){
		return false;
	}else{
		return true;
	}
}
</script>
<!--JQUERY VALIDATION ENDS-->

<script language="javascript" type="text/javascript">
function show()
{
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
			document.getElementById('showt').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showt').innerHTML=c;
		}
	}

	var type = document.getElementById('type').value;

	ajaxRequest.open("GET", "user_show_ajax.php" + "?type=" + type, true);
	ajaxRequest.send(null); 
}

function addgroupchange()
{
	var formName=document.frm;
	var w = formName.type.selectedIndex;
	var selected_text = formName.type.options[w].text;
	
	if(selected_text == "Student")
	{
		document.getElementById('showdiv').style.display ='none';
	}
	else
	{
		document.getElementById('showdiv').style.display ='block';
	}
	if(selected_text == "Center Director" || selected_text == "Student Advisor" || selected_text == "Receptionist" || selected_text == "LIS" || selected_text == "LIS Manager" || selected_text == "Accountant")
	{
		document.getElementById('showcenter').style.display ='block';
	}
	else
	{
		document.getElementById('showcenter').style.display ='none';
	}
}

//Except Characters
function PhoneNo(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90)))
	 {
		return false;
	 }
	 else
	 {
		return true;
	 }
}

function show_user(tno)
{
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
			document.getElementById('lbluser').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbluser').innerHTML=c;
			
			if(c != '')
			{
				document.getElementById('btnsave').style.display = 'none';
			}
			else
			{
				document.getElementById('btnsave').style.display = '';
			}
		}
	}
	var tno = tno;
	ajaxRequest.open("GET", "teacher1_check_user.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}

function show_email()
{
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
			document.getElementById('email').value="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('email').value=c;
			
		}
	}
	var tno = document.getElementById('student').value;
	
	ajaxRequest.open("GET", "user_show_email.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}

function show_mobile()
{
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
			document.getElementById('mobile').value="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('mobile').value=c;
			
		}
	}
	var tno = document.getElementById('student').value;
	
	ajaxRequest.open("GET", "user_show_mobile.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}

function show_email1()
{
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
			document.getElementById('email').value="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('email').value=c;
			
		}
	}
	var tno = document.getElementById('teacher').value;
	
	ajaxRequest.open("GET", "user_show_email1.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}

function show_mobile1()
{
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
			document.getElementById('mobile').value="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('mobile').value=c;
			
		}
	}
	var tno = document.getElementById('teacher').value;
	
	ajaxRequest.open("GET", "user_show_mobile1.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
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

function gotfocus()
{
  document.getElementById('type').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>),gotfocus();">
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("USER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="user_manage.php">
                <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <?php if($_REQUEST[msg]=="added") { ?>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                <tr>
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                  <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_PWDMSG");?></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
            <?php if($_SESSION['lang']=='EN'){?>
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                    <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("EDIT_USER");?></span></td>
                    <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                  <tr>
                    <td align="center" valign="top" bgcolor="#EBEBEB">
                    <form action="user_process.php?action=edituser&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="5%">&nbsp;</td>
                          <td width="18%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="49%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="26%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERTYPE");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                              <select name="type" id="type" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" onChange="show(),addgroupchange();">
                                <option value="Center Director" <?php if($res_usr[user_type]=="Center Director"){ echo "selected";}?>>Center Director</option>
                                <option value="Student Advisor" <?php if($res_usr[user_type]=="Student Advisor"){ echo "selected";}?>>Student Advisor</option>
                                <option value="Receptionist" <?php if($res_usr[user_type]=="Receptionist"){ echo "selected";}?>>Receptionist</option>
                                <option value="Student" <?php if($res_usr[user_type]=="Student"){ echo "selected";}?>>Student</option>
                                <option value="Teacher" <?php if($res_usr[user_type]=="Teacher"){ echo "selected";}?>>Teacher</option>
                                <option value="LIS" <?php if($res_usr[user_type]=="LIS"){ echo "selected";}?>>LIS</option>
                                <option value="LIS Manager" <?php if($res_usr[user_type]=="LIS Manager"){ echo "selected";}?>>LIS Manager</option>
                                <option value="Accountant" <?php if($res_usr[user_type]=="Accountant"){ echo "selected";}?>>Accountant</option>
                              </select>
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php if($res_usr[user_type]=="Student"){
							  $res_usr_name = $dbf->strRecordID("student","*","first_name='$res_usr[user_name]'");
							 ?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERNAME");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="showt">
                          <select name="student" id="student" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onChange="show_email(),show_mobile();">
                              <option value="">--Select Student--</option>
                              <?php
                              foreach($dbf->fetchOrder('student',"","first_name") as $val) {
                              ?>
                              <option value="<?php echo $val["id"];?>" <?php if($res_usr_name[id]==$val[id]){ echo "selected";}?>><?php echo $val["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
                              <?php } ?>
                            </select>
                            </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php }else if($res_usr[user_type]=="Teacher") {
							 $res_tcr_name = $dbf->strRecordID("teacher","*","name='$res_usr[user_name]'");
							?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERNAME");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="showt">
                          <select name="teacher" id="teacher" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onChange="show_email1(),show_mobile1();">
                              <option value="">--Select Teacher--</option>
                              <?php
                              foreach($dbf->fetchOrder('teacher',"","name") as $val) {
                              ?>
                              <option value="<?php echo $val["id"];?>" <?php if($res_tcr_name[id]==$val[id]){ echo "selected";}?>><?php echo $val["name"];?></option>
                              <?php } ?>
                            </select>
                            </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php } else {?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERNAME");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="showt"><input name="uname" type="text" class="validate[required] new_textbox190" id="uname" value="<?php echo $res_usr[user_name];?>" size="45" minlength="4" /></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERID");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="uid" type="text" class="validate[required] new_textbox190" id="uid" value="<?php echo $res_usr[user_id];?>" onBlur="show_user(this.value);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;&nbsp;
                            <label id="lbluser" class="nametext1"></label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_PASSWORD");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="password" type="password"class="validate[required] new_textbox190" id="password" value="<?php echo $pwd;?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_EMAILID");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox190" id="email" value="<?php echo $res_usr[email];?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" size="45" minlength="4" onKeyPress="return PhoneNo(event);" value="<?php echo $res_usr[mobile];?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" colspan="3" align="left" valign="middle" class="leftmenu">
                          <div id="showdiv" style="display:<?php if($res_usr[user_type]=="Student" ){ echo none;}else { echo '';} ?>">
                            <table width="350" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="99" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERSTATUS");?> :</td>
                                <td width="21">&nbsp;</td>
                                <td width="230" align="left" valign="middle">
                                <select name="status" id="status" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                                  <option value="">--Select--</option>
                                  <?php
                                    foreach($dbf->fetchOrder('common',"type='user status'","name") as $val) {	
                                  ?>
                                  <option value="<?php echo $val[id];?>" <?php if($val[id]==$res_usr[commonid]){ echo "selected";}?>><?php echo $val[name];?></option>
                                  <?php
                                   }
                                   ?>
                                </select>
                                </td>
                              </tr>
                            </table>
                          </div></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" colspan="3" align="left" valign="middle" class="leftmenu">
                          <div id="showcenter" style="display:<?php  if($res_usr[user_type]=="Student" || $res_usr[user_type]=="Teacher"){ echo none;}else { echo '';} ?>">
                            <table width="350" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="99" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_CENTRENAME");?> :</td>
                                <td width="21">&nbsp;</td>
                                <!--id NOT IN(select center_id from user)-->
                                <td width="230" align="left" valign="middle"><select name="center_id" id="center_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                                  <option value="">--Select--</option>
                                  <?php
                                    foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
                                  ?>
                                  <option value="<?php echo $valc[id];?>" <?php if($valc[id]==$res_usr[center_id]){ echo "selected";}?>><?php echo $valc[name];?></option>
                                  <?php
                                   }
                                   ?>
                                </select></td>
                              </tr>
                            </table>
                          </div></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><div id="btnsave" style="display:''">
                            <input name="submit" type="submit" class="btn1" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" />
                          </div></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                      </table>
                    </form></td>
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
            <?php } else{?>
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                    <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("EDIT_USER");?></span></td>
                    <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                  <tr>
                    <td align="center" valign="top" bgcolor="#EBEBEB">
                    <form action="user_process.php?action=edituser&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="15%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="59%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="23%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>                          
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                              <select name="type" id="type" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" onChange="show(),addgroupchange();">
                                <option value="Center Director" <?php if($res_usr[user_type]=="Center Director"){ echo "selected";}?>>Center Director</option>
                                <option value="Student Advisor" <?php if($res_usr[user_type]=="Student Advisor"){ echo "selected";}?>>Student Advisor</option>
                                <option value="Receptionist" <?php if($res_usr[user_type]=="Receptionist"){ echo "selected";}?>>Receptionist</option>
                                <option value="Student" <?php if($res_usr[user_type]=="Student"){ echo "selected";}?>>Student</option>
                                <option value="Teacher" <?php if($res_usr[user_type]=="Teacher"){ echo "selected";}?>>Teacher</option>
                                <option value="LIS" <?php if($res_usr[user_type]=="LIS"){ echo "selected";}?>>LIS</option>
                                <option value="LIS Manager" <?php if($res_usr[user_type]=="LIS Manager"){ echo "selected";}?>>LIS Manager</option>
                                <option value="Accountant" <?php if($res_usr[user_type]=="Accountant"){ echo "selected";}?>>Accountant</option>
                              </select>
                          </td>
                          <td>&nbsp;</td>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_USER_MANAGE_USERTYPE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <?php if($res_usr[user_type]=="Student"){
							  $res_usr_name = $dbf->strRecordID("student","*","first_name='$res_usr[user_name]'");
							 ?>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle" id="showt">
                          <select name="student" id="student" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onChange="show_email(),show_mobile();">
                              <option value="">--Select Student--</option>
                              <?php
                              foreach($dbf->fetchOrder('student',"","first_name") as $val) {
                              ?>
                              <option value="<?php echo $val["id"];?>" <?php if($res_usr_name[id]==$val[id]){ echo "selected";}?>><?php echo $val["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
                              <?php } ?>
                            </select>
                            </td>
                          <td>&nbsp;</td>
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_USERNAME");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <?php }else if($res_usr[user_type]=="Teacher") {
							 $res_tcr_name = $dbf->strRecordID("teacher","*","name='$res_usr[user_name]'");
							?>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle" id="showt">
                          <select name="teacher" id="teacher" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onChange="show_email1(),show_mobile1();">
                              <option value="">--Select Teacher--</option>
                              <?php
                              foreach($dbf->fetchOrder('teacher',"","name") as $val) {
                              ?>
                              <option value="<?php echo $val["id"];?>" <?php if($res_tcr_name[id]==$val[id]){ echo "selected";}?>><?php echo $val["name"];?></option>
                              <?php } ?>
                            </select>
                            </td>
                          <td>&nbsp;</td>
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_USERNAME");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <?php } else {?>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle" id="showt"><input name="uname" type="text" class="validate[required] new_textbox190" id="uname" value="<?php echo $res_usr[user_name];?>" size="45" minlength="4" /></td>
                          <td>&nbsp;</td>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_USERNAME");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td align="left" valign="middle">&nbsp;&nbsp;
                            <label id="lbluser" class="nametext1"></label></td>                          
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="uid" type="text" class="validate[required] new_textbox190" id="uid" value="<?php echo $res_usr[user_id];?>" onBlur="show_user(this.value);"/></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_USERID");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="password" type="password"class="validate[required] new_textbox190" id="password" value="<?php echo $pwd;?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_PASSWORD");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox190" id="email" value="<?php echo $res_usr[email];?>" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_EMAILID");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" size="45" minlength="4" onKeyPress="return PhoneNo(event);" value="<?php echo $res_usr[mobile];?>"/></td>
                          <td>&nbsp;</td>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td height="28" colspan="3" align="right" valign="middle" class="leftmenu">
                          <div id="showdiv" style="display:<?php if($res_usr[user_type]=="Student" ){ echo none;}else { echo '';} ?>">
                            <table width="350" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="199" align="right" valign="middle">
                                <select name="status" id="status" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                                  <option value="">--Select--</option>
                                  <?php
                                    foreach($dbf->fetchOrder('common',"type='user status'","name") as $val) {	
                                  ?>
                                  <option value="<?php echo $val[id];?>" <?php if($val[id]==$res_usr[commonid]){ echo "selected";}?>><?php echo $val[name];?></option>
                                  <?php
                                   }
                                   ?>
                                </select>
                                </td>
                                <td width="10">&nbsp;</td>
                                <td width="146" align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_USER_MANAGE_USERSTATUS");?></td>
                              </tr>
                            </table>
                          </div></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td height="28" colspan="3" align="right" valign="middle" class="leftmenu">
                          <div id="showcenter" style="display:<?php  if($res_usr[user_type]=="Student" || $res_usr[user_type]=="Teacher"){ echo none;}else { echo '';} ?>">
                            <table width="350" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <!--id NOT IN(select center_id from user)-->
                                <td width="196" align="right" valign="middle"><select name="center_id" id="center_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                                  <option value="">--Select--</option>
                                  <?php
                                    foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
                                  ?>
                                  <option value="<?php echo $valc[id];?>" <?php if($valc[id]==$res_usr[center_id]){ echo "selected";}?>><?php echo $valc[name];?></option>
                                  <?php
                                   }
                                   ?>
                                </select></td>
                                <td width="10">&nbsp;</td>
                                <td width="144" align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_USER_MANAGE_CENTRENAME");?></td>
                              </tr>
                            </table>
                          </div></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><div id="btnsave" style="display:''">
                            <input name="submit" type="submit" class="btn2" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" />
                          </div></td>
                          <td>&nbsp;</td>
                          
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                      </table>
                    </form></td>
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
            <?php }?>
            </td>
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
   <?php include '../footer.php';?>
</table>
</body>
</html>
