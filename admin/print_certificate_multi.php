<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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

$group_id = $_REQUEST[group_id];

//Update in Enrollment Table
//$dbf->updateTable("student_enroll","certificate_collect='1'","student_id='$student_id' And course_id='$course_id'");
?>

<style>	
.cer1
{
font-family:Arial, Helvetica, sans-serif;
font-size:10px;
color:#333333;
}

.cer2
{
font-family:Arial, Helvetica, sans-serif;
font-size:9px;
font-weight:normal;
color:#333333;
}

.cer3
{
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:normal;
color:#333333;
}

.cer4
{
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
color:#000000;
}

.cer5
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:normal;
color:#000000;
}

.cer6{font-family:minion; font-weight:bold; font-size:15px;}
.cer7_bold{font-family:"Century Gothic"; font-weight:bold; font-size:14px;}
.cer7_normal{font-family:"Century Gothic"; font-weight:normal; font-size:14px;}
.cer8_com{font-family:Cambria; font-weight:normal; font-size:14px;}
.cer9_arial{font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:14px;}
.cer9_arial_bold{font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px;}

.cer_my_head{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#000000;
font-weight:normal;
}
.cer_my_head_bold{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#000000;
font-weight:bold;
}
.cer_my_cer_head_bold{
font-family:"Monotype Corsiva";
font-size:16px;
color:#000000;
font-weight:bold;
font-style:italic;
}
</style>
<style>
@media print
{
table {page-break-after:always}
}
</style>
<?php			  
foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And m.id='$group_id'") as $val_my_group) {
	$student_id = $val_my_group["student_id"];
	$course_id = $val_my_group["course_id"];
	
	$res_g = $dbf->strRecordID("student_group","*","id='$group_id'");
	
	$res = $dbf->strRecordID("student","*","id='$student_id'");
	$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
	
	$course_name = $dbf->strRecordID("course","*","id='$course_id'");
	$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='student_id' And course_id='$course_id'");
	$res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
	$total_units = $res_size[units];
	
	$or_unit = $res_size[units];
	$per_unit = 45; //minute
	$tot_unit = $or_unit * $per_unit;
	$hr = $tot_unit / 60;
?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="943"  height="30" align="right" valign="middle"></td></td>
    <td width="57" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="920" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="903" align="left" valign="top"><table width="870" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td height="50">&nbsp;</td>
            </tr>
          <tr>
            <td height="10" align="left" valign="top"></td>
            </tr>
          <tr>
            <td class="test">&nbsp;</td>
            </tr>
          <tr>
            <td height="40" align="center" valign="middle"><p align="center" dir="rtl" class="cer_my_head_bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شهادة اجتياز دورة في اللغة الانجليزية</p></td>
            </tr>
          <tr>
            <td align="center" valign="middle" class="cer_my_cer_head_bold">A CERTIFICATE OF ACHIEVEMENT IN ENGLISH LANGUAGE</td>
            </tr>
          <tr>
            <td height="20">&nbsp;</td>
            </tr>
          <tr>
            <td align="left" valign="middle" ><table width="870" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="447" align="left" valign="top"><table width="92%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
                  </tr>
                  <tr>
                    <th height="26" align="left" valign="middle" scope="col" class="cer_my_head">This is to certify that</th>
                  </tr>
                  <?php
				  if($res[gender]=='female'){
					  $gender = 'Ms.';
				  }else{
					  $gender = 'Mr.';
				  }
				  ?>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?></span>&nbsp;<span class="cer_my_head_bold"><?php echo $res[first_name];?></span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $res[student_id];?></span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course: </span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">Level: <span class="cer_my_head_bold"><?php echo $course_name[name];?></span> with a total number of <span class="cer_my_head_bold"><?php echo $hr;?></span> hours </span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo $res_g[start_date];?></span> &nbsp;&nbsp;&nbsp;&nbsp;<span class="cer_my_head">to: </span><span class="cer_my_head_bold"><?php echo $res_g[end_date];?></span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
                  </tr>
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
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer1" scope="col"> <span class="cer_my_head">From:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $sdt;?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cer_my_head">to: </span><span class="cer_my_head_bold"><?php echo $edt;?></span></th>
                  </tr>
                  <?php
				  $res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
				  $res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
				  ?>
                  <tr>
                    <th height="28" align="left" valign="middle" scope="col"><span class="cer_my_head">and has received a final grade of </span><span class="cer_my_head_bold"><?php echo $res_grade["name"];?>, <?php echo $res_per["final_percent"];?> %</span></th>
                  </tr>
                  <tr>
                    <th height="28" align="left" valign="middle" class="cer_my_head" scope="col">Berlitz issued this certificate in recognition of the above</th>
                  </tr>
                  </table><p align="left" class="cer1" dir="rtl">&nbsp;</p></td>
                <td width="380" align="right" valign="top" ><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <th height="20" align="right" valign="middle" scope="col">&nbsp;</th>
                    </tr>
                  <tr>
                    <th height="26" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">يشهد معهد دار الخبرة لتعليم اللغة  الانجليزية بالاحساء</span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $Arabic->en2ar($res[first_name]);?></span>&nbsp; </th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"><?php echo $Arabic->en2ar($resc[value]);?></span>&nbsp;<span class="cer_my_head_bold"><span dir="rtl">الجنسية: </span> </span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold"></span>&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<?php if($res[student_id]>0) { echo $dbf->enNo2ar($res[student_id],''); } ?></span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $Arabic->en2ar($course_name[name]);?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($res_g[start_date],'-');?>   إلى: <?php echo $dbf->enNo2ar($res_g[end_date],'-');?></span></th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col">&nbsp;</th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span>                    
                    </th>
                    </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">وحصل على تقدير   <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %   , ونسبة <?php echo $Arabic->en2ar($res_grade["name"]);?> </span></th>
                  </tr>
                  <tr>
                    <th height="28" align="right" valign="middle" class="cer_my_head_bold" scope="col"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></th>
                  </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0" style="display:none;">
          <tr>
            <td width="349" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
              <p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br />
                <strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p></td>
            <td width="94">&nbsp;</td>
            <td width="87" align="center" valign="middle"><p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br />
              <strong><span dir="ltr">Stamp</span></strong></p></td>
            <td width="115">&nbsp;</td>
            <td width="255" align="center" valign="middle"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
              <strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
              <strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php } ?>
<script type="text/javascript">
window.print();
</script>