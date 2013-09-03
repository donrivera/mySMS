<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])==''){
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor"){
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

if($_SESSION[lang]=='EN'){
	$char = 160;
}else{
	$char = 70;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

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
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<script language="javascript" type="text/javascript">
function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}

function validate(){
	var x = document.getElementById('number').value;
	if(x == "009665"){
		document.getElementById('number').focus();
		return false;
	}
}	

function show_region(msg,response_field){
	
	var response_control=response_field;
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
			document.getElementById(response_control).innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById(response_control).innerHTML=c;			
		}		
	}
	
	var country = document.getElementById('student').value;
		
	ajaxRequest.open("GET", "ajax_region.php" + "?student=" + country , true);
	ajaxRequest.send(null); 

}	
function show_temp(){
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
			document.getElementById('lbltemp').innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbltemp').innerHTML=c;
		}
		
	}
	var temp = document.getElementById('temp').value;

	ajaxRequest.open("GET", "sms_show_templete.php" + "?temp=" + temp , true);
	ajaxRequest.send(null);
}
function show_studentlist(){
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
			document.getElementById('lbl_student_list').innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbl_student_list').innerHTML=c;
		}		
	}
	var opval = document.getElementById('opval').value;
	document.getElementById('number').value = '009665';
	ajaxRequest.open("GET", "sms_student.php" + "?opval=" + opval , true);
	ajaxRequest.send(null);
}

function show_student_mobile(){
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
			document.getElementById('td_state').innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('td_state').innerHTML=c;
		}
		
	}
	var opval = document.getElementById('student_2').value;
	
	ajaxRequest.open("GET", "ajax_region.php" + "?student=" + opval , true);
	ajaxRequest.send(null);
}

function show_teacher_mobile(){
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
			document.getElementById('td_state').innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('td_state').innerHTML=c;
		}
		
	}
	var opval = document.getElementById('student_2').value;
	
	ajaxRequest.open("GET", "sms_teacher_mobile.php" + "?teacher_id=" + opval , true);
	ajaxRequest.send(null);
}

function show_staff_mobile(){
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
			document.getElementById('td_state').innerHTML="Loading----";
			
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('td_state').innerHTML=c;
		}
		
	}
	var opval = document.getElementById('student_2').value;
	
	ajaxRequest.open("GET", "sms_staff_mobile.php" + "?staff_id=" + opval , true);
	ajaxRequest.send(null);
}
</script>

<SCRIPT LANGUAGE="JavaScript">
// function parameters are: field - the string field, count - the field for remaining characters number and max - the maximum number of characters
function CountLeft(){
	//alert(document.getElementById('textarea').value.length)
	// if the length of the string in the input field is greater than the max value, trim it
	if (document.getElementById('textarea').value.length > <?php echo $char;?>)
		document.getElementById('textarea').value = document.getElementById('textarea').value.substring(0, <?php echo $char;?>);
	else
		// calculate the remaining characters
		document.getElementById('count').value = <?php echo $char;?> - document.getElementById('textarea').value.length;
}

