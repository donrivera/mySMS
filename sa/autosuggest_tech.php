<?php
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

$write_text = trim($_GET["q"]);
$ctr_id = (empty($_REQUEST['centre_id'])?$_SESSION['centre_id']:$_REQUEST['centre_id']);

if (!$write_text) return;

foreach($dbf->fetchOrder('student',"(
										family_name LIKE '%$write_text%' 
										OR family_name1 LIKE '%$write_text%' 
										OR first_name LIKE '%$write_text%'
										OR first_name1 LIKE '%$write_text%'
										OR father_name LIKE '%$write_text%'
										OR father_name1 LIKE '%$write_text%'
										OR grandfather_name LIKE '%$write_text%'
										OR grandfather_name1 LIKE '%$write_text%'
										OR student_first_name LIKE '%$write_text%' 
										OR student_id LIKE '%$write_text%' 
										OR student_mobile LIKE '%$write_text%' 
										OR student_id LIKE '%$write_text%' 
										OR student_mobile LIKE '%$write_text%'
									) And centre_id='$ctr_id'"
									,	"first_name, 
										first_name1,
										father_name,
										father_name1,
										grandfather_name,
										grandfather_name1,
										family_name,
										family_name1
										limit 10") as $top_stu_list)
{
	$fname  = $top_stu_list["first_name"];
	$fname1 = $top_stu_list["first_name1"];
	$father_name = $top_stu_list["father_name"];
	$father_name1 = $top_stu_list["father_name1"];
	$grandfather_name = $top_stu_list["grandfather_name"];
	$grandfather_name1 = $top_stu_list["grandfather_name1"];
	$family_name = $top_stu_list["family_name"];
	$family_name1 = $top_stu_list["family_name1"];
	//echo $str_top_stu_list.$Arabic->en2ar($dbf->StudentName($top_stu_list["id"]))."\n";
	echo $fname." ".$father_name." ".$family_name." (".$first_name1." ".$father_name1." ".$grandfather_name1." ".$family_name1.")\n";
	//echo $fname."\n";
}
?>