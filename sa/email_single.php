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
		document.getElementById('lbl_error').innerHTML="Enter Email Address.";
		document.frm.mobile.focus();
		return false;
	}
	if(document.frm.msg.value==""){
		document.getElementById('lbl_error').innerHTML="Enter the Message.";
		document.frm.msg.focus();
		return false;
	}
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<?php if($_SESSION[lang] == "EN"){ ?>
<form id="frm" name="frm" method="post" action="email_single_process.php?student_id=<?=$_REQUEST[student_id];?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><span class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></span></td>
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
        <?php if($_REQUEST['msg'] == 'sent'){?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="30" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;">Message has been sent Successfully.</td>
        </tr>
        <?php } ?>
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <?php
		$student = $dbf->strRecordID("student", "*", "id='$_REQUEST[student_id]'");
		?>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="25%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Student Name :</td>
              <td width="2%">&nbsp;</td>
              <td width="73%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
              </tr>
            <tr>
              <td height="30" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Email ID :</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <input name="mobile" type="text" id="mobile" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999;" value="<?php echo $student["email"];?>" />
              </td>
            </tr>
            <tr>
              <td height="30" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Subject :</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="subject" type="text" id="subject" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999;"  /></td>
            </tr>
            <tr>
              <td align="right" valign="top" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">Message :&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <textarea name="msg" id="msg" rows="6" cols="30" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea>
              </td>
            </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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
<?php }else{?>
    <form id="frm" name="frm" method="post" action="email_single_process.php?student_id=<?=$_REQUEST[student_id];?>" onSubmit="return check()">
    <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FF9900;">
      <tr>
        <td colspan="4" align="left" valign="middle" bgcolor="#FFA022"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            
            <td width="11%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
            <td width="19%">&nbsp;</td>
            <td width="70%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><span class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo-ar.png" alt="logo" width="100" height="30" /></span></td>
          </tr>
          <tr>
            <td height="5" colspan="3" align="right" valign="middle"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="middle"><table width="440" border="0" cellspacing="0" cellpadding="0">
          <?php if($_REQUEST['msg'] == 'sent'){?>
          <tr>
            <td align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;"><?php echo $Arabic->en2ar('Message has been sent Successfully');?>&nbsp;</td>
            <td height="30">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php } ?>
          <tr>
            <td align="right" valign="middle" id="lbl_error" class="red_smalltext">&nbsp;</td>
            <td height="30">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="71%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?> <?php echo $student["first_name"];?>&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="28%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo $Arabic->en2ar('Student Name');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle"><input name="mobile" type="text" id="mobile" style="border:solid 1px; text-align:right; background-color:#ECF1FF; width:200px; border-color:#999999;" value="<?php echo $student["email"];?>" /></td>
                <td>&nbsp;</td>
                <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo $Arabic->en2ar('Email ID');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle"><input name="subject" type="text" id="subject" style="border:solid 1px; text-align:right; background-color:#ECF1FF; width:200px; border-color:#999999;" /></td>
                <td>&nbsp;</td>
                <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo $Arabic->en2ar('Subject');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="middle"><textarea name="msg" id="msg" rows="6" cols="30" style="border:solid 1px; background-color:#ECF1FF; text-align:right; border-color:#999999;"></textarea></td>
                <td>&nbsp;</td>
                <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo $Arabic->en2ar('Message');?></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="5" colspan="2" align="right" valign="middle"></td>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="1" colspan="2" align="right" valign="middle" bgcolor="#CCCCCC"></td>
            <td height="1"></td>
          </tr>
          <tr>
            <td height="30" colspan="2" align="right" valign="middle">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="15">&nbsp;</td>
        <td width="395" align="left" valign="middle" style="padding-left:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_send_btn");?>" class="btn2"/></td>
        <td width="27">&nbsp;</td>
        <td width="29">&nbsp;</td>
      </tr>
    </table>
    </form>
    <?php } ?>
</body>
</html>
