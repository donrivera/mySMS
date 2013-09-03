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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

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

function showgroup(){
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
			document.getElementById('lblgroup').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblgroup').innerHTML=c;
		}
	}

	var group = document.getElementById('group').value;

	ajaxRequest.open("GET", "group_show_ajax.php" + "?group=" + group, true);
	ajaxRequest.send(null); 
}
<!--JQUERY VALIDATION ENDS-->

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

function chk(){
	var str = document.getElementById("group").value;
	if (str.match(/^\s*$/)) {
		// nothing, or nothing but whitespace
		document.getElementById("group").value = '';
		document.getElementById("group").focus();
		return false;
	} else {
		// something
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
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> <img src="../images/cancel_btn2.png" width="143" height="23" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="09061986") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2F4"><img src="../images/errror.png" width="32" height="32" /></td>
                    <td width="10" bgcolor="#FFF2F4">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#FFF2F4" class="home_head_text"><?php echo constant("CD_GROUP_GROUPNAMEEXIST");?></th></td>
                  </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("GROUP_NAME");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        <form action="group_course_process.php?action=group" name="frm" method="post" id="frm" onSubmit="return chk();">
                          <table width="100%" height="90" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="13%">&nbsp;</td>
                              <td width="35%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="17%">&nbsp;</td>
                              <td width="34%" rowspan="6" align="left" valign="top"><br />
                                <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                  <tr>
                                    <td height="25" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                  <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?> :</span> <span class="shop2"><?php echo $ress["name"];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:20%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="29%" align="left" valign="middle" class="shop2">&nbsp;20%</td>
                              </tr>
                            </table></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT");?></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><input name="group" type="text" class="validate[required] new_textbox190" id="group" value="<?php echo $_SESSION[group_name];?>" autocomplete="off" onKeyUp="showgroup();" onBlur="checkTab('group');"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="55" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle" class="leftmenu" id="lblgroup">&nbsp;</td>
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
                              <td height="25" align="left" valign="middle" class="leftmenu"><a href="group_course.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/></td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
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
                </table></td>
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
                      <td width="16%" align="left"><a href="home.php"> <img src="../images/cancel_btn2.png" width="143" height="23" border="0" align="left" class="btn2"/></a></td>
                      <td width="18%">&nbsp;</td>
                      <td width="7%" align="left">&nbsp;</td>
                      <td width="7%" align="left">&nbsp;</td>
                      
                      <td width="52%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="09061986") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2F4"><img src="../images/errror.png" width="32" height="32" /></td>
                          <td width="10" bgcolor="#FFF2F4">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2F4" class="home_head_text"><?php echo constant("CD_GROUP_GROUPNAMEEXIST");?></th></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                              <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("GROUP_NAME");?></span></td>
                              <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                            <tr>
                              <td align="center" valign="top" bgcolor="#EBEBEB">
                              <form action="group_course_process.php?action=group" name="frm" method="post" id="frm" onSubmit="return chk();">
                                <table width="100%" height="90" border="0" cellpadding="0" cellspacing="0" >
                                  <tr>
                                    <td width="34%" rowspan="6" align="center" valign="top"><br />
                                      <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                        <tr>
                                          <td height="25" align="left" valign="middle">&nbsp;</td>
                                          </tr>
                                        <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                        <tr>
                                          <td align="right" valign="top"> <span class="shop2"><?php echo $ress["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></span></td>
                                          </tr>
                                        <tr>
                                          <td height="5" align="left" valign="top"></td>
                                          </tr>
                                        <tr>
                                          <td height="5" align="left" valign="top"></td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="top">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td height="5" align="left" valign="top"></td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="top">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td height="5" align="left" valign="top"></td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="top">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td height="5" align="left" valign="top"></td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="top">&nbsp;</td>
                                          </tr>
                                        <tr>
                                          <td align="left" valign="top">&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    <td width="17%">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="35%">&nbsp;</td>
                                    <td width="13%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="29%" align="right" valign="middle" class="shop2">20%&nbsp;</td>
                                        <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                        <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                          <div class="meter-value" style="background-color:#847B7B; width:20%;">
                                            <div style="border:solid 1px; border-color:#847B7B; "></div>
                                            </div>
                                          </div></td>
                                          <td width="16%" align="left" valign="middle" class="shop1">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                        
                                        </tr>
                                      </table></td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT");?></td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><input name="group" type="text" class="validate[required] new_textbox190_ar" id="group" value="<?php echo $_SESSION[group_name];?>" autocomplete="off" onKeyUp="showgroup();" onBlur="checkTab('group');"/></td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="55" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td align="left" valign="middle" class="leftmenu" id="lblgroup">&nbsp;</td>
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
                                    <td align="right"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td height="25" align="left" valign="middle" class="leftmenu"><a href="group_course.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="5" align="left" valign="middle"></td>
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
                        </table></td>
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
