<?php
ob_start();
session_start();
include '../includes/class.Main.php';
$dbf = new User();

$q = $_GET["q"];
//echo $q;exit;
if(!$q) return;

foreach($dbf->fetchOrder('student',"first_name LIKE '$q%' OR student_first_name LIKE '$q%'","first_name") as $st_dtls) {
	$cname = $st_dtls[first_name];
	echo "$cname\n";
}
?>