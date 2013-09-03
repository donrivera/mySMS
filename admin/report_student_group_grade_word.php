<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=details_students_results.doc");
?>
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">	
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="middle" bgcolor="#990066" class="headingtext"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS ?> </td>
      </tr>
      <tr>
        <td height="5" align="left" valign="middle" class="lable1"></td>
      </tr>
      <?php
     $res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");		
     ?>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo STUDENT_ADVISOR_S2_NAME ?> : <?php echo $res["first_name"]; ?> </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_IDNO?> : <?php echo $res["student_id"]; ?> </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="lable1"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL?>: &nbsp;<?php echo $res[email]; ?> </td>
      </tr>           
      <tr>
        <td align="left" valign="middle">
        <table width="100%" border="1" bordercolor="#cccccc" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
          <tr>
            <td width="8%" height="25" align="center" valign="middle" bgcolor="#999999">&nbsp;</td>
            <td width="31%" align="left" valign="middle" bgcolor="#999999" class="logintext"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME?></td>
            <td width="27%" align="center" valign="middle" bgcolor="#999999" class="logintext"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE?></td>
            <td width="34%" align="center" valign="middle" bgcolor="#999999" class="logintext"><?php echo ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE?></td>
          </tr>
          <?php					
            $i = 1;
            
            $num=$dbf->countRows('grade');
            foreach($dbf->fetchOrder('student_group_dtls',"student_id='$res[id]'","id DESC") as $val) {
            
            $res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");					
            if($res_course[name] !='') {
                
            //Get percentage
            $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$val[course_id]' And student_id='$_REQUEST[student_id]'");					
            $mark = $res_per[final_percent];
            
            //Get Average
            $grade = $dbf->strRecordID("grade","*","(tto>='$mark' And frm<='$mark')");
            $grade_name = $grade[name];
            ?>
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
            <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $mark;?>%</td>
            <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $grade_name;?></td>
            <?php
            }
		  $i = $i + 1;
		  }
		  ?>
          </tr>
          <?php
            if($num==0)
            {
            ?>
          <tr>
            <td height="25" colspan="4" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
          </tr>
          <?php
            }
            ?>
        </table>
        </td>
      </tr>			  
  <tr>
    <td width="188">&nbsp;</td>
  </tr>
</table>