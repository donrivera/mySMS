<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=report_freq_customer_report.doc");
?>
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
    <th width="2%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
    <th width="23%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
    <th width="16%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_FREQ_CUSTOMER_REPORT_EMAILADDRESS");?></th>
    <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_FREQ_CUSTOMER_REPORT_PHONENO");?></th>
    <th width="26%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_FREQ_CUSTOMER_REPORT_COURSESATTENDED");?></th>
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
    
    $num = 0;
    
    foreach($dbf->fetchOrder('student s', $condition ,"s.first_name") as $faq) {				
    
    $is_multi = $dbf->countRows("student_enroll", "student_id='$faq[id]'");
    
    foreach($dbf->fetchOrder('student_enroll',"student_id='$faq[id]'","") as $valc){							
        $c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
        if($course == ''){
            $course  = $c[name];
        }else{
            $course  = $course.",".$c[name];
            $num++;
        }
    }
    if($is_multi > 1){
    ?> 
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
    <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
    <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $faq["first_name"];?></td>
    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $faq["email"];?></td>
    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $faq["student_mobile"];?></td>
    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course;?></td>
    <?php
          $i = $i + 1;
          if($color=="#ECECFF"){
              $color = "#FBFAFA";
          }else{
              $color="#ECECFF";
          }
    }
    $course = '';
    ?>
    </tr>
    <?php } ?>
</table>