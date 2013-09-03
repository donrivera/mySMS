<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    <thead>
        <tr class="logintext">
          <th width="6%" height="33" align="center" valign="middle" bgcolor="#99CC99" >
            <input type="checkbox" name="chk" id="chk" onChange="checkall(this.checked);">
          </th>
          <th width="32%" align="left" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-left:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
          <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-left:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></th>
          <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-left:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?> </th>
          <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-left:5px;"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?> </th>
          </tr>
        </thead>
		<?php
            $i = 1;            
            //studentstatus_id='6' Means "Enrolled"            
            $num=$dbf->countRows('student s,student_course c',"s.id=c.student_id AND s.studentstatus_id='6' AND s.certificate_collect='0' AND c.course_id='$_REQUEST[course]'");
            
            foreach($dbf->fetchOrder('student s,student_course c',"s.id=c.student_id AND s.studentstatus_id='6' AND s.certificate_collect='0' AND c.course_id='$_REQUEST[course]'","first_name","s.*") as $vals){
                
            //Get course Name
            $valc = $dbf->strRecordID("common","*","id='$vals[studentstatus_id]'");            
            ?>
        <tr>
          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>"></td>
          <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?></td>
          <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
    <?php } else{?>
	<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    <thead>
        <tr class="logintext">
         <th width="22%" align="right" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-right:5px;"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?> </th>
         <th width="21%" align="right" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-right:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?> </th>
          <th width="19%" align="right" valign="middle" bgcolor="#99CC99" class="menutext"  style="padding-right:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></th>
            <th width="32%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
         
          <th width="6%" height="33" align="center" valign="middle" bgcolor="#99CC99" >
            <input type="checkbox" name="chk" id="chk" onChange="checkall(this.checked);">
          </th>
        
          
          </tr>
        </thead>
		<?php
            $i = 1;            
            //studentstatus_id='6' Means "Enrolled"            
            $num=$dbf->countRows('student s,student_course c',"s.id=c.student_id AND s.studentstatus_id='6' AND s.certificate_collect='0' AND c.course_id='$_REQUEST[course]'");
            
            foreach($dbf->fetchOrder('student s,student_course c',"s.id=c.student_id AND s.studentstatus_id='6' AND s.certificate_collect='0' AND c.course_id='$_REQUEST[course]'","first_name","s.*") as $vals){
                
            //Get course Name
            $valc = $dbf->strRecordID("common","*","id='$vals[studentstatus_id]'");            
            ?>
        <tr>
        <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-right:5px;"><?php echo $vals[email];?></td>
           <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-right:5px;"><?php echo $vals[student_mobile];?></td>
           <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-right:5px;"><?php echo $vals[student_id];?></td>
           <td height="25" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-right:5px;"><?php echo $vals[first_name];?></td>
          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>"></td>
          
          
       
          
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
    <?php }?>