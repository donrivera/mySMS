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
<select name="centre_to" id="centre_to" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_to_group(),show_group_dtls1('second'),show_student('second'),show_save();">
    <option value="">--<?php echo constant("SELECT");?>--</option>
    <?php
    	foreach($dbf->fetchOrder('centre',"id<>'$centre_from'","name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc[name];?></option>
    <?php
    	}
    ?>
</select>
<?php } else{?>
<select name="centre_to" id="centre_to" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:140px;" onchange="show_to_group(),show_group_dtls1('second'),show_student('second'),show_save();">
    <option value="">--<?php echo constant("SELECT");?>--</option>
    <?php
    	foreach($dbf->fetchOrder('centre',"id<>'$centre_from'","name") as $valc) {	
    ?>
    <option value="<?php echo $valc[id];?>"><?php echo $valc[name];?></option>
    <?php
    	}
    ?>
</select>
<?php }?>