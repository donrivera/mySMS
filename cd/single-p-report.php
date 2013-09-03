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
include_once '../includes/FusionCharts.php';
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
		document.location.href='single-p-report.php?student_id='+student_id;
	}else{
		document.location.href='single-p-report.php?student_id='+student_id +"&course_id=" + course;
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
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
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
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");;?></td>
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
                        <td width="29%" height="30" align="left" valign="middle" class="pedtext"><?php echo constant("SELECT_COURSE");?> :</td>
                        <td width="43%" align="left"><select name="course2" id="course2" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                          <option value="">---Select---</option>
                          <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                          <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                          <?php } ?>
                        </select></td>
                        <td width="28%" align="left"><?php
						$group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$student_id' And course_id='$course_id'");
						?>
                          <a href="report_teacher_progress_print.php?group_id=<?php echo $group_id;?>&teacher_id=<?php echo $_REQUEST[student_id];?>" target="_blank">
                            <?php if($_REQUEST[course_id]!="") { ?>
                            <img src="../images/printButton.png" width="50" height="16" border="0">
                            <?php } ?>
                          </a></td>
                      </tr>
                    </table></td>
                    <td width="27%">&nbsp;</td>
                    <td width="18%" align="center" valign="top"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
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
              <tr>
                <td colspan="5" align="center" valign="top">
                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                  <tr>
                    <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                    <td width="31%">&nbsp;</td>
                    <td width="32%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php
				  $group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$student_id' And course_id='$course_id'");
				  $res_g = $dbf->strRecordID("student_group","*","id='$group_id'");
				  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
				  $res_student = $dbf->strRecordID("student","*","id='$student_id'");
				  
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($group_id > 0){
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$group_id'");
				  }
				  ?>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_S2_NAME");?> : </td>
                    <td align="left" valign="middle" class="pedtext_normal"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?> : </td>
                        <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="34%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?> : </td>
                        <?php
						if($_SESSION[lang]=='EN'){
							$lang1 = "English";
						}else if($_SESSION[lang]=='AR'){
							$lang1 = "Arabic";
						}else{
							$lang1 = "English";
						}
						?>
                        <td width="45%" align="left" valign="middle" class="pedtext_normal"><?php echo $lang1;?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?> :</td>
                    <td align="left" valign="middle" class="pedtext_normal"><?php echo $res_group[name];?></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?> : </td>
                        <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_size[units];?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="34%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>:</td>
                        <?php				
							//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
							$num_total_class=$dbf->countRows('ped_units',"group_id='$group_id'");
							?>
                        <td width="45%" align="left" valign="middle" class="pedtext_normal"><?php echo $num_total_class;?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> : </td>
                    <td align="left" valign="middle" class="pedtext_normal"><?php if($group_id !='') { ?>
                      <?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?>
                      <?php } ?></td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?> : </td>
                        <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php if($group_id !='') { ?>
                          <?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?>
                          <?php } ?></td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_ATTENDANCE");?> : </td>
                    <?php
					//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
					$num_att=$dbf->countRows('ped_attendance',"course_id='$course_id' And student_id='$student_id' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
					?>
                    <td align="left" valign="middle" class="pedtext_normal"><b><?php echo $num_att;?></b>&nbsp;&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_OUTOF");?> &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $res_size[units];?></b></td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?> : </td>
                        <?php
						if($num_att>0){
							$per = round(($num_att / $res_size[units]) * 100);
						}
						?>
                        <td width="59%" align="left" valign="middle" class="pedtext_normal"><?php echo $per;?>%</td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?> :</td>
                    <td align="left" valign="middle" class="pedtext_normal"><?php echo $res_course[name];?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="left" valign="middle" class="shop2">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_LONGTEXT");?></td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="121" height="30" align="left" valign="top">&nbsp;&nbsp;<u class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_SCORE");?></u></td>
                        <td width="47">&nbsp;</td>
                        <td width="342">&nbsp;</td>
                        <td width="304">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="35" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_ATTENDACE");?></td>
                        <?php				
						$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$group_id' And student_id='$student_id'");
						
						$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_comp"];
						if($avg>0){
							$avg = $avg / 7;
							$avg = round($avg,1);
						}
						?>
                        <td align="center" valign="top" class="pedtext_normal"><?php $total = $res_size[units] / 2;?></td>
                        <td align="left" valign="top" class="shop2" style="text-align:justify;"><?php if($num_att<$total) { echo "Low attendance can keep you from reaching the goals for this level."; } ?></td>
                        <td rowspan="11" align="right" valign="top">
						<?php
						$at = $res_progress["course_attendance_perc"];
						$parti = $res_progress["course_partication"];
						$home = $res_progress["course_homework"];
						$flu = $res_progress["course_fluency"];
						$pro = $res_progress["course_pro"];
						$gra = $res_progress["course_grammer"];
						$voca = $res_progress["course_voca"];
						$comp = $res_progress["course_listen"];
						
						//<set label='Attnd' value='$at'/>
						
						echo $strXML="<chart>							
									<set label='Parti' value='$parti'/>
									<set label='Home' value='$home'/>
									<set label='Flue' value='$flu'/>
									<set label='Pron' value='$pro'/>
									<set label='Gram' value='$gra'/>
									<set label='Voca' value='$voca'/>
									<set label='Comp' value='$comp'/>
									<set label='Avg' value='$avg'/>
									</chart>";				
						 echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML, "myNext", 300, 450);
						?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_partication"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_partication]' And type='Participation'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_homework"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_homework]' And type='Homework'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_fluency"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_fluency]' And type='Fluency'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_pro"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_pro]' And type='Pronunciation'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_grammer"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_grammer]' And type='Grammer'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_voca"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_voca]' And type='Vocabulary'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr valign="top">
                        <td height="35" align="left" class="leftmenu">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_COMPREHENSION");?></td>
                        <td align="center" class="pedtext_normal"><?php echo $res_progress["course_listen"];?></td>
                        <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_comp]' And type='Comprehension'"); ?>
                        <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="center" valign="middle" class="pedtext_normal">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
                        <td align="center" valign="middle" class="pedtext_normal"><?php echo $avg;?></td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                        <td align="center" valign="middle" class="pedtext_normal">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" align="left" valign="middle" class="leftmenu"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="33%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_VERYGOOD");?></td>
                        <td width="57%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_FAIR");?></td>
                        <td width="10%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_GOOD");?></td>
                        <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_INSUFFICIENT");?></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_SATISFACTORY");?></td>
                        <td align="left" valign="middle" class="pedtext">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("ADMIN_COMMNAME");?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="40" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_LONGTEXT1");?></td>
                  </tr>
                  <tr>
                    <td height="40" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("CD_GROUP_PROGRESS_PEDASUPERVISOR");?></td>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle"><?php echo date('m/d/Y');?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                <td width="25%" height="30" align="left"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
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
                      <td width="64%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="36%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
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
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
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
                <td colspan="4" align="left" valign="top">
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td height="30" colspan="2" align="left" valign="middle" class="mytext"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                    <td width="26%">&nbsp;</td>
                    <td width="54%" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="32%" align="center" valign="middle">
                        <?php
						$group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$student_id' And course_id='$course_id'");
						?>
                        <a href="report_teacher_progress_print.php?group_id=<?php echo $group_id;?>&teacher_id=<?php echo $_REQUEST[student_id];?>" target="_blank"><?php if($_REQUEST[course_id]!="") { ?><img src="../images/printButton.png" width="50" height="16" border="0"><?php } ?></a>
                        </td>
                        <td width="41%" height="30" align="right" valign="middle"><select name="course" id="course" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                            <option value="">---<?php echo constant("SELECT");?>---</option>
                            <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                            <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                            <?php } ?>
                            </select></td>
                        <td width="27%" align="right" class="pedtext">&nbsp; : <?php echo constant("SELECT_COURSE");?>&nbsp;</td>
                        </tr>
                      </table>					</td>
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
              <tr>
                <td colspan="5" align="center" valign="top">
                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                  <tr>
                    <td width="27%" align="left" valign="middle" class="nametext">&nbsp;</td>
                    <td width="9%">&nbsp;</td>
                    <td width="1%">&nbsp;</td>
                    <td width="31%">&nbsp;</td>
                    <td width="32%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php
				  $group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$student_id' And course_id='$course_id'");
				  $res_g = $dbf->strRecordID("student_group","*","id='$group_id'");
				  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
				  $res_student = $dbf->strRecordID("student","*","id='$student_id'");
				  
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($group_id > 0){
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$group_id'");
				  }
				  ?>
                  <tr>
                    <td height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_S2_NAME");?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
                        <td width="41%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
						<?php
						if($_SESSION[lang]=='EN'){
							$lang1 = "English";
						}else if($_SESSION[lang]=='AR'){
							$lang1 = "Arabic";
						}else{
							$lang1 = "English";
						}
						?>
                        <td width="45%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $lang1;?></td>
                        <td width="34%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?>&nbsp;</td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_group[name];?></td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_size[units];?></td>
                        <td width="41%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
						<?php				
							//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
							$num_total_class=$dbf->countRows('ped_units',"group_id='$group_id'");
						?>
                        <td width="45%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $num_total_class;?></td>
                        <td width="34%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>&nbsp;</td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="20" align="right" valign="middle" class="pedtext_normal"><?php if($group_id !='') { ?>
                      <?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?>
                      <?php } ?></td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" height="20" align="right" valign="middle" class="pedtext_normal"><?php if($group_id !='') { ?>
                          <?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?>
                          <?php } ?></td>
                        <td width="41%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
				  	<?php
					//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
					$num_att=$dbf->countRows('ped_attendance',"course_id='$course_id' And student_id='$student_id' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
					?>
                    <td height="20" align="right" valign="middle" class="pedtext_normal"><b><?php echo $num_att;?></b>&nbsp;&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_OUTOF");?> &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $res_size[units];?></b></td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_PROGRESS_REPORT_ATTENDANCE");?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
					  	<?php
						if($num_att>0){
							$per = round(($num_att / $res_size[units]) * 100);
						}
						?>
                        <td width="59%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $per;?>%</td>
                        <td width="41%" align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_course[name];?></td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="left" valign="middle" class="shop2">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_LONGTEXT");?></td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="362" align="left" valign="top">&nbsp;</td>
                  <td width="395" height="30" align="left" valign="top">&nbsp;&nbsp;</td>
                  <td width="108">&nbsp;</td>
                  <td width="120" align="center"><u class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_SCORE");?></u>&nbsp;</td>
                </tr>
                <tr valign="top">
                  <td rowspan="10" align="right" class="leftmenu"><?php
				$at = $res_progress["course_attendance_perc"];
				$parti = $res_progress["course_partication"];
				$home = $res_progress["course_homework"];
				$flu = $res_progress["course_fluency"];
				$pro = $res_progress["course_pro"];
				$gra = $res_progress["course_grammer"];
				$voca = $res_progress["course_voca"];
				$comp = $res_progress["course_listen"];
				
				//<set label='Attnd' value='$at'/>
				
				echo $strXML="<chart>							
							<set label='Parti' value='$parti'/>
							<set label='Home' value='$home'/>
							<set label='Flue' value='$flu'/>
							<set label='Pron' value='$pro'/>
							<set label='Gram' value='$gra'/>
							<set label='Voca' value='$voca'/>
							<set label='Comp' value='$comp'/>
							<set label='Avg' value='$avg'/>
							</chart>";				
				 echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML, "myNext", 450, 450);
				?>&nbsp;</td>
                  <td height="35" align="right" class="shop2" >
				  <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_partication]' And type='Participation'"); ?>
				  <?php echo $res_comment[comment];?></td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_partication"];?></td>
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                </tr>
                <tr valign="top">
                  <td height="35" align="right" class="shop2">
                    <?php
                  $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_homework]' And type='Homework'");
				  echo $res_comment[comment];?>
                  </td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_homework"];?></td>
                  <td align="left" class="leftmenu" style="text-align:justify;">
				  <?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?>
                  </td>
  </tr>
                <tr valign="top">
                  <td height="35" align="right" class="shop2">
                    <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_fluency]' And type='Fluency'");
				  echo $res_comment[comment];?>
                  </td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_fluency"];?></td>                  
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
  </tr>
				  <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_pro]' And type='Pronunciation'"); ?>
                <tr valign="top">
                  <td height="35" align="right" class="shop2">&nbsp;<?php echo $res_comment[comment];?></td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_pro"];?></td>                  
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
  </tr>
                <tr valign="top">
                  <td height="35" align="right" class="shop2"><?php echo $res_comment[comment];?>&nbsp;</td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_grammer"];?></td>
                  <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_grammer]' And type='Grammer'"); ?>
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
  </tr>
                <tr valign="top">
                  <td height="35" align="right" class="shop2"><?php echo $res_comment[comment];?></td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_voca"];?></td>
                  <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_voca]' And type='Vocabulary'"); ?>
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
  </tr>
                <tr valign="top">
                  <td height="35" align="right" class="shop2"><?php echo $res_comment[comment];?></td>
                  <td align="center" class="pedtext_normal"><?php echo $res_progress["course_listen"];?></td>
                  <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_listen]' And type='Comprehension'"); ?>
                  <td align="left" class="leftmenu" style="text-align:justify;"><?php echo constant("TEACHER_REPORT_TEACHER_COMPREHENSION");?></td>
  </tr>
                <tr>
                  <td height="25" align="right" valign="middle" class="pedtext_normal">&nbsp;</td>
                  <td align="center" valign="middle" class="pedtext_normal">&nbsp;</td>
                  <td align="left" valign="middle">&nbsp;</td>
  </tr>
                <tr>
                  <td align="left" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle" class="pedtext_normal"><?php echo $avg;?></td>
                  <td height="25" align="left" valign="middle" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
  </tr>
                <tr>
                  <td height="25" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                  <td align="center" valign="middle" class="pedtext_normal">&nbsp;</td>
                  <td align="left" valign="middle">&nbsp;</td>
  </tr>
                </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="20" align="left" valign="middle" class="leftmenu"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10%">&nbsp;</td>
                        <td width="57%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_FAIR");?></td>
                        <td width="33%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_VERYGOOD");?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_INSUFFICIENT");?></td>
                        <td align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_GOOD");?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle" class="pedtext">&nbsp;</td>
                        <td align="right" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_SATISFACTORY");?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="20" colspan="2" align="right" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("ADMIN_COMMNAME");?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td height="40" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="20" colspan="5" align="right" valign="middle" class="red_smalltext">&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_LONGTEXT1");?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td height="40" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle"><?php echo date('m/d/Y');?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="20" colspan="2" align="right" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("CD_GROUP_PROGRESS_PEDASUPERVISOR");?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="pedtext">&nbsp;</td>
                    <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
