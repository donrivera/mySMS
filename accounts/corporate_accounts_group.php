<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

?> 
<select name="code" id="code" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:150px;">
    <option value="">--Select--</option>
        <?php	foreach($dbf->fetchOrder('corporate',"centre_id='$_REQUEST[status]'","name") as $valc):	?>
                <option value="<?php echo $valc[code];?>" <?php if($valc["code"]==$_REQUEST["code"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
        <?php	endforeach;?>
</select>