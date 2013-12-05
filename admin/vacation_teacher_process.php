<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

//Admin
$res_user = $dbf->strRecordID("user","*","id='$_SESSION[id]'");

if($_REQUEST['action']=='insert'){
	$teacher_id = $_REQUEST[teacher];
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
	//Current date and Time
	$cr_date = date('Y-m-d H:i:s A');	
	//$string="teacher_id='$teacher_id',frm='$_POST[startdate]',tto='$_POST[enddate]',type='$_POST[type]',no_days='$days',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	//$id = $dbf->insertSet("teacher_vacation",$string);
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","teacher_id='$teacher_id'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","teacher_id='$teacher_id'");
	$tto = $res_e["MAX(end_date)"];
	$duplicate=$dbf->genericQuery("	SELECT * 
									FROM teacher_vacation 
									WHERE teacher_id='$teacher_id'
									AND (('$start' BETWEEN frm AND tto) OR ('$end' BETWEEN frm AND tto))");
	if($duplicate <= 0 || empty($duplicate))
	{	
		$getDates=$dbf->schedLeaves("Teacher",$teacher_id,$start,$end,$_REQUEST[type]);
		$string="teacher_id='$teacher_id',frm='$_POST[startdate]',tto='$_POST[enddate]',type='$_POST[type]',no_days='$days',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$id = $dbf->insertSet("teacher_vacation",$string);
	}
	else
	{
		echo '<script type="text/javascript">alert("Duplicate Transaction!");window.history.back();</script>';
	}
	header("Location:vacation_teacher_manage.php");
	
}
if($_REQUEST['action']=='edit')
{
	//Detail of teacher vacation according to ID
	$res_vac = $dbf->strRecordID("teacher_vacation","*","id='$_REQUEST[id]'");
	//Date diffeerent in two dates
	$days = $res_vac["no_days"];
	$teacher_id = $res_vac["teacher_id"];
	$start = $res_vac[frm];
	$end = $res_vac[tto];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","teacher_id='$teacher_id'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","teacher_id='$teacher_id'");
	$tto = $res_e["MAX(end_date)"];
	$dbf->updateSchedLeaves("Teacher",$_REQUEST[id],$_POST[startdate],$_POST[enddate],$res_vac["teacher_id"]);
	header("Location:vacation_teacher_manage.php");
}

if($_REQUEST['action']=='delete')
{
	//Detail of teacher vacation according to ID
	$res_vac = $dbf->strRecordID("teacher_vacation","*","id='$_REQUEST[id]'");
	//Date diffeerent in two dates
	$days = $res_vac["no_days"];
	$teacher_id = $res_vac["teacher_id"];
	$start = $res_vac[frm];
	$end = $res_vac[tto];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","teacher_id='$teacher_id'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","teacher_id='$teacher_id'");
	$tto = $res_e["MAX(end_date)"];
	$dbf->deleteSchedLeaves("Teacher",$_REQUEST[id]);
	$dbf->deleteFromTable("teacher_vacation","id='$_REQUEST[id]'");
	header("Location:vacation_teacher_manage.php");
}
?>