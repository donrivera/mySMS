<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

if($_REQUEST[type]=="Teacher")
{
?>
<select name="teacher" id="teacher" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onchange="show_email1(),show_mobile1();">
  <option value="">--Select Teacher--</option>
  <?php
  foreach($dbf->fetchOrder('teacher',"id NOT IN (select uid from user where user_type='Teacher')","name") as $val) {
  ?>
  <option value="<?php echo $val["id"];?>"><?php echo $val["name"];?></option>
  <?php } ?>
</select>
<?php
} 
else if($_REQUEST[type]=="Student")
{
?>
<select name="student" id="student" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" class="validate[required]" onchange="show_email(),show_mobile();">
  <option value="">--Select Student--</option>
  <?php
  foreach($dbf->fetchOrder('student',"id NOT IN (select uid from user where user_type='Student')","first_name") as $val) {
  ?>
  <option value="<?php echo $val["id"];?>"><?php echo $val["first_name"];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
  <?php } ?>
</select>
<?php
}else{
?>
<input name="uname" type="text" class="validate[required] new_textbox190" id="uname" value="" size="45" minlength="4"/>
<?php
}
?>
