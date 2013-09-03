<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
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
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[cmbgroup]'");

$teacher_id = $_REQUEST[teacher_id];
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

<script type="text/javascript">
function setsubmit(){
	
	var cmbgroup = document.getElementById('cmbgroup').value;
	var teacher_id = document.getElementById('teacher_id').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='report_teacher_progress.php?cmbgroup='+cmbgroup+'&teacher_id='+ teacher_id +'&mystatus='+mystatus;
}

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ped_group.php", {status: $(this).val()}); // Page Name and Condition
	});
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    <form name="frm" method="post" id="frm">
    <table width="1000" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td width="361" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">
        
        <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
          <tr>
            <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
          </tr>
          <tr>
            <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">Status:</td>
            <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading">
            <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
            <option value="">All</option>
            <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
            <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
            <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
            </select>
            </td>
          </tr>
          <tr>
            <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_GROUP");?>:</td>
            <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
            <select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                <option value="">Select Group</option>
                <?php
				if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
			  	foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $res_group) {
				  ?>
                <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?>
</option>
                <?php
			  }
			  ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENT");?>:</td>
            <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading">
            <select name="teacher_id" id="teacher_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
              <option value="">Select Student</option>
              <?php
			  foreach($dbf->fetchOrder('student s,student_group_dtls d',"s.id=d.student_id And d.parent_id='$_REQUEST[cmbgroup]'","","s.*","") as $res_teacher) {
				  ?>
              <option value="<?php echo $res_teacher['id'];?>" <?php if($_REQUEST["teacher_id"]==$res_teacher["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_teacher['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_teacher["id"]));?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
          </tr>
        </table></td>
        <td width="493" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="46" align="center" valign="middle" bgcolor="#FFFFFF"><a href="report_teacher_progress_print.php?group_id=<?php echo $_REQUEST[cmbgroup];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>" target="_blank"><?php if($_REQUEST[cmbgroup]!="") { ?><img src="../images/printButton.png" width="50" height="16" border="0"><?php } ?></a></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#FFFFFF" class="loginheading"><?php echo constant("CD_GROUP_PROGRESS_PERSONALREPORT");?></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF">
        
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#000000;">
          <tr>
            <td width="9%" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td width="27%">&nbsp;</td>
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
		  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
		  
		  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
		  $res_student = $dbf->strRecordID("student","*","id='$_REQUEST[teacher_id]'");
		  
		  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
		  if($_REQUEST['cmbgroup']!=''){
			 $res_teacher_group = $dbf->strRecordID("student_group","*","group_id='$_REQUEST[cmbgroup]'");
		  }
		  ?>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_S2_NAME");?> : </td>
            <td align="left" valign="middle" class="pedtext_normal"><?php echo $res_student[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?> : </td>
                <td width="59%" align="left" valign="middle" class="pedtext_normal" >
				<?php if($_REQUEST["cmbgroup"] != ""){?>
				<?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?>
                <?php } ?>
                </td>
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
                <td width="34%" height="20" align="left" valign="middle" class="leftmenu"> <?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>:</td>
                <?php				
				//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
				$num_total_class=$dbf->countRows('ped_units',"group_id='$_REQUEST[cmbgroup]'");
				?>
                <td width="45%" align="left" valign="middle" class="pedtext_normal"><?php echo $num_total_class;?></td>
                <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> : </td>
            <td align="left" valign="middle" class="pedtext_normal">
            <?php if($_REQUEST[cmbgroup] !='') { ?>
              <?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?>
              <?php } ?>
            </td>
            <td>&nbsp;</td>
           
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?> : </td>
                <td width="59%" align="left" valign="middle" class="pedtext_normal" >
				<?php if($_REQUEST[cmbgroup] !='') { ?>
				<?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?>
                <?php } ?>
                </td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_ATTENDANCE");?> : </td>
            <?php
			//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
			$num_att=$dbf->No_Of_Attendance($_REQUEST['teacher_id'], $_REQUEST["cmbgroup"]);
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
            <td height="20" colspan="5" align="left" valign="middle" class="leftmenu"><table width="985" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="116" height="30" align="left" valign="top">&nbsp;&nbsp;<u class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_SCORE");?></u></td>
                <td width="84">&nbsp;</td>
                <td width="371">&nbsp;</td>
                <td width="414">&nbsp;</td>
              </tr>
              <tr>
                <td height="35" align="left" valign="top" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_ATTENDACE");?></td>
                <?php				
				$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$_REQUEST[cmbgroup]' And student_id='$teacher_id'");
				//$res_progress["course_attendance_perc"]+
                $avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_listen"];
				if($avg>0){
					$avg = $avg / 7;
					$avg = round($avg,1);
				}
				?>
                <td align="center" valign="top" class="pedtext_normal">
				<?php
				$total = $res_size[units] / 2;
				?>
                </td>
                <td align="left" valign="top" class="shop2" style="text-align:justify;">
				<?php if($num_att<$total) { echo "Low attendance can keep you from reaching the goals for this level."; } ?> </td>
                <td rowspan="11" align="left" valign="top">
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
							<set label='Participation' value='$parti'/>
							<set label='Homework' value='$home'/>
							<set label='Fluency' value='$flu'/>
							<set label='Pronunciation' value='$pro'/>
							<set label='Grammar' value='$gra'/>
							<set label='Vocabulary' value='$voca'/>
							<set label='Comprehension' value='$comp'/>
							<set label='Overall' value='$avg'/>
							</chart>";				
				 echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML, "myNext", 450, 450);
				?>
                </td>
              </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_partication"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_partication]' And type='Participation'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_homework"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_homework]' And type='Homework'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_fluency"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_fluency]' And type='Fluency'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_pro"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_pro]' And type='Pronunciation'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_grammer"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_grammer]' And type='Grammer'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_voca"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_voca]' And type='Vocabulary'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_COMPREHENSION");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_listen"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_listen]' And type='Comprehension'"); ?>
                <td align="left" class="shop2" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr>
                <td height="25" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                <td align="center" valign="middle" class="pedtext_normal">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                </tr>
              <tr>
                <td height="25" align="left" valign="middle" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
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
            <td height="40" colspan="2" align="left" valign="top" class="leftmenu">&nbsp;&nbsp;<?php echo $pro["narration"];?></td>
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
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    <form action="report_teacher_progress_save.php?action=insert" name="frm" method="post" id="frm">
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td width="361" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;&nbsp;&nbsp;<a href="report_teacher_progress_print.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>" target="_blank"><?php if($_REQUEST[group_id]!="") { ?><img src="../images/printButton.png" width="50" height="16" border="0"><?php } ?></a></td>
        <td width="493" align="right" valign="middle" bgcolor="#FFFFFF"><table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
          <tr>
            <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
          </tr>
          
          <tr>
            <td align="right" valign="middle" bgcolor="#FFCB7D" class="heading">
            <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
            <option value="">All</option>
            <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
            <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
            <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
            </select>
            </td>
            <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
          </tr>
          <tr>
            <td width="72%" align="right" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
            <select name="group_id" class="" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
              <option value=""><?php echo constant("SELECT_GROUP");?></option>
              <?php
			  if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
			  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $res_group) {
			  ?>
              <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?>
</option>
              <?php } ?>
            </select></td>
            <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></td>
            
          </tr>
          
          <tr>
            <td width="72%" align="right" valign="middle" bgcolor="#FFCB7D" class="heading">
            <select name="teacher_id" class="" id="teacher_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
              <option value=""><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_OPTION");?></option>
              <?php
			  foreach($dbf->fetchOrder('student s,student_group_dtls d',"s.id=d.student_id And d.parent_id='$_REQUEST[cmbgroup]'","","s.*","") as $res_teacher) {
				  ?>
              <option value="<?php echo $res_teacher['id'];?>" <?php if($_REQUEST[teacher_id]==$res_teacher["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_teacher['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res_teacher["id"]));?>
                <?php }?>
              </select></td>
            <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENT");?></td>
            
          </tr>
          <tr>
            <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
          </tr>
        </table></td>
        <td width="46" align="center" valign="middle" bgcolor="#FFFFFF"></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#FFFFFF" class="loginheading"><?php echo constant("CD_GROUP_PROGRESS_PERSONALREPORT");?></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF">
        <?php
		$student_id = $_REQUEST['teacher_id'];
		
		$res_student = $dbf->strRecordID("student","*","id='$student_id'");
		$res_g = $dbf->strRecordID('student_group m,student_group_dtls d',"m.*","m.id=d.parent_id And d.student_id='$student_id'");			  
		$res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
		$group_id = $res_g["id"];			  
		$res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		$res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
        ?>
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#000000;">
            <tr>
              <td width="18%" align="left" valign="middle" bgcolor="#FFFFFF" class="nametext">&nbsp;</td>
              <td width="18%" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="31%" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="32%" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="nametext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td height="20" colspan="2" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal">&nbsp;</td>
              <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="41%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
                  <td width="59%" align="left" valign="middle" class="leftmenu" >&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?></td>
                  </tr>
                </table></td>
              <td rowspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="68%" height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
              <td width="32%" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><?php echo $res_group[name];?>&nbsp;</td>
                  <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?></td>
                </tr>
                <tr>
                  <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal">
                  <?php
                  if($res_g[start_date]!='0000-00-00'){
						echo date("d/m/Y",strtotime($res_g[start_date]));
				  }
				  ?>
                  </td>
                  <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?></td>
                </tr>
                <tr>
                  <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><b><?php echo $num_att;?></b>&nbsp;&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_OUTOF");?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $res_size[units];?></b>&nbsp;</td>
                  <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_PROGRESS_REPORT_ATTENDANCE");?></td>
                </tr>
                <tr>
                  <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><?php echo $res_course[name];?>&nbsp;</td>
                  <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td height="20" colspan="2" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                  <td width="34%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $lang1;?></td>
                  <td width="45%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?></td>
                  <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                </tr>
              </table></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" valign="middle" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="41%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $res_size[units];?></td>
                  <td width="59%" align="left" valign="middle" class="leftmenu" >&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td height="20" colspan="2" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
                  <?php				
				//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
				$num_total_class=$dbf->countRows('ped_units',"group_id='$group_id'");
				?>
                  <td width="34%" height="20" align="right" valign="middle" class="pedtext_normal"><?php echo $num_total_class;?></td>
                  <td width="45%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?></td>
                  <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                </tr>
              </table>
              </td>
              <td bgcolor="#FFFFFF">&nbsp;</td>              
              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="41%" height="20" align="right" valign="middle" class="pedtext_normal">
                    <?php if($res_g[end_date]!='0000-00-00'){
							echo date("d/m/Y",strtotime($res_g[end_date]));
					}
					?> : </td>
                  <td width="59%" align="left" valign="middle" class="leftmenu" >&nbsp; : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></td>
                  </tr>
              </table></td>
              </tr>
            <?php
			//Get number of Attendace present in e-PEDCARD (table : ped_attendance)			
			$num_att = $dbf->No_Of_Attendance($student_id, $group_id);
			?>
            <tr>
              <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal">&nbsp;</td>              
              <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
                <?php
				$per = 0;
				if($num_att>0){
					 $per = round(($num_att / $res_size[units]) * 100);
				}
				?>
              <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="41%" height="20" align="right" valign="middle" class="pedtext_normal">%<?php echo $per;?></td>                
                  <td width="59%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?></td>
                  </tr>
              </table></td>
              </tr>
            <tr>
              <td height="20" align="right" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal">&nbsp;</td>
              <td align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" colspan="5" align="right" valign="middle" bgcolor="#FFFFFF" class="shop2">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_LONGTEXT");?>&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
              <?php
				$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$group_id' And student_id='$student_id'");
				
                $avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_comp"];
				if($avg>0){
					$avg = $avg / 7;
					$avg = round($avg,1);
				}
				?>
            <tr>
              <td height="20" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><table width="985" border="0" cellspacing="0" cellpadding="0">
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
                  <td height="25" align="right" valign="middle" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
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
              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF"><table width="99%" border="0" cellspacing="0" cellpadding="0">
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
              </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" colspan="2" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF" align="right"><?php echo constant("ADMIN_COMMNAME");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td height="40" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" colspan="5" align="right" valign="middle" bgcolor="#FFFFFF" class="red_smalltext"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_LONGTEXT1");?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td height="40" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;&nbsp;<?php echo constant("CD_GROUP_PROGRESS_PEDASUPERVISOR");?></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td align="right" valign="middle" bgcolor="#FFFFFF"><?php echo date('m/d/Y');?></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
          </table>
        </td>
        </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table>
    </form>
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