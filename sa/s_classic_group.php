<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$select_first_value = constant("SELECT_GROUP");
$interest_course = $_REQUEST["course_id"];

if($_SESSION['lang']=='EN'){?>
<select name="group" class="combo" id="group" style="width:370px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onBlur="checkTab('group');">
    <option value=""><?php echo $select_first_value;?></option>
    <?php
    foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And course_id in (".$interest_course.")","") as $res_g) {
    ?>
    <option value="<?php echo $res_g['id']?>"><?php echo $res_g['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_g['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_g['end_date'])) ?>,  <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></option>
    </option>
    <?php }?>
</select>
<?php } else{?>

<?php }?>