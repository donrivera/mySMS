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

<script type="text/javascript">
function gotfocus()
{
  document.getElementById('unit').focus();
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
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_UNIT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_course_process.php?action=unit" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="27%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="29%">&nbsp;</td>
                              <td width="33%" rowspan="7" align="left" valign="top" style="padding-top:3px;"><br/>
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
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
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
                                  <div class="meter-value" style="background-color:#847B7B; width:40%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="29%" align="left" valign="middle" class="shop2">&nbsp;40%</td>
                              </tr>
                            </table></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TXT2");?> <span class="nametext1">*</span></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <?php
							  $unit=$_SESSION[gr_course_units];
							  if($unit == 0 || $unit == '') { $unit = '76';} else { $unit = $_SESSION["gr_course_units"]; }
							  ?>
                              <td height="28" align="left" valign="middle" class="leftmenu">
                              <select name="unit" id="unit" class="validate[required]" style="width:150px; text-align:center; border:solid 1px; border-color:#999999;">
                                <option value="">--<?php echo constant("ADMIN_UNIT_MANAGE_UNIT");?>--</option>
                                <?php
								foreach($dbf->fetchOrder('common',"type='Unit No'","") as $res_unit) {
									?>
                                <option value="<?php echo $res_unit['id']?>" <?php if($unit==$res_unit["id"]) {?> selected="" <?php } ?>> <?php echo $res_unit['name'];?>&nbsp;units/day</option>
                                <?php } ?>
                              </select></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_TOTAL_UNIT");?> : </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <?php
							if($_SESSION["gr_course_total_units"] == '')
							{
								$i_set = 60;
							}
							else
							{
								$i_set = $_SESSION["gr_course_total_units"];
							}
							
							//Max unit from group_size
							$size = $dbf->strRecordID("group_size","MAX(units)","id>0");	
							$max = $size["MAX(units)"];
							?>
                              <td height="28" align="left" valign="middle" class="leftmenu"><select name="totalunit" id="totalunit" class="validate[required]" style="width:150px; text-align:center; border:solid 1px; border-color:#999999;" onBlur="checkTab('totalunit');">
                                <option value="">--Total Units--</option>
                                <?php
								for($i = 1; $i <= $max; $i++) {
									?>
                                <option value="<?php echo $i;?>" <?php if($i_set==$i) {?> selected="" <?php } ?>> <?php echo $i;?></option>
                                <?php } ?>
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
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu"><a href="group.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
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
                                <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_UNIT");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="group_course_process.php?action=unit" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td width="33%" rowspan="7" align="left" valign="top" style="padding-top:3px;"><br/>
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
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"> <span class="shop2"><?php echo $_SESSION[group_name];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="top">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="top">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="top">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="top">&nbsp;</td>
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
                                            <td width="29%" align="right" valign="middle" class="shop2">40%&nbsp;</td>
                                            <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                            <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                              <div class="meter-value" style="background-color:#847B7B; width:40%;">
                                                <div style="border:solid 1px; border-color:#847B7B; "></div>
                                                </div>
                                              </div></td>
                                              <td width="16%" align="left" valign="middle" class="shop1">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                            
                                            </tr>
                                          </table></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="3" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span><?php echo constant("STUDENT_ADVISOR_GROUP_TXT2");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <?php
										  $unit=$_SESSION[gr_course_units];
										  if($unit == 0 || $unit == '') { $unit = '76';} else { $unit = $_SESSION["gr_course_units"]; }
										  ?>
                                        <td height="28" align="left" valign="middle" class="leftmenu">
                                          <select name="unit" id="unit" class="validate[required]" style="width:150px; text-align:center; border:solid 1px; border-color:#999999;">
                                            <option value="">--<?php echo constant("STUDENT_ADVISOR_GROUP_UNIT");?>--</option>
                                            <?php
											foreach($dbf->fetchOrder('common',"type='Unit No'","") as $res_unit) {
											?>
                                            <option value="<?php echo $res_unit['id']?>" <?php if($unit==$res_unit["id"]) {?> selected="" <?php } ?>> <?php echo $res_unit['name'];?>&nbsp;units/day</option>
                                            <?php } ?>
                                            </select></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="right" valign="middle" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_GROUP_TOTAL_UNIT");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <?php
										if($_SESSION["gr_course_total_units"] == '')
										{
											$i_set = 60;
										}
										else
										{
											$i_set = $_SESSION["gr_course_total_units"];
										}
										
										//Max unit from group_size
										$size = $dbf->strRecordID("group_size","MAX(units)","id>0");	
										$max = $size["MAX(units)"];
										?>
                                        <td height="28" align="left" valign="middle" class="leftmenu"><select name="totalunit" id="totalunit" class="validate[required]" style="width:150px; text-align:center; border:solid 1px; border-color:#999999;" onBlur="checkTab('totalunit');">
                                          <option value="">--<?php echo constant("QUICK_TOTAL_UNITS");?>--</option>
                                          <?php
										for($i = 1; $i <= $max; $i++) {
										?>
                                          <option value="<?php echo $i;?>" <?php if($i_set==$i) {?> selected="" <?php } ?>> <?php echo $i;?></option>
                                          <?php } ?>
                                          </select></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="25" align="left" valign="middle" class="leftmenu"><a href="group.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
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
