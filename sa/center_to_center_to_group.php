<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$centre_to = $_REQUEST["centre_to"];
$from_id = $_REQUEST["from_id"];

$group = $dbf->strRecordID("student_group","*","id='$from_id'");
$course_id = $group["course_id"];
//echo "select * from student_group where centre_id='$centre_to' And course_id='$course_id'";

?>
<?php if($_SESSION[lang]=="EN"){?>
<select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="all_students('sec')"><!--show_student('sec');-->
    <option value=""><?php echo "--".constant("SELECT")."--";?></option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"centre_id='$centre_to'","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc["group_name"];?></option>
    <?php
    	}
    ?>
</select>
<?php } else{?>
<select name="to_id" id="to_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_student('sec');">
    <option value=""><?php echo "--".constant("SELECT")."--";?></option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"centre_id='$centre_to' ","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc["group_name"];?></option>
    <?php
    	}
    ?>
</select>
<?php }?>