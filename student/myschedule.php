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

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';


$student_id = $_SESSION[students_uid];

$res_student = $dbf->strRecordID("student","*","id='$student_id'");
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
<script type="text/javascript" src="../js/dropdowntabs.js"></script>

<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />

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
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_MYSCHEDULE_MY_SCHEDULE");?></td>
                  <td width="22%">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp; </td>
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
                  <td width="1911" colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
                  <table width="800" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF">                      
                      <?php
					  $cl = 0;
					  foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And d.student_id='$student_id'","","m.*") as $res_g) 
		  			  {
						  
						  
						  $res_unit = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
						  $unit = $res_unit["units"];						
						  $course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");					  
						  
						  if($cl == 0) { $color = "#D8D6FE"; }
						  if($cl == 1) { $color = "#FDF1D7"; }
						  if($cl == 2) { $color = "#EDE9EC"; }
						  if($cl == 3) { $color = "#FAFDC4"; }
						  if($cl == 4) { $color = "#D8D6FE"; }
						  if($cl == 5) { $color = "#D8D6FE"; }						  
						  if($cl == 6) { $color = "#FDF1D7"; }
						  if($cl == 7) { $color = "#EDE9EC"; }
						  if($cl == 8) { $color = "#FAFDC4"; }
						  if($cl == 9) { $color = "#D8D6FE"; }
						  if($cl == 10) { $color = "#D8D6FE"; }
					  ?>
                      <p></p>
                      <table width="250" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td width="89" height="30" align="left" valign="middle" bgcolor="#FEF1E0" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?></td>
                          <td width="161" align="left" valign="middle" bgcolor="#FEF1E0" class="red_smalltext"><?php echo $course[name];?></td>
                        </tr>
                      </table>
                      <p></p>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" >                        
                        <tr style="background-color:<?php echo $color;?>">
                          <td height="30" align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-top: solid 1px;"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_UNITS");?></td>
                          <td align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></td>
                          <td align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><?php echo constant("STUDENT_ADVISOR_PED_CSV_DATA_ATTD");?></td>
                          <td align="center" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_INSTRUCTOR");?></span></td>
                          <td align="left" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_MATERIALCOVER");?></span></td>
                          <td  align="center" valign="middle" bgcolor="#CCCCCC" style="border-bottom:solid 1px; border-color:#000000;border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_HOMEWORK");?></span></td>
                          </tr>
                        <?php
                        for($i = 1; $i<=$unit; $i++) { 
						
						//Get record from PED units
						$res_unit = $dbf->strRecordID("ped_units","*","group_id='$res_g[id]' And course_id='$res_g[course_id]' AND units='$i'");
						$res_teacher = $dbf->strRecordID("teacher","*","id='$res_unit[teacher_id]'");
						
						$num_attd = $dbf->countRows('ped_attendance',"group_id='$res_g[id]' And course_id='$res_g[course_id]' And unit='$i' And student_id='$student_id' And (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
						?>
                        <tr >
                          <td width="58" height="20" align="center" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; background-color:<?php echo $color;?>"><?php echo $i;?></td>
                          <td width="92" align="center" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php echo $res_unit["dated"];?></td>
                          <td width="45" align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php if($num_attd > 0) { ?><?php }?></td>
                          <td width="142" align="center" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?> "><?php echo $res_teacher["name"];?></td>
                          <td width="251" align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php echo $res_unit["material_overed"];?></td>
                          <td width="199"  align="center" valign="middle" bgcolor="#FFFFFF" style="border-bottom:solid 1px; border-color:#000000;background-color:<?php echo $color;?>">&nbsp;<?php echo $res_unit["homework"];?></td>
                          </tr>
                        <?php } ?>
                        <input type="hidden" name="ucount" id="ucount" value="<?php echo $i-1;?>" />
                        </table>                        
                        <?php
					  		$cl++;				  
						  }
						  ?>                        
                        </td>
                    </tr>
                  </table>				  
				  </td>
                </tr>                
                <?php  ?>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FAFDC4">&nbsp;</td>
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
<?php } else {?>
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
              <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" align="left" >&nbsp;</td>
                  <td width="15%">&nbsp;</td>
                  <td width="7%" align="left">&nbsp;</td>
                  <td width="5%" align="left">&nbsp; </td>
                  <td width="19%" align="right" class="logintext"><?php echo constant("STUDENT_MYSCHEDULE_MY_SCHEDULE");?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
            <tr>
              <td height="200" align="center" valign="top" bgcolor="#FFFFFF"><table width="97%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td width="1911" colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
                    <table width="800" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                      <tr>
                        <td align="right" valign="top" bgcolor="#FFFFFF">                      
                          <?php
					  $cl = 0;
					  foreach($dbf->fetchOrder('student_group m,student_group_dtls d',"m.id=d.parent_id And d.student_id='$student_id'","","m.*") as $res_g){
						  
						  $res_unit = $dbf->strRecordID("group_size","*","group_id='$res_g[group_id]'");
						  $unit = $res_unit["units"];						
						  $course = $dbf->strRecordID("course","*","id='$res_g[course_id]'");					  
						  
						  if($cl == 0) { $color = "#D8D6FE"; }
						  if($cl == 1) { $color = "#FDF1D7"; }
						  if($cl == 2) { $color = "#EDE9EC"; }
						  if($cl == 3) { $color = "#FAFDC4"; }
						  if($cl == 4) { $color = "#D8D6FE"; }
						  if($cl == 5) { $color = "#D8D6FE"; }						  
						  if($cl == 6) { $color = "#FDF1D7"; }
						  if($cl == 7) { $color = "#EDE9EC"; }
						  if($cl == 8) { $color = "#FAFDC4"; }
						  if($cl == 9) { $color = "#D8D6FE"; }
						  if($cl == 10) { $color = "#D8D6FE"; }
					  ?>
                          <p></p>
                          <table width="250" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="165" height="30" align="right" valign="middle" bgcolor="#FEF1E0" class="red_smalltext"><?php echo $course[name];?>&nbsp;</td>
                              <td width="79" align="left" valign="middle" bgcolor="#FEF1E0" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?></td>
                              </tr>
                            </table>
                          <p></p>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >                        
                            <tr style="background-color:<?php echo $color;?>">                              
                              <td  align="center" valign="middle" bgcolor="#CCCCCC" style="border-bottom:solid 1px;  border-right:solid 1px; border-color:#000000;border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_HOMEWORK");?></span></td>
                              <td align="right" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_MATERIALCOVER");?>&nbsp;</span></td>
                              <td align="center" valign="middle" bgcolor="#CCCCCC" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-top: solid 1px;"><span class="red_smalltext"><?php echo constant("STUDENT_MYSCHEDULE_INSTRUCTOR");?></span></td>
                              <td align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><?php echo constant("STUDENT_ADVISOR_PED_CSV_DATA_ATTD");?></td>
                              <td align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;border-top: solid 1px;"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></td>
                              <td height="30" align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-top: solid 1px;"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_UNITS");?></td>
                              </tr>
                            <?php
                        for($i = 1; $i<=$unit; $i++) { 
						
						//Get record from PED units
						$res_unit = $dbf->strRecordID("ped_units","*","group_id='$res_g[id]' And course_id='$res_g[course_id]' AND units='$i'");
						$res_teacher = $dbf->strRecordID("teacher","*","id='$res_unit[teacher_id]'");
						
						$num_attd = $dbf->countRows('ped_attendance',"group_id='$res_g[id]' And course_id='$res_g[course_id]' And unit='$i' And student_id='$student_id' And (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
						?>
                            <tr>                              
                              <td width="199"  align="center" valign="middle" bgcolor="#FFFFFF" style="border-bottom:solid 1px; border-right:solid 1px; border-color:#000000;background-color:<?php echo $color;?>">&nbsp;<?php echo $res_unit["homework"];?></td>
                              <td width="251" align="right" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php echo $res_unit["material_overed"];?>&nbsp;</td>
                              <td width="142" align="center" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?> "><?php echo $res_teacher["name"];?></td>
                              <td width="45" align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php if($num_attd > 0) { echo $num_attd; }?></td>
                              <td width="92" align="center" valign="middle" bgcolor="#FFFFFF" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;background-color:<?php echo $color;?>"><?php echo $res_unit["dated"];?></td>
                              <td width="58" height="20" align="center" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; background-color:<?php echo $color;?>"><?php echo $i;?></td>
                              </tr>
                            <?php } ?>
                            <input type="hidden" name="ucount" id="ucount" value="<?php echo $i-1;?>" />
                            </table>                        
                          <?php
					  		$cl++;				  
						  }
						  ?>                        
                          </td>
                        </tr>
                      </table>				  
                    </td>
                  </tr>                
                <?php  ?>
                </table></td>
              </tr>
            <tr>
              <td bgcolor="#FAFDC4">&nbsp;</td>
              </tr>
            </table>		
        </td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
