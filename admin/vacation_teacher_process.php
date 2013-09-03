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
	
	$teacher_id = $_REQUEST[center];
	
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
		
	//Current date and Time
	$cr_date = date('Y-m-d H:i:s A');	
	
	$string="teacher_id='$teacher_id',frm='$_POST[startdate]',tto='$_POST[enddate]',type='$_POST[type]',no_days='$days',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	$id = $dbf->insertSet("teacher_vacation",$string);
		
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","teacher_id='$teacher_id'");
	$frm = $res_s["MIN(start_date)"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","teacher_id='$teacher_id'");
	$tto = $res_e["MAX(end_date)"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
		
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){
						
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;
						
			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
				$gend = $valgroup[end_date];
				
				$leave_start = $_POST[startdate];			
				
				$no_days = $dbf->dateDiff($start,$end)+1;
				
				if($counter == 1){	
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
				
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					$string="start_date='$sdt',end_date='$edt'";
					$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					
					$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					//================================================================================
				}else{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+1 day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						
						$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					}
					//================================================================================
				}				
				$counter++;	
			}			
		}else{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto){
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"teacher_id='$teacher_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						
						$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					}
					//================================================================================										
					$counter++;	
				}				
			}

			if($start >= $frm && $start <= $tto){
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
							
							$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
						}
						//================================================================================
					}else{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
							
							$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
						}
						//================================================================================						
					}
					$counter++;	
				}				
			}			
		}		
	}
	//=================================================================================================	
	
	
	//Start Sending SMS if student is going RE-ENROLLMENT
	$mobile_no = '';
	foreach($dbf->fetchOrder('teacher_centre',"teacher_id='$_REQUEST[teacher_id]'","") as $tv){
		foreach($dbf->fetchOrder('user',"(user_type='Center Director' OR user_type='Student Advisor') And center_id='$tv[centre_id]'","") as $cd_sa){
			if($cd_sa["mobile"]){
				if($mobile_no == ''){
					$mobile_no = $cd["mobile"];
				}else{
					$mobile_no = $mobile_no.','.$cd["mobile"];
				}
			}
		}		
	}
	
	if($mobile_no){
		
		$is_enable = $dbf->countRows("sms_gateway","status='Enable'");
		$teacherdtls = $dbf->countRows("teacher","id='$teacher_id'");
		if($is_enable > 0){
			$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
			// Your username
			$UserName=UrlEncoding($sms_gateway[user]);
			
			// Your password
			$UserPassword=UrlEncoding($sms_gateway[password]);
			
			// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
			//$Numbers=UrlEncoding("966000000000,966111111111");
			$Numbers=UrlEncoding($mobile_no);
			
			// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
			$Originator=UrlEncoding($sms_gateway[your_name]);
			
			// Your Message in English or arabic or both.
			// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
			//$msg = $teacherdtls["name"]." will be vacation from ".$_REQUEST["startdate"]." to ".$_REQUEST["enddate"];
			$sms = $_REQUEST['sms'];
			
			if($sms == "1" || $sms == "3"){
				if($sms == "1"){
					$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='24'");
				}else if($sms == "3"){
					$sms_cont = $_REQUEST['contents'];
				}
				$sms_cont = str_replace('%teacher%',$teacherdtls["name"],$sms_cont);
				$sms_cont = str_replace('%startdate%',$_REQUEST["startdate"],$sms_cont);
				$msg = str_replace('%enddate%',$_REQUEST["enddate"],$sms_cont);
				
				$Message=$msg;
				
				// Storing Sending result in a Variable.
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);					
				//================================
				//SAVED SMS
				//================================
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD And SA',mobile='$mobile_no',msg_from='For Teacher Vacation',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("sms_history",$string);
				//================================
				//SAVED SMS
				//================================
			}
		}
	}//End
	
	
	header("Location:vacation_teacher_manage.php");
	
}


if($_REQUEST['action']=='edit'){
	 
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
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
		
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){	
				
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $start;

				if($counter == 1){
					$no_days = $dbf->dateDiff($start,$end)+1;
										
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					$string="start_date='$sdt',end_date='$edt'";
					$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					//================================================================================
				}else{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}				
				$counter++;	
			}
		}else{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto){				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"teacher_id='$teacher_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================										
					$counter++;	
				}				
			}

			if($start >= $frm && $start <= $tto){				
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}else{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================						
					}					
					$counter++;	
				}
			}			
		}		
	}
		
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
		
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","teacher_id='$teacher_id'");
	$frm = $res_s["MIN(start_date)"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","teacher_id='$teacher_id'");
	$tto = $res_e["MAX(end_date)"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){
			
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;
						
			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
				$gend = $valgroup[end_date];
				
				$leave_start = $_POST[startdate];			
				
				$no_days = $dbf->dateDiff($start,$end)+1;
				
				if($counter == 1){	
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
				
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					$string="start_date='$sdt',end_date='$edt'";
					$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					
					$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					//================================================================================
				}else{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+1 day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						
						$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					}
					//================================================================================
				}				
				$counter++;	
			}			
		}else{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto){
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"teacher_id='$teacher_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;
						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						
						$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
					}
					//================================================================================										
					$counter++;	
				}				
			}

			if($start >= $frm && $start <= $tto){
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
							
							$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
						}
						//================================================================================
					}else{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
							
							$dbf->updateTable("teacher_vacation","group_affect='1'","id='$id'");
						}
						//================================================================================						
					}
					$counter++;	
				}				
			}			
		}		
	}
		
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="frm='$_POST[startdate]',tto='$_POST[enddate]',type='$_POST[type]',no_days='$days',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("teacher_vacation",$string,"id='$_REQUEST[id]'");
	
	header("Location:vacation_teacher_manage.php");
	
}

if($_REQUEST['action']=='delete'){
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
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto)){

		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto)){			
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $start;

				if($counter == 1){
					$no_days = $dbf->dateDiff($start,$end)+1;
										
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					$string="start_date='$sdt',end_date='$edt'";echo '<br>';
					$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					//================================================================================
				}else{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}				
				$counter++;	
			}
		}else{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto){				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"teacher_id='$teacher_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0){
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================										
					$counter++;	
				}				
			}

			if($start >= $frm && $start <= $tto){
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' And id>='$group_id'","id") as $valgroup){
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1){
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}else{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0){
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================						
					}					
					$counter++;	
				}
			}			
		}		
	}

	$dbf->deleteFromTable("teacher_vacation","id='$_REQUEST[id]'");
	header("Location:vacation_teacher_manage.php");
}
?>