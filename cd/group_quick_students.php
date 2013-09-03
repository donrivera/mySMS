<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
$course_id = $_REQUEST["course_id"];
$centre_id = $_SESSION["centre_id"];
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr class="logintext">
      <td height="20" align="left" valign="middle">&nbsp;</td>
      <td colspan="2" align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_QUICK_WAITING_FOR_GROUP");?></td>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr class="logintext">
    <td width="6%" height="20" align="left" valign="middle" bgcolor="#000066">&nbsp;</td>
    <td width="27%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
    <td width="44%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
    <td width="23%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?></td>
  </tr>
	<?php
	$m = 1;
	foreach($dbf->fetchOrder('student_fees',"centre_id='$centre_id' And course_id='$course_id' And type='opening'","","") as $valstudent){
	$student = $dbf->strRecordID("student","*","id='$valstudent[student_id]'");
    ?>
    <tr>
    <td align="center" valign="middle"><?php //echo $m;?><input type="checkbox" checked="checked" name="student_id<?php echo $m;?>" id="student_id<?php echo $m;?>" value="<?php echo $student["id"];?>"></td>
    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?>&nbsp;(<?php echo $Arabic->en2ar($student[first_name]);?>)</td>
    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[email];?></td>
    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[student_mobile];?></td>
    </tr>
	<?php
	$m++;
    }
    ?>
    <input type="hidden" name="scount" id="scount" value="<?php echo $m - 1;?>" />
</table>
<?php } else{?>
<table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
    <tr class="logintext">
     <td align="center" valign="middle">&nbsp;</td>
      <td colspan="2" align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_QUICK_WAITING_FOR_GROUP");?></td>
      
       <td height="20" align="right" valign="middle">&nbsp;</td>
    </tr>
    <tr class="logintext">
     <td width="23%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?></td>
     <td width="44%" align="right" valign="middle" bgcolor="#000066"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
    <td width="27%" align="right" valign="middle" bgcolor="#000066"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
  
    <td width="6%" height="20" align="left" valign="middle" bgcolor="#000066">&nbsp;</td>
  </tr>
	<?php
	$m = 1;    
	foreach($dbf->fetchOrder('student_fees',"centre_id='$centre_id' And course_id='$course_id' And type='opening'","","") as $valstudent){
	$student = $dbf->strRecordID("student","*","id='$valstudent[student_id]'");
    ?>
    <tr>
       <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $student[student_mobile];?></td>
   
    
    <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $student[email];?></td>
    <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?>&nbsp;(<?php echo $Arabic->en2ar($student[first_name]);?>)</td>
  <td align="center" valign="middle"><?php echo $m;?><input type="checkbox" checked="checked" name="student_id<?php echo $m;?>" id="student_id<?php echo $m;?>" value="<?php echo $student["id"];?>"></td>
    </tr>
	<?php
	$m++;
    }
    ?>
    <input type="hidden" name="scount" id="scount" value="<?php echo $m - 1;?>" />
</table>
<?php }?>