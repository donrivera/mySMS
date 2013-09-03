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
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    
        <tr class="pedtext">
          <td width="5%" height="33" align="center" valign="middle" bgcolor="#DDDBE8" >
          <input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
          <td width="34%" align="left" valign="middle" bgcolor="#DDDBE8" style="padding-left:5px;border-left:solid 1px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th></td>
          <td width="19%" align="left" valign="middle" bgcolor="#DDDBE8"  style="padding-left:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></th></td>
          <td width="21%" align="left" valign="middle" bgcolor="#DDDBE8" style="padding-left:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></th> </td>
          <td width="21%" align="left" valign="middle" bgcolor="#DDDBE8"  style="padding-left:5px;"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></th> </td>
          </tr>       
		<?php
            $i = 1;
            $color1="#ECECFF";
            //certificate_collect<>'1' Means " Certificate has not been generate "
            
            $num=$dbf->countRows('student s,student_group g,student_group_dtls d',"g.id=d.parent_id AND s.id=d.student_id And s.certificate_collect<>'1' And g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d',"g.id=d.parent_id AND s.id=d.student_id And s.certificate_collect<>'1' And g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
            
            ?>
        <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
          <td height="25" align="center" valign="middle"  class="contenttext" style="border-top:solid 1px;">
		  <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/>
          </td>
          <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
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
          <td width="21%" align="right" valign="middle" bgcolor="#DDDBE8"  style="padding-left:5px;"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></th> </td>
          <td width="21%" align="right" valign="middle" bgcolor="#DDDBE8" style="padding-left:5px;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></th> </td>
          <td width="19%" align="right" valign="middle" bgcolor="#DDDBE8"  style="padding-left:5px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></th></td>
          <td width="34%" align="right" valign="middle" bgcolor="#DDDBE8" style="padding-left:5px;border-left:solid 1px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th></td>
          <td width="5%" height="33" align="center" valign="middle" bgcolor="#DDDBE8" >
          <input type="checkbox" name="chk" id="chk" onchange="checkall(this.checked),display_save1(this.checked);" /></td>
      </tr>       
		<?php
            $i = 1;
            $color1="#ECECFF";
            //certificate_collect<>'1' Means " Certificate has not been generate "
            
            $num=$dbf->countRows('student s,student_group g,student_group_dtls d',"g.id=d.parent_id AND s.id=d.student_id And s.certificate_collect<>'1' And g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d',"g.id=d.parent_id AND s.id=d.student_id And s.certificate_collect<>'1' And g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
            
            ?>
        <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
          <td align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td height="25" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td height="25" align="center" valign="middle"  class="contenttext" style="border-top:solid 1px;">
		  <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/>
          </td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
	<?php }?>