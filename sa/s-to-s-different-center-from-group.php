<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
$centre_from = $_REQUEST["centre_from"];
?>
<?php if($_SESSION[lang]=="EN"){?>
<select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('first'),show_student('first');">
    <option value="">--<?php echo constant("SELECT");?>--</option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"status<>'Completed' And centre_id='$centre_from'","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc["group_name"];?></option>
    <?php
    	}
    ?>
</select>
<?php } else{?>
<select name="from_id" id="from_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_group_dtls1('first'),show_student('first');">
    <option value="">--<?php echo constant("SELECT");?>--</option>
    <?php
    	foreach($dbf->fetchOrder('student_group',"status<>'Completed' And centre_id='$centre_from'","group_name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc["group_name"];?></option>
    <?php
    	}
    ?>
</select>
<?php }?>