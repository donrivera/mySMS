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

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$grp = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");

$teacher_id = $grp[teacher_id];

$rest = $dbf->strRecordID("teacher","*","id='$teacher_id'");

$pro = $dbf->strRecordID("teacher_progress","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[cmbgroup]'");
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
<script type="text/javascript">
$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ped_group.php", {status: $(this).val()}); // Page Name and Condition
	});
});
function setsubmit()
{
	var cmbgroup = document.getElementById('cmbgroup').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='report_centre_director_main.php?cmbgroup='+cmbgroup+'&mystatus='+mystatus;
	
	//var cmbgroup = document.getElementById('cmbgroup').value;
	//document.location.href='ped.php?cmbgroup='+cmbgroup;
}
</script>
<script type="text/javascript" src="dropdowntabs.js"></script>
<body>
<?php if($_SESSION[lang] == "EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
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
        
        <form action="report_center_director_save.php" name="frm" method="post" id="frm" autocomplete="off">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#CC9900;">
            <tr>
              <td width="0%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="43%">&nbsp;</td>
              <td width="32%">&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
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
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext">Status :&nbsp;</td>
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
                      <td width="28%" height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>:&nbsp;</td>
                      <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
                        <select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_centre_director_main.php',document.frm.submit();">
                          <option value="">Select Group</option>
                          <?php
						  if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
						  
						  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $res_group) {
							  ?>
                          <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST["cmbgroup"]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?>
</option>
                          <?php
						  }
						  ?>
                        </select>
                      </td>
                    </tr>
                    <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                    <tr>
                      <td height="25" align="right" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $res_course[name];?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table>
                  </td>                  
				  <?php
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$res_group = $dbf->strRecordID("common","*","id='$res_teacher_group[group_id]'");
				  ?>
                  
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center" valign="middle">
                  <?php if($_REQUEST[cmbgroup]!='') {?>
                    <a href="report_center_director_condition.php?group_id=<?php echo $_REQUEST[cmbgroup];?>&teacher_id=<?php echo $res_teacher_group[teacher_id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" /></a><?php } ?>
                  </td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : </td>
                  <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?> : </td>
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $res_size[units];?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?> : </td>
                        <td width="47%" align="left" valign="middle" class="lable1"><?php echo $rest[name];?></td>
                        <td width="14%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[start_date]!='')
						{
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
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="45%" align="left" valign="middle" class="lable1"><?php echo $hr;?> <?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[end_date]!='')
						{
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
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $edt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                        <td width="52%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate"];?>
                        </td>
                        <td width="9%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["grade_submit"] !='0000-00-00')
						  {
                          	echo $pro["grade_submit"];
						  }
							?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                        <td width="59%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
                          if($pro["progress_report_date"] !='0000-00-00')
						  {
							  echo $pro["progress_report_date"];
						  }
							  ?>
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?> : </td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php 
						  if($pro["report_print"] !='0000-00-00')
						  {
							  echo $pro["report_print"];
						  }
							  ?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?>
                        </td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_TXT4");?> : </td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["certificate_print"] !='0000-00-00')
						  {
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
                        <td width="41%" height="20" align="left" valign="middle" class="lable1"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
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
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
			<tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" bgcolor="#E8E8E8" class="lable1"><?php echo $res_course_name[name];?> </td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<input type="hidden" name="hidcourse" id="hidcourse" value="<?php echo $res_course_name[id];?>">
            
            <tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" >
              <?php
              if($_REQUEST[cmbgroup]!='')
			  {
			  ?>
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="12%" height="100" align="center" bgcolor="#E8E8E8" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                  <td width="2%" height="20" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  <td width="4%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
                </tr>
				 <?php
				function get_percent($input)
				{
					if($input > 0)
					{
						$out = 18 - (3 * $input);					
						return $out;
					}					
				}

				 $attend_calc=0;
				 $student_count = 1;

				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.course_id='$res_group[course_id]' And c.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*,c.course_id") as $r) 
				 {										 
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[cmbgroup]'");
					$attend=$course_mark[attendance];
					$totalunits=$res_size[units];
															
					if($totalunits!=0)
					{
						$attend_calc=round((($attend/$totalunits)*100)/10);
					}
					
					if($course_mark[end_of_level] > 0)
					{
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
					
					if($course_mark[end_of_level] > 0)
					{
						$final_grade = $final_grade + $benifit;
					}
					
					$res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");				
					
				?>
                <tr>
                  <td height="25" align="left" valign="middle" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
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
			  }
			  else
			  {
			  ?>
			  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="12%" height="100" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                  <td width="2%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></span></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  <td width="4%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
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
<?php }else{ ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
        
        <form name="frm" method="post" id="frm" autocomplete="off">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#CC9900;">
            <tr>
              <td width="0%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="43%">&nbsp;</td>
              <td width="32%">&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
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
                <?php
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$res_group = $dbf->strRecordID("common","*","id='$res_teacher_group[group_id]'");					
				  ?>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext" style="padding-left:50px;">
                  <?php if($_REQUEST[cmbgroup]!='') {?>
                    <a href="report_center_director_condition.php?group_id=<?php echo $_REQUEST[cmbgroup];?>&teacher_id=<?php echo $res_teacher_group[teacher_id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" /></a><?php } ?>
                  </td>             
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center" valign="middle">
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
                      <td width="72%" align="right" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult"><select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_centre_director_main.php',document.frm.submit();">
                        <option value=""><?php echo constant("SELECT_GROUP");?></option>
                        <?php
						  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'","","") as $res_group_name) {
							  ?>
                        <option value="<?php echo $res_group_name['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group_name["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group_name['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group_name['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group_name['end_date'])) ?>, <?php echo $res_group_name["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group_name["id"]);?>
</option>
                        <?php
						  }
						  ?>
                      </select></td>
                      <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?></td>
                    </tr>
                    <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                    <tr>
                      
                      <td align="right" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $res_course[name];?></td>
                      <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">: <?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext">&nbsp;</td>
                    </tr>
                  </table>
                  
                  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="pedtext"><?php echo $res_group[name];?> &nbsp;</td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
                  
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $res_size[units];?></td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?></td>
                        
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="47%" align="left" valign="middle" class="lable1"><?php echo $rest[name];?></td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?></td>
                        
                        <td width="14%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                	<td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[start_date]!='')
						{
						echo date("d/m/Y",strtotime($res_teacher_group[start_date]));
						}
						?>
						</td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT");?></td>
                  
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
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $sdt;?></td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?></td>
                        
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>                        
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="45%" align="left" valign="middle" class="lable1"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?><?php echo $hr;?></td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;">
						<?php 
						if($res_teacher_group[end_date]!='')
						{
						echo date("d/m/Y",strtotime($res_teacher_group[end_date]));
						}
						?>
						</td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?></td>
                  
                  <td>&nbsp;</td>
                  
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" align="center" valign="middle" class="lable1" style="border-bottom:dotted 1px #000000;"><?php echo $edt;?></td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?></td>
                        
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="52%" align="center" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate"];?>
                        </td>
                        <td width="28%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?></td>
                        
                        <td width="9%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["grade_submit"] !='0000-00-00')
						  {
                          	echo $pro["grade_submit"];
						  }
							?>
                        </td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?></td>
                  
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="59%" align="center" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
                          if($pro["progress_report_date"] !='0000-00-00'){
							  echo $pro["progress_report_date"];
						  }
						?>
                        </td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?></td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="lable1"></td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php 
						  if($pro["report_print"] !='0000-00-00')
						  {
							  echo $pro["report_print"];
						  }
							  ?>
                        </td>
                        <td width="28%" align="center"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?></td>
                      </tr>
                  </table></td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?></td>
                  
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        
                        <td width="59%" align="right" valign="middle" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?>&nbsp;</td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_BY");?></td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" height="20" align="center" valign="middle" class="lable1"></td>
                        <td width="42%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php
						  if($pro["certificate_print"] !='0000-00-00')
						  {
                          	echo $pro["certificate_print"];
						  }
						  ?>
                        </td>
                        <td width="28%" align="center"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?></td>
                      </tr>
                  </table></td>
                  <td height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_TXT4");?></td>
                  
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        
                        <td width="59%" align="right" valign="middle"style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate_print_by"];?>&nbsp;
                        </td>
                        <td width="41%" height="20" align="left" valign="middle" class="lable1">: <?php echo constant("TEACHER_REPORT_TEACHER_BY");?></td>
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
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
			<tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" bgcolor="#E8E8E8" class="lable1"><?php echo $res_course_name[name];?> </td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<input type="hidden" name="hidcourse" id="hidcourse" value="<?php echo $res_course_name[id];?>">
            
            <tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" >
              <?php
              if($_REQUEST[cmbgroup]!='')
			  {
			  ?>
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="4%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
                  
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?>></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="4%" height="20" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="10%" height="100" align="right" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                </tr>
				 <?php
				function get_percent($input)
				{
					if($input > 0)
					{
						$out = 18 - (3 * $input);					
						return $out;
					}					
				}

				 $attend_calc=0;
				 $student_count = 1;
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.course_id='$res_group[course_id]' And c.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*,c.course_id") as $r){
					 										 
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[cmbgroup]'");
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
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php if($final_grade>0) { echo $final_grade; }?></td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php echo $res_grade[name];?></td>                  
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
                  
                  
                  <td align="right" valign="middle" class="smalltext"><?php if($r[student_id] > 0) { echo $r[student_id]; }?>&nbsp;</td>
                  <td align="left" valign="middle"><?php echo $res_country[value];?></td>
                  <td height="25" align="right" valign="middle" class="smalltext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?>&nbsp;</td>
                </tr>
				 <?php
				 $student_count++; 
				 } 
				 ?>
                
              </table>
              <?php
			  }
			  else
			  {
			  ?>
			  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="4%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="20" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                  <td width="4%" height="20" align="center" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                  <td width="10%" height="100" align="right" bgcolor="#E8E8E8" class="pedtext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                </tr>
                <tr>
                  <td align="center" valign="middle" bgcolor="#E8E8E8"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                  <td align="left" valign="middle" bgcolor="#E8E8E8"><?php echo constant("CD_REPORT_CENTER_DIRECTOR_PRINT_0");?></td>
                  
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
                  <td align="left" valign="middle" class="smalltext">&nbsp;</td>
                  <td align="left" valign="middle" class="smalltext">&nbsp;</td>
                  <td height="25" align="left" valign="middle" class="smalltext">&nbsp;</td>
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
<?php } ?>
</body>
</html>