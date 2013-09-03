<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
if($_SESSION['lang']=='EN'){

	if($_REQUEST['group'] != ''){
		?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
		  <tr>
			<td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
			<td width="41%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
			<td width="21%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
			<td width="18%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
			<td width="14%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td>
            
		  </tr>
		  <?php
		  $i = 1;
		  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) {
				$student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				$course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
		  ?>
		  <tr>
			<td align="center" valign="middle" bgcolor="#FFFFFF" ><?php //echo $_REQUEST[group];?>
			<input type="radio" name="student_id" id="student_id<?php echo $i-1;?>" value="<?php echo $mygroup["student_id"];?>" onchange="show_save();" />
			</td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
			<td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
			<td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
		  </tr>
		  <?php  $i = $i + 1; } ?>
		  <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
		</table>
		<?php } else { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr>
            <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
            <td width="41%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="21%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
            <td width="18%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="14%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td>
          </tr>
          <?php
          $i = 1;
		  $status_id = $_REQUEST["from_status"];
		  $course_id = $_REQUEST["course_id"];
		  $centre_from = $_REQUEST["centre_from"];		  
          foreach($dbf->fetchOrder('student m,student_moving d',"m.id=d.student_id And d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$centre_from' And m.first_name<>''","","m.*") as $student) {
			  
			  $course_fee = $dbf->BalanceAmount($student["id"], $course_id);
			  
          ?>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php //echo $student["id"];?>
            <input type="radio" name="student_id" id="student_id<?php echo $i-1;?>" value="<?php echo $student["id"];?>" onchange="show_save();" />
            </td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
          </tr>
          <?php  $i = $i + 1; } ?>
            <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">                  
          </table>	
		<?php
		}
}else{
	if($_REQUEST['group'] != ''){
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
  <tr>
    <td width="18%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td>   
    <td width="18%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
    <td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
     <td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
    <td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
  </tr>
  <?php
  $i = 1;
  foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) {
        $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
		$course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
  ?>
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>
     <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
      <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
    <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" >
    <input type="radio" name="student_id" id="student_id<?php echo $i-1;?>" value="<?php echo $mygroup["student_id"];?>" onchange="show_save();" />
    </td>
  </tr>
  <?php  $i = $i + 1; } ?>
  <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
</table>
        <?php
	}else{
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr>
            <td width="18%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td>
            <td width="18%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
             <td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
          </tr>
          <?php
		  $i = 1;
		  $status_id = $_REQUEST["from_status"];
		  $course_id = $_REQUEST["course_id"];
		  $centre_from = $_REQUEST["centre_from"];
          foreach($dbf->fetchOrder('student m,student_moving d',"m.id=d.student_id And d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$centre_from' And m.first_name<>''","","m.*") as $student){
			   $course_fee = $dbf->BalanceAmount($student["id"], $course_id);
          ?>
          <tr>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>
             <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
              <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
            <td align="center" valign="middle" bgcolor="#FFFFFF" >
            <input type="radio" name="student_id" id="student_id<?php echo $i-1;?>" value="<?php echo $student["id"];?>" onchange="show_save();" />
            </td>
          </tr>
          <?php  $i = $i + 1; } ?>
          <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </table>
        <?php
	}
}
?>