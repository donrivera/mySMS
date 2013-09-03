<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$dbf->deleteFromTable("quick_links","module_name='LIS Manager' And user_id='$_SESSION[id]'");

for($i = 1; $i<=45; $i++)
{
	$ida = "id".$i;
	$ida = $_REQUEST[$ida];
	if($ida != '')
	{
		
		$link = explode("*",$ida);
		$link_name = $link[0];
		$links = $link[1];
		
		//Insert query here
		$string="link_name='$link_name',prec='$i',links='$links',module_name='LIS Manager',user_id='$_SESSION[id]',centre_id='$_SESSION[centre_id]'";
		$dbf->insertset("quick_links",$string);
	}
}

header("Location:quicklink_manage.php?msg=added");
exit;
?>
