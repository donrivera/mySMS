<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
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

<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="../js/filter_textbox.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="../js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]==''){
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="../js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="../js/jquery.validationEngine.js" type="text/javascript"></script>

<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()
});
<!--JQUERY VALIDATION ENDS-->

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
<?php if($_SESSION[lang] == "EN"){?>
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
                <td width="54%" height="30" align="left" class="headingtext"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="arf_manage.php"> 
                  <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
				<br>
				<table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="24" align="left" valign="top" >&nbsp;</td>
                      <td width="793" align="left" valign="top">
					  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
      </tr>
    </table></td>
  </tr>
  <?php
  $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
  ?>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
      <tr>
        <td align="center" valign="top" bgcolor="#EBEBEB">					
            <form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">					
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                  <tr>
                    <td width="67">&nbsp;</td>
                    <td width="124" height="30" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?> :</td>
                    <td width="220" class="leftmenu"><input name="owner2" type="text" class="validate[required] new_textbox190" id="owner2" value="<?php echo $res_std[first_name]; ?>" readonly="readonly"/></td>
                    <td width="11">&nbsp;</td>
                    <td width="115">&nbsp;</td>
                    <td width="211" align="left" valign="middle">
                    <a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank"><img src="../images/print.png" width="16" height="16" title="Print"/></a>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :</td>
                    <td align="left" valign="middle"  class="leftmenu"><input name="nr" type="text" class="validate[required] new_textbox190" id="nr" value="<?php echo $res_arf[dated];?>" readonly="readonly"/>
                      
                    </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_NR");?> :</td>
                    <td align="left" valign="middle"><input name="nr" type="text" class="validate[required] new_textbox190" id="nr" value="<?php echo $res_arf[nr];?>" readonly="readonly"/></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?> :</td>
                    <td align="left" valign="middle"  class="leftmenu"><input name="owner" type="text" class="validate[required] new_textbox190" id="owner" value="<?php echo $res_arf[action_owner];?>" readonly="readonly"/></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?> :</td>
                    <td align="left" valign="middle" class="leftmenu"><input name="report_by" type="text" class="validate[required] new_textbox190" id="report_by" value="<?php echo $res_arf[report_by];?>" readonly="readonly"/></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?>:</td>
                    <td align="left" valign="middle">
                      <input name="report_to"  type="text" class="new_textbox190" id="report_to" value="<?php echo $res_arf[report_to];?>" size="45" readonly="readonly" minlength="4"/>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?> : </td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="customer" type="text" class="new_textbox100" id="customer" value="<?php echo $res_arf[customer];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td width="115" align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
                    <td height="25" align="left" valign="middle"><span class="leftmenu">
                      <input name="reception2" type="text" class="new_textbox100" id="reception2" value="<?php echo $res_arf[reception2];?>" readonly="readonly">
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="teacher" type="text" class="new_textbox100" id="teacher" value="<?php echo $res_arf[teacher];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LCD");?> : </td>
                    <td height="25" align="left" valign="middle"><span class="leftmenu">
                      <input name="lcd" type="text" class="new_textbox100" id="lcd" value="<?php echo $res_arf[lcd];?>" readonly="readonly">
                    </span> </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="reception1" type="text" class="new_textbox100" id="reception1" value="<?php echo $res_arf[reception1];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LIS");?> : </td>
                    <td height="25" align="left" valign="middle"><span class="leftmenu">
                      <input name="lis" type="text" class="new_textbox100" id="lis" value="<?php echo $res_arf[lis];?>" readonly="readonly">
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="cs1" type="text" class="new_textbox100" id="cs1" value="<?php echo $res_arf[cs1];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
                    <td height="25" align="left" valign="middle"><span class="leftmenu">
                      <input name="cs2" type="text" class="new_textbox100" id="cs2" value="<?php echo $res_arf[cs2];?>" readonly="readonly">
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="other1" type="text" class="new_textbox100" id="other1" value="<?php echo $res_arf[other1];?>" size="35" readonly="readonly" minlength="4"/></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
                    <td height="25" align="left" valign="middle"><span class="leftmenu">
                      <input name="other2" type="text" class="new_textbox100" id="other2" value="<?php echo $res_arf[other2];?>" size="35" readonly="readonly" minlength="4"/>
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?> : </td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="instruction" type="text" class="new_textbox100" id="instruction" value="<?php echo $res_arf[instruction];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="material" type="text" class="new_textbox100" id="material" value="<?php echo $res_arf[material];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="programme" type="text" class="new_textbox100" id="programme" value="<?php echo $res_arf[programme];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="premisses" type="text" class="new_textbox100" id="premisses" value="<?php echo $res_arf[premisses];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="administration" type="text" class="new_textbox100" id="administration" value="<?php echo $res_arf[administration];?>" readonly="readonly"></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input name="other3" type="text" class="new_textbox100" id="other3" value="<?php echo $res_arf[other3];?>"size="35" readonly="readonly" minlength="4"/></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
                    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu">&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?> </td>
                    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><a href="#"></a></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                </table>
              </form></td>
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
</table></td>
                      <td width="33" align="right" valign="top" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="left" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
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
<?php }else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="56%" height="30" align="left"><a href="arf_manage.php"> 
                  <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="24%">&nbsp;</td>
                <td width="4%" align="left">&nbsp;</td>
                <td width="16%" align="right" class="headingtext"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                  <br>
                  <table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="24" align="left" valign="top" >&nbsp;</td>
                      <td width="793" align="left" valign="top">
                        <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" valign="middle" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <?php
  $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
  ?>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">					
                                  <form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">					
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="9%" height="30" align="center" valign="middle"><a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank"><img src="../images/print.png" width="16" height="16" title="Print"/></a></td>
                                        <td width="28%" align="right" valign="middle">&nbsp;</td>
                                        <td width="20%" align="left" valign="middle">&nbsp;</td>
                                        <td width="27%" align="right" valign="middle"><span class="leftmenu">
                                          <input name="owner3" type="text" class="validate[required] new_textbox190" id="owner3" value="<?php echo $res_std[first_name]; ?>" readonly="readonly"/>
                                        </span></td>
                                        <td width="16%" align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><input name="nr3" type="text" class="validate[required] new_textbox190" id="nr3" value="<?php echo $res_arf[nr];?>" readonly="readonly"/></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_NR");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="nr2" type="text" class="validate[required] new_textbox190" id="nr2" value="<?php echo $res_arf[dated];?>" readonly="readonly"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="owner4" type="text" class="validate[required] new_textbox190" id="owner4" value="<?php echo $res_arf[action_owner];?>" readonly="readonly"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><input name="report_to2"  type="text" class="new_textbox190" id="report_to2" value="<?php echo $res_arf[report_to];?>" size="45" readonly="readonly" minlength="4"/></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="report_by2" type="text" class="validate[required] new_textbox190" id="report_by2" value="<?php echo $res_arf[report_by];?>" readonly="readonly"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="reception4" type="text" class="new_textbox100_ar" id="reception4" value="<?php echo $res_arf[reception2];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="customer2" type="text" class="new_textbox100_ar" id="customer2" value="<?php echo $res_arf[customer];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="lcd2" type="text" class="new_textbox100_ar" id="lcd2" value="<?php echo $res_arf[lcd];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_LCD");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="teacher2" type="text" class="new_textbox100_ar" id="teacher2" value="<?php echo $res_arf[teacher];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="lis2" type="text" class="new_textbox100_ar" id="lis2" value="<?php echo $res_arf[lis];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_LIS");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="reception3" type="text" class="new_textbox100_ar" id="reception3" value="<?php echo $res_arf[reception1];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="cs4" type="text" class="new_textbox100_ar" id="cs4" value="<?php echo $res_arf[cs2];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="cs3" type="text" class="new_textbox100_ar" id="cs3" value="<?php echo $res_arf[cs1];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="other5" type="text" class="new_textbox100_ar" id="other5" value="<?php echo $res_arf[other2];?>" size="35" readonly="readonly" minlength="4"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="other4" type="text" class="new_textbox100_ar" id="other4" value="<?php echo $res_arf[other1];?>" size="35" readonly="readonly" minlength="4"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="instruction2" type="text" class="new_textbox100_ar" id="instruction2" value="<?php echo $res_arf[instruction];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="material2" type="text" class="new_textbox100_ar" id="material2" value="<?php echo $res_arf[material];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="programme2" type="text" class="new_textbox100_ar" id="programme2" value="<?php echo $res_arf[programme];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="premisses2" type="text" class="new_textbox100_ar" id="premisses2" value="<?php echo $res_arf[premisses];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="administration2" type="text" class="new_textbox100_ar" id="administration2" value="<?php echo $res_arf[administration];?>" readonly="readonly">
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu">
                                          <input name="other6" type="text" class="new_textbox100_ar" id="other6" value="<?php echo $res_arf[other3];?>"size="35" readonly="readonly" minlength="4"/>
                                        </span></td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="40%">&nbsp;</td>
                                            <td width="60%" height="25" align="left" valign="middle" bgcolor="#FFCCCC"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?>&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?></td>
                                      </tr>
                                    </table>
                                  </form></td>
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
  </table></td>
                      <td width="33" align="right" valign="top" >&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="3" align="left" valign="top">&nbsp;</td>
                      </tr>
                    </table></td>
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
    </table>
        
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
