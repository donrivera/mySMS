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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

if($_SESSION[lang] == "EN"){ ?>
<table width="350" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
	$name="$_REQUEST[number1]";
	if($_REQUEST[number1]=="") { exit; }
	foreach($dbf->fetchOrder("student","first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%'") as $val){
?>
  <tr>
    <td width="196" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
    <td width="148" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["student_mobile"];?></a></td>
  </tr>
  <?php
   }
  ?>
</table>
<?php } else{?>
<table width="350" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
	$name="$_REQUEST[number1]";
	if($_REQUEST[number1]=="") { exit; }
	foreach($dbf->fetchOrder("student","first_name LIKE '$name%'OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%'") as $val){
?>
  <tr>
    <td width="147" align="right" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["student_mobile"];?></a></td>
    <td width="197" align="right" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
  </tr>
  <?php
   }
  ?>
</table>
<?php }?>

