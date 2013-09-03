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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

$res_edit = $dbf->strRecordID("group_size","*","group_id='$_REQUEST[ids]'");

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
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
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

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
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
	document.getElementById('size_from').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
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
            <td align="left" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
			<table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="51%" height="30" class="logintext"><?php echo constant("EDIT_GROUP_SIZE");?></td>
                <td width="21%">&nbsp;</td>
                <td width="7%" align="left">&nbsp;</td>
                <td width="6%" align="left"></td>
                <td width="8%" align="center"><a href="group_size_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">
                <table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFE8F9"><img src="../images/success-icon.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#FFE8F9">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFE8F9" class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <?php if($_REQUEST[msg]=="dup") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FEABB1"><img src="../images/errror.png" width="32" height="32"></td>
                      <td width="10" bgcolor="#FEABB1">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FEABB1" class="nametext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_RANGEEXIST");?></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("EDIT_GROUP_SIZE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_size_process.php?action=edit&ids=<?php echo $_REQUEST[ids];?>" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="6%">&nbsp;</td>
                              <td width="35%" height="30">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="23%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="34%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">
							  <?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?>  : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <?php
							  //Get value from group size
								$res_c = $dbf->strRecordID("common","*","id='$_REQUEST[ids]'");
							  ?>
                              <td align="left" valign="middle">&nbsp;&nbsp;<?php echo $res_c[name];?></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_SIZEOFGROUP");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="size_from" type="text" class="validate[required] new_textbox40" id="size_from" value="<?php echo $res_edit[size_from];?>" onKeyPress="return isNumberKey(event);" maxlength="3" />
                                <span class="contenttext" style="padding-left:5px;">
                                <input name="size_to" type="text" class="validate[required] new_textbox40" id="size_to" value="<?php echo $res_edit[size_to];?>"  onkeypress="return isNumberKey(event);"  maxlength="3"/>
                                </span></span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LENGTHCOURSE");?> :</td>
                              <td>&nbsp;</td>
                              <?php
								if($res_edit[units] != "0")
								{
									$unit_no = ($res_edit[units] / 10)." weeks";
								}
								else
								{
									$unit_no = "Flex";
								}
								?>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="week_id" type="text" class="new_textbox12" id="week_id" value="<?php echo $unit_no;?>" readonly="readonly" />
                                </span>
                              </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_UNITS");?> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="units" type="text" class="validate[required] new_textbox40" id="units" value="<?php echo $res_edit[units];?>" onKeyPress="return isNumberKey(event);" maxlength="3" />
                              </span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="30" colspan="6" align="left" valign="middle"></td>
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
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("EDIT_GROUP_SIZE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_size_process.php?action=edit&ids=<?php echo $_REQUEST[ids];?>" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="6%">&nbsp;</td>
                              <td width="22%" height="30">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="25%">&nbsp;</td>
                              <td width="27%">&nbsp;</td>
                              <td width="19%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;
							   </td>
                              <td>&nbsp;</td>
                              <?php
							  //Get value from group size
								$res_c = $dbf->strRecordID("common","*","id='$res_edit[group_id]'");
							  ?>
                              <td align="left" valign="middle">&nbsp;&nbsp;<?php echo $res_c[name];?></td>
                              <td><span class="nametext1">*</span>  : <?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="size_from" type="text" class="validate[required] new_textbox40" id="size_from" value="<?php echo $res_edit[size_from];?>" onKeyPress="return isNumberKey(event);" maxlength="3" />
                                <span class="contenttext" style="padding-left:5px;">
                                <input name="size_to" type="text" class="validate[required] new_textbox40" id="size_to" value="<?php echo $res_edit[size_to];?>"  onkeypress="return isNumberKey(event);"  maxlength="3"/>
                                </span></span></td>
                              <td><span class="nametext1">*</span> : <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_SIZEOFGROUP");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <?php
								if($res_edit[units] != "0")
								{
									$unit_no = ($res_edit[units] / 10)." weeks";
								}
								else
								{
									$unit_no = "Flex";
								}
								?>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="week_id" type="text" class="new_textbox12" id="week_id" value="<?php echo $unit_no;?>" readonly="readonly" />
                                </span>
                              </td>
                              <td>: <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LENGTHCOURSE");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><span class="contenttext" style="padding-left:5px;">
                                <input name="units" type="text" class="validate[required] new_textbox40" id="units" value="<?php echo $res_edit[units];?>" onKeyPress="return isNumberKey(event);" maxlength="3" />
                              </span></td>
                              <td>: <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_UNITS");?></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="30" colspan="6" align="left" valign="middle"></td>
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
				<?php }?>
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
</body>
</html>