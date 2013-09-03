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
		numberOfMonths: 2,
		//minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});
</script>
<!--UI JQUERY DATE PICKER-->
<script type="text/javascript" src="dropdowntabs.js"></script>
<script src="js/ga.js" type="text/javascript"></script>
</head>
<script language="JavaScript" type="text/javascript">
function all_students(type){
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
	
	var lbl_group1_dtls = '';
	/*var from_id = 0;
	if(type == 'first'){
		lbl_group1_dtls = 'lbl_student1_dtls';
		from_id = document.getElementById('centre_from').value;
	}else{
		lbl_group1_dtls = 'lbl_student2_dtls';
		from_id = document.getElementById('centre_to').value;
	}*/
	
	
	var from_id = 0;
	if(type == 'first'){
		lbl_group1_dtls = 'lbl_student1_dtls';
		from_id = document.getElementById('from_id').value;
		from_status = document.getElementById('from_status').value;
		course_id = document.getElementById('from_course_id').value;
		centre_from = document.getElementById('centre_from').value;
	}else{
		lbl_group1_dtls = 'lbl_student2_dtls';
		
		//from_status = document.getElementById('to_status').value;
		//course_id = document.getElementById('to_course_id').value;
		centre_from = document.getElementById('centre_to').value;
		from_id = document.getElementById('to_id').value;
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			document.getElementById(lbl_group1_dtls).innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById(lbl_group1_dtls).innerHTML=c;
		}
	}
	
	if(type == 'first'){
		//ajaxRequest.open("GET", "s-to-s-different_studentlist.php" + "?centre_from=" + centre_from, true);
		ajaxRequest.open("GET", "s-to-s-different_studentlist.php" + "?centre_from=" + centre_from +"&group=" + from_id + "&from_status=" + from_status + "&course_id=" + course_id, true);
	}else{
		ajaxRequest.open("GET", "s-to-s-different_studentlist_sec.php" + "?centre_from=" + centre_from, true);
	}	
	ajaxRequest.send(null);
}

function show_to_centre(){
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
			document.getElementById('lbl_centre_to').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById('lbl_centre_to').innerHTML=c;
		}
	}
	var centre_from = document.getElementById('centre_from').value;
	ajaxRequest.open("GET", "s-to-s-different-center-to-center.php" + "?centre_from=" + centre_from, true);
	ajaxRequest.send(null);
}
function show_from_group(){
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
			document.getElementById('lbl_from_id').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById('lbl_from_id').innerHTML=c;
		}
	}
	var centre_from = document.getElementById('centre_from').value;
	ajaxRequest.open("GET", "center_to_center_from_group.php" + "?centre_from=" + centre_from, true);
	ajaxRequest.send(null);
}
function show_to_group(){
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
			document.getElementById('lbl_sec_group').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById('lbl_sec_group').innerHTML=c;
		}
	}
	var centre_from = document.getElementById('centre_from').value;
	var centre_to = document.getElementById('centre_to').value;
	var from_id = document.getElementById('from_id').value;
	ajaxRequest.open("GET", "center_to_center_to_group.php" + "?centre_from=" + centre_from + "&centre_to=" + centre_to + "&from_id=" + from_id, true);
	ajaxRequest.send(null);
}

