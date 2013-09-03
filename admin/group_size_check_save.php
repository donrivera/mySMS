<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

foreach($dbf->fetchOrder('group_size',"size_to>='$_REQUEST[frm]' and size_from<='$_REQUEST[frm]'","id") as $val) {
	if($val["id"] > 0)
	{
		echo '1';
		exit;
	}	
}

foreach($dbf->fetchOrder('group_size',"size_to>='$_REQUEST[tto]' and size_to<='$_REQUEST[tto]'","id") as $val1) {
	if($val1["id"] > 0)
	{
		echo '1';
		break;
	}	
}
?>