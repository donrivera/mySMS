<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

$teacher_id = $_SESSION[uid];

//Object initialization
$dbf = new User();

$res_sick = $dbf->strRecordID("sick_leave","*","id='$_REQUEST[id]' and teacher_id='$teacher_id'");

include_once '../includes/language.php';
?>	

<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
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

<!--JQUERY VALIDATION-->


<script type="text/javascript" src="../js/filter_textbox.js"></script>
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
</script>	
<!--JQUERY VALIDATION ENDS-->

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="../datepicker/demos.css">

<script>
$(function() {
	$( "#from_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#to_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
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
<body onLoad="gotfocus,countdown_init(<?php echo $count;?>);">
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
                <td width="54%" height="30" align="left" class="headingtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_SICKLV");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="manage_sick_leave.php"> 
                  <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#e6e6e6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_MSG");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
				 <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="headingtext"><?php if($_REQUEST[id]==''){echo constant("ADD_SICK_LEAVE");} else{ echo constant("EDIT_SICK_LEAVE");}?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                                    
                            <form action="sick_process.php?action=save" name="frm" method="post" id="frm" enctype="multipart/form-data">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-color:#CCCCCC;">
                                  <tr>
                                    <td width="4%">&nbsp;</td>
                                    <td width="28%">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="64%">&nbsp;</td>
                                    <td width="3%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?> : <span class="nametext1">*</span> </td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle">
                                    <input name="from_date" type="text" class="validate[required] datepick new_textbox190" id="from_date" readonly=""  value="<?php echo $res_sick[from_date]; ?>"/>
                                    </td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?>  : <span class="nametext1">*</span> </td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle">
                                    <input name="to_date" type="text" class="validate[required] datepick new_textbox190" id="to_date" readonly="" value="<?php echo $res_sick[to_date]; ?>"/></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASONFRLEV");?> : <span class="nametext1">*</span> </td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><textarea name="sick_reason" id="sick_reason" style="height:50px; width:290px; border:solid 1px; background-color:#ECF1FF;border-color:#999999;"><?php echo $res_sick[sick_reason];?></textarea></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?> :</td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle">
                                      <h4>
                                        <input type="file" name="sick_attach" id="sick_attach" />
                                        <a href="sickleave/<?php echo $res_sick[sick_attachment];?>" target="_blank"><?php echo $res_sick[sick_attachment];?></a></h4></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_SICKNOT");?> : </td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle">
                                    <textarea name="sick_note" id="sick_note" style="height:50px; width:290px; border:solid 1px; background-color:#ECF1FF;border-color:#999999;"><?php echo $res_sick[sick_notes];?></textarea>
                                    </td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>                          
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/>
                                    <input type="hidden" name="hidsick" id="hidsick" value="<?php echo $res_sick[id];?>"/>
                                    </td>
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
            <td >&nbsp;</td>
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
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" align="right" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17%" align="left" valign="middle">&nbsp;<a href="manage_sick_leave.php"> 
                  <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="83%" align="right" valign="middle" class="footertext"><?php echo constant("TEACHER_ARF_MANAGE_EDITARF");?>&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF">
                  <br>
                  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="headingtext"><?php if($_REQUEST[id]==''){echo constant("ADD_SICK_LEAVE");} else{ echo constant("EDIT_SICK_LEAVE");}?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                                    
                            <form action="sick_process.php?action=save" name="frm" method="post" id="frm" enctype="multipart/form-data">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-color:#CCCCCC;">
                                  <tr>
                                    <td width="5%">&nbsp;</td>
                                    <td width="66%">&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="24%">&nbsp;</td>
                                    <td width="4%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  
                                    <td align="right" valign="middle">
                                    <input name="from_date" type="text" class="validate[required] datepick new_textbox100_ar" id="from_date" readonly=""  value="<?php echo $res_sick[from_date]; ?>"/>                    </td>
                                    <td>&nbsp;</td>
                                    <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>                   
                                    <td align="right" valign="middle">
                                    <input name="to_date" type="text" class="validate[required] datepick new_textbox100_ar" id="to_date" readonly="" value="<?php echo $res_sick[to_date]; ?>"/></td>
                                     <td>&nbsp;</td>
                                    <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></td>
                                    <td>&nbsp;</td>					
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                     <td align="right" valign="middle"><textarea name="sick_reason" id="sick_reason" style="height:50px; width:290px; border:solid 1px; background-color:#ECF1FF;border-color:#999999; text-align:right;"><?php echo $res_sick[sick_reason];?></textarea></td>
                                    <td>&nbsp;</td>					
                                     <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASONFRLEV");?></td>                  
                                    <td>&nbsp;</td>
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td align="right" valign="middle">
                                      <h4>
                                        <input type="file" name="sick_attach" id="sick_attach" />
                                        <a href="sickleave/<?php echo $res_sick[sick_attachment];?>" target="_blank"><?php echo $res_sick[sick_attachment];?></a></h4></td>
                                    <td>&nbsp;</td>
                                    <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></td>                   
                                    <td>&nbsp;</td>
                                  </tr>
                                   <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                   <td align="right" valign="middle">
                                    <textarea name="sick_note" id="sick_note" style="height:50px; width:290px; border:solid 1px; background-color:#ECF1FF;border-color:#999999; text-align:right;"><?php echo $res_sick[sick_notes];?></textarea>                    </td>
                                    <td>&nbsp;</td>
                                    <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_MANAGE_SICKLEAVE_SICKNOT");?></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu"  colspan="5">&nbsp;</td>
                                   </tr>                          
                                  <tr>
                                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/>
                                    <input type="hidden" name="hidsick" id="hidsick" value="<?php echo $res_sick[id];?>"/></td>
                                    <td>&nbsp;</td>
                                    <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>                   
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
<?php } ?>
</body>
</html>
