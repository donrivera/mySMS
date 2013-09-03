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
	
	$string="centre_id='$_POST[center]',frm='$_POST[startdate]',tto='$_POST[enddate]',no_days='$days',type='$_POST[type]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	$dbf->insertSet("centre_vacation",$string);
		
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","centre_id='$_POST[center]'");
	$frm = $res_s["MIN(start_date)"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","centre_id='$_POST[center]'");
	$tto = $res_e["MAX(end_date)"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto))
	{
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto))
		{
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
			{
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $_POST[startdate];
				
				$x_count = 0;
				for($x = 1; $x <= $days; $x++)
				{
					//Check entry leave date is exist in the Previously Leave table
					$n=$dbf->countRows('vacation_dtls',"dated='$leave_start'");
					
					if($n > 0)
					{
						$x_count = $x_count + 1;
					}
					$leave_start = date('Y-m-d',strtotime(date("Y-m-d", strtotime($leave_start)) . "+1 day"));
				}
				
				if($counter == 1)
				{
					$no_days = $dbf->dateDiff($start,$end)+1;
					
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}
				else
				{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}			
				
				$counter++;	
			}
			
		}
		else
		{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto)
			{
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"centre_id='$_POST[center]' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;
						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
										
					$counter++;	
				}
				
			}

			if($start >= $frm && $start <= $tto)
			{
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}
					else
					{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
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

	header("Location:vacation_center_manage.php");
	
}

if($_REQUEST['action']=='edit')
{	
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("centre_vacation","*","id='$_REQUEST[id]'");
	
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
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto))
	{

		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto))
		{			
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
			{
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $start;
				
				$x_count = 0;
				for($x = 1; $x <= $days; $x++)
				{
					//Check entry leave date is exist in the Previously Leave table
					$n=$dbf->countRows('vacation_dtls',"dated='$leave_start'");
					
					if($n > 0)
					{
						$x_count = $x_count + 1;
					}
					$leave_start = date('Y-m-d',strtotime(date("Y-m-d", strtotime($leave_start)) . "+1 day"));
				}

				if($counter == 1)
				{
					$no_days = $dbf->dateDiff($start,$end)+1;
					
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}
				else
				{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}			
				
				$counter++;	
			}

		}
		else
		{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto)
			{				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"centre_id='$centre_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;
						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
										
					$counter++;	
				}
				
			}

			if($start >= $frm && $start <= $tto)
			{
				
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}
					else
					{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
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
	
	
	
	
	
	
	
	
	//Date diffeerent in two dates
	$days = $dbf->dateDiff($_POST[startdate], $_POST[enddate])+1;
		
	$start = $_POST[startdate];
	$end = $_POST[enddate];
	
	//Get Minimum date of the Group / Course
	$res_s = $dbf->strRecordID("student_group","MIN(start_date)","centre_id='$_POST[center]'");
	$frm = $res_s["MIN(start_date)"];
	
	//Get Maximum date of the Group / Course
	$res_e = $dbf->strRecordID("student_group","MAX(end_date)","centre_id='$_POST[center]'");
	$tto = $res_e["MAX(end_date)"];
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto))
	{
		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto))
		{
			
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
			{
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $_POST[startdate];
				
				$x_count = 0;
				for($x = 1; $x <= $days; $x++)
				{
					//Check entry leave date is exist in the Previously Leave table
					$n=$dbf->countRows('vacation_dtls',"dated='$leave_start'");
					
					if($n > 0)
					{
						$x_count = $x_count + 1;
					}
					$leave_start = date('Y-m-d',strtotime(date("Y-m-d", strtotime($leave_start)) . "+1 day"));
				}
				
				if($counter == 1)
				{
					$no_days = $dbf->dateDiff($start,$end)+1;
					
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}
				else
				{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}			
				
				$counter++;	
			}
			
		}
		else
		{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto)
			{
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"centre_id='$_POST[center]' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;
						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
										
					$counter++;	
				}
				
			}

			if($start >= $frm && $start <= $tto)
			{
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$_POST[center]' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$_POST[center]' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}
					else
					{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "+$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "+$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
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
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="frm='$_POST[startdate]',tto='$_POST[enddate]',type='$_POST[type]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("centre_vacation",$string,"id='$_REQUEST[id]'");
	
	header("Location:vacation_center_manage.php");
}

