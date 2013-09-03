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

//$teacher_id = $pro[teacher_id];
$teacher_id = $_REQUEST[teacher_id];

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
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="361" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;"><table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
      <tr>
        <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
      </tr>
      <tr>
        <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?> :</td>
        <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="leftmenu"><?php echo $dbf->getDataFromTable("student_group","group_name","id='$_REQUEST[group_id]'");?>
        </td>
      </tr>
      <tr>
        <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
      </tr>
    </table></td>
    <td width="493" align="right" valign="middle" bgcolor="#FFFFFF"><img src="../logo/logo.png" width="215" height="62"></td>
    <td width="46" align="center" valign="middle" bgcolor="#FFFFFF"><a href="report_teacher_progress_condition.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>">
      <?php if($_REQUEST[group_id]!="") { ?>
      <div style="display:none;"><img src="../images/printButton.png" width="50" height="16" border="0"></div>
      <?php } ?>
    </a></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF" class="red_smalltext"><?php echo constant("CD_GROUP_PROGRESS_PERSONALREPORT");?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="middle" bgcolor="#FFFFFF"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#000000;">
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
		  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
		  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
		  $res_student = $dbf->strRecordID("student","*","id='$_REQUEST[teacher_id]'");
		  
		  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
		  if($_REQUEST[group_id]!='')
		  {
			 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
		  }
		  ?>
      <tr>
        <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?> : </td>
        <td align="left" valign="middle" class="pedtext"><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?> : </td>
            <?php
				if($_SESSION[lang]=='EN')
				{
					$lang1 = "English";
				}
				else if($_SESSION[lang]=='AR')
				{
					$lang1 = "Arabic";
				}
				else
				{
					$lang1 = "English";
				}
				?>
            <td width="59%" align="left" valign="middle" class="pedtext" ><?php echo $lang1;?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td width="34%" height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
            <td width="45%" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
            <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?>:</td>
        <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?>: </td>
            <td width="59%" align="left" valign="middle" class="pedtext" ><?php echo $res_size[units];?></td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td width="34%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>:</td>
            <?php
				/*$or_unit = $res_size[units];
				$per_unit = 45; //minute
				$tot_unit = $or_unit * $per_unit;
				$hr = $tot_unit / 60;*/
				
				//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
				$num_total_class=$dbf->countRows('ped_units',"group_id='$_REQUEST[group_id]'");
				?>
            <td width="45%" align="left" valign="middle" class="pedtext"><?php echo $num_total_class;?></td>
            <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> : </td>
        <td align="left" valign="middle" class="pedtext"><?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?></td>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?>: </td>
            <td width="59%" align="left" valign="middle" class="pedtext" ><?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?></td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?>:</td>
        <td align="left" valign="middle" class="pedtext"><?php echo $res_course[name];?></td>
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
        <td height="20" colspan="5" align="left" valign="middle" class="leftmenu">
        <table width="988" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" colspan="10" align="left" valign="middle">&nbsp;&nbsp;<u class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_SCORE");?></u></td>
          </tr>
          <tr>
            <td height="1" colspan="10" align="left" valign="middle" bgcolor="#000000"></td>
          </tr>
          <tr>
            <td width="200" height="25" align="left" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal">&nbsp;<?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
            <td width="98" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
            <td width="87" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?></td>
            <td width="75" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
            <td width="104" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
            <td width="74" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
            <td width="97" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
            <td width="98" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("CD_GROUP_PROGRESS_COMPREHENSION");?></td>
            <td width="70" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
            <td width="82" align="left" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal" style="border-left:solid 1px; border-color:#000000;">
			<?php echo constant("CD_GROUP_PROGRESS_ATTENDACE");?></td>
          </tr>
          <tr>
            <td height="1" colspan="10" align="left" valign="middle" bgcolor="#000000"></td>
          </tr>
          <?php 
				 $attend_calc=0;
				 $student_count = 1;
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.parent_id='$_REQUEST[group_id]'","s.first_name","s.*,c.id") as $r) 
				 { 
				 	$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$_REQUEST[group_id]' And student_id='$r[id]'");
					
					//$res_progress["course_attendance_perc"]+
					$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_comp"];
					if($avg>0)
					{
						$avg = $avg / 7;
						$avg = round($avg,1);
					}
					$at = $res_progress["course_attendance_perc"];
					$parti = $res_progress["course_partication"];
					$home = $res_progress["course_homework"];
					$flu = $res_progress["course_fluency"];
					$pro = $res_progress["course_pro"];
					$gra = $res_progress["course_grammer"];
					$voca = $res_progress["course_voca"];
					$comp = $res_progress["course_comp"];								
				?>
          <tr>
            <td height="25" align="left" valign="middle" class="pedtext_normal" bgcolor="#F7F7F7" style=" border-bottom:solid 1px;">&nbsp;<?php echo $r[first_name];?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-bottom:solid 1px; border-color:#999999;"><?php if($parti>0) { echo $parti; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($home) { echo $home; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($flu>0) { echo $flu; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($pro>0) { echo $pro; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($gra>0) { echo $gra; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($voca>0) { echo $voca; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($comp>0) { echo $comp; }?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#999999;"><?php if($avg) { echo $avg; } ?></td>
            <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px;  border-bottom:solid 1px;border-color:#000000;" ><?php if($at>0) { echo $at; }?></td>
          </tr>
          <tr>
            <td height="1" colspan="10" align="left" valign="middle" bgcolor="#F5F5F5"></td>
          </tr>
          <?php
				 }
				 ?>
        </table></td>
      </tr>
      <tr>
        <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
        <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_COMMNAME");?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="left" valign="middle" class="leftmenu">&nbsp;</td>
        <td class="pedtext">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_VERYGOOD");?></td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_GOOD");?></td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_SATISFACTORY");?></td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_FAIR");?></td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_GROUP_PROGRESS_INSUFFICIENT");?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;</td>
        <td class="pedtext">&nbsp;</td>
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
        <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("CD_GROUP_PROGRESS_PEDASUPERVISOR");?></td>
        <td>&nbsp;</td>
        <td align="right" valign="middle" class="pedtext"><?php echo date('m/d/Y');?></td>
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


</body>
</html>
<script type="text/javascript">
window.print();
</script>