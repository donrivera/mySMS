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
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" bgcolor="#FFA938" class="logintext"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_PRINTPROGRESS");?></td>
                <td width="22%" bgcolor="#FFA938">&nbsp;</td>
                <td width="8%" align="left" bgcolor="#FFA938">&nbsp;</td>
                <td width="14%" align="left" bgcolor="#FFA938">&nbsp;</td>
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
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                      <form action="report_center_director_print.php?teacher_id=<?=$_REQUEST[teacher_id];?>&group_id=<?=$_REQUEST[group_id];?>" name="frm" method="post" id="frm" >
                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="14%">&nbsp;</td>
                            <td width="70%" height="250" align="center" valign="middle">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                              <tr>
                                <td height="30" bgcolor="#FF9900" class="lable1">&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_PRINTPROGRESS");?></td>
                                <td bgcolor="#FF9900">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="59%">&nbsp;</td>
                                <td width="34%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="2" align="center" class="nametext1"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_WANTPRINTPROGRESS");?></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="right" valign="middle" style="padding-right:5px;"><a href="report_teacher_progress_print.php?teacher_id=<?=$_REQUEST[teacher_id];?>&group_id=<?php echo $_REQUEST[group_id];?>" target="_blank"><input type="button" value="<?php echo constant("btn_btn_yes");?>" class="btn_yes" border="0" align="left" /></a></td>
                                <td align="left" valign="middle" style="padding-left:5px;"><a href="report_teacher_progress.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>"><input type="button" value="<?php echo constant("btn_btn_no");?>" class="btn_no" border="0" align="left" /></a></td>
                              </tr>
                              <tr>
                                <td align="right" valign="middle" style="padding-right:5px;">&nbsp;</td>
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
          <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext"><table width="100%" border="0" cellspacing="0">
            <tr>
              
              <td width="22%" bgcolor="#FFA938">&nbsp;</td>
              <td width="8%" align="left" bgcolor="#FFA938">&nbsp;</td>
              <td width="14%" align="left" bgcolor="#FFA938">&nbsp;</td>
              <td width="54%" height="30" align="right" bgcolor="#FFA938" class="logintext"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_PRINTPROGRESS");?></td>
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
              <tr>
                <td align="left" valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                    <tr>
                      <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="report_center_director_print.php?teacher_id=<?=$_REQUEST[teacher_id];?>&group_id=<?=$_REQUEST[group_id];?>" name="frm" method="post" id="frm" >
                          <table width="90%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="14%">&nbsp;</td>
                              <td width="70%" height="250" align="center" valign="middle">
                                
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                  <tr>
                                    
                                    <td bgcolor="#FF9900">&nbsp;</td>
                                    <td height="30" align="right" bgcolor="#FF9900" class="lable1">&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_PRINTPROGRESS");?></td>
                                    </tr>
                                  <tr>
                                    
                                    <td width="34%">&nbsp;</td>
                                    <td width="59%">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td colspan="2" align="center" class="nametext1"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_CONDITION_WANTPRINTPROGRESS");?></td>
                                    </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    </tr>
                                  <tr>
                                    
                                    <td align="right" valign="middle" style="padding-right:5px;"><a href="report_teacher_progress.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>"><input type="button" value="<?php echo constant("btn_btn_no");?>" class="btn_yes" border="0" align="left" /></a></td>
                                    <td align="left" valign="middle" style="padding-left:5px;"><a href="report_teacher_progress_print.php?teacher_id=<?=$_REQUEST[teacher_id];?>&group_id=<?php echo $_REQUEST[group_id];?>" target="_blank"><input type="button" value="<?php echo constant("btn_btn_yes");?>" class="btn_no" border="0" align="left" /></a></td>
                                    </tr>
                                  <tr>
                                    
                                    <td align="left" valign="middle" style="padding-left:5px;">&nbsp;</td>
                                    <td align="right" valign="middle" style="padding-right:5px;">&nbsp;</td>
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