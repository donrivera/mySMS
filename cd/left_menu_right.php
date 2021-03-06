<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$filename = $parts[count($parts) - 1];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" align="right" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#e6e6e6" class="leftmenuborder">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <?php
	foreach($dbf->fetchOrder('quick_links',"module_name='Center Director' And user_id='$_SESSION[id]'","prec") as $val_quick)
	{
		if($val_quick[links] == $filename){$class = 'myactivemenutext';}else{$class = 'mymenutext';}
		if($val_quick[links] == $filename){$img = "../images/arrow_small_right2.png";}else{$img = "../images/arrow_small_right4.png";}
		if($val_quick[link_name]=="Home"){ $linkname = constant("ADMIN_MENU_HOME");}
		else if($val_quick[link_name]=="Quick Add"){ $linkname = constant("SA_MENU_QUICKADD");}
		else if($val_quick[link_name]=="Wizard Interaction Based Student"){ $linkname = constant("CD_MENU_WIZBASESTD");}
		else if($val_quick[link_name]=="Classic Form Based Student"){ $linkname = constant("CD_MENU_CLASSICFRMBASESTD");}
		else if($val_quick[link_name]=="Manage Student Details"){ $linkname = constant("SA_MENU_STUDENT_DETAILS");}
		else if($val_quick[link_name]=="Search Students"){ $linkname = constant("ADMIN_S_MANAGE_SEARCH_STUDENT");}
		else if($val_quick[link_name]=="Wizard Interaction Based Group"){ $linkname = constant("CD_MENU_WIZBASEGROUP");}
		else if($val_quick[link_name]=="Manage Grouping"){ $linkname = constant("SA_MENU_GROUP");}
		else if($val_quick[link_name]=="Manage Time Slot"){ $linkname = constant("SA_MENU_TIME_SLOT");}
		else if($val_quick[link_name]=="Date Converter"){ $linkname = constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");}
		else if($val_quick[link_name]=="Language Converter"){ $linkname = constant("STUDENT_TRANSLATE_LANGUAGE_CONVERTER");}
		else if($val_quick[link_name]=="Help"){ $linkname = constant("RE_MENU_HELP");}
		else if($val_quick[link_name]=="Alerts"){ $linkname = constant("ADMIN_MENU_ALERTS");}
		else if($val_quick[link_name]=="SMS"){ $linkname = constant("ADMIN_MENU_SMS");}
		else if($val_quick[link_name]=="E-Mail"){ $linkname = constant("ADMIN_MENU_EMAIL");}
		else if($val_quick[link_name]=="View In Gantt Chart"){ $linkname = constant("CD_MENU_V_GANTT");}
		else if($val_quick[link_name]=="View Table By Teacher"){ $linkname = constant("CD_MENU_V_TABLE_TEACHER");}
		else if($val_quick[link_name]=="View Table By Level"){ $linkname = constant("CD_MENU_V_TABLE_LEVEL");}
		else if($val_quick[link_name]=="View Table By Start Date"){ $linkname = constant("CD_MENU_V_TABSTARTDATE");}
		else if($val_quick[link_name]=="View Table By End Date"){ $linkname = constant("CD_MENU_V_TABENDDATE");}
		else if($val_quick[link_name]=="View Table By Range Date"){ $linkname = constant("CD_MENU_V_TABRANGEDATE");}
		else if($val_quick[link_name]=="Certifcate Reports"){ $linkname = constant("TE_MENU_CR");}
		else if($val_quick[link_name]=="Progress Report"){ $linkname = constant("STUDENT_PROGRESS_REPORT_PROGRESSREPORT");}
		else if($val_quick[link_name]=="Teacher Board"){ $linkname = constant("ADMIN_MENU_REPORTS_BOARD");}
		else if($val_quick[link_name]=="Teacher(s) Schedule"){ $linkname = constant("ADMIN_MENU_REPORTS_SCHEDULE");}
		else if($val_quick[link_name]=="Student awaiting"){ $linkname = constant("ADMIN_MENU_STDAWT");}
		else if($val_quick[link_name]=="Group to Finish"){ $linkname = constant("TEACHER_MENU_GRPFINISH");}
		else if($val_quick[link_name]=="Certificate not collected"){ $linkname = constant("ADMIN_REPORT_CERTIFICATE_NOT_COLLECT_CERTIFI");}
		else if($val_quick[link_name]=="Absent Report"){ $linkname = constant("ADMIN_REPORT_ABSENT_REPORT_ABSENTREPORT");}
		else if($val_quick[link_name]=="Teacher Leave Report"){ $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");}
		else if($val_quick[link_name]=="Teacher Overtime Report"){ $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_OVER");}
		else if($val_quick[link_name]=="Teacher Capacity"){ $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");}
		else if($val_quick[link_name]=="Certificate Report"){ $linkname = constant("TE_MENU_CR");}
		else if($val_quick[link_name]=="Frequent Customer Report"){ $linkname = constant("ADMIN_MENU_REPORTS_CUSTOMER");}
		else if($val_quick[link_name]=="Student Group Grade"){ $linkname = constant("ADMIN_MENU_REPORTS_GROUP_GRADE");}
		else if($val_quick[link_name]=="Student Not Enrolled"){ $linkname = constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");}
		else if($val_quick[link_name]=="Student on Hold"){ $linkname = constant("ADMIN_MENU_REPORTS_ON_HOLD");}
		else if($val_quick[link_name]=="Statistic Report"){ $linkname = constant("ADMIN_MENU_REPORTS_STATISTIC");}
		else if($val_quick[link_name]=="Removing Student From Group"){ $linkname = constant("CD_MENU_REMOVESTDFRMGRP");}
		else if($val_quick[link_name]=="Scheduling Of A Make Up Class"){ $linkname = constant("CD_MENU_SCHMAKEUPCLASS");}
		else if($val_quick[link_name]=="Change A Classroom"){ $linkname = constant("CD_MENU_CHANGECLASSROOM");}
		else if($val_quick[link_name]=="Addtion Of A Student To A Group"){ $linkname = constant("CD_MENU_ADDSTDTOGRP");}
		else if($val_quick[link_name]=="Manage Sick Leave"){ $linkname = constant("CD_MENU_MANAGE_SICK_LEAVE");}
		else { $linkname = $val_quick[link_name]; }
	?>
      <tr>
        <td style="border-left:solid 2px; border-color:#CCC;">&nbsp;</td>
        <td width="212" align="right" valign="middle" class="<?php echo $class;?>"><a style="text-decoration:none;" href="<?php echo $val_quick[links];?>"><?php echo $linkname;?></a></td>
        <td width="31" height="30" align="center" valign="middle"><a href="<?php echo $val_quick[links];?>"><img src="<?php echo $img;?>" width="16" height="16" border="0" /></a></td>
      </tr>
      <tr>
        <td height="1" colspan="3" bgcolor="#ccc"></td>
        </tr>
    <?php } ?>      
    </table></td>
  </tr>
  <tr>
    <td height="200" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
