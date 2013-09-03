<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <thead>
    <tr class="pedtext">
      <td align="center" valign="middle" bgcolor="#CCCCCC" >&nbsp;</td>
      <td align="left" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
    </tr>
    <tr class="pedtext">
      <td width="7%" align="center" valign="middle" bgcolor="#CCCCCC" ><input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
      <td width="32%" align="left" valign="middle" bgcolor="#CCCCCC" ><input name="fname" type="text" class="new_textbox100" id="fname" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="19%" align="left" valign="middle" bgcolor="#CCCCCC" ><input name="stid" type="text" class="new_textbox100" id="stid" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="20%" align="left" valign="middle" bgcolor="#CCCCCC"><input name="mobile" type="text" class="new_textbox100" id="mobile" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="22%" align="left" valign="middle" bgcolor="#CCCCCC" ><input name="email" type="text" class="new_textbox100" id="email" autocomplete="off" onkeyup="show_student_detail();"/></td>
    </tr>
    <tr class="pedtext">
      <td colspan="5" align="center" valign="middle" id="lblstudentdtls" >
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;" class="tablesorter" bordercolor="#AAAAAA">
                <?php
                    $i = 1;
                    $color="#ECECFF";
                    //studentstatus_id='6' Means "Enrolled"
                    // Which students are Not Enrolled for Particular Course
					
                    //Get group details
                    $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
                    
                    $num = $dbf->countRows('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')");
                    
					foreach($dbf->fetchOrder('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')","s.first_name","s.*") as $vals){
                    
                    ?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                  <td width="7%" height="25" align="center" valign="middle"  class="contenttext" >
                  <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
                  <td width="32%" height="25" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
                  <td width="19%" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
                  <td width="20%" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
                  <td width="22%" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
                  <?php
                      $i = $i + 1;
                      }
                      ?>
                      <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
                </tr>
               
            </table>
      </td>
      </tr>
    </thead>
    </table>
<?php } else{?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <thead>
    <tr class="pedtext">
      <td align="right" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC" >&nbsp;</td>
    </tr>
    <tr class="pedtext">
    	<td width="22%" align="right" valign="middle" bgcolor="#CCCCCC" ><input name="email" type="text" class="new_textbox100_ar" id="email" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="20%" align="right" valign="middle" bgcolor="#CCCCCC"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="19%" align="right" valign="middle" bgcolor="#CCCCCC" ><input name="stid" type="text" class="new_textbox100_ar" id="stid" autocomplete="off" onkeyup="show_student_detail();"/></td>
            <td width="32%" align="right" valign="middle" bgcolor="#CCCCCC" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" autocomplete="off" onkeyup="show_student_detail();"/></td>
      <td width="7%" align="center" valign="middle" bgcolor="#CCCCCC" ><input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
    </tr>
    <tr class="pedtext">
      <td colspan="5" align="center" valign="middle" id="lblstudentdtls" >
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;" class="tablesorter" bordercolor="#AAAAAA">
                <?php
                    $i = 1;
                    $color="#ECECFF";
                    // Which students are Not Enrolled for Particular Course
					
                    //Get group details
                    $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
                    
                    $num = $dbf->countRows('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')");
                    
					foreach($dbf->fetchOrder('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')","s.first_name","s.*") as $vals){
                    
                    ?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                  <td width="22%" align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
                  <td width="20%" align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
                  <td width="19%" align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
                  <td width="32%" height="25" align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
                  <td width="7%" height="25" align="center" valign="middle"  class="contenttext" >
                  <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
                  <?php
                      $i = $i + 1;
                      }
                      ?>
                      <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
                </tr>
               
            </table>
      </td>
      </tr>
    </thead>
    </table>
<?php }?>