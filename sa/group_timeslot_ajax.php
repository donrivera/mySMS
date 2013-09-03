<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
if($_SESSION[lang] == "EN"){ ?>

<select name="time_slot" id="time_slot" style="width:250px; border:solid 1px; border-color:#FFCC00;">
  <?php
	foreach($dbf->fetchOrder('time_slot',"teacher_id='$_REQUEST[teacher]'","") as $resu) {
	
	//Generate strings
	if($resu[dt] != "0000-00-00")
	{
		$dt = "Starting from ".date("l",strtotime($resu[dt]))." - ".date("d/m/Y",strtotime($resu[dt]));
		$dt = $dt." - ".$resu[stime]." - ".$resu[etime];
	}
  ?>
  <option value="<?php echo $resu['id']?>"> <?php echo $dt;?></option>
  <?php }?>
</select>

<?php } else{?>
<select name="time_slot" id="time_slot" style="width:250px; border:solid 1px; border-color:#FFCC00;">
  <?php
	foreach($dbf->fetchOrder('time_slot',"teacher_id='$_REQUEST[teacher]'","") as $resu) {
	
	//Generate strings
	if($resu[dt] != "0000-00-00")
	{
		$dt = "Starting from ".date("l",strtotime($resu[dt]))." - ".date("d/m/Y",strtotime($resu[dt]));
		$dt = $dt." - ".$resu[stime]." - ".$resu[etime];
	}
  ?>
  <option value="<?php echo $resu['id']?>"> <?php echo $dt;?></option>
  <?php }?>
</select>
<?php }?>