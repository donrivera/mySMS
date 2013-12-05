<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	//Date diffeerent in two dates
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
	//Current date and Time
	$cr_date = date('Y-m-d H:i:s A');
	//$string="centre_id='$_POST[center]',name='$_POST[name]',frm='$_POST[startdate]',tto='$_POST[enddate]',no_days='$days',type='$_POST[type]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	//$dbf->insertSet("exam_vacation",$string);
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","centre_id='$_POST[center]'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","centre_id='$_POST[center]'");
	$tto = $res_e["MAX(end_date)"];
	$duplicate=$dbf->genericQuery("	SELECT * 
									FROM exam_vacation 
									WHERE name='$_POST[name]' AND center_id='$_POST[center]'
									AND (('$start' BETWEEN frm AND tto) OR ('$end' BETWEEN frm AND tto))");
	if($duplicate <= 0 || empty($duplicate))
	{	
		$getDates=$dbf->schedLeaves("Exam",$_POST[name],$start,$end,$_POST[center]);
		$string="centre_id='$_POST[center]',name='$_POST[name]',frm='$_POST[startdate]',tto='$_POST[enddate]',no_days='$days',type='$_POST[type]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("exam_vacation",$string);
	}
	else
	{
		echo '<script type="text/javascript">alert("Duplicate Transaction!");window.history.back();</script>';
	}
	header("Location:vacation_exam_manage.php");
}
if($_REQUEST['action']=='edit')
{
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("exam_vacation","*","id='$_REQUEST[id]'");
	//Date diffeerent in two dates
	$days = $res_vac["no_days"];
	$centre_id = $res_vac["centre_id"];
	$start = $res_vac[frm];
	$end = $res_vac[tto];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","centre_id='$centre_id'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","centre_id='$centre_id'");
	$tto = $res_e["MAX(end_date)"];
	$dbf->updateSchedLeaves("Exam",$_REQUEST[id],$_POST[startdate],$_POST[enddate],"");
	header("Location:vacation_exam_manage.php");
}
if($_REQUEST['action']=='delete')
{
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("exam_vacation","*","id='$_REQUEST[id]'");
	//Date diffeerent in two dates
	$days = $res_vac["no_days"];
	$centre_id = $res_vac["centre_id"];
	$start = $res_vac[frm];
	$end = $res_vac[tto];
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","centre_id='$centre_id'");
	$frm = $res_s["MIN(start_date)"];
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","centre_id='$centre_id'");
	$tto = $res_e["MAX(end_date)"];
	$dbf->deleteSchedLeaves("Exam",$_REQUEST[id]);
	$dbf->deleteFromTable("exam_vacation","id='$_REQUEST[id]'");
	header("Location:vacation_exam_manage.php");
}
?>
