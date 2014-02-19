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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<!--JQUERY VALIDATION ENDS-->
</script>	

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="../datepicker/demos.css">
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

function gotfocus(){
  document.getElementById('student').focus();
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
<!--UI JQUERY DATE PICKER-->

<style>
.mytext{border:solid 1px; background-color:#ECF1FF; border-color:#999999;}
.mycombo {background-color:#ECF1FF;width:192px; border:solid 1px; border-color:#999999;}
body input:focus, textarea:focus, select:focus{background-color:#FDE7C8;}
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
</head>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){ ?>
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
                <td align="left" valign="middle" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="centercolumntext"><span class="logintext"><?php echo constant("STUDENT_APPOINTMENT");?></span></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
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
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?></td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:5px;">
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="centercolumntext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_EDITSTUDENTAPPOINT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="student_appoint_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" >
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="23%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="51%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="23%">&nbsp;</td>
                          </tr>
                          <?php
						   $res = $dbf->strRecordID("student_appointment","*","id='$_REQUEST[id]'");
						  ?>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?>  :</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle"><input name="date" type="text" class="new_textbox190 datepickFuture" readonly="readonly" id="date" value="<?php echo $res[dated];?>"/></td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle" id="lblname">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?><span class="nametext1">*</span>: </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">
                            <select id="student"  name="student" class="validate[required] mycombo">
                              <option value="">--Select Student--</option>
                              <?php
					          foreach($dbf->fetchOrder('student',"","first_name") as $val) {
								  ?>
                              <option value="<?php echo $val["id"]; ?>" <?php if($val["id"]==$res["student_id"]) { echo "Selected"; }?>> <?php echo $dbf->printStudentName($val["id"]);?></option>
                              <?php
							  }
		                      ?>
                            </select></td>
                            <td>&nbsp;</td>
                            <td  align="left" valign="middle" id="lblerror">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENTS");?><span class="nametext1">*</span>:</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle"><label for="comment"></label>
                              <textarea name="comment" id="comment" cols="45" rows="5" class="mytext"><?php echo $res[comments]; ?></textarea> </td>
                            <td>&nbsp;</td>
                            <td  align="left" valign="middle" id="lblcom">&nbsp;</td>
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30"><a href="student_appoint_manage.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="right"><span class="logintext"><?php echo constant("STUDENT_APPOINTMENT");?>&nbsp;&nbsp;</span></td>
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
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:5px;">
                  <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="centercolumntext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_EDITSTUDENTAPPOINT");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="student_appoint_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" onsubmit="return validate();">
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr>                            
                                  <td width="23%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="51%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="23%">&nbsp;</td>                          
                                  <td width="1%">&nbsp;</td>
                                  </tr>
                                <?php
						   $res = $dbf->strRecordID("student_appointment","*","id='$_REQUEST[id]'");
						  ?>
                                <tr>                           
                                  <td align="left" valign="middle" id="lblname">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="right" valign="middle"><input name="date" type="text" class="new_textbox190_ar datepickFuture" readonly="readonly" id="date" size="45" minlength="4" value="<?php echo $res[dated];?>"/></td>
                                  <td>&nbsp;</td>
                                  <td height="28" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?></td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                <tr>                          
                                  <td  align="left" valign="middle" id="lblerror">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="right" valign="middle">
                                    <select id="student"  name="student" class="validate[required] mycombo">
                                      <option value="">--Select Student--</option>
                                      <?php
					          foreach($dbf->fetchOrder('student',"","") as $val) {
								  ?>
                                      <option value="<?php echo $val["id"]; ?>" <?php if($val["id"]==$res["student_id"]) { echo "Selected"; }?>> <?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
                                      <?php
							  }
		                      ?>
                                      </select></td>
                                  <td>&nbsp;</td>
                                  <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?></td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  </tr>
                                <tr>                           
                                  <td  align="left" valign="middle" id="lblcom">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="right" valign="middle"><label for="comment"></label>
                                    <textarea name="comment" id="comment" cols="45" rows="5" class="mytext" style="text-align:right;"><?php echo $res[comments]; ?></textarea></td>
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