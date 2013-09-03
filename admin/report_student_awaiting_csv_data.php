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
      <th width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="22%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></th>
      <th width="16%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></th>
      <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></th>
      <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
      <th width="24%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_TEXTD");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        if($_REQUEST[status]!=''){
            $cond="s.id = c.student_id And c.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3'";
        }else{
            $cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3'";
        }
                            
        //Get Number of Rows
        if($cond != ''){
            $num=$dbf->countRows('student s,student_moving c',$cond);
        }
        
        //Loop start
        foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.first_name","s.*,c.date_time") as $val){
            $course = $dbf->getDataFromTable("course", "name", "id='$_REQUEST[status]'");
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
      <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course;?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;">
      <?php if($val[date_time] != '0000-00-00 00:00:00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
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


