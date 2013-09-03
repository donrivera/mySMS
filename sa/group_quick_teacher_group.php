<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$teacher_id = $_REQUEST["teacher_id"];

 if($_SESSION[lang]=="EN"){?>
<table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
    <tr class="logintext">
      <td width="35%" height="20" align="left" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
      <td width="28%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
      <td width="22%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_QUICK_START_END_DATE");?></td>
      <td width="15%" align="left" valign="middle" bgcolor="#000066"> % <?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
  </tr>
    <?php
    foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And teacher_id='$teacher_id'","","") as $valstudent){
	$course = $dbf->strRecordID("course","*","id='$valstudent[course_id]'");
	
	# Calculate Percentanges of Complition
	# (Number of Class complete / Number of Units has to be Teach) * 100
	$tot_unit = $dbf->strRecordID("group_size","*","group_id='$valstudent[group_id]'");
	$tot_unit = $tot_unit[units];
	
	# SELECT count(id) FROM `ped_units` WHERE `material_overed`<>'' and `group_id`=1
	$com_unit = $dbf->strRecordID("ped_units","COUNT(id)","material_overed<>'' And group_id='$valstudent[id]'");
	$com_unit = $com_unit["COUNT(id)"];
	
	# Final Percent
	$completed = 0;
	if($tot_unit > 0 && $com_unit > 0){
		$completed = ($com_unit / $tot_unit) * 100;
		if($completed != 100){
			$completed = number_format(($com_unit / $tot_unit) * 100,2);
		}
	}
    ?>
    <tr>
      <td align="left" valign="middle">&nbsp;<?php echo $valstudent[group_name];?> <?php echo $valstudent["group_time"];?>-<?php echo $dbf->GetGroupTime($valstudent["id"]);?></td>
      <td align="left" valign="middle">&nbsp;<?php echo $course[name];?></td>
      <td align="center" valign="middle">&nbsp;<?php echo date('d-M-Y',strtotime($valstudent[start_date]));?>&nbsp;<br />        <?php echo date('d-M-Y',strtotime($valstudent[end_date]));?></td>
      <td align="left" valign="middle">&nbsp;<?php echo $completed;?>&nbsp;%</td>
    </tr>
    <?php	
    }
    ?>
</table>
<?php } else{?>
<table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
    <tr class="logintext">
    <td width="16%" align="right" valign="middle" bgcolor="#000066"> % <?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
    <td width="21%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_QUICK_START_END_DATE");?></td>
      <td width="22%" align="right" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
      <td width="41%" height="20" align="left" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
     
     
      
      
  </tr>
    <?php
    foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And teacher_id='$teacher_id'","","") as $valstudent){
	$course = $dbf->strRecordID("course","*","id='$valstudent[course_id]'");
	
	# Calculate Percentanges of Complition
	# (Number of Class complete / Number of Units has to be Teach) * 100
	$tot_unit = $dbf->strRecordID("group_size","*","group_id='$valstudent[group_id]'");
	$tot_unit = $tot_unit[units];
	
	# SELECT count(id) FROM `ped_units` WHERE `material_overed`<>'' and `group_id`=1
	$com_unit = $dbf->strRecordID("ped_units","COUNT(id)","material_overed<>'' And group_id='$valstudent[id]'");
	$com_unit = $com_unit["COUNT(id)"];
	
	# Final Percent
	$completed = 0;
	if($tot_unit > 0 && $com_unit > 0){
		$completed = ($com_unit / $tot_unit) * 100;
		if($completed != 100){
			$completed = number_format(($com_unit / $tot_unit) * 100,2);
		}
	}
    ?>
    <tr>
     <td align="right" valign="middle">%&nbsp;<?php echo $completed;?></td>
      <td align="center" valign="middle"><?php echo date('d-M-Y',strtotime($valstudent[start_date]));?>&nbsp;<br />        <?php echo date('d-M-Y',strtotime($valstudent[end_date]));?></td>
     <td align="right" valign="middle">&nbsp;<?php echo $course[name];?></td>
      <td align="right" valign="middle">&nbsp;<?php echo $valstudent[group_name];?> <?php echo $valstudent["group_time"];?>-<?php echo $dbf->GetGroupTime($valstudent["id"]);?></td>
      
      
     
    </tr>
    <?php	
    }
    ?>
</table>
<?php }?>
