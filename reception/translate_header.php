<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="left">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" ></td>
  </tr>
  <tr >
    <td height="50" align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs" >
      <ul>
        <li><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
		<li><a href="s_manage.php" title=""><span><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <li><a href="student_appoint_manage.php" title=""><span><?php echo constant("RE_MENU_APP");?></span></a></li>
        <li><a href="search.php" title="Search"><span><?php echo constant("RE_MENU_SEARCH");?></span></a></li>
        <li><a href="group_manage.php" title=""><span><?php echo constant("RE_MENU_GROUPS");?></span></a></li>
        <li><a href="#" title="Reports" rel="rpt_report"><span><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        <li><a style="background-color:#003399; background-image:none;" href="calc_converter.php" title="Date Convertor" rel="conv" ><span style="background-color:#003399; background-image:none;"><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        <li><a href="#" title="center"><span><?php echo constant("RE_MENU_HELP");?></span></a></li>
        <li><a href="alert.php" title="Alert"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="arf_manage.php" title="ARF"><span><?php echo constant("RE_MENU_ARF");?></span></a></li>
        <li><a href="sms.php" title="SMS"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
        <li><a href="email.php" title="e-Mail"><span><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        <li><a href="centre_schedule.php" title=""><span><?php echo constant("RE_MENU_CS");?></span></a></li>
        <li><a href="news_manage.php" title="" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        <li><a href="#" title="" rel="prefer"><span><?php echo constant("STUDENT_MENU_PREFERENCES");?></span></a></li>
      </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />
		<div id="conv" class="dropmenudiv_d">
        	<a href="calc_converter.php">Date Converter</a> 
            <a href="translate.php">Language Converter</a> 
        </div>
        
	  <!--Links drop down menu -->
        <div id="mnu_rel" class="dropmenudiv_d">
		<?php
		foreach($dbf->fetchOrder('links',"rep='1'","id") as $val) {
		?>
			<a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
		<?php } ?>
		</div>
		
        <div id="conv" class="dropmenudiv_d">
        	<a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
            <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
        </div>
		
		<!-- Report drop down menu -->                                                   
		<div id="rpt_report" class="dropmenudiv_d">
			<a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a>
			<a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
			<a href="report_student_awaiting.php"><?php echo constant("ADMIN_MENU_REPORTS_AWAIT");?></a>
			<a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
			<a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a>
			<a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>			
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
