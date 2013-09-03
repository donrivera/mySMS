<?php
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

$write_text = strtolower($_GET["q"]);
$ctr_id = $_REQUEST['centre_id'];

if (!$write_text) return;
foreach($dbf->fetchOrder('student',"(family_name LIKE '%$write_text%' OR family_name1 LIKE '%$write_text%' OR first_name LIKE '$write_text%' OR student_first_name LIKE '$write_text%' OR student_id LIKE '$write_text%' OR student_mobile LIKE '$write_text' OR student_id LIKE '%$write_text%' OR student_mobile LIKE '%$write_text%') And centre_id='$ctr_id'","first_name limit 10") as $top_stu_list){
	$str_top_stu_list = $top_stu_list["first_name"];
	echo $str_top_stu_list.$Arabic->en2ar($dbf->StudentName($top_stu_list["id"]))."\n";
}
?>