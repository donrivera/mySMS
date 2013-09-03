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

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[cmbgroup]'");
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
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='report_group_progress.php?cmbgroup='+cmbgroup+'&mystatus='+mystatus;
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
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
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
            <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext">Status:&nbsp;</td>
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
            <td width="28%" height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?>:&nbsp;</td>
            <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
              <select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                <option value="">Select Group</option>
                <?php
			  	if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
				foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $res_group) {
				?>
                <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                <?php
			  }
			  ?>
                </select></td>
          </tr>
          <tr>
            <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
          </tr>
        </table></td>
        <td width="493" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="46" align="center" valign="middle" bgcolor="#FFFFFF"><a href="report_group_progress_print.php?group_id=<?php echo $_REQUEST[cmbgroup];?>" target="_blank"><?php if($_REQUEST[cmbgroup]!="") { ?><img src="../images/printButton.png" width="50" height="16" border="0"><?php } ?></a></td>
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
		  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
		  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
		  $teacher_id = $res_g["teacher_id"];
		  
		  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
		  
		  if($_REQUEST[group_id]!=''){
			 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
		  }
		  ?>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?> : </td>
            <td align="left" valign="middle" class="pedtext_normal"><?php if($res_g[group_name] != ''){ ?><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?><?php } ?></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?> : </td>
                <?php
				if($_SESSION[lang]=='EN'){
					$lang1 = "English";
				}else if($_SESSION[lang]=='AR'){
					$lang1 = "Arabic";
				}else{
					$lang1 = "English";
				}
				?>
                <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php echo $lang1;?></td>
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
            <td align="left" valign="middle" class="pedtext_normal"><?php echo $res_group[name];?></td>
            <td>&nbsp;</td>
            <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?>: </td>
                <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_size[units];?></td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>
                <td width="34%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?>:</td>
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
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?>  : </td>
            <td align="left" valign="middle" class="pedtext_normal"><?php if($res_g[group_name] != ''){ ?>
              <?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?><?php } ?>
              </td>
            <td>&nbsp;</td>
            
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?>: </td>
                <td width="59%" align="left" valign="middle" class="pedtext_normal" ><?php if($res_g[group_name] != ''){ ?><?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?><?php } ?></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?>:</td>
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
            <td height="20" colspan="5" align="left" valign="middle" class="leftmenu">
            <table width="988" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30" colspan="10" align="left" valign="middle">&nbsp;&nbsp;<u class="leftmenu"><?php echo constant("CD_GROUP_PROGRESS_SCORE");?></u></td>
                </tr>
              <tr>
                <td height="1" colspan="10" align="left" valign="middle" bgcolor="#000000"></td>
                </tr>
              <tr>
                <td width="200" height="25" align="left" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
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
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*,c.course_id") as $r){ 
				 
				 	$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$_REQUEST[cmbgroup]' And student_id='$r[id]'");
					
					//$res_progress["course_attendance_perc"]+
					$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_listen"];
					if($avg>0){
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
					$comp = $res_progress["course_listen"];								
				?>
              <tr>
                <td height="25" align="left" valign="middle" class="pedtext_normal"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($parti>0) { echo $parti; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($home) { echo $home; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($flu>0) { echo $flu; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($pro>0) { echo $pro; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($gra>0) { echo $gra; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($voca>0) { echo $voca; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($comp>0) { echo $comp; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($avg) { echo $avg; } ?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#000000;" ><?php if($at>0) { echo $at; }?></td>
              </tr>
              <tr>
                <td height="1" colspan="10" align="left" valign="middle" bgcolor="#F5F5F5"></td>
                </tr>
              <?php } ?>
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
            <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("ADMIN_COMMNAME");?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="left" valign="top" class="leftmenu">&nbsp;&nbsp;<?php echo $pro["narration"];?></td>
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
    <form name="frm" method="post" id="frm">
    <table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td width="361" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:3px;"><a href="report_group_progress_print.php?group_id=<?php echo $_REQUEST[group_id];?>" target="_blank"><?php if($_REQUEST[group_id]!="") { ?><img src="../images/printButton.png" width="50" height="16" border="0"><?php } ?></a></td>
        <td width="493" align="right" valign="middle" bgcolor="#FFFFFF">
        <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
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
            <select name="cmbgroup" class="" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
              <option value=""><?php echo constant("SELECT_GROUP");?></option>
              <?php
			  if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
			  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $res_group) {
			  ?>
              <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST["cmbgroup"]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>,  <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
              <?php } ?>
            </select></td>
            <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></td>
            
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
        
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#000000;">
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
		  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
		  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
		  $teacher_id = $res_g["teacher_id"];
		  
		  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
		  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
		  
		  if($_REQUEST[group_id]!=''){
			 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[cmbgroup]'");
		  }
		  ?>
          <tr>
            <td height="20" align="right" valign="middle" class="shop2"><?php if($res_g[group_name] != ''){ ?><?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?><?php }?>&nbsp;</td>
            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("CD_GROUP_PROGRESS_COMPANYGROUP");?></td>
            <td>&nbsp;</td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
                <?php
				if($_SESSION[lang]=='EN'){
					$lang1 = "English";
				}else if($_SESSION[lang]=='AR'){
					$lang1 = "Arabic";
				}else{
					$lang1 = "English";
				}
				?>
                <td width="59%" align="right" valign="middle" class="shop2" ><?php echo $lang1;?> &nbsp;</td>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu">: <?php echo constant("CD_GROUP_PROGRESS_LANGUAGE");?></td>
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
            <td height="20" align="right" valign="middle" class="shop2"><?php echo $res_group[name];?>&nbsp;</td>
            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?></td>
            <td>&nbsp;</td>
            <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="59%" height="20" align="right" valign="middle" class="shop2"><?php echo $res_size[units];?>&nbsp;</td>
                <td width="41%" align="left" valign="middle" class="leftmenu" >: <?php echo constant("CD_GROUP_PROGRESS_PROGRAMLENGTH");?></td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5%" align="left" valign="middle" class="nametext">&nbsp;</td>                
                <?php				
				//Get number of Attendace present in e-PEDCARD (table : ped_attendance)
				$num_total_class=$dbf->countRows('ped_units',"group_id='$_REQUEST[cmbgroup]'");
				?>
                <td width="45%" align="right" valign="middle" class="pedtext_normal"><?php echo $num_total_class;?>&nbsp;</td>
                <td width="34%" height="20" align="left" valign="middle" class="leftmenu">: <?php echo constant("CD_GROUP_PROGRESS_LESSIONTAKEN");?></td>
                <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" align="right" valign="middle" class="shop2"><?php if($res_g[group_name] != ''){ ?><?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?><?php }?>&nbsp;</td>
            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?></td>
            <td>&nbsp;</td>
            
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
                <td width="59%" align="right" valign="middle" class="shop2" ><?php if($res_g[group_name] != ''){ ?><?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?><?php }?>&nbsp;</td>
                <td width="41%" height="20" align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            
            <td align="right" valign="middle" class="shop2"><?php echo $res_course[name];?>&nbsp;</td>
            <td height="20" align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" colspan="5" align="right" valign="middle" class="shop2">&nbsp;<?php echo constant("CD_GROUP_PROGRESS_LONGTEXT");?>&nbsp;&nbsp;</td>
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
                <td width="82" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal" style="border-left:solid 1px; border-color:#000000;">
				<?php echo constant("CD_GROUP_PROGRESS_ATTENDACE");?></td>                
                <td width="98" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                <td width="87" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_HOMEWORK");?></td>
                <td width="75" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_FLUENCY");?></td>
                <td width="104" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_PRONUNCI");?></td>
                <td width="74" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_GRAMMAR");?></td>
                <td width="97" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("STUDENT_PROGRESS_REPORT_VOCABUL");?></td>
                <td width="98" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("CD_GROUP_PROGRESS_COMPREHENSION");?></td>
                <td width="70" align="center" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("CD_GROUP_PROGRESS_OVERALL");?></td>
                
                
                <td width="200" height="25" align="right" valign="middle" bgcolor="#F5F5F5" class="pedtext_normal"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="1" colspan="10" align="left" valign="middle" bgcolor="#000000"></td>
                </tr>
                <?php 
				 $attend_calc=0;
				 $student_count = 1;
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*,c.id") as $r){ 
				 
				 	$res_progress = $dbf->strRecordID("teacher_progress_course","*","group_id='$_REQUEST[group_id]' And student_id='$r[id]'");
					
					//$res_progress["course_attendance_perc"]+
					$avg = $res_progress["course_partication"]+$res_progress["course_homework"]+$res_progress["course_fluency"]+$res_progress["course_pro"]+$res_progress["course_grammer"]+$res_progress["course_voca"]+$res_progress["course_listen"];
					if($avg>0){
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
					$comp = $res_progress["course_listen"];								
				?>
              <tr>
                <td align="center" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;" ><?php if($at>0) { echo $at; }?></td>
                
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($parti>0) { echo $parti; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($home) { echo $home; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($flu>0) { echo $flu; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($pro>0) { echo $pro; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($gra>0) { echo $gra; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($voca>0) { echo $voca; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($comp>0) { echo $comp; }?></td>
                <td align="center" valign="middle" class="pedtext_normal" style="border-left:solid 1px; border-color:#F5F5F5;"><?php if($avg) { echo $avg; } ?></td>
                                
                <td height="25" align="right" valign="middle" class="pedtext_normal"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?>&nbsp;</td>
              </tr>
              <tr>
                <td height="1" colspan="10" align="left" valign="middle" bgcolor="#F5F5F5"></td>
                </tr>
              <?php } ?>
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
            <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo constant("ADMIN_COMMNAME");?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="left" valign="top" class="leftmenu">&nbsp;&nbsp;<?php echo $pro["narration"];?></td>
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
<?php } ?>
</body>
</html>