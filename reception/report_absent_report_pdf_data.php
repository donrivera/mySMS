<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="2%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_LEVEL");?></th>
      <th width="7%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></th>
      <th width="13%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME");?></th>
      <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_MOBILENO");?></th>
      <th width="17%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_LASTATTAND");?></th>
      <th colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT");?></th>
    </tr>
    </thead>
    <?php
        $centre_id = $_REQUEST["centre_id"];
        $condition = '';
        //Concate the Condition
        //1.
        if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "email LIKE '$_REQUEST[email]%'  And centre_id='$centre_id'";
        }
        //End 1.
        
        //2.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$centre_id'";
        }
        //End 2.
        
        //3.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }
        //End 3.
        
        //4.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "id>'0' And centre_id='$centre_id'";
        }
        //End 4.
        
        $i = 1;
        $color="#ECECFF";
        
        //Get Number of Rows
        $num=$dbf->countRows('student', $condition);					
        //loop start
        foreach($dbf->fetchOrder('student', $condition ,"first_name") as $val) {
        
        //Get Course
        $g = $dbf->strRecordID("student_group_dtls","*","student_id='$val[id]'");
        
        $course = $dbf->strRecordID("course","*","id='$g[course_id]'");
        
        //Get Total Absent
        $res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
        $countid = $res_max["COUNT(id)"];
        
        //Get Last Attendance
        $res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
        $maxid = $res_max["MAX(id)"];
        
        $reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
        $resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
        
        //Get Name Of Groups
        $res = $dbf->strRecordID("student","*","id='$resp[student_id]'");
        $res2 = $dbf->strRecordID("common","*","id='$resp[group_id]'");
        
        //Get Name Of Teacher
        $res3 = $dbf->strRecordID("teacher","*","id='$resp[teacher_id]'");
        
        if($countid>0) {
        ?>
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td height="25" align="center" valign="middle" class="mycon">&nbsp;</td>
      <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
      <td height="30" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res2[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res3[name];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[student_mobile];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[email];?></td>
      <?php
      $last = '';
      if($reslast["unit"] > 0){
            $last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
      }
      ?>
      <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $last;?></td>
      <td width="11%" align="center" valign="middle" bgcolor="#F8F9FB"><?php echo $countid;?></td>
      <?php
			  $i = $i + 1;
			  if($color=="#ECECFF"){
				  $color = "#FBFAFA";
			  }else{
				  $color="#ECECFF";
			  }          
		}
		}
    ?>
    </tr>
</table>