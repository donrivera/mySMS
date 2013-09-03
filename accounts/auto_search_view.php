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

$res = $dbf->strRecordID("student","*","id='$_REQUEST[id]'");
$res_country = $dbf->strRecordID("countries","*","id='$res[country_id]'");
$res_status = $dbf->strRecordID("common","*","id='$res[studentstatus_id]'AND type='student status'");
$res_student = $dbf->strRecordID("student_course","*","student_id='$res[id]'");
$res_course = $dbf->strRecordID("course","*","id='$res_student[course_id]'");
$res_lead = $dbf->strRecordID("student_lead","*","student_id='$res[id]'");
$res_lead1 = $dbf->strRecordID("common","*","id='$res_lead[lead_id]'AND type='lead type'");

$num=$dbf->countRows('student',"id='$_REQUEST[id]'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
</head>
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
<body onload="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
            <td height="450" align="left" valign="top"  style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="centercolumntext"><span class="logintext"><?php echo constant("STUDENT_INFORMATON");?></span></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp; </td>
                    <td width="8%" align="left"><a href="auto_search.php"> 
                      <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:5px;">
                
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("VIEW_STUDENT_INFORMATON");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                       
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="5%">&nbsp;</td>
                              <td width="29%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="62%">&nbsp;</td>
                              <td width="3%">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L1");?>: <span class="nametext1">*</span> </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L2");?>: <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[arabic_name]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L3");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[father_name]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L4");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[father_name1]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L5");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[grandfather_name]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L6");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[grandfather_name1]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L7");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[family_name]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L8");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[family_name1]; ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res_country[value]; ?>
                            </td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_GENDER");?>:</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[gender]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_IDNUMB");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[student_id]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[student_mobile]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L9");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res[alt_contact]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_EMAILADDRESS");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  <?php echo $res[email]; ?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S5_STATUSOFSTD");?>: </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res_status[name]; ?></td>
							 
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_11"><?php echo constant("STUDENT_ADVISOR_S10_INTEREST");?>: </label></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  <?php
                              $course = "";
					
								foreach($dbf->fetchOrder('student_course',"student_id='$res[id]'","") as $valc) {
								
									$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
									if($course=='')
									{
										$course  = $c[name];
									}
									else
									{
										$course  = $course.",".$c[name];
									}
								}
								?>
							<?php echo $course;?>
							</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_S10_COMMENTS");?></label>
                                :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php echo $res["student_comment"];?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_L10");?>?</label></td>
                              <td>&nbsp;</td>
                              <?php
                              $lead = "";
					
								foreach($dbf->fetchOrder('student_lead',"student_id='$res[id]'","") as $valc) {
								
									$c = $dbf->strRecordID("common","name","id='$valc[lead_id]'");
									if($lead=='')
									{
										$lead  = $c[name];
									}
									else
									{
										$lead  = $lead.",".$c[name];
									}
								}
								?>
                              <td align="left" valign="middle"><?php echo $lead;?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_HOME_S_CLASSIC_STDPHOTO");?>: </td>
                              <td align="left" valign="middle"></td>
                              <?php if($res["photo"]!=''){
							  		$photo = "../sa/photo/".$res["photo"];
							  }else{
							  		$photo = "../images/noimage.jpg";
							  }
							  ?>
                              <td align="left" valign="bottom"><img src="<?php echo $photo; ?>" width="100" height="100" /></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
							 
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>

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
</body>
</html>
