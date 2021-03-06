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

<!--Except Characters-->
<script language="javascript" type="text/javascript">
function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}


function show_student(){
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
			document.getElementById('id_student').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('id_student').innerHTML=c;
		}
	}

	var name = document.getElementById('name').value;
	
	ajaxRequest.open("GET", "student_add_check_student.php" + "?name=" + name, true);
	ajaxRequest.send(null); 
}

function show_mobile(){
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
			document.getElementById('id_mobile').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('id_mobile').innerHTML=c;
		}
	}

	var name = document.getElementById('mobile').value;
	
	ajaxRequest.open("GET", "student_add_check_mobile.php" + "?name=" + name, true);
	ajaxRequest.send(null); 
}

function gotfocus(){
  document.getElementById('name').focus();
}
</script>
<style>
.mytext{border:solid 1px; height:200px; width:190px; background-color:#ECF1FF; border-color:#999999;}
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
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_QUICKADD");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"><a href="student_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" id="id_student"></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" id="id_mobile" style="padding-top:5px;"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">
				<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE">
					  <img src="../images/errror.png" width="32" height="32" /></td>
                      <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_NAMEEXT");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			  <?php if($_REQUEST[msg]=="existm") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">
				<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE"><img src="../images/errror.png" width="32" height="32" /></td>
                      <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_MOBILEEXT");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                 
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
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
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="student_process.php?action=insert" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="7%">&nbsp;</td>
                              <td width="33%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="38%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="20%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_STUDENTNAME");?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input name="name" type="text" class="validate[required] new_textbox190" value="<?php echo $_SESSION['quick_name'];?>" id="name" size="45" autocomplete="off"/><!--onkeyup="show_student();" -->
                              </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_STUDENTMOBNO");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <?php if($_SESSION['quick_mobile'] == ''){
								  $mobile = '009665';
							  }else{
								  $mobile = $_SESSION['quick_mobile'];
							  }
							  ?>
                              <td align="left" valign="middle">
                              <input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" onkeypress="return PhoneNo(event);" onkeyup="show_mobile();" value="<?php echo $mobile;?>"  autocomplete="off"/>
                              </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="right" class="leftmenu" style="padding-top:5px;"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_TEXT");?></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <?php
							   $i=1;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $ress) {
							  ?>
                                <tr>
                                  <th width="8%" align="left" valign="middle" scope="col">
                                    <input type="checkbox" name="lead<?php echo $i; ?>" id="lead<?php echo $i; ?>" value="<?php echo $ress['id'] ?>" /></th>
                                  <th width="92%" align="left" valign="middle" class="leftmenu" scope="col"><?php echo $ress['name'] ?></th>
                                  </tr>
                                <?php $i++;}?>
                                <input type="hidden" name="count" id="count" value="<?php echo $i-1; ?>" />
                                </table>
                                </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="right" valign="top" class="leftmenu" style="padding-top:10px;"><span class="leftmenu" style="padding-top:5px;"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_COMMENTS");?></span> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <textarea name="enquire" id="enquire" class="validate[required] mytext" ><?php echo $_SESSION['quick_comment'];?></textarea>
                              </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>                            
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="30" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_APPOINTDT");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="app_date" type="text" class="datepick validate[required] new_textbox190" id="app_date"  readonly="readonly" value="<?php echo $_SESSION['quick_app_date'];?>"/></td>
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
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
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
                      <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                        <tr>
                          <td width="8%" align="left"><a href="student_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                          <td width="22%">&nbsp;</td>
                          <td width="8%" align="left">&nbsp;</td>
                          <td width="8%" align="left">&nbsp;</td>
                          
                          <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_QUICKADD");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" id="id_student"></td>
                      </tr>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" id="id_mobile" style="padding-top:5px;"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="exist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF">
                        <table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                          <tr>
                            <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE">
                              <img src="../images/errror.png" width="32" height="32" /></td>
                            <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
                            <td width="253" align="left" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_NAMEEXT");?></td>
                            </tr>
                          </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="existm") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF">
                        <table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                          <tr>
                            <td width="37" height="30" align="center" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE"><img src="../images/errror.png" width="32" height="32" /></td>
                            <td width="10" bordercolor="#FDE9E8" bgcolor="#FEE4DE">&nbsp;</td>
                            <td width="253" align="left" valign="middle" bordercolor="#FDE9E8" bgcolor="#FEE4DE" class="nametext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_MOBILEEXT");?> </td>
                            </tr>
                          </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
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
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="student_process.php?action=insert" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="7%">&nbsp;</td>
                              <td width="13%">&nbsp;</td>
                              <td width="2%">&nbsp;</td>
                              <td width="31%">&nbsp;</td>
                              <td width="2%">&nbsp;</td>
                              <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input name="name" type="text" class="validate[required] new_textbox190_ar" id="name" size="45" onkeyup="show_student();" autocomplete="off"/>
                              </td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td width="20%" align="left" valign="middle"><span class="nametext1">*</span><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_STUDENTNAME");?></span></td>
                              <td width="25%" align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input name="mobile" type="text" class="validate[required] new_textbox190_ar" id="mobile" onkeypress="return PhoneNo(event);" onkeyup="show_mobile();" value="009665"  autocomplete="off"/>
                              </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_STUDENTMOBNO");?></span></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" class="leftmenu" style="padding-top:5px;">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <?php
							   $i=1;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $ress) {
							  ?>
                                <tr>
                                  <th width="86%" align="right" valign="middle" scope="col"><span class="leftmenu"><?php echo $Arabic->en2ar($ress['name']); ?></span></th>
                                  <th width="14%" align="center" valign="middle" class="leftmenu" scope="col"><input type="checkbox" name="lead<?php echo $i; ?>" id="lead<?php echo $i; ?>" value="<?php echo $ress['id'] ?>" /></th>
                                  </tr>
                                <?php $i++;}?>
                                <input type="hidden" name="count" id="count" value="<?php echo $i-1; ?>" />
                                </table>                             
                                
                                </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="leftmenu" style="padding-top:5px;">: <?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_TEXT");?></span></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="top" class="leftmenu" style="padding-top:10px;">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <textarea name="enquire" id="enquire" style="text-align:right;" class="validate[required] mytext"></textarea>
                              </td>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top"><span class="nametext1">*</span> : <span class="leftmenu" style="padding-top:5px;"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_COMMENTS");?></span></td>
                              <td align="left" valign="top">&nbsp;</td>
                            </tr>                            
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="app_date" type="text" class="datepick validate[required] new_textbox190_ar" id="app_date"  readonly="readonly"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="nametext1">*</span><span class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_APPOINTDT");?></span></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="7" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                              <td>&nbsp;</td>
                              <td colspan="2" align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="7" align="left" valign="middle"></td>
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
