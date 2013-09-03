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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$student_id = $_REQUEST['student_id'];
$course_id = $_REQUEST['course_id'];
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<script language="javascript" type="text/javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll)
{
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMS");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="14%" align="left"><a href="search_manage.php?student_id=<?php echo $student_id;?>&course_id=<?php echo $course_id;?>"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
            
            <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;">&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <?php $val = $dbf->strRecordID("student","*","id='$_REQUEST[id]'"); ?>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                          <form action="search_manage_mail_process.php?student_id=<?=$student_id;?>" name="frm" method="post" id="frm" >
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="14%">&nbsp;</td>
                                <td width="70%" height="250" align="center" valign="middle">
                                
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                  <tr>
                                    <td height="30" bgcolor="#FF9900">&nbsp;</td>
                                    <td bgcolor="#FF9900" class="lable1">&nbsp;&nbsp;<?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMSTO");?> <?php echo $val["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                                    <td bgcolor="#FF9900">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="7%">&nbsp;</td>
                                    <td width="59%">&nbsp;</td>
                                    <td width="34%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" align="center" class="nametext1"><?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMSFORPAYMENT");?></td>
                                    </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="6%" align="center" valign="middle">
										<script language="JavaScript" type="text/javascript">
										function showsms(val){
											if(val == "3"){
												document.getElementById('smsid').style.display = "block";
											}else{
												document.getElementById('smsid').style.display = "none";
											}
										}
				                    </script>
                                          <input name="sms" type="radio" id="radio" value="1" checked="checked" onChange="showsms(this.value)" /></td>
                                        <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
                                      </tr>
                                      <tr>
                                        <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onChange="showsms(this.value)" /></td>
                                        <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                      </tr>
                                      <tr>
                                        <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                                        <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                      </tr>
                                      <tr>
                                        <td align="center" valign="middle">&nbsp;</td>
                                        <?php
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
										?>
                                        <td align="left" valign="middle" class="mytext">
                                        <table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                          <tr>
                                            <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:400px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    </table></td>
                                    </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td align="right" valign="middle" style="padding-right:5px;">
                                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_confirm");?>" class="btn_yes"/></td>
                                    <td align="left" valign="middle" style="padding-left:5px;">&nbsp;</td>
                                  </tr>
                                </table></td>
                                <td width="16%">&nbsp;</td>
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
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
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
                  <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="14%" align="left"><a href="search_manage.php?id=<?php echo $_REQUEST[id];?>"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      
                      <td width="54%" height="30" class="logintext" align="right"><?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMS");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                  </tr>
                <tr>
                  <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                    
                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                            <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;">&nbsp;</td>
                            <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                            </tr>
                          </table></td>
                        </tr>
                      <?php $val = $dbf->strRecordID("student","*","id='$_REQUEST[id]'"); ?>
                      <tr>
                        <td align="left" valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                            <tr>
                              <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="search_manage_mail_process.php?id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm" >
                                  <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="14%">&nbsp;</td>
                                      <td width="70%" height="250" align="center" valign="middle">
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                          <tr>
                                            <td height="30" bgcolor="#FF9900">&nbsp;</td>
                                            <td bgcolor="#FF9900" class="lable1">&nbsp;&nbsp;<?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMSTO");?> <?php echo $val["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                                            <td bgcolor="#FF9900">&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td width="7%">&nbsp;</td>
                                            <td width="59%">&nbsp;</td>
                                            <td width="34%">&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td colspan="3" align="center" class="nametext1"><?php echo constant("CD_SEARCH_MANAGE_MAIL_ALERTSMSFORPAYMENT");?></td>
                                            </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                
                                                <td width="94%" align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
                                                <td width="6%" align="center" valign="middle">
                                                  <script language="JavaScript" type="text/javascript">
													function showsms(val){
														if(val == "3"){
															document.getElementById('smsid').style.display = "block";
														}else{
															document.getElementById('smsid').style.display = "none";
														}
													}
												</script>
                                                  <input name="sms" type="radio" id="radio" value="1" checked="checked" onChange="showsms(this.value)" /></td>
                                                </tr>
                                              <tr>
                                                <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                                <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onChange="showsms(this.value)" /></td>
                                              </tr>
                                              <tr>
                                                <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                                <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                                              </tr>
                                              <tr>
                                                <td align="center" valign="middle">&nbsp;</td>
                                                <?php
												$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
												?>
                                                <td align="left" valign="middle" class="mytext">
                                                  <table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                                    <tr>
                                                      <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:400px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                              </table></td>
                                            </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle" style="padding-right:5px;">
                                              <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_confirm");?>" class="btn_no"/></td>
                                            <td align="left" valign="middle" style="padding-left:5px;">&nbsp;</td>
                                            </tr>
                                          </table></td>
                                      <td width="16%">&nbsp;</td>
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
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>