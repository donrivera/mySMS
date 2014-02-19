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

include_once '../includes/language.php';
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
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
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

function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

function ageinfo(){
	var age=$("#age").val();
	if(age <= 16){
		document.getElementById('gender').style.display='none';
		document.getElementById('parentid').style.display='';
	}else if(age > 16){
		document.getElementById('gender').style.display='';
		document.getElementById('parentid').style.display='none';
	}
}

function gotfocus(){
  document.getElementById('age').focus();
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?> </td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-shadow: 5px 5px 5px #ccc;">
              
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
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=age" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="11%">&nbsp;</td>
                            <td width="31%">&nbsp;</td>
                            <td width="26%">&nbsp;</td>
                            <td width="32%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" colspan="2" align="left" valign="middle" class="leftmenu">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="5%" align="left" valign="middle"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="86%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                    <div class="meter-value" style="background-color:#847B7B; width:0%;">
                                        <div  style="border:solid 1px; "></div>
                                    </div>
                                </div>
                                </td>
                                <td width="9%" align="center" valign="middle" class="shop2">0%</td>
                              </tr>
                            </table>
                            </td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?> : <span class="nametext1">*</span></td>
                            <td align="left" valign="middle"><span class="leftmenu">
                              <input name="age" type="text" class="validate[required] new_textbox40" id="age" maxlength="2" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $_SESSION["age"]; ?>" onKeyUp="ageinfo();">
                            </span></td>
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
                            
                            <td width="159" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?>:</td>
                            
                            <td width="341" align="left" valign="middle" class="leftmenu"><?php
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
						    if($_SESSION[gname]!='' && ($_SESSION[age] <= 16))
							{
								$dis1="";
							}
							else
							{
								$dis1="none";
							}

						  ?>
                          <div id="parentid" style="display:<?php echo $dis1;?>">
                          <table width="531" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?> &nbsp;:</td>
                            <td width="10" align="left" valign="middle">&nbsp;</td>
                            <td width="298" align="left" valign="middle"><span class="leftmenu">
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
                            <td width="192" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?> : <span class="nametext1">*</span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle"><span class="leftmenu">
                              <input name="gname" type="text" class="validate[required] new_textbox190" id="gname" value="<?php echo $_SESSION[gname];?>"/>
                            </span></td>
                          </tr>
                          <tr>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTSCONTACT");?> : <span class="nametext1">*</span></td>
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
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="10" colspan="4" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/></td>
                          </tr>
                          <tr>
                            <td height="10" colspan="4" align="left" valign="middle"></td>
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
                      <td width="8%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?> </td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
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
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        
                        <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="s1_process.php?action=age" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td width="19%">&nbsp;</td>
                                        <td width="23%">&nbsp;</td>
                                        <td width="40%">&nbsp;</td>
                                        <td width="18%">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" colspan="2" align="left" valign="middle" class="leftmenu">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="4%" align="left" valign="middle"><span class="shop2">0%</span></td>
                                              <td width="87%" align="left" valign="middle" style="padding-left:2px;">
                                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                                  <div class="meter-value" style="background-color:#847B7B; width:0%;">
                                                    <div  style="border:solid 1px; "></div>
                                                    </div>
                                                  </div>
                                              </td>
                                              </tr>
                                            </table>
                                          </td>
                                        <td align="left" valign="middle" class="shop2">&nbsp;: <?php echo constant("PROGRESS_BAR");?></td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="right" valign="middle" class="leftmenu"><input name="age" type="text" class="validate[required] new_textbox40_ar" id="age" maxlength="2" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $_SESSION["age"]; ?>" onKeyUp="ageinfo();"></td>
                                        <td align="left" valign="middle"> <span class="nametext1">*</span><span class="leftmenu">  : <?php echo constant("STUDENT_ADVISOR_S_AGE_AGEOFSTUDENT");?></span></td>
                                        <td>&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td colspan="4" align="left">
                                          <?php
						    if($_SESSION[gender]!='' && ($_SESSION[age] > 16) )
							{
								$dis = "";
							}
							else
							{
								$dis = "none";
							}

						  ?>
                                          <div id="gender" style="display:<?php echo $dis; ?>"> 
                                            <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                                              <tr>
                                                
                                                <td width="159" height="28" align="right" valign="middle" class="leftmenu"><?php
							$v = $_SESSION[gender];
							if($v == ''){ $v = 'male'; }
							?>
                                                  <input name="gender" type="radio" id="gender2" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                                                  <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                                                  <input type="radio" name="gender" id="gender2" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                                                  <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>
                                                
                                                <td width="341" align="left" valign="middle" class="leftmenu">:<?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></td>                           
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
                                            <table width="396" border="0" align="center" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td height="28" align="right" valign="middle" class="leftmenu">
												<?php
													$v = $_SESSION[gender1];
													if($v == ''){ $v = 'male'; }
													?>
                                                  <input name="gender1" type="radio" id="gender1" value="male" <?php if($v == "male") { ?> checked="checked" <?php } ?>>
                                                  <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?>
                                                  <input type="radio" name="gender1" id="gender1" value="female" <?php if($v == "female") { ?> checked="checked" <?php } ?>>
                                                  <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>
                                                <td width="11" align="left" valign="middle">&nbsp;</td>
                                                <td width="211" align="left"><span class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></span></td>
                                                </tr>
                                              <tr>
                                                <td width="192" height="28" align="left" valign="middle" class="leftmenu"><input name="gname" type="text" class="validate[required] new_textbox190_ar" id="gname" value="<?php echo $_SESSION[gname];?>"/></td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td align="left"><span class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTGUARDIANS");?></span></td>
                                                </tr>
                                              <tr>
                                                <td height="28" align="left" valign="middle" class="leftmenu"><input name="pcontact" type="text" class="validate[required] new_textbox190_ar" id="pcontact" value="<?php echo $_SESSION[pcontact];?>"/></td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td align="left"><span class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S_PARENT_PARENTSCONTACT");?></span></td>
                                                </tr>
                                              <tr>
                                                <td height="28" align="left" valign="middle" class="leftmenu"><input name="information" type="text" class="new_textbox190_ar" id="information" value="<?php echo $_SESSION[information];?>"/></td>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                <td align="left"><span class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_S_PARENT_TEXT");?></span></td>
                                                </tr>
                                              </table>
                                            </div>
                                          </td>
                                        </tr>
                                      
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                      
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="4" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="center" valign="middle" class="leftmenu" colspan="2"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                        
                                        <td colspan="2" align="center" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="4" align="left" valign="middle"></td>
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
