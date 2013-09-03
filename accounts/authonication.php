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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$fet = $dbf->strRecordID("user","*","user_type='Student' And uid='$_REQUEST[student_id]'");
$user = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");

if($fet["uid"]!='')
{
	// Session	
	$_SESSION[students_user_name]=$user[first_name];
	$_SESSION[students_id]=$fet[id];
	$_SESSION[students_user_type]="Student";
	$_SESSION[lang]="1";
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
          <tr>
            <td height="30" bgcolor="#FFA938" class="centercolumntext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_SEARCH_AUTHENTI");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="middle" bgcolor="#e6e6e6"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" align="center" valign="middle"><img src="../images/errror_alert.png" width="128" height="128" /></td>
              </tr>
              <tr>
                <td height="150" align="center" valign="top"><table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFCC"><span class="loginheading"><?php echo constant("STUDENT_ADVISOR_SEARCH_TEXTNOLOGIN");?> </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
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
