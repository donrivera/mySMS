<?php

ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$teacher_id = $_SESSION[uid];

if($_REQUEST['action']=='edit')
{
	echo "test";
	//echo var_dump($_REQUEST);
	$cr_date = date('Y-m-d H:i:s A');
	//$string="teacher_id='$_SESSION[uid]',student_id='$_POST[student]',group_id='$_REQUEST[group_id]',dated='$_POST[dated]',nr='$_POST[nr]',action_owner='$_POST[owner]',report_by='$_POST[report_by]',report_to='$_POST[report_to]',customer='$_POST[customer]',teacher='$_POST[teacher]',reception1='$_POST[reception1]',cs1='$_POST[cs1]',other1='$_POST[other1]',reception2='$_POST[reception2]',lcd='$_POST[lcd]',lis='$_POST[lis]',cs2='$_POST[cs2]',other2='$_POST[other2]',instruction='$_POST[instruction]',material='$_POST[material]',programme='$_POST[programme]',premisses='$_POST[premisses]',administration='$_POST[administration]',other3='$_POST[other3]',last_updated='$cr_date',updated_by='$_SESSION[uid]'";
	$string="report_to='$_REQUEST[report_to]',sa_status='1'";
	$dbf->updateTable("arf",$string,"id='$_REQUEST[record_id]'");
	header("Location:arf_manage.php");
}

?>	