<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';
$dbf = new User();

$teacher_name = $dbf->strRecordID("teacher", "*", "id='$_REQUEST[teacher_id]'");
?>
<?php if($_SESSION[lang]=="EN"){?>
<input name="number" type="text" class="validate[required] new_textbox190" id="number" value="<?php echo $teacher_name[mobile];?>" />
<?php } else{?>
<input name="number" type="text" class="validate[required] new_textbox190_ar" id="number" value="<?php echo $teacher_name[mobile];?>" />
<?php }?>
