<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['students_uid']=="" || $_SESSION['students_user_type']!="Student")
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

$students_id = $_SESSION[students_uid];

$res = $dbf->strRecordID("student","*","id='$students_id'");

include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="../js/dropdowntabs.js"></script>
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
<?php if($_SESSION[lang] == "EN"){ ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF"><table width="97%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td width="637" colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCC99;">
                    <tr>
                      <td height="20" align="left" valign="middle" class="menutext">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="35%" height="20" align="left" valign="top" class="menutext" style="padding-left:6px;">
                      <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td width="22%" height="20" align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_YOURNAME");?> :</td>
                          <td width="78%" align="left" valign="middle" class="pedtext">&nbsp;<?php echo $res["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></td>
                          </tr>
                          <?php if($res["student_id"] > 0){?>
                        <tr>
                          <td height="20" align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_STDUENTID");?> : </td>
                          <td align="left" valign="middle" class="pedtext">&nbsp;<?php echo $res["student_id"];?></td>
                          </tr>
                          <?php } ?>
                        <tr>
                          <td height="20" align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_EMAIL");?> :</td>
                          <td align="left" valign="middle" class="pedtext">&nbsp;<?php echo $res["email"];?></td>
                          </tr>
                        <tr>
                          <td height="20" align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?> :</td>
                          <td align="left" valign="middle" class="pedtext">&nbsp;<?php echo $res["student_mobile"];?></td>
                          </tr>
                        </table>
                      </td>
                      <?php
						     if($res["photo"]!='')
							 {
							  $photo="../sa/photo/".$res["photo"];
							 }
							 else
							 {
								 $photo="../images/noimage.jpg";
							 }
						  ?>
                      <td width="65%" align="right" valign="middle" style="padding-right:15px;">
                      
                      <table width="80" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th align="right" valign="middle" scope="col" style="border-right:solid #FF9900;border-bottom:solid #FF9900;">
                          <img width="80" height="80" src="<?php echo $photo;?>" /></th>
                        </tr>
                      </table></td>
                      </tr>
                      <tr>
                        <td height="10" colspan="2" align="left" valign="middle" class="leftmenu"></td>
                      </tr>
                      <tr>
                        <td height="20" colspan="2" align="left" valign="middle">
                        
                        <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="7%" height="100" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  <td width="4%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
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
				 
				 foreach($dbf->fetchOrder('student s,teacher_progress_certificate c',"s.id=c.student_id AND c.student_id='$students_id'","s.id","c.*") as $course_mark) 
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
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2">
                    <?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $nos;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $benifit;?></td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($res_size[units]) { echo $res_size[units]; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                    <?php if($attend_calc>0) { echo round($attend_calc); }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2">
                    <?php if($final_grade>0) { echo $final_grade; }?>
                  </td>
                  <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php echo $res_grade[name];?></td>
                </tr>
				 <?php
				 $student_count++; 
				 } 
				 ?>
                
              </table>
                        
                        </td>
                        </tr>
                      <tr>
                        <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                
                
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
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
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left">&nbsp;</td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="right" class="logintext"><?php echo constant("STUDENT_MENU_CERTIFICATE_GRADES");?>&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF"><table width="97%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td width="637" colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCC99;">
                    <tr>
                      <td height="20" align="left" valign="middle" class="menutext">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
						<?php
                         if($res["photo"]!=''){
                          $photo="../sa/photo/".$res["photo"];
                         }else{
                             $photo="../images/noimage.jpg";
                         }
                      ?>
                    <tr>
                      <td width="35%" height="20" align="left" valign="top" class="menutext" style="padding-left:6px;">
                      <table width="80" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th align="right" valign="middle" scope="col" style="border-right:solid #FF9900;border-bottom:solid #FF9900;">
                          <img width="80" height="80" src="<?php echo $photo;?>" /></th>
                        </tr>
                      </table>
                      </td>
                      <td width="65%" align="right" valign="middle" style="padding-right:5px;">
                      
                      <table width="60%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td width="74%" height="20" align="right" valign="middle" class="pedtext"><?php echo $res["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?>&nbsp;</td>
                          <td width="26%" align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_YOURNAME");?></td>
                        </tr>
                        <?php if($res["student_id"] > 0){?>
                        <tr>
                          <td height="20" align="right" valign="middle" class="pedtext"><?php echo $res["student_id"];?>&nbsp;</td>
                          <td align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_STDUENTID");?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td height="20" align="right" valign="middle" class="pedtext"><?php echo $res["email"];?>&nbsp;</td>
                          <td align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_EMAIL");?></td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle" class="pedtext"><?php echo $res["student_mobile"];?>&nbsp;</td>
                          <td align="left" valign="middle" bgcolor="#E8E8E8" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?></td>
                        </tr>
                      </table>
                      </td>
                      </tr>
                      <tr>
                        <td height="10" colspan="2" align="left" valign="middle" class="leftmenu"></td>
                      </tr>
                      <tr>
                        <td height="20" colspan="2" align="left" valign="middle">
                        
                        <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                <tr>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TEXT");?></td>
                  <td width="4%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FINALGRD");?></td>
                  
                  
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_FLUEN15");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_PRONUN15");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_GARMMER15");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_VOCABUL15");?></td>
                  <td width="8%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_TXT");?></td>
                  <td width="5%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TEXT");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_DESRESUlT");?></td>
                  <td width="6%" height="100" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_NUMERESULT");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_BENIFTGRD");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                  <td width="5%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_TXT8");?></td>
                  <td width="6%" align="center" class="pedtext"><?php echo constant("TEACHER_REPORT_CENTERDI_ATTENDCALC");?></td>
                  
                  <td width="7%" height="100" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
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
				 
				 foreach($dbf->fetchOrder('student s,teacher_progress_certificate c',"s.id=c.student_id AND c.student_id='$students_id'","s.id","c.*") as $course_mark) 
				 {
					$res_teacher_group = $dbf->strRecordID("student_group","*","id='$course_mark[group_id]'");
					$res_size = $dbf->strRecordID("group_size","*","group_id='$res_teacher_group[group_id]'");
					$course = $dbf->strRecordID("course","*","id='$course_mark[course_id]'");
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
                         
                          <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2"><?php echo $res_grade[name];?></td>
                          <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2">
                            <?php if($final_grade>0) { echo $final_grade; }?>
                          </td>           
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[fluency]>0) { echo get_percent($course_mark[fluency]); }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[pronunciation]>0) { echo get_percent($course_mark[pronunciation]); }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[grammer]>0) { echo get_percent($course_mark[grammer]); }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[vocabulary]>0) { echo get_percent($course_mark[vocabulary]); }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[listening]>0) { echo get_percent($course_mark[listening]); }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[end_of_level]>0) { echo $course_mark[end_of_level]; }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#E8E8E8" class="shop2">
                            <?php if($course_mark[end_of_level] > 0) { echo $grade_sheet[name]; }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $nos;?></td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2"><?php echo $benifit;?></td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($course_mark[attendance]>0) { echo $course_mark[attendance]; }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($res_size[units]) { echo $res_size[units]; }?>
                          </td>
                          <td align="center" valign="middle" bgcolor="#FFFFFF" class="shop2">
                            <?php if($attend_calc>0) { echo round($attend_calc); }?>
                          </td>
                          
                          
                          <td height="25" align="left" valign="middle" bgcolor="#E8E8E8" class="pedtext"><?php echo $course[name];?></td>
                        </tr>
				 <?php
				 $student_count++; 
				 } 
				 ?>
                
              </table>
                        
                        </td>
                        </tr>
                      <tr>
                        <td height="20" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                
                
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
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
