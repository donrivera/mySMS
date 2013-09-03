<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
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
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="5%" height="30" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="80%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("LIS_COUNT");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";					
					$num=$dbf->countRows('student_fees', $group);
					$days = $dbf->dateDiff($_REQUEST[start_date],$_REQUEST[end_date]);
					
					$status = $_REQUEST[status];
					
					//loop start
					for($k = 0; $k <= $days; $k++){
						if($k == 0){
							$st = $_REQUEST[start_date];
						}else{
							$st = date('Y-m-d',strtotime(date("Y-m-d", strtotime($st)) . "1 day"));
						}
						$no_stu = $dbf->countRows("ped_attendance","(shift1='$status' OR shift2='$status' || shift3='$status' OR shift4='$status' OR shift5='$status' || shift6='$status' OR shift7='$status' OR shift8='$status' || shift9='$status') And attend_date='$st'");
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon">
                  <a href="javascript:void(0);" onClick="show_details('<?php echo "kk".$k;?>');"> <span id="plusArrow<?php echo "kk".$k;?>"><img src="../images/plus.gif" border="0" /></span></a>
                  </td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $st;?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $no_stu;?></td>
                  </tr>
                <tr style="display:none;" id="<?php echo "kk".$k;?>">
                  <td align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="mycon"><table width="85%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                    <tr class="lable1">
                      <td width="4%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                      <td width="29%" height="25" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></td>
                      <td width="21%" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                      <td width="22%" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></td>
                      <td width="24%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("LIS_TOTAL_OF_STATUS");?></td>
                    </tr>
                    <?php
					  foreach($dbf->fetchOrder('ped_attendance', "(shift1='$status' OR shift2='$status' || shift3='$status' OR shift4='$status' OR shift5='$status' || shift6='$status' OR shift7='$status' OR shift8='$status' || shift9='$status') And attend_date='$st'") as $enroll_dtls) {
						  
						  //Student Name
						  $student = $dbf->strRecordID("student","*","id='$enroll_dtls[student_id]'");
						  $teacher = $dbf->strRecordID("teacher","*","id='$enroll_dtls[teacher_id]'");
						  $group = $dbf->strRecordID("student_group","*","id='$enroll_dtls[group_id]'");
						  $unit = $dbf->countRows("ped_units","material_overed<>'' And group_id='$enroll_dtls[group_id]'");
					  ?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td align="left" valign="middle">&nbsp;</td>
                      <td height="20" align="left" valign="middle">&nbsp;<?php echo $student["first_name"];?>&nbsp;(<?php echo $Arabic->en2ar($student["first_name"]);?>&nbsp;)</td>
                      <td align="left" valign="middle">&nbsp;<?php echo $teacher["name"];?></td>
                      <td align="left" valign="middle"><?php echo $group["group_name"];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?>&nbsp;</td>
                      <td align="center" valign="middle"><?php echo $unit;?>&nbsp;</td>
                    </tr>
                    <?php
					  }
					  ?>
                  </table></td>
                  </tr>  
                <?php
						$i = $i + 1;
						if($color=="#ECECFF"){
							$color = "#FBFAFA";
						}else{
							$color="#ECECFF";
						}
					}
					?>            
            </table>

<script type="text/javascript">
window.print();
</script>
