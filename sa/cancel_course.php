<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
?>
<style>
.mystyles{border:1px solid #999;font-size:14px;color:#000;background:#ECF1FF;padding:2px;}
.styled-select{width:230px;height:34px;overflow:hidden;background:url(../images/down_arrow_select.jpg) no-repeat right #ddd;}
.styled-select select{background:transparent;width:230px;padding:2px;border:1px solid #ccc;font-size:16px;height:30px;-webkit-appearance:none;}
</style>
<?php if($_SESSION[lang]=="EN"){?>
<select name="course_id" id="course_id" class="mystyles" onchange="show_student();">
<?php
foreach($dbf->fetchOrder('student_enroll',"student_id='$_REQUEST[student_id]' And level_complete='0'","") as $ress2) {
	$course = $dbf->strRecordID("course","*","id='$ress2[course_id]'");
?>
<option value="<?php echo $course["id"];?>"><?php echo $course["name"];?></option>
<?php } ?>
</select>
<?php } else{?>
<select name="course_id" id="course_id" class="mystyles" onchange="show_student();">
<?php
foreach($dbf->fetchOrder('student_enroll',"student_id='$_REQUEST[student_id]' And level_complete='0'","") as $ress2) {
	$course = $dbf->strRecordID("course","*","id='$ress2[course_id]'");
?>
<option value="<?php echo $course["id"];?>"><?php echo $course["name"];?></option>
<?php } ?>
</select>
<?php }?>