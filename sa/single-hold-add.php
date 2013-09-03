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

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');

$student_id = $_REQUEST["student_id"];

if($_REQUEST['action']=='insert'){
		
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	$dt = date('Y-m-d');
	$comment = mysql_real_escape_string($_REQUEST[comment]);
	
	$string="dated='$_REQUEST[dated]',student_id='$_REQUEST[student]',course_id='$_REQUEST[course_id]',centre_id='$_SESSION[centre_id]',comment='$comment',cd_status='Pending',created_date='$dt',created_by='$_SESSION[id]'";
	$dbf->insertSet("student_hold",$string);
	
	$course_id = $_REQUEST['course_id'];
	$stu = $dbf->strRecordID("student",'*',"id='$student_id'");
	$enroll = $dbf->strRecordID("student_enroll",'*',"student_id='$student_id' And course_id='$course_id'");
	$course = $dbf->strRecordID("course",'*',"id='$course_id'");
	$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
	
	$course_fee = $course_fees;
	$discount = $enroll["discount"];
	$other_amt = $enroll["other_amt"];
	
	$en_amt = $course_fee - $discount;
	$course_fee_final = $en_amt + $other_amt;
	
	$fee = $dbf->strRecordID("student_fees",'SUM(paid_amt)',"student_id='$student_id' And course_id='$course_id'");
	$paid_amt = $fee["SUM(paid_amt)"];
	$bal_amt = $course_fee_final - $paid_amt;
	
	// Start Mail to Centre Director
	//Get teacher email id
	$from = $dbf->getDataFromTable("user","email","id='$_SESSION[id]'");
	$to = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$cd = $dbf->getDataFromTable("user","user_name","user_type='Center Director' And center_id='$_SESSION[centre_id]'");
	$teacher = $dbf->getDataFromTable("user","user_name","id='$_SESSION[id]'");
	?>
    <style>
	.mycon{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-weight:normal;
	font-size:12px;
	}
	.shop1{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
	color:#204B9A;
	padding-left:2px;
	font-weight:bold;
	}
	</style>
    <?php
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$email_cont = $dbf->strRecordID("email_templetes","*","id='10'");
	$email_msg = $email_cont["content"];
	
	$email_msg = str_replace('%cd%',$cd,$email_msg);
	
	$body1='<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
	  <tr>
		<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
	  </tr>
	  <tr>
		<td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#6a81b1;font-weight:bold;padding-left:45px;">'.$email_msg.'</td>
	  </tr>
	  <tr>
		<td height="30" align="center" valign="top">        
        <table width="250" border="1" cellspacing="0" cellpadding="0" bordercolor="#9999FF" style="border-collapse:collapse;">
          <tr>
            <td width="54%" height="20" align="right" valign="middle" class="mycon">Student Name : &nbsp;</td>
            <td width="46%" align="left" valign="middle" class="shop2">&nbsp;'.$stu["first_name"].'</td>
          </tr>
          <tr>
            <td width="54%" height="20" align="right" valign="middle" class="mycon">Course : &nbsp;</td>
            <td width="46%" align="left" valign="middle" class="shop2">&nbsp;'.$course["name"].'</td>
          </tr>
          <tr class="mycon">
            <td colspan="2" align="center" valign="middle"><u class="mymenutext">Payment Details</u> &nbsp;</td>
          </tr>
          <tr>
            <td width="54%" align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
            <td width="46%" align="left" valign="middle" bgcolor="#999999" class="shop2">&nbsp;'.$course_fee.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Discount (-) : &nbsp;</td>
            <td align="left" valign="middle" class="shop2">&nbsp;'.$discount.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Enrollment Amount : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFF99" class="shop2">&nbsp;'.$en_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Other Amount : &nbsp;</td>
            <td align="left" valign="middle" class="shop2">&nbsp;'.$other_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#9D9DFF" class="shop2">&nbsp;'.$course_fee_final.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Paid Amount : &nbsp;</td>
            <td align="left" valign="middle" class="shop2" >&nbsp;'.$paid_amt.'</td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="mycon">Balance Amount : &nbsp;</td>
            <td align="left" valign="middle" bgcolor="#006699" class="logintext" >&nbsp;'.$bal_amt.'</td>
          </tr>
        </table>        
        </td>
	  </tr>
	  <tr>
	    <td align="right" valign="middle">&nbsp;</td>
  </tr>
	  <tr>
		<td align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:50px;">Thanks</td>
	  </tr>
	  <tr>
		<td height="30" align="right" valign="middle" class="nametext" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#000000;padding-right:28px;">'.$teacher.'</td>
	  </tr>
	  <tr>
		<td align="center" valign="top">&nbsp;</td>
	  </tr>
	</table>';	
	
	$subj = $email_cont["title"];
	$subject = str_replace('%username%',$teacher,$email_msg);
	
	//$subject ="Student on-hold request from ".$teacher;
	mail($to,$subject,$body1,$headers);
	// End Mail
	
	//Start Save Mail	
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student Advisor and Center Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin for Approved or Rejected of the Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
		
	
	//Start Save Mail
	$string="dated='$dt',user_id='$_SESSION[id]',msg='$body1',comment='$comment',send_to='Centre Director',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Student Advisor for Cancellation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);	
	// End Save Mail
		
	header("Location:single-hold.php?student_id=$student_id");
	exit;
}
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
<script type="text/javascript" src="js/filter_textbox.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]==''){
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
<!--JQUERY VALIDATION ENDS-->

