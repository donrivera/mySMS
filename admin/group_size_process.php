<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST[action]=="insert"){
	//Check duplicate
	$nums = $dbf->countRows('group_size',"size_from<='$_REQUEST[size_to]' And size_to >='$_REQUEST[size_from]'");
	
	if($nums > 0){
		header("Location:group_size_add.php?msg=dup");
		exit;
	}else{
		$total_size = abs($_REQUEST[size_to] - $_REQUEST[size_from]);
		
		$string="group_id='$_REQUEST[group]',size_from='$_REQUEST[size_from]',size_to='$_REQUEST[size_to]',total_size='$total_size',units='$_REQUEST[units]',effect_units='$_REQUEST[units]'";
		$dbf->insertSet("group_size",$string);
		
		//Loop for All Centre
		foreach($dbf->fetchOrder('centre',"","name") as $centre){
			
			$string="group_id='$_REQUEST[group]',size_from='$_REQUEST[size_from]',size_to='$_REQUEST[size_to]',total_size='$total_size',units='$_REQUEST[units]',centre_id='$centre[id]'";
			$dbf->insertSet("centre_group_size",$string);
			
		}
		//End Loop
		
		header("Location:group_size_manage.php");
		exit;
	}	
	
}

if($_REQUEST[action]=="edit"){
	
	$string="units='$_REQUEST[units]'";
	$dbf->updateTable("group_size",$string,"group_id='$_REQUEST[ids]'");
		
	//Check duplicate
	$nums = $dbf->countRows('group_size',"size_from<='$_REQUEST[size_to]' And size_to >='$_REQUEST[size_from]'");
	
	if($nums > 0){
		header("Location:group_size_edit.php?ids=$_REQUEST[ids]&msg=dup");
		exit;
	}else{
		
		//Check duplicate
		$num_group = $dbf->countRows('group_size',"group_id='$_REQUEST[ids]'");
		if($num_group == 0){
			
			$string="group_id='$_REQUEST[ids]',size_from='$_REQUEST[size_from]',size_to='$_REQUEST[size_to]',units='$_REQUEST[units]'";
			$dbf->insertSet("group_size",$string);
		}else{
			
			$string="size_from='$_REQUEST[size_from]',size_to='$_REQUEST[size_to]',units='$_REQUEST[units]'";
			$dbf->updateTable("group_size",$string,"group_id='$_REQUEST[ids]'");
		}
		
		//Loop for All Centre
		foreach($dbf->fetchOrder('centre',"","name") as $centre){
			
			$string="group_id='$_REQUEST[group]',size_from='$_REQUEST[size_from]',size_to='$_REQUEST[size_to]',total_size='$total_size',units='$_REQUEST[units]'";
			$dbf->updateTable("centre_group_size",$string,"group_id='$_REQUEST[ids]' And centre_id='$centre[id]'");			
		}
		//End Loop
		
		header("Location:group_size_manage.php");
		exit;
	}	
}

if($_REQUEST[action]=="del"){
	
	$dbf->deleteFromTable("group_size","group_id='$_REQUEST[ids]'");
	$dbf->deleteFromTable("centre_group_size","group_id='$_REQUEST[ids]'");
	
	header("Location:group_size_manage.php");
	exit;
}
?>
