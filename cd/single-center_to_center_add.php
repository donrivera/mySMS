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
include("../includes/saudismsNET-API.php");
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$student_id = $_REQUEST['student_id'];

if($_REQUEST['action']=='centre_transfer'){

	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	$reg_dt = date('Y-m-d');
	
	$string="dated='$_REQUEST[dated]',centre_from='$_REQUEST[centre_from]',from_id='$_REQUEST[from_id]',centre_to='$_REQUEST[centre_to]',to_id='$_REQUEST[to_id]',centre_id='$_SESSION[centre_id]',created_by='$_SESSION[id]',created_date='$reg_dt',status='Pending',comment='$comm'";
	$parent_id = $dbf->insertSet("transfer_centre_to_centre",$string);
		
	$string="parent_id='$parent_id',student_id='$student_id'";
	$dbf->insertSet("transfer_centre_to_centre_dtls",$string);
	
	//Mail
	//Get teacher email id
	$userfrom = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
	$from = $userfrom["email"];
	
	$userto = $dbf->strRecordID("user","*","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$to = $userto["email"];
	
	$mobile_no = $userto["mobile"];
	
	$cd = $userto["user_name"];
	$teacher = $userfrom["user_name"];
	
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='9'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%cd%',$cd,$email_msg);
	
	$body1='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
		  <tr>
			<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
		  </tr>
		  <tr>
		    <td align="left" valign="middle">&nbsp;</td>
  		  </tr>
		  <tr>
			<td height="50" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#999999; padding-left:5px;">'.$email_msg.'</td>
		  </tr>		  
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>';
	
	$subj = $email_cont["title"];
	$subject = str_replace('%teacher%',$teacher,$subj);
	//$subject ="Request for transfer from (SA) ".$teacher;
	mail($to,$subject,$body1,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	//SMS
	if($dbf->countRows("sms_gateway","status='Enable'") > 0){
		
		$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
		if($mobile_no != ''){
				
			// Your username
			$UserName=UrlEncoding($sms_gateway[user]);
			
			// Your password
			$UserPassword=UrlEncoding($sms_gateway[password]);
			
			// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
			//$Numbers=UrlEncoding("966000000000,966111111111");
			$Numbers=UrlEncoding($mobile_no);
			
			// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
			$Originator=UrlEncoding($sms_gateway[your_name]);
			
			// Your Message in English or arabic or both.
			// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
			$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='37'");
			$msg = str_replace('%teacher%',$teacher,$sms_cont);
			
			$Message=$msg;
			
			// Storing Sending result in a Variable.
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
			//================================
			//SAVED SMS
			//================================
			$cr_date = date('Y-m-d H:i:s A');
			
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='SA to CD',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("sms_history",$string);
			//================================
			//SAVED SMS
			//================================
		}
	}
	
	header("Location:single-transfer.php?student_id=$student_id");
	exit;
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
                <td width="54%" height="30" class="logintext"><?php echo constant("SA_CENTER_CENTER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="single-transfer.php?student_id=<?php echo $student_id ?>"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
            <br />
            <form action="single-center_to_center_add.php?student_id=<?php echo $student_id;?>&action=centre_transfer" name="frm" method="post" id="frm">
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
                    <td width="18%" align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"><?php echo constant("CD_STUDENT_CENTER_FROM");?> :&nbsp;</td>
                    <td width="33%" align="center" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                      <select name="centre_from" id="centre_from" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <?php
						foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]' And m.status<>'Completed'","m.centre_id","m.centre_id") as $valc) {
							$centre = $dbf->strRecordID("centre", "*", "id='$valc[centre_id]'");
						  ?>
                        <option value="<?php echo $centre[id];?>"><?php echo $centre[name];?></option>
                        <?php
					   }
					   ?>
                      </select>
                    </td>
                    <td width="18%" height="40" align="right" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?>:&nbsp; </td>
                    <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;" id="lbl_from_id">
                      <select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('first'),show_student('first');">
                        <option value="">--Select--</option>
                        <?php
							foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]' And m.status<>'Completed'","m.group_name","m.*") as $valc) {
						  ?>
                        <option value="<?php echo $valc[id];?>"><?php echo $valc[group_name];?></option>
                        <?php
					    }
					    ?>
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
                      <select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('sec'),show_student('sec');">
                        <option value="">--Select--</option>
                        <?php
						foreach($dbf->fetchOrder('centre',"id<>'$_SESSION[centre_id]'","name") as $valc) {
						  ?>
                        <option value="<?php echo $valc[id];?>"><?php echo $valc[name];?></option>
                        <?php
					   }
					   ?>
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
                
                
                <td align="left" valign="middle">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td width="89%" align="right"><input name="dated" type="text" class="datepick new_textbox100_ar" id="dated" readonly="readonly" value="<?php echo date('Y-m-d');?>"/></td>
                    <td width="11%" align="left" valign="middle" class="mymenutext">&nbsp;: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                    
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
              <td align="left" valign="top"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    
                    <td width="35%" align="center" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;" id="lbl_centre_to">
                      <select name="to_id2" id="to_id2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                      </select>
                    </td>
                    <td width="15%" align="left" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;"> : <?php echo constant("CD_STUDENT_CENTER_TO");?></td>
                    
                    <td width="34%" height="40" align="left" valign="middle" bgcolor="#E9E9E9" id="lbl_sec_group" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;">
                      <select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                        </select></td>
                        <td width="16%" align="left" valign="middle" bgcolor="#E9E9E9" class="hometest_name" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#999;"> : <?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></td>
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group2_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
                  <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;" id="lbl_from_id">
                      <select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
                        <option value="">--<?php echo constant("SELECT");?>--</option>
                        </select></td>
                        <td width="18%" height="40" align="left" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">&nbsp; : <?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></td>
                        <td width="33%" align="center" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">
                      <select name="centre_from" id="centre_from" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;">
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
                    <td width="18%" align="left" valign="middle" bgcolor="#CCCCCC" style="border-left:solid 1px; border-top:solid 1px; border-bottom:solid 1px; border-color:#666;">&nbsp; :<?php echo constant("CD_STUDENT_CENTER_FROM");?></td>
                    
                    
                    
                    </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top" id="lbl_group1_dtls">&nbsp;</td>
                    </tr>
                  </table></td>
                
                
              </tr>
              <tr>
                <td align="left" valign="top" class="mymenutext" >&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext">&nbsp;</td>
              </tr>
              <tr>
              <td align="left" valign="top" class="mymenutext" id="lbl_student2_dtls" style="padding-right:8px;">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>
                  <td width="23%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                   <td width="33%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                    <td width="38%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;">&nbsp;</td>
                   
                   
                    
                  </tr>
                  <?php
				  $i = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
				  $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                  <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext" style="padding-right:5px;">&nbsp;
                      <?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                      <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext" style="padding-right:5px;">&nbsp;<?php echo $student["student_mobile"];?></td>
                     <td align="right" valign="middle" bgcolor="#FFFFFF"  style="padding-right:5px;">&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                     
                    <td align="center" valign="middle" bgcolor="#FFFFFF" ><input type="checkbox" name="id<?php echo $i;?>2" id="id<?php echo $i;?>2" value="<?php echo $mygroup[id];?>" /></td>
                   
                    
                  </tr>
                  <?php  $i = $i + 1; } ?>
                  <input type="hidden" name="count2" id="count2" value="<?php echo $i-1;?>" />
                </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="mymenutext" id="lbl_student1_dtls">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr>
                  <td width="23%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                  <td width="33%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                   <td width="38%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext" style="padding-right:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                    <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
                   
                    
                    
                  </tr>
                  <?php
				  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='0'") as $mygroup) {
						$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				  ?>
                  <tr>
                   <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext" style="padding-right:5px;">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
                   <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext" style="padding-right:5px;">&nbsp;<?php echo $student["student_mobile"];?></td>
                   <td align="right" valign="middle" bgcolor="#FFFFFF" style="padding-right:5px;" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                   
                    <td align="center" valign="middle" bgcolor="#FFFFFF"  >
                    <input type="checkbox" name="student_id<?php echo $i;?>" id="student_id<?php echo $i;?>" />
                    </td>
                    
                    
                   
                  </tr>
                  <?php } ?>
                  </table>
                  </td>
                
                
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="right" valign="top" class="mymenutext" style="padding-right:7px;"> : <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></td>
              </tr>
              <tr>
               <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                <td align="right" valign="top" class="mymenutext">
                <textarea name="comment" id="comment" rows="3" cols="55" style="border:solid 1px; text-align:right; background-color:#ECF1FF; border-color:#999999;" onkeyup="show_save();"></textarea></td>
              
               
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
