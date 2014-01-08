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
            <td width="37%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="25%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
            <td width="19%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="13%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
          </tr>
          <?php
          $kk = 1;
          foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) {
                $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
                $course_fee = $dbf->BalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
          ?>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF" ><input type="radio" name="tostudent_id" id="tostudent_id<?php echo $kk;?>" value="<?php echo $mygroup["student_id"];?>"  onchange="show_save();"/></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php  echo $dbf->printStudentName($student["id"]);?></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
          </tr>
          <?php $kk++; } ?>
        </table>
        <input type="hidden" name="tocount" id="tocount" value="<?php echo $kk-1;?>" />
        <?php
	}else{
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr>
            <td width="6%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
            <td width="37%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="25%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
            <td width="19%" height="25" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="13%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?>&nbsp;</td>
          </tr>
          <?php
          $kk = 1;
		  $status_id = $_REQUEST["from_status"];
		  $course_id = $_REQUEST["course_id"];
         if($course_id !='')
		  {
			$query=$dbf->genericQuery("SELECT s.*,sf.total
									   FROM student s
									   LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
									   INNER JOIN student_moving sm ON sm.student_id=s.id
									   WHERE sf.course_id='$course_id' And s.centre_id='$_SESSION[centre_id]'
									   ");
									   
		  }
		  elseif($status !='')
		  {echo "2";
			$query=$dbf->genericQuery("SELECT s.*,sf.total,sf.course_id
									   FROM student s
									   LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
									   INNER JOIN student_moving sm ON sm.student_id=s.id
									   WHERE sm.status_id='$status_id' And s.centre_id='$_SESSION[centre_id]'");
		  }
		  else
		  {
			$query=$dbf->genericQuery("SELECT s.*,sf.total,sf.course_id
									   FROM student s
									   LEFT JOIN(SELECT student_id,course_id,SUM(paid_amt)AS total FROM student_fees GROUP BY student_id) sf ON sf.student_id=s.id 
									   INNER JOIN student_moving sm ON sm.student_id=s.id
									   WHERE sm.status_id='$status_id' And s.centre_id='$_SESSION[centre_id]' ORDER BY sf.total DESC LIMIT 0,10");
		  }
		  foreach($query as $student) {
				
			  $cou_id=($course_id =='' ? $student["course_id"] :$course_id );
			  $course_fee = $dbf->printBalanceAmount($student["id"], $cou_id);
			  
          ?>          
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php //echo $student["id"];?>
            <input type="radio" name="tostudent_id" id="tostudent_id<?php echo $kk;?>" value="<?php echo $student["id"];?>"  onchange="show_save();"/></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php echo $dbf->printStudentName($student["id"]);?></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext"><?php echo number_format($course_fee, 2);?>&nbsp;</td>
          </tr>
          <?php $kk++; } ?>
        </table>
<input type="hidden" name="tocount" id="tocount" value="<?php echo $kk-1;?>" />
        <?php
	}
	?>
		
<?php
}else{
	if($_REQUEST['group'] != ''){
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr>
            <td width="18%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;<?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td> 
            <td width="18%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
            <td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
          </tr>
          <?php
          $kk = 1;
          foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group]'") as $mygroup) {
                $student = $dbf->strRecordID("student","*","id='$mygroup[student_id]'");
				$course_fee = $dbf->printBalanceAmount($mygroup["student_id"], $mygroup["course_id"]);
          ?>
          <tr>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>    
            <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php  echo $dbf->printStudentName($student["id"]);?></td>
            <td align="center" valign="middle" bgcolor="#FFFFFF" >
            <input type="radio" name="tostudent_id" id="tostudent_id<?php echo $kk;?>" value="<?php echo $mygroup["student_id"];?>"  onchange="show_save();"/>
            </td>
          </tr>
          <?php $kk++; } ?>
        </table>
<input type="hidden" name="tocount" id="tocount" value="<?php echo $kk-1;?>" />
		<?php
	}else{
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr>
            <td width="18%" align="left" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;<?php echo constant('CD_SEARCH_PRINT_INVOICE_BALANCE');?></td> 
            <td width="18%" height="25" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
            <td width="26%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
            <td width="31%" align="right" valign="middle" bgcolor="#E0E3FE" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="7%" align="center" valign="middle" bgcolor="#E0E3FE" class="pedtext">&nbsp;</td>
          </tr>
          <?php
          $kk = 1;
          $status_id = $_REQUEST["from_status"];
		  $course_id = $_REQUEST["course_id"];
           if($course_id !='')
		  {
			//$query=$dbf->fetchOrder('student m,student_moving d',"m.id=d.student_id And d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$_SESSION[centre_id]' And m.first_name<>''","","m.*");
			$query=$dbf->genericQuery("SELECT m.* FROM student m INNER JOIN student_moving d ON d.student_id=m.id WHERE d.status_id='$status_id' And d.course_id='$course_id' And m.centre_id='$_SESSION[centre_id]'");
		  }
		  else
		  {
			$query=$dbf->genericQuery("SELECT s.id,s.student_mobile,s.student_id FROM student s INNER JOIN student_moving sm ON sm.student_id=s.id WHERE sm.status_id='$status_id'");
		  }
		  foreach($query as $student) {
			  
			  $course_fee = $dbf->printBalanceAmount($student["id"], $course_id);
			  
          ?>
          <tr>
            <td align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo number_format($course_fee, 2);?></td>    
            <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php if($student["student_id"]!='0') { echo $student["student_id"]; }?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;<?php echo $student["student_mobile"];?></td>
            <td align="right" valign="middle" bgcolor="#FFFFFF" >&nbsp;<?php  echo $dbf->printStudentName($student["id"]);?></td>
            <td align="center" valign="middle" bgcolor="#FFFFFF" >
            <input type="radio" name="tostudent_id" id="tostudent_id<?php echo $kk;?>" value="<?php echo $student["id"];?>"  onchange="show_save();"/></td>
          </tr>
          <?php $kk++; } ?>
        </table>
<input type="hidden" name="tocount" id="tocount" value="<?php echo $kk-1;?>" />
        <?php
	}
		?>
<?php }?>