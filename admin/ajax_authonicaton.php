<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$dbf = new User();

$fet = $dbf->existsInTable("user","*","uid='$_REQUEST[id]'");
?>

