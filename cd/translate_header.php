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
    
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul>        
      <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="home.php" title="Home"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "student_manage.php" || $page_name=="student_edit.php" || $page_name=="student_add.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="student_manage.php" title="Quick Add" ><span <?php echo $mystyle;?> ><?php echo constant("SA_MENU_QUICKADD");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "s_age.php" || $page_name=="s_classic.php" || $page_name=="s_manage.php" || $page_name=="s_edit.php" || $page_name=="arf_manage.php" ||$page_name=="arf_print.php" ||$page_name=="arf_view.php" || $page_name=="s2.php" || $page_name=="s3.php" || $page_name=="s4.php" || $page_name=="s5.php" || $page_name=="s_group.php" || $page_name=="s6.php" || $page_name=="s7.php" || $page_name=="s8.php" || $page_name=="s10.php" || $page_name == "cancel_manage.php"  || $page_name == "hold_manage.php"  || $page_name == "single-student.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Students" rel="rpt_student"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "search.php" || $page_name=="search_manage.php" || $page_name=="search_manage_mail.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="search.php" title="Search"><span <?php echo $mystyle;?> ><?php echo constant("MENU_STUDENT_SERVICES");?></span></a></li>
        
        
        <?php
	  $mystyle = '';
	  if($page_name == "group_course.php" ||  $page_name=="group_quick.php" ||  $page_name=="group.php" || $page_name=="group_unit.php" || $page_name=="group_teacher.php" || $page_name=="group_classroom.php" || $page_name=="group_review.php" || $page_name=="group_manage.php" || $page_name=="view_group_size.php" || $page_name=="view_group_history.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Grouping" rel="rel_group"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_GROUPS");?></span></a></li>        
        
        <?php
	  $mystyle = '';
	  if($page_name == "student_to_student_manage.php" || $page_name == "student_to_student_add.php" || $page_name =="student_to_center_manage.php" || $page_name =="center_to_center_manage.php" || $page_name == "center_to_center_add.php" || $page_name == "student_to_different_center_manage.php" || $page_name == "student_from_another_center_manage.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Groups" rel="rel_transfer"><span <?php echo $mystyle;?>><?php echo constant("SA_TRANSFER");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php" || $page_name == "translate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Date Convertor" rel="conv"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
      <?php
	  $mystyle = '';
	  if($page_name == "alert.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="alert.php" title="Alert"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        
      <?php
	  $mystyle = '';
	  if($page_name == "sms.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="sms.php" title="SMS"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
		
        <?php
	  $mystyle = '';
	  if($page_name == "email.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="email.php" title="email"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "centre_schedule.php" || $page_name=="centre_schedule_teacher.php" || $page_name=="centre_schedule_table.php" || $page_name=="centre_schedule_startdate.php"  || $page_name=="centre_schedule_enddate.php" || $page_name=="centre_schedule_rangedate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Centre Schedule" rel="mnu_centre_sch"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CS");?></span></a></li>
		
         <?php
	  $mystyle = '';
	  if($page_name == "report_centre_director_main.php" || $page_name=="report_group_progress.php" || $page_name == "report_teacher_progress.php" || $page_name=="report_teacher_board.php" || $page_name=="report_teacher_schedule.php" || $page_name=="report_student_awaiting.php"  || $page_name=="report_group_to_finish.php" || $page_name=="report_certificate_not_collect.php" || $page_name == "report_absent_report.php" || $page_name=="report_teacher_leave_report.php" || $page_name=="report_teacher_overtime_report.php" || $page_name=="report_teacher_capacity.php"  || $page_name=="report_certificate_report.php" || $page_name=="report_freq_customer_report.php" || $page_name == "report_student_group_grade.php" || $page_name=="report_student_not_enrolled.php" || $page_name=="report_student_on_hold.php" || $page_name=="report_statistic.php"  || $page_name=="view_student_comments_history.php" || $page_name=="manage_sms_history.php" || $page_name == "report_management.php" || $page_name == "ped.php" || $page_name == "report_student_cycle.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Report" rel="rpt_progress_report"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        
        
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        
      <?php
	  $mystyle = '';
	  if($page_name == "ep_removing_student.php" || $page_name=="ep_scheduling_manage.php" || $page_name == "ep_change_classroom.php" || $page_name=="ep_adding_student.php" || $page_name=="ep_class_cancel_manage.php" || $page_name=="ep_class_cancel_add.php" || $page_name=="ep_class_cancel_edit.php" || $page_name=="ep_schedulng_add.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="E. Proc" rel="e_proc"><span <?php echo $mystyle;?> ><?php echo constant("CD_MENU_EPROC");?></span></a></li>
		
      <?php
	  $mystyle = '';
	  if($page_name == "vacation_center_manage.php" || $page_name=="vacation_exam_manage.php" || $page_name == "vacation_teacher_manage.php" || $page_name=="sick_leave_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Leave Vacation" rel="vacation" ><span <?php echo $mystyle;?> ><?php echo constant("CD_MENU_LEAVE_VACATION");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "certificate.php" || $page_name == 'certificate_multi.php')
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>" rel="certi_multi"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php" || $page_name == "user_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Preferences" rel="prefer"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PRE");?></span></a></li>
       <?php
	  $mystyle = '';
	  if($page_name == "help.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Help" rel="help"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_HELP");?></span></a></li>
       
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
