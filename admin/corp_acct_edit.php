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
$res = $dbf->strRecordID("corporate","*","id='$_REQUEST[id]'");
#echo var_dump($res);
include_once '../includes/language.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

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
	document.getElementById('material_name').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>),gotfocus();">
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="logintext"><?php echo "Edit Account";?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"></td>
                    <td width="8%" align="left"><a href="corp_acct_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo "Edit Account";?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                         <?php
							$sql=$dbf->genericQuery("SELECT id,name FROM centre WHERE id='".$res[centre_id]."'");
						?>
                        <form action="corp_acct_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="20%" height="30">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="34%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="34%">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Centre Name";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
								<select name="centre_name">
									<?php foreach($sql as $val):?>
										<option value='<?php echo $val['id'];?>' selected='<?php echo ($res['centre_id']==$val['id']?'selected':'');?>' readonly><?php echo $val['name']?></option>
									<?php endforeach;?>
								</select>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Code";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_code" type="text" class="validate[required] new_textbox1" id="corporate_code" size="45" minlength="4" value="<?php echo $res['code'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Name";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_name" type="text" class="validate[required] new_textbox1" id="corporate_name" size="45" minlength="4" value="<?php echo $res['name'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Address";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_address" type="text" class="validate[required] new_textbox1" id="corporate_address" size="45" minlength="4" value="<?php echo $res['address'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Contact";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_contact" type="text" class="validate[required] new_textbox1" id="corporate_contact" size="45" minlength="4" value="<?php echo $res['contact'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Details";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_details" type="text" class="validate[required] new_textbox1" id="corporate_details" size="45" minlength="4" value="<?php echo $res['details'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="30" align="right" valign="middle" class="leftmenu"><?php echo "Nos. of Students";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_num_of_students" type="text" class="validate[required] new_textbox1" id="corporate_num_of_studnets" size="45" minlength="4" value="<?php echo $res['no_of_students'];?>" onKeyPress="return isNumberKey(event);"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Nos. of Class";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_num_of_class" type="text" class="validate[required] new_textbox1" id="corporate_num_of_class" size="45" minlength="4" value="<?php echo $res['no_of_class'];?>" onKeyPress="return isNumberKey(event);"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo "Remarks";?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
									<input name="corporate_remarks" type="text" class="validate[required] new_textbox1" id="corporate_remarks" size="45" minlength="4" value="<?php echo $res['remarks'];?>"/>
							  </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							<!--
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("MANAGE_TYPE_NAME");?> : <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="material_name" type="text" class="validate[required] new_textbox1" id="material_name" value="<?php echo $res[name];?>" size="45" minlength="4"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
							-->
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
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("MANAGE_EDIT_TYPE");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="type_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" >
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              
                              <td width="30%" height="30">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="35%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="23%">&nbsp;</td>
                              <td width="10%">&nbsp;</td>
                            </tr>
                            <tr>
                              
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="material_name" type="text" class="validate[required] new_textbox1" id="material_name" value="<?php echo $res[name];?>" size="45" minlength="4"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("MANAGE_TYPE_NAME");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="30" colspan="6" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                             
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
