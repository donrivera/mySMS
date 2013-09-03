<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include '../includes/FusionCharts.php';
include_once '../includes/language.php';
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_student_group_grade.doc");
?>

<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
	
<table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="middle" bgcolor="#990066" class="headingtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?> </td>
      </tr>
      <tr>
        <td height="5" align="left" valign="middle" class="lable1"></td>
      </tr>
      <?php
     $res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");			
     ?>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo constant("STUDENT_ADVISOR_S2_NAME");?> :<?php echo $res[first_name]; ?> </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_IDNO");?> : <?php echo $res[student_id]; ?> </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL");?>: &nbsp;<?php echo $res[email]; ?> </td>
      </tr>
   
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
      
      <tr>
        <td align="center" valign="middle">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#DFF2DB" class="tablesorter" id="tablesorter-demo">
          <tr>
            <td width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</td>
            <td width="67%" align="left" valign="middle" bgcolor="#99CC99" class="menutext" ><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME?></td>
            <td width="27%" align="center" valign="middle" bgcolor="#99CC99" class="menutext" ><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE?></td>
          </tr>
          <?php					
            $i = 1;
            $num=$dbf->countRows('grade');
            foreach($dbf->fetchOrder('student_course',"student_id='$res[id]'","id DESC") as $val) {
            $res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
            ?>
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
            <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">&nbsp;</td>
            <?php
              $i = $i + 1;
              }
              ?>
          </tr>
          <?php
            if($num==0)
            {
            ?>
          <tr>
            <td height="25" colspan="3" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?> </td>
          </tr>
          <?php
            }
            ?>                  
        </table>
        </td>
      </tr>
      <tr>
        <td align="center" valign="middle">&nbsp;</td>
</tr>
    </table>
            
           