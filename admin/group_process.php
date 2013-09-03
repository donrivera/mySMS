<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){

	//Check duplicate
	$num=$dbf->countRows('common',"type='group group' AND name='$_POST[name]'");
	if($num==0){
		
		$string="type='group group',name='$_POST[name]'";
		$ids = $dbf->insertSet("common",$string);
		
		$count = $_POST[count];
		for($i=1; $i<=$count; $i++){
			$c = "code".$i;
			$c = $_REQUEST[$c];
			
			if($c != ''){
				
				$cr_date = date('Y-m-d H:i:s A');
				
				$string="commonid='$ids',course_id='$c',created_datetime='$cr_date',created_by='$_SESSION[id]'";
				$dbf->insertSet("group_list",$string);
			}
		}		
		header("Location:group_manage.php");
	}else{
		header("Location:group_add.php?msg=exist");		
	}
}


if($_REQUEST['action']=='edit'){

	$string="name='$_POST[name]'";
	$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");
	
	$dbf->deleteFromTable("group_list","commonid='$_REQUEST[id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		
		$c = "code".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			$cr_date = date('Y-m-d H:i:s A');
			
			$string="commonid='$_REQUEST[id]',course_id='$c',created_datetime='$cr_date',created_by='$_SESSION[id]'";
			$dbf->insertSet("group_list",$string);
		}
	}	
	
	header("Location:group_manage.php");
	exit;
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("common","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("group_list","commonid='$_REQUEST[id]'");
	$dbf->deleteFromTable("group_size","group_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("centre_group_size","group_id='$_REQUEST[id]'");
	
	header("Location:group_manage.php");
	exit;
}
?>
