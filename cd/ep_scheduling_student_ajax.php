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
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php if($_SESSION[lang]=="EN"){?>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    
        <tr class="pedtext">
          <td width="7%" height="33" align="center" valign="middle" bgcolor="#DDDDDD" >
          <input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
          <td width="32%" align="left" valign="middle" bgcolor="#DDDDDD" style="padding-left:5px;border-left:solid 1px;"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
          <td width="19%" align="left" valign="middle" bgcolor="#DDDDDD"  style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?></td>
          <td width="20%" align="left" valign="middle" bgcolor="#DDDDDD" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> </td>
          <td width="22%" align="left" valign="middle" bgcolor="#DDDDDD"  style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?> </td>
          </tr>
       
		<?php
            $i = 1;
            
            //studentstatus_id='6' Means "Enrolled"
            
            $num=$dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
            
            ?>
        <tr>
          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
          <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
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
    
        <tr class="pedtext">          
          <td width="22%" align="right" valign="middle" bgcolor="#DDDDDD"  style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?> </td>
          <td width="20%" align="right" valign="middle" bgcolor="#DDDDDD" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> </td>
          <td width="19%" align="right" valign="middle" bgcolor="#DDDDDD"  style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?></td>
          <td width="32%" align="right" valign="middle" bgcolor="#DDDDDD" style="padding-left:5px;border-left:solid 1px;"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
          <td width="7%" height="33" align="center" valign="middle" bgcolor="#DDDDDD" >
          <input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
  </tr>
       
		<?php
            $i = 1;
            
            //studentstatus_id='6' Means "Enrolled"
            
            $num=$dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
            
            ?>
        <tr>
          <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td height="25" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
</table>
<?php }?>    