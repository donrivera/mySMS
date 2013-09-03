<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");

$res_c = $dbf->strRecordID("course","*","id='$res_g[course_id]'");

echo $res_c[name];
?>