<script language="javascript" type="text/javascript">
function show_student(){
	
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
			document.getElementById('lbl_student').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbl_student').innerHTML=c;
		}
	}

	var student_id = <?php echo $student_id;?>;
	var course_id = document.getElementById('course_id').value;

	ajaxRequest.open("GET", "cancel_student_dtls.php" + "?course_id=" + course_id + "&student_id=" + student_id, true);
	ajaxRequest.send(null); 
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
<script type="text/javascript">
function gotfocus()
{
  document.getElementById('student').focus();
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
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
        <td width="19%" align="left" valign="top"><?php include 'single-menu.php';?></td>
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="headingtext"><h1><?php echo constant("MANAGE_ONHOLD");?></h1></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">
                <a href="single-hold.php?student_id=<?php echo $student_id;?>"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                                <td width="100%" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("MANAGE_ONHOLD");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="single-hold-add.php?student_id=<?php echo $student_id;?>&action=insert" name="frm" method="post" id="frm">        
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                      <tr>
                                        <td height="20">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td width="17">&nbsp;</td>
                                        <td width="118" height="30" align="right" class="nametext"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?> : <span class="nametext1">*</span></td>
                                        <td width="283" align="left" valign="middle" class="pedtext">
										<?php echo $dbf->getDataFromTable("student", "first_name", "id='$student_id'")." ".$Arabic->en2ar($dbf->StudentName($student_id));?>
                                        </td>
                                        <td width="330" rowspan="4" align="center" valign="top" id="lbl_student">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="nametext">
										<?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : <span class="nametext1">*</span></td>
                                        <td align="left" valign="middle" id="lbl_course">
                                        <select name="course_id" id="course_id" class="validate[required]" style="width:192px;height:25px; border:solid 1px; border-color:#999999;" onChange="show_student();">
                                            <option value=""><?php echo constant("SELECT_COURSE");?></option>
                                            <?php
                                            foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id' And level_complete='0'","") as $ress2) {
                                                $course = $dbf->strRecordID("course","*","id='$ress2[course_id]'");
                                            ?>
                                            <option value="<?php echo $course["id"];?>"><?php echo $course["name"];?></option>
                                            <?php } ?>
                                        </select>
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="nametext"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : <span class="nametext1">*</span></td>
                                        <td align="left" valign="middle">
                                          <input name="dated" type="text" class="datepickFuture validate[required] new_textbox190" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="nametext"><?php echo constant("SA_REASON_FOR_CANCEL");?> : <span class="nametext1">*</span></td>
                                        <td align="left" valign="middle"><textarea name="comment" class="validate[required]" id="comment" rows="5" cols="35" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="nametext">&nbsp;</td>
                                        <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle">
                                          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="leftmenu"></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
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
                  <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="8%" align="left">
                        <a href="single-hold.php?student_id=<?php echo $student_id;?>"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" class="headingtext" align="right"><h1><?php echo constant("MANAGE_ONHOLD");?></h1></td>
                      
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
                                <td width="100%" align="right" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("MANAGE_ONHOLD");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="single-hold-add.php?student_id=<?php echo $student_id;?>&action=insert" name="frm" method="post" id="frm"> 
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                      <tr>
                                        <td height="20">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>                                        
										<td height="20" class="leftmenu">&nbsp;</td>
										<td height="20">&nbsp;</td>
                                      </tr>
                                      <tr>
									   <td width="330" rowspan="4" align="center" valign="top" id="lbl_student">&nbsp;</td>
                                       <td width="283" align="right" valign="middle" class="pedtext">
                                       <?php echo $dbf->getDataFromTable("student", "first_name", "id='$student_id'");?> <?php echo $Arabic->en2ar($dbf->StudentName($student_id));?>
                                       </td>
                                       <td width="118" height="30" align="left" class="nametext"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?></td>
                                        <td width="17">&nbsp;</td>                                       
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle" id="lbl_course">
                                        <select name="course_id" id="course_id" class="validate[required]" style="width:192px;height:25px; border:solid 1px; border-color:#999999;" onChange="show_student();">
                                            <option value=""><?php echo constant("SELECT_COURSE");?></option>
                                            <?php
                                            foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id' And level_complete='0'","") as $ress2) {
                                                $course = $dbf->strRecordID("course","*","id='$ress2[course_id]'");
                                            ?>
                                            <option value="<?php echo $course["id"];?>"><?php echo $course["name"];?></option>
                                            <?php } ?>
                                        </select>                                        </td>
										<td height="30" align="left" valign="middle" class="nametext">
										<span class="nametext1">*</span> : <?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle">
                                          <input name="dated" type="text" class="datepickFuture validate[required] new_textbox190_ar" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">                                        </td>
										<td height="30" align="left" valign="middle" class="nametext"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_DATE");?></td>
									  <td>&nbsp;</td>
									 </tr>
                                      <tr>
                                        <td align="right" valign="middle"><textarea name="comment" class="validate[required]" id="comment" rows="5" cols="35" style="border:solid 1px; background-color:#ECF1FF; text-align:right; border-color:#999999;"></textarea></td>
										 <td height="30" align="left" valign="middle" class="nametext"><span class="nametext1">*</span> : <?php echo constant("SA_REASON_FOR_CANCEL");?></td>
										 <td>&nbsp;</td>
                                        </tr>
                                      <tr>                                       
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="center" valign="middle" class="leftmenu">&nbsp;</td>                                       
										<td height="30" align="left" valign="middle" class="nametext">&nbsp;</td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle">
                                          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
										 <td height="30" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>                                       
										<td height="30" align="left" valign="middle" class="leftmenu"></td>
										<td>&nbsp;</td>
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
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
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
