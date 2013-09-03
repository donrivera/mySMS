<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST[tno]=='') { exit; }

$num=$dbf->countRows('user',"user_id='$_REQUEST[tno]'");
if($num > 0)
{
	echo "User ID already exist.";
}
?>