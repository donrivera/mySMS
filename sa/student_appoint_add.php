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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="dropdowntabs.js"></script>
<script src="../js/jquery-1.8.2.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../chosen/chosen.css" />
<script src="../chosen/chosen.jquery.js"></script>

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
</script>

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
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
</script>
<!--UI JQUERY DATE PICKER-->

<style>
.mytext{border:solid 1px; background-color:#ECF1FF; border-color:#999999;}
.mycombo {border:solid 1px #999999; background-color:#ECF1FF;}
</style>

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
</head>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
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
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_APPOINTMENT");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp; </td>
                    <td width="8%" align="left"><a href="student_appoint_manage.php"> 
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
			  <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECADD");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
				
				<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_ADDSTUDENTAPPOINT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="student_appoint_process.php?action=insert" name="frm" method="post" id="frm" onsubmit="return validate();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="1%">&nbsp;</td>
                              <td width="23%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="51%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="23%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"> <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="date" type="text"  class="new_textbox100 datepickFuture" readonly="" id="date" size="45" minlength="4" value="<?php echo date("Y-m-d"); ?>"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" id="lblname">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?> <span class="nametext1">*</span>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
                              <select name="student" id="student" class="chzn-select validate[required,minListOptions[]]">
                                    <option value="">-- Select Student --</option>
                                    <?php
                                    foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]'","first_name") as $ress2) {
                                    ?>
                                    <option value="<?php echo $ress2['id']?>"><?php echo $ress2['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($ress2["id"]));?></option>
                                    <?php }?>
                                </select>
                                
                                <!-- JavaScript -->
								<script type="text/javascript" src="../tooltip/prettify.js"></script>
                                <script src="../tooltip/apprise.js" type="text/javascript"></script>
                                <link href="../tooltip/apprise.css" rel="stylesheet" type="text/css">
                                <!-- JavaScript -->
                                
                                <script>
								function tryit(string, args) {
									apprise(string, args, function(r) {
										if(r) {
											if(typeof(r)=='string')
												{ $('#returns').text(r); }
											else
												{ $('#returns').text('True'); }
											}
										else 
											{ $('#returns').text('False'); }
									});
								}
								</script>
                                
                                <script type="text/javascript">
									var form_error_stat=false;
									$(".chzn-select").chosen(); 
									$(".chzn-select-deselect").chosen({allow_single_deselect:true});
									
									$('#frm').on('submit', function(e) {
										
										var value = $(".chzn-select").val();										
										if(value == ''){
											tryit('Select Student Name', {'animate':true});
											e.preventDefault();
											return false;
										}
																																
										if($('#comment').val() == ''){
											tryit('Select Comments', {'animate':true});
											e.preventDefault();
											return false;
										}
																			
									}); 
                            	</script>
                                
                              </td>
                              <td>&nbsp;</td>
                              <td  align="left" valign="middle" id="lblerror">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENTS");?> <span class="nametext1">*</span>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><label for="comment"></label>
                                <textarea name="comment" id="comment" cols="45" rows="5" class="mytext"></textarea></td>
                              <td>&nbsp;</td>
                              <td rowspan="2" align="left" valign="middle" id="lblcom">&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="10" colspan="6" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                        <tr>
                         <td width="8%" align="left"><a href="student_appoint_manage.php"> 
                            <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                          <td width="22%">&nbsp;</td>
                          <td width="8%" align="left">&nbsp;</td>
                          <td width="8%" align="left">&nbsp; </td>
                           <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_APPOINTMENT");?></td>
                          
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
                    <?php if($_REQUEST[msg]=="added") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECADD");?> </td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_ADDSTUDENTAPPOINT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="student_appoint_process.php?action=insert" name="frm" method="post" id="frm" onsubmit="return validate();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="23%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="51%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
							  <td width="23%">&nbsp;</td>
							  <td width="1%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" id="lblname">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input name="date" type="text"  class="new_textbox100_ar datepickFuture" readonly="" id="date" size="45" minlength="4" value="<?php echo date("Y-m-d"); ?>"/></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?></td>
							  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr> 
							  <td align="left" valign="middle" id="lblerror">&nbsp;</td>                             
                              <td>&nbsp;</td>
                              <td align="right" valign="middle">
                                <select id="student"  name="student" class="validate[required] mycombo">
                                   <option value="">--<?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_OPTION");?>--</option>
                                    <?php
					          		foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]'","") as $val) {
								  ?>
								  <option value="<?php echo $val[id]; ?>"> <?php echo $val[first_name]; ?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
								  <?php
							  		}
		                           ?>
                                </select></td>
                              <td>&nbsp;</td>
							  <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?></td>
                             <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td rowspan="2" align="left" valign="middle" id="lblcom">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><label for="comment"></label>
                                <textarea name="comment" id="comment" style="text-align:right;" cols="45" rows="5" class="validate[required] mytext"></textarea></td>
                              <td>&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENTS");?></td>
							  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="6" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>                              
                              <td>&nbsp;</td>
                              <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
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
<?php  } ?>
</body>
</html>
