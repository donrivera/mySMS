<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" >
  <tr >
      <td width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" ></td>
      <td width="22%" align="left" valign="middle" bgcolor="#CDCDCD"  ><strong><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></strong></td>
      <td width="16%" align="left" valign="middle" bgcolor="#CDCDCD" ><strong><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?> </strong></td>
      <td width="25%" align="left" valign="middle" bgcolor="#CDCDCD" ><strong><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></strong></td>
      <td width="9%" align="left" valign="middle" bgcolor="#CDCDCD" ><strong><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></strong></td>
      <td width="24%" align="left" valign="middle" bgcolor="#CDCDCD" ><strong><?php echo constant("CD_REPORT_STUDENT_AWAITING_CSV_DATA_DATEWAIT");?> </strong></td>
  </tr>
    <?php
	if($_REQUEST[status]!=''){
		$cond="s.id = c.student_id And c.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3' And s.centre_id='$_REQUEST[centre_id]'";
	}else{
		$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_REQUEST[centre_id]'";
	}
	$i = 1;
	$color="#ECECFF";
	
	//Get Number of Rows
	if($cond != ''){
		$num=$dbf->countRows('student s,student_moving c',$cond);
	}
	
	//Loop start
	foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.first_name","s.*,c.date_time") as $val){
		$course = $dbf->getDataFromTable("course", "name", "id='$_REQUEST[status]'");	
    ?>
    <tr>
      <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" ><?php echo $i;?></td>
      <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" ><?php echo $val[first_name];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB"  ><?php echo $val[student_mobile];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB" ><?php echo $val[email];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB"  ><?php echo $course;?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB"  ><?php if($val[date_time] != '0000-00-00 00:00:00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
  </tr>
      <?php
   $i = $i + 1;
   }
   ?>
</table>