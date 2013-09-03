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

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>	

<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
                <tr class="logintext">
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
                  <th width="22%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_IDNUMBER");?>  </th>
                  <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME");?> </th>
                  <th width="15%" align="center" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_PERCENT");?>  </th>
                  <th width="27%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"><?php echo constant("CD_REPORT_CERTIFICATE_REPORT_CSV_DATA_GRSTARTEND");?> </th>
                  </tr>
				  </thead>
                 <?php
					if($_REQUEST[cmbgroup]!=""){
						$cond="g.id=d.parent_id And s.id=d.student_id And g.id='$_REQUEST[cmbgroup]'"; //certificate_collect='0' And 
					}
										
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					if($cond!=''){
						
						$num=$dbf->countRows('student s,student_group g,student_group_dtls d', $cond);
						
						//Loop Start
						foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d', $cond,"s.first_name","s.*") as $val){
						
							//Get Student Name
							$ress = $dbf->strRecordID("student","*","id='$res[student_id]'");
							
						   //Get the Group Name
							$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
							
							//Get the Group Name
							$group = $dbf->strRecordID("common","*","id='$_REQUEST[cmbgroup]'");
							
							//Get Percentage from teacher_progress_certificate Table
							$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$res_group[course_id]' And student_id='$val[id]'");					
							$percentage = $res_per[final_percent];
					?>
                <tr>
                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $i;?></td>
                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[first_name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_id];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $res_group[group_name];?> <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></td>
                  <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><span class="contenttext" style="padding-left:5px;"><?php echo $percentage;?></span>%</td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $res_group[start_date] ." / ". $res_group[end_date];?></td>
                  <? $i = $i + 1;
				  }
					  }
					  ?>
                </tr>
            </table>
<script type="text/javascript">
window.print();
</script>
           