function show_group_dtls1(type){
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
	
	var lbl_group1_dtls = '';
	var from_id = 0;
	if(type == 'first'){
		lbl_group1_dtls = 'lbl_group1_dtls';
		from_id = document.getElementById('from_id').value;
	}else{
		lbl_group1_dtls = 'lbl_group2_dtls';
		from_id = document.getElementById('to_id').value;
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			document.getElementById(lbl_group1_dtls).innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById(lbl_group1_dtls).innerHTML=c;
		}
	}	
	ajaxRequest.open("GET", "student_to_student_manage_group_dtls.php" + "?group=" + from_id, true);
	ajaxRequest.send(null);
}
function show_student(type){
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
	
	var lbl_group1_dtls = '';
	var from_id = 0;
	if(type == 'first'){
		lbl_group1_dtls = 'lbl_student1_dtls';
		from_id = document.getElementById('from_id').value;
	}else{
		lbl_group1_dtls = 'lbl_student2_dtls';
		from_id = document.getElementById('to_id').value;
	}
	
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			document.getElementById(lbl_group1_dtls).innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;			
			document.getElementById(lbl_group1_dtls).innerHTML=c;
		}
	}
	if(type == 'first'){
		ajaxRequest.open("GET", "student_to_student_manage_student_list.php" + "?group=" + from_id, true);
	}else{
		ajaxRequest.open("GET", "student_to_student_manage_student_list_sec.php" + "?group=" + from_id, true);
	}
	ajaxRequest.send(null);
}
function show_save(){
	document.getElementById('lblsave').style.display = 'none';
	if(document.getElementById('centre_from').value != ''){
		if(document.getElementById('centre_to').value != ''){
			var count = document.getElementById('count').value;
			var is_ok = '';
			for(k = 1; k <= count; k++){
				var sid = 'student_id'+k;
				if(document.getElementById(sid).checked == true){
					is_ok = 'ok';
				}
			}			
			if(is_ok != ''){				
				if(document.getElementById('comment').value != ''){
					document.getElementById('lblsave').style.display = 'block';
				}
			}
		}
	}else{
		document.getElementById('lblsave').style.display = 'none';
	}
}
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
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
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
          <tr bgcolor="#000000">
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("SA_STUDENT_TO_CENTER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="s-to-s-different-center-manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
            <br />
            
            <form action="s-to-s-different-center-process.php?action=transfer" name="frm" method="post" id="frm">
            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td width="458" align="left" valign="top"></td>
                <td width="12" align="left" valign="top">&nbsp;</td>
                <td width="459" align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="11%" align="right" valign="middle" class="mymenutext"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :&nbsp;</td>
                    <td width="89%" align="left"><input name="dated" type="text" class="datepick new_textbox100" id="dated" readonly="readonly" value="<?php echo date('Y-m-d');?>"/></td>
                  </tr>
                </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"><?php echo constant("CD_STUDENT_CENTER_FROM");?> :&nbsp;</td>
                    <td align="center" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                    <select name="centre_from" id="centre_from" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="all_students('first');show_to_centre();show_from_group();">
                        <option value="">--Select--</option>
                        <?php
							foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
						  ?>
                        <option value="<?php echo $valc[id];?>"><?php echo $valc[name];?></option>
                        <?php
					   }
					   ?>
                      </select>
                    </td>
                    <td height="40" align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">Status :&nbsp;</td>
                    <td align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                    <select name="from_status" id="from_status" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:80px;" onchange="all_students('first');">
                        <option value="">--Status--</option>
                        <?php
							foreach($dbf->fetchOrder('student_status',"(id >2 And id < 9)","") as $valstatus) {
						  ?>
                        <option value="<?php echo $valstatus[id];?>"><?php echo $valstatus[name];?></option>
                        <?php
					    }
					    ?>
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <td width="18%" align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"><?php echo constant('ADMIN_GROUP_MANAGE_COURSE');?>&nbsp;</td>
                    <td width="33%" align="center" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                    <select name="from_course_id" id="from_course_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="all_students('first');">
                        <option value="">--Status--</option>
                        <?php
							foreach($dbf->fetchOrder('course',"","") as $course) {
						  ?>
                        <option value="<?php echo $course[id];?>"><?php echo $course[name];?></option>
                        <?php
					    }
					    ?>
                        </select>                    
                    </td>
                    <td width="18%" height="40" align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?>:&nbsp; </td>
                    <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;" id="lbl_from_id">
                      <select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--Select--</option>
                        </select></td>
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group1_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="15%" align="right" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;"><?php echo constant("CD_STUDENT_CENTER_TO");?>:&nbsp;</td>
                    <td width="35%" align="center" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;" id="lbl_centre_to">
                      <select name="to_id2" id="to_id2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--Select--</option>
                      </select>
                    </td>
                    <td width="16%" align="right" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?>:&nbsp;</td>
                    <td width="34%" height="40" align="left" valign="middle" bgcolor="#E9E9E9" id="lbl_sec_group" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;">
                      <select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--Select--</option>
                        </select></td>
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group2_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext" >&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext" id="lbl_student1_dtls">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
                    <td width="38%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="33%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                    <td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                  </tr>
                  <?php
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
						$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" >
                    <input type="checkbox" name="student_id<?php echo $i;?>" id="student_id<?php echo $i;?>" />
                    </td>
                    <td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                    <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
                    <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                  </tr>
                  <?php } ?>
                  </table>
                  </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext" id="lbl_student2_dtls" style="padding-right:8px;">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
                    <td width="38%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="33%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                    <td width="23%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                  </tr>
                  <?php
				  $i = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
				  $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" ><input type="checkbox" name="id<?php echo $i;?>2" id="id<?php echo $i;?>2" value="<?php echo $mygroup[id];?>" /></td>
                    <td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                    <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
                    <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;
                      <?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                  </tr>
                  <?php  $i = $i + 1; } ?>
                  <input type="hidden" name="count2" id="count2" value="<?php echo $i-1;?>" />
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?> :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext">
                <textarea name="comment" id="comment" rows="3" cols="55" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;" onkeyup="show_save();"></textarea></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                <div id="lblsave" style="display:none;">
                <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" />
                </div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table>
            </form>
            
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#000000">
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
               <td width="8%" align="left"><a href="center_to_center_manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="8%" align="left">&nbsp;</td>
                  <td width="22%">&nbsp;</td>
               
                <td width="54%" height="30" align="right" class="logintext"><?php echo constant("SA_CENTER_CENTER");?></td>
              
               
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
            <br />
            
            <form action="center_to_center_process.php?action=transfer" name="frm" method="post" id="frm">
            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td width="458" align="left" valign="top"></td>
                <td width="12" align="left" valign="top">&nbsp;</td>
                <td width="459" align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    
                    <td width="89%" align="right"><input name="dated" type="text" class="datepick new_textbox100" id="dated" readonly="readonly" value="<?php echo date('Y-m-d');?>"/></td>
                    <td width="11%" align="right" valign="middle" class="mymenutext">&nbsp;:&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                  </tr>
                </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    
                    <td width="33%" align="center" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                      <select name="centre_from" id="centre_from" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="all_students('first');show_to_centre();show_from_group();">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                        <?php
							foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
						  ?>
                        <option value="<?php echo $valc[id];?>"><?php echo $valc[name];?></option>
                        <?php
					   }
					   ?>
                      </select>
                    </td>
                    <td width="18%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"> :&nbsp;<?php echo constant("CD_STUDENT_CENTER_FROM");?></td>
                    
                    <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;" id="lbl_from_id">
                      <select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                        </select></td>
                        <td width="18%" height="40" align="left" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">:&nbsp;<?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></td>
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group1_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    
                    <td width="35%" align="center" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;" id="lbl_centre_to">
                      <select name="to_id2" id="to_id2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                      </select>
                    </td>
                    <td width="15%" align="left" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;">:&nbsp;<?php echo constant("CD_STUDENT_CENTER_TO");?></td>
                    
                    <td width="34%" height="40" align="left" valign="middle" bgcolor="#E9E9E9" id="lbl_sec_group" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;">
                      <select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                        </select></td>
                        <td width="16%" align="left" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;">:&nbsp;<?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></td>
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group2_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext" >&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext" id="lbl_student1_dtls">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>                    
                    <td width="23%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                    <td width="33%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                    <td width="38%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
                  </tr>
                  <?php
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
						$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                    <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                    <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
                    <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" >
                    <input type="checkbox" name="student_id<?php echo $i;?>" id="student_id<?php echo $i;?>" />
                    </td>
                  </tr>
                  <?php } ?>
                  </table>
                  </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext" id="lbl_student2_dtls" style="padding-right:8px;">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>
                    <td width="23%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                     <td width="33%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                    <td width="38%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
                  </tr>
                  <?php
				  $i = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
				  $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                    <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;
                      <?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                      <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
                      <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF" ><input type="checkbox" name="id<?php echo $i;?>2" id="id<?php echo $i;?>2" value="<?php echo $mygroup[id];?>" /></td>
                  </tr>
                  <?php  $i = $i + 1; } ?>
                  <input type="hidden" name="count2" id="count2" value="<?php echo $i-1;?>" />
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="mymenutext"> : <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="mymenutext">
                <textarea name="comment" id="comment" rows="3" cols="55" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;" onkeyup="show_save();"></textarea></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                <div id="lblsave" style="display:none;">
                <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" />
                </div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table>
            </form>
            
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        
        <td width="2%">&nbsp;</td>
        <td width="19%" align="left" valign="top"><?php include 'left_menu_right.php';?></td>
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
