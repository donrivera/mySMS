<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$qry = $_SERVER['QUERY_STRING'];
if($qry != '') { $page = $parts[count($parts) - 1].'?'.$qry; }else{ $page = $parts[count($parts) - 1];}
$page = base64_encode($page);
$page_name = $parts[count($parts) - 1];
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
        <td colspan="2" align="center" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" style="display:'';">
          <tr>
            <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_BIGGER");?></b></a></td>
            <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_RESET");?></b></a></td>
            <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_SMALLER");?></b></a></td>
          </tr>
        </table></td>
        <td width="12%" align="right" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?> :</td>
        <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
        <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"  ><div id="glowmenu" class="glowingtabs">
      <ul>
      <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "myschedule.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="myschedule.php" title="My schedule" rel=""><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "myaccount.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="myaccount.php" title=""><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "audit.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="audit.php" title=""><span <?php echo $mystyle;?>><?php echo constant("STUDENT_AUDITDATA");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "progress_report.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="progress_report.php" title="My Progress Reports"><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "certificate_report.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="certificate_report.php" title="<?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?>"><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="<?php echo constant("STUDENT_MENU_DATE_CONVERTER");?>"><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></li>
                
        <?php
	  $mystyle = '';
	  if($page_name == "alert.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="alert.php" title="Alerts"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="javascript:void(0);" title="" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "leave_manage.php" || $page_name == "leave_add.php" || $page_name == "leave_edit.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="leave_manage.php" title="Leave"><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_LEAVE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php" || $page_name == "sms_allowed.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="" title="" rel="prefer"><span <?php echo $mystyle;?>><?php echo constant("STUDENT_MENU_PREFERENCES");?></span></a></li>
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
            <a href="sms_allowed.php"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_SMSGATEWAYCONFIGURATION");?></a>
		</div>
      	<script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
