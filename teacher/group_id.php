<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
?>
<select name="group_id" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
    <option value="">Select Group</option>
    <?php
	if($_REQUEST["status"] == ""){
		$status = "";
	}else{
		$status = " And status='$_REQUEST[status]'";
	}
    foreach($dbf->fetchOrder('student_group',"teacher_id='$_SESSION[uid]'".$status,"","") as $res_group) {
      ?>
    <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
    <?php
    }
    ?>
</select>