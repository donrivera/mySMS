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
font-size:16px;
color:#000000;
font-weight:normal;
}
.cer_my_head_bold{
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
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
<!--
@media 
print
{
table {page-break-after:always}
}
-->

</style>
<?php
$sl = 0;
$height = 0;
$show_passing_grade=$dbf->getDataFromTable("grade","frm","name='Fair'");
$sql=$dbf->genericQuery("	SELECT m.*,d.* 
							FROM student_group m 
							INNER JOIN student_group_dtls d ON m.id=d.parent_id
							INNER JOIN teacher_progress_certificate t ON t.student_id=d.student_id AND t.group_id = m.id
							WHERE m.id='$group_id' AND t.final_percent >=$show_passing_grade");			  
#foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And m.id='$group_id'") as $val_my_group) 
foreach($sql as $val_my_group) 
{
	$student_id = $val_my_group["student_id"];
	$course_id = $val_my_group["course_id"];
	$res_g = $dbf->strRecordID("student_group","*","id='$group_id'");
	
	$res = $dbf->strRecordID("student","*","id='$student_id'");
	$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
	
	$course_name = $dbf->strRecordID("course","*","id='$course_id'");
	$exp_course_name=explode("-",$course_name[name]);
	$eng_course_name=$exp_course_name[0];
	$arb_course_name=$exp_course_name[1];
	$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='student_id' And course_id='$course_id'");
	$res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
	$total_units = $res_size[units];
	
	$or_unit = $res_size[units];
	$per_unit = 45; //minute
	$tot_unit = $or_unit * $per_unit;
	$hr = $tot_unit / 60;
	$bal_amt = $dbf->BalanceAmount($student_id,$course_id);
	if($bal_amt <= 0):
?>
<table width="100%" border="0" style="height:90px;">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<p  dir="rtl" class="cer_my_head_bold">شهادة اجتياز دورة في اللغة الانجليزية</p>
			<p class="cer_my_cer_head_bold">A CERTIFICATE OF ACHIEVEMENT IN ENGLISH LANGUAGE</p>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="50">
			<table>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th align="left" class="cer_my_head">This is to certify that</th>
				</tr>
				<?php $gender=($res[gender]=='female'?'Ms.':'Mr.');?>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head"><?php echo $gender;?></span>&nbsp;<span class="cer_my_head_bold"><?php echo $res['first_name']."&nbsp;".$res['father_name']."&nbsp;".$res['family_name'];?></span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head">Nationality:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $resc[value];?></span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head">ID Number:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $res[student_id];?></span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head"> passed the following English language course: </span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head">Level: <span class="cer_my_head_bold"><?php echo $eng_course_name;?></span> with a total number of <span class="cer_my_head_bold"><?php echo $hr;?></span> hours </span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head">From: </span><span class="cer_my_head_bold"><?php echo date("d-m-Y",strtotime($res_g["start_date"]));?></span> &nbsp;&nbsp;&nbsp;&nbsp;<span class="cer_my_head">to: </span><span class="cer_my_head_bold"><?php echo date("d-m-Y",strtotime($res_g["start_date"]));?></span></th>
				</tr>
				<tr>
					<th align="left" class="cer1" scope="col"><span class="cer_my_head">That correspond to the Hijra dates</span></th>
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
					<th align="left" class="cer1" scope="col"> <span class="cer_my_head">From:</span>&nbsp;<span class="cer_my_head_bold"><?php echo $sdt;?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cer_my_head">to: </span><span class="cer_my_head_bold"><?php echo $edt;?></span></th>
				</tr>
				<?php
					$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$course_id' And student_id='$student_id'");
					$res_grade = $dbf->strRecordID("grade","*","id='$res_per[grade_id]'");
				?>
				<tr>
					<th align="left" scope="col"><span class="cer_my_head">and has received a final grade of </span><span class="cer_my_head_bold"><?php echo $res_grade["name"];?>, <?php echo $res_per["final_percent"];?> %</span></th>
				</tr>
				<tr>
					<th align="left" class="cer_my_head" scope="col">Berlitz issued this certificate in recognition of the above</th>
				</tr>
			</table>
		</td>
		<td valign="middle" align="right" height="50">
			<table>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">يشهد معهد دار الخبرة لتعليم اللغة  الانجليزية بالاحساء</span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">بأن المتدرب: <?php echo $res['first_name1']."&nbsp;".$res['father_name1']."&nbsp;".$res['grandfather_name1']."&nbsp;".$res['family_name1'];#echo $Arabic->en2ar($res["first_name"]);?></span>&nbsp; </th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col">&nbsp;<span class="cer_my_head_bold"><span dir="rtl">الجنسية: <?php echo $Arabic->en2ar($resc[value]);?></span> </span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold"></span>&nbsp;<span class="cer_my_head_bold" dir="rtl">رقم السجل المدني / الإقامة:<?php if($res[student_id]>0) { echo $dbf->enNo2ar($res[student_id],''); } ?></span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">قد اجتاز دورة في اللغة  الانجليزية لغير الناطقين بها:</span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في المستوى <?php echo $arb_course_name;?>  , وأكمل   <?php echo $dbf->enNo2ar($hr,'');?>   ساعة دراسية</span></th>
				</tr>
				<tr>
					<?php $ar_start_date=date("d-m-Y",strtotime($res_g["start_date"]));$ar_end_date=date("d-m-Y",strtotime($res_g["end_date"]));?>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">في الفترة من: <?php echo $dbf->enNo2ar($ar_start_date,'-');?>   إلى: <?php echo $dbf->enNo2ar($ar_end_date,'-');?></span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col">&nbsp;</th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">الموافق من: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($sdt,'-');} ?>إلى: <?php if($res_g[start_date]!='0000-00-00') { echo $dbf->enNo2ar($edt,'-');} ?></span></th>
				</tr>
				<tr>
					<th align="right" class="cer2" scope="col"><span class="cer_my_head_bold" dir="rtl">وحصل على تقدير  <?php echo $res_grade["arabic"];?> , ونسبة  <?php echo $dbf->enNo2ar($res_per["final_percent"],'');?> %</span></th>
				</tr>
				<tr>
					<th align="right" class="cer_my_head_bold" scope="col"><span dir="rtl">وبناء عليه مُنح هذه  الشهادة.</span></th>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="position:float; top:10%; height:10em; margin-top:-10em ">
			<table><!--style="display:none;"-->
				<tr>
					<td width="349" align="center" valign="middle">
						<p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>   تصادق إدارة التربية والتعليم  علي صحة ختم وتوقيع مدير المعهد</strong></p>
						<p align="center" dir="rtl"><strong>مدير عام التربية والتعليم بمحافظة الإحساء</strong><br /><strong>أ/أحمد بن محمد بالغنيم</strong><strong> </strong></p>
					</td>
					<td width="94">&nbsp;</td>
					<td width="87" align="center" valign="middle">
						<p align="center" dir="rtl"><strong>ختم المعهد</strong><strong><span dir="ltr"> </span></strong><br /><strong><span dir="ltr">Stamp</span></strong></p>
					</td>
					<td width="115">&nbsp;</td>
					<td width="255" valign="middle" align="right"><p dir="rtl"><span dir="rtl"> </span><strong><span dir="rtl"> </span>            المدير  العام</strong><br />
						<strong><span dir="ltr">Managing  Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong></p>
						<strong><span dir="rtl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;م /مشارى بن عبد اللطيف الحليبى</span></strong>
					</td>
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>

<?php endif;} ?>
<script type="text/javascript">
window.print();
</script>