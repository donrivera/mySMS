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
echo $_SESSION["centre_id"];
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
</script>	
<!--JQUERY VALIDATION ENDS-->
<script type="text/javascript">
function gotfocus()
{
  document.getElementById('course').focus();
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> 
                <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" />
                <!--<img src="../images/cancel_btn2.png" width="143" height="23" border="0" align="left" /></a></td>-->
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
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("CD_EP_ADDING_STUDENT_RECADD");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_COURSE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_course_process.php?action=insert" name="frm" method="post" id="frm">
                          <table width="100%" height="90" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="13%">&nbsp;</td>
                              <td width="25%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="39%">&nbsp;</td>
                              <td width="22%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="20%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="51%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#ffffff; border:solid 1px; border-color:#999999;">
                                  <div class="meter-value" style="background-color:#847B7B; width:0%;">
                                    <div style="border:solid 1px; "></div>
                                  </div>
                                </div>
                                </td>
                                <td width="29%" align="left" valign="middle" class="shop2">&nbsp;0%</td>
                              </tr>
                            </table></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="4" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT1");?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu">
                                <select name="course" class="validate[required]" id="course" style="width:300px; border:solid 1px; border-color:#999999;">
                                  <option value="">--Select Course--</option>
                                  <?php
								foreach($dbf->fetchOrder('course',"","") as $ress) {
								  ?>
                                  <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$_SESSION[gr_course_id]) {?> selected="selected" <?php } ?>> <?php echo $ress['name'];?></option>
                                  <?php }?>
                                </select></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu"></td>
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
<?php } else {?>
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
                <td width="15%" align="left"><a href="home.php">
                <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                <!-- <img src="../images/cancel_btn2.png" width="143" height="23" border="0" align="left" class="btn2"/>--></a></td>
                <td width="19%">&nbsp;</td>
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
              <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                    <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("CD_EP_ADDING_STUDENT_RECADD");?></td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                  
                  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="right" valign="middle" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_COURSE");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="group_course_process.php?action=insert" name="frm" method="post" id="frm">
                              <table width="100%" height="90" border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                  <td width="13%">&nbsp;</td>
                                  <td width="25%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="39%">&nbsp;</td>
                                  <td width="22%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td width="29%" align="right" valign="middle" class="shop2">&nbsp;0%</td>
                                      
                                      <td width="51%" align="left" valign="middle" style="padding-left:2px;">
                                      <div class="meter-wrap" style="background-color:#ffffff; border:solid 1px; border-color:#999999;">
                                          <div class="meter-value" style="background-color:#847B7B; width:0%;">
                                            <div  style="border:solid 1px; "></div>
                                          </div>
                                        </div>
                                      </td>
                                      <td width="20%" align="right" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                      </tr>
                                    </table></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT1");?></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" colspan="3" align="right" valign="middle">
                                  <select name="course" class="validate[required]" id="course" style="width:300px; border:solid 1px; border-color:#999999;">
                                    <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
                                    <?php
									foreach($dbf->fetchOrder('course',"","") as $ress) {
								  	?>
                                    <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$_SESSION[gr_course_id]) {?> selected="selected" <?php } ?>> <?php echo $ress['name'];?></option>
                                    <?php }?>
                                  </select></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="5" align="left" valign="middle"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="25" align="left" valign="middle" class="leftmenu"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/>
                                  </td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left">&nbsp;</td>
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
