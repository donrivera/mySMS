<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');
?>	
<select name="student" id="student"  style="width:192px; height:25px; border:solid 1px; border-color:#999999;"><!--class="validate[required]"-->
<option value="">--Select Student--</option>
<?php
foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d',"m.id=d.parent_id And s.id=d.student_id And s.certificate_collect='0' And m.id='$_REQUEST[group_id]'","s.first_name","s.*") as $ress2) {
	
	
?>
<option value="<?php echo $ress2['id']?>">
	<?php echo $ress2[first_name]."&nbsp;".$ress2[father_name]."&nbsp;".$ress2[family_name]."&nbsp;(".$ress2[first_name1]."&nbsp;".$ress2[father_name1]."&nbsp;".$ress2[grandfather_name1]."&nbsp;".$ress2[family_name1].")";?>
</option>
<?php }?>
</select>