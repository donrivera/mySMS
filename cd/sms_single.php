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
<?php if($_SESSION[lang] == "EN"){ ?>
<form id="frm" name="frm" method="post" action="sms_single_process.php?student_id=<?=$_REQUEST[student_id];?>" onSubmit="return check()">
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
      <?php if($_REQUEST['msg'] == 'block'){?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="30" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;">SMS API has been disabled by Administrator</td>
        </tr>
        <?php } ?>
        <?php if($_REQUEST['msg'] != 'block'){?>
        <?php if($_REQUEST['msg'] != ''){?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="30" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;"><?php echo $_REQUEST['msg'];?></td>
        </tr>
        <?php }} ?>
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
              <td width="25%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo ADMIN_VIEW_COMMENTS_MANAGE_STUDENT?> :</td>
              <td width="2%">&nbsp;</td>
              <td width="73%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo ADMIN_TEACHER1_MANAGE_MOBILENUMBER?> :</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">
                <input name="mobile" type="text" id="mobile" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999;" value="<?php echo $student["student_mobile"];?>" />
              </td>
            </tr>
            <tr>
              <td height="30" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo SELECT_TEMPLATE ?> :&nbsp;</td>
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
              <td align="right" valign="top" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo ADMIN_SMS_HISTORY_MESSAGE?> :&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle" id="lbltemp">
                <textarea name="msg" id="msg" rows="5" cols="29" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea>
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
    <form id="frm" name="frm" method="post" action="sms_single_process.php?student_id=<?=$_REQUEST[student_id];?>" onSubmit="return check()">
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
          <?php if($_REQUEST['msg'] == 'block'){?>
          <tr>
            <td width="236" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;"><?php echo $Arabic->en2ar('SMS API has been disabled by Administrator');?></td>
            <td width="65" height="30">&nbsp;</td>
            <td width="29">&nbsp;</td>
          </tr>
          <?php } ?>
          <?php if($_REQUEST['msg'] != 'block'){?>
        	<?php if($_REQUEST['msg'] != ''){?>
          <tr>
            <td align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#f00; font-weight:normal; font-size:12px;"><?php echo $_REQUEST['msg'];?>&nbsp;</td>
            <td height="30">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php }} ?>
          <tr>
            <td align="right" valign="middle" id="lbl_error" class="red_smalltext">&nbsp;</td>
            <td height="30">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="71%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"> <?php echo $student["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                <td width="1%">&nbsp;</td>
                <td width="28%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo ADMIN_VIEW_COMMENTS_MANAGE_STUDENT?></td>
              </tr>
              <tr>
                <td align="right" valign="middle"><input name="mobile" type="text" id="mobile" style="border:solid 1px; text-align:right; background-color:#ECF1FF; width:200px; border-color:#999999;" value="<?php echo $student["student_mobile"];?>" /></td>
                <td>&nbsp;</td>
                <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo ADMIN_TEACHER1_MANAGE_MOBILENUMBER?></td>
              </tr>
              <tr>
                <td align="right" valign="middle">
                <select name="temp" id="temp" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_temp();">
                  <option value="">-- <?php echo SELECT_TEMPLATE ?> --</option>
                  <?php
                foreach($dbf->fetchOrder('sms_templete',"sms_type=''","id") as $res_temp) {
                  ?>
                  <option value="<?php echo $res_temp['id'];?>"><?php echo $res_temp['name'];?></option>
                  <?php }?>
                  </select>
                </td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;<?php echo SELECT_TEMPLATE ?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" id="lbltemp">
                <textarea name="msg" id="msg" rows="5" cols="29" style="border:solid 1px; text-align:right; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                <td>&nbsp;</td>
                <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo ADMIN_SMS_HISTORY_MESSAGE?></td>
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
