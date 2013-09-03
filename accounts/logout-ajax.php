<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

include 'application_top.php';

//Object initialization
$dbf = new User();

//Set the Logout Time in Logn_info Table
if($_SESSION['id']){
	
	//Update for Offline
	$dbf->updateTable("user","is_online=0","id='$_SESSION[id]'");
	
	/*function getMyTimeDiff($t1,$t2)
	{
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
		$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
		$diff = abs($time1-$time2);
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		$secs = floor(($diff-(($hours*60*60)+($mins*60))));
		
		if(strlen($hours)<2){$hours="0".$hours;}
		if(strlen($mins)<2){$mins="0".$mins;}
		if(strlen($secs)<2){$secs="0".$secs;}
		
		$result = $hours.":".$mins.":".$secs;
		return $result;
	}
	
	//========= MAIN TABLE (login_info) =========
	//update out time
	$my_logout_time = date('h:i:s');
	$user->updateTable("login_info","out_time='$my_logout_time'","id='$_SESSION[my_login_id]'");
	
	$info = $user->strRecordID("login_info","*","id='$_SESSION[my_login_id]'");
	
	$intime = $info["in_time"];
	$outtime = $info["out_time"];
	
	//Calculate total time
	$tot = getMyTimeDiff($intime,$outtime);
	$user->updateTable("login_info","tot_time='$tot'","id='$_SESSION[my_login_id]'");
	
	//Set the Logout Time in Logn_info Table
	if($_SESSION['my_module_id']) {
		
		//update out time
		$my_logout_time = date('h:i:s');
		$user->updateTable("login_module_dtls","out_time='$my_logout_time'","id='$_SESSION[my_module_id]'");
		
		$info = $user->strRecordID("login_module_dtls","*","id='$_SESSION[my_module_id]'");
		
		$intime = $info["in_time"];
		$outtime = $info["out_time"];
		
		//Calculate total time
		$tot = $user->getTimeDiff($intime,$outtime);
		$user->updateTable("login_module_dtls","tot_time='$tot'","id='$_SESSION[my_module_id]'");
		
		//session destroy [my_module_id]
		unset($_SESSION['my_module_id']);
		session_unregister('my_module_id');
	}
	
	if($_SESSION['my_create_id']!='') {
		
		//update out time
		$my_logout_time = date('h:i:s');
		$user->updateTable("login_module","module_logout_time='$my_logout_time'","id='$_SESSION[my_create_id]'");
		
		$info = $user->strRecordID("login_module","*","id='$_SESSION[my_create_id]'");
		
		$intime = $info["module_login_time"];
		$outtime = $info["module_logout_time"];
		
		//Calculate total time
		$tot = $user->getTimeDiff($intime,$outtime);
		$user->updateTable("login_module","module_total_time='$tot'","id='$_SESSION[my_create_id]'");
		
		//session destroy [my_module_id]
		unset($_SESSION['my_create_id']);
		session_unregister('my_create_id');
	}*/
}
?>