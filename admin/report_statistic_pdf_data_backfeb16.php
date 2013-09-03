<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';


?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" style="border:solid 1px; border-color:#AAAAAA;">
  <tr>
    <td width="52" height="30"></td>
    <td width="536" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" >Number Of Units Completed Within The Selected Period :&nbsp;
      <?php
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !='')
						{
							$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
						?>
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo number_format($val_student["SUM(gs.units)"],0); ?></span>
      <?php } ?></td>
  </tr>
  <tr>
    <td width="52" height="30"></td>
    <td width="536" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">Number Of Course Completed :&nbsp;
      <?php
	    
	         if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !='')
			   {
				  $val_student1 = $dbf->strRecordID("student_group s,group_size gs","*","s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))");
                  $val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
				  //$val_course = $dbf->strRecordID("course","*","id='$val_student1[course_id]'");
				 
  ?>
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"> <?php echo number_format($val_no_course['COUNT(course_id)'],0); ?></span>    </td>
      <?php } ?>
  </tr>
  <tr>
    <td width="52" height="30"></td>
    <td width="536" class="leftmenu"><table width="90%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#AAAAAA;" bordercolor="#AAAAAA" >
      <tr>
        <td height="30" colspan="3" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;List of Courses completed </td>
      </tr>
      <tr>
        <td width="47%" height="30" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">&nbsp;Name of the Course</td>
        <td width="29%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">Start Date </td>
        <td width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">End Date </td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle" >
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
              <?php
            
                 if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !='')
                   {
                        $num=$dbf->countRows('student_group',"status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))");
                        foreach($dbf->fetchOrder('student_group',"status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))","id","") as $val_course){
                        $val_course_name = $dbf->strRecordID("course","*","id='$val_course[course_id]'");
                     
      ?>
              <tr class="red_smalltext">
                <td width="47%" height="25" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val_course_name[name]; ?></td>
                <td width="29%" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val_course[start_date]; ?></td>
                <td width="24%" align="left" valign="middle" bgcolor="#F8F9FB" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">&nbsp; <?php echo $val_course[end_date]; ?></td>
              </tr>
              <?php }}?>
            </table>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"></td>
        <td align="left" valign="middle" class="lable1"></td>
        <td align="left" valign="middle" class="lable1"></td>
      </tr>
    </table></td>
  </tr>
 
  <tr>
    <td width="52" height="30"></td>
    <td width="536" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;">Number Of Students Completed :&nbsp;
      <?php
	
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !='')
						{
							  $num=$dbf->countRows('student_group',"status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))");
							//$val_student_com = $dbf->strRecordID("student_course","*","course_id='$val[course_id]'");
							foreach($dbf->fetchOrder('student_group',"status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))","id","") as $val){
					
					//$val_student_no = $dbf->strRecordID("student_course","COUNT(student_id)","course_id='$val[course_id]'");
					
					$val_student_no = $dbf->strRecordID("student_group g,student_group_dtls d","COUNT(d.student_id)","g.id=d.parent_id And g.status='Completed' And g.course_id='$val[course_id]' And (start_date <= '$_REQUEST[enddate]' And end_date >= '$_REQUEST[startdate]')");
						?>
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo number_format($val_student_no['COUNT(d.student_id)'],0); ?></span>
      <?php } }?></td>
  </tr>
</table>
