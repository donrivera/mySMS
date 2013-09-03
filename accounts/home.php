<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../includes/FusionCharts.php';
include_once 'logout-check.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_SESSION['ALERT_DISPLAY'] == ''){
$alert_count = $dbf->countRows("alerts", "ac='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
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
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="left" valign="middle" bgcolor="#FFA938" class="centercolumntext" style="background:url(../images/footer_repeat.png) repeat-x;">&nbsp;&nbsp;<?php echo constant("ACCOUNTANT_DASHBOARD");?>
</td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="10" height="50">&nbsp;</td>
                <td width="45%" rowspan="2" align="left" valign="top" style="padding-top:15px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                    <tr>
                      <td height="30" align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="25%" height="72" align="center" valign="middle"><a href="home.php"><img src="../home_icon/home.jpg" width="80" height="63" border="0" /></a></td>
                      <td width="25%" align="center" valign="middle"><a href="search.php"><img src="../home_icon/student.jpg" width="70" height="60" border="0" /></a></td>
                      <td width="25%" align="center" valign="middle"><a href="course_manage.php"><img src="../home_icon/group.jpg" width="60" height="60" border="0" /></a></td>
                      <td width="25%" align="center" valign="middle"><a href="centre_schedule.php"><img src="../home_icon/center.jpg" width="60" height="56" border="0" /></a></td>
                    </tr>
                    <tr class="lable1">
                      <td height="30" align="center" valign="top"><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></td>
                      <td align="center" valign="top"><a href="search.php" title="Student" rel=""><span><?php echo constant("ADMIN_NEWS_MANAGE_STUDENT");?></span></a></td>
                      <td align="center" valign="top"><a href="course_manage.php" ><span><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></span></a></td>
                      <td align="center" valign="top"><a href="centre_schedule.php" ><span><?php echo constant("RE_MENU_CS");?></span></a></td>
                    </tr>
                    <tr>
                      <td height="72" align="center" valign="middle"><a href="password.php"><img src="../home_icon/chg_pass.png" width="60" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="calc_converter.php"><img src="../home_icon/calendar-icon.jpg" width="57" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="translate.php"><img src="../home_icon/converter_icon.jpg" width="60" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="move_to_beddebt.php"><img src="../home_icon/appoint.jpg" width="60" height="60" border="0" /></a></td>
                    </tr>
                    <tr class="lable1">
                      <td height="30" align="center" valign="top"><a href="password.php" title="Certificates Grade"><span><?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?></span></a></td>
                      <td align="center" valign="top"><a href="calc_converter.php" title="Date Convertor"><span><?php echo constant("STUDENT_MENU_DATE_CONVERTER");?></span></a></td>
                      <td align="center" valign="top"><a href="translate.php" title="Language Convertor"><span><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></span></a></td>
                      <td align="center" valign="top"><a href="move_to_beddebt.php" title="Alerts"><span><?php echo constant("AC_MOVETO_BED_DEBT");?></span></a></td>
                    </tr>
                    <tr>
                      <td height="70" align="center" valign="middle"><a href="alert1_manage.php"><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="sms.php"><img src="../home_icon/sms.jpg" width="60" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="email.php"><img src="../home_icon/emial.jpg" width="60" height="60" border="0" /></a></td>
                      <td align="center" valign="middle"><a href="news_manage.php"><img src="../home_icon/news.png" width="60" height="53" border="0" /></a></td>
                    </tr>
                    <tr class="lable1">
                      <td height="30" align="center" valign="top"><a href="alert1_manage.php"><?php echo constant("ADMIN_MENU_ALERTS");?></a></td>
                      <td align="center" valign="top"><a href="sms.php" title="Leave"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></td>
                      <td align="center" valign="top"><a href="email.php"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></a></td>
                      <td align="center" valign="top"><a href="news_manage.php"><?php echo constant("ADMIN_MENU_NEWS");?></a></td>
                    </tr>
                  </table>
                  </td>
                <td width="8%" align="left" valign="top">&nbsp;</td>
                <td width="47%" align="left" valign="middle" class="home_head_text"><table width="450" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF9900;">
                  <tr>
                    <td width="5%" height="25" align="center" valign="middle" bgcolor="#FEFAEB"><img src="../images/news.jpeg" width="18" height="21" /></td>
                    <td width="61%" align="left" valign="middle" bgcolor="#FEFAEB" class="red_smalltext">&nbsp;<?php echo constant("RECEPTION_HOME_LATESTNEWS");?></td>
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
                          <td width="26%" align="left" valign="middle" class="hometest_name"><?php echo constant("RECEPTION_HOME_POSTEDBYADMIN");?></td>
                          <td width="74%" align="left" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
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
                              <td width="11%" align="left" valign="middle" class="hometest_time"><?php echo constant("RECEPTION_HOME_MARKAS");?> : </td>
                              <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                              <td width="83%" align="left" valign="middle" class="hometest_time"><span class="hometest_name"><?php echo constant("RECEPTION_HOME_IMPORTANT");?></span></td>
                            </tr>
                          </table></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="hometest_time"><span class="hometest_name"><?php echo constant("RECEPTION_HOME_MSGTYPE");?></span> : <?php echo $valm["name"];?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="mycon"><?php echo $val["imp_info"];?></td>
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
                    <td align="left" valign="top"><table width="450" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                        <tr>
                          <td width="12%" align="center" valign="middle" bgcolor="#FEF0FF"><img src="../images/errror.png" width="25" height="25" /></td>
                          <td width="54%" align="left" valign="middle" bgcolor="#FEF0FF" class="red_smalltext">&nbsp;&nbsp;<?php echo constant("RECEPTION_HOME_LATESTALERTS");?></td>
                          <td width="34%" bgcolor="#FEF0FF">&nbsp;</td>
                        </tr>
                      </table>
<div id="dataDisplay">
  <?php
			  	$i = 1;
				foreach($dbf->fetchOrder('alerts',"(stu_ad='1' AND status='0') OR audience='1'","id DESC LIMIT 0,5") as $val) {
				?>
  				<table width="450" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="25" height="25" /></td>
                      <td width="4">&nbsp;</td>
                      <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="46%" align="left" valign="middle" class="hometest_name"><?php echo constant("RECEPTION_HOME_POSTEDBYADMIN");?></td>
                          <td width="54%" align="left" valign="middle" class="hometest_time"><?php echo date("l, d M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
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
                              <td width="11%" align="left" valign="middle" class="hometest_time"><?php echo constant("RECEPTION_HOME_MARKAS");?> : </td>
                              <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                              <td width="83%" align="left" valign="middle" class="hometest_time"><span class="hometest_name"><?php echo constant("RECEPTION_HOME_URGENT");?></span></td>
                            </tr>
                          </table></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="mycon"><?php echo $val["imp_info"];?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php
                    foreach($dbf->fetchOrder('alerts_reply',"alert_id='$val[id]'","id") as $val_r) {
						
						$res_user = $dbf->strRecordID("user","*","id='$val_r[user_id]'");
					?>
                    <tr>
                      <td width="64" align="center" valign="middle"><img src="../images/user.png" width="24" height="24" /></td>
                      <td width="4">&nbsp;</td>
                      <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="45%" align="left" valign="middle" class="hometest_name"><?php echo constant("RECEPTION_HOME_POSTEDBY");?> <?php echo $res_user[user_name];?></td>
                          <td width="55%" align="left" valign="middle" class="hometest_time"><?php echo date("l, d M Y",strtotime($val_r["date_time"]));?>&nbsp;,<?php echo date("h:i A",strtotime($val_r["date_time"]));?></td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                          <td height="5"></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="left" valign="top" class="mycon"><?php echo $val_r["msg"];?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="25" colspan="3" align="right" valign="middle"><img src="../images/reply.png" width="46" height="22" onclick="show_a(<?php echo $i;?>)" /></td>
                    </tr>
                    <tr>
                      <td height="10" colspan="3"><div id="diva<?php echo $i;?>" style="display:none;">
                        <form action="home_process.php?action=insert&amp;row=<?php echo $i;?>" name="frma<?php echo $i;?>" method="post" id="frma<?php echo $i;?>" onsubmit="return validate(<?php echo $i;?>);">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="14%" align="left" valign="middle" class="hometest_name">&nbsp;</td>
                              <td width="86%" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="30%" height="25" align="left" valign="middle" class="hometest_name">&nbsp;&nbsp;Reply Message</td>
                                  <td width="58%">&nbsp;</td>
                                  <td width="12%"><input type="hidden" name="aid<?php echo $i;?>" id="aid<?php echo $i;?>" value="<?php echo $val[id];?>" /></td>
                                </tr>
                                <tr>
                                  <td colspan="3" align="left" valign="middle">&nbsp;
                                    <textarea name="msg<?php echo $i;?>" id="msg<?php echo $i;?>" cols="45" rows="3" style="border:solid 1px; border-color:#5A79A8;"></textarea></td>
                                </tr>
                                <tr>
                                  <td height="5" colspan="3" align="left" valign="middle" class="hometest_name"></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="right" valign="middle"><input type="image" src="../images/post.png" width="46" height="22" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                        </form>
                      </div></td>
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
                 </table>
                 </td>
              
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                
                </td>
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
</body>
</html>
