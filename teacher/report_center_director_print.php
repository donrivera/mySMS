<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$teacher_id = $_SESSION[uid];
$rest = $dbf->strRecordID("teacher","*","id='$teacher_id'");

$pro = $dbf->strRecordID("teacher_progress","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
?>
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<style>
 .heading1{
 font-family:Arial, Helvetica, sans-serif;
 font-size:16px;
 font-weight:bold;
 color:#000000;
 text-decoration:underline;
 }
 .smalltext{
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 font-weight:bold;
 color:#000000;
 padding-left:10px;
 }
</style>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
              <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>:</td>
               <?php
              $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
              $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
              ?>
              <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="leftmenu">
                <?php echo $res_g["group_name"]; ?> <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?>
              </td>
            </tr>
           
            <tr>
              <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:</td>
              <td align="left" valign="middle" bgcolor="#FFCB7D" class="leftmenu"><?php echo $res_course[name];?></td>
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
                <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUPENDDT");?>: </td>
                <td width="59%" align="center" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $edt;?></td>
              </tr>
          </table></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11%" align="left" valign="middle" class="nametext">&nbsp;</td>
                <td width="28%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE");?> : </td>
                <td width="52%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
                <td width="42%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
                <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_PROGRESSREPORT");?>  : </td>
                <td width="59%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
          <td height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT3");?> : </td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30%" height="20" align="center" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : </td>
                <td width="42%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
                <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                <td width="59%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;"><?php echo $pro["report_print_by"];?>
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
                <td width="42%" align="left" valign="middle" class="nametext" style="border-bottom:dotted 1px #000000;">
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
                <td width="41%" height="20" align="left" valign="middle" class="nametext"><?php echo constant("TEACHER_REPORT_TEACHER_BY");?> : </td>
                <td width="59%" align="left" valign="middle" class="nametext"style="border-bottom:dotted 1px #000000;">
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
    ?>
    <tr>
      <td>&nbsp;</td>
      <td height="20" colspan="3" align="center" valign="middle" bgcolor="#E8E8E8" class="nametext"><?php echo $res_course_name[name];?> </td>
      <td align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td height="20" colspan="3" align="center" valign="middle" >
      
      <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px; border-collapse:collapse;">
        <tr>
          <td width="12%" height="100" align="center" bgcolor="#E8E8E8" class="nametext"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNM");?></span></td>
          <td width="2%" height="20" align="left" bgcolor="#E8E8E8" class="nametext"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?></span></td>
          <td width="7%" height="20" align="center" bgcolor="#E8E8E8" class="nametext"><span class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDIDNO");?></span></td>
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
            
            if($course_mark[end_of_level] > 0)
            {
                $final_grade = $final_grade + $benifit;
            }
            
            $res_grade = $dbf->strRecordID("grade","*","'$final_grade' BETWEEN frm and tto");				
            
        ?>
        <tr>
          <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[first_name];?></td>
          <td align="left" valign="middle" bgcolor="#E8E8E8" class="mycon"><?php echo $res_country[value];?></td>
          <td align="left" valign="middle" bgcolor="#E8E8E8" class="smalltext"><?php echo $r[student_id];?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?></td>
          <td align="center" valign="middle" bgcolor="#E8E8E8" class="mycon"><?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php echo $nos;?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php echo $benifit;?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($res_size[units]) { echo $res_size[units]; }?></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF" class="mycon"><?php if($attend_calc>0) { echo round($attend_calc); }?></td>
          <td align="center" valign="middle" bgcolor="#E8E8E8" class="mycon"><?php if($final_grade>0) { echo $final_grade; }?></td>
          <td align="center" valign="middle" bgcolor="#E8E8E8" class="mycon"><?php echo $res_grade[name];?></td>
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
      <td align="center" valign="middle">&nbsp;</td>
      <td align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="middle">&nbsp;</td>
      </tr>
  </table>
</body>
<script type="text/javascript">
window.print();
</script>