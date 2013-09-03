<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['students_uid']=="" || $_SESSION['students_user_type']!="Student")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../includes/FusionCharts.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

# Get the student id from SESSION
$students_id = $_SESSION["students_uid"];

# Get the student details
$res_student = $dbf->strRecordID("student","*","id='$students_id'");

# Visible the all alerts which is created by administrator and allow to visible for students
if($_SESSION['ALERT_DISPLAY'] == ''){
	$alert_count = $dbf->countRows("alerts", "student='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
}

//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");

# Set timeout period in seconds
$count = $res_logout["name"];

// Alert set 1 time by session
$_SESSION['ALERT_DISPLAY'] = 'TRUE';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="../js/dropdowntabs.js"></script>

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!-- POP UP modal box -->
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.2.js"></script>
<link rel="stylesheet" href="../fancybox/jquery.fancybox-1.3.2.css" type="text/css" media="screen" />
<!-- POP UP modal box -->

</head>
<script language="JavaScript">
function show_a(row){
	var d = "diva"+row;
	if(document.getElementById(d).style.display == 'none'){
		document.getElementById(d).style.display = '';
	}else if(document.getElementById(d).style.display == ''){
		document.getElementById(d).style.display = 'none';
	}
}

function validate(row){
	var d = "msg"+row;
	if(document.getElementById(d).value == ''){
		return false;
	}
}
</script>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}

