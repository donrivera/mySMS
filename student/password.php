<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['students_uid']=="" || $_SESSION['students_user_type']!="Student")
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

//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");

# Set timeout period in seconds
$count = $res_logout["name"];

# When user click on save button
if($_REQUEST['action']=='edit'){
	
	# encode old password
	$pwd = base64_encode(base64_encode($_POST[oldpassword]));
	
	# encode new password
	$newpwd = base64_encode(base64_encode($_POST[newpassword]));
	
	# Check password is exist or not
	$num=$dbf->countRows('user',"password='$pwd' AND id='$_SESSION[id]'");
	
	# if password is correct
	if($num > 0){
		
		# Update query string
		$string="password='$newpwd'";
		$dbf->updateTable("user",$string,"id='$_SESSION[id]'");
		
		# Redirect to current page
		header("Location:password.php?msg=added");
		exit;
	}else{
		
		# Redirect to current page for invalid password
		header("Location:password.php?msg=invalid");
	}
}
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
<script type="text/javascript" src="../js/dropdowntabs.js"></script>

<!--JQUERY VALIDATION-->
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="../js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="../js/jquery.validationEngine.js" type="text/javascript"></script>		
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
<script type="text/javascript" language="javascript">
function password(){
	if((document.frm.newpassword.value)!=(document.frm.confirmpassword.value)){
		alert("Please match your passwords");
		document.frm.confirmpassword.value='';
		document.frm.confirmpassword.focus();
		return false;
	}
}	
</script>
<script type="text/javascript">
function gotfocus(){
  document.getElementById('oldpassword').focus();
}
</script>
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
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN"){ ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
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
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_PASSWORD_CHANGE_PASSWORD");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp; </td>
                    <td width="8%" align="left">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="invalid") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_PASSWORD_INVALIDPWD");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="314" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_PASSWORD_SUCMSG");?></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("NEW_PASSWORD");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="password.php?action=edit" name="frm" method="post" id="frm" onsubmit="password();" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="24%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="42%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="22%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_PASSWORD_OLDPASSWORD");?>  : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="oldpassword" type="password" class="validate[required] new_textbox190" id="oldpassword" size="45" minlength="4"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_PASSWORD_NEWPASSWORD");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="newpassword" type="password" class="validate[required] new_textbox190" id="newpassword" size="45" minlength="4"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_PASSWORD_CONFIRMPASSWORD");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="confirmpassword" type="password" class="validate[required] new_textbox190" id="confirmpassword" size="45" minlength="4"/></td>
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
<?php } else { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"></td>
                    <td width="22%">&nbsp;</td>
                    <td width="1%" align="left">&nbsp; </td>
                    <td width="15%" align="right" class="logintext"><?php echo constant("STUDENT_PASSWORD_CHANGE_PASSWORD");?>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                </tr>
              <?php if($_REQUEST[msg]=="invalid") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                    <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_PASSWORD_INVALIDPWD");?></td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
              <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="314" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                    <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("STUDENT_PASSWORD_SUCMSG");?></td>
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
                          <td width="100%" align="right" valign="middle" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("NEW_PASSWORD");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                          <tr>
                            <td align="center" valign="top" bgcolor="#EBEBEB">
                              
                              <form action="password.php?action=edit" name="frm" method="post" id="frm" onsubmit="password();" >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                  <tr>
                                    <td width="10%">&nbsp;</td>
                                    <td width="24%">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="31%">&nbsp;</td>
                                    <td width="0%">&nbsp;</td>
                                    <td width="34%">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"> </td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><input name="oldpassword" type="password" class="validate[required] new_textbox190_ar" id="oldpassword" size="45" minlength="4"/></td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp; : <span class="nametext1">*</span><?php echo constant("STUDENT_PASSWORD_OLDPASSWORD");?></td>
                                    </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"></td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><input name="newpassword" type="password" class="validate[required] new_textbox190_ar" id="newpassword" size="45" minlength="4"/></td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp; : <span class="nametext1">*</span><?php echo constant("STUDENT_PASSWORD_NEWPASSWORD");?></td>
                                    </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"></td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><input name="confirmpassword" type="password" class="validate[required] new_textbox190_ar" id="confirmpassword" size="45" minlength="4"/></td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp; : <span class="nametext1">*</span><?php echo constant("STUDENT_PASSWORD_CONFIRMPASSWORD");?></td>
                                    </tr>
                                  <tr>
                                    <td height="10" colspan="6" align="left" valign="middle"></td>
                                    </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
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
    </table>        
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
