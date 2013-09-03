<?php
ob_start();
session_start();


include_once '../includes/class.Main.php';


//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
    <tr class="logintext">
      <th width="6%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="55%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></th>
      <th width="19%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALTEACH");?></th>
      <th width="18%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALCONTRA");?></th>
      </tr>
    </thead>
    <?php			
        $i = 1;
        $color="#ECECFF";
        $centre_id = $_REQUEST["centre_id"];
        $num=$dbf->countRows('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'");
        foreach($dbf->fetchOrder('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'","","u.*") as $val) {
            
            # Get Teacher details
            $res_teacher = $dbf->strRecordID("teacher", "*", "id='$val[uid]'");
            
            //Get the total units from the E-PED unit table of a particular teacher
            $res_unit = $dbf->strRecordID("ped_attendance","COUNT(unit)","teacher_id='$val[uid]' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
      <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["name"];?></td>
      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_unit["COUNT(unit)"];?></td>
      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["unit"];?></td>
      <?php
      $i = $i + 1;
       if($color=="#ECECFF")
          {
              $color = "#FBFAFA";
          }
          else
          {
              $color="#ECECFF";
          }      
      }
      ?>
    </tr>
</table>