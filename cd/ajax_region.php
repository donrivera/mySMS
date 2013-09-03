<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';
$dbf = new User();

$res=$dbf->fetchSingle("student","id='$_REQUEST[student]'");
?>
<?php if($_SESSION[lang]=="EN"){?>
<input name="number" type="text" class="validate[required] new_textbox190" id="number" size="45" minlength="4" value="<?php echo $res[student_mobile];?>" />
<?php } else{?>
<input name="number" type="text" class="validate[required] new_textbox190_ar" id="number" size="45" minlength="4" value="<?php echo $res[student_mobile];?>" />
<?php }?>
