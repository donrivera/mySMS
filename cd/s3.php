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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$res = $dbf->strRecordID("student","*","id='$_SESSION[student_id]'");

include_once '../includes/language.php';

?>	
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

function gotfocus()
{
  document.getElementById('mobile_no').focus();
}
function checkTab(id)
{
	if(id=="alt_no")
	{
	document.getElementById('submit').focus();
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->
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
<?php if($_SESSION['lang']=='EN'){?>
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="alert_manage.php"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
             <?php if($_REQUEST[msg]=="mexist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo constant("STUDENT_ADVISOR_S3_TEXT1");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			  <?php if($_REQUEST[msg]=="maexist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="322" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo constant("STUDENT_ADVISOR_S3_TEXT2");?></td>
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
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_CONTACT");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=contact" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="23%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td width="50%" rowspan="8" align="left" valign="top">
                              <br>
                              <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                <tr>
                                  <td height="30" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S2_NAME");?> :</span> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span></td>
                                  </tr>
                                <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?> :</span> <span class="shop2"><?php echo $rescc["value"];?></span></td>
                                  </tr>
                                  <?php if($_SESSION[student_id] != ''){?>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?>:</span> <span class="shop2"><?php echo $_SESSION[student_id];?></span></td>
                                  </tr>
                                  <?php } ?>
                                <tr>
                                  <td height="50" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="18%" align="right" valign="middle"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:30%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="9%" align="center" valign="middle" class="shop2">30%</td>
                              </tr>
                            </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S3_STDMOBNO");?><span class="nametext1">*</span> : </td>
                            <td>&nbsp;</td>
                            <?php if($_SESSION[mobile_no] == '') { $mobile = '009665'; } else { $mobile = $_SESSION[mobile_no];}?>
                            <td align="left" valign="middle">
                              <input name="mobile_no" type="text" class="validate[required] new_textbox190" id="mobile_no" value="<?php echo $mobile;?>" onKeyPress="return PhoneNo(event);"  maxlength="20"/>
                            </td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S3_TEXT3");?>: </td>
                            <td>&nbsp;</td>
                            <?php if($_SESSION[alt_no] == '') { $mobile1 = '009665'; } else { $mobile1 = $_SESSION[alt_no];}?>
                            <td width="25%" align="left" valign="middle"><input name="alt_no" type="text" class="new_textbox190" id="alt_no" value="<?php echo $mobile1;?>" onKeyPress="return PhoneNo(event);" maxlength="20" onBlur="checkTab('alt_no');"/></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="center" valign="middle" class="leftmenu"><a href="s2.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/></td>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
                  <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left"><a href="alert_manage.php"></a></td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="mexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                          <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo constant("STUDENT_ADVISOR_S3_TEXT1");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="maexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="322" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                          <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo constant("STUDENT_ADVISOR_S3_TEXT2");?></td>
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
                        <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_CONTACT");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=contact" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="51%" rowspan="8" align="center" valign="top">
                              <br>
                              <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                <tr>
                                  <td height="30" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S2_NAME");?></span></td>
                                  </tr>
                                <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                                <tr>
                                  <td align="right" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $rescc["value"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?></span></td>
                                  </tr>
                                  <?php if($_SESSION[student_id] != ''){?>
                                <tr>
                                  <td align="right" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[student_id];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?></span></td>
                                  </tr>
                                  <?php }?>
                                <tr>
                                  <td height="50" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </td>
                            <td>&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="21%">&nbsp;</td>
                            <td width="2%">&nbsp;</td>
                          </tr>
                          <tr>
                            
                            <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="9%" align="center" valign="middle" class="shop2">30%</td>
                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:30%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="18%" align="left" valign="middle">&nbsp;&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                
                              </tr>
                            </table></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <?php if($_SESSION[mobile_no] == '') { $mobile = '009665'; } else { $mobile = $_SESSION[mobile_no];}?>
                            <td width="25%" height="28" align="right" valign="middle"><input name="mobile_no" type="text" class="validate[required] new_textbox190_ar" id="mobile_no" value="<?php echo $mobile;?>" onKeyPress="return PhoneNo(event);" maxlength="20"/></td>
                            <td>&nbsp;</td>
                            
                            <td width="21%" align="right" valign="middle"><span class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S3_STDMOBNO");?></span></td>
                            
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <?php if($_SESSION[alt_no] == '') { $mobile1 = '009665'; } else { $mobile1 = $_SESSION[alt_no];}?>
                            <td height="28" align="right" valign="middle" class="leftmenu"><input name="alt_no" type="text" class="new_textbox190_ar" id="alt_no" value="<?php echo $mobile1;?>" onKeyPress="return PhoneNo(event);" maxlength="20" onBlur="checkTab('alt_no');"/></td>
                            <td>&nbsp;</td>
                            <td align="right" valign="middle"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S3_TEXT3");?></span></td>
                            
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            
                          </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                             <td align="right"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                             <td align="left" valign="middle">&nbsp;</td>
                             <td>&nbsp;</td>
                             <td height="25" align="left" valign="middle" class="leftmenu"><a href="s2.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                             
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
