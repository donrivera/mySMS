<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';
$dbf = new User();

//$teacher_name = $dbf->strRecordID("user", "*", "id='$_REQUEST[staff_id]'");
$sql=$dbf->genericQuery("	SELECT s.student_mobile as mobile
							FROM student s
							INNER JOIN student_group_dtls sgd ON sgd.student_id=s.id
							WHERE sgd.parent_id='$_REQUEST[group_id]'");
foreach($sql as $q):
	$contacts[]=$q['mobile'];
endforeach;
$group=implode(', ',$contacts);
?>
<?php if($_SESSION[lang]=="EN"){?>
<input name="number" type="text" class="validate[required] new_textbox190" id="number" value="<?=$group?>" />
<?php } else{?>
<input name="number" type="text" class="validate[required] new_textbox190_ar" id="number" value="<?=$group?>" />
<?php }?>