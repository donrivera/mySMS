<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' bordercolor='#AAAAAA'>
      <tr>
        <td width='2%' height='29' align='center' valign='middle' bgcolor='#CDCDCD' >&nbsp;</td>
        <td width='13%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("STUDENT_ADVISOR_S10_MOBNO");?> </td>
        <td width='18%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> </td>
        <td width='11%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("CD_REPORT_STUDENT_NOT_ENROLLED_CSV_DATA_EQUITYDATE");?></td>
        <td width='15%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?> </td>
        <td width='13%' align='left' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LEADINFO");?> </td>
        <td width="13%"  align='center' valign='middle' bgcolor='#CDCDCD' style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_INTRESTEDIN");?> </td>
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
	<tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
	  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[first_name];?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[student_mobile];?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[email];?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dt;?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $com["comments"];?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $lead;?></td>
	  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><span id="result_box" lang="ar" xml:lang="ar"><?php echo $course;?></span></td>
        <?php
		  $i = $i + 1;
		  }
		?>		  
  </tr>
</table>