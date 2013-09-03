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

$student_id = $_SESSION[student_id];
$res = $dbf->strRecordID("student","*","id='$student_id'");

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
               
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_STUDENT_DETAILS");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=insert" name="frm" method="post" id="frm">
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
                            <td height="25" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="32%" align="right" valign="middle"><?php echo constant("PROGRESS_BAR");?>&nbsp;</td>
                                <td width="59%" align="left" valign="middle" style="padding-left:2px;">
                                  <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                    <div class="meter-value" style="background-color:#847B7B; width:100%;">
                                      <div style="border:solid 1px; border-color:#847B7B; "></div>
                                      </div>
                                    </div></td>
                                <td width="9%" align="center" valign="middle" class="shop2">100%</td>
                                </tr>
                            </table></td>
                            <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext">&nbsp;</td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S10_STDNAME");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?> : </td>
                            <td>&nbsp;</td>
							 <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                            <td align="left" valign="middle" class="mytext"><?php echo $rescc["value"];?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php if($_SESSION[student_id] != ''){?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $_SESSION[student_id];?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php } ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $_SESSION[mobile_no];?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                          <?php if($_SESSION[alt_no]!= '') { ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $_SESSION[alt_no];?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $_SESSION[email];?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                          <?php if($_SESSION[group] != ''){?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S10_ASSIGNEDGROUP");?> : </td>
                            <td>&nbsp;</td>
                            <?php
							$res_g = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");
							?>
                            <td align="left" valign="middle" class="mytext"><?php echo $res_g["group_name"];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <?php if($_SESSION[student_comment] != ''){?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S10_COMMENTS");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><?php echo $_SESSION[student_comment];?></td>
                            <td align="right" valign="middle" class="mytext">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <?php if($_SESSION[courseid] != ''){?>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S10_INTEREST");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext">
							<?php
							$c ='';
							$courseid=explode(',',$_SESSION[courseid]);
							//foreach($dbf->fetchOrder('student_course',"student_id='$student_id'","") as $valc) {
							foreach($dbf->fetchOrder('course',"","") as $valc) 
							{
								if(in_array($valc[id], $courseid))
								{
									if($c == '')
									{
										$c = $valc["name"];
									}
									else
									{
										$c = $c."&nbsp;,&nbsp;".$valc["name"];
									}
								}
							}
							echo $c;
							?>
							</td>
                            <td align="right" valign="middle" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php }?>
                          <tr>
                            <td width="9%">&nbsp;</td>
                            <td width="24%" align="left" valign="middle" class="lable1">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="57%" align="left" valign="middle" class="lable1">&nbsp;</td>
                            <td width="9%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="center" valign="middle" class="leftmenu"><a href="s8.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                            <td>&nbsp;</td>
                            <td colspan="2" align="center" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_finish_btn");?>" class="btn1"/></td>
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
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_AGE_STUDENT_DETAILS");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=insert" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="25" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="9%" align="center" valign="middle" class="shop2">100%</td>
                                <td width="61%" align="left" valign="middle" style="padding-left:2px;">
                                  <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                    <div class="meter-value" style="background-color:#847B7B; width:100%;">
                                      <div style="border:solid 1px; border-color:#847B7B; "></div>
                                      </div>
                                    </div></td>
                                    <td width="30%" align="left" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                </tr>
                            </table></td>
                            </tr>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S10_STDNAME");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                            <td align="right" valign="middle" class="mytext"><?php echo $rescc["value"];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php if($_SESSION[student_id] != ''){?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $_SESSION[student_id];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php }?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $_SESSION[mobile_no];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php if($_SESSION[alt_no]!= '') { ?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $_SESSION[alt_no];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php } ?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $_SESSION[email];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <?php
							$ress = $dbf->strRecordID("common","*","id='$_SESSION[status]'");
							?>
                            <td align="right" valign="middle" class="mytext"><?php echo $ress["name"];?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S6_STATUS");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php if($_SESSION[group] != ''){?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <?php
							$res_g = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");
							?>
                            <td align="right" valign="middle" class="mytext"><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?>&nbsp;</td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_S10_ASSIGNEDGROUP");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php } ?>
                          <?php if($_SESSION[student_comment] != ''){?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $_SESSION[student_comment];?>&nbsp;</td>
                            <td align="left" valign="middle" class="mytext"><span class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_S10_COMMENTS");?></span></td>
                            <td align="left" valign="middle" class="mytext">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <?php if($_SESSION[courseid] != ''){?>
                          <tr>
                            <td height="25">&nbsp;</td>
                            <td align="right" valign="middle" class="mytext">
                              <?php
							$c ='';
							$courseid=explode(',',$_SESSION[courseid]);
							foreach($dbf->fetchOrder('course',"","") as $valc) 
							{
								if(in_array($valc[id], $courseid))
								{
									if($c == '')
									{
										$c = $valc["name"];
									}
									else
									{
										$c = $c."&nbsp;,&nbsp;".$valc["name"];
									}
								}
							}
							echo $c;
							?>&nbsp;
                            </td>
                            <td align="left" valign="middle" style="padding-top:3px;"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S10_INTEREST");?></span></td>
                            <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          <?php } ?>
                          <tr>
                            <td width="14%">&nbsp;</td>
                            <td width="44%" align="left" valign="middle" class="lable1">&nbsp;</td>
                            <td width="20%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            <td width="22%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td height="10" colspan="4" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_finish_btn");?>" class="btn2"/></td>
                            <td height="25" colspan="2" align="center" valign="middle"><a href="s8.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
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
