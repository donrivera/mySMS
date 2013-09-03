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

require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
?>	
<script type="text/javascript" language="javascript">
function workload_chk()
{
	if(document.frm.overtime.checked)
	{
		document.frm.workload.disabled=false;
		
	}
	else
	{
		document.frm.workload.disabled=true;
		document.frm.workload.value=0;
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
</script>
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

<script type="text/javascript" language="javascript">
function ajaxshowcenter()
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
			document.getElementById('showcenter').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showcenter').innerHTML=c;
		}
	}

	var tno = document.getElementById('name').value;

	ajaxRequest.open("GET", "teacher1_check.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
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
		}
	}

	var tno = tno;

	ajaxRequest.open("GET", "teacher1_check_user.php" + "?tno=" + tno, true);
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
	document.getElementById('name').focus();
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp; </td>
                <td width="8%" align="left"><a href="teacher1_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
             <?php if($_SESSION['lang']=='EN'){?>
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NEWTEACHER");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="teacher1_process.php?action=insert" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="5%">&nbsp;</td>
                          <td width="23%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="54%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="16%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?>: <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <input name="name" type="text" class="validate[required] new_textbox1" id="name" autocomplete="off" value="" onKeyUp="ajaxshowcenter();" onBlur="ajaxshowcenter();"/>&nbsp;&nbsp;<label id="showcenter"></label></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox1" id="mobile" size="45" minlength="4" onKeyPress="return PhoneNo(event);"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> <span class="nametext1">*</span> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox1" id="email" value="" />
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <select name="country" id="country" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;">
                              <?php
							foreach($dbf->fetchOrder('countries',"","") as $res) {
							  ?>
                              <option value="<?php echo $res['id']?>" <?php if($res["id"]=="189") { ?> selected="selected" <?php } ?>><?php echo $res['value'] ?></option>
                              <?php }?>
                            </select>
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_TEACHERSTATUS");?>:</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <select name="teacher_status" id="teacher_status" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                              <?php
							foreach($dbf->fetchOrder('common',"type='user status'","") as $res) {
							  ?>
                              <option value="<?php echo $res['id']?>"><?php echo $res['name'] ?></option>
                              <?php }?>
                            </select>
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_CENTERNAME");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><table width="300" cellpadding="0" cellspacing="0">
                            <?php
							$i=1;
							foreach($dbf->fetchOrder('centre',"","") as $res) {
							 ?>
                            <tr>
                              <th width="35" align="left" valign="middle" scope="col"><input type="checkbox" name="center<?php echo $i;?>" id="center<?php echo $i;?>" value="<?php echo $res['id'];?>" /></th>
                              <th width="220" align="left" valign="middle" scope="col"><?php echo $res['name'];?></th>
                              <th width="43" scope="col">&nbsp;</th>
                              </tr>
                            <?php $i++; }?>
                            <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>" />
                            </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_WORKLOAD");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <select name="workload" id="workload" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:80px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                            <option value="0">select</option>
                            <?php
								for($i=1;$i<37;$i++) {
								  ?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>
                            </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_OVERTIME");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><span class="labeltext">
                            <input name="overtime" type="checkbox" id="overtime"  /><!--onChange="workload_chk();"-->
                          </span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_PREFERENCE");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <select name="preference" id="preference" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                              <?php
							foreach($dbf->fetchOrder('common',"type='teacher preference'","") as $res) {
							  ?>
                              <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                              <?php }?>
                          </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" colspan="3" align="left" valign="bottom">
                          
                          <table width="325" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                            <tr>
                              <td width="21" bgcolor="#FFCC00">&nbsp;</td>
                              <td width="279" height="20" align="left" valign="middle" bgcolor="#FFCC00" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_LOGINDETAILS");?></td>
                            </tr>
                          </table>
                          
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_LOGINID");?> <span class="nametext1">*</span> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <input name="username" type="text" class="validate[required] new_textbox1" id="username" value="" size="45" autocomplete="off" onBlur="show_user(this.value);"/>&nbsp;&nbsp;<label id="lbluser" class="nametext1"></label></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?> <span class="nametext1">*</span> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="password" type="password" class="validate[required] new_textbox1" id="password" value="" size="45" minlength="4"/></td>
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
                          <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
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
            <?php }else{?>
			<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NEWTEACHER");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="teacher1_process.php?action=insert" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                         
                          <td width="19%">&nbsp;</td>
                          <td width="2%">&nbsp;</td>
                          <td width="48%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="25%">&nbsp;</td>
                           <td width="5%">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <input name="name" type="text" class="validate[required] new_textbox1" id="name" autocomplete="off" value="" onKeyUp="ajaxshowcenter();" onBlur="ajaxshowcenter();"/><label id="showcenter"></label></td>
						   <td align="left" valign="middle">&nbsp;</td>
                          <td class="leftmenu"><span class="nametext1">*</span>:<?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox1" id="mobile" size="45" minlength="4" onKeyPress="return PhoneNo(event);"/></td>
						   <td align="left" valign="middle">&nbsp;</td>
                          <td class="leftmenu"><span class="nametext1">*</span>  : <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] new_textbox1" id="email" value="" />                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> :<?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <select name="country" id="country" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;">
                              <?php
							foreach($dbf->fetchOrder('countries',"","") as $res) {
							  ?>
                              <option value="<?php echo $res['id']?>" <?php if($res["id"]=="189") { ?> selected="selected" <?php } ?>><?php echo $res['value'] ?></option>
                              <?php }?>
                            </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <select name="teacher_status" id="teacher_status" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                              <?php
							foreach($dbf->fetchOrder('common',"type='user status'","") as $res) {
							  ?>
                              <option value="<?php echo $res['id']?>"><?php echo $res['name'] ?></option>
                              <?php }?>
                            </select>                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_TEACHERSTATUS");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="top" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><table width="300" cellpadding="0" cellspacing="0">
                            <?php
							$i=1;
							foreach($dbf->fetchOrder('centre',"","") as $res) {
							 ?>
                            <tr>
                              <th width="35" scope="col">&nbsp;</th>
                              <th width="225" align="right" valign="middle" scope="col"><?php echo $Arabic->en2ar($res['name']);?></th>
                              <th width="38" scope="col" align="left" valign="middle"><input type="checkbox" name="center<?php echo $i;?>" id="center<?php echo $i;?>" value="<?php echo $res['id'];?>" /></th>
                              </tr>
                            <?php $i++; }?>
                            <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>" />
                            </table></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_CENTERNAME");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <select name="workload" id="workload" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:80px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                            <option value="0">select</option>
                            <?php
								for($i=1;$i<37;$i++) {
								  ?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>
                            </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_WORKLOAD");?> </td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><span class="labeltext">
                            <input name="overtime" type="checkbox" id="overtime"  /><!--onChange="workload_chk();"-->
                          </span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_OVERTIME");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                        
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <select name="preference" id="preference" style="background-color:#ECF1FF; border:solid 1px; border-color:#999999;width:152px;font:Verdana, Geneva, sans-serif; font-size:12px;height:25px;">
                              <?php
							foreach($dbf->fetchOrder('common',"type='teacher preference'","") as $res) {
							  ?>
                              <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                              <?php }?>
                          </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_TEACHER1_MANAGE_PREFERENCE");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td height="28" colspan="3" align="right" valign="bottom">
                          
                          <table width="325" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                            <tr>
                              
                              <td width="279" height="20" align="right" valign="middle" bgcolor="#FFCC00" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_LOGINDETAILS");?></td>
                              <td width="21" bgcolor="#FFCC00">&nbsp;</td>
                            </tr>
                          </table>
                          
                          </td>
                          
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <input name="username" type="text" class="validate[required] new_textbox1" id="username" value="" size="45" autocomplete="off" onBlur="show_user(this.value);"/>&nbsp;&nbsp;<label id="lbluser" class="nametext1"></label></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> <span class="nametext1">*</span> :<?php echo constant("ADMIN_TEACHER1_MANAGE_LOGINID");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="password" type="password" class="validate[required] new_textbox1" id="password" value="" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> :<?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?> </td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
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
