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
$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$teacher_id = $_SESSION[uid];
$rest = $dbf->strRecordID("teacher","*","id='$teacher_id'");

$pro = $dbf->strRecordID("teacher_progress","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
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
<script type="text/javascript">
function setsubmit(){
	var group_id = document.getElementById('group_id').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='report_center_director.php?group_id='+group_id+'&mystatus='+mystatus;
}

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("group_id.php", {status: $(this).val()}); // Page Name and Condition
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
        
        <form name="frm" method="post" id="frm" autocomplete="off">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#009;">
			  <?php if($_REQUEST['msg']=='added'){ ?>
		  	<tr>
              <td width="0%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="43%" align="center"><span  style="font-weight:bold; color:#009900;"> <?php echo constant("TEACHER_REPORT_CENTERDI_SAVEMSG");?></span></td>
              <td width="32%" align="center" valign="middle"></td>
              <td width="3%">&nbsp;</td>
            </tr>
			<?php }	?>
            <tr>
              <td width="0%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="43%">&nbsp;</td>
              <td width="32%" height="30" align="right" valign="middle"><?php if($_REQUEST[group_id] !='') { ?><a href="report_center_director_print.php?group_id=<?php echo $_REQUEST[group_id];?>" target="_blank">
            <img src="../images/print.png" width="16" height="16" /></a><?php } ?></td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?></td>
              <td align="center" valign="middle" class="heading"><img src="../images/logo.png" width="105" height="30" /></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="14%" align="left" valign="middle" class="nametext">&nbsp;</td>
                  <td width="27%">&nbsp;</td>
                  <td width="0%">&nbsp;</td>
                  <td width="29%">&nbsp;</td>
                  <td width="30%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">
                  
                  <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
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
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading" style="border-bottom:dotted 1px #000000;">
                      <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                        <option value="">Select Status</option>
                        <option value="Not Started" <?php if($status=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($status=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($status=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td width="28%" height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?> : &nbsp;</td>
                      <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" style="border-bottom:dotted 1px #000000;" id="statusresult">
                        <select name="group_id" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                            <option value="">Select Group</option>
                            <?php
							  if($_REQUEST["mystatus"] == ''){
								  $status = 'Continue';
							  }else{
								  $status = $_REQUEST['mystatus'];
							  }
                            foreach($dbf->fetchOrder('student_group',"status='$status' And teacher_id='$_SESSION[uid]'","","") as $res_group) {
                              ?>
                            <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                            <?php
                            }
                            ?>
                        </select>
                      </td>
                    </tr>
                    <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?> : &nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $res_course[name];?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table>
                  </td>                  
				  <?php
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$res_group = $dbf->strRecordID("common","*","id='$res_teacher_group[group_id]'");
				  ?>                  
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : </td>
                  <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $res_size[units];?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?> : </td>
                        <td width="47%" align="left" valign="middle" class="nametext"><?php echo $rest[name];?></td>
                        <td width="14%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[start_date]!=''){
							echo date("d/m/Y",strtotime($res_teacher_group[start_date]));
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
					$date=$res_teacher_group[start_date];
					$sdt = $DateConv->GregorianToHijri($date,$format);
					
					//End date
					$date=$res_teacher_group[end_date];
					$edt = $DateConv->GregorianToHijri($date,$format);
					?>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="45%" align="left" valign="middle" class="nametext"><?php echo $hr;?> <?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[end_date]!=''){
							echo date("d/m/Y",strtotime($res_teacher_group[end_date]));
						}
						?>
						</td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $edt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                        <td width="52%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate"];?>
                        </td>
                        <td width="9%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["grade_submit"] !='0000-00-00'){
                          	echo $pro["grade_submit"];
						  }?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                        <td width="59%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
                          if($pro["progress_report_date"] !='0000-00-00'){
							  echo $pro["progress_report_date"];
						  }
						?>
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
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php 
						  if($pro["report_print"] !='0000-00-00'){
							  echo $pro["report_print"];
						  }?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?>
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
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["certificate_print"] !='0000-00-00'){
                          	echo $pro["certificate_print"];
						  }
						  ?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="left" valign="middle"style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate_print_by"];?>
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
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" bgcolor="#000066" class="tableborder2"><?php echo constant("TEACHER_REPORT_CENTERDI_CERTIFGRD");?></td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<?php
			$row = 1;
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            
			$res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
			$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
			$res_group = $dbf->strRecordID("common","*","id='$res_teacher_group[group_id]'");
		  ?> 
			<tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" bgcolor="#E8E8E8" class="nametext"><?php echo $res_course_name[name];?> </td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<input type="hidden" name="hidcourse" id="hidcourse" value="<?php echo $res_course_name[id];?>">            
            <tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" >
              <?php
              if($_REQUEST[group_id]!=''){
			  ?>
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="12%" height="100" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                  <td width="2%" height="20" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></span></td>
                  <td width="8%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></span></td>
                  <td width="5%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></span></td>
                  <td width="4%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></span></td>
                </tr>
				 <?php
				function get_percent($input){
					if($input > 0){
						$out = 18 - (3 * $input);					
						return $out;
					}					
				}

				 $attend_calc=0;
				 $student_count = 1;
				 //echo "select s.*,c.course_id from student s,student_group_dtls c where s.id=c.student_id AND c.course_id='$res_group[course_id]' And c.parent_id='$_REQUEST[group_id]'";
				 
				 $res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
				 
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.course_id='$res_group[course_id]' And c.parent_id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r){
							 
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
					$attend=$course_mark[attendance];
					$totalunits=$res_size[units];
															
					if($totalunits!=0){
						$attend_calc=round((($attend/$totalunits)*100)/10);
					}
					
					if($course_mark[end_of_level] > 0){
						$grade_sheet = $dbf->strRecordID("grade_sheet","*","'$course_mark[end_of_level]' BETWEEN frm and tto");					
						$nos = $grade_sheet[nos];
						$benifit = 18 - (3 * $nos);
					}
					
					$final_grade = get_percent($course_mark[fluency]);
					$final_grade = $final_grade + get_percent($course_mark[pronunciation]);
					$final_grade = $final_grade + get_percent($course_mark[grammer]);
					$final_grade = $final_grade + get_percent($course_mark[vocabulary]);
					$final_grade = $final_grade + get_percent($course_mark[listening]);
					$final_grade = $final_grade + $attend_calc;
					
					if($course_mark[end_of_level] > 0){
						$final_grade = $final_grade + $benifit;
					}
					
					$res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");
				?>
                <tr>
                  <td height="25" align="left" valign="middle" class="smalltext"><?php echo $r[first_name];?></td>
                  <td align="left" valign="middle"><?php echo $res_country[value];?></td>
                  <td align="left" valign="middle" class="smalltext"><?php echo $r[student_id];?></td>
				  <input type="hidden" name="st<?php echo $student_count;?>" id="st<?php echo $student_count;?>" value="<?php echo $r[id];?>">
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?></td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $nos;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $benifit;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($res_size[units]) { echo $res_size[units]; }?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF"><?php if($attend_calc>0) { echo round($attend_calc); }?></td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php if($final_grade>0) { echo $final_grade; }?></td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php echo $res_grade[name];?></td>
                </tr>
				 <?php
				 $student_count++; 
				 } 
				 ?>
                
              </table>
              <?php
			  }else{
			  ?>
			  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="12%" height="100" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                  <td width="2%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></span></td>
                  <td width="8%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></span></td>
                  <td width="5%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></span></td>
                  <td width="5%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></span></td>
                  <td width="6%" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></span></td>
                  <td width="4%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></span></td>
                  <td width="6%" height="20" align="center" class="rotate_text"><span class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></span></td>
                </tr>
                <tr>
                  <td height="25" align="left" valign="middle" class="smalltext">&nbsp;</td>
                  <td align="left" valign="middle" class="smalltext">&nbsp;</td>
                  <td align="left" valign="middle" class="smalltext">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                  <td align="left" valign="middle" bgcolor="#E8E8E8"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                </tr>
              </table>
			  <?php
			  }
			  ?>
              </td>
			   <input type="hidden" name="student_count" id="student_count" value="<?php echo $student_count-1;?>">
              <td align="left" valign="middle">&nbsp;</td>
            </tr>			
            <tr>
              <td>&nbsp;</td>
              <td height="20" align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td height="20" align="left" valign="middle">&nbsp;</td>
              <td align="right" valign="middle"><div style="display:none;"><input name="submit" id="submit" value="submit" type="image" src="../images/save_btn.png" /></div></td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td height="20" align="left" valign="middle">&nbsp;</td>
			  <td align="center" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle">&nbsp;</td>
			  <td align="left" valign="middle">&nbsp;</td>
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
  <?php include '../footer.php';?>
</table>
</body>
</html>