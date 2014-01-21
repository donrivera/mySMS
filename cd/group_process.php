<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	$num=$dbf->countRows('student_group',"teacher_id='$_POST[teacher]' AND group_id='$_POST[group]' AND centre_id='$_SESSION[centre_id]' AND course_id='$_POST[course]'");
	if($num>0){
		header("Location:group_review.php?msg=exist");
		exit;
	}
	
	$string="group_id='$_POST[group]',centre_id='$_SESSION[centre_id]',course_id='$_POST[course]',teacher_id='$_POST[teacher]',units='$_POST[unit]', week_no='$_POST[week_no]', dated='$_POST[dated]',room_id='$_POST[class_room]',start_date='$_POST[start_date]', end_date='$_POST[end_date]',sa_id='$_SESSION[id]'";
		
	$gid = $dbf->insertset("student_group",$string);
	
	$count = $_REQUEST[count];
	for($i = 1; $i<=$count; $i++){
		$id = "id".$i;
		$id = $_REQUEST[$id];
		if($id != ''){
			//Insert query here
			$string="parent_id='$gid',student_id='$id',group_id='$_POST[group]',course_id='$_POST[course]',centre_id='$_SESSION[centre_id]',room_id='$_POST[class_room]'";
			$dbf->insertset("student_group_dtls",$string);
		}
	}
	header("Location:group_manage.php");
	exit;	
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("student_group","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("student_group_dtls","parent_id='$_REQUEST[id]'");
	
	header("Location:group_manage.php");
}
?>
