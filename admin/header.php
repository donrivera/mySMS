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
<script type='text/javascript' src='../js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$("#testinput").autocomplete("autosuggest_tech.php", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" >
    <form action="auto_search.php" method="post" name="search_frm" id="search_frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="41%" align="right" id="DisplayInfo"></td>
        <td width="2%">&nbsp;</td>
        <td width="47%" align="right" valign="middle" style="padding-left:250px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="43%" align="right" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="left" style="display:'';">
              <tr>
                <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_BIGGER");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_RESET");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_SMALLER");?></b></a></td>
              </tr>
            </table></td>
            <td width="57%" align="right" valign="middle">
            <div id="suggest" style="width:450px;">
            <span class="leftmenu"><?php echo constant("RE_MENU_SEARCH");?></span>:
            <input name="testinput" type="text" class="searchtext" id="testinput" autocomplete="off" />              
            </div>
            </td>
          </tr>
        </table></td>
        <td width="2%" align="left" valign="middle"><input type="image"src="images/search.png" alt="add_btn" width="30" height="27" title="<?php echo RE_MENU_SEARCH ?>"/></td>
        <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
        <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" >
    <div id="glowmenu" class="glowingtabs">
      <ul>
      <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li>
        <a <?php echo $mystyle;?> href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_HOME");?></span></a>
        </li>
        <?php
		$mystyle = '';
		  if($page_name == "week_manage.php" || $page_name == "week_edit.php" || $page_name == "group_manage.php" || $page_name=="group_add.php" || $page_name=="group_edit.php" || $page_name == "group_size_manage.php" || $page_name=="group_size_add.php"  || $page_name=="group_size_edit.php" || $page_name == "user_status_manage.php" || $page_name=="user_status_add.php" || $page_name=="user_status_edit.php" || $page_name == "teacher_manage.php" || $page_name=="teacher_add.php" || $page_name=="teacher_edit.php" || $page_name == "student_manage.php" || $page_name=="manage_student_add.php" || $page_name=="manage_student_edit.php" || $page_name == "alert_manage.php" || $page_name=="alert_add.php" || $page_name=="alert_edit.php" || $page_name == "teacher1_manage.php" || $page_name=="teacher1_add.php" || $page_name=="teacher1_edit.php" || $page_name == "material_manage.php" || $page_name=="material_add.php" || $page_name=="material_edit.php" || $page_name == "unit_manage.php" || $page_name=="unit_add.php" || $page_name=="unit_edit.php" || $page_name == "comments_manage.php" || $page_name == "timeout_manage.php" || $page_name == "sms_gateway_manage.php" || $page_name == "view_group_size.php" || $page_name == "view_group_history.php" || $page_name == "view_student_comments_history.php" || $page_name == "currency_setup.php" || $page_name == "help_manage.php" || $page_name=="help_add.php" || $page_name=="help_edit.php" || $page_name == "type_manage.php" || $page_name == "type_add.php" || $page_name == "type_edit.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li>
        <a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_RULE_RR");?>" rel="dropmenu1_d"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_RULE_RR");?></span></a>
        </li>
        <?php
		$mystyle = '';
		  if($page_name == "lead_manage.php" || $page_name == "lead_add.php" || $page_name == "lead_edit.php" )
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="lead_manage.php" title="<?php echo constant("ADMIN_MENU_LEADS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_LEADS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "grade_manage.php" || $page_name == "grade_add.php" || $page_name == "grade_edit.php" )
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="grade_manage.php" title="<?php echo constant("ADMIN_MENU_GRADES");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_GRADES");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "payment_manage.php" || $page_name=="payment_add.php" || $page_name=="payment_edit.php" || $page_name =="challan_cond.php" || $page_name =="invoice_cond.php" || $page_name=="bed_debt_config.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_ACCOUNTS");?>" rel="accounts_dr"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ACCOUNTS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "center_manage.php" || $page_name == "center_add.php" || $page_name == "center_edit.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="center_manage.php" title="<?php echo constant("ADMIN_MENU_CENTRE");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_CENTRE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "student_to_student_manage.php" || $page_name == "student_to_student_add.php" || $page_name =="student_to_center_manage.php" || $page_name =="center_to_center_manage.php" || $page_name == "center_to_center_add.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Groups" rel="rel_transfer"><span <?php echo $mystyle;?>><?php echo constant("SA_TRANSFER");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "vacation_center_manage.php" || $page_name=="vacation_center_add.php" || $page_name=="vacation_center_edit.php" || $page_name == "vacation_teacher_manage.php" || $page_name == "vacation_teacher_add.php" || $page_name == "vacation_teacher_edit.php" || $page_name == "vacation_exam_manage.php" || $page_name == "vacation_exam_add.php" || $page_name == "vacation_exam_edit.php" || $page_name=="vacation_student_manage.php" || $page_name=="vacation_student_add.php" || $page_name=="vacation_student_edit.php" || $page_name == "sick_leave_manage.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_VAC_LEAVE");?>" rel="vacation"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_VAC_LEAVE");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "course_manage.php" || $page_name == "course_edit.php" || $page_name == "course_add.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="course_manage.php" title="<?php echo constant("ADMIN_MENU_COURSE");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_COURSE");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "user_manage.php" || $page_name == "user_add.php" || $page_name == "user_edit.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="user_manage.php" title="<?php echo constant("ADMIN_MENU_USERS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_USERS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "news_manage.php" || $page_name == "news_add.php" || $page_name == "news_edit.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="news_manage.php" title="<?php echo constant("ADMIN_MENU_NEWS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_NEWS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "link_manage.php" || $page_name == "link_add.php" || $page_name == "link_edit.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="link_manage.php" title="<?php echo constant("ADMIN_MENU_LINKS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>  
        
        <?php
		$mystyle = '';
		  if($page_name == "alert1_manage.php" || $page_name == "alert1_add.php" || $page_name == "alert1_edit.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
		<li><a <?php echo $mystyle;?> href="alert1_manage.php" title="<?php echo constant("ADMIN_MENU_ALERTS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        
         <?php
		$mystyle = '';
		  if($page_name == "sms_template_manage.php" || $page_name=="sms_parameter_templete.php" || $page_name=="sms_template_add.php" || $page_name=="sms_template_edit.php" || $page_name == "sms_history.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_SMS");?>" rel="rel_sms"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "email_manage.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_EMAIL");?>" rel="rel_email"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "s_manage.php" || $page_name == 'cancel_manage.php' || $page_name == 'cancel_status.php'){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_STUDENT");?>" rel="mnu_enroll"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        
         <?php
		$mystyle = '';
		  if($page_name == "report_teacher_board.php" || $page_name=="report_teacher_schedule.php" || $page_name=="report_student_awaiting.php" || $page_name == "report_group_to_finish.php" || $page_name == "report_certificate_not_collect.php" || $page_name=="report_absent_report.php" || $page_name=="report_teacher_leave_report.php" || $page_name == "report_teacher_overtime_report.php" || $page_name == "report_teacher_capacity.php" || $page_name=="report_certificate_report.php" || $page_name == "report_student_group_grade_dtls.php" || $page_name== "report_freq_customer_report.php" || $page_name == "report_student_group_grade.php" || $page_name == "report_student_not_enrolled.php" || $page_name == "report_student_on_hold.php" || $page_name == "report_statistic.php" || $page_name == "report_student_cycle.php" || $page_name == "report_student_cycle_dtls.php" || $page_name == "report_management.php") {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_REPORTS");?>" rel="rpt_progress_report"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>   
        
        <?php
		$mystyle = '';
		  if($page_name == "certificate.php" || $page_name == "certificate_multi.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>" rel="certi_multi"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        
         <?php
		$mystyle = '';
		  if($page_name == "my_account.php" || $page_name == "password.php" || $page_name == "quicklink_manage.php"){
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_MY_ACCOUNT");?>" rel="pre"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></li>
      </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />
        <!-- SMS Menu -->
        <div id="rel_sms" class="dropmenudiv_d">
        <a href="sms_template_manage.php"><?php echo constant("ADMIN_MENU_SMS_TEMP");?></a> 
		<a href="sms_parameter_templete.php"><?php echo constant("ADMIN_SMS_PARAMETER_TEMPLETE_SMS_PARA_TEMP");?></a>
		<a href="sms_history.php"><?php echo constant("ADMIN_MENU_SMS_HISTORY");?></a> 
        </div>
        <div id="rel_email" class="dropmenudiv_d">
        <a href="email_manage.php"><?php echo constant("ADMIN_EMAIL_MANAGE_EMAIL_TEMPLETE");?></a> 
		<a href="email_parameter_templete.php"><?php echo constant("ADMIN_MENU_EMAIL_TEMP");?></a>
        </div>
        <div id="mnu_enroll" class="dropmenudiv_d">
        <a href="s_manage.php"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?></a> 
		<a href="cancel_manage.php"><?php echo constant("CANCELLATION_REQUEST");?></a>
        </div>        
        <div id="certi_multi" class="dropmenudiv_d">
        <a href="certificate.php"><?php echo constant("SINGLE_CERTIFICATE");?></a> 
		<a href="certificate_multi.php"><?php echo constant("MULTIPLE_CERTIFICATE");?></a>
        </div>        
        <!-- Transfer -->
        <div id="rel_transfer" class="dropmenudiv_d">
            <a href="student_to_student_manage.php"><?php echo constant("SA_STUDENT_TO_STUDENT");?></a>
            <!--<a href="student_to_center_manage.php"><?php //echo constant("SA_STUDENT_TO_CENTER");?></a>-->
            <a href="center_to_center_manage.php"><?php echo constant("SA_CENTER_CENTER");?></a>
        </div>
        
        <!--1st drop down menu -->
        <div id="dropmenu1_d" class="dropmenudiv_d">
			<a href="week_manage.php"><?php echo constant("ADMIN_MENU_RULE_WEEK");?></a> 
			<a href="group_manage.php"><?php echo constant("ADMIN_MENU_RULE_TYPE");?></a> 
			<a href="group_size_manage.php"><?php echo constant("ADMIN_MENU_RULE_GROUP");?></a> 
			<a href="user_status_manage.php"><?php echo constant("ADMIN_MENU_RULE_USER_STATUS");?></a>
			<a href="teacher_manage.php"><?php echo constant("ADMIN_MENU_RULE_PREFER");?></a> 
			<!--<a href="student_manage.php"><?php //echo constant("ADMIN_MENU_RULE_STUDENT_STATUS");?></a>-->
			<a href="alert_manage.php"><?php echo constant("ADMIN_MENU_RULE_ALERTS");?></a> 
			<a href="teacher1_manage.php"><?php echo constant("ADMIN_MENU_RULE_TEACHER");?></a>
			<a href="material_manage.php"><?php echo constant("ADMIN_MENU_RULE_MATERIAL");?></a>
            <a href="unit_manage.php"><?php echo constant("ADMIN_MENU_RULE_UNI");?></a>
            <a href="comments_manage.php"><?php echo constant("ADMIN_MENU_RULE_COMMENTS");?></a>
            <a href="timeout_manage.php"><?php echo constant("ADMIN_MENU_RULE_LOGOUT_TIME");?></a>
            <a href="sms_gateway_manage.php"><?php echo constant("ADMIN_MENU_RULE_SMS");?></a>
            <a href="view_group_size.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_GROUP_SIZE");?></a>
            <a href="view_group_history.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_GROUP_HISTORY");?></a>
            <a href="view_student_comments_history.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY");?></a>
            <a href="currency_setup.php"><?php echo constant("ADMIN_MENU_RULE_CURRENCY");?></a>
            <a href="help_manage.php"><?php echo constant("ADMIN_MENU_RULE_HELP");?></a>
            <a href="type_manage.php"><?php echo constant("TYPE_OF_STUDENTS");?></a>
			</div>
			
        <div id="vacation" class="dropmenudiv_d">
        <a href="vacation_center_manage.php"><?php echo constant("ADMIN_MENU_VAC_CENTRE");?></a>
        <a href="vacation_teacher_manage.php"><?php echo constant("ADMIN_MENU_VAC_TEACHER");?></a>
        <a href="vacation_exam_manage.php"><?php echo constant("ADMIN_MENU_VAC_EXAM");?></a> 
        <a href="vacation_student_manage.php"><?php echo constant("ADMIN_MENU_VAC_STUDENT");?></a>
        <a href="sick_leave_manage.php"><?php echo constant("CD_MENU_MANAGE_SICK_LEAVE");?></a>
        </div>
			
      <div id="accounts_dr" class="dropmenudiv_d">
	  	<a href="payment_manage.php"><?php echo constant("ADMIN_MENU_TYPEOFPAYMENT");?></a>
		<a href="challan_cond.php"><?php echo constant("ADMIN_MENU_RECEIPT");?></a>
		<a href="invoice_cond.php"><?php echo constant("ADMIN_MENU_INVOICE");?></a>
        <a href="bed_debt_config.php"><?php echo constant("ADMIN_BED_DEBT_CONFIRE");?></a>
	  </div>
              
      <div id="pre" class="dropmenudiv_d">
        <a href="my_account.php"><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></a>
      	<a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        <!--<a href="translate.php"><?php //echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a>-->
      </div>
      
	  <!--Progress report drop down menu -->
        <div id="rpt_progress_report" class="dropmenudiv_d">
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
            <a href="report_statistic.php"><?php echo constant("ADMIN_MENU_REPORTS_STATISTIC");?></a>
            <a href="report_student_cycle.php"><?php echo constant("REPORT_STUDENT_LIFE_CYCLE");?></a>
            <a href="report_management.php"><?php echo constant("MANAGEMENT_REPORT");?></a>
        </div>
      <script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
