<?php
include_once 'includes/language.php';

if($_SESSION["lang"] == "EN"){
	$logo = "../logo/logo.png";
}else{
	$logo = "../logo/logo-ar.png";
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left" valign="top"><table width="210" border="0" cellspacing="0" cellpadding="0" style="padding-right:10px;">
      <tr>
        <td width="132" height="20" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80%" align="right" valign="middle"><a href="../logout.php" title="Logout" style="text-decoration:none"><span class="leftmenu">&nbsp;&nbsp;<?php echo constant("LOGOUT");?></span></a></td>
            </tr>
        </table></td>
        <td width="78" align="left" valign="middle"><a href="../logout.php" title="Logout" style="text-decoration:none">&nbsp;&nbsp;<img src="../images/logout.png" width="15" height="15" border="0" /></a></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="leftmenu"><span class="nametext1"><?php echo $_SESSION[user_name];?></span></td>
        <td align="left" valign="middle"><span class="leftmenu">&nbsp; : <?php echo constant("WELCOME");?></span></td>
      </tr>
    </table></td>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%">&nbsp;</td>
        <td width="22%" align="right" valign="middle" style="padding-top:25px;"><img src="<?php echo $logo;?>" alt="logo" width="215" height="62" /></td>
      </tr>
    </table></td>
  </tr>
</table>