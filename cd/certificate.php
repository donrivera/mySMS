<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#FFFFFF;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
h1,h2,h3,h4,h5,h6 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
h1 {
	font-size: 12px;
	color: #000000;
}
h2 {
	font-size: 14px;
	color: #000000;
}
-->
.cer_my_head{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#000000;
font-weight:normal;
}
.cer_my_head_bold{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#000000;
font-weight:bold;
}
.cer_my_cer_head_bold{
font-family:"Monotype Corsiva";
font-size:18px;
color:#000000;
font-weight:bold;
font-style:italic;
}
</style>
</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<script type="text/javascript">
function setsubmit()
{
	var student = document.getElementById('student').value;
	var course_id = document.getElementById('course_id').value;
	document.location.href='certificate.php?student='+student+'&course_id='+course_id;
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN"){?>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#e6e6e6">
              <form name="frm" id="frm" method="post">
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    
                    <td width="234"  height="30" align="left" valign="middle" style="padding-left:12px;">
                      <select id="student" name="student" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="setsubmit();">
                        <option value="">--Select Student--</option>
                        <?php
						foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d',"m.centre_id='$_SESSION[centre_id]' And m.id=d.parent_id And s.id=d.student_id And m.status='Completed'","s.first_name","s.id,s.first_name","s.id") as $val) {
						?>
                        <option value="<?php echo $val[id]; ?>"<?php if($_REQUEST[student]==$val["id"]){?> selected="selected"<?php } ?>><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
                        <?php 
						  }
						  ?>
                        </select></td>                    
                    <td width="265" align="left" valign="middle" class="pedtext">
                    <?php
					//If the students balance should be Zero
					$bal_amt = $dbf->BalanceAmount($_REQUEST["student"],$_REQUEST["course_id"]);
					if($bal_amt <= 0){
					?>
                    <a href="certificate_condition.php?course_id=<?php echo $_REQUEST[course_id];?>&student_id=<?php echo $_REQUEST[student];?>" target="_blank"><?php if($_REQUEST[student]!="" && $_REQUEST[course_id]!=''){ ?><img src="../images/print.png" width="16" height="16" border="0" title="Print"/><?php } ?></a>
                    <?php } ?>
                    <a href="search_groupname.php?page=search_groupname.php&amp;TB_iframe=true&amp;height=200&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a>
                    </td>
                    <td width="627" align="left" valign="middle" class="pedtext"></td>
                    
                    </tr>
                  <tr>
                    <td  height="30" align="left" valign="middle" style="padding-left:12px;">
                    <select id="course_id" name="course_id" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onchange="setsubmit();">
                      <option value="">--Select Course--</option>
                      <?php
						foreach($dbf->fetchOrder('course c,student_group m,student_group_dtls d',"m.id=d.parent_id And m.status='Completed' And c.id=d.course_id And d.student_id='$_REQUEST[student]'","c.name","c.*") as $valc) {
						?>
                      <option value="<?php echo $valc[id]; ?>"<?php if($_REQUEST[course_id]==$valc["id"]){?> selected="selected" <?php } ?>><?php echo $valc[name]; ?></option>
                      <?php
						  }
						  ?>
                    </select></td>
                    <td align="left" valign="middle">
                     <?php
                    if($bal_amt > 0){
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
					?>
                    <table width="100%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="52%" height="25" align="right" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
                        <td width="48%" align="left" valign="middle" bgcolor="#FFF7D5" class="nametext1">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      </tr>
                    </table>
                    <?php } ?>                    
                    </td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <?php
					$res = $dbf->strRecordID("student","*","id='$_REQUEST[student]'"); 
					$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
									
					$course_name = $dbf->strRecordID("course","*","id='$_REQUEST[course_id]'");
					$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$_REQUEST[student]' And course_id='$_REQUEST[course_id]'");
					$res_g = $dbf->strRecordID("student_group","*","id='$res_enroll[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
					$total_units = $res_size[units];
					
					$or_unit = $res_size[units];
					$per_unit = 45; //minute
					$tot_unit = $or_unit * $per_unit;
					$hr = $tot_unit / 60;
					?>
                  <tr>
                    
                    <td colspan="3" align="center" valign="top">
                    
                    <table width="1100" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000;" bgcolor="#FFFFFF">
                        <tr>
                          <td width="115"><img src="../images/left-img.jpg" alt="left-img" width="125" height="670" /></td>
                          <td width="827" align="left" valign="top"><table width="850" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                            <tr>
                              <td height="28">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="top"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="227" align="center" valign="middle" ><p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                                    <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                                    <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />Ministry of Education - Al Ahsa <br />(Male)</span></strong><br /><strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p>
                                    </td>
                                  <td width="364" align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                                  <td width="309" align="right" valign="middle">
                                  <table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="255" valign="top">
                                      <p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
                                        معهد دار الخبرة لتعليم اللغة الإنجليزية<br />
                                        تحت اشراف وزارة التربية والتعليم<br />
                                        الإدارة العامة للتربية والتعليم بمحافظة الاحساء <br />
                                        (بنين)<br />
                                        ترخيص رقم: 05023006&nbsp;&nbsp;</p></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="40" align="center" valign="middle"><p align="center" dir="rtl" class="cer_my_head_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شهادة اجتياز دورة في اللغة الانجليزية</p></td>
                              </tr>
                            <tr>
                              <td align="center" valign="middle" class="cer_my_cer_head_bold">A CERTIFICATE OF ACHIEVEMENT IN ENGLISH LANGUAGE</td>
                              </tr>
                            <tr>
                              <td height="12"></td>
                              </tr>
                            <tr>
                              <td align="center" valign="middle" style="background:url(../images/body-bg1.jpg)  no-repeat center; width:10px;">
                              <table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="400" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
                                      </tr>
                                    
                                    <tr>
                                      <th height="21" align="left" valign="middle" scope="col" class="cer_my_head">This is to certify that</th>
                                    </tr>
                                      <?php
									  if($res[gender]=='female'){
										  $gender = 'Ms.';
									  }else{
										  $gender = 'Mr.';
									  }
									  ?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?>&nbsp;</span><span class="cer_my_head_bold"><?php echo $res[first_name];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php if($res[student_id]>0) { echo $res[student_id]; } ?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name[name];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g[end_date];?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                      <?php
										include_once '../includes/hijri.php';
										
										$DateConv=new Hijri_GregorianConvert;
										$format="YYYY/MM/DD";
										
										//Start date
										$date=$res_g[start_date];
										$sdt = $DateConv->GregorianToHijri($date,$format);
										
										//End date
										$date=$res_g[end_date];
										$edt = $DateConv->GregorianToHijri($date,$format);
										?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($_REQUEST[student] !='' ) { ?> <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?> <?php } ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($_REQUEST[student] !='' ) { ?><?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?><?php } ?>
                                        </span></th>
                                      </tr>
                                      <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$_REQUEST[course_id]' And student_id='$_REQUEST[student]'");
								  $res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
								  ?>  
                                    </table>
                                  <br />
                                  <span class="cer_my_head">and received a final grade of </span> <span class="cer_my_head_bold"><?php echo $res_grade["name"];?> , <?php echo $res_per["final_percent"];?> % </span></td>
                                  <td width="400" align="right" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <th height="20" align="right" valign="middle" scope="col">&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer9_arial" scope="col"><span class="cer_my_head_bold" dir="rtl">يشهد معهد دار الخبرة لتعليم اللغة  الانجليزية بالاحساء</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $res[arabic_name];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $Arabic->en2ar($resc[value]);?></span><span class="cer_my_head_bold">&nbsp;:<span dir="rtl">الجنسية  </span> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" >&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<span class="cer_my_head_bold"><?php if($res[student_id]>0) { echo $dbf->enNo2ar($res[student_id],''); } ?></span></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $Arabic->en2ar($course_name[name]);?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g[start_date],'-');?>   إلى: <?php echo $dbf->enNo2ar($res_g[end_date],'-');?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($_REQUEST[student] !='' ) { if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');}} ?>إلى: <?php if($_REQUEST[student] !='' ) { if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');}} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير   <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %  , ونسبة  <?php echo $Arabic->en2ar($res_grade["name"]);?></span></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td class="cer_my_head"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="450" align="left" valign="middle">Berlitz issued this certificate in recognition of the above. </td>
                                    <td width="450" align="right" valign="middle" class="cer9_arial_bold"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td height="20">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="349" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
                                    <p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br />
                                      <strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p>
                                    </td>
                                  <td width="94">&nbsp;</td>
                                  <td width="87" align="center" valign="middle"><p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br />
                                    <strong><span dir="ltr">Stamp</span></strong></p></td>
                                  <td width="115">&nbsp;</td>
                                  <td width="255" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
                                    <strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
                                    <strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="loginheading">
                              </td>
                            </tr>
                            </table></td>
                          </tr>
                        </table>
                    
                    </td>
                    
                    </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
  </table>	
                </form>		</td>
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
<?php }else{ ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#e6e6e6">
              <form name="frm" id="frm" method="post">
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    
                    <td width="239"  height="30" align="left" valign="middle" style="padding-left:12px;">
                      <select id="student" name="student" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="setsubmit();">
                        <option value="">--Select Student--</option>
                        <?php
						foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d',"m.centre_id='$_SESSION[centre_id]' And m.id=d.parent_id And s.id=d.student_id And m.status='Completed'","s.first_name","s.id,s.first_name","s.id") as $val) {
						?>
                        <option value="<?php echo $val[id]; ?>"<?php if($_REQUEST[student]==$val["id"]){?> selected="selected"<?php } ?>><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></option>
                        <?php 
						  }
						  ?>
                        </select></td>                    
                    <td width="761" align="left" valign="middle" class="pedtext">
                    <?php
					//If the students balance should be Zero
					$bal_amt = $dbf->BalanceAmount($_REQUEST["student"],$_REQUEST["course_id"]);
					if($bal_amt <= 0){
					?>
                    <a href="certificate_condition.php?course_id=<?php echo $_REQUEST[course_id];?>&student_id=<?php echo $_REQUEST[student];?>" target="_blank"><?php if($_REQUEST[student]!="" && $_REQUEST[course_id]!=''){ ?><img src="../images/print.png" width="16" height="16" border="0" title="Print"/><?php } ?></a>
                    <?php } ?>
                    <a href="search_groupname.php?page=search_groupname.php&amp;TB_iframe=true&amp;height=200&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("RECEPTION_SMS_SEARCHFORSTUDENT");?></a>
                    </td>
                    
                    </tr>
                  <tr>
                    <td  height="30" align="left" valign="middle" style="padding-left:12px;">
                    <select id="course_id" name="course_id" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onchange="setsubmit();">
                      <option value="">--Select Course--</option>
                      <?php
						foreach($dbf->fetchOrder('course c,student_group m,student_group_dtls d',"m.id=d.parent_id And m.status='Completed' And c.id=d.course_id And d.student_id='$_REQUEST[student]'","c.name","c.*") as $valc) {
						?>
                      <option value="<?php echo $valc[id]; ?>"<?php if($_REQUEST[course_id]==$valc["id"]){?> selected="selected" <?php } ?>><?php echo $valc[name]; ?></option>
                      <?php
						  }
						  ?>
                    </select></td>
                    <td align="left" valign="middle">
                     <?php
                    if($bal_amt > 0){
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
					?>
                    <table width="30%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="52%" height="25" align="right" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
                        <td width="48%" align="left" valign="middle" bgcolor="#FFF7D5" class="nametext1">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      </tr>
                    </table>
                    <?php } ?>                    
                    </td>
                  </tr>
                  <?php
					$res = $dbf->strRecordID("student","*","id='$_REQUEST[student]'"); 
					$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
									
					$course_name = $dbf->strRecordID("course","*","id='$_REQUEST[course_id]'");
					$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$_REQUEST[student]' And course_id='$_REQUEST[course_id]'");
					$res_g = $dbf->strRecordID("student_group","*","id='$res_enroll[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
					$total_units = $res_size[units];
					
					$or_unit = $res_size[units];
					$per_unit = 45; //minute
					$tot_unit = $or_unit * $per_unit;
					$hr = $tot_unit / 60;
					?>
                  <tr>
                    
                    <td colspan="2" align="center" valign="top">
                    
                    <table width="1100" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000;" bgcolor="#FFFFFF">
                        <tr>
                          <td width="115"><img src="../images/left-img.jpg" alt="left-img" width="125" height="670" /></td>
                          <td width="827" align="left" valign="top"><table width="850" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                            <tr>
                              <td height="28">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="top"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="227" align="center" valign="middle" ><p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                                    <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                                    <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />Ministry of Education - Al Ahsa <br />(Male)</span></strong><br /><strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p>
                                    </td>
                                  <td width="364" align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                                  <td width="309" align="right" valign="middle">
                                  <table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="255" valign="top">
                                      <p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
                                        معهد دار الخبرة لتعليم اللغة الإنجليزية<br />
                                        تحت اشراف وزارة التربية والتعليم<br />
                                        الإدارة العامة للتربية والتعليم بمحافظة الاحساء <br />
                                        (بنين)<br />
                                        ترخيص رقم: 05023006&nbsp;&nbsp;</p></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="40" align="center" valign="middle"><p align="center" dir="rtl" class="cer_my_head_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شهادة اجتياز دورة في اللغة الانجليزية</p></td>
                              </tr>
                            <tr>
                              <td align="center" valign="middle" class="cer_my_cer_head_bold">A CERTIFICATE OF ACHIEVEMENT IN ENGLISH LANGUAGE</td>
                              </tr>
                            <tr>
                              <td height="12"></td>
                              </tr>
                            <tr>
                              <td align="center" valign="middle" style="background:url(../images/body-bg1.jpg)  no-repeat center; width:10px;">
                              <table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="400" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
                                      </tr>
                                    
                                    <tr>
                                      <th height="21" align="left" valign="middle" scope="col" class="cer_my_head">This is to certify that</th>
                                    </tr>
                                      <?php
									  if($res[gender]=='female'){
										  $gender = 'Ms.';
									  }else{
										  $gender = 'Mr.';
									  }
									  ?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?>&nbsp;</span><span class="cer_my_head_bold"><?php echo $res[first_name];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php if($res[student_id]>0) { echo $res[student_id]; } ?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name[name];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g[end_date];?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                      <?php
										include_once '../includes/hijri.php';
										
										$DateConv=new Hijri_GregorianConvert;
										$format="YYYY/MM/DD";
										
										//Start date
										$date=$res_g[start_date];
										$sdt = $DateConv->GregorianToHijri($date,$format);
										
										//End date
										$date=$res_g[end_date];
										$edt = $DateConv->GregorianToHijri($date,$format);
										?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($_REQUEST[student] !='' ) { ?> <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?> <?php } ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($_REQUEST[student] !='' ) { ?><?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?><?php } ?>
                                        </span></th>
                                      </tr>
                                      <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$_REQUEST[course_id]' And student_id='$_REQUEST[student]'");
								  $res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
								  ?>  
                                    </table>
                                  <br />
                                  <span class="cer_my_head">and received a final grade of </span> <span class="cer_my_head_bold"><?php echo $res_grade["name"];?> , <?php echo $res_per["final_percent"];?> % </span></td>
                                  <td width="400" align="right" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <th height="20" align="right" valign="middle" scope="col">&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer9_arial" scope="col"><span class="cer_my_head_bold" dir="rtl">يشهد معهد دار الخبرة لتعليم اللغة  الانجليزية بالاحساء</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $res[arabic_name];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $Arabic->en2ar($resc[value]);?></span><span class="cer_my_head_bold">&nbsp;:<span dir="rtl">الجنسية  </span> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" >&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<span class="cer_my_head_bold"><?php if($res[student_id]>0) { echo $dbf->enNo2ar($res[student_id],''); } ?></span></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $Arabic->en2ar($course_name[name]);?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g[start_date],'-');?>   إلى: <?php echo $dbf->enNo2ar($res_g[end_date],'-');?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($_REQUEST[student] !='' ) { if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');}} ?>إلى: <?php if($_REQUEST[student] !='' ) { if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');}} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير   <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %  , ونسبة  <?php echo $Arabic->en2ar($res_grade["name"]);?></span></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td class="cer_my_head"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="450" align="left" valign="middle">Berlitz issued this certificate in recognition of the above. </td>
                                    <td width="450" align="right" valign="middle" class="cer9_arial_bold"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
                              <td height="20">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle"><table width="850" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="349" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
                                    <p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br />
                                      <strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p>
                                    </td>
                                  <td width="94">&nbsp;</td>
                                  <td width="87" align="center" valign="middle"><p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br />
                                    <strong><span dir="ltr">Stamp</span></strong></p></td>
                                  <td width="115">&nbsp;</td>
                                  <td width="255" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
                                    <strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
                                    <strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="loginheading">
                              </td>
                            </tr>
                            </table></td>
                          </tr>
                        </table>
                    
                    </td>
                    
                    </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    </tr>
  </table>	
                </form>		</td>
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
<?php } ?>
</body>
</html>
