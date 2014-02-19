<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
//Object initialization
$dbf = new User();
include_once '../includes/language.php';
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_student_awaiting.doc");
?>	
<!--Important-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
<tr class="logintext">
  <th width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
  <th width="22%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?> </th>
  <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  ><?php echo constant("CD_REPORT_STUDENT_AWAITING_CSV_DATA_DATEWAIT");?> </th>
  </tr>
</thead>
<?php
	if($_REQUEST[status]!='')
	{
		//$cond = "s.id = c.student_id And sf.student_id=c.student_id And sf.type='advance' And sf.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3' And s.centre_id='$_SESSION[centre_id]'";
						
		$query=$dbf->genericQuery("SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
									FROM student_moving c
									INNER JOIN student s ON s.id=c.student_id
									INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
									WHERE 
										c.status_id = '3' 
										AND s.centre_id='$_SESSION[centre_id]' 
										AND sf.course_id = '$_REQUEST[status]'
										AND sf.type='advance' ORDER BY s.first_name");
	}else
	{
		//$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_SESSION[centre_id]' And sf.student_id=c.student_id And sf.type='advance'";
						
		$query=$dbf->genericQuery("SELECT s.id,s.student_mobile,s.email,c.date_time,sf.course_id
									FROM student_moving c
									INNER JOIN student s ON s.id=c.student_id
									INNER JOIN (SELECT DISTINCT(course_id),type,student_id FROM student_fees) sf ON c.student_id=sf.student_id
									WHERE 
										c.status_id = '3' 
										AND s.centre_id='$_SESSION[centre_id]'  
										AND sf.type='advance' ORDER BY s.first_name");
	}
	$i = 1;
	$color="#ECECFF";
	$num=count($query);#$dbf->countRows('student s,student_moving c',$cond);
	#$query=$dbf->fetchOrder('student s,student_moving c,student_fees sf',$cond,"s.first_name","s.*,c.date_time,sf.course_id")
	//Loop start
	foreach($query as $val){
			$course = $dbf->getDataFromTable("course", "name", "id='$val[course_id]'");
    ?>
<tr>
  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $i;?></td>
  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $dbf->printStudentName($val["id"]);?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[student_mobile];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[email];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $course;?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;">
  <?php if($val[date_time] != '0000-00-00 00:00:00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
  <?php
	  $i = $i + 1;
	}      
?>
</tr>
</table>
</body>

