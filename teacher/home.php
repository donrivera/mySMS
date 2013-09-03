<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_SESSION['ALERT_DISPLAY'] == ''){
$alert_count = $dbf->countRows("alerts", "teacher='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
}
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
<script type="text/javascript" src="dropdowntabs.js"></script>

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
	//var res="<div style='width:300px;height:200px;border:2px solid red;'class='post_review_main'> bye bye</div>";
	$.post("alert_page.php",{"choice":"alert_respose"},function(res){
		$.fancybox(res,{centerOnScroll:true,hideOnOverlayClick:false});
	});
	
	}
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds

// Alert set 1 time by session
$_SESSION['ALERT_DISPLAY'] = 'TRUE';
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">&nbsp; <?php echo constant("TEACHER_HOME_DASHBOARD");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="10" height="50">&nbsp;</td>
                <td width="45%" rowspan="2" align="left" valign="top" style="padding-top:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                  <tr>
                    <td height="30" align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="25%" height="72" align="center" valign="middle"><a href="home.php"><img src="../home_icon/home.jpg" width="80" height="63" border="0" /></a></td>
                    <td width="25%" align="center" valign="middle"><a href="my_groups.php"><img src="../home_icon/group.jpg" width="70" height="60" border="0" /></a></td>
                    <td width="25%" align="center" valign="middle"><a href="my_schedules.php"><img src="../home_icon/calendar_icon.png" width="60" height="60" border="0" /></a></td>
                    <td width="25%" align="center" valign="middle"><a href="report_teacher_progress.php"><img src="../home_icon/report_icon.jpg" width="60" height="56" border="0" /></a></td>
                  </tr>
                  <tr class="lable1">
                    <td height="30" align="center" valign="top" class="mymenutext"><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></td>
                    <td align="center" valign="top" class="mymenutext"><a href="my_groups.php" title="My schedule" rel=""><?php echo constant("TE_MENU_MY_GROUP");?></a></td>
                    <td align="center" valign="top" class="mymenutext"><a href="my_schedules.php" ><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></a></td>
                    <td align="center" valign="top" class="mymenutext"><a href="report_teacher_progress.php" ><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></a></td>
                  </tr>
                  <tr>
                    <td height="72" align="center" valign="middle"><a href="report_center_director.php"><img src="../home_icon/cert.png" width="64" height="64" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="calc_converter.php"><img src="../home_icon/calendar-icon.jpg" width="57" height="60" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="translate.php"><img src="../home_icon/converter_icon.jpg" width="60" height="60" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="alert_page.php?choice=alert_respose&page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a></td>
                  </tr>
                  <tr class="mymenutext">
                    <td height="30" align="center" valign="top"><a href="report_center_director.php" title="Certificates Grade"><span><?php echo constant("TE_MENU_CR");?></span></a></td>
                    <td align="center" valign="top"><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></td>
                    <td align="center" valign="top"><a href="translate.php" title="Language Convertor"><span><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></span></a></td>
                    <td align="center" valign="top"><a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("ADMIN_MENU_ALERTS");?></a></td>
                  </tr>
                  <tr>
                    <td height="70" align="center" valign="middle"><a href="ped.php"><img src="../home_icon/time_attendance.png" width="60" height="60" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="leave_manage.php"><img src="../home_icon/abs.png" width="60" height="60" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="password.php"><img src="../home_icon/chg_pass.png" width="48" height="48" border="0" /></a></td>
                    <td align="center" valign="middle"><a href="quicklink_manage.php"><img src="../home_icon/quick-link.png" width="60" height="60" border="0" /></a></td>
                  </tr>
                  <tr class="mymenutext">
                    <td height="30" align="center" valign="top"><a href="ped.php"><?php echo constant("TE_MENU_EPEDCARD");?></a></td>
                    <td align="center" valign="top"><a href="leave_manage.php" title="Leave"><span><?php echo constant("STUDENT_MENU_LEAVE");?></span></a></td>
                    <td align="center" valign="top"><a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a></td>
                    <td align="center" valign="top"><a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a></td>
                  </tr>
                </table></td>
                <td width="8%" align="left" valign="top">&nbsp;</td>
                <td width="47%" align="left" valign="middle" class="home_head_text"><table width="92%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                  <tr>
                    <td width="5%" height="25" align="center" valign="middle" bgcolor="#FEFAEB"><img src="../images/news.jpeg" width="18" height="21" /></td>
                    <td width="61%" align="left" valign="middle" bgcolor="#FEFAEB" class="red_smalltext">&nbsp;<?php echo constant("TEACHER_HOME_LATEST_NEWS");?></td>
                    <td width="34%" bgcolor="#FEFAEB">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td width="10" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                 <table cellpadding="0" cellspacing="0" border="0">
                 <tr>
                  <td>
                    <div id="DisplayInfo">
                  <?php
                $i = 1;
                foreach($dbf->fetchOrder('news',"(stu_ad='1' AND status='0') OR audience='1'","id DESC LIMIT 0,5") as $val) {
                ?>
                  <table width="450" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                      <td width="4">&nbsp;</td>
                      <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="32%" align="left" valign="middle" class="hometest_name"><?php echo constant("TEACHER_HOME_PSTBYADMIN");?> </td>
                          <td width="68%" align="left" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                          <td height="5"></td>
                        </tr>
                        <?php $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                        <?php if($val["imp"]=="1") { ?>
                        <tr>
                          <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="16%" align="left" valign="middle" class="mytext"><?php echo constant("TEACHER_HOME_MARKAS");?> : </td>
                              <td width="4%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                              <td width="83%" align="left" valign="middle" class="hometest_time"><?php echo constant("TEACHER_HOME_IMPORTANT");?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("TEACHER_HOME_MSGTYPE");?> : <?php echo $valm["name"];?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="mytext"><?php echo $val["imp_info"];?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="10" colspan="3"></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                    </tr>
                  </table>
                  <?php $i++; } ?>
                </div>
                  </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                  </td>
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
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
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
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" align="right" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("TEACHER_HOME_DASHBOARD");?>&nbsp;</td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td width="10" height="50">&nbsp;</td>
                      <td width="45%" rowspan="2" align="left" valign="top" style="padding-top:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                        <tr>
                          <td height="30" align="center" valign="middle">&nbsp;</td>
                          <td align="center" valign="middle">&nbsp;</td>
                          <td align="center" valign="middle">&nbsp;</td>
                          <td align="center" valign="middle">&nbsp;</td>
                          </tr>
                        <tr>
                          <td width="25%" height="72" align="center" valign="middle"><a href="home.php"><img src="../home_icon/home.jpg" width="80" height="63" border="0" /></a></td>
                          <td width="25%" align="center" valign="middle"><a href="my_groups.php"><img src="../home_icon/group.jpg" width="70" height="60" border="0" /></a></td>
                          <td width="25%" align="center" valign="middle"><a href="my_schedules.php"><img src="../home_icon/calendar_icon.png" width="60" height="60" border="0" /></a></td>
                          <td width="25%" align="center" valign="middle"><a href="report_teacher_progress.php"><img src="../home_icon/report_icon.jpg" width="60" height="56" border="0" /></a></td>
                          </tr>
                        <tr class="lable1">
                          <td height="30" align="center" valign="top" class="mymenutext"><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></td>
                          <td align="center" valign="top" class="mymenutext"><a href="my_groups.php" title="My schedule" rel=""><?php echo constant("TE_MENU_MY_GROUP");?></a></td>
                          <td align="center" valign="top" class="mymenutext"><a href="my_schedules.php" ><?php echo constant("STUDENT_MENU_MY_SCHEDULE");?></a></td>
                          <td align="center" valign="top" class="mymenutext"><a href="report_teacher_progress.php" ><?php echo constant("STUDENT_MENU_MY_PROGRESS");?></a></td>
                          </tr>
                        <tr>
                          <td height="72" align="center" valign="middle"><a href="report_center_director.php"><img src="../home_icon/cert.png" width="64" height="64" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="calc_converter.php"><img src="../home_icon/calendar-icon.jpg" width="57" height="60" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="translate.php"><img src="../home_icon/converter_icon.jpg" width="60" height="60" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="alert_page.php?choice=alert_respose&page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a></td>
                          </tr>
                        <tr class="mymenutext">
                          <td height="30" align="center" valign="top"><a href="report_center_director.php" title="Certificates Grade"><span><?php echo constant("TE_MENU_CR");?></span></a></td>
                          <td align="center" valign="top"><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></td>
                          <td align="center" valign="top"><a href="translate.php" title="Language Convertor"><span><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></span></a></td>
                          <td align="center" valign="top"><a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("ADMIN_MENU_ALERTS");?></a></td>
                          </tr>
                        <tr>
                          <td height="70" align="center" valign="middle"><a href="ped.php"><img src="../home_icon/time_attendance.png" width="60" height="60" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="leave_manage.php"><img src="../home_icon/abs.png" width="60" height="60" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="password.php"><img src="../home_icon/chg_pass.png" width="48" height="48" border="0" /></a></td>
                          <td align="center" valign="middle"><a href="quicklink_manage.php"><img src="../home_icon/quick-link.png" width="60" height="60" border="0" /></a></td>
                          </tr>
                        <tr class="mymenutext">
                          <td height="30" align="center" valign="top"><a href="ped.php"><?php echo constant("TE_MENU_EPEDCARD");?></a></td>
                          <td align="center" valign="top"><a href="leave_manage.php" title="Leave"><span><?php echo constant("STUDENT_MENU_LEAVE");?></span></a></td>
                          <td align="center" valign="top"><a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a></td>
                          <td align="center" valign="top"><a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a></td>
                          </tr>
                        </table></td>
                      <td width="8%" align="left" valign="top">&nbsp;</td>
                      <td width="47%" align="left" valign="middle" class="home_head_text"><table width="450" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                          <tr>
                            <td width="5%" height="25" align="center" valign="middle" bgcolor="#EAEDFF">&nbsp;</td>
                            <td width="86%" align="right" valign="middle" bgcolor="#EAEDFF" class="red_smalltext">&nbsp;<?php echo constant("STUDENT_ADVISOR_HOME_LATESTNEWS");?></td>
                            <td width="9%" align="center" bgcolor="#EAEDFF"><img src="../images/news.jpeg" width="18" height="21" /></td>
                            </tr>
                          </table></td>
                      </tr>
                    <tr>
                      <td width="10" align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td>
                              <div id="DisplayInfo">
                                <?php
								$i = 1;
								foreach($dbf->fetchOrder('news',"(teacher='1' AND status='0') OR audience='1'","id DESC LIMIT 0,5") as $val) {
								?>
                                <table width="450" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        
                                        <td width="74%" align="right" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                                        <td width="26%" align="right" valign="middle" class="hometest_name"><?php echo constant("STUDENT_ADVISOR_HOME_POSTEDBYADMIN");?>  </td>
                                        </tr>
                                      <tr>
                                        <td height="5"></td>
                                        <td height="5"></td>
                                        </tr>
                                      <?php $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                                      <?php if($val["imp"]=="1") { ?>
                                      <tr>
                                        <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="83%" align="right" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_HOME_IMPORTANT");?></td>
                                            <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16"></td>
                                            
                                            <td width="11%" align="left" valign="middle" class="hometest_time"> : <?php echo constant("STUDENT_ADVISOR_HOME_MARKAS");?></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                      <?php } ?>
                                      <tr>
                                        <td colspan="2" align="right" valign="top" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_HOME_MSGTYPE");?> : <?php echo $valm["name"];?></td>
                                        </tr>
                                      <tr>
                                        <td colspan="2" align="right" valign="top" class="mycon"><?php echo $val["imp_info"];?></td>
                                        </tr>
                                      </table></td>
                                    <td width="4">&nbsp;</td>
                                    <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="3"></td>
                                    </tr>
                                  <tr>
                                    <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                                    </tr>
                                  </table>
                                <?php $i++; } ?>
                                                                
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            </tr>
                          </table>
                        </td>
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
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
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
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
