<?php
ob_start();

if($_SESSION['lang']=='')
{
	$LANGUAGE = "EN";
}
else
{
	$LANGUAGE = $_SESSION['lang'];
}
switch($LANGUAGE) {
	case "EN":
		require('lang_en.php');
		break;
	case "AR":
		require('lang_ar.php');
		break;
	default:
		require('lang_en.php');
}
?>