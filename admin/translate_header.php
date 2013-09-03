<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
?>
<link href="css/glowtabs.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#090;
}
#country{
	padding:3px;
	border:1px #CCC solid;
	font-size:17px;
}
.suggestionsBox {
	position: absolute;
	right:1px;
	top:0px;
	margin: 26px 0px 0px 0px;
	width: 150px;
	padding:0px;
	background-color:#C8C8C8;
	border-top: 3px solid #C8C8C8;
	color: #fff;
	text-align:center;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color:#093;
	color:#FFF;
}
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#000;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}

</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" > </td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul>
        <li><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_RULE_RR");?>" rel="dropmenu1_d"><span><?php echo constant("ADMIN_MENU_RULE_RR");?></span></a></li>
        <li><a href="lead_manage.php" title="<?php echo constant("ADMIN_MENU_LEADS");?>"><span><?php echo constant("ADMIN_MENU_LEADS");?></span></a></li>
        <li><a href="grade_manage.php" title="<?php echo constant("ADMIN_MENU_GRADES");?>"><span><?php echo constant("ADMIN_MENU_GRADES");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_ACCOUNTS");?>" rel="accounts_dr"><span><?php echo constant("ADMIN_MENU_ACCOUNTS");?></span></a></li>
        <li><a href="center_manage.php" title="<?php echo constant("ADMIN_MENU_CENTRE");?>"><span><?php echo constant("ADMIN_MENU_CENTRE");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_VAC_LEAVE");?>" rel="vacation"><span><?php echo constant("ADMIN_MENU_VAC_LEAVE");?></span></a></li>
        <li><a href="course_manage.php" title="<?php echo constant("ADMIN_MENU_COURSE");?>"><span><?php echo constant("ADMIN_MENU_COURSE");?></span></a></li>
        <li><a href="user_manage.php" title="<?php echo constant("ADMIN_MENU_USERS");?>"><span><?php echo constant("ADMIN_MENU_USERS");?></span></a></li>
        <li><a href="news_manage.php" title="<?php echo constant("ADMIN_MENU_NEWS");?>"><span><?php echo constant("ADMIN_MENU_NEWS");?></span></a></li>
        <li><a href="link_manage.php" title="<?php echo constant("ADMIN_MENU_LINKS");?>"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>        
		<li><a href="alert1_manage.php" title="<?php echo constant("ADMIN_MENU_ALERTS");?>"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_SMS");?>" rel="rel_sms"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
        <li><a href="email_manage.php" title="<?php echo constant("ADMIN_MENU_EMAIL");?>"><span><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        <li><a href="s_manage.php" title="<?php echo constant("ADMIN_MENU_STUDENT");?>"><span><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_REPORTS");?>" rel="rpt_progress_report"><span><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>        
        <li><a href="certificate.php" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>"><span><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        <li><a href="#" title="<?php echo constant("ADMIN_MENU_MY_ACCOUNT");?>" rel="pre"><span><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></li>
      </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />
        
        <!-- SMS Menu -->
        <div id="rel_sms" class="dropmenudiv_d">
        <a href="sms_template_manage.php"><?php echo constant("ADMIN_MENU_SMS_TEMP");?></a> 
		<a href="sms_history.php"><?php echo constant("ADMIN_MENU_SMS_HISTORY");?></a> 
        </div>
        <!--1st drop down menu -->
        <div id="dropmenu1_d" class="dropmenudiv_d">
			<a href="week_manage.php"><?php echo constant("ADMIN_MENU_RULE_WEEK");?></a> 
			<a href="group_manage.php"><?php echo constant("ADMIN_MENU_RULE_TYPE");?></a> 
			<a href="group_size_manage.php"><?php echo constant("ADMIN_MENU_RULE_GROUP");?></a> 
			<a href="user_status_manage.php"><?php echo constant("ADMIN_MENU_RULE_USER_STATUS");?></a>
			<a href="teacher_manage.php"><?php echo constant("ADMIN_MENU_RULE_PREFER");?></a> 
			<a href="student_manage.php"><?php echo constant("ADMIN_MENU_RULE_STUDENT_STATUS");?></a>
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
			</div>
			
        <div id="vacation" class="dropmenudiv_d">
        <a href="vacation_center_manage.php"><?php echo constant("ADMIN_MENU_VAC_CENTRE");?></a>
        <a href="vacation_teacher_manage.php"><?php echo constant("ADMIN_MENU_VAC_TEACHER");?></a>
        <a href="vacation_exam_manage.php"><?php echo constant("ADMIN_MENU_VAC_EXAM");?></a> 
        <a href="vacation_student_manage.php"><?php echo constant("ADMIN_MENU_VAC_STUDENT");?></a>
        </div>
			
      <div id="accounts_dr" class="dropmenudiv_d">
	  	<a href="payment_manage.php"><?php echo constant("ADMIN_MENU_TYPEOFPAYMENT");?></a>
		<a href="challan_cond.php"><?php echo constant("ADMIN_MENU_RECEIPT");?></a>
		<a href="invoice_cond.php"><?php echo constant("ADMIN_MENU_INVOICE");?></a>
	  </div>
              
      <div id="pre" class="dropmenudiv_d">
        <a href="my_account.php"><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></a>
      	<a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a>
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
        </div>        
      <script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
