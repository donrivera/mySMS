<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){

	//Check duplicate
	$num=$dbf->countRows('common',"type='Type' AND name='$_POST[material_name]'");
	if($num==0){
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="type='Type',name='$_POST[material_name]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("common",$string);
		
		header("Location:type_manage.php");
	}else{
		header("Location:type_add.php?msg=exist");		
	}
}

if($_REQUEST['action']=='edit'){
	
	$cr_date = date('Y-m-d H:i:s A');	
	$string="name='$_POST[material_name]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	
	$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");	
	header("Location:type_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("common","id='$_REQUEST[id]'");
	header("Location:type_manage.php");
}
?>
