<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{	
	$row = "aid".$_REQUEST[row];
	$row = $_REQUEST[$row];
	
	$msg = "msg".$_REQUEST[row];
	$msg = $_REQUEST[$msg];
	
	$dt = date('Y-m-d h:i:s');
	
	$string="alert_id='$row',msg='$msg',user_id='$_SESSION[id]',date_time='$dt'";
		
	$dbf->insertset("alerts_reply",$string);	
	
	header("Location:home.php");
}
?>
