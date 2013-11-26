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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$teacher_id = $_SESSION[uid];
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
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
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
	$( "#action_report_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
	$( "#action_taken_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
	$( "#result_check_date" ).datepicker({
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
	
<script language="Javascript" type="text/javascript">
function gotfocus()
{
  document.getElementById('group_id').focus();
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
function show_student()
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
			document.getElementById('lblstudent').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblstudent').innerHTML=c;
		}
	}

	var group_id = document.getElementById('group_id').value;

	ajaxRequest.open("GET", "arf_add_student_ajax.php" + "?group_id=" + group_id, true);
	ajaxRequest.send(null); 
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="30%" class="footertext">&nbsp;<?php echo constant("TEACHER_ARF_MANAGE_EDITARF");?></td>
                  <td width="70%" align="right" valign="middle"><a href="arf_manage.php"> 
                  <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
            <table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td height="10" colspan="3" align="center" valign="top">
                  <br>
                  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">					
                    <form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">						
                      <?php
                      $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");$user = $dbf->strRecordID("user","user_type,user_name","id='$_SESSION[id]'");
                      ?>					
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?> : <span class="nametext1">*</span></td>
                        <td class="leftmenu"><span style="border-bottom:dotted 1px #000000;">
                          <select name="group_id" class="" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_student();">
                            <option value="">Select Group</option>
                            <?php
                              foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'","","") as $res_group) {
                                  ?>
                            <option value="<?php echo $res_group['id'];?>" <?php if($res_arf[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>>
                            <?php echo $res_group['group_name'];?></option>
                            <?php
                              }
                              ?>
                          </select>
                        </span></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle">
                        <a href="arf_print.php?id=<?php echo $_REQUEST["id"];?>" target="_blank">
                        <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/></a>
                        </td>
                      </tr>
                      <tr>
                        <td width="86">&nbsp;</td>
                        <td width="118" height="30" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?> : <span class="nametext1">*</span></td>
                        <td width="221" class="leftmenu" id="lblstudent">
                          <select name="student" id="student"  style="width:192px; height:25px; border:solid 1px; border-color:#999999;"><!--class="validate[required]"-->
                             <option value="">--Select Student--</option>
                            <?php
                            foreach($dbf->fetchOrder('student',"certificate_collect='0'","first_name") as $ress2) {
                          ?>
                            <option value="<?php echo $ress2['id']?>" <?php if($ress2[id]==$res_arf[student_id]) { ?> selected="selected" <?php } ?>>
                            <?php echo $ress2[first_name]."&nbsp;".$ress2[father_name]."&nbsp;".$ress2[family_name]."&nbsp;(".$ress2[first_name1]."&nbsp;".$ress2[father_name1]."&nbsp;".$ress2[grandfather_name1]."&nbsp;".$ress2[family_name1].")";?></option>
                            <?php }?>
                          </select>
                        </td>
                        <td width="11">&nbsp;</td>
                        <td width="86">&nbsp;</td>
                        <td width="226">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : <span class="nametext1">*</span></td>
                        <td align="left" valign="middle"  class="leftmenu">
                          <input name="dated" type="text" class="datepickFuture validate[required] new_textbox190" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">
                        </td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_NR");?> : <span class="nametext1">*</span></td>
                        <td align="left" valign="middle"><input name="nr" type="text" class="validate[required] new_textbox190" id="nr" value="<?php echo $res_arf[nr];?>"/></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWENER");?> : <span class="nametext1">*</span></td>
                        <td align="left" valign="middle"  class="leftmenu"><input name="owner" type="text" class="validate[required] new_textbox190" id="owner" value="<?php echo $user[user_type]."-".$user[user_name];?>" readonly="readonly"/></td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                            <td>&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?> : <span class="nametext1">*</span></td>
                            <td align="left" valign="middle" class="leftmenu"></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTEDTO");?>:</td>
                            <td align="left" valign="middle"></td>
                      </tr>
					<tr>		
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CUSTOMER");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="function" value="customer" <?php echo ($res_arf["arf_function"] == 'customer' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td width="74" align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
						<td height="25" align="left" valign="middle">
							<span class="leftmenu">
								<input type="radio" name="function1" value="reception" <?php echo ($res_arf["arf_function1"] == 'reception' ? 'checked' : '')?>>
							</span>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_TEACHER");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="function" value="teacher" <?php echo ($res_arf["arf_function"] == 'teacher' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LCD");?> : </td>
						<td height="25" align="left" valign="middle">
							<span class="leftmenu">
								<input type="radio" name="function1" value="lcd" <?php echo ($res_arf["arf_function1"] == 'lcd' ? 'checked' : '')?>>
							</span> 
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="function" value="reception" <?php echo ($res_arf["arf_function"] == 'reception' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LIS");?> : </td>
						<td height="25" align="left" valign="middle">
							<span class="leftmenu">
								<input type="radio" name="function1" value="lis" <?php echo ($res_arf["arf_function1"] == 'lis' ? 'checked' : '')?>>
							</span>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="function" value="customer service" <?php echo ($res_arf["arf_function"] == 'customer service' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
						<td height="25" align="left" valign="middle">
							<span class="leftmenu">
								<input type="radio" name="function1" value="customer service" <?php echo ($res_arf["arf_function1"] == 'customer service' ? 'checked' : '')?>>
							</span>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="function" value="other" <?php echo ($res_arf["arf_function"] == 'other' ? 'checked' : '')?>>
							<input name="other1" type="text" id="other1" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> :</td>
						<td height="25" align="left" valign="middle">&nbsp;&nbsp;
							<input type="radio" name="function1" value="other" <?php echo ($res_arf["arf_function1"] == 'other' ? 'checked' : '')?>>
							<input name="other2" type="text" id="other2" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_SUBJECT");?> :</td>
						<td align="left" valign="middle" class="leftmenu"></td>
					</tr>
					<tr>
						<td align="center" class="leftmenu"></td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_INSTRUCTION");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="instruction" <?php echo ($res_arf["subject"] == 'instruction' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_MATERIAL");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="material" <?php echo ($res_arf["subject"] == 'material' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PROGRAMME");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="program" <?php echo ($res_arf["subject"] == 'program' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PREMISSES");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="premises" <?php echo ($res_arf["subject"] == 'premises' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ADMINST");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="administration" <?php echo ($res_arf["subject"] == 'administration' ? 'checked' : '')?>>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
						<td height="25" align="left" valign="middle" class="leftmenu">
							<input type="radio" name="subject" value="other" <?php echo ($res_arf["subject"] == 'other' ? 'checked' : '')?>>
							<input name="other3" type="text" class="new_textbox100" id="other3" value="<?php echo $res_arf[other3];?>"size="45" minlength="4"/>
						</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
                </table>
				<table>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORT");?>:</td>
						<td><textarea name="action_report" cols="50" rows="10"><?php echo $res_arf[action_report];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="action_report_date"  type="text" class="new_textbox100" id="action_report_date" size="45" value="<?php echo $res_arf[action_report_date];?>"/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONTAKEN");?>:</td>
						<td><textarea name="action_taken" cols="50" rows="10"><?php echo $res_arf[action_taken];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="action_taken_date"  type="text" class="new_textbox100" id="action_taken_date" size="45" value="<?php echo $res_arf[action_taken_date];?>"/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RESULTCHECKED");?>:</td>
						<td><textarea name="result_check" cols="50" rows="10"><?php echo $res_arf[result_check];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="result_check_date"  type="text" class="new_textbox100" id="result_check_date" size="45" value="<?php echo $res_arf[result_check_date];?>"/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="30" align="left" valign="middle" class="leftmenu"></td>
						<td align="center" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
					</tr>
				</table>
				<input type="hidden" name="record_id" value="<?php echo $res_arf["id"];?>">
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
            </table>
                  </td>
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
                  <td height="30" align="right" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="17%" align="left" valign="middle">&nbsp;<a href="arf_manage.php"> 
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
                            <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
                            <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                          <tr>
                            <td align="center" valign="top" bgcolor="#EBEBEB">					
                        <form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">						
                          <?php
                          $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
                          ?>					
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                          <tr>
                            <td align="right" valign="middle">
                            <a href="arf_print.php?id=<?php echo $_REQUEST["id"];?>" target="_blank">
                            <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/></a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right" class="leftmenu"><span style="border-bottom:dotted 1px #000000;">
                              <select name="group_id" class="" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_student();">
                                <option value="">Select Group</option>
                                <?php
                                  foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'","","") as $res_group) {
                                      ?>
                                <option value="<?php echo $res_group['id'];?>" <?php if($res_arf[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>>
                                <?php echo $res_group['group_name'];?></option>
                                <?php
                                  }
                                  ?>
                              </select>
                            </span></td>
                            <td height="30" align="right" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="197">&nbsp;</td>
                            <td width="97">&nbsp;</td>
                            <td width="11">&nbsp;</td>
                            <td width="192" align="right" class="leftmenu" id="lblstudent">
                              <select name="student" id="student" class="validate[required]" style="width:182px; height:25px; border:solid 1px; border-color:#999999;">
                                 <option value="">--Select Student--</option>
                                <?php
                                foreach($dbf->fetchOrder('student',"certificate_collect='0'","first_name") as $ress2) {
                                ?>
                                <option value="<?php echo $ress2['id']?>" <?php if($ress2[id]==$res_arf[student_id]) { ?> selected="selected" <?php } ?>>
                                <?php echo $ress2['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($ress2["id"]));?></option>
                                <?php }?>
                              </select>
                            </td>
                            <td width="127" height="30" align="right" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?></td>
                            <td width="112">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle"><input name="nr" type="text" class="validate[required] new_textbox190" id="nr" value="<?php echo $res_arf[nr];?>"/></td>
                            <td align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_NR");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle"  class="leftmenu">
                              <input name="dated" type="text" class="datepickFuture validate[required] new_textbox100_ar" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">
                            </td>
                            <td height="30" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_DATE");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle"  class="leftmenu"><input name="owner" type="text" class="validate[required] new_textbox100_ar" id="owner" value="<?php echo $res_arf[action_owner];?>"/></td>
                            <td height="30" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWENER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="right" valign="middle">
                              <input name="report_to"  type="text" class="new_textbox190" id="report_to" value="<?php echo $res_arf[report_to];?>" size="45" minlength="4"/>
                            </td>
                            <td align="right" valign="middle" class="leftmenu">:<?php echo constant("TEACHER_ARF_MANAGE_REPORTEDTO");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle"><input name="report_by" type="text" class="validate[required] new_textbox190" id="report_by" value="<?php echo $res_arf[report_by];?>"/></td>
                            <td height="30" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="31" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">:<?php echo constant("TEACHER_ARF_MANAGE_FUNCTION");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="30" align="right" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_FUNCTION");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle"><span class="leftmenu">
                              <input name="reception2" type="text" class="new_textbox100_ar" id="reception2" value="<?php echo $res_arf[reception2];?>">
                            </span></td>
                            <td width="97" align="left" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="customer" type="text" value="<?php echo $res_arf[customer];?>" class="new_textbox100_ar" id="customer"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_CUSTOMER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle"><span class="leftmenu">
                              <input name="lcd" type="text" class="new_textbox100_ar" id="lcd" value="<?php echo $res_arf[lcd];?>">
                            </span> </td>
                            <td align="left" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_LCD");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="teacher" type="text" value="<?php echo $res_arf[teacher];?>" class="new_textbox100_ar" id="teacher"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_TEACHER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle"><span class="leftmenu">
                              <input name="lis" type="text" class="new_textbox100_ar" value="<?php echo $res_arf[lis];?>" id="lis">
                            </span></td>
                            <td align="left" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_LIS");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="reception1" type="text" value="<?php echo $res_arf[reception1];?>" class="new_textbox100_ar" id="reception1"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle"><span class="leftmenu">
                              <input name="cs2" type="text" class="new_textbox100_ar" value="<?php echo $res_arf[cs2];?>" id="cs2">
                            </span></td>
                            <td align="left" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_CS");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="cs1" type="text" value="<?php echo $res_arf[cs1];?>" class="new_textbox100_ar" id="cs1"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_CS");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle"><span class="leftmenu">
                            <input name="other2" type="text" class="new_textbox140_ar" id="other2" value="<?php echo $res_arf[other2];?>" size="35" minlength="4"/></span></td>
                              <td align="left" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_OTHER");?></td>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="other1" type="text" class="new_textbox140_ar" id="other1" value="<?php echo $res_arf[other1];?>" size="35" minlength="4"/></td>
                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_OTHER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>													
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="instruction" value="<?php echo $res_arf[instruction];?>" type="text" class="new_textbox100_ar" id="instruction"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_INSTRUCTION");?></td>
                            <td align="center" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_SUBJECT");?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="material" value="<?php echo $res_arf[material];?>" type="text" class="new_textbox100_ar" id="material"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_MATERIAL");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="programme" value="<?php echo $res_arf[programme];?>" type="text" class="new_textbox100_ar" id="programme"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_PROGRAMME");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="premisses" value="<?php echo $res_arf[premisses];?>" type="text" class="new_textbox100_ar" id="premisses"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_PREMISSES");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="administration" value="<?php echo $res_arf[administration];?>" type="text" class="new_textbox100_ar" id="administration"></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_ADMINST");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="right" valign="middle" class="leftmenu"><input name="other3" type="text" class="new_textbox140_ar" id="other3" value="<?php echo $res_arf[other3];?>"size="35" minlength="4"/></td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_OTHER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="center" bgcolor="#FFC058" class="leftmenu" ><?php echo constant("TEACHER_ARF_MANAGE_REPORT");?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle" class="leftmenu">:<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_DATE");?></td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONTAKEN");?></td>
                         </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle" class="leftmenu">:<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?></td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("TEACHER_ARF_MANAGE_DATE");?></td>
                            <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="top" class="leftmenu">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RESULTCHECKED");?></td>
                          </tr>
                          <tr>
                          <td align="center" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                            <td>&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu"></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td width="12" align="center" valign="middle">&nbsp;</td>
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
<?php }?>
</body>
</html>
