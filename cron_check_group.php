<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
include("includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();


$today = date('Y-m-d');
$sql=$dbf->genericQuery("	SELECT DISTINCT(s.id) as id
							FROM student_group s 
							INNER JOIN student_group_dtls sgd ON sgd.parent_id=s.id 
							WHERE s.start_date='$today' AND s.status='Not Started'");
foreach($sql as $group)
{
	#echo $group["id"]."<BR/>";
	$string_g="status='Continue'";
	$dbf->updateTable("student_group",$string_g,"id='$group[id]'");
}	
?>