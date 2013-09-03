<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=centre_schedule_startdate.doc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
</head>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            
              <tr>
                <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                <td height="25" align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
                <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_GROUP");?></td>
                <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT");?></td>
                <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS");?></td>
              </tr>
              
              <?php
			$color = "#ECECFF";
			
			if($_REQUEST[startdate] !='')
				{
				  $cond="start_date >='$_REQUEST[startdate]' And centre_id='$_SESSION[centre_id]'";
				}
			else
				{
				  $cond="centre_id='$_SESSION[centre_id]'";
				}
			
			//Get Number of Rows
			 $num=$dbf->countRows('student_group',$cond);
			//echo $num;
			
            //Loop start
			foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
			
			//Get no of students
			$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");
			
			//Get group name
			$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
			
			//Get course name
			$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
			
			//Get teacher name
			$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
			
			?>
            
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td width="201" align="center" valign="middle"  class="mycon"><?php echo $val_teacher[name];?></td>
                <td width="169" height="25" align="center" valign="middle"  class="mycon"><?php echo $val_course[name];?></td>
                <td width="366" align="center" valign="middle"  class="mycon"><?php echo $dbf->FullGroupInfo($val["id"]);?></td>
                <td width="134" align="center" valign="middle"  class="mycon"><?php echo $val_no["COUNT(id)"];?></td>
                <td width="127" align="center" valign="middle"  class="mycon"><?php echo $val[status];?></td>
              </tr>
            <?php 
			if($color=="#ECECFF")
				  {
					  $color = "#FBFAFA";
				  }
				  else
				  {
					  $color="#ECECFF";
				  }
			
			} ?>
            </table>
<?php } else{?>
<table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        
    <tr>
      <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS");?></td>
      <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_GROUP");?></td>
      <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?></td>
      
      <td height="25" align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
      <td align="center" valign="middle" class="pedtext" bgcolor="#DDDDDD"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
      </tr>
    
    <?php
    $color = "#ECECFF";
    
    if($_REQUEST[startdate] !='')
        {
          $cond="start_date >='$_REQUEST[startdate]' And centre_id='$_SESSION[centre_id]'";
        }
    else
        {
          $cond="centre_id='$_SESSION[centre_id]'";
        }
    
    //Get Number of Rows
     $num=$dbf->countRows('student_group',$cond);
    //echo $num;
    
    //Loop start
    foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
    
    //Get no of students
    $val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");
    
    //Get group name
    $val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
    
    //Get course name
    $val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
    
    //Get teacher name
    $val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
    
    ?>
    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
      <td width="97" align="center" valign="middle"  class="mycon"><?php echo $val[status];?></td>
      <td width="372" align="center" valign="middle"  class="mycon"><?php echo $dbf->FullGroupInfo($val["id"]);?></td>
      <td width="104" align="center" valign="middle"  class="mycon"><?php echo date('m/d/Y',strtotime($val[end_date]));?></td>
      <td width="209" height="25" align="center" valign="middle"  class="mycon"><?php echo $val_course[name];?></td>
      <td width="215" align="center" valign="middle"  class="mycon"><?php echo $val_teacher[name];?></td>
      </tr>
    <?php 
    if($color=="#ECECFF")
          {
              $color = "#FBFAFA";
          }
          else
          {
              $color="#ECECFF";
          }
    
    } ?>
    </table>
<?php }?>
</body>
</html>