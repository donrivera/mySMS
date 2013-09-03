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
    <td align="right" height="30"  bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
	<?php echo constant("ADMIN_MENU_QUICK_LINKS");?>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#e6e6e6" class="leftmenuborder">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <?php
	foreach($dbf->fetchOrder('quick_links',"module_name='Administrator' And link_name<>'Manage Week List'","prec") as $val_quick)
	{
		if($val_quick[links] == $filename)	{	$class = 'myactivemenutext';}	else { $class = 'mymenutext';	}
		if($val_quick[links] == $filename){$img = "../images/arrow_small_right2.png";}else{$img = "../images/arrow_small_right4.png";}
		if($val_quick[link_name]=="Home"){ $linkname = constant("ADMIN_MENU_HOME");} 
		else if($val_quick[link_name]=="Manage Week") { $linkname = constant("ADMIN_MENU_RULE_WEEK");}
		else if($val_quick[link_name]=="Manage Week List") { $linkname = constant("STUDENT_LEAVE_MANAGE_MANAGE_WEEKLIST");}
		else if($val_quick[link_name]=="Manage Group Type") { $linkname = constant("ADMIN_MENU_RULE_TYPE");}
		else if($val_quick[link_name]=="Manage Group Size") { $linkname = constant("ADMIN_GROUP_SIZE_MANAGE_MANAGE_GROUP_SIZE");}
		else if($val_quick[link_name]=="Manage User Status") { $linkname = constant("ADMIN_USER_STATUS_MANAGE_MANAGE_USER_STATUS");}
		else if($val_quick[link_name]=="Manage Teacher Preference") { $linkname = constant("ADMIN_TEACHER_MANAGE_MANAGE_TEACHER_PREFERENCE");}
		else if($val_quick[link_name]=="Manage Student Status") { $linkname = constant("ADMIN_STUDENT_MANAGE_MANAGE_STUDENT_STATUS");}
		else if($val_quick[link_name]=="News Alert Type") { $linkname = constant("ADMIN_ALERT_MANAGE_MANAGE_NEWALERT");}
		else if($val_quick[link_name]=="Manage Teacher") { $linkname = constant("ADMIN_TEACHER1_MANAGE_MANAGE_TEACHER");}
		else if($val_quick[link_name]=="Manage Material") { $linkname = constant("ADMIN_MATERIAL_MANAGE_MANAGE_MATERIAL");}
		else if($val_quick[link_name]=="Set Logout Time") { $linkname = constant("ADMIN_MENU_RULE_LOGOUT_TIME");}
		else if($val_quick[link_name]=="SMS Gateway Configuration") { $linkname = constant("ADMIN_MENU_RULE_SMS");}
		else if($val_quick[link_name]=="Leads Management") { $linkname = constant("ADMIN_MENU_LEADMGT");}
		else if($val_quick[link_name]=="Grades Management") { $linkname = constant("ADMIN_MENU_GRADEMGT");}
		else if($val_quick[link_name]=="Accounts Type") { $linkname = constant("ADMIN_MENU_ACNTTYPE");}
		else if($val_quick[link_name]=="Center Management") { $linkname = constant("ADMIN_MENU_CENTERMGT");}
		else if($val_quick[link_name]=="Centre Vacation") { $linkname = constant("ADMIN_MENU_VAC_CENTRE");}
		else if($val_quick[link_name]=="Teacher Vacation") { $linkname = constant("ADMIN_MENU_VAC_TEACHER");}
		else if($val_quick[link_name]=="Exam Vacation") { $linkname = constant("ADMIN_MENU_VAC_EXAM");} 
		else if($val_quick[link_name]=="Student Vacation") { $linkname = constant("ADMIN_MENU_STDVAC");}
		else if($val_quick[link_name]=="Course Management") { $linkname = constant("ADMIN_MENU_COURSEMGT");}
		else if($val_quick[link_name]=="Certificate") { $linkname = constant("TEACHER_REPORT_TEACHER_CERTIFICATE");}
		else if($val_quick[link_name]=="Users Management") { $linkname = constant("ADMIN_MENU_USERSMGT");}
		else if($val_quick[link_name]=="News Management") { $linkname = constant("ADMIN_NEWS_MANAGE_NEWS_MANAGEMENT");} 
		else if($val_quick[link_name]=="Links Management") { $linkname = constant("ADMIN_MENU_LINKMGT");} 
		else if($val_quick[link_name]=="Alerts Management") { $linkname = constant("ADMIN_ALERT1_MANAGE_ALERTS_MANAGEMENT");} 
		else if($val_quick[link_name]=="SMS") { $linkname = constant("ADMIN_MENU_SMS");} 
		else if($val_quick[link_name]=="E-Mail") { $linkname = constant("ADMIN_MENU_EMAIL");} 
		else if($val_quick[link_name]=="Students") { $linkname = constant("ADMIN_MENU_STUDENT");} 
		else if($val_quick[link_name]=="Teacher Board") { $linkname = constant("ADMIN_MENU_REPORTS_BOARD");} 
		else if($val_quick[link_name]=="Teacher(s) Schedule") { $linkname = constant("ADMIN_MENU_REPORTS_SCHEDULE");} 
		else if($val_quick[link_name]=="Student awaiting") { $linkname = constant("ADMIN_MENU_STDAWT");} 
		else if($val_quick[link_name]=="Group to Finish") { $linkname = constant("ADMIN_MENU_REPORTS_FINISH");} 
		else if($val_quick[link_name]=="Certificate not collect") { $linkname = constant("ADMIN_MENU_REPORTS_COLLECT");} 
		else if($val_quick[link_name]=="Absent Report") { $linkname = constant("ADMIN_MENU_REPORTS_ABSENT");} 
		else if($val_quick[link_name]=="Teacher Leave Report") { $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");} 
		else if($val_quick[link_name]=="Teacher Overtime Report") { $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_OVER");} 
		else if($val_quick[link_name]=="Teacher Capacity") { $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");} 
		else if($val_quick[link_name]=="Certificate Report") { $linkname = constant("TE_MENU_CR");} 
		else if($val_quick[link_name]=="Frequent Customer Report") { $linkname = constant("ADMIN_REPORT_FREQ_CUSTOMER_REPORT_FREQUENTCUST");}  
		else if($val_quick[link_name]=="Student Group Grade") { $linkname = constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTGG");} 
		else if($val_quick[link_name]=="Student Not Enrolled") { $linkname = constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");} 
		else if($val_quick[link_name]=="Student on Hold") { $linkname = constant("ADMIN_MENU_REPORTS_ON_HOLD");} 
		else if($val_quick[link_name]=="Statistic Report") { $linkname = constant("ADMIN_MENU_REPORTS_STATISTIC");} 
		else { $linkname = $val_quick[link_name]; }
	?>
      <tr>
                
        <td height="30" align="right" valign="middle" style="border-right:solid 2px; border-color:#CCC;" class="<?php echo $class;?>"><a style="text-decoration:none;" href="<?php echo $val_quick[links];?>"><?php echo $linkname;?></a></td>
        
        <td width="25" align="center" valign="middle"><a href="<?php echo $val_quick[links];?>"><img src="<?php echo $img;?>" width="16" height="16" border="0" /></a></td>
        <td width="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="1" colspan="3" bgcolor="#ccc"></td>
        </tr>
    <?php } ?>      
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