var x = <?php echo $alert_count; ?>;
$(function(){
	if(x > 0){
	$.fancybox.showActivity();
	//var res="<div style='width:300px;height:200px;border:2px solid red;'class='post_review_main'> bye bye</div>";
	$.post("alert_page.php",{"choice":"alert_respose"},function(res){
		$.fancybox(res,{centerOnScroll:true,hideOnOverlayClick:false});
	});
	}
});
</script>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN") { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#000000">
            <td height="30" bgcolor="#FFA938" style="background:url(../images/footer_repeat.png) repeat-x;" class="logintext"><?php echo constant("STUDENT_HOME_DASHBOARD");?></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="4">&nbsp;</td>
                <td width="843" align="left" valign="top">&nbsp;</td>
                <td width="141" align="left" valign="middle" class="home_head_text">&nbsp;</td>
                <td width="45" align="left" valign="middle" class="home_head_text">&nbsp;</td>
              </tr>
              <tr>
                <td width="4" height="200" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                  <tr>
                    <td width="16%" height="72" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="home.php"><img src="../home_icon/home.jpg" width="80" height="63" border="0" /></a></td>
                    <td width="16%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="myschedule.php"><img src="../home_icon/calendar_icon.png" width="70" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="myaccount.php"><img src="../home_icon/my_acc.jpg" width="60" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="progress_report.php"><img src="../home_icon/report_icon.jpg" width="60" height="56" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="leave_manage.php"><img src="../home_icon/abs.png" width="60" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="password.php"><img src="../home_icon/chg_pass.png" width="48" height="48" border="0" /></a></td>
                  </tr>
                  <tr class="lable1">
                    <td height="30" align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="myschedule.php" title="My schedule"><span><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="myaccount.php" ><span><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="progress_report.php" ><span><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="leave_manage.php" title="Leave"><?php echo constant("STUDENT_MENU_LEAVE");?></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a></td>
                  </tr>
                  <tr>
                    <td height="72" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="certificate_report.php"><img src="../home_icon/cert.png" width="64" height="64" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="calc_converter.php"><img src="../home_icon/calendar-icon.jpg" width="57" height="60" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="alert_page.php?choice=alert_respose&amp;page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"><img src="../home_icon/quick-link.png" width="60" height="60" border="0" /></a><a href="alert_page.php?choice=alert_respose&page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;">&nbsp;</td>
                  </tr>
                  <tr class="lable1">
                    <td height="30" align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="certificate_report.php" title="Certificates Grade"><span><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?></span></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("ADMIN_MENU_ALERTS");?></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;">&nbsp;</td>
                  </tr>
                </table></td>
                <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="lable1"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                  </tr>
                  <tr>
                    <td height="2" align="center" valign="middle"></td>
                  </tr>
                  <tr>
                  <?php
					if($res_student["photo"]!=''){
						$photo="../sa/photo/".$res_student["photo"];
					}else{
						$photo="../images/noimage.jpg";
					}
				  ?>
                    <td align="center" valign="middle">
                    <img width="80" height="90" src="<?php echo $photo;?>" />
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="mytext"><?php echo STUDENT_MYACCOUNT_EMAIL?> : <?php echo $res_student["email"];?></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="mytext"><?php echo STUDENT_MYACCOUNT_MOBILENO ?> : <?php echo $res_student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                </table></td>
                <td align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="2" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="2" align="left" valign="top">
                <?php 
				foreach($dbf->fetchOrder('student_enroll',"student_id='$students_id'","course_id") as $vals) {
				$course = $dbf->strRecordID("course","*","id='$vals[course_id]'");
				?>
                <table width="425" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                  <tr>
                    <td align="left" valign="middle">
                    <?php
					$res_progress = $dbf->strRecordID("teacher_progress_course","*","course_id='$vals[course_id]' And student_id='$students_id'");
					//$res_progress["course_attendance_perc"]+
					$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_comp"];
					
					if($avg>0)
					{
						$avg = $avg / 7;
						$avg = round($avg,1);
					}
					
					//$at = $res_progress["course_attendance"];
					$parti = $res_progress["course_partication"];
					$home = $res_progress["course_homework"];
					$flu = $res_progress["course_fluency"];
					$pro = $res_progress["course_pro"];
					$gra = $res_progress["course_grammer"];
					$voca = $res_progress["course_voca"];
					$comp = $res_progress["course_listen"];
						//<set label='Att' value='$at'/>			
					echo $strXML="<chart caption='Progress Reports for ($course[name])' xAxisName='' yAxisName='' showValues='0' decimals='0' formatNumberScale='0' chartRightMargin='30'>
									
									<set label='Parti' value='$parti'/>
									<set label='Home' value='$home'/>
									<set label='Flue' value='$flu'/>
									<set label='Pron' value='$pro'/>
									<set label='Gram' value='$gra'/>
									<set label='Voca' value='$voca'/>
									<set label='Comp' value='$comp'/>								
									<set label='Avg' value='$avg'/>
									</chart>";	
					 echo renderChartHTML("../FusionCharts/Charts/Column2D.swf", "", $strXML, "myNext", 420, 200);
					?>
                    </td>
                  </tr>
                </table>
                <?php } ?>
                
                </td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#000000">
            <td height="30" align="right" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("STUDENT_HOME_DASHBOARD");?>&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="3">&nbsp;</td>
                <td width="196" align="left" valign="top">&nbsp;</td>
                <td width="737" align="left" valign="top">&nbsp;</td>
                <td width="21" align="left" valign="middle">&nbsp;</td>
                </tr>
              <tr>
                <td width="3" height="200" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="middle" class="lable1"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    </tr>
                  <tr>
                    <td height="2" align="center" valign="middle"></td>
                    </tr>
                  <tr>
                    <?php
						 if($res_student["photo"]!='')
						 {
						  $photo="../sa/photo/".$res_student["photo"];
						 }
						 else
						 {
							 $photo="../images/noimage.jpg";
						 }
					  ?>
                    <td align="center" valign="middle"><img width="80" height="90" src="<?php echo $photo;?>" /></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle"><span class="mytext"><?php echo $res_student["email"];?> : <?php echo constant("STUDENT_MYACCOUNT_EMAIL");?></span></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle"><span class="mytext"><?php echo $res_student["student_mobile"];?> : <?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?></span></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                  <tr>
                    <td width="16%" height="72" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="home.php"><img src="../home_icon/home.jpg" width="80" height="63" border="0" /></a></td>
                    <td width="16%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="myschedule.php"><img src="../home_icon/calendar_icon.png" width="70" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="myaccount.php"><img src="../home_icon/my_acc.jpg" width="60" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="progress_report.php"><img src="../home_icon/report_icon.jpg" width="60" height="56" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="leave_manage.php"><img src="../home_icon/abs.png" width="60" height="60" border="0" /></a></td>
                    <td width="17%" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="password.php"><img src="../home_icon/chg_pass.png" width="48" height="48" border="0" /></a></td>
                    </tr>
                  <tr class="lable1">
                    <td height="30" align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="myschedule.php" title="My schedule"><span><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="myaccount.php" ><span><?php echo constant("ADMIN_MENU_MY_ACCOUNT");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="progress_report.php" ><span><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></span></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="leave_manage.php" title="Leave"><?php echo constant("STUDENT_MENU_LEAVE");?></a></td>
                    <td align="center" valign="top" style="border-bottom:solid 1px; border-color:#cccccc;border-right:solid 1px; border-color:#cccccc;"><a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a></td>
                    </tr>
                  <tr>
                    <td height="72" align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="certificate_report.php"><img src="../home_icon/cert.png" width="64" height="64" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="calc_converter.php"><img src="../home_icon/calendar-icon.jpg" width="57" height="60" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="alert_page.php?choice=alert_respose&amp;page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"><img src="../home_icon/quick-link.png" width="60" height="60" border="0" /></a><a href="alert_page.php?choice=alert_respose&page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"></a></td>
                    <td align="center" valign="middle" style="border-right:solid 1px; border-color:#cccccc;">&nbsp;</td>
                    </tr>
                  <tr class="lable1">
                    <td height="30" align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="certificate_report.php" title="Certificates Grade"><span><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?></span></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("ADMIN_MENU_ALERTS");?></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"><a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;"></td>
                    <td align="center" valign="top" style="border-right:solid 1px; border-color:#cccccc;">&nbsp;</td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"></td>
                </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                  <?php 
				foreach($dbf->fetchOrder('student_enroll',"student_id='$students_id'","course_id") as $vals) {
				$course = $dbf->strRecordID("course","*","id='$vals[course_id]'");
				?>
                  <table width="425" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                    <tr>
                      <td align="left" valign="middle">
                        <?php
					$res_progress = $dbf->strRecordID("teacher_progress_course","*","course_id='$vals[course_id]' And student_id='$students_id'");
					//$res_progress["course_attendance_perc"]+
					$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_comp"];
					
					if($avg>0)
					{
						$avg = $avg / 7;
						$avg = round($avg,1);
					}
					
					//$at = $res_progress["course_attendance"];
					$parti = $res_progress["course_partication"];
					$home = $res_progress["course_homework"];
					$flu = $res_progress["course_fluency"];
					$pro = $res_progress["course_pro"];
					$gra = $res_progress["course_grammer"];
					$voca = $res_progress["course_voca"];
					$comp = $res_progress["course_listen"];
					
					$report_name = $Arabic->en2ar("Progress Reports for ($course[name])");
							
					echo $strXML="<chart caption='$report_name' xAxisName='' yAxisName='' showValues='0' decimals='0' formatNumberScale='0' chartRightMargin='30'>
									
									<set label='Parti' value='$parti'/>
									<set label='Home' value='$home'/>
									<set label='Flue' value='$flu'/>
									<set label='Pron' value='$pro'/>
									<set label='Gram' value='$gra'/>
									<set label='Voca' value='$voca'/>
									<set label='Comp' value='$comp'/>								
									<set label='Avg' value='$avg'/>
									</chart>";	
					 echo renderChartHTML("../FusionCharts/Charts/Column2D.swf", "", $strXML, "myNext", 420, 200);
					?>
                        </td>
                      </tr>
                    </table>
                  <?php } ?>
                  
                  </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
