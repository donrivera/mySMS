<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
		$parts = Explode('/', $currentFile);
		$page = $parts[count($parts) - 1];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"></td>
        <td width="44%">&nbsp;</td>
        <td width="6%" align="right"></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td width="32%" align="right"></td>
        <td colspan="2" align="right" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="right" style="display:'';">
          <tr>
            <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b>Bigger</b></a></td>
            <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b>Reset</b></a></td>
            <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b>Smaller</b></a></td>
          </tr>
        </table></td>
        <td width="12%" align="right" valign="middle" class="sl_text"><?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?> :</td>
        <?php
		$currentFile = $_SERVER["PHP_SELF"];
		$parts = explode('/', $currentFile);
		$page = $parts[count($parts) - 1];
		?>
        <td width="2%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/arabia.png" alt="Arabic" width="18" height="18" border="0" title="Arabic"/></a></td>
        <td width="4%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="18" height="18" border="0" title="English" /></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" ><div id="glowmenu" class="glowingtabs">
      <ul>
        <li><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        <li><a href="myschedule.php" title="My schedule" rel=""><span><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></span></a></li>
        <li><a href="myaccount.php" title=""><span><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></li>
        <?php
	  $mystyle = '';
	  if($page == "audit.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="audit.php" title=""><span <?php echo $mystyle;?>><?php echo constant("STUDENT_AUDITDATA");?></span></a></li>
        <li><a href="progress_report.php" title="My Progress Reports"><span><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></span></a></li>
        <li><a href="certificate_report.php" title="Certificates Grade"><span><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?></span></a></li>
        <li><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></li>
                
        <li><a href="alert.php" title="Alerts"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="#" title="" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        <li><a href="leave_manage.php" title="Leave"><span><?php echo constant("STUDENT_MENU_LEAVE");?></span></a></li>
        <li><a href="" title="" rel="prefer"><span><?php echo constant("STUDENT_MENU_PREFERENCES");?></span></a></li>
      </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />
		 <div id="mnu_rel" class="dropmenudiv_d">
		<?php
		foreach($dbf->fetchOrder('links',"student='1'","id") as $val) {
		?>
			<a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
		<?php } ?>
		</div>
		
        <!--preference drop down menu -->
        <div id="prefer" class="dropmenudiv_d"> 
            <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
            <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
		</div>
      <script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
