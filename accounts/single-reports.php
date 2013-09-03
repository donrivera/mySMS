<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
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

$student_id = $_REQUEST['student_id'];

if($_REQUEST['action']=='edit'){
	
	$pwd = base64_encode(base64_encode($_POST[oldpassword]));	
	$newpwd = base64_encode(base64_encode($_POST[newpassword]));
	
	$num=$dbf->countRows('user',"password='$pwd' AND uid='$student_id'");
	if($num>0){
		
		$string="password='$newpwd'";
		$dbf->updateTable("user",$string,"id='$student_id'");
		
		header("Location:single-password.php?msg=added");
		exit;
	}else{
		
		header("Location:single-password.php?msg=invalid");
		exit;
	}
}
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
<script language="javascript" type="text/javascript">
function check(){
	if(document.getElementById('oldpassword').value == ''){
		document.getElementById('lbl1').innerHTML = 'Enter old password';
		document.getElementById('oldpassword').focus();
		return false;
	}
	if(document.getElementById('newpassword').value == ''){
		document.getElementById('lbl2').innerHTML = 'Enter new password';
		document.getElementById('newpassword').focus();
		return false;
	}
	if(document.getElementById('confirmpassword').value == ''){
		document.getElementById('lbl3').innerHTML = 'Enter current password';
		document.getElementById('confirmpassword').focus();
		return false;
	}
	if(document.getElementById('newpassword').value != document.getElementById('confirmpassword').value){
		document.getElementById('lbl3').innerHTML = 'Password not match';
		document.getElementById('newpassword').focus();
		return false;
	}
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
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang] == "EN") { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%" align="center" valign="middle" class="shop1"><a href="single-reports-print.php?student_id=<?php echo $_REQUEST['student_id'];?>" target="_blank">Print All</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td colspan="2" align="left" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="35%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> : &nbsp;</td>
                    <td width="65%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <?php if($student["student_id"] > 0) { ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("SA_MENU_ARF_REPORTS");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"><table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                    <td width="13%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTDATE");?></td>
                    <td width="20%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
                    <td width="17%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?></td>
                    <td width="17%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></td>
                    <td width="18%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?></td>
                    <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?></td>
                    </tr>
                  <?php
				  $k = 1;
				  foreach($dbf->fetchOrder('arf',"student_id='$student_id'","dated desc") as $arf) {
					  $res_student = $dbf->strRecordID("student","*","id='$arf[student_id]'");
				  ?>
                  <tr>
                    <td height="22" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $arf[dated];?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $arf[action_owner];?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $arf[report_by];?></td>
                    <td align="center" valign="middle" class="mytext"><?php echo $arf[report_to];?></td>
                    <td width="5%" align="center" valign="middle" class="mytext"><a href="single-arf.php?student_id=<?php echo $arf["student_id"];?>&id=<?php echo $arf[id];?>"><img src="images/search.png" width="20" height="20" border="0" title="View" /></a></td>
                    <td width="5%" align="center" valign="middle" class="mytext"><a href="arf_print.php?id=<?php echo $arf[id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" border="0" title="Print"/></a></td>
                  </tr>
                  <?php $k++; } ?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_GROUP_GRADE");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" style="padding-left:3px;">
                <table width="50%" border="1" bordercolor="#999" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="8%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                    <td width="41%" align="left" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
                    <td width="24%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE");?></td>
                    <td width="27%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE");?></td>
                  </tr>
                  <?php					
					$i = 1;
					
					$num=$dbf->countRows('grade');
					foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $val) {
					
					$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					if($res_course[name] !='') {
						
					//Get percentage
					$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$student_id' And course_id='$val[course_id]'");					
					$mark = $per[final_percent];
					
					//Get Average
					$grade = $dbf->strRecordID("grade","*","id='$per[grade_id]'");
					$grade_name = $grade[name];
					?>
                  <tr>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $mark;?>%</td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $grade_name;?></td>
                    <?php
					}
					  $i = $i + 1;
					  }
					  ?>
                  </tr>
                  <?php
					if($num==0)
					{
					?>
                  <tr>
                    <td height="25" colspan="4" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                  <?
					}
					?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("TE_MENU_CR");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                  <tr>
                    <td width="7%" height="100" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
                    <td width="5%" height="100" align="center" class="pedtext">Flu / 15</td>
                    <td width="5%" height="100" align="center" class="pedtext">Pro / 15</td>
                    <td width="5%" height="100" align="center" class="pedtext">Gra / 15</td>
                    <td width="6%" height="100" align="center" class="pedtext">Voca / 15</td>
                    <td width="8%" height="100" align="center" class="pedtext">Listen/15</td>
                    <td width="5%" height="100" align="center" class="pedtext">ELT / 40</td>
                    <td width="6%" height="100" align="center" class="pedtext">Desc Result</td>
                    <td width="6%" height="100" align="center" class="pedtext">Num / 15</td>
                    <td width="6%" align="center" class="pedtext">Berlitz<br>
                      Grade</td>
                    <td width="6%" align="center" class="pedtext">Attend</td>
                    <td width="5%" align="center" class="pedtext">No.Unit</td>
                    <td width="6%" align="center" class="pedtext">Att.Calc</td>
                    <td width="4%" height="100" align="center" class="pedtext">Final</td>
                    <td width="6%" height="100" align="center" class="pedtext">Grade</td>
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
				 
				 foreach($dbf->fetchOrder('student s,teacher_progress_certificate c',"s.id=c.student_id AND c.student_id='$student_id'","s.id","c.*") as $course_mark) 
				 {
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$course_mark[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$course = $dbf->strRecordID("course","*","id='$course_mark[course_id]'");
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
                    <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="pedtext"><?php echo $course[name];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $nos;?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $benifit;?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($res_size[units]) { echo $res_size[units]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($attend_calc>0) { echo round($attend_calc); }?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php if($final_grade>0) { echo $final_grade; }?>%</td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php echo $res_grade[name];?></td>
                  </tr>
                  <?php
				 $student_count++; 
				 } 
				 ?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top">
                  
                  </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="18%" height="30" align="left">&nbsp;<a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="25%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="64%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="36%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("SA_MENU_ARF_REPORTS");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"><table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?></td>
                    <td width="13%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTDATE");?></td>
                    <td width="20%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
                    <td width="17%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?></td>
                    <td width="17%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></td>
                    <td width="18%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?></td>
					<td width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                    </tr>
                  <?php
				  $k = 1;
				  foreach($dbf->fetchOrder('arf',"student_id='$student_id'","dated desc") as $arf) {
					  $res_student = $dbf->strRecordID("student","*","id='$arf[student_id]'");
				  ?>
                  <tr>
                    <td width="5%" align="center" valign="middle" class="mytext"><a href="single-arf.php?student_id=<?php echo $arf["student_id"];?>&id=<?php echo $arf[id];?>"><img src="images/search.png" width="20" height="20" border="0" title="View" /></a></td>
                    <td width="5%" align="center" valign="middle" class="mytext"><a href="arf_print.php?id=<?php echo $arf[id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" border="0" title="Print"/></a></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $arf[dated];?></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $arf[action_owner];?></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $arf[report_by];?></td>
                    <td align="center" valign="middle" class="mytext"><?php echo $arf[report_to];?></td>
					<td height="22" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                  </tr>
                  <?php $k++; } ?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_GROUP_GRADE");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" style="padding-left:3px;">
                <table width="50%" border="1" bordercolor="#999" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="8%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                    <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" ><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
                    <td width="27%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE");?></td>
                    <td width="34%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE");?></td>
                  </tr>
                  <?php					
					$i = 1;
					
					$num=$dbf->countRows('student_enroll',"student_id='$student_id'");
					foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $val) {
					
					$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					if($res_course[name] !='') {
						
					//Get percentage
					$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$student_id' And course_id='$val[course_id]'");					
					$mark = $per[final_percent];
					
					//Get Average
					$grade = $dbf->strRecordID("grade","*","id='$per[grade_id]'");
					$grade_name = $grade[name];
					?>
                  <tr>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $mark;?>%</td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="mytext" style="padding-left:5px;"><?php echo $grade_name;?></td>
                    <?php
					}
					  $i = $i + 1;
					  }
					  ?>
                  </tr>
                  <?php
					if($num==0)
					{
					?>
                  <tr>
                    <td height="25" colspan="4" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                  <?
					}
					?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("TE_MENU_CR");?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                  <tr>
                    <td width="7%" height="100" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
                    <td width="5%" height="100" align="center" class="pedtext">Flu / 15</td>
                    <td width="5%" height="100" align="center" class="pedtext">Pro / 15</td>
                    <td width="5%" height="100" align="center" class="pedtext">Gra / 15</td>
                    <td width="6%" height="100" align="center" class="pedtext">Voca / 15</td>
                    <td width="8%" height="100" align="center" class="pedtext">Listen/15</td>
                    <td width="5%" height="100" align="center" class="pedtext">ELT / 40</td>
                    <td width="6%" height="100" align="center" class="pedtext">Desc Result</td>
                    <td width="6%" height="100" align="center" class="pedtext">Num / 15</td>
                    <td width="6%" align="center" class="pedtext">Berlitz<br>
                      Grade</td>
                    <td width="6%" align="center" class="pedtext">Attend</td>
                    <td width="5%" align="center" class="pedtext">No.Unit</td>
                    <td width="6%" align="center" class="pedtext">Att.Calc</td>
                    <td width="4%" height="100" align="center" class="pedtext">Final</td>
                    <td width="6%" height="100" align="center" class="pedtext">Grade</td>
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
				 
				 foreach($dbf->fetchOrder('student s,teacher_progress_certificate c',"s.id=c.student_id AND c.student_id='$student_id'","s.id","c.*") as $course_mark) 
				 {
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$course_mark[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$course = $dbf->strRecordID("course","*","id='$course_mark[course_id]'");
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
                    <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="pedtext"><?php echo $course[name];?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $nos;?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $benifit;?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($res_size[units]) { echo $res_size[units]; }?></td>
                    <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php if($attend_calc>0) { echo round($attend_calc); }?></td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php if($final_grade>0) { echo $final_grade; }?>%</td>
                    <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php echo $res_grade[name];?></td>
                  </tr>
                  <?php
				 $student_count++; 
				 } 
				 ?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top">                  </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
			  </tr>
			  <tr>
				<td bgcolor="#FFFFFF">&nbsp;</td>
			  </tr>
			</table>			</td>
		  </tr>
		</table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
