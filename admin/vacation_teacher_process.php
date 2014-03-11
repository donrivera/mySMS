<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

//Admin
$res_user = $dbf->strRecordID("user","*","id='$_SESSION[id]'");

if($_REQUEST['action']=='insert')
{
	#echo var_dump($_POST);
	$teacher_id = $_REQUEST[teacher];
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
	//Current date and Time
	$cr_date = date('Y-m-d H:i:s A');	
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
		//Start Sending SMS 
		$sms_mobile=$dbf->genericQuery("	SELECT u.mobile
											FROM user u
											INNER JOIN teacher_centre t ON t.centre_id = u.center_id
											WHERE t.teacher_id =  '$teacher_id'
											AND (u.user_type =  'Center Director' || u.user_type='Student Advisor')
										");
		$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
		$teacher_name=$dbf->getDataFromTable("teacher","name","id='$teacher_id'");;
		if($is_enable > 0)
		{
			$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
			$UserName=UrlEncoding($sms_gateway['user']);
			$UserPassword=UrlEncoding($sms_gateway['password']);
			$Originator=UrlEncoding($sms_gateway['your_name']);
			$sms = $_REQUEST['sms'];
			switch($sms)
			{
				case '3':	{$msg = $_REQUEST['contents'];}break;
				default:	{
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='24'");
								$search = array('%teacher%','%startdate%','%enddate%');
								$replace = array($teacher_name,$start,$end);
								$msg=str_replace($search, $replace, $sms_cont); 
							}break;
			}
			$Message=$msg;
			foreach($sms_mobile as $m):
				$Numbers=UrlEncoding($m['mobile']);
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
				$string="dated='$cr_date',user_id='0',msg='$Message',send_to='CD And SA',mobile='$Numbers',msg_from='For Teacher Vacation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("sms_history",$string);
			endforeach;
		}
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