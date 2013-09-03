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

if($_SESSION[lang] == "EN"){ ?>
<table width="350" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
	$name="$_REQUEST[number1]";
	if($_REQUEST[number1]=="") { exit; }
	foreach($dbf->fetchOrder("student","family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%' And centre_id='$_SESSION[centre_id]'") as $val){
?>
  <tr>
    <td width="196" align="left" valign="top" style="padding-left:5px; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" style="text-decoration:none;" ><?php echo $val["first_name"];?></a></td>
    <td width="148" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
  </tr>
  <?php	} ?>
</table>
<?php } else{?>
<table width="350" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
	$name="$_REQUEST[number1]";
	if($_REQUEST[number1]=="") { exit; }
	foreach($dbf->fetchOrder("student","family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%' And centre_id='$_SESSION[centre_id]'") as $val){
?>
  <tr>    
    <td width="147" align="right" valign="top" style="padding-right:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>"  style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
    <td width="197" align="right" valign="top" style="padding-right:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>"  style="text-decoration:none;"><?php echo $val["first_name"];?></a></td>
  </tr>
  <?php	} ?>
</table>
<?php }?>
