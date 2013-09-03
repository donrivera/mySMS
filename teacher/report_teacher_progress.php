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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$teacher_id = $_SESSION[uid];

$rest = $dbf->strRecordID("teacher","*","id='$teacher_id'");
$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[group_id]'");
?>

<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />	
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

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="../datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});
</script>
<!--UI JQUERY DATE PICKER-->
<script language="javascript" type="text/javascript">
function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
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
</script>
<script type="text/javascript">
function setsubmit(){
	var group_id = document.getElementById('group_id').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='report_teacher_progress.php?group_id='+group_id+'&mystatus='+mystatus;
}

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("group_id.php", {status: $(this).val()}); // Page Name and Condition
	});
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    <form action="report_teacher_progress_save.php?action=insert" name="frm" method="post" id="frm">
        <table width="1100" border="0" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
          <tr>
            <td width="6%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
            <td width="77%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_TEACHER_HEADTEXT");?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%" align="left" valign="middle" class="nametext">&nbsp;</td>
                  <td width="21%">&nbsp;</td>
                  <td width="1%">&nbsp;</td>
                  <td width="31%">&nbsp;</td>
                  <td width="32%" align="center"><?php if($_REQUEST[group_id]!='') {?>
            <a href="report_teacher_progress_print.php?group_id=<?php echo $_REQUEST[group_id];?>" target="_blank">
            <img src="../images/print.png" width="16" height="16" /></a><?php } ?></td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">
                  
                  <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext">Status : &nbsp;</td>
                      <?php
					  if($_REQUEST["mystatus"] == ''){
						  $status = 'Continue';
					  }else{
						  $status = $_REQUEST['mystatus'];
					  }
					  ?>
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading">
                      <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                        <option value="">All</option>
                        <option value="Not Started" <?php if($status=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($status=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($status=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%" height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?> : &nbsp;</td>
                      <td width="75%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
                        <select name="group_id" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                          <option value="">Select Group</option>
                          <?php
						  if($_REQUEST["mystatus"] == ''){
							  $status = 'Continue';
						  }else{
							  $status = $_REQUEST['mystatus'];
						  }
						  foreach($dbf->fetchOrder('student_group',"status='$status' And teacher_id='$teacher_id'","","") as $res_group) {
							  ?>
                          <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                          <?php
						  }
						  ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?> : &nbsp;</td>
                      <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="pedtext"><?php echo $res_course[name];?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($_REQUEST[group_id]!='' && $_REQUEST[course_id]!='')
				  {
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND course_id='$_REQUEST[course_id]' AND group_id='$_REQUEST[group_id]'");
				  }
				  ?>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : </td>
                  <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext"><?php echo $res_size[units];?>
						<input type="hidden" name="hidAttend" id="hidAttend" value="<?php echo $res_size[effect_units];?>"/>
						</td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="29%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?> : </td>
                        <td width="44%" align="left" valign="middle" class="nametext"><?php echo $rest[name];?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" >
						<?php
                        if($_REQUEST[group_id] != '')
						{
							if($res_g[start_date]!='0000-00-00')
							{
								echo date("d/m/Y",strtotime($res_g[start_date]));
							}
						}
						?>                        
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
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
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext" ><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="29%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="44%" align="left" valign="middle" class="nametext"><?php echo $hr;?> <?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext">
						<?php
                        if($_REQUEST[group_id] != '')
						{
							if($res_g[end_date]!='0000-00-00')
							{
								echo date("d/m/Y",strtotime($res_g[end_date]));
							}
						}
						?></td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext"><?php echo $edt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="23%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                        <td width="50%" align="left" valign="middle">
                          <input name="certificate" type="text" class="new_textbox190" id="certificate" value="<?php echo $pro["certificate"];?>">
                        </td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="52%" align="left" valign="middle"><input name="grade_submit" type="text" class="datepick new_textbox80" id="grade_submit" readonly="" value="<?php if($pro["grade_submit"]!="0000-00-00") { echo $pro["grade_submit"];}?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                        <td width="59%" align="center" valign="middle">
                          <input name="progress_report_date" type="text" class="datepick new_textbox80" id="progress_report_date" readonly="" value="<?php if($pro["progress_report_date"]!="0000-00-00") { echo $pro["progress_report_date"];}?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?> : </td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="52%" align="left" valign="middle">
                          <input name="report_print" type="text" class="datepick new_textbox80" id="report_print" readonly="" value="<?php if($pro[report_print]!="0000-00-00") { echo $pro["report_print"]; } ?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext">
                        <input name="report_print_by" type="text" class="new_textbox190" id="report_print_by" value="<?php echo $pro["report_print_by"];?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT4");?> : </td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="52%" align="left" valign="middle">
                          <input name="certificate_print" type="text" class="datepick new_textbox80" id="certificate_print" readonly="" value="<?php if($pro["certificate_print"]!="0000-00-00") { echo $pro["certificate_print"]; } ?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle">
                          <input name="certificate_print_by" type="text" class="new_textbox190" id="certificate_print_by" value="<?php echo $pro["certificate_print_by"];?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="20" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#6699CC" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_TXT7");?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" >
              <?php
			$row = 1;
			
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="3" align="center" valign="middle"><span class="heading"><?php echo $res_course_name[name];?></span></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle">
                    
                    <?php
                if($_REQUEST[group_id]!='')
				{
				?>
                    <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                      
                      <tr>
                        <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PARTICI");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_HW");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                      </tr>
                      <?php
					$student_count = 1;
					
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id,g.units") as $r) {
					?>
                      <?php
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_course","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");					
					?>
                      <tr>                  
                        <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                        <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                        <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?>
                        <input type="hidden" name="student_id<?php echo "_".$student_count;?>" id="student_id<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>"></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_partication<?php echo "_".$student_count;?>" id="course_partication<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_partication']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_partication']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_partication']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_partication']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_partication']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>    
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_homework<?php echo "_".$student_count;?>" id="course_homework<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_homework']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_homework']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_homework']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_homework']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_homework']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_fluency<?php echo "_".$student_count;?>" id="course_fluency<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_fluency']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_fluency']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_fluency']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_fluency']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_fluency']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_pro<?php echo "_".$student_count;?>" id="course_pro<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_pro']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_pro']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_pro']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_pro']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_pro']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_grammer<?php echo "_".$student_count;?>" id="course_grammer<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_grammer']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_grammer']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_grammer']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_grammer']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_grammer']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_voca<?php echo "_".$student_count;?>" id="course_voca<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_voca']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_voca']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_voca']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_voca']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_voca']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_listen<?php echo "_".$student_count;?>" id="course_listen<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_listen']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_listen']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_listen']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_listen']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_listen']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <?php
					$count_shift = $dbf->No_Of_Attendance($r["id"], $_REQUEST["group_id"]);
					?>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <input type="text" name="course_attendance<?php echo "_".$student_count;?>" id="course_attendance<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;" maxlength="3" onKeyPress="return isNumberKey(event);" value="<?php echo $count_shift; ?>" readonly="">
                        </td>
                        <?php					
					$group_unit = $res_size[effect_units];
					
					$uu = $dbf->strRecordID("common","*","id='$r[units]'");
					//get unit from common table					
					                    
					//$group_unit = $group_unit / $uu[name];
					//$group_unit = $group_unit / $uu[name];
					$group_unit = $res_size[units];
					
					$attend_perc=0;
					if($count_shift!='0'){
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					
					if($attend_perc<61){
						$rfiles = "round-red.png";
					}else if($attend_perc >= 61 && $attend_perc <= 84){
						$rfiles = "round-yellow.png";
					}else if($attend_perc >= 85){
						$rfiles = "round-green.png";
					}										
					?>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php echo $group_unit / 2;?></td>
                        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"  /></td>
                            <td width="53%" align="center" valign="middle" class="mycon"><?php echo $attend_perc;?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <?php
                  $student_count++;
				  }
				  ?>
                    </table>
                    <?php
				}else{
				?>
                    <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                      
                      <tr>
                        <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PARTICI");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_HW");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                      </tr>
                      <tr>                  
                        <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="47%" align="right" valign="middle"><img src="../images/round-red.png"  /></td>
                            <td width="53%" align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
                    <?php
				}
                ?>
                  </td>
                  <input type="hidden" name="student_count" id="student_count" value="<?php echo $student_count-1;?>">
                </tr>
                <tr>
                  <td width="35%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
              
            </td>
          </tr>
          
           <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#000066" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" >
              <?php
				$row = 1;
				$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
				$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <input type="hidden" name="course_id1<?php echo $course_count;?>" id="course_id1<?php echo $course_count;?>" value="<?php echo $res_course_name[id];?>">
                  <td colspan="3" align="center" valign="middle"><span class="heading"><?php echo $res_course_name[name];?></span></td>
                  </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle">
                  <?php
				  if($_REQUEST[group_id]!='')
				  {
				  ?>
                  <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                    </tr>
                    <?php
                    $student_count = 1;
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r) {
					
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");	
					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
									
					?>
                    <tr>
                      <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                      <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?>
                      <input type="hidden" name="student_id1<?php echo "_".$student_count;?>" id="student_id1<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>">
                      </td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="fluency<?php echo "_".$student_count;?>" id="fluency<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['fluency']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['fluency']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['fluency']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['fluency']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['fluency']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="pronunciation<?php echo "_".$student_count;?>" id="pronunciation<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['pronunciation']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['pronunciation']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['pronunciation']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['pronunciation']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['pronunciation']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                       <select name="grammer<?php echo "_".$student_count;?>" id="grammer<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['grammer']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['grammer']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['grammer']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['grammer']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['grammer']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="vocabulary<?php echo "_".$student_count;?>" id="vocabulary<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['vocabulary']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['vocabulary']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['vocabulary']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['vocabulary']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['vocabulary']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="listening<?php echo "_".$student_count;?>" id="listening<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['listening']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['listening']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['listening']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['listening']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['listening']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8">
                      <select name="end_of_level<?php echo "_".$student_count;?>" id="end_of_level<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['end_of_level']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['end_of_level']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['end_of_level']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['end_of_level']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['end_of_level']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          
                          <option value="6"<?php if($course_mark['end_of_level']=="6") { ?> selected="selected" <?php } ?>>6</option>
                          <option value="7" <?php if($course_mark['end_of_level']=="7") { ?> selected="selected" <?php } ?>>7</option>
                          <option value="8"<?php if($course_mark['end_of_level']=="8") { ?> selected="selected" <?php } ?>>8</option>
                          <option value="9"<?php if($course_mark['end_of_level']=="9") { ?> selected="selected" <?php } ?>>9</option>
                          <option value="10"<?php if($course_mark['end_of_level']=="10") { ?> selected="selected" <?php } ?>>10</option>
                          
                          <option value="11"<?php if($course_mark['end_of_level']=="11") { ?> selected="selected" <?php } ?>>11</option>
                          <option value="12" <?php if($course_mark['end_of_level']=="12") { ?> selected="selected" <?php } ?>>12</option>
                          <option value="13"<?php if($course_mark['end_of_level']=="13") { ?> selected="selected" <?php } ?>>13</option>
                          <option value="14"<?php if($course_mark['end_of_level']=="14") { ?> selected="selected" <?php } ?>>14</option>
                          <option value="15"<?php if($course_mark['end_of_level']=="15") { ?> selected="selected" <?php } ?>>15</option>
                          
                          <option value="16"<?php if($course_mark['end_of_level']=="16") { ?> selected="selected" <?php } ?>>16</option>
                          <option value="17" <?php if($course_mark['end_of_level']=="17") { ?> selected="selected" <?php } ?>>17</option>
                          <option value="18"<?php if($course_mark['end_of_level']=="18") { ?> selected="selected" <?php } ?>>18</option>
                          <option value="19"<?php if($course_mark['end_of_level']=="19") { ?> selected="selected" <?php } ?>>19</option>
                          <option value="20"<?php if($course_mark['end_of_level']=="20") { ?> selected="selected" <?php } ?>>20</option>
                          
                          <option value="21"<?php if($course_mark['end_of_level']=="21") { ?> selected="selected" <?php } ?>>21</option>
                          <option value="22" <?php if($course_mark['end_of_level']=="22") { ?> selected="selected" <?php } ?>>22</option>
                          <option value="23"<?php if($course_mark['end_of_level']=="23") { ?> selected="selected" <?php } ?>>23</option>
                          <option value="24"<?php if($course_mark['end_of_level']=="24") { ?> selected="selected" <?php } ?>>24</option>
                          <option value="25"<?php if($course_mark['end_of_level']=="25") { ?> selected="selected" <?php } ?>>25</option>
                          
                          <option value="26"<?php if($course_mark['end_of_level']=="26") { ?> selected="selected" <?php } ?>>26</option>
                          <option value="27" <?php if($course_mark['end_of_level']=="27") { ?> selected="selected" <?php } ?>>27</option>
                          <option value="28"<?php if($course_mark['end_of_level']=="28") { ?> selected="selected" <?php } ?>>28</option>
                          <option value="29"<?php if($course_mark['end_of_level']=="29") { ?> selected="selected" <?php } ?>>29</option>
                          <option value="30"<?php if($course_mark['end_of_level']=="30") { ?> selected="selected" <?php } ?>>30</option>
                          
                          <option value="31"<?php if($course_mark['end_of_level']=="31") { ?> selected="selected" <?php } ?>>31</option>
                          <option value="32" <?php if($course_mark['end_of_level']=="32") { ?> selected="selected" <?php } ?>>32</option>
                          <option value="33"<?php if($course_mark['end_of_level']=="33") { ?> selected="selected" <?php } ?>>33</option>
                          <option value="34"<?php if($course_mark['end_of_level']=="34") { ?> selected="selected" <?php } ?>>34</option>
                          <option value="35"<?php if($course_mark['end_of_level']=="35") { ?> selected="selected" <?php } ?>>35</option>
                          
                          <option value="36"<?php if($course_mark['end_of_level']=="36") { ?> selected="selected" <?php } ?>>36</option>
                          <option value="37" <?php if($course_mark['end_of_level']=="37") { ?> selected="selected" <?php } ?>>37</option>
                          <option value="38"<?php if($course_mark['end_of_level']=="38") { ?> selected="selected" <?php } ?>>38</option>
                          <option value="39"<?php if($course_mark['end_of_level']=="39") { ?> selected="selected" <?php } ?>>39</option>
                          <option value="40"<?php if($course_mark['end_of_level']=="40") { ?> selected="selected" <?php } ?>>40</option>
                        </select></td>
						<?php
						$count_shift = $dbf->No_Of_Attendance($r["id"], $_REQUEST["group_id"]);
						?>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <input type="text" name="attendance<?php echo "_".$student_count;?>" id="attendance<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;" maxlength="3" onKeyPress="return isNumberKey(event);" value="<?php echo $count_shift;?>" readonly=""></td>
                      
                     <?php
					$group_unit = $res_size[units];
					
					$attend_perc=0;
					if($count_shift!='0'){
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					if($attend_perc<61){
						$rfiles = "round-red.png";
					}else if($attend_perc >= 61 && $attend_perc <= 84){
						$rfiles = "round-yellow.png";
					}else if($attend_perc >= 85){
						$rfiles = "round-green.png";
					}
					?>
                      <td align="center" valign="middle" class="mycon"><?php echo $res_size[units];?></td>
                      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"/></td>
                          <td width="53%" align="center" valign="middle" class="mycon"><?php echo $attend_perc;?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php
					$student_count++;				
                    }
					?>
                    <input type="hidden" name="student_count1" id="student_count1" value="<?php echo $student_count-1;?>">
                  </table>
                  <?php
				  }
				  else
				  {
				  ?>
				  <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></span></td>
                      <td height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></span></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="47%" align="right" valign="middle"><img src="../images/round-red.png"/></td>
                          <td width="53%" align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
				  <?php
				  }
				  ?>
                  </td>
                </tr>
                <tr>
                  <td width="35%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
				<input type="hidden" name="course_count1" id="course_count1" value="<?php echo $course_count-1;?>">

              </td>
          </tr>
          <?php if($_REQUEST[group_id] !='') { ?>
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="left" valign="middle"><table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="nametext"><?php echo constant("ADMIN_CHALLAN_COND_NARRATION");?> :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="3"><textarea name="narration" id="narration" style="width:560px; height:60px;"><?php echo $pro[narration];?></textarea></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td>&nbsp;</td>
            <td height="20" align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle">
              <?php if($_REQUEST[group_id] !='') { ?>
              <input name="submit" type="submit" class="btn1" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" />
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="20" align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
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
<?php } else{?>
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
        <table width="1100" border="0" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
          <tr>
            <td width="13%">&nbsp;</td>
            <td width="77%">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"></td>
            <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_TEACHER_HEADTEXT");?></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%" align="left" valign="middle"><?php if($_REQUEST[group_id]!='') {?>
            <a href="report_teacher_progress_print.php?group_id=<?php echo $_REQUEST[group_id];?>" target="_blank">
            <img src="../images/print.png" width="16" height="16" /></a><?php } ?></td>
                  <td width="21%">&nbsp;</td>
                  <td width="1%">&nbsp;</td>
                  <td width="31%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">
                  
                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center" valign="middle">
                  <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" >
                      <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                        <option value="">All</option>
                        <option value="Not Started" <?php if($_REQUEST["mystatus"]=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($_REQUEST["mystatus"]=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($_REQUEST["mystatus"]=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                        </select></td>
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="pedtext">:<?php echo constant('ADMIN_WEEK_MANAGE_STATUS');?>
                      
                      </td>
                    </tr>
                    <tr>
                      <td width="71%" height="25" align="right" bgcolor="#FFCB7D" id="statusresult"><select name="group_id" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                          <option value="">Select Group</option>
                          <?php
						  if($_REQUEST["mystatus"] == ''){
							  $status = '';
						  }else{
							  $status = " And status='".$_REQUEST['mystatus']."'";
						  }
						  foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'".$status,"","") as $res_group) {
							  ?>
                          <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                          <?php
						  }
						  ?>
                        </select></td>
                      <td width="29%" align="left" valign="middle" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>
                        
                      </td>
                    </tr>
					<?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext">&nbsp;<?php echo $res_course[name];?></td>
                      
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table>
                  </td>
                </tr>
                <?php
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($_REQUEST[group_id]!='' && $_REQUEST[course_id]!='')
				  {
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND course_id='$_REQUEST[course_id]' AND group_id='$_REQUEST[group_id]'");
				  }
				  ?>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : </td>
                  <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext"><?php echo $res_size[units];?>
						<input type="hidden" name="hidAttend" id="hidAttend" value="<?php echo $res_size[effect_units];?>"/>
						</td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="29%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?> : </td>
                        <td width="44%" align="left" valign="middle" class="nametext"><?php echo $rest[name];?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" >
						<?php
                        if($_REQUEST[group_id] != '')
						{
							if($res_g[start_date]!='0000-00-00')
							{
								echo date("d/m/Y",strtotime($res_g[start_date]));
							}
						}
						?>                        
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
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
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext" ><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="29%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="44%" align="left" valign="middle" class="nametext"><?php echo $hr;?> <?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext">
						<?php
                        if($_REQUEST[group_id] != '')
						{
							if($res_g[end_date]!='0000-00-00')
							{
								echo date("d/m/Y",strtotime($res_g[end_date]));
							}
						}
						?></td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext"><?php echo $edt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="23%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                        <td width="50%" align="left" valign="middle">
                          <input name="certificate" type="text" class="new_textbox190" id="certificate" value="<?php echo $pro["certificate"];?>">
                        </td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="52%" align="left" valign="middle"><input name="grade_submit" type="text" class="datepick new_textbox80" id="grade_submit" readonly="" value="<?php if($pro["grade_submit"]!="0000-00-00") { echo $pro["grade_submit"];}?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                        <td width="59%" align="center" valign="middle">
                          <input name="progress_report_date" type="text" class="datepick new_textbox80" id="progress_report_date" readonly="" value="<?php if($pro["progress_report_date"]!="0000-00-00") { echo $pro["progress_report_date"];}?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?> : </td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="52%" align="left" valign="middle">
                          <input name="report_print" type="text" class="datepick new_textbox80" id="report_print" readonly="" value="<?php if($pro[report_print]!="0000-00-00") { echo $pro["report_print"]; } ?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext">
                        <input name="report_print_by" type="text" class="new_textbox190" id="report_print_by" value="<?php echo $pro["report_print_by"];?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT4");?> : </td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="52%" align="left" valign="middle">
                          <input name="certificate_print" type="text" class="datepick new_textbox80" id="certificate_print" readonly="" value="<?php if($pro["certificate_print"]!="0000-00-00") { echo $pro["certificate_print"]; } ?>">
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle">
                          <input name="certificate_print_by" type="text" class="new_textbox190" id="certificate_print_by" value="<?php echo $pro["certificate_print_by"];?>">
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" class="nametext">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#6699CC" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_TXT7");?></td>
          </tr>
          <tr>
            <td height="20" colspan="2" align="center" valign="middle" >
              <?php
			$row = 1;
			
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="3" align="center" valign="middle"><span class="heading"><?php echo $res_course_name[name];?></span></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle">
                    
                    <?php
                if($_REQUEST[group_id]!='')
				{
				?>
                    <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                      
                      <tr>
                        <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PARTICI");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_HW");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                      </tr>
                      <?php
					$student_count = 1;
					
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id,g.units") as $r) {
					?>
                      <?php
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_course","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");					
					?>
                      <tr>                  
                        <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                        <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                        <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?>
                        <input type="hidden" name="student_id<?php echo "_".$student_count;?>" id="student_id<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>"></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_partication<?php echo "_".$student_count;?>" id="course_partication<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_partication']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_partication']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_partication']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_partication']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_partication']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>    
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_homework<?php echo "_".$student_count;?>" id="course_homework<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_homework']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_homework']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_homework']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_homework']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_homework']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_fluency<?php echo "_".$student_count;?>" id="course_fluency<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_fluency']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_fluency']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_fluency']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_fluency']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_fluency']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_pro<?php echo "_".$student_count;?>" id="course_pro<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_pro']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_pro']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_pro']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_pro']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_pro']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_grammer<?php echo "_".$student_count;?>" id="course_grammer<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_grammer']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_grammer']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_grammer']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_grammer']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_grammer']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_voca<?php echo "_".$student_count;?>" id="course_voca<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_voca']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_voca']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_voca']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_voca']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_voca']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <select name="course_listen<?php echo "_".$student_count;?>" id="course_listen<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;">
                            <option value=""></option>
                            <option value="1"<?php if($course_mark['course_listen']=="1") { ?> selected="selected" <?php } ?>>1</option>
                            <option value="2" <?php if($course_mark['course_listen']=="2") { ?> selected="selected" <?php } ?>>2</option>
                            <option value="3"<?php if($course_mark['course_listen']=="3") { ?> selected="selected" <?php } ?>>3</option>
                            <option value="4"<?php if($course_mark['course_listen']=="4") { ?> selected="selected" <?php } ?>>4</option>
                            <option value="5"<?php if($course_mark['course_listen']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          </select>
                        </td>
                        <?php
					$count_shift = $dbf->No_Of_Attendance($r["id"], $_REQUEST["group_id"]);
					?>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">
                          <input type="text" name="course_attendance<?php echo "_".$student_count;?>" id="course_attendance<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;" maxlength="3" onKeyPress="return isNumberKey(event);" value="<?php echo $count_shift; ?>" readonly="">
                        </td>
                        <?php					
					$group_unit = $res_size[effect_units];
					
					$uu = $dbf->strRecordID("common","*","id='$r[units]'");
					//get unit from common table					
					                    
					//$group_unit = $group_unit / $uu[name];
					//$group_unit = $group_unit / $uu[name];
					$group_unit = $res_size[units];
					
					$attend_perc=0;
					if($count_shift!='0'){
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					
					if($attend_perc<61){
						$rfiles = "round-red.png";
					}else if($attend_perc >= 61 && $attend_perc <= 84){
						$rfiles = "round-yellow.png";
					}else if($attend_perc >= 85){
						$rfiles = "round-green.png";
					}										
					?>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php echo $group_unit / 2;?></td>
                        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"  /></td>
                            <td width="53%" align="center" valign="middle" class="mycon"><?php echo $attend_perc;?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <?php
                  $student_count++;
				  }
				  ?>
                    </table>
                    <?php
				}else{
				?>
                    <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                      
                      <tr>
                        <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                        <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PARTICI");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_HW");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                        <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                      </tr>
                      <tr>                  
                        <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="47%" align="right" valign="middle"><img src="../images/round-red.png"  /></td>
                            <td width="53%" align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
                    <?php
				}
                ?>
                  </td>
                  <input type="hidden" name="student_count" id="student_count" value="<?php echo $student_count-1;?>">
                </tr>
                <tr>
                  <td width="35%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
              
            </td>
          </tr>
          
           <tr>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#000066" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?></td>
          </tr>
          
          <tr>
            <td height="20" colspan="2" align="center" valign="middle" >
              <?php
				$row = 1;
				$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
				$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <input type="hidden" name="course_id1<?php echo $course_count;?>" id="course_id1<?php echo $course_count;?>" value="<?php echo $res_course_name[id];?>">
                  <td colspan="3" align="center" valign="middle"><span class="heading"><?php echo $res_course_name[name];?></span></td>
                  </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle">
                  <?php
				  if($_REQUEST[group_id]!='')
				  {
				  ?>
                  <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                    </tr>
                    <?php
                    $student_count = 1;
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r) {
					
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");	
					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
									
					?>
                    <tr>
                      <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                      <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?>
                      <input type="hidden" name="student_id1<?php echo "_".$student_count;?>" id="student_id1<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>">
                      </td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="fluency<?php echo "_".$student_count;?>" id="fluency<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['fluency']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['fluency']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['fluency']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['fluency']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['fluency']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="pronunciation<?php echo "_".$student_count;?>" id="pronunciation<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['pronunciation']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['pronunciation']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['pronunciation']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['pronunciation']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['pronunciation']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                       <select name="grammer<?php echo "_".$student_count;?>" id="grammer<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['grammer']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['grammer']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['grammer']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['grammer']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['grammer']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="vocabulary<?php echo "_".$student_count;?>" id="vocabulary<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['vocabulary']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['vocabulary']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['vocabulary']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['vocabulary']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['vocabulary']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <select name="listening<?php echo "_".$student_count;?>" id="listening<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['listening']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['listening']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['listening']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['listening']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['listening']=="5") { ?> selected="selected" <?php } ?>>5</option>
                        </select>
                        
                      </td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8">
                      <select name="end_of_level<?php echo "_".$student_count;?>" id="end_of_level<?php echo "_".$student_count;?>" style="border:none; width:60px; text-align:center; font-weight:bold;">
                      	  <option value=""></option>
                          <option value="1"<?php if($course_mark['end_of_level']=="1") { ?> selected="selected" <?php } ?>>1</option>
                          <option value="2" <?php if($course_mark['end_of_level']=="2") { ?> selected="selected" <?php } ?>>2</option>
                          <option value="3"<?php if($course_mark['end_of_level']=="3") { ?> selected="selected" <?php } ?>>3</option>
                          <option value="4"<?php if($course_mark['end_of_level']=="4") { ?> selected="selected" <?php } ?>>4</option>
                          <option value="5"<?php if($course_mark['end_of_level']=="5") { ?> selected="selected" <?php } ?>>5</option>
                          
                          <option value="6"<?php if($course_mark['end_of_level']=="6") { ?> selected="selected" <?php } ?>>6</option>
                          <option value="7" <?php if($course_mark['end_of_level']=="7") { ?> selected="selected" <?php } ?>>7</option>
                          <option value="8"<?php if($course_mark['end_of_level']=="8") { ?> selected="selected" <?php } ?>>8</option>
                          <option value="9"<?php if($course_mark['end_of_level']=="9") { ?> selected="selected" <?php } ?>>9</option>
                          <option value="10"<?php if($course_mark['end_of_level']=="10") { ?> selected="selected" <?php } ?>>10</option>
                          
                          <option value="11"<?php if($course_mark['end_of_level']=="11") { ?> selected="selected" <?php } ?>>11</option>
                          <option value="12" <?php if($course_mark['end_of_level']=="12") { ?> selected="selected" <?php } ?>>12</option>
                          <option value="13"<?php if($course_mark['end_of_level']=="13") { ?> selected="selected" <?php } ?>>13</option>
                          <option value="14"<?php if($course_mark['end_of_level']=="14") { ?> selected="selected" <?php } ?>>14</option>
                          <option value="15"<?php if($course_mark['end_of_level']=="15") { ?> selected="selected" <?php } ?>>15</option>
                          
                          <option value="16"<?php if($course_mark['end_of_level']=="16") { ?> selected="selected" <?php } ?>>16</option>
                          <option value="17" <?php if($course_mark['end_of_level']=="17") { ?> selected="selected" <?php } ?>>17</option>
                          <option value="18"<?php if($course_mark['end_of_level']=="18") { ?> selected="selected" <?php } ?>>18</option>
                          <option value="19"<?php if($course_mark['end_of_level']=="19") { ?> selected="selected" <?php } ?>>19</option>
                          <option value="20"<?php if($course_mark['end_of_level']=="20") { ?> selected="selected" <?php } ?>>20</option>
                          
                          <option value="21"<?php if($course_mark['end_of_level']=="21") { ?> selected="selected" <?php } ?>>21</option>
                          <option value="22" <?php if($course_mark['end_of_level']=="22") { ?> selected="selected" <?php } ?>>22</option>
                          <option value="23"<?php if($course_mark['end_of_level']=="23") { ?> selected="selected" <?php } ?>>23</option>
                          <option value="24"<?php if($course_mark['end_of_level']=="24") { ?> selected="selected" <?php } ?>>24</option>
                          <option value="25"<?php if($course_mark['end_of_level']=="25") { ?> selected="selected" <?php } ?>>25</option>
                          
                          <option value="26"<?php if($course_mark['end_of_level']=="26") { ?> selected="selected" <?php } ?>>26</option>
                          <option value="27" <?php if($course_mark['end_of_level']=="27") { ?> selected="selected" <?php } ?>>27</option>
                          <option value="28"<?php if($course_mark['end_of_level']=="28") { ?> selected="selected" <?php } ?>>28</option>
                          <option value="29"<?php if($course_mark['end_of_level']=="29") { ?> selected="selected" <?php } ?>>29</option>
                          <option value="30"<?php if($course_mark['end_of_level']=="30") { ?> selected="selected" <?php } ?>>30</option>
                          
                          <option value="31"<?php if($course_mark['end_of_level']=="31") { ?> selected="selected" <?php } ?>>31</option>
                          <option value="32" <?php if($course_mark['end_of_level']=="32") { ?> selected="selected" <?php } ?>>32</option>
                          <option value="33"<?php if($course_mark['end_of_level']=="33") { ?> selected="selected" <?php } ?>>33</option>
                          <option value="34"<?php if($course_mark['end_of_level']=="34") { ?> selected="selected" <?php } ?>>34</option>
                          <option value="35"<?php if($course_mark['end_of_level']=="35") { ?> selected="selected" <?php } ?>>35</option>
                          
                          <option value="36"<?php if($course_mark['end_of_level']=="36") { ?> selected="selected" <?php } ?>>36</option>
                          <option value="37" <?php if($course_mark['end_of_level']=="37") { ?> selected="selected" <?php } ?>>37</option>
                          <option value="38"<?php if($course_mark['end_of_level']=="38") { ?> selected="selected" <?php } ?>>38</option>
                          <option value="39"<?php if($course_mark['end_of_level']=="39") { ?> selected="selected" <?php } ?>>39</option>
                          <option value="40"<?php if($course_mark['end_of_level']=="40") { ?> selected="selected" <?php } ?>>40</option>
                        </select></td>
						<?php
						$count_shift = $dbf->No_Of_Attendance($r["id"], $_REQUEST["group_id"]);
						?>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <input type="text" name="attendance<?php echo "_".$student_count;?>" id="attendance<?php echo "_".$student_count;?>" style="border:none; width:50px; text-align:center; font-weight:bold;" maxlength="3" onKeyPress="return isNumberKey(event);" value="<?php echo $count_shift;?>" readonly=""></td>
                      
                     <?php
					$group_unit = $res_size[units];
					
					$attend_perc=0;
					if($count_shift!='0'){
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					if($attend_perc<61){
						$rfiles = "round-red.png";
					}else if($attend_perc >= 61 && $attend_perc <= 84){
						$rfiles = "round-yellow.png";
					}else if($attend_perc >= 85){
						$rfiles = "round-green.png";
					}
					?>
                      <td align="center" valign="middle" class="mycon"><?php echo $res_size[units];?></td>
                      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"/></td>
                          <td width="53%" align="center" valign="middle" class="mycon"><?php echo $attend_perc;?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php
					$student_count++;				
                    }
					?>
                    <input type="hidden" name="student_count1" id="student_count1" value="<?php echo $student_count-1;?>">
                  </table>
                  <?php
				  }
				  else
				  {
				  ?>
				  <table width="1100" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="250" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                      <td height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                      <td height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>                      
                      <td align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="47%" align="right" valign="middle"><img src="../images/round-red.png"/></td>
                          <td width="53%" align="center" valign="middle"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
				  <?php
				  }
				  ?>
                  </td>
                </tr>
                <tr>
                  <td width="35%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
				<input type="hidden" name="course_count1" id="course_count1" value="<?php echo $course_count-1;?>">

              </td>
          </tr>
          <?php if($_REQUEST[group_id] !='') { ?>
          <tr>
            <td height="20" colspan="2" align="left" valign="middle"><table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="nametext"><?php echo constant("ADMIN_CHALLAN_COND_NARRATION");?> :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="3"><textarea name="narration" id="narration" style="width:560px; height:60px;"><?php echo $pro[narration];?></textarea></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="20" align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
         
          <tr>
            <td height="20" colspan="2" align="center" valign="middle">
              <?php if($_REQUEST[group_id] !='') { ?>
              <input name="submit" type="submit" class="btn1" value="<?php echo constant("btn_save_btn");?>" align="left" border="0" />
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
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
<?php }?>
</body>
</html>