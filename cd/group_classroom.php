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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

//echo $_SESSION[student_id];

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
<script type="text/javascript" src="dropdowntabs.js"></script>

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

<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()
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
<script type="text/javascript">
function gotfocus()
{
  document.getElementById('class_room').focus();
}
function checkTab(id)
{
	if(id=="class_room")
	{
	document.getElementById('submit').focus();
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
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_CLASSROOM");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_course_process.php?action=class" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="27%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="29%">&nbsp;</td>
                              <td width="33%" rowspan="8" align="left" valign="top" style="padding-top:3px;"><br>
                                <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                  <tr>
                                    <td height="25" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                  <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?> :</span> <span class="shop2"><?php echo $ress["name"];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?> :</span> <span class="shop2"><?php echo $_SESSION[group_name];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <?php
							   $unit_no=$dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");
							   ?>
                                    <td align="left" valign="middle"><span class="shop1"> <?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_UNITSDAY");?> : </span><span class="shop2"><?php echo $unit_no[name]; ?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <?php
							    $rest=$dbf->strRecordID("teacher","*","id='$_SESSION[gr_course_teacher]'") ;
							  ?>
                                    <td align="left" valign="middle"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?> :</span><span class="shop2"><?php echo $rest[name];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="25" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:80%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="29%" align="left" valign="middle" class="shop2">&nbsp;80%</td>
                              </tr>
                            </table></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT7");?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td height="28" align="left" valign="middle">
                              <select name="class_room" id="class_room" style="width:150px; border:solid 1px; border-color:#999999;" onBlur="checkTab('class_room');">
                                <option value="">--Select Classroom--</option>
                                <?php
								foreach($dbf->fetchOrder('centre_room',"centre_id='$_SESSION[centre_id]' And id not in(select room_id from student_group where status<>'Completed' And centre_id='$_SESSION[centre_id]')","") as $resu) {
							  ?>
                                <option value="<?php echo $resu['id']?>" <?php if($resu["id"]==$_SESSION["gr_class_room"]){?> selected="selected"<?php }?>> <?php echo $resu['name'];?></option>
                                <?php }?>
                              </select></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu"><a href="group_teacher.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/></td>
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
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <tr>
                      <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_CLASSROOM");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="group_course_process.php?action=class" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td width="33%" rowspan="8" align="center" valign="top" style="padding-top:3px;"><br>
                                          <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                            <tr>
                                              <td height="25" align="left" valign="middle">&nbsp;</td>
                                              </tr>
                                            <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                            <tr>
                                              <td align="right" valign="top"> <span class="shop2"><?php echo $ress["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[group_name];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <?php
							   $unit_no=$dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");
							   ?>
                                              <td align="right" valign="middle"> <span class="shop2"><?php echo $unit_no[name]; ?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_UNITSDAY");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <?php
							    $rest=$dbf->strRecordID("teacher","*","id='$_SESSION[gr_course_teacher]'") ;
							  ?>
                                              <td align="right" valign="middle"><span class="shop2"><?php echo $rest[name];?></span><span class="shop1">:<?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="left" valign="top">&nbsp;</td>
                                              </tr>
                                            </table></td>
                                        <td width="29%">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="27%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="29%" align="right" valign="middle" class="shop2">80%&nbsp;</td>
                                            <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                            <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                              <div class="meter-value" style="background-color:#847B7B; width:80%;">
                                                <div style="border:solid 1px; border-color:#847B7B; "></div>
                                                </div>
                                              </div></td>
                                              <td width="16%" align="left" valign="middle" class="shop1">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                            </tr>
                                          </table></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="3" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT7");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="right" valign="middle" class="leftmenu">
                                        <select name="class_room" id="class_room" style="width:150px; border:solid 1px; border-color:#999999;" onBlur="checkTab('class_room');">
                                          <option value="">--<?php echo constant("SELECT_CLASSROOM");?>--</option>
                                          <?php
											foreach($dbf->fetchOrder('centre_room',"centre_id='$_SESSION[centre_id]' And id not in(select room_id from student_group where status<>'Completed' And centre_id='$_SESSION[centre_id]')","") as $resu) {
										  ?>
                                          <option value="<?php echo $resu['id']?>" <?php if($resu["id"]==$_SESSION["gr_class_room"]){?> selected="selected"<?php }?>> <?php echo $resu['name'];?></option>
                                          <?php }?>
                                          </select></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="right"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="25" align="left" valign="middle" class="leftmenu"><a href="group_teacher.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
