<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){	
	
	$comments = mysql_real_escape_string($_REQUEST[comments]);
	
	$string="group_id='$_REQUEST[group]',centre_id='$_SESSION[centre_id]',cancel_date='$_POST[startdate]',cancel_by='$_SESSION[id]',comments='$comments'";
	$dbf->insertSet("class_cancel",$string);
		
	$start = $_POST[startdate];
	$end = $_POST[startdate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","start_date","id='$_REQUEST[group]'");
	$frm = $res_s["start_date"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","end_date","id='$_REQUEST[group]'");
	$tto = $res_e["end_date"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){
			
			$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($tto)) . "+1 day"));
			$string="end_date='$edt'";
			
			$dbf->updateTable("student_group",$string,"id='$_REQUEST[group]'");			
		}
	}
	
	header("Location:ep_class_cancel_manage.php");
	
}

if($_REQUEST['action']=='edit'){
	//Start Reverse 1 Days
	//==================
	
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("class_cancel","*","id='$_REQUEST[id]'");
		
	$group_id = $res_vac["group_id"];

	$start = $res_vac["cancel_date"];
	$end = $start;
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","start_date","id='$group_id'");
	$frm = $res_s["start_date"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","end_date","id='$group_id'");
	$tto = $res_e["end_date"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){

		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){			
			$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($tto)) . "-1 day"));
			$string="end_date='$edt'";
			
			$dbf->updateTable("student_group",$string,"id='$group_id'");
		}
				
	}
	//End Reverse 1 Day
	//==================
	
	//Start Add 1 Day
	//===============
	
	$comments = mysql_real_escape_string($_REQUEST[comments]);		
	$start = $_POST[startdate];
	$end = $_POST[startdate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","start_date","id='$_REQUEST[group]'");
	$frm = $res_s["start_date"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","end_date","id='$_REQUEST[group]'");
	$tto = $res_e["end_date"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){
			
			$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($tto)) . "+1 day"));
			$string="end_date='$edt'";
			
			$dbf->updateTable("student_group",$string,"id='$_REQUEST[group]'");			
		}
	}
	
	//End Add 1 Day
	//===============
	
	$string="group_id='$_REQUEST[group]',cancel_date='$_POST[startdate]',comments='$comments'";
	$dbf->updateTable("class_cancel",$string,"id='$_REQUEST[id]'");
	
	header("Location:ep_class_cancel_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("class_cancel","*","id='$_REQUEST[id]'");
		
	$group_id = $res_vac["group_id"];

	$start = $res_vac["cancel_date"];
	$end = $start;
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","start_date","id='$group_id'");
	$frm = $res_s["start_date"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","end_date","id='$group_id'");
	$tto = $res_e["end_date"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){

		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){			
			$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($tto)) . "-1 day"));
			$string="end_date='$edt'";
			
			$dbf->updateTable("student_group",$string,"id='$group_id'");
		}				
	}

	$dbf->deleteFromTable("class_cancel","id='$_REQUEST[id]'");
	header("Location:ep_class_cancel_manage.php");
}
?>
