<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();


//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_statistic.doc");
?>

<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" style="border:solid 1px; border-color:#AAAAAA;">
  <tr>
    <td width="52" height="30"></td>
    <td width="536" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" >
	<?php echo constant("ADMIN_REPORT_STATISTIC_TXT1");?> :&nbsp;
    <?php	
	if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		
		$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
	?>
     <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
	 <?php echo number_format($val_student["SUM(gs.units)"],0); ?>
     </span>
     <?php } ?>
     </td>
  </tr>
  <tr>
    <td height="30"></td>
    <td style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">
	<?php echo constant("ADMIN_REPORT_STATISTIC_TXT2");?>:&nbsp;
     <?php
	 if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		 
		  $val_student1 = $dbf->strRecordID("student_group s,group_size gs","*","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
		  
		  $val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
  ?>  
  <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
  <?php echo number_format($val_no_course['COUNT(course_id)'],0); ?>
  </span>
  <?php } ?>
  </td>
  </tr>
  <tr>
    <td height="30"></td>
    <td class="leftmenu"><table width="90%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#AAAAAA;" bordercolor="#AAAAAA" >
      <tr>
        <td height="30" colspan="3" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT3");?> </td>
      </tr>
      <tr class="pedtext">
        <td width="47%" height="30" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT4");?></td>
        <td width="29%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?> </td>
        <td width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?> </td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle" >
        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
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
          <tr class="red_smalltext">
            <td width="47%" height="25" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val_course[name]; ?></td>
            <td width="29%" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val[start_date]; ?></td>
            <td width="24%" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val[end_date]; ?></td>
          </tr>
          <?php }} ?>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"></td>
        <td align="left" valign="middle" class="lable1"></td>
        <td align="left" valign="middle" class="lable1"></td>
      </tr>
    </table></td>
  </tr>
  <?php
	$val_student_com = $dbf->strRecordID("student_course","*","course_id='$val[course_id]'");
	
	//$val_student_no = $dbf->strRecordID("student_course","COUNT(student_id)","course_id='$val[course_id]'");
	$val_student_no = $dbf->strRecordID("student_group g,student_group_dtls d","COUNT(d.student_id)","g.id=d.parent_id And g.status='Completed' And g.course_id='$val[course_id]' And (start_date <= '$_REQUEST[enddate]' And end_date >= '$_REQUEST[startdate]')");	
	?>
  <tr>
    <td height="30"></td>
    <td style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT5");?>:&nbsp;
      <?php
		if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
		?>
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
	  <?php echo number_format($val_student_no['COUNT(d.student_id)'],0); ?>
      </span>
      <?php } ?>
      </td>
  </tr>
</table>
