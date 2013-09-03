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
//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_teacher_leave_report.doc");

?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">





<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">
                  <th width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
                  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" class="menutext"><span class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></span></th>
                  <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE");?>  </th>
                  <th width="30%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_ENDDATE");?>  </th>
                  <th width="32%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#6a6868;font-weight:bold;"  > <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_GROUPAFFECTED");?> </th>
                  </tr>
				  </thead>
               <?php
					
					if($_REQUEST[teacher]!='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]' And (frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]=='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="(frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]!='' && $_REQUEST[start_date]=='' && $_REQUEST[end_date]=='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]'";
					}
					else
					{
					 $cond="";
					}

					$i = 1;
					$num=$dbf->countRows('teacher_vacation',$cond);
					
					foreach($dbf->fetchOrder('teacher_vacation',$cond,"id DESC") as $val) {
					
					$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
		
					?>
                <tr>
                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><?php echo $i;?></span></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[name];?></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[frm];?></span></td>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $val[tto];?></span></td>
				  <?php if($val[group_affect]==0)
				        {
				       $affect='NO';
					     }
						else
						{
						$affect='YES';
						} 
						?>
                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#000000;padding-left:3px;"><?php echo $affect;?></td>
                  <? 
					  $i = $i + 1;
					  }
					  ?>
                </tr>
            </table>