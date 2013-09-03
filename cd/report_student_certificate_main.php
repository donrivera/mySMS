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

$pro = $dbf->strRecordID("teacher_progress","*","group_id='$_REQUEST[group_id]'");

//$teacher_id = $pro[teacher_id];
$teacher_id = $_REQUEST[teacher_id];

$rest = $dbf->strRecordID("teacher","*","id='$teacher_id'");
?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

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
<?php if($_SESSION[lang]=="EN"){?>
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
        
        
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="400" align="center" valign="top"><table width="500" border="0" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
                <tr>
                  <td width="63%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="15%" align="left" valign="middle" class="nametext">&nbsp;</td>
                      <td width="21%">&nbsp;</td>
                      <td width="1%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" colspan="2" align="left" valign="middle" style="padding-left:3px;">
                      
                      <form action="" name="frm" method="post" id="frm">
                      <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                        <tr>
                          <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                        </tr>
                        <tr>
                          <td height="25" align="right" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?>:</td>
                          <td align="left" valign="middle" bgcolor="#FFE2D5" class="heading"><select name="teacher_id" class="" id="teacher_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_student_certificate_main.php',document.frm.submit();">
                            <option value="">Select Teacher</option>
                            <?php
						  foreach($dbf->fetchOrder('user',"user_type='Teacher' and center_id='$_SESSION[centre_id]'","","","") as $res_teacher) {
							  ?>
                            <option value="<?php echo $res_teacher['uid'];?>" <?php if($_REQUEST[teacher_id]==$res_teacher["uid"]) { ?> selected="selected" <?php } ?>><?php echo $res_teacher['user_name'];?>
                              <?php
						  }
						  ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td width="28%" height="25" align="right" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?>:</td>
                          <td width="72%" align="left" valign="middle" bgcolor="#FFE2D5" class="heading"><select name="group_id" class="" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_student_certificate_main.php',document.frm.submit();">
                            <option value="">Select Group</option>
                            <?php
						  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' and teacher_id='$_REQUEST[teacher_id]'","","") as $res_group) {
							  ?>
                            <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'];?></option>
                            <?php
						  }
						  ?>
                          </select></td>
                        </tr>
                        <tr>
                          <td height="25" align="right" bgcolor="#FFE2D5" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_COURSE");?>:</td>
                          <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                          <td align="left" valign="middle" bgcolor="#FFE2D5" class="heading"><?php echo $res_course[name];?></td>
                        </tr>
                        <tr>
                          <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                        </tr>
                      </table>
                      </form>
                      
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($_REQUEST[group_id]!='')
				  {
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
				  }
				  ?>
                  </table></td>
                  <td width="36%" height="30" align="right" valign="middle">
                  
                  
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="54%" align="right" valign="middle">
                      
                      <a href="report_student_certificate_print.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>" target="_blank">
                    <?php if($_REQUEST[group_id]!="" && $_REQUEST[teacher_id]!="") { ?>
                    <img src="../images/printButton.png" width="50" height="16" border="0">
                    <?php } ?>
                  </a>
                  </td>
                      <td width="46%" align="center" valign="middle">
                      <a href="report_student_certificate_word.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>">
                    <?php //if($_REQUEST[group_id]!=""  && $_REQUEST[teacher_id]!="") { ?>
                    <img src="../images/word2007.png" width="25" height="25" border="0">
                    <?php //} ?>
                  </a></td>
                    </tr>
                  </table>
                  
                  
                  </td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="center" valign="middle"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="7%" align="center" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>
                      <td width="39%" height="30" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?> </td>
                      <td width="30%" height="30" align="center" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?> </td>
                      <td width="24%" height="30" align="left" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("CD_REPORT_STUDENT_CERTIFICATE_MAIN_STDID");?> </td>
                      </tr>
                    <?php $student_count = 1;?>
                    <?php
						
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$_REQUEST[teacher_id]' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id,g.units") as $r) {
					
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");
										
					?>
                    <tr>
                      <td align="center" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;</td>
                      <td height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $res_country[value];?></td>
                      <td align="left" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $r[student_id];?>
                        <input type="hidden" name="student_id<?php echo "_".$student_count;?>" id="student_id<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>"></td>
                      </tr>
                    <?php $student_count++; } ?>
                    </table></td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
              
        </td>
      </tr>
    </table></td>
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
    <td align="center" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
        
        
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="400" align="center" valign="top"><table width="500" border="0" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
                <tr>
                  <td width="36%" height="30" align="right" valign="middle">
                  
                  
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                     
                      <td width="46%" align="center" valign="middle">
                      <a href="report_student_certificate_word.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>">
                    <?php //if($_REQUEST[group_id]!=""  && $_REQUEST[teacher_id]!="") { ?>
                    <img src="../images/word2007.png" width="25" height="25" border="0">
                    <?php //} ?>
                  </a></td>
                   <td width="54%" align="right" valign="middle">
                      
                      <a href="report_student_certificate_print.php?group_id=<?php echo $_REQUEST[group_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>" target="_blank">
                    <?php if($_REQUEST[group_id]!="" && $_REQUEST[teacher_id]!="") { ?>
                    <img src="../images/printButton.png" width="50" height="16" border="0">
                    <?php } ?>
                  </a>
                  </td>
                    </tr>
                  </table>
                  </td>
                  <td width="63%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="15%" align="left" valign="middle" class="nametext">&nbsp;</td>
                      <td width="21%">&nbsp;</td>
                      <td width="1%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" colspan="2" align="right" valign="middle" style="padding-left:3px;">
                      
                      <form action="" name="frm" method="post" id="frm">
                      <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                        <tr>
                          <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                        </tr>
                        <tr>
                          
                          <td align="right" valign="middle" bgcolor="#FFE2D5" class="heading"><select name="teacher_id" class="" id="teacher_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_student_certificate_main.php',document.frm.submit();">
                            <option value=""><?php echo constant("ADMIN_REPORT_TEACHER_SCHEDULE_SELECTTEACHER");?></option>
                            <?php
						  foreach($dbf->fetchOrder('user',"user_type='Teacher' and center_id='$_SESSION[centre_id]'","","","") as $res_teacher) {
							  ?>
                            <option value="<?php echo $res_teacher['uid'];?>" <?php if($_REQUEST[teacher_id]==$res_teacher["uid"]) { ?> selected="selected" <?php } ?>><?php echo $res_teacher['user_name'];?>
                              <?php
						  }
						  ?>
                            </select></td>
                            <td height="25" align="left" bgcolor="#FFE2D5" class="pedtext"> : <?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></td>
                        </tr>
                        <tr>
                          
                          <td width="72%" align="right" valign="middle" bgcolor="#FFE2D5" class="heading"><select name="group_id" class="" id="group_id" style="width:150px; border:solid 1px; border-color:#999999;" onChange="javascript:document.frm.action='report_student_certificate_main.php',document.frm.submit();">
                            <option value=""><?php echo constant("SELECT_GROUP");?></option>
                            <?php
						  foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' and teacher_id='$_REQUEST[teacher_id]'","","") as $res_group) {
							  ?>
                            <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[group_id]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'];?></option>
                            <?php
						  }
						  ?>
                          </select></td>
                          <td width="28%" height="25" align="left" bgcolor="#FFE2D5" class="pedtext"> : <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></td>
                        </tr>
                        <tr>
                          
                          <?php
					  $res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group_id]'");
					  $res_course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");
					  ?>
                          <td align="right" valign="middle" bgcolor="#FFE2D5" class="heading"><?php echo $res_course[name];?></td>
                          <td height="25" align="left" bgcolor="#FFE2D5" class="pedtext"> : <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_COURSE");?></td>
                        </tr>
                        <tr>
                          <td height="5" colspan="2" align="left" bgcolor="#FFE2D5" class="pedtext"></td>
                        </tr>
                      </table>
                      </form>
                      
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php
				  $res_size = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
				  $res_group = $dbf->strRecordID("common","*","id='$res_g[group_id]'");
				  if($_REQUEST[group_id]!='')
				  {
					 $res_teacher_group = $dbf->strRecordID("student_group","*","teacher_id='$teacher_id' AND group_id='$_REQUEST[group_id]'");
				  }
				  ?>
                  </table></td>
                  
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="center" valign="middle"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-collapse:collapse;">
                    <tr>
                      <td width="24%" height="30" align="right" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("CD_REPORT_STUDENT_CERTIFICATE_MAIN_STDID");?> </td>
                      <td width="30%" height="30" align="right" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_STDNAT");?> </td>
                      <td width="39%" height="30" align="right" bgcolor="#E8E8E8" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?> </td>
                      <td width="7%" align="center" valign="middle" bgcolor="#E8E8E8">&nbsp;</td>
                      </tr>
                    <?php $student_count = 1;?>
                    <?php
						
					foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls c',"g.id=c.parent_id And s.id=c.student_id And g.teacher_id='$_REQUEST[teacher_id]' And g.id='$_REQUEST[group_id]'","s.first_name","s.*,c.course_id,g.units") as $r) {
					
                    $res_country = $dbf->strRecordID("countries","*","id='$r[country_id]'");
										
					?>
                    <tr>                      
                      <td align="right" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $r[student_id];?>
                        <input type="hidden" name="student_id<?php echo "_".$student_count;?>" id="student_id<?php echo "_".$student_count;?>" value="<?php echo $r[id];?>"></td>
                        <td align="right" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $res_country[value];?></td>
                         <td height="25" align="right" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;<?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" class="smalltext">&nbsp;</td>
                      </tr>
                    <?php $student_count++; } ?>
                  </table></td>
                </tr>
                <tr>
                  <td height="20" colspan="2" align="left" valign="middle" class="nametext">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
              
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>