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

$res = $dbf->strRecordID("student","*","id='$_REQUEST[id]'");
$num=$dbf->countRows('student',"id='$_REQUEST[id]'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

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
		function PhoneNo(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90)))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	</script>	
<!--JQUERY VALIDATION ENDS-->

</head>
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
<body onload="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="logintext"><?php echo constant("STUDENT_INFORMATON");?> </td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp; </td>
                    <td width="8%" align="left"><a href="auto_search.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECEXIST");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="add") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_AUTO_SEARCH_EDIT_RECADD");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="mexist") { ?>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="idexist") { ?>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="maexist") { ?>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                <?php if($_SESSION["lang"] == "EN"){?>
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("UPDATNG_STUDENT_INFORMATON");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="auto_search_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" enctype="multipart/form-data">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="9%">&nbsp;</td>
                              <td width="33%">&nbsp;</td>
                              <td width="0%">&nbsp;</td>
                              <td width="54%">&nbsp;</td>
                              <td width="4%">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L1");?>: <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="nameenglish" type="text" class="validate[required] new_textbox190" id="nameenglish" size="45" minlength="4" value="<?php echo $res[first_name]; ?>"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L2");?>: <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="namearabic" type="text" class="new_textbox190" id="namearabic" size="45" minlength="4"value="<?php echo $res[arabic_name]; ?>"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L3");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="fatherenglish" type="text" class="validate[required] new_textbox190" id="fatherenglish" size="45" minlength="4" value="<?php echo $res[father_name]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L4");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="fatherarabic" type="text" class="new_textbox190" id="fatherarabic" size="45" minlength="4" value="<?php echo $res[father_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L5");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="grandenglish" type="text" class="validate[required] new_textbox190" id="grandenglish" size="45" minlength="4" value="<?php echo $res[grandfather_name]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L6");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="grandarabic" type="text" class="new_textbox190" id="grandarabic" size="45" minlength="4" value="<?php echo $res[grandfather_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L7");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="famlyenglish" type="text" class="validate[required] new_textbox190" id="famlyenglish" size="45" minlength="4" value="<?php echo $res[family_name]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L8");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="familyarabic" type="text" class="new_textbox190" id="familyarabic" size="45" minlength="4" value="<?php echo $res[family_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NATIONALITY");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <select name="country" id="country" style="width:190px; border:solid 1px; background-color:#ECF1FF;border-color:#999999;font:Verdana, Geneva, sans-serif; font-size:12px;">
                                <option value="">--- Select Country ---</option>
                                <?php
									if($res["country_id"]!='')
									{
										$cid = $res["country_id"];
									}
									else
									{
										$cid = "189";
									}
									foreach($dbf->fetchOrder('countries',"","") as $resc) {
								?>
                                <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                <?php }?>
                            </select></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <input type="radio" name="gender" id="gender" value="male" <?php if($res[gender]=='male') { ?> checked="checked" <?php } ?>/><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?><br/>
							  <input type="radio" name="gender" id="gender" value="female"<?php if($res[gender]=='female') { ?> checked="checked" <?php } ?> /><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_IDNUMB");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="sid" type="text" class="validate[required] new_textbox190" id="sid" size="45" minlength="4"value="<?php echo $res[student_id]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" size="45" minlength="4" value="<?php echo $res[student_mobile]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L9");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="altmobile" type="text" class="validate[required] new_textbox190" id="altmobile" size="45" minlength="4"value="<?php echo $res[alt_contact]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  <input name="email" type="text" class="validate[required,custom[email]] new_textbox190" id="email" size="45" minlength="4" value="<?php echo $res[email]; ?>"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STATUSFSTD");?> : </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><select name="status" id="status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                <?php
							foreach($dbf->fetchOrder('common',"type='student status'","") as $ress) {
							  ?>
                                <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$res["studentstatus_id"]) { echo "Selected"; }?>><?php echo $ress['name'] ?></option>
                                <?php }?>
                              </select></td>
							 
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_11"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INTERESTIN");?> : </label></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  <?php
							$i = 1;
							foreach($dbf->fetchOrder('course',"","") as $valc) {
							
							$n=$dbf->countRows('student_course',"student_id='$_REQUEST[id]' AND course_id='$valc[id]'");
						
							?>
							<input name="course<?php echo $i;?>" id="course<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if($n>0) { ?> checked="checked" <?php } ?>><?php echo $valc["name"];?><br>
							<?php
							$i = $i + 1;
							}
							?>
							
							<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>"></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_COMMENTS");?> </label>
                                :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"><?php echo $res["student_comment"];?></textarea></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?>?</label></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php
							$i1 = 1;
							//echo $student_id;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) {
							
							$n11=$dbf->countRows('student_lead',"student_id='$_REQUEST[id]' AND lead_id='$valc[id]'");
							
							?>
							<input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if($n11>0) { ?> checked="checked" <?php } ?>><?php echo $valc["name"];?><br>
							<?php
							$i1 = $i1 + 1;
							}
							?>
							<input type="hidden" name="leadcount" id="leadcount" value="<?php echo $i1-1;?>"></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STDPHOTO");?>: </td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle"><input type="file" name="signature" id="signature" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle"><?php //echo "sdg".$photo; ?></td>
							  <?php if($res["photo"]!=''){
							  		$photo = "../sa/photo/".$res["photo"];
							  }else{
							  		$photo = "../images/noimage.jpg";
							  }
							  ?>
                              <td align="left" valign="middle"><img src="<?php echo $photo; ?>" width="100" height="100" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                              <td>&nbsp;</td>
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
                <?php }else{?>
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("UPDATNG_STUDENT_INFORMATON");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="auto_search_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" enctype="multipart/form-data">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>                            
                              <td width="4%">&nbsp;</td>
                              <td width="54%">&nbsp;</td>
                              <td width="0%">&nbsp;</td>
                              <td width="33%">&nbsp;</td>
                              <td width="9%">&nbsp;</td>
                            </tr>
                            <tr>                             
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="nameenglish" type="text" class="validate[required] new_textbox190" id="nameenglish" size="45" minlength="4" value="<?php echo $res[first_name]; ?>"/></td>
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L1");?></td>
                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="namearabic" type="text" class="new_textbox190" id="namearabic" size="45" minlength="4"value="<?php echo $res[arabic_name]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L2");?></td>
                             <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>                             
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="fatherenglish" type="text" class="validate[required] new_textbox190" id="fatherenglish" size="45" minlength="4" value="<?php echo $res[father_name]; ?>"/></td>
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L3");?></td>
                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="fatherarabic" type="text" class="new_textbox190" id="fatherarabic" size="45" minlength="4" value="<?php echo $res[father_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L4");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="grandenglish" type="text" class="validate[required] new_textbox190" id="grandenglish" size="45" minlength="4" value="<?php echo $res[grandfather_name]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L5");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="grandarabic" type="text" class="new_textbox190" id="grandarabic" size="45" minlength="4" value="<?php echo $res[grandfather_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L6");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>                              
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="famlyenglish" type="text" class="validate[required] new_textbox190" id="famlyenglish" size="45" minlength="4" value="<?php echo $res[family_name]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L7");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="familyarabic" type="text" class="new_textbox190" id="familyarabic" size="45" minlength="4" value="<?php echo $res[family_name1]; ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L8");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>                             
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
                              <select name="country" id="country" style="width:190px; border:solid 1px; background-color:#ECF1FF;border-color:#999999;font:Verdana, Geneva, sans-serif; font-size:12px;">
                                <option value="">--- Select Country ---</option>
                                <?php
									if($res["country_id"]!='')
									{
										$cid = $res["country_id"];
									}
									else
									{
										$cid = "189";
									}
									foreach($dbf->fetchOrder('countries',"","") as $resc) {
								?>
                                <option value="<?php echo $resc['id'];?>" <?php if($resc["id"]==$cid) { ?> selected="selected" <?php } ?>><?php echo $resc['value'];?></option>
                                <?php }?>
                            </select></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_NATIONALITY");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
                              <input type="radio" name="gender" id="gender" value="male" <?php if($res[gender]=='male') { ?> checked="checked" <?php } ?>/><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MALE");?><br/>
							  <input type="radio" name="gender" id="gender" value="female"<?php if($res[gender]=='female') { ?> checked="checked" <?php } ?> /><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_FEMALE");?></td>
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="sid" type="text" class="validate[required] new_textbox190" id="sid" size="45" minlength="4"value="<?php echo $res[student_id]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_IDNUMB");?> </td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="mobile" type="text" class="validate[required] new_textbox190" id="mobile" size="45" minlength="4" value="<?php echo $res[student_mobile]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_MOBNUMB");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="altmobile" type="text" class="validate[required] new_textbox190" id="altmobile" size="45" minlength="4"value="<?php echo $res[alt_contact]; ?>" onkeypress="return PhoneNo(event);"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L9");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
							  <input name="email" type="text" class="validate[required,custom[email]] new_textbox190" id="email" size="45" minlength="4" value="<?php echo $res[email]; ?>"/></td>
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><select name="status" id="status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                <?php
							    foreach($dbf->fetchOrder('common',"type='student status'","") as $ress) {
							    ?>
                                <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$res["studentstatus_id"]) { echo "Selected"; }?>><?php echo $ress['name'] ?></option>
                                <?php }?>
                              </select></td>
							 
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STATUSFSTD");?></td>
                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
							  <?php
							$i = 1;
							foreach($dbf->fetchOrder('course',"","") as $valc) {
							
							$n=$dbf->countRows('student_course',"student_id='$_REQUEST[id]' AND course_id='$valc[id]'");
						
							?>
							<input name="course<?php echo $i;?>" id="course<?php echo $i;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if($n>0) { ?> checked="checked" <?php } ?>><?php echo $valc["name"];?><br>
							<?php
							$i = $i + 1;
							}
							?>
							
							<input type="hidden" name="count" id="count" value="<?php echo $i-1;?>"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu"><label class="description" for="element_11"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_INTERESTIN");?></label></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
                              <textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"><?php echo $res["student_comment"];?></textarea></td>
                              <td>&nbsp;</td>
                               <td height="28" align="left" valign="top" class="leftmenu"> : <label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_COMMENTS");?> </label>
                                </td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><?php
							$i1 = 1;
							//echo $student_id;
							foreach($dbf->fetchOrder('common',"type='lead type'","") as $valc) {
							
							$n11=$dbf->countRows('student_lead',"student_id='$_REQUEST[id]' AND lead_id='$valc[id]'");
							
							?>
							<input name="lead<?php echo $i1;?>" id="lead<?php echo $i1;?>" type="checkbox" value="<?php echo $valc["id"];?>" <?php if($n11>0) { ?> checked="checked" <?php } ?>><?php echo $valc["name"];?><br>
							<?php
							$i1 = $i1 + 1;
							}
							?>
							<input type="hidden" name="leadcount" id="leadcount" value="<?php echo $i1-1;?>"></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu"><label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?>?</label></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="right" valign="middle"><input type="file" name="signature" id="signature" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STDPHOTO");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>
							  <?php if($res["photo"]!=''){
							  		$photo = "../sa/photo/".$res["photo"];
							  }else{
							  		$photo = "../images/noimage.jpg";
							  }
							  ?>
                              <td align="right" valign="middle"><img src="<?php echo $photo; ?>" width="100" height="100" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                              <td>&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
