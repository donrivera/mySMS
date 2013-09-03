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

$pageTitle='Welcome to Berlitz-KSA';


//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<script language="javascript" type="text/javascript">	
function showno()
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
			document.getElementById('show').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('show').innerHTML=c;
		}
	}
	
	var number1 = document.getElementById('number').value;
	//alert(number1);
	ajaxRequest.open("GET", "sms_show_student_name.php" + "?number1=" + number1, true);
	ajaxRequest.send(null); 
}
</script>

</head>
<body>
<?php if($_SESSION[lang] == "EN"){?>
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
      <table width="460" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td height="30" id="lbl_error2" class="red_smalltext">&nbsp;</td>
        </tr>
        <tr>
          <td width="96" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#006;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?> <span class="nametext1"></span> :&nbsp;</td>
          <td width="344" height="30" id="lbl_error" class="red_smalltext"><input name="number" type="text" class="validate[required]" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999;" id="number" onkeyup="showno();"/></td>
        </tr>
        <tr>
          <td height="30" colspan="2" align="center" valign="middle" id="show">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right" valign="top" style="padding-right:8px;">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
<?php } else { ?>
<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
  <tr>
    <td width="66%" align="left" valign="middle" bgcolor="#FFA62B" class="leftmenu" ><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
    <td height="30" colspan="2" align="left" valign="middle"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="64%" align="right" valign="middle" bgcolor="#FFA21F"><span class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo-ar.png" alt="logo" width="100" height="30" /></span>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top" class="leftmenu" id="lblerror"></td>
  </tr>
  <tr>
    <td height="30" align="right" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#006;">&nbsp;</td>
  </tr>
  <tr>
    <td width="66%" height="44" align="right" valign="middle" class="leftmenu"><input name="number" type="text" class="validate[required]" style="border:solid 1px; background-color:#ECF1FF; width:200px; border-color:#999999; text-align:right;" id="number" onkeyup="showno();"/></td>
    <td width="1%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#006;">&nbsp; : <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
  </tr>
  <tr>
    <td height="28" colspan="2" align="center" valign="middle" class="leftmenu" id="show">&nbsp;</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC"></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" valign="middle"></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
