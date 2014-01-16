<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");
//Object initialization
$dbf = new User();
$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
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
		$query=$dbf->genericQuery("	SELECT s.student_mobile as mobile
									FROM student_group sg
									INNER JOIN student_group_dtls sgd ON sgd.parent_id = sg.id
									LEFT JOIN (	SELECT student_mobile,id 
									            FROM student
												WHERE sms_status='1'
											   ) s ON s.id = sgd.student_id
									WHERE sg.group_name='$_POST[name]'");
		#SEND SMS#
		/*
		$UserName=UrlEncoding($sms_gateway['user']);
		$UserPassword=UrlEncoding($sms_gateway['password']);
		$Originator=UrlEncoding($sms_gateway['your_name']);
		$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='41'");
		foreach($query as $s):
			//$search = array('%startdate%', '%enddate%', '%teacher%');
			//$replace = array($start,$end,$teacher);
			//$msg=str_replace($search, $replace, $sms_cont);  
			$Numbers=UrlEncoding($s['mobile']);
			$Message=$sms_cont;
			SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			$cr_date = date('Y-m-d H:i:s A');
			$string="dated='$cr_date',user_id='0',msg='$msg',send_to='Teacher',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='Sick Leave',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
			$dbf->insertSet("sms_history",$string);
		endforeach;
		*/
		#SEND SMS#
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
