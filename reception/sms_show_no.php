<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
if($_SESSION[lang] == "EN"){ ?>
<table width="350" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border-color:#0000CC;">
<?php
	$name="$_REQUEST[number1]";
	if($_REQUEST[number1]=="") { exit; }
	foreach($dbf->fetchOrder("student","centre_id='$_SESSION[centre_id]' And (first_name LIKE '$name%' OR student_first_name LIKE '$name%' OR first_name1 LIKE '$name%')") as $val)
	{
?>
  <tr>
    <td width="196" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["first_name"];?></a></td>
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
	foreach($dbf->fetchOrder("student","centre_id='$_SESSION[centre_id]' And (first_name LIKE '$name%' OR student_first_name LIKE '$name%' Or first_name1 LIKE '$name%')") as $val)
	{
?>
  <tr>    
    <td width="147" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["student_mobile"];?></a></td>
    <td width="197" align="left" valign="top" style="padding-left:5px;"><a href="sms_f.php?number=<?php echo $val["student_mobile"];?>" ><?php echo $val["first_name"];?></a></td>
  </tr>
  <?php
		}
  ?>
</table>
<?php }?>

