<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

include_once '../includes/language.php';

//Object initialization
$dbf = new User();
?>
<style>
.btn2{
background:url(../images/btn22.png) no-repeat;
width:165px;
height:25px;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
.btn1{
background:url(../images/btn1.png) no-repeat;
width:165px;
height:25px;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
</style>
<?php if($_REQUEST[group]!='')
{
?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="78%" height="30" align="center" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
      <td width="22%" height="30" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:5px;">
      <div id="idsave" style="display:none">
      
      <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_withdraw");?>" class="btn1"/>
      </div>
      </td>
    </tr>
</table>
<?php } else{?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="22%" height="30" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:5px;">
      <div id="idsave" style="display:none">
      <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_withdraw");?>" class="btn2"/>
      </div>
      </td>
      <td width="78%" height="30" align="center" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
    </tr>
</table>
<?php }?>
<?php
}
?>