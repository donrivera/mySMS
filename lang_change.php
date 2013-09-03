<?php
ob_start();
session_start();

if($_REQUEST[lang]==''){
	$_SESSION[lang] = "EN";
}else{
	$_SESSION[lang] = $_REQUEST[lang];
}
header("Location:$_REQUEST[page]");
?>