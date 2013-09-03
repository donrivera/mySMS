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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
$course_id =  $_REQUEST['course_id'];
?>
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
<script type="text/javascript" src="../modal/thickbox.js"></script>
<script type="text/javascript">
function show_payment(){
	var course = document.getElementById('course').value;
	var student_id = <?php echo $student_id;?>;
	
	if(course == ''){
		document.location.href='single-certificate.php?student_id='+student_id;
	}else{
		document.location.href='single-certificate.php?student_id='+student_id +"&course_id=" + course;
	}
}
</script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN") { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td colspan="2" align="left" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="35%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> : &nbsp;</td>
                    <td width="65%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <?php if($student["student_id"] > 0) { ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td height="30" colspan="2" align="left" valign="middle" class="mytext"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="25%" align="left" valign="middle" class="pedtext"><?php echo constant("SELECT_COURSE");?> :</td>
                        <td width="42%" align="left">
                          <select name="course" id="course" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                            <option value="">---Select---</option>
                            <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                            <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                            <?php } ?>
                            </select></td>
                        <td width="33%" align="left">
                        <?php
						//If the students balance should be Zero
						$bal_amt = $dbf->BalanceAmount($_REQUEST["student_id"],$_REQUEST["course_id"]);
						if($bal_amt <= 0){
						?>
						<a href="print_certificate.php?course_id=<?php echo $_REQUEST[course_id];?>&student_id=<?php echo $_REQUEST[student_id];?>" target="_blank"><?php if($_REQUEST[student_id]!="" && $_REQUEST[course_id]!=''){ ?><img src="../images/print.png" width="16" height="16" border="0" title="Print"/><?php } ?></a>
						<?php } ?>
                        </td>
                        </tr>
                      </table></td>
                    <td width="27%" align="left" valign="middle">
                    <?php
                    if($bal_amt > 0){
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
					?>
                    <table width="90%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="60%" height="25" align="right" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
                        <td width="40%" align="left" valign="middle" bgcolor="#FFF7D5" class="nametext1">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      </tr>
                    </table>
                    <?php } ?>
                    </td>
                    <td width="18%" align="center" valign="top"><?php echo $dbf->VVIP_Big_Icon($student_id);?></td>
                  </tr>
                  </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <?php
				$resc = $dbf->strRecordID("countries","*","id='$student[country_id]'");									
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
                <td colspan="5" align="left" valign="top">               
                
                <table width="820" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #ccc;" bgcolor="#FFFFFF">
                  <tr>
                    <td width="110"><img src="../images/left-img.jpg" alt="left-img" width="110" height="670" /></td>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                      <tr>
                        <td height="28">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center" valign="middle" ><p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                              <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                              <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />
                                Ministry of Education - Al Ahsa <br />
                                (Male)</span></strong><br />
                              <strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p></td>
                            <td align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                            <td align="right" valign="middle"><table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td valign="top"><p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
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
                        <td height="20">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" style="background:url(../images/body-bg1.jpg)  no-repeat center; width:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="51%" align="left" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" scope="col" class="cer_my_head">This is to certify that</th>
                              </tr>
                              <?php
							  if($student[gender]=='female'){
								  $gender = 'Ms.';
							  }else{
								  $gender = 'Mr.';
							  }
							  ?>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?>&nbsp;</span><span class="cer_my_head_bold"><?php echo $student[first_name];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold">
                                  <?php if($student[student_id]>0) { echo $student[student_id]; } ?>
                                </span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name[name];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g[end_date];?></span></th>
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
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?>
                                  <?php } ?>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
                                    <?php if($student_id !='' ) { ?>
                                    <?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?>
                                    <?php } ?>
                                  </span></th>
                              </tr>
                              <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
								  $res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
								  ?>
                            </table>
                              <br />
                              <span class="cer_my_head">and received a final grade of </span> <span class="cer_my_head_bold"><?php echo $res_grade["name"];?> , <?php echo $res_per["final_percent"];?> % </span></td>
                            <td width="49%" align="right" valign="top" ><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $Arabic->en2ar($resc[value]);?></span><span class="cer_my_head_bold">&nbsp;:<span dir="rtl">الجنسية  </span></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col" ><span class="cer_my_head_bold">
                                  <?php if($res[student_id]>0) { echo $res[student_id]; } ?>
                                </span>&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name[name];?> , وأكمل   <?php echo $hr;?>   ساعة دراسية</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $res_g[start_date];?> إلى: <?php echo $res_g[end_date];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
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
                                <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl"> <span class="cer_my_head_bold" dir="rtl">الموافق من:
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?>
                                  <?php } ?>
                                  إلى:
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?>
                                  <?php } ?>
                                </span></th>
                              </tr>
                            </table>
                              <br />
                              <span class="cer_my_head_bold" dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;وحصل على تقدير   <?php echo $res_per["final_percent"];?> %  , ونسبة  <?php echo $res_grade["name"];?></span></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="cer_my_head"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="middle">Berlitz issued this certificate in recognition of the above. </td>
                            <td align="right" valign="middle" class="cer9_arial_bold"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="30">sdf</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
                              <p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br />
                                <strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p></td>
                            <td >&nbsp;</td>
                            <td align="center" valign="middle"><p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br />
                              <strong><span dir="ltr">Stamp</span></strong></p></td>
                            <td >&nbsp;</td>
                            <td align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
                              <strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
                              <strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
        <td width="79%" align="left" valign="top">
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="63%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="37%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) {?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext">: <?php echo $Arabic->en2ar('Add Date');?></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1%">&nbsp;</td>
                      <td height="30" colspan="2" align="left" valign="middle" class="mytext"><?php echo $dbf->VVIP_Big_Icon($student_id);?></td>
                      <td width="26%" align="right" valign="middle">
                      <?php
                    if($bal_amt > 0){
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
					?>
                    <table width="90%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>             
                        <td width="40%" align="left" valign="middle" bgcolor="#FFF7D5" class="nametext1">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td width="60%" height="25" align="right" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
                      </tr>
                    </table>
                    <?php } ?>
                      </td>
                      <td width="54%" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="25%" align="left" valign="middle" class="pedtext"><?php echo constant("SELECT_COURSE");?> :</td>
                          <td width="42%" align="left"><select name="course" id="course" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                            <option value="">---Select---</option>
                            <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                            <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                            <?php } ?>
                          </select></td>
                          <td width="33%" align="left"><?php
						//If the students balance should be Zero
						$bal_amt = $dbf->BalanceAmount($_REQUEST["student_id"],$_REQUEST["course_id"]);
						if($bal_amt <= 0){
						?>
                            <a href="print_certificate.php?course_id=<?php echo $_REQUEST[course_id];?>&student_id=<?php echo $_REQUEST[student_id];?>" target="_blank">
                              <?php if($_REQUEST[student_id]!="" && $_REQUEST[course_id]!=''){ ?>
                              <img src="../images/print.png" width="16" height="16" border="0" title="Print"/>
                              <?php } ?>
                              </a>
                            <?php } ?></td>
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <?php
				$resc = $dbf->strRecordID("countries","*","id='$student[country_id]'");									
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
                <td colspan="5" align="left" valign="top">               
                
                <table width="820" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #ccc;" bgcolor="#FFFFFF">
                  <tr>
                    <td width="110"><img src="../images/left-img.jpg" alt="left-img" width="110" height="670" /></td>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                      <tr>
                        <td height="28">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center" valign="middle" ><p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
                              <strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
                              <strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />
                                Ministry of Education - Al Ahsa <br />
                                (Male)</span></strong><br />
                              <strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p></td>
                            <td align="center" valign="middle"><img src="../images/logo_big.jpg" width="278" height="80" /></td>
                            <td align="right" valign="middle"><table dir="rtl" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td valign="top"><p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
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
                        <td height="20">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" style="background:url(../images/body-bg1.jpg)  no-repeat center; width:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="51%" align="left" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" scope="col" class="cer_my_head">This is to certify that</th>
                              </tr>
                              <?php
							  if($student[gender]=='female'){
								  $gender = 'Ms.';
							  }else{
								  $gender = 'Mr.';
							  }
							  ?>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?>&nbsp;</span><span class="cer_my_head_bold"><?php echo $student[first_name];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold">
                                  <?php if($student[student_id]>0) { echo $student[student_id]; } ?>
                                </span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course</span><span class="cer9_arial">:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: </span><span class="cer_my_head_bold"><?php echo $course_name[name];?></span><span class="cer_my_head"> with a total number of </span><span class="cer_my_head_bold"> <?php echo $hr;?></span>&nbsp;<span class="cer_my_head">hours</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?> &nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">&nbsp;<?php echo $res_g[end_date];?></span></th>
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
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?>
                                  <?php } ?>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="cer_my_head">to:</span><span class="cer_my_head_bold">
                                    <?php if($student_id !='' ) { ?>
                                    <?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?>
                                    <?php } ?>
                                  </span></th>
                              </tr>
                              <?php
								  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
								  $res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
								  ?>
                            </table>
                              <br />
                              <span class="cer_my_head">and received a final grade of </span> <span class="cer_my_head_bold"><?php echo $res_grade["name"];?> , <?php echo $res_per["final_percent"];?> % </span></td>
                            <td width="49%" align="right" valign="top" ><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $Arabic->en2ar($resc[value]);?></span><span class="cer_my_head_bold">&nbsp;:<span dir="rtl">الجنسية  </span></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col" ><span class="cer_my_head_bold">
                                  <?php if($res[student_id]>0) { echo $res[student_id]; } ?>
                                </span>&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $course_name[name];?> , وأكمل   <?php echo $hr;?>   ساعة دراسية</span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $res_g[start_date];?> إلى: <?php echo $res_g[end_date];?></span></th>
                              </tr>
                              <tr>
                                <th height="21" align="right" valign="middle" class="cer2" scope="col"></th>
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
                                <th height="21" align="right" valign="middle" class="cer2" scope="col" dir="rtl"> <span class="cer_my_head_bold" dir="rtl">الموافق من:
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $sdt;}?>
                                  <?php } ?>
                                  إلى:
                                  <?php if($student_id !='' ) { ?>
                                  <?php if($res_g[start_date]!='0000-00-00') { echo $edt;}?>
                                  <?php } ?>
                                </span></th>
                              </tr>
                            </table>
                              <br />
                              <span class="cer_my_head_bold" dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;وحصل على تقدير   <?php echo $res_per["final_percent"];?> %  , ونسبة  <?php echo $res_grade["name"];?></span></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="cer_my_head"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="middle">Berlitz issued this certificate in recognition of the above. </td>
                            <td align="right" valign="middle" class="cer9_arial_bold"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="30">sdf</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
                              <p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br />
                                <strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p></td>
                            <td >&nbsp;</td>
                            <td align="center" valign="middle"><p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br />
                              <strong><span dir="ltr">Stamp</span></strong></p></td>
                            <td >&nbsp;</td>
                            <td align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
                              <strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
                              <strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</form>		</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
