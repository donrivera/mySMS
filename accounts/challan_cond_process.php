<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['type']=='challan')
{

	$string="name='$_POST[name]'";
	$dbf->updateTable("conditions",$string,"type='Challan'");
	
	header("Location:challan_cond.php?msg=added");
}
if($_REQUEST['type']=='invoice')
{

	$string="name='$_POST[name]'";
	$dbf->updateTable("conditions",$string,"type='Invoice'");
	
	header("Location:invoice_cond.php?msg=added");
}
?>
