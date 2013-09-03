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

$centre_id = $_SESSION["centre_id"];

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[group_id]'");

$teacher_id=$pro["teacher_id"];

$print_date = date('Y-m-d');

//update all students in teacher_certificate table means already print the certificate by centre director
$string="print_status='1',print_date='$print_date'";
$dbf->updateTable("teacher_progress_certificate",$string,"group_id='$_REQUEST[group_id]'");
?>	
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="0%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="49%">&nbsp;</td>
              <td width="28%">&nbsp;</td>
              <td width="1%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="center" valign="middle" class="heading1"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?></td>
              <?php
			  $res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
			  ?>
              <td align="center" valign="middle" ><?php echo $res_logo[name];?></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="15%" align="left" valign="middle" class="nametext">&nbsp;</td>
                  <td width="26%">&nbsp;</td>
                  <td width="0%">&nbsp;</td>
                  <td width="29%">&nbsp;</td>
                  <td width="30%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">
                  <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                    </tr>
                    <tr>
                      <td width="28%" height="25" align="left" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("RE_MENU_GROUPS");?>:</td>
                      <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                      <td width="72%" align="left" valign="middle" bgcolor="#FFE2D5" class="pedtext"><?php echo $res_g['group_name'];?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></td>
                    </tr>
                    
                    <tr>
                      <td height="25" align="left" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?>:</td>
                      <td align="left" valign="middle" bgcolor="#FFE2D5" class="pedtext"><?php echo $res_course[name];?></td>
                    </tr>
                    <tr>
                      <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                    </tr>
                  </table></td>
                  <?php
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$res_group = $dbf->strRecordID("common","*","id='$res_teacher_group[group_id]'");
					$rest = $dbf->strRecordID("teacher","*","id='$res_teacher_group[teacher_id]'");
					?>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?>: </td>
                  <td align="left" valign="middle" class="pedtext"><?php echo $res_group[name];?></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT5");?> : </td>
                        <td width="59%" align="center" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $res_size[units];?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TEACHER");?> : </td>
                        <td width="47%" align="left" valign="middle" class="content"><?php echo $rest[name];?></td>
                        <td width="14%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="content" style="border-bottom:dotted 1px #000000;">
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
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPSTDT");?>: </td>
                        <td width="59%" align="center" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $sdt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT6");?>  : </td>
                        <?php
						$or_unit = $res_size[units];
						$per_unit = 45; //minute
						$tot_unit = $or_unit * $per_unit;
						$hr = $tot_unit / 60;
						?>
                        <td width="45%" align="left" valign="middle" class="content"><?php echo $hr;?> <?php echo constant("CD_REPORT_CENTER_DIRECTOR_HOUR");?></td>
                        <td width="16%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT1");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="8%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="74%" align="center" valign="middle" class="content" style="border-bottom:dotted 1px #000000;">
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
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?>: </td>
                        <td width="59%" align="center" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $edt;?></td>
                      </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                        <td width="28%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_MENU_CERTIFICATE");?> : </td>
                        <td width="52%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["certificate"];?></td>
                        <td width="9%" align="center" valign="middle" class="nametext" >&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT2");?> : </td>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="44%" height="20" align="center" valign="middle">&nbsp;</td>
                        <td width="28%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["grade_submit"];?></td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TE_MENU_PR");?>  : </td>
                        <td width="59%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["progress_report_date"];?></td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?> : </td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="46%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?> : </td>
                        <td width="26%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print"];?></td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?></td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_TXT4");?> : </td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="47%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_CENTERDI_HEADTEXT");?> : </td>
                        <td width="25%" align="left" valign="middle" class="content" style="border-bottom:dotted 1px #000000;"><?php echo $pro["certificate_print"];?></td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td>&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="41%" height="20" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                        <td width="59%" align="left" valign="middle" class="content"style="border-bottom:dotted 1px #000000;"><?php echo $pro["certificate_print_by"];?></td>
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
              <td height="20" align="left" valign="middle" bgcolor="#000066" class="nametext">&nbsp;</td>
              <td align="center" valign="middle" bgcolor="#000066" class="logouttext">Certificate Grades </td>
              <td align="left" valign="middle" bgcolor="#000066">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			<?php
			$row = 1;
			$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
			$res_course_name = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
            ?>
			<tr>
              <td>&nbsp;</td>
              <td height="20" align="left" valign="middle" bgcolor="#E8E8E8" class="nametext">&nbsp;</td>
              <td align="center" valign="middle" bgcolor="#E8E8E8" class="heading"><?php echo $res_course_name[name];?> </td>
              <td align="left" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>            
            <tr>
              <td>&nbsp;</td>
              <td height="20" colspan="3" align="center" valign="middle" >
              
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="12%" height="100" align="center" bgcolor="#E8E8E8" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></span></td>
                  <td width="2%" height="20" align="left" bgcolor="#E8E8E8"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></span></td>
                  <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="nametext" style="border-right:solid 1px; border-color:#000;border-bottom:solid 1px; border-color:#000;"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></span></td>
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
				 foreach($dbf->fetchOrder('student s,student_group_dtls c',"s.id=c.student_id AND c.course_id='$res_group[course_id]' And c.parent_id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id") as $r) 
				 {										 
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");					
					$course_mark = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$r[id]' AND teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
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
					
					if($course_mark[end_of_level] > 0){
						$final_grade = $final_grade + $benifit;
					}
					
					$res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");					
				?>
                <tr>
                  <td height="25" align="left" valign="middle" class="smalltext"><?php echo $r[first_name];?></td>
                  <td align="left" valign="middle" class="content"><?php echo $res_country["value"];?></td>
                  <td align="left" valign="middle" class="content"><?php echo $r["student_id"];?></td>
				  
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="content">
                  <?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content"><?php echo $nos;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content"><?php echo $benifit;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($res_size[units]) { echo $res_size[units]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="content">
                  <?php if($attend_calc>0) { echo round($attend_calc); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="content">
                  <?php if($final_grade>0) { echo $final_grade; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="content"><?php echo $res_grade[name];?></td>
                </tr>
				 <?php
				 $student_count++; 
				 } 
				 ?>
                
              </table>
              
              </td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>			
            <tr>
              <td>&nbsp;</td>
              <td height="20" align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
			</table>
</body>
</html>
<script type="text/javascript">
window.print();
</script>