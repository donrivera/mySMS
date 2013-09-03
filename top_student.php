<?php include_once 'includes/language.php';?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">	
<tr>
    <td width="50%" height="50" align="left" valign="middle" style="padding-top:25px;"><img src="../logo/logo.png" alt="logo" /></td>
	<td width="50%" height="39" align="right" valign="top" style="padding-right:10px;">
    
        <table width="210" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="88" height="20">&nbsp;</td>
            <td width="122" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12%" align="left" valign="middle">
                <a href="../logout_student.php" title="Logout" style="text-decoration:none">
                <span class="leftmenu"><img src="../images/logout.png" width="15" height="15" border="0" /></span></a></td>
                <td width="88%" align="left" valign="middle">
                <a href="../logout_student.php" title="Logout" style="text-decoration:none"><span class="leftmenu">&nbsp;&nbsp;<?php echo constant("LOGOUT");?> </span></a></td>
              </tr>
            </table>
            
            </td>
          </tr>
          <tr>
            <td class="leftmenu" align="left"><?php echo constant("WELCOME");?> : </td>
            <td align="left" valign="middle"><span class="nametext1">
			<?php
			echo $_SESSION[students_user_name];
			?>
            </span></td>
          </tr>
      </table>
</td>
</tr>
    </table>
	