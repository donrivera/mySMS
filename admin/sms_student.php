<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';
include 'application_top.php';
include_once '../includes/language.php';

$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

$status_id = 0;
if($_REQUEST['opval']=="Enquiry"){
		$status_id = 1;
}else if($_REQUEST['opval']=="Potential"){
	$status_id = 2;
}else if($_REQUEST['opval']=="Waiting - Payment Pending"){
	$status_id = 3;
}else if($_REQUEST['opval']=="Waiting - Full Payment"){
	$status_id = 3;
}else if($_REQUEST['opval']=="Enrolled - Payment Pending"){
	$status_id = 4;
}else if($_REQUEST['opval']=="Enrolled - Full Payment"){
	$status_id = 4;
}else if($_REQUEST['opval']=="Active - Payment Pending"){
	$status_id = 5;
}else if($_REQUEST['opval']=="Active - Full Payment"){
	$status_id = 5;
}else if($_REQUEST['opval']=="On Hold - Payment Pending"){
	$status_id = 6;
}else if($_REQUEST['opval']=="On Hold - Full Payment"){
	$status_id = 6;
}else if($_REQUEST['opval']=="Cancelled - Payment Pending"){
	$status_id = 7;
}else if($_REQUEST['opval']=="Cancelled - Full Payment"){
	$status_id = 7;
}else if($_REQUEST['opval']=="Cancelled - Refunded"){
	$status_id = 7;
}else if($_REQUEST['opval']=="Completed - Payment Pending"){
	$status_id = 8;
}else if($_REQUEST['opval']=="Completed - Full Payment"){
	$status_id = 8;
}else if($_REQUEST['opval']=="Legally Critical"){
	$status_id = 9;
}
if($status_id > 0){
?>
<select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_student_mobile();">
    <option value="">-- <?php echo constant('ADMIN_VIEW_COMMENTS_MANAGE_OPTION');?> --</option>
    <?php
	foreach($dbf->fetchOrder('student s,student_moving m',"s.id=m.student_id And m.status_id='$status_id'","","m.student_id","m.student_id") as $move){
		
		if($_REQUEST['opval']=="Enquiry" || $_REQUEST['opval']=="Potential" || $_REQUEST['opval']=="Legally Critical" || $_REQUEST['opval']=="Cancelled - Refunded"){
			$res_student = $dbf->strRecordID("student", "*", "id='$move[student_id]'");
			if($res_student['first_name'] != ''){
			?>
            <option value="<?php echo $res_student['id'];?>"><?php echo $res_student['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></option>
            <?php
			}
		}else if($_REQUEST['opval']=="Waiting - Payment Pending" || $_REQUEST['opval']=="Enrolled - Payment Pending" || $_REQUEST['opval']=="Active - Payment Pending" || $_REQUEST['opval']=="On Hold - Payment Pending" || $_REQUEST['opval']=="Cancelled - Payment Pending" || $_REQUEST['opval']=="Completed - Payment Pending"){
			
			$balance = $dbf->GetStudentPaidAmount($move['student_id']);
			if($balance > 0){
				$res_student = $dbf->strRecordID("student","*","id='$move[student_id]' And sms_status='1'");
				if($res_student['first_name'] != ''){
				?>
                <option value="<?php echo $res_student['id'];?>"><?php echo $res_student['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></option>
                <?php
				}
			}
		}else{			
			$res_student = $dbf->strRecordID("student","*","id='$move[student_id]' And sms_status='1'");
			if($res_student['first_name'] != ''){
			?>
            <option value="<?php echo $res_student['id'];?>"><?php echo $res_student['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></option>
            <?php
			}
		}
	}
	?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="student"){?>
<select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" onChange="show_student_mobile();">
    <option value="">-- <?php echo constant('ADMIN_VIEW_COMMENTS_MANAGE_OPTION');?> --</option>
    <?php
	foreach($dbf->fetchOrder('student',"student_mobile<>'' And first_name <> ''","","","") as $move){
	?>
	<option value="<?php echo $move['id'];?>"><?php echo $move['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($move["id"]));?></option>
	<?php } ?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="group"){?>
<select name="group" id="group" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" >
    <option value="">-- <?php echo constant('SELECT_GROUP');?> --</option>
    <?php
	foreach($dbf->fetchOrder('student_group',"status='Not Started'","","","") as $res_group){
	?>
	<option value="<?php echo $res_group['id'];?>"><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
	<?php } ?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="groupcontinue"){?>
<select name="group" id="group" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" >
    <option value="">-- <?php echo constant('SELECT_GROUP');?> --</option>
    <?php
	foreach($dbf->fetchOrder('student_group',"status='Continue'","","","") as $res_group){
	?>
	<option value="<?php echo $res_group['id'];?>"><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
	<?php } ?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="groupfinish"){?>
<select name="group" id="group" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;" >
    <option value="">-- <?php echo constant('SELECT_GROUP');?> --</option>
    <?php
	foreach($dbf->fetchOrder('student_group',"status='Completed'","","","") as $res_group){
	?>
	<option value="<?php echo $res_group['id'];?>"><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
	<?php } ?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="teacher"){?>
<select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;"  onChange="show_teacher_mobile();">
    <option value="">-- <?php echo constant('ADMIN_REPORT_TEACHER_SCHEDULE_SELECTTEACHER');?> --</option>
    <?php
	foreach($dbf->fetchOrder('teacher',"mobile <> ''","","","") as $teacher_name){
	?>
	<option value="<?php echo $teacher_name['id'];?>"><?php echo $teacher_name['name'] ?></option>
	<?php } ?>
</select>
<?php } ?>
<?php if($_REQUEST['opval']=="staff"){?>
<select name="student_2" id="student_2" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; width:192px;"  onChange="show_staff_mobile();">
    <option value="">-- <?php echo constant('STAFF');?> --</option>
    <?php
	foreach($dbf->fetchOrder('user',"user_type <> 'Administrator' And user_type <> 'Teacher'","","","") as $staff){
	?>
	<option value="<?php echo $staff['id'];?>"><?php echo $staff['user_name'] ?></option>
	<?php } ?>
</select>
<?php } ?>