<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
      <th width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" >&nbsp;</th>
      <th width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
      <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
      <th width="41%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
      <th width="33%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></th>
      <th width="7%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_STATUS");?></th>
      </tr>
  </thead>
  <?php
    $k=1;
    $i = 1;
    $color = "#ECECFF";
                            
    //Loop start
    foreach($dbf->fetchOrder('student', "centre_id='$_REQUEST[centre_id]'","","") as $valstudent){
    
	$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$valstudent[id]'");
	$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
	$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
	
    $total_course_fees = 0;
    foreach($dbf->fetchOrder('student_group_dtls', "student_id='$valstudent[id]'","","") as $dtls){						
        $total_course_fees = $total_course_fees + $dbf->BalanceAmount($dtls["student_id"],$dtls["course_id"]);						
    }
    
    if($total_course_fees < 0){									
    ?>
  <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
    <td width="4%" height="25" align="center" valign="middle" class="contenttext">&nbsp;</td>
    <td width="5%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
    <td width="10%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[first_name];?></td>
    <td width="41%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[email];?></td>
    <td width="33%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[student_mobile];?></td>
    <td width="7%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $moving["name"];?></td>
    <?php
      $i = $i + 1;
      if($color=="#ECECFF"){
          $color = "#FBFAFA";
      }else{
          $color="#ECECFF";
      }
  ?>
  </tr>
  <?php
    $k++;
    }
    $total_course_fees = 0;
}
?>
</table>