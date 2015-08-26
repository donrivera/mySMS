<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	//$cr_date = date('Y-m-d H:i:s A');
	//Check duplicate
	$num=$dbf->countRows('discount',"code='$_POST[code]' AND centre='$_POST[centre]'");
	//echo var_dump($_POST);
	if($num==0){
		//$cr_date = date('Y-m-d H:i:s A');
		$percent = $_POST['percent'] / 100;
		$string="centre='$_POST[centre]',code='$_POST[code]',name='$_POST[desc]',percent='$percent'";
		$dbf->insertSet("discount",$string);
		header("Location:discount_manage.php");
	}else{
		header("Location:discount_manage_add.php?msg=exist");		
	}
	
}

if($_REQUEST['action']=='edit'){
	
	$cr_date = date('Y-m-d H:i:s A');	
	$percent = $_POST['percent'] / 100;
	$string="centre='$_POST[centre]',code='$_POST[code]',name='$_POST[desc]',percent='$percent'";
	$dbf->updateTable("discount",$string,"id='$_REQUEST[id]'");	
	header("Location:discount_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("corporate","id='$_REQUEST[id]'");
	header("Location:corp_acct_manage.php");
}
?>
