<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$users_id = $_SESSION["user_entry"];

//Date and Time
$mydt = date("Y-m-d h:i:s");

if($_REQUEST["action"] == "send")
{
	//Comment or Message
	$comments = mysql_real_escape_string($_REQUEST["msg"]);
	
	//insert query here
	if($comments != ''){
		$string="student_id='$_REQUEST[ids]',user_id='$users_id',comments='$comments',date_time='$mydt'";
		$dbf->insertSet("student_comment",$string);
	}
}
?>