<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{

	//Check duplicate
	$num=$dbf->countRows('common',"type='Unit No' AND name='$_POST[name]'");
	if($num==0)
	{
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="type='Unit No',name='$_POST[name]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("common",$string);
		
		header("Location:unit_manage.php");
	}	
	else
	{
		header("Location:unit_add.php?msg=exist");		
	}
}

if($_REQUEST['action']=='edit')
{
	//Check duplicate
	$num=$dbf->countRows('common',"type='Unit No' AND name='$_POST[name]'");
	if($num==0)
	{
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="name='$_POST[name]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
		$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");
		
		header("Location:unit_manage.php");
	}
	else
	{
		header("Location:unit_edit.php?id=$_REQUEST[id]&msg=exist");
	}	
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("common","id='$_REQUEST[id]'");
	header("Location:unit_manage.php");
}
?>
