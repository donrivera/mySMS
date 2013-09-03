<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
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
header("Content-Disposition: attachment; Filename=report_outstanding_report.doc");
?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
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
														
					//loop start
					foreach($dbf->fetchOrder('teacher_vacation',"status='0'","frm") as $val_leave) {
						$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'")
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
<br>
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
        $num=$dbf->countRows('sick_leave',"");
        
        //loop start
        foreach($dbf->fetchOrder('sick_leave',"sick_status='0'","from_date") as $val_leave) {
            $teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'")
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $val_leave[from_date];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[from_date];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[to_date];?></td>
      <td align="left" valign="middle" class="mycon"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_SICKLV");?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave["sick_reason"];?></td>
      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><a href="../teacher/sickleave/<?php echo $val_leave[sick_attachment];?>" target="_blank" style="text-decoration:none;"> <?php echo $val_leave[sick_attachment];?></a></td>
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