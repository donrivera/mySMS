<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
?>
<select name="group" id="group" class="validate[required]" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;" onchange="getteacher();">
      <option value=""> Select Group</option>
      <?php
	  if($_REQUEST["status"] != ""){ $cond = " And status='$_REQUEST[status]'";}else{ $cond = " And status<>'Completed'"; }
	  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"") as $res) {
  	?>
      <option value="<?php echo $res['id'];?>"><?php echo $res['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res['start_date']));?> - <?php echo date('d/m/Y',strtotime($res['end_date'])) ?>, <?php echo $res["group_time"];?>-<?php echo $dbf->GetGroupTime($res["id"]);?></option>
      <?php }?>
      </select>