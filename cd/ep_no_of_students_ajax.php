<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

//Get group details
$res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");

//Get group type
$res_t = $dbf->strRecordID("common","*","id='$res_g[group_id]'");

//Get course
$res_c = $dbf->strRecordID("course","*","id='$res_g[course_id]'");

//Get no of students schedule in admin panel
$res_s = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");

//get already enrolled with schedule students
$res_no = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$_REQUEST[group]'");

?>
<?php if($_SESSION["lang"]=="EN"){?>
<table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr>
      <td width="21%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
      <td width="21%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_MENU_COURSE");?></td>
      <td width="39%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_SCHEDULESTUDENTS");?>:</td>
      <?php
      if($res_s["size_to"] == '0'){
		  $too = $res_s["size_from"].'+';
	  }else{
		  $too = $res_s["size_from"]."-".$res_s["size_to"];
	  }
	  ?>
      <td width="19%" height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo $too;?></td>
      </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php echo $res_t[name];?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php echo $res_c[name];?></td>
      <td align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_ENROLLEDSTUDENTS");?> :</td>
      <td height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo $res_no["COUNT(student_id)"];?></td>
      </tr>
</table>
<?php }else{?>
<table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr>
      <?php
      if($res_s["size_to"] == '0')
	  {
		  $too = $res_s["size_from"].'+';
	  }
	  else
	  {
		  $too = $res_s["size_from"]."-".$res_s["size_to"];
	  }
	  ?>
      <td width="19%" height="25" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo $too;?></td>
      <td width="39%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"> : <?php echo constant("CD_EP_ADDING_STUDENT_SCHEDULESTUDENTS");?></td>
      <td width="21%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_MENU_COURSE");?></td>
      <td width="21%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
</tr>
    <tr>
      <td height="25" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo $res_no["COUNT(student_id)"];?></td>
      <td align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"> : <?php echo constant("CD_EP_ADDING_STUDENT_ENROLLEDSTUDENTS");?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php echo $res_c[name];?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php echo $res_t[name];?></td>
   </tr>
</table>
<?php }?>