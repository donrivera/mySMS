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
function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}

function hideme(){
	if(document.getElementById('id_typen').checked == true){
		document.getElementById('lblp').style.display = 'block';
	}else{
		document.getElementById('lblp').style.display = 'none';	
	}
}

function check(){
	if(document.getElementById('country').value == '189'){
		if(document.getElementById('id_typen').checked == true){
			if(document.getElementById('studentid').value == ''){
				document.getElementById('iderror').style.display = '';	
				document.getElementById('studentid').focus();
				return false;
			}else{
				document.getElementById('iderror').style.display = 'none';
			}
		}
	}else{
		document.getElementById('iderror').style.display = 'none';
	}
}

function gotfocus()
{
  document.getElementById('country').focus();
}
function checkTab(id)
{
	if(id=="studentid")
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
			  <?php if($_REQUEST[msg]=="invalid") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("STUDENT_ADVISOR_S2_INVALIDID");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              
			  <?php if($_REQUEST[msg]=="idexist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("STUDENT_ADVISOR_S2_STDIDALREDYEXT");?> </td>
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
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_COUNTRY_ID");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=country" name="frm" method="post" id="frm" onSubmit="return check();">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="19%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="32%">&nbsp;</td>
                            <td width="46%" rowspan="9" align="left" valign="top" style="padding-top:3px;">
                            <br>
                            <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                              <tr>
                                <td align="left" valign="middle">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="150" align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S2_NAME");?> :</span> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span></td>
                              </tr>
                            </table>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" colspan="3" align="center" valign="middle" class="leftmenu">
                              
                              <div id="iderror" style="display:none;">
                                <table width="192" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                  <tr>
                                    <td align="center" valign="middle" bgcolor="#FBBBC5" class="leftmenu"><?php echo constant("ENTER_STUDENT_ID");?></td>
                                    </tr>
                                  </table>
                              </div>
                              <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="18%" align="left" valign="middle"><?php echo constant("PROGRESS_BAR");?></td>
                                  <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                  <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                    <div class="meter-value" style="background-color:#847B7B; width:20%;">
                                      <div style="border:solid 1px; border-color:#847B7B; "></div>
                                    </div>
                                  </div>
                                  </td>
                                  <td width="9%" align="center" valign="middle" class="shop2">20%</td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" >&nbsp;</td>
                          </tr>
                          <?php
							if($_SESSION[country]!=''){
								$cid = $_SESSION[country];
							}else{
								$cid = "189";
							}								
							?>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu">
							<?php echo constant("STUDENT_ADVISOR_S2_COUNTRY");?> : <span class="nametext1">*</span> </td>
                            <td></td>
                            <td align="left" valign="middle" >
							<select name="country" class="combo" id="country" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF; font:Verdana, Geneva, sans-serif; font-size:12px;" >
                                <option value="">--- Select Country ---</option>
                                <?php
									foreach($dbf->fetchOrder('countries',"","") as $resc) {
								?>
                                <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                <?php }?>
                            </select></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ID_TYPE");?> :&nbsp;</td>
                            <td>&nbsp;</td>
                            <?php
							$v = $_SESSION[id_type];
							if($v == ''){ $v = 'National ID'; }
							?>
                            <td align="left" valign="middle"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="9%" align="left" valign="middle" class="hometest_name">
                                <input name="id_type" type="radio" id="id_typen" onChange="hideme();" value="National ID" <?php if($v == "National ID") { ?> checked="checked" <?php } ?>></td>
                                <td width="50%" align="left" valign="middle" class="hometest_name">
								<?php echo constant("NATIONAL_ID_IQAMA");?></td>
                                <td width="9%" align="left" valign="middle" class="hometest_name">
                                <input type="radio" name="id_type" id="id_typep" onChange="hideme();" value="Passport" <?php if($v != "National ID") { ?> checked="checked" <?php } ?>></td>
                                <td width="32%" align="left" valign="middle" class="hometest_name"><?php echo constant("PASSPORT");?></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S2_STDIDNO");?>&nbsp;:<span id="lblp" class="nametext1">*</span></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">
                            <input name="studentid" type="text" class="new_textbox190" id="studentid" value="<?php echo $_SESSION[student_id];?>" onKeyPress="return PhoneNo(event);" maxlength="10" onBlur="checkTab('studentid');"/></td>  <!--onBlur="check();"-->
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">
                            <!--<div id="iderror" style="display:none;">
                            <table width="192" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                              <tr>
                                <td align="center" valign="middle" bgcolor="#FBBBC5" class="leftmenu">Enter Student ID</td>
                              </tr>
                            </table>
                            </div>-->
                            </td>
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
                            <td height="25" align="center" valign="middle" class="leftmenu"><a href="s1.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <?php
							if($cid == '189')
							{
								$dd = "none";
							}
							else
							{
								$dd = '';
							}
							?>
                            <td align="left">
                            <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/>                            
                            </td>
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
                      <td width="8%" align="left"></td>
                      <td width="8%" align="left"></td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="invalid") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                          <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("STUDENT_ADVISOR_S2_INVALIDID");?> </td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    
                    <?php if($_REQUEST[msg]=="idexist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
                          <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("STUDENT_ADVISOR_S2_STDIDALREDYEXT");?> </td>
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
                                <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_COUNTRY_ID");?>&nbsp;</td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                                <tr>
                                  <td align="center" valign="top" bgcolor="#EBEBEB">
                                    
                                    <form action="s1_process.php?action=country" name="frm" method="post" id="frm" onSubmit="return check();">
                                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                        <tr>
                                          <td width="51%" rowspan="9" align="center" valign="top" style="padding-top:3px;">
                                            <br>
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                              <tr>
                                                <td align="left" valign="middle">&nbsp;</td>
                                                </tr>
                                              <tr>
                                                <td height="150" align="right" valign="top"> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S2_NAME");?></span></td>
                                                </tr>
                                              </table>
                                            </td>
                                          <td width="28%">&nbsp;</td>
                                          <td width="1%">&nbsp;</td>
                                          <td width="18%">&nbsp;</td>
                                          <td width="2%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        <td height="28" colspan="3" align="center" valign="middle" class="leftmenu">
                                            
                                            <div id="iderror" style="display:none;">
                                              <table width="192" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                                                <tr>
                                                  <td align="center" valign="middle" bgcolor="#FBBBC5" class="leftmenu"><?php echo constant("ENTER_STUDENT_ID");?></td>
                                                  </tr>
                                                </table>
                                              </div>
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="9%" align="center" valign="middle" class="shop2">20%</td>
                                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                                  <div class="meter-value" style="background-color:#847B7B; width:20%;">
                                                    <div class="meter-text"></div>
                                                    </div>
                                                  </div></td>                                                
                                                <td width="18%" align="left" valign="middle">&nbsp;&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                                </tr>
                                              </table></td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          
                                          </tr>
                                        <tr>
                                          <td align="left" valign="middle" >&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <?php
											if($_SESSION[country]!=''){
												$cid = $_SESSION[country];
											}else{
												$cid = "189";
											}									
											?>
                                          <td height="25" align="right" valign="middle" >
                                          <select name="country" class="combo" id="country" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF; font:Verdana, Geneva, sans-serif; font-size:12px;" >
                                              <option value="">--- <?php echo constant("SELECT_COUNTRY");?> ---</option>
                                              <?php
												foreach($dbf->fetchOrder('countries',"","") as $resc) {
											  ?>
                                              <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                              <?php }?>
                                              </select>
                                             </td>
                                          <td>&nbsp;</td>
                                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S2_COUNTRY");?></td>
                                          
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                        <tr>
                                         
                                          <?php
											$v = $_SESSION[id_type];
											if($v == ''){ $v = 'National ID'; }
											?>
                                          <td align="right" valign="middle"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                             <td width="40%" align="right" valign="middle" class="mytext">
                                                <?php echo constant("NATIONAL_ID_IQAMA");?></td>
                                              <td width="10%" align="left" valign="middle" class="hometest_name">
                                                <input name="id_type" type="radio" id="id_typen" onChange="hideme();" value="National ID" <?php if($v == "National ID") { ?> checked="checked" <?php } ?>></td>
          									 <td width="40%" align="right" valign="middle" class="mytext"><?php echo constant("PASSPORT");?></td>                                  
                                              <td width="10%" align="left" valign="middle" class="hometest_name">
                                                <input type="radio" name="id_type" id="id_typep" onChange="hideme();" value="Passport" <?php if($v != "National ID") { ?> checked="checked" <?php } ?>></td>
                                              
                                              </tr>
                                            </table></td>
                                          <td>&nbsp;</td>
                                           <td height="28" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("ID_TYPE");?></td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td align="right" valign="middle">
                                            <input name="studentid" type="text" class="new_textbox190_ar" id="studentid" value="<?php echo $_SESSION[student_id];?>" onKeyPress="return PhoneNo(event);" maxlength="10" onBlur="checkTab('studentid');"/></td>  <!--onBlur="check();"-->
                                          <td>&nbsp;</td>
                                          <td height="28" align="left" valign="middle" class="leftmenu"><span id="lblp" class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_S2_STDIDNO");?></td>
                                          
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          
                                        </tr>
                                        <tr>
                                          <td align="left" valign="middle"></td>
                                            <td>&nbsp;</td>
                                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
                                          <td align="right">
                                            <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/>                            
                                            </td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <?php
										if($cid == '189')
										{
											$dd = "none";
										}
										else
										{
											$dd = '';
										}
										?>
                                          <td height="25" align="center" valign="middle" class="leftmenu"><a href="s1.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                                          
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
