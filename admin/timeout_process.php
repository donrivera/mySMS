<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$num=$dbf->countRows('conditions',"type='Logout Time'");

if($num==0)
{
	$string="name='$_POST[title]',type='Logout Time'";
	$dbf->insertSet("conditions",$string);
	
	header("Location:timeout_manage.php?msg=added");
}
else
{
	$string="name='$_POST[title]'";
	$dbf->updateTable("conditions",$string,"type='Logout Time'");
	
	header("Location:timeout_manage.php?msg=added");
}
?>
