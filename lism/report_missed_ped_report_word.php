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
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_missed_ped_report.doc");

?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
      <th width="3%" height="30" align="center" valign="middle">&nbsp;</th>
      <th width="9%" align="left" valign="middle" class="pedtext"><?php echo constant("LISM_DUE_DATE");?></th>
      <th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
      <th width="17%" height="30" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
      <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
      <th width="15%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
      <th width="11%" align="center" valign="middle" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
      <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("LISM_UPDATE_DATE");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        //Get Number of Rows
        $num=$dbf->countRows('ped_daily_status_dtls',"centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'");
        
        //loop start
        foreach($dbf->fetchOrder('ped_daily_status_dtls',"centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'","id") as $val_leave) {
            $group = $dbf->strRecordID("student_group","*","id='$val_leave[group_id]'");
            $teacher = $dbf->strRecordID("teacher","*","id='$group[teacher_id]'");
            $centre = $dbf->strRecordID("centre","*","id='$group[centre_id]'");
            $course = $dbf->strRecordID("course","*","id='$group[course_id]'");
            $no_of_students = $dbf->countRows("student_group_dtls","parent_id='$group[id]'");
            $tdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($val_leave["dated"])) . "-2 day"));
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $tdt;?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $centre[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no_of_students;?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[dated];?></td>
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