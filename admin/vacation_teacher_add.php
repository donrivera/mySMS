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
include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#startdate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#enddate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<!--UI JQUERY DATE PICKER-->


<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm.startdate.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select Start Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}
	
	if(document.frm.enddate.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select End Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}	
			
	if(document.frm.center.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select Teacher Name. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}
}

function getteacher()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('showsch').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showsch').innerHTML=c;
		}
	}

	var teacher = document.getElementById('center').value;
	var startdate = document.getElementById('startdate').value;
	var enddate = document.getElementById('enddate').value;
	
	ajaxRequest.open("GET", "vacation_teacher_ajax.php" + "?teacher=" + teacher +"&startdate=" + startdate +"&enddate=" + enddate, true);
	ajaxRequest.send(null);
}
</script>

</head>
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
	document.getElementById('startdate').focus();
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
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
        <td width="2%">
        <p>&nbsp;</p>
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
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="logintext"><?php echo constant("VOCATION_TEACHER");?> </td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"><a href="vacation_teacher_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext1"><?php echo constant("COMMON_RECORDALREADYAXIT");?> </td>
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
                <?php if($_SESSION['lang']=='EN'){?>
                <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_VACATION_TEACHER_ADD_NEWVAC");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="vacation_teacher_process.php?action=insert" name="frm" method="post" id="frm"  onsubmit="return validate();">
                          		<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="17%">&nbsp;</td>
                              <td width="29%">&nbsp;</td>
                              <td width="0%">&nbsp;</td>
                              <td width="54%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="leftmenu">&nbsp; <?php echo constant("CD_EP_CLASS_CANCEL_EDIT_STARTDATE");?> <span class="nametext1">*</span>: </td>
                              <td align="left" valign="middle">
                              <input name="startdate" type="text" class="datepick new_textbox1" id="startdate" size="45" readonly="" minlength="4"/></td>
                              <td>&nbsp;</td>
                              <td rowspan="2" align="left" valign="middle" id="lblerror" style="padding-left:19px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="leftmenu">&nbsp; <?php echo constant("CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE");?> <span class="nametext1">*</span>:</td>
                              <td align="left" valign="middle">
                              <input name="enddate" type="text" class="datepick new_textbox1" id="enddate" size="45" readonly="" minlength="4"/></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="30" align="right" valign="top" class="leftmenu">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?>   <span class="nametext1">*</span> :</td>
                              <td align="left" valign="top">
                              <select name="center" id="center" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onchange="getteacher();">
                              <option value="">Select Teacher</option>
                                <?php
								foreach($dbf->fetchOrder('teacher',"","") as $res) {
								  ?>
                                <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                                <?php }?>
                              </select></td>
                              <td>&nbsp;</td>
                              <td rowspan="2" align="left" valign="top" id="showsch">
                              <p id="showsch">&nbsp;</p>
                              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                <tr>
                                  <td height="30" align="center" valign="middle">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
                                    <tr>
                                      <td width="13%" height="25" align="center" valign="middle" bgcolor="#FFDDD7">&nbsp;</td>
                                      <td width="87%" align="center" valign="middle" bgcolor="#FFDDD7" class="red_smalltext"><?php echo constant("ADMIN_VACATION_TEACHER_ADD_TEXT");?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_VACATION_CENTRE_AJAX_SHOWSCHEDULE");?></td>
                                  </tr>
                                <tr>
                                  <td height="20" align="left" valign="middle">
                                  
                                  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSA");?></td>
                                    </tr>
                                    <tr>
                                      <td align="right" valign="middle" style="padding-right:5px;">
                                      <table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                       
                                        <tr>
                                          <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
                                          <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
                                        </tr>
                                        <tr>
                                          <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
                                          <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
                                        </tr>
                                        </table></td>
                                    </tr>
                                  </table>
                                  
                                  </td>
                                  </tr>
                                <tr>
                                  <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSB");?></td>
                                </tr>
                                <tr>
                                  <td height="0" align="right" valign="middle" style="padding-right:5px;"><table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                    <tr>
                                      <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
                                      <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
                                    </tr>
                                    <tr>
                                      <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
                                      <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td height="0" align="left" valign="middle">&nbsp;</td>
                                </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="top" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_VACATIONTYPE");?> : </td>
                              <td align="left" valign="top">
                                <select name="type" id="type" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                  <option value="Annual leave">Annual leave</option>
                                  <option value="Short leave">Short leave</option>
                                  <option value="Sick leave">Sick leave</option>
                                </select></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="10" colspan="4" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="6%" align="center" valign="middle"><script language="JavaScript" type="text/javascript">
								function showsms(val){
									if(val == "3"){
										document.getElementById('smsid').style.display = "block";
									}else{
										document.getElementById('smsid').style.display = "none";
									}
								}
								</script>
                                    <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
                                  <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("ADMIN_VACATION_TEACHER_STANDARDVAC_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
                                  <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onchange="showsms(this.value)" /></td>
                                  <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle">&nbsp;</td>
                                  <?php
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='24'");
								?>
                                  <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                    <tr>
                                      <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="4" align="left" valign="middle"></td>
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
				<table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_VACATION_TEACHER_ADD_NEWVAC");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="vacation_teacher_process.php?action=insert" name="frm" method="post" id="frm"  onsubmit="return validate();">
                          		<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
							  <td width="47%">&nbsp;</td>
                              <td width="26%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="26%">&nbsp;</td>                              
                            </tr>
                            <tr>
							  <td rowspan="2" align="left" valign="middle" id="lblerror" style="padding-left:19px;">&nbsp;</td>
                              
                              <td align="right" valign="middle">
                              <input name="startdate" type="text" class="datepick new_textbox1" id="startdate" size="45" readonly="" minlength="4"/></td>
                              <td>&nbsp;</td>
							  <td height="28" align="left" valign="middle" class="leftmenu">&nbsp; <span class="nametext1">*</span> : <?php echo constant("CD_EP_CLASS_CANCEL_EDIT_STARTDATE");?> </td>                              
                            </tr>
                            <tr>
                              
                              <td align="right" valign="middle">
                              <input name="enddate" type="text" class="datepick new_textbox1" id="enddate" size="45" readonly="" minlength="4"/></td>
                              <td>&nbsp;</td>
							  <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;<span class="nametext1">*</span>: <?php echo constant("CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE");?> </td>
                            </tr>
                            <tr>
							<td rowspan="2" align="left" valign="top" id="showsch">
                              <p id="showsch">&nbsp;</p>
                              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                <tr>
                                  <td height="30" align="center" valign="middle">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
                                    <tr>
                                      <td width="13%" height="25" align="center" valign="middle" bgcolor="#FFDDD7">&nbsp;</td>
                                      <td width="87%" align="center" valign="middle" bgcolor="#FFDDD7" class="red_smalltext"><?php echo constant("ADMIN_VACATION_TEACHER_ADD_TEXT");?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_VACATION_CENTRE_AJAX_SHOWSCHEDULE");?></td>
                                  </tr>
                                <tr>
                                  <td height="20" align="left" valign="middle">
                                  
                                  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSA");?></td>
                                    </tr>
                                    <tr>
                                      <td align="right" valign="middle" style="padding-right:5px;">
                                      <table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                       
                                        <tr>
                                          <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
                                          <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
                                        </tr>
                                        <tr>
                                          <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
                                          <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
                                        </tr>
                                        </table></td>
                                    </tr>
                                  </table>
                                  
                                  </td>
                                  </tr>
                                <tr>
                                  <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSB");?></td>
                                </tr>
                                <tr>
                                  <td height="0" align="right" valign="middle" style="padding-right:5px;"><table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                    <tr>
                                      <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
                                      <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
                                    </tr>
                                    <tr>
                                      <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
                                      <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td height="0" align="left" valign="middle">&nbsp;</td>
                                </tr>
                                </table></td>
                              
                              <td align="right" valign="top">
                              <select name="center" id="center" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onchange="getteacher();">
                              <option value="">Select Teacher</option>
                                <?php
								foreach($dbf->fetchOrder('teacher',"","") as $res) {
								  ?>
                                <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                                <?php }?>
                              </select></td>
                              <td>&nbsp;</td>
                              <td height="30" align="left" valign="top" class="leftmenu">&nbsp; <span class="nametext1">*</span> :<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?> </td>
                            </tr>
                            <tr>
                              
                              <td align="right" valign="top">
                                <select name="type" id="type" style="width:190px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                  <option value="Annual leave">Annual leave</option>
                                  <option value="Short leave">Short leave</option>
                                  <option value="Sick leave">Sick leave</option>
                                </select></td>
                              <td>&nbsp;</td>
							  <td height="28" align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_VACATIONTYPE");?></td>
                              </tr>
                            <tr>
                              <td height="10" colspan="4" align="left" valign="middle"></td>
                            </tr>
                            <tr>
							<td align="left" valign="middle"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="6%" align="center" valign="middle"><script language="JavaScript" type="text/javascript">
								function showsms(val){
									if(val == "3"){
										document.getElementById('smsid').style.display = "block";
									}else{
										document.getElementById('smsid').style.display = "none";
									}
								}
								</script>
                                    <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
                                  <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("ADMIN_VACATION_TEACHER_STANDARDVAC_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
                                  <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onchange="showsms(this.value)" /></td>
                                  <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle">&nbsp;</td>
                                  <?php
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='24'");
								?>
                                  <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                    <tr>
                                      <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="4" align="left" valign="middle"></td>
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
