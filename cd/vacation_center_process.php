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
//$dbf->updateTable("centre_vacation",$string,"id='$_REQUEST[id]'");

//=================================================================

//Check Approved or Rejected
//If Approved then Do the Re-scheduled here
if($_REQUEST[status]=='1')
{
	//Get Centre details from Leave vacation
	$res_centre = $dbf->strRecordID("centre_vacation","*","id='$_REQUEST[id]'");
	
	//vacation start date
	echo $start = $res_centre["frm"];
	echo $end = $res_centre["tto"];
	exit;
	//This vacation dates are already approved or not
	$num=$dbf->countRows('vacation_dtls',"centre_id='$_SESSION[centre_id]' And (dated >= '$start' And dated <= '$end')");	
	exit;
	
	//Update in Student Group Table
	foreach($dbf->fetchOrder('teacher_vacation_dtls',"teacher_id='$teacher_id'","","order_sl","order_sl") as $val_t){		
		//Get Minimum date of the Group / Course
		$res_s = $dbf->strRecordID("teacher_vacation_dtls","MIN(dated)","order_sl='$val_t[order_sl]'");
		$start = $res_s["MIN(dated)"];
		
		//Get Maximum date of the Group / Course
		$res_e = $dbf->strRecordID("teacher_vacation_dtls","MAX(dated)","order_sl='$val_t[order_sl]'");
		$end = $res_e["MAX(dated)"];
		
		$string="start_date='$start',end_date='$end'";
		$dbf->updateTable("student_group",$string,"id='$val_t[order_sl]'");
		
	}
}

//Sending to Header
?>
<script type="text/javascript">
	self.parent.location.href='vacation_center_manage.php';
	self.parent.tb_remove();
</script>