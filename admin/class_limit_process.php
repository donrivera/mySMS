<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
/*
if($_REQUEST['action']=='insert')
{
	$cr_date = date('Y-m-d H:i:s A');
	//Check duplicate
	$num=$dbf->countRows('area',"code='$_POST[area_code]'");
	if($num==0)
	{
		$cr_date = date('Y-m-d H:i:s A');
		$string="code='$_POST[area_code]',name='$_POST[area_name]',date_added='$cr_date'";
		$dbf->insertSet("area",$string);
		header("Location:area_manage.php");
	}else{header("Location:area_manage_add.php?msg=exist");}
}
*/
if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');	
	$string="name='$_POST[name]'";
	$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");	
	header("Location:class_limit.php?msg=update");
}
/*
if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("area","id='$_REQUEST[id]'");
	header("Location:area_manage.php");
}
*/
?>