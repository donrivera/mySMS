<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	$cr_date = date('Y-m-d H:i:s A');
	
	$valg = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
	
	$string="group_id='$_REQUEST[group]',centre_id='$_SESSION[centre_id]',course_id='$valg[course_id]',schedule_date='$_REQUEST[schedule_date]',dated='$_REQUEST[dated]',room_id='$_REQUEST[room_id]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	
	$gid = $dbf->insertset("cd_makeup_class",$string);
	
	//Insert IN details table
	$count = $_REQUEST[count];
	for($i = 1; $i<=$count; $i++){
		$id1 = "id".$i;
		$id1 = $_REQUEST[$id1];
		if($id1 != ''){
			//Insert query here
			$string="parent_id='$gid',student_id='$id1',group_id='$_REQUEST[group]',course_id='$valg[course_id]',centre_id='$_SESSION[centre_id]'";
			$dbf->insertset("cd_makeup_class_dtls",$string);
		}
	}	
	header("Location:ep_scheduling_manage.php");   
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("cd_makeup_class","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("cd_makeup_class_dtls","parent_id='$_REQUEST[id]'");
	
	header("Location:ep_scheduling_manage.php");
}
?>
