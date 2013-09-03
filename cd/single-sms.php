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

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];

if($_SESSION[lang]=='EN'){
	$char = 160;
}else{
	$char = 70;
}

if($_REQUEST["action"] == "sms_sent"){
	
	$student_id = $_REQUEST['student_id'];
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	
	$student_mobile_no = $_REQUEST["number"];
	
	// Your username
	$UserName=UrlEncoding($sms_gateway[user]);
	
	// Your password
	$UserPassword=UrlEncoding($sms_gateway[password]);
	
	// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
	//$Numbers=UrlEncoding("966000000000,966111111111");
	$Numbers=UrlEncoding($student_mobile_no);
	
	// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
	$Originator=UrlEncoding($sms_gateway[your_name]);
	
	// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
	$Message = $_REQUEST[textarea];
	
	// Storing Sending result in a Variable.
	$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
	if($is_enable > 0){
		$SendingResult = SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
		
		$cr_date = date('Y-m-d H:i:s A');
		$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$_REQUEST[textarea]',send_to='student',mobile='$_REQUEST[number]',centre_id='$_SESSION[centre_id]'";
		$ids = $dbf->insertSet("sms_history",$string);
			
		$string1="parent_id='$ids',student_id='$student_id'";
		$dbf->insertSet("sms_history_dtls",$string1);	
	}else{
		$SendingResult = "SMS API disable by Administrator";
	}
	header("Location:single-sms.php?student_id=$student_id&msg=$SendingResult");
	exit;
}
if($_REQUEST["action"] == "email_sent"){
	
	$student_id = $_REQUEST['student_id'];
	
	//Get the information of the Administrator
	$res_admin=$dbf->fetchSingle("user","id='$_SESSION[id]'");
	$from = $res_admin[email];
	
	$headers .= 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From:".$from."\n";
	
	$sentto = $_REQUEST["sentto"];
	$body = $_REQUEST["content"];
	$subject = $_REQUEST["subject"];
			
	mail($sentto,$subject,$body,$headers);
	
	//Start Save Mail
	$dt = date('Y-m-d H:i:s A');
	$string="dated='$dt',user_id='$_SESSION[id]',msg='$subject',send_to='student',email='$sentto',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Direct sent email student new dashboard',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	header("Location:single-sms.php?student_id=$student_id&msg=emailsent");
	exit;
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../admin/ckeditor/ckeditor.js"></script>
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
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="dropdowntabs.js"></script>
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
<?php if($_SESSION[lang] == "EN") { ?>
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
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td colspan="2" align="left" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="35%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> : &nbsp;</td>
                    <td width="65%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");;?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="top"><table width="93%" border="0" cellspacing="0" cellpadding="0">
                <?php
				$is_disable = $dbf->countRows("sms_gateway","status='Disable'");
                if($is_disable > 0){
                ?>
                  <tr>
                    <td align="center" valign="middle">
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
                                      <td width="90%" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_SMS_ERROR_TEXT");?></td>
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
                  <?php }?>
                  <tr>
                    <td height="30" align="center" valign="middle" class="pedtext"><a href="single-sms-details.php?student_id=<?php echo $_REQUEST["student_id"];?>&amp;TB_iframe=true&amp;height=480&amp;width=675&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">View All SMS</a> which is sent to <span class="red_smalltext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></span></td>
                  </tr> 
                  <?php if($is_disable == 0) {?>               
                  <tr>
                    <td align="center" valign="middle">
                    <form action="single-sms.php?action=sms_sent&student_id=<?php echo $student_id;?>" name="frm1" method="post" id="frm1"  onSubmit="return validatesms();">
                    <table width="80%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                      <tr>
                        <td height="35" colspan="4" align="center" valign="top" class="leftmenu">
						<?php if($_REQUEST[msg]=='smssent') { ?>
                          <table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#009900;">
                            <tr>
                              <td width="47" height="30" align="center" valign="middle" bgcolor="#E8FFED"><img src="../images/Info.png" width="16" height="16" /></td>
                              <td width="219" align="left" valign="middle" bgcolor="#E8FFED" class="nametext1"><?php echo $_REQUEST[msg];?></td>
                            </tr>
                          </table>
                          <?php } ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center" valign="top" class="leftmenu" id="lblerror"></td>
                      </tr>
                      
                      <tr>
                        <td width="5%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td width="27%" height="35" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SMS_ENTERSTUDENTNO");?> <span class="nametext1"></span> :</td>
                        <td width="56%" align="left" valign="middle" id="td_state">
                          <input name="number" type="text" class="new_textbox190" id="number" readonly="" value="<?php echo $student["student_mobile"];?>"/></td>
                        <td width="12%" align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SMS_CHOOSETHETEMP");?> :</td>
                        <td align="left" valign="middle">
                        <select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_temp();">
                          <option value="">-- Select Templete --</option>
                          <?php
							foreach($dbf->fetchOrder('sms_templete',"sms_type=''","id") as $res_temp) {
							  ?>
                          <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                          <?php }?>
                        </select></td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="top" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" id="lbltemp"><textarea name="textarea" id="textarea" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;" rows="5" cols="29" onFocus="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onClick="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onKeyDown="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onKeyUp="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onBlur="if(this.value=='')this.value='SMS Message-<?php echo $char;?> char',checkTab('textarea');" >SMS Message-<?php echo $char;?> char</textarea></td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="30" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle"><table width="69%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%" align="left" valign="middle"><input name="count" type="text" id="count" readonly="readonly" value="160" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                            <td width="50%" align="right" valign="middle"><input name="count2" type="text" id="count2" readonly="readonly" value="70" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                          </tr>
                        </table></td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="10" colspan="4" align="left" valign="middle"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
                  <tr>
                    <td align="center" valign="middle">
                    <br>
                    <span class="red_smalltext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></span>
                    <br>
                    <br>
                    <form action="single-sms.php?action=email_sent&student_id=<?php echo $student_id;?>" name="frm2" method="post" id="frm2"  onSubmit="return validateemail();">
                    <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#ccc;">
                      <tr>
                        <td width="111" height="30" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo constant("MESSAGE_TO");?> :</td>
                        <td colspan="2" bgcolor="#FFFFFF"><input name="sentto" type="text" readonly="" class="new_textbox190" id="sentto" value="<?php echo $student["email"];?>"/></td>
                        <td width="69" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo constant("STUDENT_ADVISOR_EMAIL_SUBJECT");?> :</td>
                        <td height="30" colspan="3" align="left" valign="middle" bgcolor="#FFFFFF"><input name="subject" type="text" id="subject" style="border:solid 1px; border-color:#FFCC00;width:400px;"></td>
                      </tr>
                      <?php $res = $dbf->strRecordID("email_templete","*",""); ?>
                      <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF" class="pedtext"><?php echo constant("STUDENT_ADVISOR_EMAIL_MESSAGE");?> :</td>
                        <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF"><textarea name="content" id="content" ><?php echo $res["content"];?></textarea>
                          <script type="text/javascript">
							//<![CDATA[
				
								CKEDITOR.replace( 'content', {
									extraPlugins : 'autogrow',
									autoGrow_maxHeight : 100,width : 470,
height:250,toolbar:[
        ['Bold','Italic','Underline','Strike'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Undo','Redo'],['Font'],['FontSize'],['TextColor']]									
								});
							</script></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                        <td width="62" bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="329" bgcolor="#FFFFFF">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                        <td height="35" align="right" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_send_btn");?>" class="btn1"/></td>
                        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table>
                    </form>
                    </td>
                  </tr>
                  <?php } ?>
                </table></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else { ?>
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
        <td width="79%" align="left" valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
				<td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="64%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="36%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="top"><table width="93%" border="0" cellspacing="0" cellpadding="0">
                <?php
                if($dbf->countRows("sms_gateway","status='Disable'") > 0){
                ?>
                  <tr>
                    <td align="center" valign="middle">
                    	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                            <tr>
                              <td height="50" colspan="2" align="center" valign="middle"><img src="../images/errror.png" width="32" height="32"></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                                <tr>
                                  <td height="30" align="center" valign="middle" bgcolor="#FEF7D8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="90%" align="right" class="red_smalltext"><?php echo constant("STUDENT_ADVISOR_SMS_ERROR_TEXT");?></td>
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
                        </table>                    </td>
                  </tr>
                  <?php }else{?>                  
                  <tr>
                    <td align="center" valign="middle">
                    <form action="single-sms.php?action=sms_sent&student_id=<?php echo $student_id;?>" name="frm1" method="post" id="frm1"  onSubmit="return validatesms();">
                    <table width="80%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                      <tr>
                        <td height="35" colspan="4" align="center" valign="top" class="leftmenu">
						<?php if($_REQUEST[msg]=='smssent') { ?>
                          <table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#009900;">
                            <tr>
                              <td width="219" height="30" align="right" valign="middle" bgcolor="#E8FFED" class="nametext1"><?php echo $_REQUEST[msg];?></td>
                              <td width="47" align="center" valign="middle" bgcolor="#E8FFED"><img src="../images/Info.png" width="16" height="16" /></td>
                            </tr>
                          </table>
                          <?php } ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center" valign="top" class="leftmenu" id="lblerror"></td>
                      </tr>                      
                      <tr>
                        <td width="12%" align="left" valign="middle">&nbsp;</td>
                        <td width="56%" align="right" valign="middle" id="td_state">
                          <input name="number" type="text" class="new_textbox190" id="number" readonly="" value="<?php echo $student["student_mobile"];?>"/></td>
                        <td width="27%" height="35" align="right" valign="middle" class="leftmenu"> <span class="nametext1"></span> :<?php echo constant("STUDENT_ADVISOR_SMS_ENTERSTUDENTNO");?></td>
                        <td width="5%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle">
                        <select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_temp();">
                          <option value="">-- <?php echo constant("SELECT_TEMPLATE");?> --</option>
                          <?php
							foreach($dbf->fetchOrder('sms_templete',"sms_type=''","id") as $res_temp) {
							  ?>
                          <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                          <?php }?>
                        </select></td>
                        <td height="28" align="right" valign="middle" class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_SMS_CHOOSETHETEMP");?></td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                         <td align="left" valign="middle" id="lbltemp"><textarea name="textarea" id="textarea" style="border:solid 1px; text-align:right; border-color:#999999;background-color:#ECF1FF;" rows="5" cols="29" onFocus="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onClick="if(this.value=='SMS Message-<?php echo $char;?> char')this.value='';" onKeyDown="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onKeyUp="<?php if($_SESSION[lang]=='EN'){ ?> CountLeft(); <?php } else if($_SESSION[lang]!='EN') {?> CountLeft_AR(); <?php }?>" onBlur="if(this.value=='')this.value='SMS Message-<?php echo $char;?> char',checkTab('textarea');" >SMS Message-<?php echo $char;?> char</textarea></td>
                        <td height="28" align="left" valign="top" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle"><table width="69%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%" align="left" valign="middle"><input name="count" type="text" id="count" readonly="readonly" value="160" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                            <td width="50%" align="right" valign="middle"><input name="count2" type="text" id="count2" readonly="readonly" value="70" style="width:50px; border:solid 1px; border-color:#FFCC00; text-align:center; font-weight:bold; background-color:#FFFF99;" /></td>
                          </tr>
                        </table></td>
                        <td height="30" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="10" colspan="4" align="left" valign="middle"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn2"/></td>
                        <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="10" colspan="4" align="left" valign="middle"></td>
                      </tr>
                    </table>
                    </form></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">
                    <br>
                    <form action="single-sms.php?action=email_sent&student_id=<?php echo $student_id;?>" name="frm2" method="post" id="frm2"  onSubmit="return validateemail();">
                    <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#ccc;">
                      <tr>
                        <td width="190" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td colspan="2" align="right" bgcolor="#FFFFFF"><input name="sentto" type="text" readonly="" class="new_textbox190" id="sentto" value="<?php echo $student["email"];?>"/></td>
                        <td width="89" height="30" align="right" valign="middle" bgcolor="#FFFFFF" class="menutext">:<?php echo constant("MESSAGE_TO");?>&nbsp;&nbsp;</td>
                      </tr>
                      <tr>
                        
                        <td height="30" colspan="3" align="right" valign="middle" bgcolor="#FFFFFF"><input name="subject" type="text" id="subject" style="border:solid 1px; border-color:#FFCC00; text-align:right;width:400px;"></td>
                        <td align="right" valign="middle" bgcolor="#FFFFFF" class="menutext"> :<?php echo constant("STUDENT_ADVISOR_EMAIL_SUBJECT");?>&nbsp;&nbsp;</td>
					  </tr>
                      <?php $res = $dbf->strRecordID("email_templete","*",""); ?>
                      <tr>
                        <td colspan="3" align="right" valign="middle" bgcolor="#FFFFFF"><textarea name="content" id="content" ><?php echo $res["content"];?></textarea>
                          <script type="text/javascript">
							//<![CDATA[
				
								CKEDITOR.replace( 'content', {
									extraPlugins : 'autogrow',
									autoGrow_maxHeight : 100,width : 500,
height:250,toolbar:[
        ['Bold','Italic','Underline','Strike'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Undo','Redo'],['Font'],['FontSize'],['TextColor']]									
								});
							</script></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF" class="menutext"> :<?php echo constant("STUDENT_ADVISOR_EMAIL_MESSAGE");?>&nbsp;&nbsp;</td>
						</tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                        <td width="104" bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="228" bgcolor="#FFFFFF">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                        <td height="35" align="left" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_send_btn");?>" class="btn2"/></td>
                        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                    </table>
                    </form>                    </td>
                  </tr>
                  <?php } ?>
                </table></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>		</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
