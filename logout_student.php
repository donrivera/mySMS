<?php
ob_start();
session_start();

if (isset($_SESSION['students_uid'])) 
{
	// Session	
	unset($_SESSION['students_user_name']);
	session_unregister('students_user_name');
	
	unset($_SESSION['students_id']);
	session_unregister('students_id');
	
	unset($_SESSION['students_user_type']);
	session_unregister('students_user_type');
	
	unset($_SESSION['students_uid']);
	session_unregister('students_uid');
	
	unset($_SESSION['lang']);
	session_unregister('lang');
	
	unset($_SESSION['ALERT_DISPLAY']);
	session_unregister('ALERT_DISPLAY');
	
	session_regenerate_id();
	
	if(isset($_COOKIE['username']))		// If the cookie 'Joe2Torials is set, do the following;
	{
		$time = time();
		setcookie("username", $time - 3600);
		setcookie("password", $time - 3600);
	}
}

header('Location:index.php');
exit;


?>