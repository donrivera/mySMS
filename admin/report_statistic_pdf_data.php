<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
?>
<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
  <tr>
    <td width="66" height="25" align="left" valign="middle">&nbsp;</td>
    <td width="352" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT1");?> :&nbsp;
    <?php	
	if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		
		$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
	?>
     <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
	 <?php echo number_format($val_student["SUM(gs.units)"],0); ?>
     </span>
     <?php } ?></td>
    <td width="103" align="left" valign="middle">&nbsp;</td>
    <td width="77" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT2");?>:&nbsp;
     <?php
	 if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		 
		  $val_student1 = $dbf->strRecordID("student_group s,group_size gs","*","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
		  
		  $val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
  ?>  
  <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
  <?php echo number_format($val_no_course['COUNT(course_id)'],0); ?>
  </span>
  <?php } ?></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT3");?></td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?></td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?></td>
  </tr>
  <?php
	if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		$cond="status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))";
	}else{
		$cond="";
	}
	
	//Get Number of Rows
	$num=$dbf->countRows('student_group',$cond);
	
	if($cond != ""){
	
		//Loop start
		foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
		
		//Get course name
		$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");			
	?>
  <tr>
    <td height="25" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp;<?php echo $val_course[name]; ?></td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val[start_date]; ?></td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val[end_date]; ?></td>
  </tr>
  <?php }} ?>
  <tr>
    <td height="25" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT5");?>:&nbsp;
      <?php
		if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		?>
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
	  <?php echo number_format($val_student_no['COUNT(d.student_id)'],0); ?>
      </span>
      <?php } ?></td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp;</td>
    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp;</td>
  </tr>
</table>



