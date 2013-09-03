<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$array	= $_POST['arrayorder'];

if ($_POST['update'] == "update")
{	
	$count = 1;
	foreach ($array as $idval)
	{	
		$string="prec= $count ";
		$dbf->updateTable("quick_link",$string,"id='$idval'");
		$count ++;	
	}	
}
?>