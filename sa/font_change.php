<?php
ob_start();
session_start();

//report_unit_taught.php?start_date=2012-01-01&end_date=2012-08-31&x=30&y=6

if($_REQUEST[font]=='big'){
	$_SESSION[font] = "big";
	
}else if($_REQUEST[font]=='small'){
	$_SESSION[font] = "small";
	
}else if($_REQUEST[font]=='reset'){
	$_SESSION[font] = "reset";
	
}else{
	$_SESSION[font] = "reset";
}
$page = base64_decode($_REQUEST[page]);
header("Location:$page");
?>