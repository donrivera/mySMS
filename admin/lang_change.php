<?php
ob_start();
session_start();

if($_REQUEST[lang]==''){
	$_SESSION[lang] = "EN";
}else{
	$_SESSION[lang] = $_REQUEST[lang];
}
$page = base64_decode($_REQUEST[page]);
header("Location:$page");
?>