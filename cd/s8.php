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

$student_id = $_SESSION[student_id];
$res = $dbf->strRecordID("student","*","id='$student_id'");

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
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

function gotfocus()
{
  document.getElementById('lead1').focus();
}
function checkTab(id)
{
	if(id=="lead")
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
                <td width="8%" align="left"></td>
                <td width="8%" align="left"></td>
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
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S87_LTEXT");?> &nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=aboutus" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="18%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="24%">&nbsp;</td>
                            <td width="52%" rowspan="9" align="left" valign="top" style="padding-top:3px;">
                            <br>
                            <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                              <tr>
                                <td height="25" align="left" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S2_NAME");?> :</span> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span></td>
                              </tr>
                              <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?> :</span> <span class="shop2"><?php echo $rescc["value"];?></span></td>
                              </tr>
                              <?php if($_SESSION[student_id] != ''){?>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?> :</span> <span class="shop2"><?php echo $_SESSION[student_id];?></span></td>
                              </tr>
                              <?php } ?>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?> :</span> <span class="shop2"><?php echo $_SESSION[alt_no];?></span></td>
                              </tr>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?> :</span> <span class="shop2"><?php echo $_SESSION[alt_no];?></span></td>
                              </tr>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?> :</span> <span class="shop2"><?php echo $_SESSION[email];?></span></td>
                              </tr>
                              <tr>
                                <td height="5" align="left" valign="top"></td>
                              </tr>
                              <?php
							  if($_SESSION[group] != ''){
								$ress = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");
							  ?>
                              <tr>
                                <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S6_STATUS");?> :</span> <span class="shop2"><?php echo $ress[group_name];?></span></td>
                              </tr>
                              <?php } ?>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="18%" align="left" valign="middle"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:90%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="9%" align="center" valign="middle" class="shop2">90%</td>
                              </tr>
                            </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="top" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S87_LTEXT");?> </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td rowspan="3" align="left" valign="top" class="mytext">
							<?php
							$i = 1;
							//echo $student_id;
							$leadid=explode(',',$_SESSION[leadid]);
							$num11=$dbf->countRows('common',"type='lead type'");
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) 
							{
							?>
							<input name="lead<?php echo $i;?>" id="lead<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if(in_array($valc[id], $leadid)) { ?> checked="checked" <?php } if($num11==$i) { ?> onBlur="checkTab('lead');" <?php } ?>><?php echo $valc["name"];?><br>
							<?php
							$i = $i + 1;
							}
							?>
							<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="top" class="leftmenu"><?php echo constant("TYPE_OF_STUDENTS");?></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">
                            <?php
							$t = 1;
							//echo $student_id;
							$typeid=explode(',',$_SESSION[typeid]);
							foreach($dbf->fetchOrder('common',"type='Type'","") as $valt) 
							{
							?>
							<input name="type<?php echo $t;?>" id="type<?php echo $t;?>" type="checkbox" value="<?php echo $valt["id"];?>" <?php if(in_array($valt[id], $typeid)) { ?> checked="checked" <?php } ?>><?php echo $valt["name"];?><br>
							<?php
							$t = $t + 1;
							}
							?>
							<input type="hidden" name="tcount" id="tcount" value="<?php echo $t-1;?>">
                            </td>
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
                            <td height="25" align="center" valign="middle" class="leftmenu"><a href="s7.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
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
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S87_LTEXT");?> &nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=aboutus" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="52%" rowspan="8" align="center" valign="top" style="padding-top:3px;">
                              <br>
                              <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                <tr>
                                  <td height="25" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S2_NAME");?></span></td>
                                  </tr>
                                <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $rescc["value"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?></span></td>
                                  </tr>
                                  <?php if($_SESSION[student_id] != ''){?>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top">  <span class="shop2"><?php echo $_SESSION[student_id];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?></span></td>
                                  </tr>
                                  <?php } ?>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[alt_no];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?> </span></td>
                                  </tr>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[alt_no];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?></span></td>
                                  </tr>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="right" valign="top">  <span class="shop2"><?php echo $_SESSION[email];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?></span></td>
                                  </tr>
                                <tr>
                                  <td height="5" align="right" valign="top"></td>
                                  </tr>
                                <?php
								if($_SESSION[group] != ''){
								$ress = $dbf->strRecordID("student_group","*","id='$_SESSION[group]'");
								?>
                                <tr>
                                  <td align="right" valign="top"> <span class="shop2"><?php echo $ress[group_name];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S6_STATUS");?></span></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <td align="right" valign="top">&nbsp;</td>
                                  </tr>
                              </table></td>
                            <td>&nbsp;</td>
                            <td width="2%">&nbsp;</td>
                            <td width="27%">&nbsp;</td>
                            <td width="4%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="9%" align="center" valign="middle" class="shop2">90%</td>
                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:90%;">
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
                            <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S87_LTEXT");?> </td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td rowspan="2" align="left" valign="top" class="mytext">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="mytext">
                              <?php
							$i = 1;
							//echo $student_id;
							$leadid=explode(',',$_SESSION[leadid]);
							$num11=$dbf->countRows('common',"type='lead type'");
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc){
							echo $valc["name"];
							?>
                              <input name="lead<?php echo $i;?>" id="lead<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if(in_array($valc[id], $leadid)) { ?> checked="checked" <?php } if($num11==$i) { ?> onBlur="checkTab('lead');" <?php } ?>><br>
                              <?php
							$i = $i + 1;
							}
							?>
                              <input type="hidden" name="count2" id="count2" value="<?php echo $i-1;?>">
                            </td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="28" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;<?php echo constant("TYPE_OF_STUDENTS");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="15%" align="right" valign="top"></td>
                            <td>&nbsp;</td>
                            <td height="28" align="right" valign="top" class="mytext">
							<?php
							$t = 1;
							//echo $student_id;
							$typeid=explode(',',$_SESSION[typeid]);
							foreach($dbf->fetchOrder('common',"type='Type'","") as $valt){
							echo $valt["name"];
							?>
                              <input name="type<?php echo $t;?>" id="type<?php echo $t;?>" type="checkbox" value="<?php echo $valt["id"];?>" <?php if(in_array($valt[id], $typeid)) { ?> checked="checked" <?php } ?>>
                              <br>
                              <?php
							$t = $t + 1;
							}
							?>
                              <input type="hidden" name="tcount2" id="tcount2" value="<?php echo $t-1;?>"></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                             <td align="right"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                             <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td height="25" align="center" valign="middle" class="leftmenu"><a href="s7.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                             
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
