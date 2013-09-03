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

?>	

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
<tr class="logintext">
  <th width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
  <th width="23%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPNAME");?></th>
  <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("STUDENT_ADVISOR_PED_TNAME");?> </th>
  <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("STUDENT_ADVISOR_PED_STARTDT");?> </th>
  <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE");?> </th>
  <th width="23%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
  </tr>
  </thead>
<?php
    $i = 1;
    if($_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
    {
     $cond="status<>'Completed' And (start_date <= '$_REQUEST[end_date]' And end_date >= '$_REQUEST[start_date]')";
    }
    else
    {
    $cond="status<>'Completed'";
    }
    $num=$dbf->countRows('student_group',$cond);
    
    foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
        
    $res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
    $grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
    $course = $dbf->strRecordID("course","*","id='$val[course_id]'");
    ?>
<tr>
  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><?php echo $i;?></td>
  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $res[name];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[start_date];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[end_date];?></td>
  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $course[name];?></td>
  <?php
      $i = $i + 1;
      }
      ?>
</tr>
</table>
<script type="text/javascript">
window.print();
</script>