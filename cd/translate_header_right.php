<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$qry = $_SERVER['QUERY_STRING'];
if($qry != '') { $page = $parts[count($parts) - 1].'?'.$qry; }else{ $page = $parts[count($parts) - 1];}
$page = base64_encode($page);
$page_name = $parts[count($parts) - 1];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" >
    <form action="auto_search.php" method="post" name="search_frm" id="search_frm">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30" align="center" valign="middle"><a href="lang_change.php?lang=EN&amp;page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
          <td width="24" align="center" valign="middle"><a href="lang_change.php?lang=AR&amp;page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
          <td width="30" align="center" valign="middle"><input type="image" src="images/search.png" alt="add_btn" width="30" height="27" title="Search"/></td>
          <td width="10" align="left" valign="middle">&nbsp;</td>
          <td width="150" align="left" valign="middle"><div id="suggest" style="width:300px;">
            <input name="testinput" type="text" class="searchtext" id="testinput" onblur="fill(this.value);" onkeyup="suggest(this.value);" autocomplete="off" value="<?php echo $_REQUEST[testinput];?>" />
            &nbsp; : <span class="leftmenu"><?php echo constant("RE_MENU_SEARCH");?></span>
            <div style="position: absolute;left:1px;top:0px;margin: 26px 0px 0px 0px;width: 230px;padding:0px;background-color:#C8C8C8;border-top: 3px solid #C8C8C8;color: #fff;
	text-align:left;display:none;" id="suggestions">
              <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
            </div>
          </div></td>
          <td width="60" align="left" valign="middle"></td>
          <td width="5" align="left" valign="middle">&nbsp;</td>
          <td align="left" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="left" style="display:'';">
            <tr>
              <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_BIGGER");?></b></a></td>
              <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_RESET");?></b></a></td>
              <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_SMALLER");?></b></a></td>
            </tr>
          </table></td>
          <td align="left" valign="middle">&nbsp;</td>
          <td align="left" valign="middle">&nbsp;</td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="right" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul style="float:right;">
        <li><a href="home.php" title="Home"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        <li><a href="student_manage.php" title="Quick Add" ><span><?php echo constant("SA_MENU_QUICKADD");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page == "s1.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Students" rel="rpt_student"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <li><a href="search.php" title="Search"><span><?php echo constant("RE_MENU_SEARCH");?></span></a></li>
        <li><a href="#" title="Grouping" rel="rel_group"><span><?php echo constant("RE_MENU_GROUPS");?></span></a></li>        
        
        <?php
	  $mystyle = '';
	  if($page_name == "translate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Date Convertor" rel="conv"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        <li><a href="#" title="Help"><span><?php echo constant("RE_MENU_HELP");?></span></a></li>
        <li><a href="alert.php" title="Alert"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="sms.php" title="SMS"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
		<li><a href="email.php" title="email"><span><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        <li><a href="#" title="Centre Schedule" rel="mnu_centre_sch"><span><?php echo constant("RE_MENU_CS");?></span></a></li>
		<li><a href="#" title="Report" rel="rpt_progress_report"><span><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        <li><a href="#" title="E. Proc" rel="e_proc"><span><?php echo constant("CD_MENU_EPROC");?></span></a></li>
		<li><a href="#" title="Leave Vacation" rel="vacation" ><span><?php echo constant("CD_MENU_LEAVE_VACATION");?></span></a></li>
        <li><a href="#" title="Preferences" rel="prefer"><span><?php echo constant("TE_MENU_PRE");?></span></a></li>
      </ul>
    </div>
	
    <br style="clear: left;" />
        <br class="IEonlybr" />
        
        <div id="conv" class="dropmenudiv_d">
        	<a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
        	<a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a>
        </div>
        <div id="vacation" class="dropmenudiv_d">
        	<a href="vacation_center_manage.php"><?php echo constant("ADMIN_MENU_VAC_CENTRE");?></a>
            <a href="vacation_exam_manage.php"><?php echo constant("ADMIN_MENU_VAC_EXAM");?></a>
            <a href="vacation_teacher_manage.php"><?php echo constant("ADMIN_MENU_VAC_TEACHER");?></a>
            <a href="sick_leave_manage.php"><?php echo constant("CD_MENU_MANAGE_SICK_LEAVE");?></a>
        </div>
        <div id="mnu_centre_sch" class="dropmenudiv_d">
        	<a href="centre_schedule.php"><?php echo constant("CD_MENU_V_GANTT");?></a>
            <a href="centre_schedule_teacher.php"><?php echo constant("CD_MENU_V_TABLE_TEACHER");?></a>
            <a href="centre_schedule_table.php"><?php echo constant("CD_MENU_V_TABLE_LEVEL");?></a>
            <a href="centre_schedule_startdate.php"><?php echo constant("CD_MENU_V_START");?></a>
            <a href="centre_schedule_enddate.php"><?php echo constant("CD_MENU_V_END");?></a>
			<a href="centre_schedule_rangedate.php"><?php echo constant("CD_MENU_V_RANGE");?></a>
        </div>
        
        <div id="e_proc" class="dropmenudiv_d">
        	<a href="ep_removing_student.php"><?php echo constant("CD_MENU_REMOVE");?></a>
            <?php //if(date("D") == "Thu") {?>
            <a href="ep_scheduling_manage.php"><?php echo constant("CD_MENU_SCHEDULING");?></a>
            <?php //} ?>
            <a href="ep_change_classroom.php"><?php echo constant("CD_MENU_CHANGE");?></a>
            <a href="ep_adding_student.php"><?php echo constant("CD_MENU_ADDITION");?></a>
            <a href="ep_class_cancel_manage.php"><?php echo constant("CD_MENU_CANCEL");?></a>
        </div>
        
      	<div id="mnu_rel" class="dropmenudiv_d">
		<?php
		foreach($dbf->fetchOrder('links',"cen_dr='1'","id") as $val) {
		?>
			<a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
		<?php } ?>
		</div>
		 <!--preference drop down menu -->
        <div id="prefer" class="dropmenudiv_d">
        	<a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        	<a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        </div>
        <!--Progress report drop down menu -->
      
       <!--student drop down menu -->
        <div id="rpt_student" class="dropmenudiv_d"> 
			<a href="s_age.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
			<a href="s_classic.php"><?php echo constant("SA_MENU_CLASSIC");?></a>
			<a href="s_manage.php"><?php echo constant("SA_MENU_STUDENT_DETAILS");?></a>
            <a href="arf_manage.php"><?php echo constant("ACTION_ARF_REPORT");?></a>
            <a href="cancel_manage.php"><?php echo constant("CANCELLATION_REQUEST");?></a>
            <a href="hold_manage.php"><?php echo constant("MANAGE_ONHOLD");?></a>
            <a href="single-student.php"><?php echo constant("STUDENT_INFORMATON");?></a>
		</div>
      
      <!-- grouping -->
     <div id="rel_group" class="dropmenudiv_d">
     	<a href="group_course.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
		<a href="group_manage.php"><?php echo constant("SA_MENU_GROUP");?></a>
        <a href="view_group_size.php"><?php echo constant("SA_MENU_GROUP_SIZE");?></a>
        <a href="view_group_history.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_GROUP_HISTORY");?></a>
     </div>
      
    <div id="rpt_progress_report" class="dropmenudiv_d">
        <a href="report_group_progress.php" title="Group Progress Report"><?php echo constant("CD_MENU_GROUP_PROGRESS_REPORT");?></a>
        <a href="report_teacher_progress.php" title="Persoanl Progress Report" rel=""><?php echo constant("CD_MENU_PERSONAL_PROGRESS_REPORT");?></a>            
        <a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a> 
        <a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a> 
        <a href="report_student_awaiting.php"><?php echo constant("ADMIN_MENU_REPORTS_AWAIT");?></a> 
        <a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a> 
        <a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a> 
        <a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a> 
        <a href="report_teacher_leave_report.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?></a> 
        <a href="report_teacher_overtime_report.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_OVER");?></a> 
        <a href="report_teacher_capacity.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");?></a> 
        <a href="report_certificate_report.php"><?php echo constant("ADMIN_MENU_REPORTS_SUMMARY");?></a> 
        <a href="report_freq_customer_report.php"><?php echo constant("ADMIN_MENU_REPORTS_CUSTOMER");?></a> 
        <a href="report_student_group_grade.php"><?php echo constant("ADMIN_MENU_REPORTS_GROUP_GRADE");?></a> 
        <a href="report_student_not_enrolled.php"><?php echo constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");?></a> 
        <a href="report_student_on_hold.php"><?php echo constant("ADMIN_MENU_REPORTS_ON_HOLD");?></a> 
        <a href="report_statistic.php"><?php echo constant("CD_MENU_STATISTIC_REPORT");?></a>
        <a href="arf_manage.php"><?php echo constant("SA_MENU_ARF_REPORTS");?></a>
    </div>    
    
    <script type="text/javascript">
    //SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
    tabdropdown.init("glowmenu", "auto")
    </script>
    </td>
  </tr>
</table>
