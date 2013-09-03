<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';
$dbf = new User();

$res=$dbf->fetchSingle("student","id='$_REQUEST[student]'");
?>
<input name="number" type="text" class="validate[required] textfield1" id="number" size="45" minlength="4" value="<?php echo $res[student_mobile];?>" />
