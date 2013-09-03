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
      <th width="11%" height="29" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
      <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_MOBILENUMBER");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_EMAIL");?></th>
      <th width="7%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_ENQDATE");?></th>
      <th width="13%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_LASTCOMMENT");?></th>
      <th width="16%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
      <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_COURSEWASP");?></th>
      <th align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">
     <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_DATEOF");?></th>
       <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">
       <?php echo constant("ADMIN_REPORT_STUDENT_ON_HOLD_LASTCHAPTED");?></th>
    </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        $centre_id = $_SESSION["centre_id"];
        $condition = '';
        //Concate the Condition
        //1.
        if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "s.student_id LIKE '$_REQUEST[stid]%'  And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "s.email LIKE '$_REQUEST[email]%'  And s.centre_id='$centre_id'";
        }
        //End 1.
        
        //2.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'  And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }
        //End 2.
        
        //3.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }
        //End 3.
        
        //4.
        else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
            $condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.centre_id='$centre_id'";
        }else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
            $condition = "s.id>'0' And s.centre_id='$centre_id'";
        }
        //End 4.
        
        $condition = $condition." And s.id = m.student_id And m.status_id='6'";
        
        $num=$dbf->countRows('student s,student_moving m', $condition);
        foreach($dbf->fetchOrder('student s,student_moving m', $condition , "", "m.*") as $val1) {
            
            $val = $dbf->strRecordID("student","*","id='$val1[student_id]'");
            if($val[register_date] == '0000-00-00'){
                $dt = '';
            }else{
                $dt = date('d-M-Y',strtotime($val[register_date]));
            }
            
            //get current course of the student
            $grp = $dbf->strRecordID("student_group g,student_group_dtls d","g.*","g.id=d.parent_id And g.status<>'Completed' And d.student_id='$val1[student_id]'");
            
            //get course name
            $course = $dbf->strRecordID("course","*","id='$grp[course_id]'");
        ?>                    
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val["first_name"];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dt;?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_comment];?></td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
      <td width="11%" align="left" valign="middle" class="mycon" style="padding-left:5px;">&nbsp;</td>
      <td align="left" valign="middle" class="mycon" style="padding-left:5px;">&nbsp;</td>
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