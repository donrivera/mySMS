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

$student_id = $_SESSION[student_id];
$res = $dbf->strRecordID("student","*","id='$student_id'");

include_once '../includes/language.php';

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
<script type="text/javascript">
function gotfocus()
{
  document.getElementById('name').focus();
}
</script>
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
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;">&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=finished" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="4" rowspan="3" align="left" valign="middle" class="lable1">
							
							<table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                              <tr>
                                <td width="11%" height="35" align="center" valign="middle" bgcolor="#FEF5D8"><img src="../images/tick.png" width="16" height="16"></td>
                                <td width="2%" bgcolor="#FEF5D8">&nbsp;</td>
                                <td width="87%" align="left" valign="middle" bgcolor="#FEF5D8" class="shop1"><?php echo constant("STUDENT_ADVISOR_S_FINISH_SUCMSG");?></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td width="10%">&nbsp;</td>
                            <td width="19%" align="left" valign="middle" class="lable1">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="26%" align="left" valign="middle" class="lable1">&nbsp;</td>
                            <td width="44%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="center" valign="middle" class="leftmenu"></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_goto_btn");?>" class="btn1"/></td>
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
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;">&nbsp;</td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="s1_process.php?action=finished" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" rowspan="3" align="left" valign="middle" class="lable1">
                                          
                                          <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                            <tr>
                                              
                                              
                                              <td width="87%" align="right" valign="middle" bgcolor="#FEF5D8" class="shop1"><?php echo constant("STUDENT_ADVISOR_S_FINISH_SUCMSG");?></td>
                                              <td width="2%" bgcolor="#FEF5D8">&nbsp;</td>
                                              <td width="11%" height="35" align="center" valign="middle" bgcolor="#FEF5D8"><img src="../images/tick.png" width="16" height="16"></td>
                                              </tr>
                                            </table></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td width="10%">&nbsp;</td>
                                        <td width="19%" align="left" valign="middle" class="lable1">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="26%" align="left" valign="middle" class="lable1">&nbsp;</td>
                                        <td width="44%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="25" align="center" valign="middle" class="leftmenu"></td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_goto_btn");?>" class="btn2"/></td>
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
