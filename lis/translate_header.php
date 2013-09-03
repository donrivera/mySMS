<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$page = $parts[count($parts) - 1];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" ></td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul>
        <li><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
                 
        <li><a href="student_manage.php" title="Quick Add" rel=""><span <?php echo $mystyle;?>><?php echo constant("SA_MENU_QUICKADD");?></span></a></li>
        <?php
	  $mystyle = '';
	  if($page == "s1.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Students" rel="rpt_student"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <li><a href="search.php" title="Search"><span><?php echo constant("RE_MENU_SEARCH");?></span></a></li>
        <li><a href="#" title="Groups" rel="rel_group"><span><?php echo constant("RE_MENU_GROUPS");?></span></a></li>
        <li><a href="#" title="Reports" rel="rpt_report"><span><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page == "translate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Converter" rel="conv"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
        
        <li><a href="#" title="Help"><span><?php echo constant("RE_MENU_HELP");?></span></a></li>
        <li><a href="alert.php" title="Alerts"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="sms.php" title="SMS"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
		<li><a href="email.php" title="email"><span><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        <li><a href="centre_schedule.php" title="Centre Schedule"><span><?php echo constant("RE_MENU_CS");?></span></a></li>
        <li><a href="ped.php" title="ePEDCARD" rel=""><span><?php echo constant("TE_MENU_EPEDCARD");?></span></a></li>
        <li><a <?php echo $mystyle;?> href="report_teacher_progress.php" title="Progress Reports"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PR");?></span></a></li>
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        <li><a href="certificate.php" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>"><span><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        <li><a href="#" title="preferences" rel="prefer"><span><?php echo constant("TE_MENU_PRE");?></span></a></li>        
      </ul>
    </div>
    
    <br style="clear: left;" />
    <br class="IEonlybr" />
	  
    <div id="conv" class="dropmenudiv_d">
        <a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
        <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
    </div>
      
	<!--RSeport drop down menu -->                                                   
	<div id="rpt_report" class="dropmenudiv_d">
        <a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a>
        <a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
        
        <a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
        <a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a>
        <a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>
        <a href="report_teacher_leave_report.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?></a>
        <a href="report_teacher_capacity.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");?></a>
        <a href="report_freq_customer_report.php"><?php echo constant("ADMIN_MENU_REPORTS_CUSTOMER");?></a>
        <a href="report_student_group_grade.php"><?php echo constant("ADMIN_MENU_REPORTS_GROUP_GRADE");?></a>
        <a href="report_student_not_enrolled.php"><?php echo constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");?></a>
        <a href="report_student_on_hold.php"><?php echo constant("ADMIN_MENU_REPORTS_ON_HOLD");?></a>
        <a href="arf_manage.php"><?php echo constant("SA_MENU_ARF_REPORTS");?></a>
	</div>
     
    <!-- grouping -->
    <div id="rel_group" class="dropmenudiv_d">
        <a href="group_course.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
        <a href="group_manage.php"><?php echo constant("SA_MENU_GROUP");?></a>
        <!--<a href="slot_manage.php"><?php //echo constant("SA_MENU_TIME_SLOT");?></a>-->
        <a href="view_group_size.php"><?php echo constant("SA_MENU_GROUP_SIZE");?></a>
    </div>
     
	<!--student drop down menu -->
    <div id="rpt_student" class="dropmenudiv_d"> 
        <a href="s_age.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
        <a href="s_classic.php"><?php echo constant("SA_MENU_CLASSIC");?></a>
        <a href="s_manage.php"><?php echo constant("SA_MENU_STUDENT_DETAILS");?></a>
        <a href="student_appoint_manage.php"><?php echo constant("SA_MENU_APPOINT");?></a>
	</div>
     <!--Links drop down menu -->
    <div id="mnu_rel" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('links',"stu_ad='1'","id") as $val) {
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
