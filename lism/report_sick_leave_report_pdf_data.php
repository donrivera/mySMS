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
      <th width="3%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="17%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
      <th width="10%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVEFROM");?></th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVETO");?></th>
      <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("LIS_LEAVE_TYPE");?></th>
      <th width="34%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
      <th width="8%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        //Get Number of Rows
        $num=$dbf->countRows('teacher_vacation',"teacher_id='$_REQUEST[teacher_id]'");
        
        //loop start
        foreach($dbf->fetchOrder('teacher_vacation',"teacher_id='$_REQUEST[teacher_id]'","frm") as $val_leave) {
            $teacher = $dbf->strRecordID("teacher","*","id='$_REQUEST[teacher_id]'")
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $val_leave[frm];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[frm];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[tto];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[type];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"></td>
      <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"> - </td>
      <?php
          $i = $i + 1;
          if($color=="#ECECFF"){
              $color = "#FBFAFA";
          }else{
              $color="#ECECFF";
          }					  
      }
      ?>
    </tr>
</table>