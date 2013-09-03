<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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
header("Content-Disposition: attachment; Filename=report_student_not_enrolled.doc");
?>

<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<body>
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
      <tr>
        <td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></span></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?></span></td>
        <td width='12%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></span></td>
        <td width='16%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE");?></span></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?></span></td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LEADINFO");?></span></td>
        <td colspan='2' align='center' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_INTRESTEDIN");?></span></td>
      </tr>
	 <?php
					if($_REQUEST[teacher]!=''){
						$cond = "s.id=c.student_id AND c.status_id='$_REQUEST[teacher]'";
					}else{
						$cond = "s.id=c.student_id";
					}
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student s,student_moving c',$cond,"");
					
					 //Loop start
					foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.id DESC","s.id","s.id") as $val) {
					
					$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
					
					//Get Course Name
					$course = "";
					foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
					
						$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
						if($course==''){
							$course  = $c[name];
						}else{
							$course  = $course.",".$c[name];
						}
					}
					
					//Get Lead Information
					$lead = '';
					foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
					
						$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
						if($lead==''){
							$lead  = $c[name];
						}else{
							$lead  = $lead.",".$c[name];
						}
					}
					
					//Register date
					if($val[register_date] == "0000-00-00"){
						$dt = '';
					}else{
						$dt = date('d-M-Y',strtotime($val_student[created_datetime]));
					}
					
					//Last comment
					$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
					$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");
					?>	
      <tr>
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $i;?></td>
        <td height='25' align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val_student[first_name];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val_student[student_mobile];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val_student[email];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $dt;?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $com["comments"];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $lead;?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $course;?></td>
        <?php
	  $i = $i + 1;
	  }
		?>		  
        </tr>
		<?php
		if($num==0)
		{
			?>
	  <?php
		}
		?>
		
    </table>
</body>
</html>
