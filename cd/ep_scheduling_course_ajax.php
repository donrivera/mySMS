<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_SESSION[lang] == "EN"){ ?>

<select name="course" id="course" style="width:150px; border:solid 1px; border-color:#FFCC00;" onchange="show_student(),show_save();">
  <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
  <?php
	 foreach($dbf->fetchOrder('course c,group_list l,student_group g',"c.id=g.course_id AND g.centre_id='$_SESSION[centre_id]' AND c.id=l.course_id AND l.commonid='$_REQUEST[group]'","c.id","c.*") as $ress) {
	  ?>
  <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
  <?php }?>
</select>
<?php }else{?>
<select name="course" id="course" style="width:150px; border:solid 1px; border-color:#FFCC00;" onchange="show_student(),show_save();">
  <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
  <?php
	 foreach($dbf->fetchOrder('course c,group_list l,student_group g',"c.id=g.course_id AND g.centre_id='$_SESSION[centre_id]' AND c.id=l.course_id AND l.commonid='$_REQUEST[group]'","c.id","c.*") as $ress) {
	  ?>
  <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
  <?php }?>
</select>
<?php } ?>