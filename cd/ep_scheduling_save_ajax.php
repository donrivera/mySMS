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
        <tr>
          <td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
          <td width="18%" height="30" align="right" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><?php echo constant("RECEPTION_GROUP_MANAGE_CLASSROOM");?> : <span class="nametext1">*</span></td>
          <td width="75%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
        	<select name="room_id" id="room_id" style="width:80px; border:solid 1px; border-color:#FFCC00;" class="validate[required]" >
              <option value="">&nbsp;Room&nbsp;&nbsp;</option>
              <?php
                 foreach($dbf->fetchOrder('centre_room',"centre_id='$_SESSION[centre_id]'","no") as $res_room) {
                  ?>
              <option value="<?php echo $res_room['id']?>"> <?php echo $res_room['name'];?></option>
              <?php }?>
            </select>
          
          </td>
        </tr>
       
    </table>
<br />

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="78%" height="30" align="center" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
      <td width="22%" height="30" align="left" valign="middle" bgcolor="#FFFFFF"style="padding-left:5px;">
      <div id="idsave" style="display:none">
      <input name="submit" id="submit" value="submit" type="image" src="../images/save_btn.png"/>
      </div>
      </td>
    </tr>
</table>
<?php } else{?>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
        <tr>
          <td width="75%" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
        	<select name="room_id" id="room_id" style="width:80px; border:solid 1px; border-color:#FFCC00;" class="validate[required]" >
              <option value=""><?php echo constant("ROOM");?>&nbsp;&nbsp;</option>
              <?php
                 foreach($dbf->fetchOrder('centre_room',"centre_id='$_SESSION[centre_id]'","no") as $res_room) {
                  ?>
              <option value="<?php echo $res_room['id']?>"> <?php echo $res_room['name'];?></option>
              <?php }?>
            </select>
          
          </td>
          <td width="18%" height="30" align="right" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_GROUP_MANAGE_CLASSROOM");?></td>
          <td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
  </tr>
       
</table>
<br />

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      
      <td width="22%" height="30" align="right" valign="middle" bgcolor="#FFFFFF"style="padding-left:5px;">
      <div id="idsave" style="display:none">
      <input name="submit" id="submit" value="submit" type="image" src="../images/save_btn.png"/>
      </div>
      </td>
      <td width="78%" height="30" align="center" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
    </tr>
</table>
<?php }?>