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
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
      <th width="3%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("LISM_DUE_DATE");?></th>
      <th width="21%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
      <th width="17%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
      <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
      <th width="11%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("LISM_UPDATE_DATE");?></th>
    </tr>
  </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        foreach($dbf->fetchOrder('student_group',"(certificate_filled='' OR certificate_filled='No') And centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'","id") as $val_leave) {
            $teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'");
            $centre = $dbf->strRecordID("centre","*","id='$val_leave[centre_id]'");
            $course = $dbf->strRecordID("course","*","id='$val_leave[course_id]'");
            $no_of_students = $dbf->countRows("student_group_dtls","parent_id='$val_leave[id]'");
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $val_leave[end_date];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $centre[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($val_leave["id"]);?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no_of_students;?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[certificate_update_date];?></td>
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
