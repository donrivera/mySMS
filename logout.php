<?php
ob_start();
session_start();

if(isset($_SESSION['id'])){
	
	unset($_SESSION['id']);
	//session_unregister('id');
	
	unset($_SESSION['admin_name']);
	//session_unregister('admin_name');
	
	unset($_SESSION['user_type']);
	//session_unregister('user_type');
	
	unset($_SESSION['uid']);
	//session_unregister('uid');
	
	unset($_SESSION['lang']);
	//session_unregister('lang');
	
	unset($_SESSION['ALERT_DISPLAY']);
	//session_unregister('ALERT_DISPLAY');
	
	session_unset();
	session_destroy();
	
	session_regenerate_id();
	
	// Unset Cookies
	
	if(isset($_COOKIE['username']))		// If the cookie 'Joe2Torials is set, do the following;
	{
		$time = time();
		setcookie("username", $time - 3600);
		setcookie("password", $time - 3600);
	}
}
header('Location:.');
/*if($_SERVER['HTTP_HOST'] == "bletprojects.com" || $_SERVER['HTTP_HOST'] == "localhost"){
	header('Location:index.php');
}else if($_SERVER['HTTP_HOST'] == "berlitz-ksa.com"){ 
	header('Location:mySMS/index.php');
}else{
	header('Location:index.php');
}*/
exit;
?>