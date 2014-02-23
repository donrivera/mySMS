<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
		<th width="9%" align="left" valign="middle" class="pedtext"><?php echo constant("LISM_DUE_DATE");?></th>
		<th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
		<th width="17%" height="30" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
		<th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
		<th width="15%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
		<th width="11%" align="center" valign="middle" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
    </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        $teacher_id=$_REQUEST['teacher_id'];
		$centre_id=$_REQUEST['centre_id'];
        $query=$dbf->genericQuery("SELECT DISTINCT(p.dated),p.teacher_id,p.group_id,sg.group_name,sg.course_id,c.name as centre_name,t.name as teacher_name
													FROM ped_units p
													INNER JOIN student_group sg ON sg.id=p.group_id
													INNER JOIN teacher t ON t.id=p.teacher_id
													INNER JOIN centre c ON c.id=sg.centre_id
													WHERE p.dated NOT IN(SELECT attend_date FROM ped_attendance)
													AND p.teacher_id='$teacher_id' AND sg.centre_id='$centre_id'");
		$num=count($query);
		foreach($query as $ped)
		{
			$tdt=$ped['dated'];
			$group_id=$ped['group_id'];
			$course_id=$ped['course_id'];
			$no_of_students=$dbf->getDataFromTable("student_group_dtls","COUNT(id)","parent_id='$group_id'");
			$course_name=$dbf->getDataFromTable("course","name","id='$course_id'");
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
		<td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $tdt;?></td>
        <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $ped['teacher_name'];?></td>
        <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $ped['centre_name'];?></td>
        <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($group_id);?></td>
        <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course_name;?></td>
        <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no_of_students;?></td>
      <?php
          $i = $i + 1;
          if($color=="#ECECFF"){
              $color = "#FBFAFA";
          }else{
              $color="#ECECFF";
          }					  
      }
      ?>
    </tr>                   
</table>

<script type="text/javascript">
window.print();
</script>
