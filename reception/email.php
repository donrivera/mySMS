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
<script type="text/javascript" src="../admin/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript">	
function validate(){	
	var x = document.getElementById('student_2').value;
	if(x == ""){
		return false;
	}
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
	ajaxRequest.open("GET", "sms_student.php" + "?opval=" + opval , true);
	ajaxRequest.send(null);
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
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="30%" height="30" align="left" class="logintext"><?php echo constant("RECEPTION_EMAIL_SENDINGTHE");?></td>
                <td width="46%" align="left" valign="middle" id="lblname"><?php if($_REQUEST[msg]=="sent") { ?>
                  <table width="300" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="40" height="20" align="center" valign="middle" bgcolor="#FFF0FF"><img src="../images/Info.png" width="16" height="16"></td>
                      <td width="260" align="left" valign="middle" bgcolor="#FFF0FF" class="nametext1"><?php echo constant("RECEPTION_EMAIL_EMAILSUCMSG");?></td>
                    </tr>
                  </table>
                  <?php } ?></td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="title headingtext">&nbsp;</td>
          </tr>
          <?php
          $res = $dbf->strRecordID("email_templete","*","");
		  ?>
          <tr>
            <td align="center" valign="middle" class="title headingtext">
            
            <form action="email_process.php" name="frm1" method="post" id="frm1" onSubmit="return validate();">
            <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#666699;">
              <tr>
                <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              <tr>
                <td width="112" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SMS_SELECTOPT");?> :&nbsp;</td>
                <td width="107" align="left" bgcolor="#FFFFFF">
                <select name="opval" id="opval" style="border:solid 1px; border-color:#999999; width:100px;" onChange="show_studentlist();">
                  <option value="">Select</option>
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
                </select></td>
                <td width="320" align="left" valign="middle" id="lbl_student_list" bgcolor="#FFFFFF">
                  <select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;">
                    <option value="">-- All Student --</option>
                  </select>
                </td>
                <td width="386" align="left" valign="middle" bgcolor="#FFFFFF" id="lblerror"><span><a href="sms_search_student_name.php?page=sms_search_student_name.php&amp;TB_iframe=true&amp;height=200&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a></span></td>
                </tr>
              <tr>
                <td align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_EMAIL_SUBJECT");?>  :&nbsp;</td>
                <td height="30" colspan="3" align="left" valign="middle" bgcolor="#FFFFFF">
                <input name="subject" type="text" id="subject" style="border:solid 1px; border-color:#999999;width:400px;"></td>
                </tr>
              <tr>
                <td align="right" valign="top" bgcolor="#FFFFFF" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_EMAIL_MESSAGE");?> :&nbsp;</td>
                <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF">
                
                <textarea name="content" id="content" ><?php echo $res["content"];?></textarea><script type="text/javascript">
							//<![CDATA[
				
								CKEDITOR.replace( 'content', {
									extraPlugins : 'autogrow',
									autoGrow_maxHeight : 600,toolbar:[
        ['Bold','Italic','Underline','Strike'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Undo','Redo'],['Format'],['Styles'],['Font'],['FontSize'],['TextColor']]
									
								});
				
							//]]>
							</script>                </td>
                </tr>
              <tr>
                <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              <tr>
                <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                <td height="35" colspan="2" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn1"/></td>
                <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
            </table>
            </form>
            
            </td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="title headingtext">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            </td>
          </tr>
         	
          
        </table>
        
        </td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else{?>
<table style="margin-top:-15px;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
        <td width="79%" align="left" valign="top">
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
            <tr>
              <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="46%" align="left" valign="middle" id="lblname"><?php if($_REQUEST[msg]=="sent") { ?>
                    <table width="300" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="40" height="20" align="center" valign="middle" bgcolor="#FFF0FF"><img src="../images/Info.png" width="16" height="16"></td>
                        <td width="260" align="left" valign="middle" bgcolor="#FFF0FF" class="nametext1"><?php echo constant("RECEPTION_EMAIL_EMAILSUCMSG");?></td>
                        </tr>
                      </table>
                    <?php } ?></td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>                  
                  <td width="30%" height="30" align="right" class="logintext"><?php echo constant("RECEPTION_EMAIL_SENDINGTHE");?></td>
                 </tr>
                </table></td>
              </tr>
            <tr>
              <td align="center" valign="middle" class="title headingtext">&nbsp;</td>
              </tr>
            <?php
          $res = $dbf->strRecordID("email_templete","*","");
		  ?>
            <tr>
              <td align="center" valign="middle" class="title headingtext">
                
                <form action="email_process.php" name="frm1" method="post" id="frm1" onSubmit="return validate();">
                  <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#666699;">
                    <tr>
                      <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="386" align="right" valign="middle" bgcolor="#FFFFFF" id="lblerror"><span><a href="sms_search_student_name.php?page=sms_search_student_name.php&amp;TB_iframe=true&amp;height=200&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a></span></td>
                      <td width="320" align="right" valign="middle" bgcolor="#FFFFFF" id="lbl_student_list">
                        <select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;">
                            <option value="">-- <?php echo constant('ADMIN_VIEW_COMMENTS_MANAGE_OPTION');?> --</option>
                          </select>
                        </td>
                        <td width="107" align="right" valign="middle" bgcolor="#FFFFFF">
                        <select name="opval" id="opval" style="border:solid 1px; border-color:#999999; width:100px;" onChange="show_studentlist();">
                        
                        <option value=""> Select </option>

                        <option value="student">Student</option>
                        <option value="group">Group - Not Started</option>
                        <option value="groupcontinue">Group - In Progress</option>
                        <option value="groupfinish">Group - Completed</option>
                        
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
                        <td width="112" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SMS_SELECTOPT");?></td>
                      
                      </tr>
                    <tr>
                      
                      <td height="30" colspan="3" align="right" valign="middle" bgcolor="#FFFFFF">
                        <input name="subject" type="text" id="subject" style="border:solid 1px; text-align:right; border-color:#999999; text-align:right; width:400px;"></td>
                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_EMAIL_SUBJECT");?></td>
                      </tr>
                    <tr>                      
                      <td colspan="3" align="right" valign="middle" bgcolor="#FFFFFF">                        
                        <textarea name="content" id="content" ><?php echo $res["content"];?></textarea><script type="text/javascript">
							//<![CDATA[
				
								CKEDITOR.replace( 'content', {
									extraPlugins : 'autogrow',
									autoGrow_maxHeight : 600,toolbar:[
								['Bold','Italic','Underline','Strike'],
								['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
								['Undo','Redo'],['Format'],['Styles'],['Font'],['FontSize'],['TextColor']]
									
								});
				
							//]]>
							</script></td>
                            <td align="left" valign="top" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_EMAIL_MESSAGE");?></td>
                      </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#FFFFFF" class="menutext">&nbsp;</td>
                      <td height="35" colspan="2" align="right" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn2"/></td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                
                </td>
              </tr>
            <tr>
              <td align="center" valign="middle" class="title headingtext">&nbsp;</td>
              </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#FFFFFF">
                </td>
              </tr>
            
            
            </table>
          
        </td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
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