if($_REQUEST['action']=='delete')
{
	//Detail of centre vacation according to ID
	$res_vac = $dbf->strRecordID("centre_vacation","*","id='$_REQUEST[id]'");
	
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
	
	//Check entry end date is BETWEEN then (group Start and End date)
	if(($end >= $frm && $end <= $tto) || ($start >= $frm && $start <= $tto))
	{

		if(($end >= $frm && $end <= $tto) && ($start >= $frm && $start <= $tto))
		{			
			//Get Effect Group from student_group Table
			$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
			$group_id = $res_g["id"];
			
			$counter = 1;

			//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
			foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
			{
				$gstart = $valgroup[start_date];
				$gend = $valgroup[end_date];
				
				$leave_start = $start;
				
				$x_count = 0;
				for($x = 1; $x <= $days; $x++)
				{
					//Check entry leave date is exist in the Previously Leave table
					$n=$dbf->countRows('vacation_dtls',"dated='$leave_start'");
					
					if($n > 0)
					{
						$x_count = $x_count + 1;
					}
					$leave_start = date('Y-m-d',strtotime(date("Y-m-d", strtotime($leave_start)) . "+1 day"));
				}

				if($counter == 1)
				{
					$no_days = $dbf->dateDiff($start,$end)+1;
					
					//$no_days = (Current No of days - Previously leave days)
					$no_days = $no_days - $x_count;
					
					$sdt = $gstart;
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}
				else
				{
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
				}			
				
				$counter++;	
			}

		}
		else
		{
			
			//Condition := $end >= $frm && $end <= $tto
			//Date should be Between the Group start and End date
			//if Entry End date starting from start group
			if($end >= $frm && $end <= $tto)
			{				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						//Days Difference between Group start and Entry end Date
						$no_days = $dbf->dateDiff($gstart, $end)+1;
						
						//Get no of days of the Previous vacation
						$num_vac=$dbf->countRows('vacation_dtls',"centre_id='$centre_id' And (dated >= '$start' And dated <= '$end')");
						
						//Adding both days
						$no_days = $no_days + $num_vac;
						
					}
					$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
					$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
					$gstart = $edt;
					
					//Update statement Here
					//================================================================================
					if($no_days > 0)
					{
						$string="start_date='$sdt',end_date='$edt'";
						$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
					}
					//================================================================================
										
					$counter++;	
				}
				
			}

			if($start >= $frm && $start <= $tto)
			{
				
				
				//Get Effect Group from student_group Table
				$res_g = $dbf->strRecordID("student_group","*","centre_id='$centre_id' And (start_date <= '$end' And end_date >= '$start')");
				$group_id = $res_g["id"];
				
				$counter = 1;
	
				//Total loop for student_group Table from Effected Group (1-2-3-4 : [If 3 is match] loop from 3 to 4 )
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And id>='$group_id'","id") as $valgroup)
				{
					$gstart = $valgroup[start_date];
					$gend = $valgroup[end_date];
					
					if($counter == 1)
					{
						$no_days = $dbf->dateDiff($start,$gend)+1;
						
						$sdt = $gstart;
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
							$string="start_date='$sdt',end_date='$edt'";
							$dbf->updateTable("student_group",$string,"id='$valgroup[id]'");
						}
						//================================================================================
					}
					else
					{
						$sdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gstart)) . "-$no_days day"));
						$edt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($gend)) . "-$no_days day"));
						$gstart = $edt;
						
						//Update statement Here
						//================================================================================
						if($no_days > 0)
						{
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
	
	$dbf->deleteFromTable("centre_vacation","id='$_REQUEST[id]'");
	header("Location:vacation_center_manage.php");
}
?>
