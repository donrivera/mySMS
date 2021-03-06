<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script language="javascript" type="text/javascript">
function check(){
	if(document.frm.mobile.value==""){
		document.getElementById('lbl_error').innerHTML="Enter Mobile No.";
		document.frm.mobile.focus();
		return false;
	}
	if(document.frm.msg.value==""){
		document.getElementById('lbl_error').innerHTML="Enter the Message.";
		document.frm.msg.focus();
		return false;
	}
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
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
.btn2{
background:url(../images/btn2.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
</style>
</head>
<body>
<form id="frm" name="frm" method="post" action="sms_single_process.php?student_id=<?=$_REQUEST[student_id];?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></td>
          <td width="19%">&nbsp;</td>
          <td width="11%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top">
      <table width="440" border="0" cellspacing="0" cellpadding="0">
      <?php if($_REQUEST['msg'] == 'block'){?>
        <tr>
          <td>&nbsp;</td>
          <td height="30" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;">SMS API has been disabled by Administrator</td>
        </tr>
        <?php } ?>
        <?php if($_REQUEST['msg'] != 'block'){?>
        <?php if($_REQUEST['msg'] != ''){?>
        <tr>
          <td>&nbsp;</td>
          <td height="30" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;"><?php echo $_REQUEST['msg'];?></td>
        </tr>
        <?php }} ?>
        <tr>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <?php
		$student = $dbf->strRecordID("student", "*", "id='$_REQUEST[student_id]'");
		?>
        <tr>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="38%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Student Name :</td>
              <td width="1%">&nbsp;</td>
              <td width="61%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo $dbf->printStudentName($student[id]);?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Mobile No :</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <input name="mobile" type="text" id="mobile" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999;" value="<?php echo $student["student_mobile"];?>" />
                </td>
              </tr>
            <tr>
              <td height="30" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo constant("STUDENT_ADVISOR_SMS_CHOOSETHETEMP");?> :&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_temp();">
                  <option value="">-- Select Templete --</option>
                  <?php
                foreach($dbf->fetchOrder('sms_templete',"sms_type=''","id") as $res_temp) {
                  ?>
                  <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                  <?php }?>
                  </select>
                </td>
              </tr>
            <tr>
              <td align="right" valign="top" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Message :&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle" id="lbltemp">
                <textarea name="textarea" id="textarea" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;" rows="5" cols="29" onfocus="if(this.value=='SMS Message-160 char')this.value='';" onclick="if(this.value=='SMS Message-160 char')this.value='';"><?php echo $res[contents];?></textarea>
                </td>
              </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn1"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
