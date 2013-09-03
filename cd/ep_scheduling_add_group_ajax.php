<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
?>
<select name="group" class="validate[required]" id="group" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_course(),show_student(),show_save(),show_no();">
<option value="">--Select Group--</option>
<?php
if($_REQUEST["status"] != ""){ $cond = " And status='$_REQUEST[status]'";}else{ $cond = " And status<>'Completed'"; }
foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","*") as $ress) {
?>
<option value="<?php echo $ress[id];?>"><?php echo $ress['group_name'] ?>, <?php echo date('d/m/Y',strtotime($ress['start_date']));?> - <?php echo $ress['end_date'] ?>, <?php echo $ress["group_time"];?>-<?php echo $dbf->GetGroupTime($ress["id"]);?></option>
<?php }?>
</select>