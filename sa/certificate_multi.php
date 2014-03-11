<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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

$group_id = $_REQUEST["cmbgroup"];
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
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
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
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}

function setsubmit(){
	
	var cmbgroup = document.getElementById('cmbgroup').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='certificate_multi.php?cmbgroup='+cmbgroup+'&mystatus='+mystatus;
	
	//var group_id = document.getElementById('group_id').value;
	//document.location.href='certificate_multi.php?group_id='+group_id;
}
$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ped_group.php", {status: $(this).val()}); // Page Name and Condition
	});
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  
          <tr>
            <td height="450" align="left" valign="top" >
            <table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td height="30" align="left" valign="middle">
                <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                <option value="">All</option>
                <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                </select>
                </td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="8%">&nbsp;</td>
                <td width="20%" height="30" align="left" valign="middle" id="statusresult">
                <select id="cmbgroup" name="cmbgroup" style="border:solid 1px; border-color:#999999; height:20px; width:150px;" onChange="setsubmit();">
                <option value="">--<?php echo constant("SELECT_GROUP");?>--</option>
                <?php
                if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
				foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"group_name") as $val) {
                ?>
                <option value="<?php echo $val[id];?>"<?php if($group_id==$val["id"]){?> selected="selected"<?php } ?>><?php echo $val['group_name'] ?>, <?php echo date('d/m/Y',strtotime($val['start_date']));?> - <?php echo date('d/m/Y',strtotime($val['end_date'])) ?>, <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></option>
                <?php
                  }
                  ?>
                </select>
                </td>
                <td width="72%" align="left" valign="middle">
                <a href="print_certificate_multi.php?group_id=<?php echo $group_id;?>" target="_blank"><?php if($group_id!=""){ ?>
                <img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/>
				<?php } ?></a>
                </td>
              </tr>
            </table>
              <form name="frm" id="frm" method="post">
              <?php			  
			  foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And m.id='$group_id'") as $val_my_group) {
			  ?>
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
                  <?php
					$student_id = $val_my_group["student_id"];
					$course_id = $val_my_group["course_id"];
					
					$res = $dbf->strRecordID("student","*","id='$student_id'"); 
					$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
					
					$course_name = $dbf->strRecordID("course","*","id='$course_id'");
					$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
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
                                  <td width="227" align="center" valign="middle" >
									<!--
									<p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                                    <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                                    <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />Ministry of Education - Al Ahsa <br />(Male)</span></strong><br /><strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p>
                                    -->
								   </td>
                                  <td width="364" align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                                  <td width="309" align="right" valign="middle">
                                  <table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="255" valign="top">
									  <!--
                                      <p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
                                        معهد دار الخبرة لتعليم اللغة الإنجليزية<br />
                                        تحت اشراف وزارة التربية والتعليم<br />
                                        الإدارة العامة للتربية والتعليم بمحافظة الاحساء <br />
                                        (بنين)<br />
                                        ترخيص رقم: 05023006&nbsp;&nbsp;</p>
										-->
										</td>
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
                              <td align="center" valign="middle" class="cer_my_cer_head_bold">A CERTIFICATE OF ACHIEVEMENT IN THE ENGLISH LANGUAGE</td>
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
									  <?php $gender=($res[gender]=='female'?'Ms.':'Mr.');?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?>&nbsp;</span><span class="cer_my_head_bold"><?php echo $res['first_name']."&nbsp;".$res['father_name']."&nbsp;".$res['family_name'];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc["value"];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php if($res["student_id"]>0) { echo $res["student_id"]; } ?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name["name"];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g["start_date"];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g["end_date"];?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                      <?php
										include_once '../includes/hijri.php';
										
										$DateConv=new Hijri_GregorianConvert;
										$format="YYYY/MM/DD";
										
										//Start date
										$date = $res_g["start_date"];
										$sdt = $DateConv->GregorianToHijri($date,$format);
										
										//End date
										$date = $res_g["end_date"];
										$edt = $DateConv->GregorianToHijri($date,$format);
										?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $sdt;}?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $edt;}?>
                                        </span></th>
                                      </tr>
                                      <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
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
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $res['first_name1']."&nbsp;".$res['father_name1']."&nbsp;".$res['grandfather_name1']."&nbsp;".$res['family_name1'];#echo $Arabic->en2ar($res["first_name"]);?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">الجنسية:<?php echo $resc["arabic"];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" >&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<span class="cer_my_head_bold"><?php if($res["student_id"]>0) { echo $dbf->enNo2ar($res["student_id"],''); } ?></span></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name["name"];?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g["start_date"],'-');?>   إلى: <?php echo $dbf->enNo2ar($res_g["end_date"],'-');?></span></th>
                                      </tr>
                                    <!--
									<tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    -->
									<tr>
									  <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g["start_date"]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g["start_date"]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير  <?php echo $Arabic->en2ar($res_grade["name"]);?> , ونسبة  <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %</span></td>
                                  </tr>
                                </table></td>
                              </tr>
                            <tr>
								<td class="cer_my_head">
									<table width="850" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="450" align="left" valign="middle">Berlitz issued this certificate in recognition of the above. </td>
											<td width="450" align="right" valign="middle" class="cer9_arial_bold"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></td>
										</tr>
									</table>
								</td>
                            </tr>
                            <tr>
                              <td height="20">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle">
								<!--
								<table width="850" border="0" cellspacing="0" cellpadding="0">
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
										<strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong>
									</td>
									</tr>
								</table>
								-->
							   </td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="loginheading">
                              </td>
                            </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    
                    </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    </tr>
  </table>
  				<?php }?>
                <?php if($group_id == ''){?>
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
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
									<td width="227" align="center" valign="middle" >
									<!--
									<p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                                    <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                                    <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />Ministry of Education - Al Ahsa <br />(Male)</span></strong><br /><strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p>
                                    -->
									</td>
                                  <td width="364" align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                                  <td width="309" align="right" valign="middle">
                                  <table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="255" valign="top">
                                      <!--
									  <p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
                                        معهد دار الخبرة لتعليم اللغة الإنجليزية<br />
                                        تحت اشراف وزارة التربية والتعليم<br />
                                        الإدارة العامة للتربية والتعليم بمحافظة الاحساء <br />
                                        (بنين)<br />
                                        ترخيص رقم: 05023006&nbsp;&nbsp;</p>
										-->
										</td>
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
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Mr/Ms.&nbsp;</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name["name"];?></span><span class="cer_my_head"> with a total number of </span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g["start_date"];?> &nbsp;</span><span class="cer_my_head">to:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $sdt;}?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $edt;}?>
                                        </span></th>
                                      </tr>
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
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $res["arabic_name"];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">الجنسية:<?php echo $Arabic->en2ar($resc["value"]);?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" >&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<span class="cer_my_head_bold"><?php if($res["student_id"]>0) { echo $dbf->enNo2ar($res["student_id"],''); } ?></span></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name["name"];?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g["start_date"],'-');?>   إلى: <?php echo $dbf->enNo2ar($res_g["end_date"],'-');?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g["start_date"]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g["start_date"]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير  <?php echo $Arabic->en2ar($res_grade["name"]);?> , ونسبة  <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %</span></td>
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
                              <td align="left" valign="middle">
								<!--
								<table width="850" border="0" cellspacing="0" cellpadding="0">
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
								</table>
								-->
							   </td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="loginheading">
                              </td>
                            </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    
                    </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    </tr>
  				</table>
  				<?php } ?>
                </form>
                </td>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  
          <tr>
            <td height="450" align="left" valign="top" >
            <table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td height="30" align="left" valign="middle">
                <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                <option value="">All</option>
                <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                </select>
                </td>
                <td align="left" valign="middle"><span><a href="search_groupname.php?page=search_groupname.php&amp;TB_iframe=true&amp;height=200&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><?php echo constant("SEARCH_FOR_GROUPS");?></a></span></td>
              </tr>
              <tr>
                <td width="8%">&nbsp;</td>
                <td width="20%" height="30" align="left" valign="middle" id="statusresult">
                <select id="cmbgroup" name="cmbgroup" style="border:solid 1px; border-color:#999999; height:20px; width:150px;" onChange="setsubmit();">
                <option value="">--<?php echo constant("SELECT_GROUP");?>--</option>
                <?php
				if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
                foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond) as $val) {
                ?>
                <option value="<?php echo $val["id"];?>"<?php if($group_id==$val["id"]){?> selected="selected"<?php } ?>><?php echo $val['group_name'] ?>, <?php echo date('d/m/Y',strtotime($val['start_date']));?> - <?php echo date('d/m/Y',strtotime($val['end_date'])) ?>, <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></option>
                <?php
                  }
                  ?>
                </select>
                </td>
                <td width="72%" align="left" valign="middle">
                <a href="print_certificate_multi.php?group_id=<?php echo $group_id;?>" target="_blank"><?php if($group_id!=""){ ?>
                <img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/>
				<?php } ?></a>
                </td>
              </tr>
            </table>
              <form name="frm" id="frm" method="post">
              <?php			  
			  foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And m.id='$group_id'") as $val_my_group) {
			  ?>
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
                  <?php
				  $student_id = $val_my_group["student_id"];
				  $course_id = $val_my_group["course_id"];
				  
					$res = $dbf->strRecordID("student","*","id='$student_id'"); 
					$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
									
					$course_name = $dbf->strRecordID("course","*","id='$course_id'");
					$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
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
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Mr/Ms.&nbsp;</span><span class="cer_my_head_bold"><?php echo $res["first_name"];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc["value"];?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php if($res["student_id"]>0) { echo $res["student_id"]; } ?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name["name"];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g["start_date"];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g["end_date"];?> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                      <?php
										include_once '../includes/hijri.php';
										
										$DateConv=new Hijri_GregorianConvert;
										$format="YYYY/MM/DD";
										
										//Start date
										$date=$res_g["start_date"];
										$sdt = $DateConv->GregorianToHijri($date,$format);
										
										//End date
										$date=$res_g["end_date"];
										$edt = $DateConv->GregorianToHijri($date,$format);
										?>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $sdt;}?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($res_g["start_date"]!='0000-00-00') { echo $edt;}?>
                                        </span></th>
                                      </tr>
                                      <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
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
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $Arabic->en2ar($res[first_name]);?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $resc[arabic];?></span><span class="cer_my_head_bold">&nbsp;:<span dir="rtl">الجنسية  </span> </span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" >&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<span class="cer_my_head_bold"><?php if($res[student_id]>0) { echo $dbf->enNo2ar($res[student_id],''); } ?></span></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name[name];?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g[start_date],'-');?> إلى: <?php echo $dbf->enNo2ar($res_g[end_date],'-');?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير  <?php echo $Arabic->en2ar($res_grade["name"]);?> , ونسبة  <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %</span></td>
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
                        </table></td>
                    
                    </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    </tr>
  </table>
  				<?php }?>
                <?php if($group_id == ''){?>
                <table width="1126" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Mr/Ms.&nbsp;</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;</th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name[name];?></span><span class="cer_my_head"> with a total number of </span>&nbsp;<span class="cer_my_head">hours</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?> &nbsp;</span><span class="cer_my_head">to:</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From:</span><span class="cer_my_head_bold">
<?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
<?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?>
                                        </span></th>
                                      </tr>
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
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name[name];?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g[start_date],'-');?> إلى: <?php echo $dbf->enNo2ar($res_g[end_date],'-');?></span></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
                                      </tr>
                                    <tr>
                                      <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl">
                                      <span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span>
                                      </th>
                                      </tr>
                                  </table>
                                  <br />
                                  <span class="cer_my_head_bold" dir="rtl">وحصل على تقدير  <?php echo $Arabic->en2ar($res_grade["name"]);?> , ونسبة  <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %</span></td>
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
                        </table></td>
                    
                    </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    </tr>
  </table>
  				<?php } ?>
                </form>
                </td>
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
