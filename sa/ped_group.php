<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
?>
<select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
  <option value="">Select Group</option>
  <?php
  if($_REQUEST["status"] != ""){ $cond = " And status='$_REQUEST[status]'";}else{ $cond = ""; }
  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' ".$cond,"group_name","") as $res_group) {
  ?>
  <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $dbf->printClassTImeFormat($res_group["group_start_time"],$res_group["group_end_time"]);?></option>
  <?php
  }
  ?>
</select>