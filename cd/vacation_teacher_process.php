<?php 
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();


//=================================================================
//Query string
$string = "status='$_POST[status]'";

//Excute query
$dbf->updateTable("teacher_vacation",$string,"id='$_REQUEST[id]'");

//=================================================================
//Check Approved or Rejected
//If Approved then Do the Re-scheduled here
if($_REQUEST[status]=='1')
{
	
	//Get Teacher id from teacher vacation
	$res_teacher = $dbf->strRecordID("teacher_vacation","*","id='$_REQUEST[id]'");
	
	$teacher_id = $res_teacher[teacher_id];
	
	//=============================================================================================
	//Insert in Vacation Details
	foreach($dbf->fetchOrder('teacher_vacation',"teacher_id='$teacher_id'","id","","") as $val_t)
	{				
		//No of Days of a particular Leave Approved
		$dt = $val_t["no_days"];
		
		for($j = 1; $j <= $no; $j++)
		{
			//Insert query string
			$string="dated='$dt',teacher_id='$teacher_id',centre_id='$_SESSION[centre_id]',type='Teacher'";
			
			//Query excute
			$dbf->insertSet("vacation_dtls",$string);
			
			//Generate Date
			$dt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($dt)) . "+1 day"));
		}		
	}
	//===============================================================================================
	
	//Update in Student Group Table
	foreach($dbf->fetchOrder('teacher_vacation_dtls',"teacher_id='$teacher_id'","","order_sl","order_sl") as $val_t)
	{		
		//Get Minimum date of the Group / Course
		$res_s = $dbf->strRecordID("teacher_vacation_dtls","MIN(dated)","order_sl='$val_t[order_sl]'");
		$start = $res_s["MIN(dated)"];
		
		//Get Maximum date of the Group / Course
		$res_e = $dbf->strRecordID("teacher_vacation_dtls","MAX(dated)","order_sl='$val_t[order_sl]'");
		$end = $res_e["MAX(dated)"];
		
		$string="start_date='$start',end_date='$end'";
		$dbf->updateTable("student_group",$string,"id='$val_t[order_sl]'");
		
	}
	//=================================================================================================	
	
}

	
//Sending to Header
?>
<script type="text/javascript">
	self.parent.location.href='vacation_teacher_manage.php';
	self.parent.tb_remove();
</script>