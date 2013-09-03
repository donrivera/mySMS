<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';
$dbf = new User();

$res=$dbf->fetchSingle("sms_templete","id='$_REQUEST[temp]'");

?>
<textarea name="textarea" id="textarea" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;" rows="5" cols="29" onfocus="if(this.value=='SMS Message-160 char')this.value='';" onclick="if(this.value=='SMS Message-160 char')this.value='';" onKeyDown="CountLeft();" onKeyUp="CountLeft();" ><?php echo $res[contents];?></textarea>
