<?php
ob_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$qry = $_SERVER['QUERY_STRING'];
if($qry != '') { $page = $parts[count($parts) - 1].'?'.$qry; }else{ $page = $parts[count($parts) - 1];}
$page = base64_encode($page);
$page_name = $parts[count($parts) - 1];
?>
<!--<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>-->
<script type='text/javascript' src='../js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$("#testinput").autocomplete("autosuggest_tech.php?centre_id=<?php echo $_SESSION['centre_id'];?>", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="right">
  <tr>
    <td height="46" align="right" valign="top" background="images/title.png" >
    <form action="auto_search.php" method="post" name="search_frm" id="search_frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="41%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="47%" align="right" valign="middle" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="43%" align="right" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="left" >
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
            </div></td>
          </tr>
        </table>
        </td>
        <td width="2%" align="left" valign="middle"><input type="image" src="images/search.png" alt="add_btn" width="30" height="27" title="<?php echo RE_MENU_SEARCH ?>"/></td>
        <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
        <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul>        
         <?php
	  $mystyle = '';
	  if($page_name == "home.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "student_manage.php" || $page_name=="student_add.php" || $page_name=="student_edit.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="student_manage.php" title="Quick Add" rel=""><span <?php echo $mystyle;?>><?php echo constant("SA_MENU_QUICKADD");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "s_age.php" || $page_name == "s_classic.php" || $page_name == "student_appoint_manage.php" || $page_name == "arf_manage.php" || $page_name=="arf_view.php" || $page_name == "s_classic.php" || $page_name=="s2.php" || $page_name=="s3.php" || $page_name=="s4.php" || $page_name=="s5.php" || $page_name=="s_group.php" || $page_name=="s6.php" || $page_name=="s7.php" || $page_name=="s8.php" || $page_name=="s10.php" || $page_name=="view_student_comments_history_from_manage.php" || $page_name=="student_appoint_add.php" || $page_name=="student_appoint_edit.php" || $page_name=="cancel_manage.php" || $page_name=="cancel_add.php" || $page_name == "hold_manage.php"  || $page_name == "hold_add.php" || $page_name == "single-student.php" || $page_name == "single-home.php" || $page_name == "single-payment.php" || $page_name == "single-comments.php" || $page_name == "single-sms.php" || $page_name == "single-group.php" || $page_name == "single-audit.php" || $page_name == "single-p-report.php" || $page_name == "single-certificate.php" || $page_name == "single-password.php" || $page_name == "single-reports.php" || $page_name == 'single-arf.php' || $page_name == 'single-payment-edit.php' || $page_name == 'single-payment-made.php'){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="Students" rel="rpt_student"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "search.php" || $page_name=="search_advance.php" || $page_name=="search_advance_edit.php" || $page_name=="search_manage.php" || $page_name=="search_manage_mail.php" || $page_name=="s_edit.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="search.php" title="Search"><span <?php echo $mystyle;?>><?php echo constant("MENU_STUDENT_SERVICES");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "view_group_size.php" || $page_name=="group_course.php"  || $page_name=="group_quick.php" || $page_name=="group_manage.php" || $page_name=="group.php" || $page_name=="group_unit.php" || $page_name=="group_teacher.php" || $page_name=="group_classroom.php" || $page_name=="group_review.php" || $page_name=="view_group_history.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="Groups" rel="rel_group"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_GROUPS");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "student_to_student_manage.php" || $page_name == "student_to_student_add.php" || $page_name =="student_to_center_manage.php" || $page_name =="center_to_center_manage.php" || $page_name == "center_to_center_add.php" || $page_name == "s-to-s-different-center-manage.php" || $page_name =="s-to-s-different-center-add.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" rel="rel_transfer"><span <?php echo $mystyle;?>><?php echo constant("SA_TRANSFER");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "report_teacher_board.php" || $page_name == "report_teacher_schedule.php" || $page_name == "report_student_awaiting.php" || $page_name == "report_group_to_finish.php" || $page_name == "report_certificate_not_collect.php" || $page_name == "report_absent_report.php" || $page_name == "report_teacher_leave_report.php" || $page_name == "report_teacher_capacity.php" || $page_name == "report_certificate_report.php" || $page_name == "report_freq_customer_report.php" || $page_name == "view_student_comments_history_from_manage.php" || $page_name == "report_student_group_grade.php" || $page_name == "report_student_group_grade_dtls.php" || $page_name == "report_student_not_enrolled.php" || $page_name == "report_student_on_hold.php" || $page_name == "view_student_comments_history.php" || $page_name == "report_student_cycle.php" || $page_name == "report_student_cycle_dtls.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="Reports" rel="rpt_report"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php" || $page_name == "translate.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
       <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Converter" rel="conv"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
         
        
         <?php
	  $mystyle = '';
	  if($page_name == "alert.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="alert.php" title="Alerts"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "sms.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="sms.php" title="SMS"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
		
         <?php
	  $mystyle = '';
	  if($page_name == "email.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="email.php" title="email"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "centre_schedule.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="centre_schedule.php" title="Centre Schedule"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "ped.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="ped.php" title="ePEDCARD" rel=""><span <?php echo $mystyle;?>><?php echo constant("TE_MENU_EPEDCARD");?></span></a></li>
        
        
        <?php
	  $mystyle = '';
	  if($page_name == "report_teacher_progress.php" || $page_name == "report_group_progress.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="Progress Reports" rel="lbl_progress_rpt"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PR");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "certificate.php" || $page_name == "certificate_multi.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>" rel="certi_multi"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
         
		 <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php" || $page_name == "user_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>        
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="preferences" rel="prefer"><span <?php echo $mystyle;?>><?php echo constant("TE_MENU_PRE");?></span></a></li> 
        
        <?php
	  $mystyle = '';
	  if($page_name == "help.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="Help" rel="help"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_HELP");?></span></a></li>       
      </ul>
    </div>
    <br style="clear: left;" />
    <br class="IEonlybr" />
	
    <div id="lbl_progress_rpt" class="dropmenudiv_d">
    	<a href="report_group_progress.php"><?php echo constant("SINGLE_GROUP");?></a> 
        <a href="report_teacher_progress.php"><?php echo constant("STUDENT_WISE");?></a> 
    </div>
    <div id="conv" class="dropmenudiv_d">
        <a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
        <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
    </div>
      
      <div id="certi_multi" class="dropmenudiv_d">
        <a href="certificate.php"><?php echo constant("SINGLE_CERTIFICATE");?></a> 
		<a href="certificate_multi.php"><?php echo constant("MULTIPLE_CERTIFICATE");?></a>
        </div>
      
	<!--RSeport drop down menu -->                                                   
	<div id="rpt_report" class="dropmenudiv_d">
        <a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a>
        <a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
        <a href="report_student_awaiting.php"><?php echo constant("ADMIN_MENU_REPORTS_AWAIT");?></a>
        <a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
        <a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a>
        <a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>
        <a href="report_teacher_leave_report.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?></a>
        <a href="report_teacher_capacity.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");?></a>
        <a href="report_certificate_report.php"><?php echo constant("ADMIN_MENU_REPORTS_SUMMARY");?></a>
        <a href="report_freq_customer_report.php"><?php echo constant("ADMIN_MENU_REPORTS_CUSTOMER");?></a>
        <a href="report_student_group_grade.php"><?php echo constant("ADMIN_MENU_REPORTS_GROUP_GRADE");?></a>
        <a href="report_student_not_enrolled.php"><?php echo constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");?></a>
        <a href="report_student_on_hold.php"><?php echo constant("ADMIN_MENU_REPORTS_ON_HOLD");?></a>
        <a href="view_student_comments_history.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY");?></a>
        <a href="report_student_cycle.php"><?php echo constant("REPORT_STUDENT_LIFE_CYCLE");?></a>
	</div>
     
    <!-- grouping -->
    <div id="rel_group" class="dropmenudiv_d">
        <a href="group_course.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
        <a href="group_quick.php"><?php echo constant("QUICK_ADD_GROUP");?></a>
        <a href="group_manage.php"><?php echo constant("SA_MENU_GROUP");?></a>        
        <a href="view_group_size.php"><?php echo constant("SA_MENU_GROUP_SIZE");?></a>
    </div>
    
    <!-- Transfer -->
    <div id="rel_transfer" class="dropmenudiv_d">
        <a href="student_to_student_manage.php"><?php echo constant("SA_STUDENT_TO_STUDENT");?></a>
        <a href="s-to-s-different-center-manage.php"><?php echo constant("SA_STUDENT_TO_CENTER");?></a>
        <a href="center_to_center_manage.php"><?php echo constant("SA_CENTER_CENTER");?></a>
    </div>
         
	<!--student drop down menu -->
    <div id="rpt_student" class="dropmenudiv_d"> 
        <a href="s_age.php"><?php echo constant("CD_MENU_WIZBASESTD");?></a>
        <a href="s_classic.php"><?php echo constant("SA_MENU_CLASSIC");?></a>
        <a href="student_appoint_manage.php"><?php echo constant("SA_MENU_APPOINT");?></a>
        <a href="arf_manage.php"><?php echo constant("ACTION_ARF_REPORT");?></a>
        <a href="cancel_manage.php"><?php echo constant("CANCELLATION_REQUEST");?></a>
        <a href="hold_manage.php"><?php echo constant("MANAGE_ONHOLD");?></a>
        <a href="single-student.php"><?php echo constant("STUDENT_INFORMATON");?></a>
	</div>
     <!--Links drop down menu -->
    <div id="mnu_rel" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('links',"stu_ad='1'","id") as $val) {    ?>
        <a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
    <?php } ?>
    </div>

	<!--preference drop down menu -->
   <div id="prefer" class="dropmenudiv_d">
        <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        <a href="user_manage.php"><?php echo constant("STUDENT_CREDENT");?></a>
   </div>
   
    <div id="help" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('help',"stu_ad='1'","id") as $val) {
    ?>
        <a href="help.php?id=<?php echo $val[id]; ?>"><?php echo $val["title"];?></a>
    <?php } ?>
    </div>
       
	<script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
    </script>
    </td>
  </tr>
</table>
