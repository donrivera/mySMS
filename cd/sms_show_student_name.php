<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="400" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
$name="$_REQUEST[number1]";
if($_REQUEST[number1]=="") { exit; }
foreach($dbf->fetchOrder("student","(family_name LIKE '$name%' OR family_name1 LIKE '$name%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%') And centre_id='$_SESSION[centre_id]' And email <> ''") as $val){
?>
  <tr>
    <td width="126" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
    <td width="111" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
    <td width="105" align="left" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["email"];?></a></td>
  </tr>
  <?php
	}
  ?>
</table>
<?php } else{?>
<table width="400" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
$name="$_REQUEST[number1]";
if($_REQUEST[number1]=="") { exit; }
foreach($dbf->fetchOrder("student","(family_name LIKE '$name%' OR family_name1 LIKE '$name%' OR first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%') And centre_id='$_SESSION[centre_id]' And email <> ''") as $val){
?>
  <tr>
    <td width="111" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["student_mobile"];?></a></td>
    <td width="105" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $val["email"];?></a></td>
    <td width="126" align="right" valign="top" style="padding-left:2px; font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000;"><a href="sms_student_f.php?student_id=<?php echo $val["id"];?>" style="text-decoration:none;"><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?><?php echo $val["first_name"];?></a></td>
  </tr>
  <?php
	}
  ?>
</table>
<?php }?>