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
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#AAAAAA" style="border-collapse:collapse;" class="tablesorter">
	<thead>
    <tr class="pedtext">
      <th width="6%" align="center" valign="middle" ><?php echo constant("STUDENT_MYACCOUNT_SL");?></th>
      <th width="28%" align="left" valign="middle" style="padding-left:5px;"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
      <th width="12%" align="left" valign="middle" style="padding-left:5px;"><?php echo constant("RECEPTION_SEARCH_STUDENTID");?></th>
      <th width="23%" align="left" valign="middle" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?> </th>
      <th width="18%" align="left" valign="middle" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?> </th>
      <th width="13%" align="center" valign="middle" ><?php echo constant("CD_EP_CHANGE_CLASSROOM_CURRENTROOM");?></th>
      </tr>
       </thead>
		<?php
            $i = 1;
            $color="#ECECFF";
            //studentstatus_id='6' Means "Enrolled"
            
            $num=$dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
			
			$val_room = $dbf->strRecordID("centre_room","*","id='$valg[room_id]'");
            
            ?>
        <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
          <td height="25" align="center" valign="middle"  class="contenttext"><?php echo $i;?>
          <input type="hidden" name="student_id<?php echo $i;?>" id="student_id<?php echo $i;?>" value="<?php echo $valg[student_id];?>" />
          </td>
          <td height="25" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <td align="center" valign="middle"  class="contenttext" ><?php echo $val_room["name"];?></td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
    <br />
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    <tr class="pedtext">
    <?php
    $resg = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
	?>
      <td width="12%" align="center" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("CD_EP_CHANGE_CLASSROOM_SHIFTEDTO");?> </td>
      <td width="88%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" style="padding-left:5px;border-left:solid 1px;">
    <select name="room_id" id="room_id" style="width:80px; border:solid 1px; border-color:#FFCC00;">
      <option value="">&nbsp;&nbsp;Room&nbsp;&nbsp;</option>
      <?php
        foreach($dbf->fetchOrder('centre_room',"id<>'$resg[room_id]' AND centre_id='$_SESSION[centre_id]'","","*") as $ress){
      ?>
      <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
      <?php }?>
    </select>
    </td>
    </tr>
    </table>
<?php } else{?>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#AAAAAA" style="border-collapse:collapse;" class="tablesorter">
	<thead>
    <tr class="pedtext">
      <th width="13%" align="center" valign="middle" ><?php echo constant("CD_EP_CHANGE_CLASSROOM_CURRENTROOM");?></th>
      <th width="18%" align="right" valign="middle" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?> </th>
      <th width="23%" align="right" valign="middle" style="padding-left:5px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?> </th>
      <th width="12%" align="right" valign="middle" style="padding-left:5px;"><?php echo constant("RECEPTION_SEARCH_STUDENTID");?></th>
      <th width="28%" align="right" valign="middle" style="padding-left:5px;"><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
      <th width="6%" align="center" valign="middle" ><?php echo constant("STUDENT_MYACCOUNT_SL");?></th>
      </tr>
       </thead>
		<?php
            $i = 1;
            $color="#ECECFF";
            //studentstatus_id='6' Means "Enrolled"
            
            $num=$dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'");
            
            foreach($dbf->fetchOrder('student_group g,student_group_dtls d',"g.id=d.parent_id AND g.id='$_REQUEST[group]'","d.id","d.*") as $valg)
            {
                
            //Get Student Name
            $vals = $dbf->strRecordID("student","*","id='$valg[student_id]'");
			
			$val_room = $dbf->strRecordID("centre_room","*","id='$valg[room_id]'");
            
            ?>
        <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
          <td align="center" valign="middle"  class="contenttext" ><?php echo $val_room["name"];?></td>
          <td align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <td align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td height="25" align="right" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td height="25" align="center" valign="middle"  class="contenttext"><?php echo $i;?>
          <input type="hidden" name="student_id<?php echo $i;?>" id="student_id<?php echo $i;?>" value="<?php echo $valg[student_id];?>" />
          </td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
    <br />
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
    <tr class="pedtext">
    <?php
    $resg = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
	?>
      
      <td width="88%" height="30" align="right" valign="middle" bgcolor="#CCCCCC" style="padding-right:5px;border-left:solid 1px;">
    <select name="room_id" id="room_id" style="width:80px; border:solid 1px; border-color:#FFCC00;">
      <option value="">&nbsp;&nbsp;<?php echo constant("ROOM");?>&nbsp;&nbsp;</option>
      <?php
        foreach($dbf->fetchOrder('centre_room',"id<>'$resg[room_id]' AND centre_id='$_SESSION[centre_id]'","","*") as $ress) 		{
      ?>
      <option value="<?php echo $ress['id']?>"> <?php echo $ress['name'];?></option>
      <?php }?>
    </select>
    </td>
    <td width="12%" align="center" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("CD_EP_CHANGE_CLASSROOM_SHIFTEDTO");?> </td>
  </tr>
</table>
<?php }?>