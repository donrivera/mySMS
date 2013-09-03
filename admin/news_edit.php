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

$res = $dbf->strRecordID("news","*","id='$_REQUEST[id]'");

include_once '../includes/language.php';

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

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">

<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="../datepicker/demos.css">
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
</script>
<!--UI JQUERY DATE PICKER-->

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}
else
{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN')
{
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR')
{
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
		
		
		
function validate()
{
	if(document.frm.imp_info.value == '')
	{
		document.getElementById('lblname').innerHTML = "<html><table width='190' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='12%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='82%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Enter Important Information</td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		
		document.frm.imp_info.focus();
		return false;
	}
	else
	{
		document.getElementById('lblname').innerHTML = "";
	}
	
	if(document.frm.date.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='190' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='12%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='82%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		
		document.frm.date.focus();
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
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
	document.getElementById('alert_id').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_MENU_NEWS");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="news_manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_NEWS_MANAGE_EDITNEWS");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="news_process.php?action=edit&amp;id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="6%">&nbsp;</td>
                          <td width="27%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="30%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_ALERTTYPE");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><select name="alert_id" id="alert_id" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px;">
                              <?php
					foreach($dbf->fetchOrder('common',"type='alert type'","") as $ress) {
					  ?>
                              <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$res["alert_id"]) { echo "Selected"; }?>><?php echo $ress['name'] ?></option>
                              <?php }?>
                            </select>
                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_IMPORTANT");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="imp" type="checkbox" id="imp" <?php if($res["imp"]=="1") { ?> checked="checked" <?php } ?>></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_IMPORTANTINFO");?> : <span class="nametext1">*</span> </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">
                          <textarea name="imp_info" id="imp_info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px; height:150px;"><?php echo $res['imp_info'] ?></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="lblname">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_INFORMATION");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><textarea name="info" id="info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px; height:150px;"><?php echo $res['infor'] ?></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" style="padding-top:3px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?> : <span class="nametext1">*</span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="date" type="text" class="datepick validate[required] new_textbox1" id="date"  size="45" minlength="4" value="<?php echo $res['dt'] ;?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" id="lblerror">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_NEWS_MANAGE_AUDIENCE");?> :</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input name="audience" type="checkbox" id="audience" <?php if($res["audience"]=="1") { ?> checked="checked" <?php } ?>></td>
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
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_NEWS_MANAGE_EDITNEWS");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="news_process.php?action=edit&amp;id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          
                          <td width="30%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="41%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="6%">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><select name="alert_id" id="alert_id" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px;">
                              <?php
							foreach($dbf->fetchOrder('common',"type='alert type'","") as $ress) {
					  		?>
                              <option value="<?php echo $ress['id']?>" <?php if($ress["id"]==$res["alert_id"]) { echo "Selected"; }?>><?php echo $ress['name'] ?></option>
                              <?php }?>
                            </select>                          </td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_NEWS_MANAGE_ALERTTYPE");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="imp" type="checkbox" id="imp" <?php if($res["imp"]=="1") { ?> checked="checked" <?php } ?>></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_NEWS_MANAGE_IMPORTANT");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                         
                          <td height="28" align="left" valign="middle"  id="lblname">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle">
                          <textarea name="imp_info" id="imp_info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px; height:150px;"><?php echo $res['imp_info'] ?></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_NEWS_MANAGE_IMPORTANTINFO");?></td>
                           <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><textarea name="info" id="info" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px; height:150px;"><?php echo $res['infor'] ?></textarea></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_NEWS_MANAGE_INFORMATION");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" id="lblerror">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="date" type="text" class="datepick validate[required] new_textbox1" id="date"  size="45" minlength="4" value="<?php echo $res['dt'] ;?>"/></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span>  : <?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          
                          <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input name="audience" type="checkbox" id="audience" <?php if($res["audience"]=="1") { ?> checked="checked" <?php } ?>></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("ADMIN_NEWS_MANAGE_AUDIENCE");?></td>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="6" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2" border="0" align="left" /></td>
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
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
</body>
</html>
