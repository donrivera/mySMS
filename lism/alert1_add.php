<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include_once 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">
<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});

$(function() {
	$( ".datepickFuture" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});


$(function() {
	$( ".datepickPast" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		maxDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});	

function validate(){
	if(document.frm.imp_info.value == ''){	
		document.frm.imp_info.focus();
		return false;
	}else{
		document.getElementById('lblname').innerHTML = "";
	}
	
	if(document.frm.date.value == ''){	
		document.frm.date.focus();
		return false;
	}else{
		document.getElementById('lblerror').innerHTML = "";
	}
}
</script>
<!--UI JQUERY DATE PICKER-->
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

function gotfocus(){
  document.getElementById('alert_id').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>),gotfocus();">
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4"  style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_MENU_ALERTS");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">                  
                <a href="alert1_manage.php"><input name="button" type="button" class="btn1" value="<?php echo constant("btn_cancel_btn2");?>" align="left" border="0" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <?php if($_REQUEST[msg]=="added") { ?>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                <tr>
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                  <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_ALERT1_MANAGE_NEWALERTS");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="alert1_process.php?action=insert" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="4%">&nbsp;</td>
                          <td width="24%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_ALERTTYPE");?>:</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><select name="alert_id" id="alert_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:187px;">
                            <?php
							foreach($dbf->fetchOrder('common',"type='alert type'","") as $res) {
							  ?>
                            <option value="<?php echo $res['id']?>"><?php echo $res['name'] ?></option>
                            <?php }?>
                            </select></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_IMPORTANT");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="imp" type="checkbox" id="imp" title="Mark as Important"></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_IMPORTANTINFO");?> : <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><textarea name="imp_info" id="imp_info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:187px; height:150px;"></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="lblname">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_INFORMATION");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" style="padding-top:3px;"><textarea name="info" id="info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:187px; height:150px;"></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_DATE");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="date" readonly="" type="text" class="datepick validate[required] new_textbox190" id="date" value="" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="lblerror">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_ALERT1_MANAGE_AUDIENCE");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="audience" type="checkbox" id="audience"></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="submit" type="submit" class="btn1" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" /></td>
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
            <?php } else{?>
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_ALERT1_MANAGE_NEWALERTS");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="alert1_process.php?action=insert" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          
                          <td width="35%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          
                          <td width="24%">&nbsp;</td>
                          <td width="4%">&nbsp;</td>
                        </tr>
                        <tr>                          
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><select name="alert_id" id="alert_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:187px;">
                            <?php
							foreach($dbf->fetchOrder('common',"type='alert type'","") as $res) {
							  ?>
                            <option value="<?php echo $res['id']?>"><?php echo $res['name'] ?></option>
                            <?php }?>
                            </select></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="bottom" class="leftmenu"> : <?php echo constant("ADMIN_ALERT1_MANAGE_ALERTTYPE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="imp" type="checkbox" id="imp" title="Mark as Important"></td>
                          <td>&nbsp;</td>
                          
                          <td height="28" align="left" valign="bottom" class="leftmenu"> : <?php echo constant("ADMIN_ALERT1_MANAGE_IMPORTANT");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                         <td align="left" valign="middle" id="lblname">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><textarea name="imp_info" id="imp_info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:187px; height:150px;"></textarea></td>
                          <td>&nbsp;</td>
                          
                           <td height="28" align="left" valign="bottom" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_ALERT1_MANAGE_IMPORTANTINFO");?> </td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>                          
                          <td>&nbsp;</td>
                          <td align="right" valign="middle" style="padding-top:3px;"><textarea name="info" id="info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:187px; height:150px;"></textarea></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="bottom" class="leftmenu"> :<?php echo constant("ADMIN_ALERT1_MANAGE_INFORMATION");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>                          
                          <td align="left" valign="middle" id="lblerror">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="date" readonly="" type="text" class="datepick validate[required] new_textbox190" id="date" value="" size="45" minlength="4"/></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_ALERT1_MANAGE_DATE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>                          
                          <td align="left" valign="middle">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="audience" type="checkbox" id="audience"></td>
                          <td>&nbsp;</td>                          
                          <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_ALERT1_MANAGE_AUDIENCE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>                          
                          <td align="left" valign="middle">&nbsp;</td> 
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="submit" type="submit" class="btn2" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" /></td>
                          <td>&nbsp;</td>
                         
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
</body>
</html>
