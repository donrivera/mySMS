<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
      <tr>
        <td width='3%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='14%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?> </td>
        <td width='12%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> </td>
        <td width='10%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_PRINT_AREA");?> </td>
        <td width='40%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_PRINT_ADDRESS");?> </td>
		<td width='40%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_GROUP");?> </td>
	  </tr>
	  <?php
					if($_REQUEST[area_code]!=''){
						$cond="s.area_code='$_REQUEST[area_code]'";
					}else{
						$cond="s.area_code=a.code";
					}
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student s,area a',$cond,"");
					
					 //Loop start
					foreach($dbf->fetchOrder('student s,area a',$cond,"s.first_name ASC","s.id,s.first_name","s.id") as $val) {
					
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
        <td height='25' align='center' valign='middle' bgcolor='#F8F9FB'><?php echo $i;?></td>
        <td height='25' align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->printStudentName($val_student[id]);?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val_student[student_mobile];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val_student[email];?></td>
        <!--<td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dt;?></td>-->
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $dbf->getDataFromTable("area","name","code='$val_student[area_code]'");?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'><?php echo $val_student[address];?></td>
        <td align='left' valign='middle' bgcolor='#F8F9FB' style='font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;'>
			<?php 
				$group=$dbf->genericQuery("SELECT sg.group_name,sg.start_date,sg.end_date,sg.group_start_time,sg.group_end_time
													FROM student_group sg
													INNER JOIN student_group_dtls sgd ON sgd.student_id='".$val_student[id]."'
													WHERE sg.status='Continue'
													ORDER BY sg.start_date DESC
													LIMIT 0,1
												");
						foreach($group as $g):
							echo $g[group_name]."<BR/>";
							echo $dbf->printClassTimeFormat($g[group_start_time],$g[group_end_time]);
							echo "<BR/>".$g[start_date]."&nbsp;".$g[end_date];
						endforeach;
			?>
		</td>
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