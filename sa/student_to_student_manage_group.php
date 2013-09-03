<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
$from_id = $_REQUEST["from_id"];
$group_dtls = $dbf->strRecordID("student_group","*","id='$from_id'");
$course_id = $group_dtls["course_id"];
 if($_SESSION['lang']=='EN'){?>
<select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('second'),show_student('second'),show_save();">
    <option value="">--<?php echo constant("SELECT");?>--</option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And id<>'$from_id' And course_id='$course_id'","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc[group_name];?></option>
    <?php
    	}
    ?>
</select>
<?php } else{?>
<select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('second'),show_student('second'),show_save();">
    <option value=""><?php echo constant("SELECT");?></option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And id<>'$from_id' And course_id='$course_id'","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc[group_name];?></option>
    <?php
    	}
    ?>
</select>
<?php }?>