<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='save'){

	//update query here
	$string="room_id='$_REQUEST[room_id]'";

	$dbf->updateTable("student_group",$string,"id='$_POST[group]'");
	$dbf->updateTable("student_group_dtls",$string,"parent_id='$_POST[group]'");
		
	header("Location:ep_change_classroom.php");
	exit;
}
?>
