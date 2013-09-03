<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_mail = $dbf->strRecordID("teacher","*","id='$_REQUEST[tno]'");

echo $res_mail["mobile"];
?>