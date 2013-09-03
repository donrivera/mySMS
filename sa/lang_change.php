<?php
ob_start();
session_start();

unset($_SESSION['lang']);
session_unregister('lang');

if($_REQUEST[lang]==''){
	$_SESSION[lang] = "EN";
}else{
	$_SESSION[lang] = $_REQUEST[lang];
}
$page = base64_decode($_REQUEST[page]);
header("Location:$page");
?>