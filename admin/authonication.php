<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$fet = $dbf->strRecordID("user","*","uid='$_REQUEST[student_id]'");
$user = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");

if($fet["uid"] > 0){	
	
	// Session	
	$_SESSION[students_user_name]=$user[first_name];
	$_SESSION[students_id]=$fet[id];
	$_SESSION[students_user_type]="Student";
	//$_SESSION[lang]="1";
	$_SESSION[students_uid]=$fet[uid];
	
	header("location:../student/home.php");
	exit;
}

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
</head>
<script language="javascript" type="text/javascript">
function show()
{
	var d = "diva";
	if(document.getElementById(d).style.display == 'none')
	{
		document.getElementById(d).style.display = '';
	}
	else if(document.getElementById(d).style.display == '')
	{
		document.getElementById(d).style.display = 'none';
	}
}

function show_user()
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
			document.getElementById('lbluser').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbluser').innerHTML=c;
			
			if(c != '')
			{
				document.getElementById('btnsave').style.display = 'none';
			}
			else
			{
				document.getElementById('btnsave').style.display = '';
			}
		}
	}
	
	var tno = document.getElementById('uid').value;
	
	ajaxRequest.open("GET", "user_check.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}
</script>
<body>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
          <tr>
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
			<?php echo constant("ADMIN_S_MANAGE_AUTHENTICATION");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="middle" ><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" align="center" valign="middle"><img src="../images/errror_alert.png" width="128" height="128" /></td>
              </tr>
              <tr>
                <td height="40" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFCC"><span class="loginheading"> <?php echo constant("STUDENT_ADVISOR_SEARCH_TEXTNOLOGIN");?></span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                  <tr>
                    <td width="73%" align="left" valign="middle" bgcolor="#FFECFF" class="nametext1">&nbsp;&nbsp;<?php echo constant("CD_AUTHONICATION_GENERATEUIDANDPASSWORD");?></td>
                    <td width="13%" align="right" valign="middle" bgcolor="#FFECFF"><input type="button" value="<?php echo constant("btn_btn_yes");?>" class="btn_yes" border="0" align="left" onclick="show();"/></td>
                    <td width="14%" height="30" align="center" valign="middle" bgcolor="#FFECFF"><a href="search.php">
                      <input type="button" value="<?php echo constant("btn_btn_no");?>" class="btn_no" border="0" align="left" />
                    </a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="2"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="middle"><div id="diva" style="display:none;">
                  <form action="user_process.php?action=usersetpassword" name="frm" method="post" id="frm">
                    <table width="90%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCCccc;">
                      <tr>
                        <td width="6%" bgcolor="#EDECF2"><input type="hidden" name="student_id" id="student_id" value="<?php echo $_REQUEST[student_id];?>" /></td>
                        <td width="19%" bgcolor="#EDECF2">&nbsp;</td>
                        <td width="2%" bgcolor="#EDECF2">&nbsp;</td>
                        <td width="37%" bgcolor="#EDECF2">&nbsp;</td>
                        <td width="36%" bgcolor="#EDECF2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERID");?> : <span class="nametext1">*</span></td>
                        <td bgcolor="#EDECF2">&nbsp;</td>
                        <td align="left" valign="middle" bgcolor="#EDECF2"><input name="uid" type="text"  autocomplete="off" class="validate[required] new_textbox190" id="uid" value="" onkeyup="show_user();"/></td>
                        <td align="left" valign="middle" bgcolor="#EDECF2" id="lbluser">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_PASSWORD");?> : <span class="nametext1">*</span></td>
                        <td bgcolor="#EDECF2">&nbsp;</td>
                        <td align="left" valign="middle" bgcolor="#EDECF2"><input name="password" type="password" class="validate[required] new_textbox190" id="password" value="" /></td>
                        <td bgcolor="#EDECF2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu">&nbsp;</td>
                        <td height="25" align="left" valign="middle" bgcolor="#EDECF2" class="leftmenu">&nbsp;</td>
                        <td bgcolor="#EDECF2">&nbsp;</td>
                        <td height="40" align="left" valign="middle" bgcolor="#EDECF2"><div id="btnsave" style="display:none;">
                          <input name="submit" id="submit" value="submit" type="image" src="../images/save_btn.png" />
                        </div></td>
                        <td bgcolor="#EDECF2">&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                </div></td>
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
</body>
</html>
