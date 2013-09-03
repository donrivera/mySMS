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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script type="text/javascript">
function gotfocus()
{
  document.getElementById('name').focus();
}
</script>

<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()	
	//$.validationEngine.loadValidation("#date")
	//alert($("#formID").validationEngine({returnIsValid:true}))
	//$.validationEngine.buildPrompt("#date","This is an example","error")	 		 // Exterior prompt build example
	//$.validationEngine.closePrompt(".formError",true) 							// CLOSE ALL OPEN PROMPTS
});

// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
function validate2fields(){
	if($("#firstname").val() =="" ||  $("#lastname").val() == ""){
		return false;
	}else{
		return true;
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->
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
<?php if($_SESSION['lang']=='EN'){?>
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
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="alert_manage.php"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3">&nbsp;</td>
              </tr>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" >
                
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("REVIEW_GROUP");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_course_process.php?action=finish" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <?php if($_REQUEST[msg]=='exist'){ ?>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="3" align="center" valign="middle" class="nametext1"><span style="color:#FF0000; font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT8");?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="3">&nbsp;</td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                  <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                  <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                    <div class="meter-value" style="background-color:#847B7B; width:100%;">
                                      <div style="border:solid 1px; border-color:#847B7B; "></div>
                                    </div>
                                  </div></td>
                                  <td width="29%" align="left" valign="middle" class="shop2">&nbsp;100%</td>
                                </tr>
                              </table></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php
								$res_group = $dbf->strRecordID("common","*","id='$_SESSION[gr_group_id]'");								
							?>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <td colspan="3" align="left" valign="middle" ><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?> : </span><span class="shop2"> <?php echo $_SESSION["group_name"];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php
								$ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");								
							?>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?> : </span><span class="shop2"> <?php echo $ress["name"];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <?php							 
							    $rest=$dbf->strRecordID("teacher","*","id='$_SESSION[gr_course_teacher]'") ;
							?>
                              <td height="25">&nbsp;</td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?> : </span><span class="shop2"><?php echo $rest[name]; ?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <?php
							   $unit_no=$dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");
							   ?>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("ADMIN_CENTRE_MANAGE_NOUNITS");?> : </span><span class="shop2"><?php echo $unit_no[name];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_UNIT");?> : </span><span class="shop2"><?php echo $_SESSION[gr_course_total_units];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?> : </span><span class="shop2"><?php echo $_SESSION[dt];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25"></td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?> : </span><span class="shop2"><?php echo $_SESSION[gr_course_endt];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25"></td>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_GROUPTIME");?> : </span><span class="shop2"><?php echo $_SESSION[tm];?>-<?php echo $_SESSION[end_tm];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php if($_SESSION[gr_class_room] != ""){?>
                            <tr>
                              <td height="25">&nbsp;</td>
                              <?php
							    $resr=$dbf->strRecordID("centre_room","*","id='$_SESSION[gr_class_room]'") ;
							  ?>
                              <td colspan="3" align="left" valign="middle" class="lable1"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_CLASSROOM");?> : </span><span class="shop2"><?php echo $resr["name"];?></span></td>
                              <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="20%" align="left" valign="middle" class="lable1">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="40%" align="left" valign="middle" class="lable1">&nbsp;</td>
                              <td width="29%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="center" valign="middle" class="leftmenu"><a href="group_classroom.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_finish_btn");?>" class="btn1"/></td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>
                        </form>
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                
				  </td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
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
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left"><a href="alert_manage.php"></a></td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="450" align="center" valign="top" bgcolor="#FFFFFF" >
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" valign="middle" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("REVIEW_GROUP");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="group_course_process.php?action=finish" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <?php if($_REQUEST[msg]=='exist'){ ?>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3" align="center" valign="middle" class="nametext1"><span style="color:#FF0000; font-weight:bold;"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT8");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <?php } ?>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3">&nbsp;</td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>                                           
                                            <td width="29%" align="right" valign="middle" class="shop2">100%&nbsp;</td>
                                             <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                              <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                                <div class="meter-value" style="background-color:#847B7B; width:100%;">
                                                  <div style="border:solid 1px; border-color:#847B7B; "></div>
                                                  </div>
                                                </div></td>
                                            <td width="16%" align="left" valign="middle" class="shop1">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                            </tr>
                                          </table></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <?php
										$res_group = $dbf->strRecordID("common","*","id='$_SESSION[gr_group_id]'");								
									  ?>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" align="right" valign="middle" ><span class="shop2"> <?php echo $_SESSION["group_name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <?php
										$ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");								
									?>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"> <?php echo $ress["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <?php							 
										$rest=$dbf->strRecordID("teacher","*","id='$_SESSION[gr_course_teacher]'") ;
									?>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $rest[name]; ?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <?php
									   $unit_no=$dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");
									   ?>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $unit_no[name];?></span><span class="shop1"> : <?php echo constant("ADMIN_CENTRE_MANAGE_NOUNITS");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $_SESSION[gr_course_total_units];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_UNIT");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $_SESSION[dt];?></span><span class="shop1"> : <?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="25"></td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $_SESSION[gr_course_endt];?></span><span class="shop1"> : <?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="25"></td>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $_SESSION[end_tm];?>-<?php echo $_SESSION[m];?></span><span class="shop1"> : <?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_GROUPTIME");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                      </tr>
                                      <?php if($_SESSION[gr_class_room] != ""){?>
                                      <tr>
                                        <td height="25">&nbsp;</td>
                                        <?php
											$resr=$dbf->strRecordID("centre_room","*","id='$_SESSION[gr_class_room]'") ;
										  ?>
                                        <td colspan="3" align="right" valign="middle" class="lable1"><span class="shop2"><?php echo $resr["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_CLASSROOM");?></span></td>
                                        <td align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                      </tr>
                                      <?php } ?>
                                      <tr>
                                        <td width="10%">&nbsp;</td>
                                        <td width="20%" align="left" valign="middle" class="lable1">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="40%" align="left" valign="middle" class="lable1">&nbsp;</td>
                                        <td width="29%" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_finish_btn");?>" class="btn2"/></td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td height="25" align="center" valign="middle" class="leftmenu"><a href="group_classroom.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                                        
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      </table>
                                    </form>
                                  
                                  </td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                                    <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                                    <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                        
                        </td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
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
