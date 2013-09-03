<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
if($_SESSION[lang] == "EN"){ ?>
<select name="course" class="validate[required]" id="course" style="width:102px; border:solid 1px; border-color:#FFCC00;" onchange="show_student();">
  <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
  <?php
	 foreach($dbf->fetchOrder('course c,group_list l',"c.id=l.course_id AND l.commonid='$_REQUEST[group]'","c.id","c.*") as $ress) {
	  ?>
  <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
  <?php }?>
</select>
<?php }else{?>
<select name="course" class="validate[required]" id="course" style="width:102px; border:solid 1px; border-color:#FFCC00;" onchange="show_student();">
  <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
  <?php
	 foreach($dbf->fetchOrder('course c,group_list l',"c.id=l.course_id AND l.commonid='$_REQUEST[group]'","c.id","c.*") as $ress) {
	  ?>
  <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
  <?php }?>
</select>
<?php }?>