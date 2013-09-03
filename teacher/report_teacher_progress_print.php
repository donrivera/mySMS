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

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[group_id]'");
?>

<link href="../css/stylesheet2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="6%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
            <td width="77%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_TEACHER_HEADTEXT");?></td>
            <td align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%" align="left" valign="middle" class="nametext">&nbsp;</td>
                  <td width="21%">&nbsp;</td>
                  <td width="1%">&nbsp;</td>
                  <td width="31%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">
                  <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                    </tr>
                    <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                    <tr>
                      <td width="28%" height="25" align="left" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>:</td>
                      <td width="72%" align="left" valign="middle" bgcolor="#FFE2D5" class="heading">
                        <?php echo $res_g[group_name];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?>
                      </td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:</td>
                      
                      <td align="left" valign="middle" bgcolor="#FFE2D5" class="heading"><?php echo $res_course[name];?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
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
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $res_size[units];?>
						
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
                        <td width="74%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php if($res_g[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($res_g[start_date]));}?></td>
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
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="29%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <td width="44%" align="left" valign="middle" class="nametext"></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php if($res_g[end_date]!='0000-00-00') {echo date("d/m/Y",strtotime($res_g[end_date]));}?></td>
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
                        <td width="23%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                        <td width="50%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate"];?>
                        </td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["grade_submit"];?>
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["progress_report_date"];?>
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
                        <td width="52%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["report_print"];?>
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?>
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
                        <td width="52%" align="left" valign="middle" style="border-bottom:dotted 1px #000000;">
                          <?php echo $pro["certificate_print"];?>
                        </td>
                        <td width="18%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#6699CC" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_TXT7");?></td>
            <td align="left" valign="middle">&nbsp;</td>
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
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                  <tr>
                    <td width="13%" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                    <td width="10%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                    <td width="6%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                    <td width="9%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                    <td width="10%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                  </tr>
                  <?php
                    $student_count = 1;
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r) {
					?>
                  <?php
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");	
					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
									
					?>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?></td>
                    <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course_mark['fluency'];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course_mark['pronunciation'];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course_mark['grammer'];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course_mark['vocabulary'];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course_mark['listening'];?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8"><?php echo $course_mark['end_of_level'];?></td>
                    <?php
						$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='X'");
						$shift1 = $count_att_1["COUNT(id)"];
						
						$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='X'");
						$shift2 = $count_att_2["COUNT(id)"];
						
						$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='X'");
						$shift3 = $count_att_3["COUNT(id)"];
						
						//count attendance E
						$count_att_E1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='E'");
						$shift1E = $count_att_E1["COUNT(id)"];
						
						$count_att_E2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='E'");
						$shift2E = $count_att_E2["COUNT(id)"];
						
						$count_att_E3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='E'");
						$shift3E = $count_att_E3["COUNT(id)"];
						//count attendance B
						$count_att_B1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='B'");
						$shift1B = $count_att_B1["COUNT(id)"];
						
						$count_att_B2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='B'");
						$shift2B = $count_att_B2["COUNT(id)"];
						
						$count_att_B3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='B'");
						$shift3B = $count_att_B3["COUNT(id)"];
						//count attendance S
						$count_att_S1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='S'");
						$shift1S = $count_att_S1["COUNT(id)"];
						
						$count_att_S2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='S'");
						$shift2S = $count_att_S2["COUNT(id)"];
						
						$count_att_S3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='S'");
						$shift3S = $count_att_S3["COUNT(id)"];
						//count attendance V
						$count_att_V1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='V'");
						$shift1V = $count_att_V1["COUNT(id)"];
						
						$count_att_V2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='V'");
						$shift2V = $count_att_V2["COUNT(id)"];
						
						$count_att_V3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='V'");
						$shift3V = $count_att_V3["COUNT(id)"];
						
						//Sum of E,B,S,V 
						$count_all = $shift1E+$shift2E+$shift3E+$shift1B+$shift2B+$shift3B+$shift1S+$shift2S+$shift3S+$shift1V+$shift2V+$shift3V;
						
						//Sum of shift 1 and shift 2
						$count_shift = $shift1+$shift2+$shift3+$count_all;
						?>
                    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $count_shift;?></td>
                    <?php
					//$group_unit = $res_size[effect_units];
					$group_unit = $res_size[units];
					$attend_perc=0;
					if($count_shift!='0')
					{
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					if($attend_perc<61)
					{
						$rfiles = "round-red.png";
					}
					else if($attend_perc >= 61 && $attend_perc <= 84)
					{
						$rfiles = "round-yellow.png";
					}
					else if($attend_perc >= 85)
					{
						$rfiles = "round-green.png";
					}
					?>
                    <td align="center" valign="middle"><?php echo $res_size[units];?></td>
                    <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"/></td>
                        <td width="53%" align="center" valign="middle"><?php echo $attend_perc;?></td>
                      </tr>
                    </table></td>
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
                    <td width="12%" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                    <td width="9%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                    <td width="9%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PARTICI");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_HW");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                    <td width="7%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                    <td width="7%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                    <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
					<td width="9%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                    <td width="7%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                    <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
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
                
                </tr>
              <tr>
                <td width="35%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="33%">&nbsp;</td>
              </tr>
            </table>
                        
            </td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          
           <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="center" valign="middle" bgcolor="#000066" class="tableborder2"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?></td>
            <td align="left" valign="middle">&nbsp;</td>
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
                  
                  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="13%" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></td>
                      <td width="10%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></td>
                      <td width="6%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></td>
                      <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                      <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                      <td width="6%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                      <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                      <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_LISTCOMPREH");?></td>
                      <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                      <td width="8%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                      <td width="9%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                      <td width="10%" height="20" align="center" class="rotate_text"><?php echo constant("TEACHER_REPORT_TEACHER_TXT9");?></td>
                    </tr>
                    <?php
                    $student_count = 1;
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$teacher_id' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r) {
					?>
                    <?php
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");	
					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
									
					?>
                    <tr>
                      <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?></td>
                      <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $res_country[value];?></td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?>
                      
                      </td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $course_mark['fluency'];?>                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $course_mark['pronunciation'];?>                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $course_mark['grammer'];?>                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $course_mark['vocabulary'];?>                        
                      </td>
                      
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $course_mark['listening'];?>                        
                      </td>
                      <td align="center" valign="middle" bgcolor="#E8E8E8">
                      <?php echo $course_mark['end_of_level'];?></td>
						<?php
						$count_att_1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='X'");
						$shift1 = $count_att_1["COUNT(id)"];
						
						$count_att_2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='X'");
						$shift2 = $count_att_2["COUNT(id)"];
						
						$count_att_3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='X'");
						$shift3 = $count_att_3["COUNT(id)"];
						
						//count attendance E
						$count_att_E1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='E'");
						$shift1E = $count_att_E1["COUNT(id)"];
						
						$count_att_E2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='E'");
						$shift2E = $count_att_E2["COUNT(id)"];
						
						$count_att_E3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='E'");
						$shift3E = $count_att_E3["COUNT(id)"];
						//count attendance B
						$count_att_B1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='B'");
						$shift1B = $count_att_B1["COUNT(id)"];
						
						$count_att_B2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='B'");
						$shift2B = $count_att_B2["COUNT(id)"];
						
						$count_att_B3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='B'");
						$shift3B = $count_att_B3["COUNT(id)"];
						//count attendance S
						$count_att_S1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='S'");
						$shift1S = $count_att_S1["COUNT(id)"];
						
						$count_att_S2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='S'");
						$shift2S = $count_att_S2["COUNT(id)"];
						
						$count_att_S3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='S'");
						$shift3S = $count_att_S3["COUNT(id)"];
						//count attendance V
						$count_att_V1 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift1='V'");
						$shift1V = $count_att_V1["COUNT(id)"];
						
						$count_att_V2 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift2='V'");
						$shift2V = $count_att_V2["COUNT(id)"];
						
						$count_att_V3 = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$r[id]' AND group_id='$_REQUEST[group_id]' AND teacher_id='$teacher_id' AND course_id='$r[course_id]' AND shift3='V'");
						$shift3V = $count_att_V3["COUNT(id)"];
						
						//Sum of E,B,S,V 
						$count_all = $shift1E+$shift2E+$shift3E+$shift1B+$shift2B+$shift3B+$shift1S+$shift2S+$shift3S+$shift1V+$shift2V+$shift3V;
						
						//Sum of shift 1 and shift 2
						$count_shift = $shift1+$shift2+$shift3+$count_all;
						?>
                      <td align="center" valign="middle" bgcolor="#FFFFFF">
                      <?php echo $count_shift;?></td>
                      
                     <?php
					$group_unit = $res_size[units];
					
					$attend_perc=0;
					if($count_shift!='0')
					{
						$attend_perc=round(($count_shift/$group_unit)*100);
					}
					if($attend_perc<61)
					{
						$rfiles = "round-red.png";
					}
					else if($attend_perc >= 61 && $attend_perc <= 84)
					{
						$rfiles = "round-yellow.png";
					}
					else if($attend_perc >= 85)
					{
						$rfiles = "round-green.png";
					}
					?>
                      <td align="center" valign="middle"><?php echo $res_size[effect_units];?></td>
                      <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="47%" align="right" valign="middle"><img src="../images/<?php echo $rfiles;?>"/></td>
                          <td width="53%" align="center" valign="middle"><?php echo $attend_perc;?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php
					$student_count++;				
                    }
					?>
                    
                  </table>
                  
                  </td>
                </tr>
                <tr>
                  <td width="35%">&nbsp;</td>
                  <td width="32%">&nbsp;</td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
              </td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <?php if($_REQUEST[group_id] !='') { ?>
          <tr>
            <td>&nbsp;</td>
            <td height="20" colspan="2" align="left" valign="middle">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="nametext"><?php echo constant("ADMIN_CHALLAN_COND_NARRATION");?> :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3"><?php echo $pro[narration];?></td>
                </tr>
            </table></td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <?php } ?>
        </table>
</body>
</html>
<script type="text/javascript">
window.print();
</script>