<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
$teacher_id = $_SESSION[uid];
?>	
<select name="group_id" id="group_id" onChange="show_student();" style="border:1px solid #999;font-size:14px;color:#000;background:#ECF1FF;padding:2px; width:192px;">
<option value="">Select Group</option>
<?php
if($_REQUEST["status"] == ""){
	$status = "";
}else{
	$status = " And status='$_REQUEST[status]'";
}
foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'".$status,"","") as $res_group) {
?>
<option value="<?php echo $res_group['id'];?>" <?php if($res_arf[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'];?></option>
<?php
}
?>
</select>