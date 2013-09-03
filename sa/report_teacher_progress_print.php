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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[group_id]'");

$teacher_id = $pro[teacher_id];
//echo base64_decode(base64_decode('U205bGJBPT0='));
$rest = $dbf->strRecordID("teacher","*","id='$pro[teacher_id]'");

$res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
$res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
$res_student = $dbf->strRecordID("student","*","id='$_REQUEST[teacher_id]'");
?>	
<style>
.mytext{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#336699;
font-weight:normal;
padding-left:2px;
}
.leftmenu
{
color:#000066;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bold;
}
.pedtext{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#000000;
padding-left:7px;
font-weight:bold;
}
.rotate_text{
	font-family:Verdana, Arial, Helvetica, sans-serif;
    -webkit-transform: rotate(323deg);
    -moz-transform: rotate(323deg);
    -o-transform: rotate(323deg);
    writing-mode: lr-tb;
	font-size:10px;
	font-weight:bold;
}
.heading{
 font-family:Arial, Helvetica, sans-serif;
 font-size:16px;
 font-weight:bold;
 color:#000000;
 }
.heading1{
 font-family:Arial, Helvetica, sans-serif;
 font-size:16px;
 font-weight:bold;
 color:#000000;
 text-decoration:underline;
 }
 .content
 {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:12px;
	 color:#000000;
	 padding-left:3px;
 }
</style>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" align="left" valign="middle" style="padding-left:5px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
    
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="361" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
        <td width="493" align="left" valign="middle" bgcolor="#FFFFFF" class="heading"><?php echo constant("CD_GROUP_PROGRESS_PERSONALREPORT");?></td>
        <td width="46" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF">
        
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#000000;">
          <tr>
            <td width="9%" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td width="27%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="31%">&nbsp;</td>
            <td width="32%" align="center" valign="middle" style="padding-top:3px;"><img src="../logo/logo.png" width="215" height="62"></td>
          </tr>
          <tr>
            <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php		  
		  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
		  if($_REQUEST[group_id]!='')
		  {
			 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
		  }
		  ?>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_S2_NAME");?> : </td>
            <td align="left" valign="middle" class="content"><?php echo $res_student[first_name];?></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?> : </td>
                <td width="59%" align="left" valign="middle" class="content" ><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
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
                <td width="45%" align="left" valign="middle" class="content"><?php echo $lang1;?></td>
                <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?> :</td>
            <td align="left" valign="middle" class="content"><?php echo $res_group[name];?></td>
            <td>&nbsp;</td>
            <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?> : </td>
                <td width="59%" align="left" valign="middle" class="content" ><?php echo $res_size[units];?></td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
                <td width="34%" height="20" align="left" valign="middle" class="leftmenu"> <?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>:</td>
                <?php
				//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
				$num_total_class=$dbf->countRows('ped_units',"group_id='$_REQUEST[group_id]'");
				?>
                <td width="45%" align="left" valign="middle" class="content"><?php echo $num_total_class;?></td>
                <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> : </td>
            <td align="left" valign="middle" class="content">
            <?php if($_REQUEST[group_id] !='') { ?>
              <?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?>
              <?php } ?>
            </td>
            <td>&nbsp;</td>
           
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?> : </td>
                <td width="59%" align="left" valign="middle" class="content" >
				<?php if($_REQUEST[group_id] !='') { ?>
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
			$num_att=$dbf->countRows('ped_attendance',"student_id='$teacher_id' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
			?>
            <td align="left" valign="middle" class="content"><b><?php echo $num_att;?></b>&nbsp;&nbsp;&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_OUTOF");?> &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $res_size[units];?></b></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?>  : </td>
                <?php
				if($num_att>0)
				{
					$per = round(($num_att / $res_size[units]) * 100);
				}
				?>
                <td width="59%" align="left" valign="middle" class="content"><?php echo $per;?>%</td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?> :</td>
            <td align="left" valign="middle" class="content"><?php echo $res_course[name];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" colspan="5" align="left" valign="middle" class="content">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_LONGTEXT");?></td>
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
				$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$_REQUEST[group_id]' And student_id='$_REQUEST[teacher_id]'");
				//$res_progress["course_attendance_perc"]+
                $avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_listen"];
				if($avg>0)
				{
					$avg = $avg / 7;
					$avg = round($avg,1);
				}
				?>
                <td align="center" valign="top" class="pedtext_normal">
				<?php
				$total = $res_size[units] / 2;
				?>
                </td>
                <td align="left" valign="top" class="mytext" style="text-align:justify;">
				<?php if($num_att<$total) { echo "Low attendance can keep you from reaching the goals for this level."; } ?> </td>
                <td rowspan="11" align="center" valign="top">
                <?php
                $at = $res_progress["course_attendance_perc"];
				$parti = $res_progress["course_partication"];
				$home = $res_progress["course_homework"];
				$flu = $res_progress["course_fluency"];
				$pro = $res_progress["course_pro"];
				$gra = $res_progress["course_grammer"];
				$voca = $res_progress["course_voca"];
				$comp = $res_progress["course_listen"];
				?>
                <table width="200" border="0" id="data" style="display:none;">
                  <tr>
                    <td>Parti</td>
                    <td><?php echo $parti;?></td>
                  </tr>
                  <tr>
                    <td>Home</td>
                    <td><?php echo $home;?></td>
                  </tr>
                  <tr>
                    <td>Flue</td>
                    <td><?php echo $flu;?></td>
                  </tr>
                  <tr>
                    <td>Pron</td>
                    <td><?php echo $pro;?></td>
                  </tr>
                  <tr>
                    <td>Gram</td>
                    <td><?php echo $gra;?></td>
                  </tr>
                  <tr>
                    <td>Voca</td>
                    <td><?php echo $voca;?></td>
                  </tr>
                  <tr>
                    <td>Comp</td>
                    <td><?php echo $comp;?></td>
                  </tr>
                  <tr>
                    <td>Avg.</td>
                    <td><?php echo $avg;?></td>
                  </tr>
                </table>
                <canvas id="graph" width="350" height="220"></canvas>
                <script type="text/javascript" src="../js/jquery.js"></script>
                <script type="text/javascript" src="../js/mocha.js"></script>
                </td>
              </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_partication"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_partication]' And type='Participation'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_homework"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_homework]' And type='Homework'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_fluency"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_fluency]' And type='Fluency'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_pro"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_pro]' And type='Pronunciation'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_grammer"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_grammer]' And type='Grammer'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_voca"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_voca]' And type='Vocabulary'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
                </tr>
              <tr valign="top">
                <td height="35" align="left" class="pedtext_normal">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_COMPREHENSION");?></td>
                <td align="center" class="pedtext_normal"><?php echo $res_progress["course_listen"];?></td>
                <?php $res_comment = $dbf->strRecordID("comment","*","id='$res_progress[course_listen]' And type='Comprehension'"); ?>
                <td align="left" class="mytext" style="text-align:justify;"><?php echo $res_comment[comment];?></td>
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
            <td height="20" colspan="5" align="left" valign="middle" class="content">&nbsp;<?php echo constant("CD_REPORT_TEACHER_PROGRESS_LONGTEXT1");?></td>
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
      </table>
   
    </td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
window.print();
</script>