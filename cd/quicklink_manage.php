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

<script language="javascript" type="text/javascript">
function check1(type){
	
	var total = document.getElementById('total').value;
	for(i = 0; i <= total; i++){
		var id = "id"+i;
		document.getElementById(id).checked = type;
	}
}

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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_ADDTO_QUICKLINK");?> </td>
                <td width="22%" id="lblname">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF">
            
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_ADDTO_QUICKLINK");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        	<form action="quicklink_process.php" name="frm" method="post" id="frm">
                                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                  <tr>
                                    <td width="1%">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" colspan="2" align="left" valign="middle" class="leftmenu"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30" align="center" valign="middle" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="5%" align="center"><img src="../images/errror.png" width="32" height="32"></td>
                                            <td width="95%" align="left" valign="middle" class="shop1"><?php echo constant("ADMIN_QUICKLINK_MANAGE_TEXTP");?></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" colspan="2" align="left" valign="middle" class="leftmenu">
                                    
                                      <table width="99%" border="0" cellspacing="0" bordercolor="#cccccc" cellpadding="0" style="border-collapse:collapse;">
                                      
                                        <tr>
                                          <td width="5%" height="25" align="center" valign="middle" bgcolor="#DDDDDD">
                                          <input type="checkbox" name="checkbox" id="checkbox" onChange="check1(this.checked)"></td>
                                          <td width="42%" align="left" valign="middle" bgcolor="#DDDDDD" class="mymenutext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_PAGENAME");?></td>
                                          <td width="5%" align="center" valign="middle" bgcolor="#DDDDDD">&nbsp;</td>
                                          <td width="48%" align="left" valign="middle" bgcolor="#DDDDDD" class="mymenutext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_PAGENAME");?></td>
                                          </tr>
                                        </table>
                                        <?php
										$k = 0;
										foreach($dbf->fetchOrder('quick_menu',"module_name='Center Director'","id") as $qpage) {
									$num=$dbf->countRows('quick_links',"link_name='$qpage[link_name]' And module_name='Center Director' And user_id='$_SESSION[id]'");
										?>
                                      <table width="50%" border="0" cellspacing="0" bordercolor="#cccccc" cellpadding="0" style="border-collapse:collapse; float:left;">
                                      		<tr>
                                          		<td width="10%" height="25" align="center" valign="middle" <?php if ($num=="1") {?> bgcolor="#003399" <?php }?>>
                                          		<input type="checkbox" name="id<?php echo $k;?>" id="id<?php echo $k;?>" <?php if ($num=="1") {?> checked="checked" <?php } ?> value="<?php echo $qpage["link_name"];?>*<?php echo $qpage["links"];?>"></td>
                                          		<td width="90%" align="left" valign="middle" class="mymenutext"><?php echo $qpage["link_name"];?></td>
                                          	</tr>
                                        </table>
                                        <?php $k++; } ?>
                                        <input type="hidden" name="total" id="total" value="<?php echo $k - 1;?>">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td height="20" colspan="3" align="left" valign="middle"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td width="13%" height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td width="86%" align="right" valign="middle">
                                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="3" align="left" valign="middle"></td>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="22%" id="lblname">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"></td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="54%" height="30" align="right" class="logintext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_ADDTO_QUICKLINK");?> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF">
            
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_ADDTO_QUICKLINK");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        	<form action="quicklink_process.php" name="frm" method="post" id="frm">
                                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                  <tr>
                                    <td width="1%">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" colspan="2" align="left" valign="middle" class="leftmenu"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30" align="center" valign="middle" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="95%" align="right" valign="middle" class="shop1"><?php echo constant("ADMIN_QUICKLINK_MANAGE_TEXTP");?></td>
                                            <td width="5%" align="center"><img src="../images/errror.png" width="32" height="32"></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" colspan="2" align="left" valign="middle" class="leftmenu">
                                    
                                      <table width="99%" border="0" cellspacing="0" bordercolor="#cccccc" cellpadding="0" style="border-collapse:collapse;">
                                      
                                        <tr>
                                          <td width="48%" align="right" valign="middle" bgcolor="#DDDDDD" class="mymenutext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_PAGENAME");?></td>
                                          <td width="2%" align="center" valign="middle" bgcolor="#DDDDDD">&nbsp;</td>
                                          <td width="45%" align="right" valign="middle" bgcolor="#DDDDDD" class="mymenutext"><?php echo constant("ADMIN_QUICKLINK_MANAGE_PAGENAME");?></td>
                                          <td width="5%" height="25" align="center" valign="middle" bgcolor="#DDDDDD">
                                          <input type="checkbox" name="checkbox" id="checkbox" onChange="check1(this.checked)"></td>
                                          </tr>
                                        </table>
                                        <?php
										$k = 0;
										foreach($dbf->fetchOrder('quick_menu',"module_name='Center Director'","id") as $qpage) {
									$num=$dbf->countRows('quick_links',"link_name='$qpage[link_name]' And module_name='Center Director' And user_id='$_SESSION[id]'");
										?>
                                      <table width="50%" border="0" cellspacing="0" bordercolor="#cccccc" cellpadding="0" style="border-collapse:collapse; float:right;">
                                      		<tr>
                                          		<td width="90%" align="right" valign="middle" class="mymenutext"><?php echo $qpage["link_name"];?></td>
                                                <td width="10%" height="25" align="center" valign="middle" <?php if ($num=="1") {?> bgcolor="#003399" <?php }?>>
                                          		<input type="checkbox" name="id<?php echo $k;?>" id="id<?php echo $k;?>" <?php if ($num=="1") {?> checked="checked" <?php } ?> value="<?php echo $qpage["link_name"];?>*<?php echo $qpage["links"];?>"></td>
                                          	</tr>
                                        </table>
                                        <?php $k++; } ?>
                                        <input type="hidden" name="total" id="total" value="<?php echo $k - 1;?>">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td height="20" colspan="3" align="left" valign="middle"></td>
                                  </tr>
                                  <tr>
                                  <td align="right" valign="middle">
                                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td width="13%" height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="3" align="left" valign="middle"></td>
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
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