function CountLeft_AR(){
	//alert(document.getElementById('textarea').value.length)
	// if the length of the string in the input field is greater than the max value, trim it
	if (document.getElementById('textarea').value.length > <?php echo $char;?>)
		document.getElementById('textarea').value = document.getElementById('textarea').value.substring(0, <?php echo $char;?>);
	else
		// calculate the remaining characters
		document.getElementById('count2').value = <?php echo $char;?> - document.getElementById('textarea').value.length;
}
</script>
<script type="text/javascript">
function gotfocus(){
  document.getElementById('opval').focus();
}
function checkTab(id){
	if(id=="textarea"){
	document.getElementById('submit').focus();
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
</head>

<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN"){?>
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
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("CD_SMS_SENDING_TEXTSMS");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
            
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                <?php
                $res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
                if($res_sms[status] == ''){?>
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("CD_SMS_TEXT1");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="sms_process.php" name="frm1" method="post" id="frm1"  onSubmit="return validate();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
							  <td width="5%" align="left" valign="middle" class="leftmenu" >&nbsp;</td>
                              <td height="30" colspan="4" align="left" valign="middle" class="loginheading">&nbsp;</td>
                              </tr>
                              <?php if($_REQUEST[msg]!='') { ?>
                              <tr>
                                  <td height="35" colspan="4" align="center" valign="top" class="leftmenu">
								  
								      <table width="500" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                                        <tr>
                                          <td width="39" height="30" align="center" valign="middle" bgcolor="#FFFF00">
                                          <img src="../images/important.png" width="16" height="16" /></td>
                                          <td width="459" align="left" valign="middle" bgcolor="#FFFF00" class="nametext1"><?php echo $_REQUEST[msg];?></td>
                                        </tr>
                                      </table>
                                      
                                  </td>
                              </tr>
                            <?php } ?>                              
                            <tr>
                              <td colspan="4" align="center" valign="top" class="leftmenu" id="lblerror">
                              
                             </td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="35" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="45%" height="25" align="right" valign="middle"><?php echo constant("RECEPTION_SMS_SELECTOPT");?> :</td>
                                    <td width="55%" align="left" valign="middle">
                                    <select name="opval" id="opval" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:100px;" onchange="show_studentlist();">
                                      <option value=""> Select </option>
                                      <option value="student">Student</option>
                                      <option value="group">Group - Not Started</option>
                                      <option value="groupcontinue">Group - In Progress</option>
                                      <option value="groupfinish">Group - Completed</option>
                                      <!--<option value="all">Sent to All</option>-->
                                      <option value="teacher">Teacher</option>
                                      <option value="staff">Staff</option>
                                      
                                      <option value="Enquiry">Enquiry</option>
                                      <option value="Potential">Potential</option>
                                      
                                      <option value="Waiting - Payment Pending">Waiting - Payment Pending</option>
                                      <option value="Waiting - Full Payment">Waiting - Full Payment</option>
                                      
                                      <option value="Enrolled - Payment Pending">Enrolled - Payment Pending</option>
                                      <option value="Enrolled - Full Payment">Enrolled - Full Payment</option>
                                      
                                      <option value="Active - Payment Pending">Active - Payment Pending</option>
                                      <option value="Active - Full Payment">Active - Full Payment</option>
                                      
                                      <option value="On Hold - Payment Pending">On Hold - Payment Pending</option>
                                      <option value="On Hold - Full Payment">On Hold - Full Payment</option>
                                       
                                      <option value="Cancelled - Payment Pending">Cancelled - Payment Pending</option>
                                      <option value="Cancelled - Full Payment">Cancelled - Full Payment</option>
                                      <option value="Cancelled - Refunded">Cancelled - Refunded</option>
                                      
                                      <option value="Completed - Payment Pending">Completed - Payment Pending</option>
                                      <option value="Completed - Full Payment">Completed - Full Payment</option>
                                      
                                      <option value="Legally Critical">Legally Critical</option>
                                    </select></td>
                                  </tr>
                            </table></td>
                              <td align="left" valign="middle" id="lbl_student_list">
                              <select name="student" id="student" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;">
                                <option value="">-- All Student --</option>
                              </select>
                              </td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="5%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td width="39%" height="35" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_SMS_ENTERSTUDENTNO");?> <span class="nametext1"></span> :</td>
                              <td width="44%" align="left" valign="middle" id="td_state">
                              <?php if($_SESSION[number] == '') { $mobile1 = '009665'; } else { $mobile1 = $_SESSION[number];}?>
                              <input name="number" type="text" class="validate[required] new_textbox190" id="number" size="45" minlength="4" onkeypress="return PhoneNo(event);" value="<?php echo $mobile1;?>"/></td>
                              <td width="12%" align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_SMS_CHOOSETHETEMP");?> :</td>
                              <td align="left" valign="middle"><select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onchange="show_temp();">
                                <option value="">-- Select Template --</option>
                                <?php
                                    foreach($dbf->fetchOrder('sms_templete',"name<>''","id") as $res_temp) {
                                      ?>
                                <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                                <?php }?>
                              </select></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="top" class="leftmenu">
                                 <table>
                                      <tr>
                                      <td width="155" align="center"><?php echo constant("RECEPTION_SMS_OR");?></td>
                                      </tr>
                                      <tr>
                                      <td align="center"><a href="sms_search_student.php?page=sms_search_student.php&amp;TB_iframe=true&amp;height=200&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true"  class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a></td>
                                      </tr>
                                 </table></td>
                              <td align="left" valign="middle" id="lbltemp">
                              <textarea name="textarea" id="textarea" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;" rows="5" cols="29" onfocus="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onclick="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onKeyDown="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onKeyUp="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onblur="if(this.value=='')this.value='SMS Message-<?php echo $char;?> char',checkTab('textarea');" >SMS Message-<?php echo $char;?> char</textarea></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="30" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">
                              <table width="69%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="50%" align="left" valign="middle"><input name="count" type="text" id="count" readonly="readonly" value="160" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                                  <td width="50%" align="right" valign="middle"><input name="count2" type="text" id="count2" readonly="readonly" value="70" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                                </tr>
                            </table>                              
                              </td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="4" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu"><a href="sms.php"><input type="button" value="<?php echo constant("btn_reset_btn");?>" class="btn1" border="0" align="left" /></a></td>
                              <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn1"/></td>
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
                <table width="900" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td width="30" align="left" valign="top" >&nbsp;</td>
                  <td width="554" align="left" valign="top">
                  
                      <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                        <tr>
                          <td height="50" colspan="2" align="center" valign="middle"><img src="../images/errror.png" width="32" height="32"></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                            <tr>
                              <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="10%" align="center" valign="middle"><img src="../images/mobile-phone.png" width="16" height="16"></td>
                                  <td width="90%" class="red_smalltext"><?php echo constant("CD_SMS_ERROR_TEXT");?></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td width="19%" height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td width="66%" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        </table>
                  
                  </td>
                  </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                </tr>
            </table>
                    <?php
				}
				?>
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
                        <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                          <tr>
                            <td width="54%" height="30" align="right" class="logintext"><?php echo constant("CD_SMS_SENDING_TEXTSMS");?>&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    
                      <tr>
                        <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        <?php
                            $res_sms = $dbf->strRecordID("sms_gateway","*","status='Disable'");
                            if($res_sms[status] == '')
                            {
                        ?>
                        <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("CD_SMS_TEXT1");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="sms_process.php" name="frm1" method="post" id="frm1"  onSubmit="return validate();">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                      <td width="5%" align="left" valign="middle" class="leftmenu" >&nbsp;</td>
                                      <td height="30" colspan="4" align="left" valign="middle" class="loginheading">&nbsp;</td>
                                      </tr>
                                      <?php if($_REQUEST[msg]!='') { ?>
                                      <tr>
                                          <td height="35" colspan="4" align="center" valign="top" class="leftmenu">
                                              <table width="500" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF0000;">
                                                <tr>
                                                  <td width="459" height="30" align="right" valign="middle" bgcolor="#FFFF00"  class="nametext1">
												  <?php echo $_REQUEST[msg];?></td>
                                                  <td width="39" align="center" valign="middle" bgcolor="#FFFF00">
                                                  <img src="../images/important.png" width="16" height="16" /></td>
                                                </tr>
                                              </table>
                                           </td>
                                      </tr>
                                      <?php } ?>                                      
                                    <tr>
                                      <td colspan="4" align="center" valign="top" class="leftmenu" id="lblerror"> </td>
                                    </tr>                                      
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="35" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td align="right" valign="middle" id="lbl_student_list">
                                      <select name="student" id="student" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;">
                                        <option value="">-- <?php echo constant('ADMIN_VIEW_COMMENTS_MANAGE_OPTION');?> --</option>
                                      </select>
                                      </td>
                                      <td align="right" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="55%" height="25" align="right" valign="middle">
                                            <select name="opval" id="opval" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF;width:100px;" onchange="show_studentlist();">
                                              <option value=""> Select </option>
                                              <option value="student">Student</option>
                                              <option value="group">Group - Not Started</option>
                                              <option value="groupcontinue">Group - In Progress</option>
                                              <option value="groupfinish">Group - Completed</option>
                                              <option value="teacher">Teacher</option>
                                              <option value="staff">Staff</option>
                                              
                                              <option value="Enquiry">Enquiry</option>
                                              <option value="Potential">Potential</option>
                                              
                                              <option value="Waiting - Payment Pending">Waiting - Payment Pending</option>
                                              <option value="Waiting - Full Payment">Waiting - Full Payment</option>
                                              
                                              <option value="Enrolled - Payment Pending">Enrolled - Payment Pending</option>
                                              <option value="Enrolled - Full Payment">Enrolled - Full Payment</option>
                                              
                                              <option value="Active - Payment Pending">Active - Payment Pending</option>
                                              <option value="Active - Full Payment">Active - Full Payment</option>
                                              
                                              <option value="On Hold - Payment Pending">On Hold - Payment Pending</option>
                                              <option value="On Hold - Full Payment">On Hold - Full Payment</option>
                                               
                                              <option value="Cancelled - Payment Pending">Cancelled - Payment Pending</option>
                                              <option value="Cancelled - Full Payment">Cancelled - Full Payment</option>
                                              <option value="Cancelled - Refunded">Cancelled - Refunded</option>
                                              
                                              <option value="Completed - Payment Pending">Completed - Payment Pending</option>
                                              <option value="Completed - Full Payment">Completed - Full Payment</option>
                                              
                                              <option value="Legally Critical">Legally Critical</option>
                                            </select>
                                            </td>
                                            <td width="45%" align="left" valign="middle">&nbsp; : <?php echo constant("RECEPTION_SMS_SELECTOPT");?></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td width="5%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td width="12%" height="35" align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                      <?php if($_SESSION[number] == '') { $mobile1 = '009665'; } else { $mobile1 = $_SESSION[number];}?>
                                      <td width="44%" align="right" valign="middle" id="td_state">
                                      <input name="number" type="text" class="validate[required] new_textbox190_ar" id="number" size="45" minlength="4" onkeypress="return PhoneNo(event);" value="<?php echo $mobile1;?>"/></td>
                                      <td width="39%" align="right" valign="middle" class="leftmenu">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="55%" height="25" align="left" valign="middle"></td>
                                            <td width="45%" align="left" valign="middle">&nbsp; : <?php echo constant("RECEPTION_SMS_ENTERSTUDENTNO");?></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td align="right" valign="middle"><select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onchange="show_temp();">
                                        <option value="">-- <?php echo constant("SELECT_TEMPLATE");?> --</option>
                                        <?php
                                            foreach($dbf->fetchOrder('sms_templete',"name<>''","id") as $res_temp) {
                                              ?>
                                        <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                                        <?php }?>
                                      </select></td>
                                      <td align="right" valign="middle" class="leftmenu">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="55%" height="25" align="left" valign="middle"></td>
                                            <td width="45%" align="left" valign="middle">&nbsp; : <?php echo constant("RECEPTION_SMS_CHOOSETHETEMP");?></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="28" align="left" valign="top" class="leftmenu">&nbsp;</td>
                                      <td align="right" valign="middle" id="lbltemp">
                                      <textarea name="textarea" id="textarea" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; text-align:right;" rows="5" cols="29" onfocus="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onclick="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onKeyDown="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onKeyUp="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onblur="if(this.value=='')this.value='SMS Message-<?php echo $char;?> char',checkTab('textarea');" >SMS Message-<?php echo $char;?> char</textarea></td>
                                      <td align="right" valign="top" class="leftmenu"><table>
                                          <tr>
                                            <td width="155" align="center"><?php echo constant("RECEPTION_SMS_OR");?></td>
                                          </tr>
                                          <tr>
                                            <td align="center"><a href="sms_search_student.php?page=sms_search_student.php&amp;TB_iframe=true&amp;height=200&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true"  class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="30" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td align="right" valign="middle">
                                      <table width="69%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="50%" align="left" valign="middle"><input name="count2" type="text" id="count2" readonly="readonly" value="70" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                                          <td width="50%" align="right" valign="middle"><input name="count" type="text" id="count" readonly="readonly" value="160" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                                        </tr>
                                    </table>                              </td>
                                      <td align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="10" colspan="4" align="left" valign="middle"></td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td height="25" align="left" valign="middle" class="leftmenu"></td>
                                      <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn2"/></td>
                                      <td align="right" valign="middle"><a href="sms.php">
                                        <input type="button" value="<?php echo constant("btn_reset_btn");?>" class="btn2" border="0" align="left" /></a></td>
                                    </tr>
                                    <tr>
                                      <td height="10" colspan="4" align="left" valign="middle"></td>
                                    </tr>
                                  </table>
                              </form>                        </td>
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
                        <?php } else { ?>
                            <table width="900" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                            <tr>
                              <td colspan="2" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="30" align="left" valign="top" >&nbsp;</td>
                              <td width="554" align="left" valign="top">
                              
                                  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                    <tr>
                                      <td height="50" colspan="2" align="center" valign="middle"><img src="../images/errror.png" width="32" height="32"></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" align="center"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                                        <tr>
                                          <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="90%" align="right" class="red_smalltext"><?php echo constant("CD_SMS_ERROR_TEXT");?></td>
                                              <td width="10%" align="center" valign="middle"><img src="../images/mobile-phone.png" width="16" height="16"></td>
                                              </tr>
                                            </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                      <td width="19%" height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      <td width="66%" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    </table>						  </td>
                                  </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                </tr>
                            </table>
                            <?php
                            }
                            ?>					</td>
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
