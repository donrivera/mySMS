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


//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>	

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">
                  <th width="6%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
                  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?>/<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></th>
                  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALU");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_CONTRACTUNITS");?></th>
                  <th width="19%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_TOTALH");?></th>
                  </tr>
				  </thead>
                <?php
					
					if($_REQUEST[teacher]!=0)
					{
					 $cond="teacher_id='$_REQUEST[teacher]'";
					}
					else
					{
					$cond="";
					}
					
					$i = 1;
					$num=$dbf->countRows('student_group',$cond);
					foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
					$res = $dbf->strRecordID("common","*","id='$val[group_id]'");
					$res_total_unit = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
										
					$unit = $dbf->strRecordID("ped_units","COUNT(id)","teacher_id='$val[teacher_id]' And group_id='$val[group_id]' And course_id='$val[course_id]'");
					
					$unit1 = $dbf->strRecordID("group_size","*","group_id='$val[group_id]'");
					
					$over = $unit["COUNT(id)"] - $unit1["units"];
					
					if($over < 0){
						$over = 'No overtime yet...';
					}					
					?>
                <tr>
                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo date('d-M-Y',strtotime($val[start_date]))." To ".date('d-M-Y',strtotime($val[end_date]));?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $unit["COUNT(id)"];?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><span class="contenttext" style="padding-left:5px;"><?php echo $unit1["units"];?></span></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><span class="contenttext" style="padding-left:5px;"><?php echo $over;?></span></td>
                  <?php
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>
<script type="text/javascript">
window.print();
</script>
