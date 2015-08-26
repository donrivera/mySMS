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
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">

<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="../datepicker/demos.css">
<script>
$(function() 
{
	$( "#action_taken_date" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});
</script>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script language="Javascript" type="text/javascript">
$(document).ready(function () {
    $('input[type = "radio"]').change(function () {
        this.checked = false;
    });
});
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
                <td width="54%" height="30" align="left" class="headingtext"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="arf_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
				<br>
				<table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="24" align="left" valign="top" >&nbsp;</td>
                      <td width="793" align="left" valign="top">
					  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
      <tr>
        <td align="center" valign="top" bgcolor="#EBEBEB">
					
					<form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">
					
					  <?php
                      $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
					  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
					  $user = $dbf->strRecordID("user","user_type,user_name","id='$res_arf[teacher_id]'");
					  ?>
					
					    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
							<tr>
								<td width="63">&nbsp;</td>
								<td width="115" height="30" align="right" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?> :</td>
								<td width="202" class="leftmenu">
									<?php $sg=$dbf->strRecordID("student_group","group_name","id='$res_arf[group_id]'");?>
									<input name="group" type="text" id="group" value="<?php echo $sg[group_name];?>" readonly="readonly"/>
								</td>
								<td width="16">&nbsp;</td>
								<td width="74">&nbsp;</td>
								<td width="196" class="mytext">&nbsp;</td>
							</tr>
							<?php $student_name=$res_std[first_name]."&nbsp;".$res_std[father_name]."&nbsp;".$res_std[family_name]."&nbsp;(".$res_std[first_name1]."&nbsp;".$res_std[father_name1]."&nbsp;".$res_std[grandfather_name1]."&nbsp;".$res_std[family_name1].")";?>
                            <tr>
                            <td width="63">&nbsp;</td>
                            <td width="115" height="30" align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?> :</td>
                            <td width="202" class="leftmenu"><input name="owner2" type="text"  id="owner2" value="<?php echo ($res_std[first_name] !== '' ? $student_name:'N/A'); ?>" readonly="readonly"/></td><!--class="validate[required] new_textbox190"-->
                            <td width="16">&nbsp;</td>
                            <td width="74">&nbsp;</td>
                            <td width="196" align="left" valign="middle">
								<a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank">
									<img src="../images/print.png" width="16" height="16" title="Print"/>
								</a>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="30" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :</td>
                            <td align="left" valign="middle"  class="leftmenu"><input name="nr" type="text" id="nr" value="<?php echo $res_arf[dated];?>" readonly="readonly"/>
                              
                            </td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_NR");?> :</td>
                            <td align="left" valign="middle"><input name="nr" type="text" id="nr" value="<?php echo $res_arf[nr];?>" readonly="readonly"/></td><!--class="validate[required] new_textbox190"-->
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td height="30" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?> :</td>
                            <td align="left" valign="middle"  class="leftmenu"><input name="owner" type="text"  id="owner" value="<?php echo $user[user_type]."-".$user[user_name];?>" readonly="readonly"/></td><!--class="validate[required] new_textbox190"-->
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?> : <span class="nametext1">*</span></td>
                            <td align="left" valign="middle" class="leftmenu"></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORTEDTO");?>:</td>
                            <td align="left" valign="middle"></td>
						</tr>
						<tr>		
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CUSTOMER");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="function" value="customer" <?php echo ($res_arf["arf_function"] == 'customer' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td width="74" align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
							<td height="25" align="left" valign="middle">
								<span class="leftmenu">
									<input type="radio" name="function1" value="reception" <?php echo ($res_arf["arf_function1"] == 'reception' ? 'checked' : '')?>>
								</span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_TEACHER");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="function" value="teacher" <?php echo ($res_arf["arf_function"] == 'teacher' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LCD");?> : </td>
							<td height="25" align="left" valign="middle">
								<span class="leftmenu">
									<input type="radio" name="function1" value="lcd" <?php echo ($res_arf["arf_function1"] == 'lcd' ? 'checked' : '')?>>
								</span> 
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RECEPTION");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="function" value="reception" <?php echo ($res_arf["arf_function"] == 'reception' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_LIS");?> : </td>
							<td height="25" align="left" valign="middle">
								<span class="leftmenu">
									<input type="radio" name="function1" value="lis" <?php echo ($res_arf["arf_function1"] == 'lis' ? 'checked' : '')?>>
								</span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="function" value="customer service" <?php echo ($res_arf["arf_function"] == 'customer service' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_CS");?> : </td>
							<td height="25" align="left" valign="middle">
								<span class="leftmenu">
									<input type="radio" name="function1" value="customer service" <?php echo ($res_arf["arf_function1"] == 'customer service' ? 'checked' : '')?>>
								</span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="function" value="other" <?php echo ($res_arf["arf_function"] == 'other' ? 'checked' : '')?>>
								<input name="other1" type="text" id="other1" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="right" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> :</td>
							<td height="25" align="left" valign="middle">&nbsp;&nbsp;
								<input type="radio" name="function1" value="other" <?php echo ($res_arf["arf_function1"] == 'other' ? 'checked' : '')?>>
								<input name="other2" type="text" id="other2" value="<?php echo $res_arf[other1];?>" class="new_textbox100"/>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_SUBJECT");?> :</td>
							<td align="left" valign="middle" class="leftmenu"></td>
						</tr>
						<tr>
							<td align="center" class="leftmenu"></td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_INSTRUCTION");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="instruction" <?php echo ($res_arf["subject"] == 'instruction' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_MATERIAL");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="material" <?php echo ($res_arf["subject"] == 'material' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PROGRAMME");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="program" <?php echo ($res_arf["subject"] == 'program' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_PREMISSES");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="premises" <?php echo ($res_arf["subject"] == 'premises' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ADMINST");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="administration" <?php echo ($res_arf["subject"] == 'administration' ? 'checked' : '')?>>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_OTHER");?> : </td>
							<td height="25" align="left" valign="middle" class="leftmenu">
								<input type="radio" name="subject" value="other" <?php echo ($res_arf["subject"] == 'other' ? 'checked' : '')?>>
								<input name="other3" type="text" class="new_textbox100" id="other3" value="<?php echo $res_arf[other3];?>"size="45" minlength="4"/>
							</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
					</table>
				<table>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_REPORT");?>:</td>
						<td><textarea name="action_report" cols="50" rows="10" readonly><?php echo $res_arf[action_report];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="action_report_date"  type="text" class="new_textbox100" id="action_report_date" size="45" value="<?php echo $res_arf[action_report_date];?>"/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONTAKEN");?>:</td>
						<td><textarea name="action_taken" cols="50" rows="10"><?php echo $res_arf[action_taken];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="action_taken_date"  type="text" class="new_textbox100" id="action_taken_date" size="45" value="<?php echo $res_arf[action_taken_date];?>"/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_RESULTCHECKED");?>:</td>
						<td><textarea name="result_check" cols="50" rows="10"><?php echo $res_arf[result_check];?></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" valign="middle" class="leftmenu"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : 
							<input name="result_check_date"  type="text" class="new_textbox100" id="result_check_date" size="45" value=""/>
							<?php echo constant("TEACHER_ARF_MANAGE_SIGNED");?>:
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="30" align="left" valign="middle" class="leftmenu"></td>
						<td align="center" valign="middle"><input type="submit" name="submit" id="submit" value="Send To LCD" class="btn1"/></td>
					</tr>
                </table>
						<input type="hidden" name="record_id" value="<?php echo $res_arf["id"];?>">
					  </form></td>
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
</table></td>
                      <td width="33" align="right" valign="top" >&nbsp;</td>
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
                       <td width="8%" align="left"><a href="arf_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                     
                      <td width="54%" height="30" align="right" class="headingtext"><?php echo constant("RECEPTION_ARF_MANAGE_VIEWARF");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                        <br>
                        <table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                          <tr>
                            <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                            </tr>
                          <tr>
                            <td width="24" align="left" valign="top" >&nbsp;</td>
                            <td width="793" align="left" valign="top">
                              <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                      <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONREQUESTFRM");?></span></td>
                                      <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                                    <tr>
                                      <td align="center" valign="top" bgcolor="#EBEBEB">
                                        
                                        <form action="arf_process.php?action=edit&id=<?=$_REQUEST[id];?>" name="frm" method="post" id="frm">
                                          
                                          <?php
										  $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
										  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
										  ?>
                                          
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                            <tr>
                                              <td width="196" align="right" valign="middle">
                                                <a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank">
                                                  <img src="../images/print.png" width="16" height="16" title="Print"/></a>
                                                </td>
                                                <td width="74">&nbsp;</td>
                                                <td width="16">&nbsp;</td>
                                                <td width="202" align="right" class="leftmenu"><input name="owner2" type="text" class="validate[required] new_textbox190_ar" id="owner2" value="<?php echo $res_std[first_name]."&nbsp;".$res_std[father_name]."&nbsp;".$res_std[family_name]."&nbsp;(".$res_std[first_name1]."&nbsp;".$res_std[father_name1]."&nbsp;".$res_std[grandfather_name1]."&nbsp;".$res_std[family_name1].")";?>" readonly="readonly"/></td>
                                                <td width="115" height="30" align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
                                                <td width="63">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle"><input name="nr" type="text" class="validate[required] new_textbox190_ar" id="nr" value="<?php echo $res_arf[nr];?>" readonly="readonly"/></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_NR");?></td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle"  class="leftmenu"><input name="nr" type="text" class="validate[required] new_textbox190_ar" id="nr" value="<?php echo $res_arf[dated];?>" readonly="readonly"/></td>
                                              <td height="30" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle"  class="leftmenu"><input name="owner" type="text" class="validate[required] new_textbox190_ar" id="owner" value="<?php echo $res_arf[action_owner];?>" readonly="readonly"/></td>
                                              <td height="30" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?></td>
                                               <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="middle">
                                                <input name="report_to"  type="text" class="new_textbox190_ar" id="report_to" value="<?php echo $res_arf[report_to];?>" size="45" readonly="readonly" minlength="4"/>
                                                </td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td align="right" valign="middle" class="leftmenu"><input name="report_by" type="text" class="validate[required] new_textbox190_ar" id="report_by" value="<?php echo $res_arf[report_by];?>" readonly="readonly"/></td>
                                                <td height="30" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><span class="leftmenu">
                                                <input name="reception2" type="text" class="new_textbox140_ar" id="reception2" value="<?php echo $res_arf[reception2];?>" readonly="readonly">
                                                </span></td>
                                                <td width="74" align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td height="25" align="right" valign="middle" class="leftmenu"><input name="customer" type="text" class="new_textbox140_ar" id="customer" value="<?php echo $res_arf[customer];?>" readonly="readonly"></td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?></td>
                                                 <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><span class="leftmenu">
                                                <input name="lcd" type="text" class="new_textbox140_ar" id="lcd" value="<?php echo $res_arf[lcd];?>" readonly="readonly">
                                                </span> </td>
                                                <td align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_LCD");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td height="25" align="right" valign="middle" class="leftmenu"><input name="teacher" type="text" class="new_textbox140_ar" id="teacher" value="<?php echo $res_arf[teacher];?>" readonly="readonly"></td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><span class="leftmenu">
                                                <input name="lis" type="text" class="new_textbox140_ar" id="lis" value="<?php echo $res_arf[lis];?>" readonly="readonly">
                                                </span></td>
                                                <td align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_LIS");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td height="25" align="right" valign="middle" class="leftmenu"><input name="reception1" type="text" class="new_textbox140_ar" id="reception1" value="<?php echo $res_arf[reception1];?>" readonly="readonly"></td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                                <td height="25" align="right" valign="middle"><span class="leftmenu">
                                                <input name="cs2" type="text" class="new_textbox140_ar" id="cs2" value="<?php echo $res_arf[cs2];?>" readonly="readonly">
                                                </span></td>
                                                <td align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td height="25" align="right" valign="middle" class="leftmenu"><input name="cs1" type="text" class="new_textbox140_ar" id="cs1" value="<?php echo $res_arf[cs1];?>" readonly="readonly"></td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><span class="leftmenu">
                                                <input name="other2" type="text" class="new_textbox190_ar" id="other2" value="<?php echo $res_arf[other2];?>" size="45" readonly="readonly" minlength="4"/>
                                                </span></td>
                                                <td align="left" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                                <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                                <td height="25" align="right" valign="middle" class="leftmenu"><input name="other1" type="text" class="new_textbox190_ar" id="other1" value="<?php echo $res_arf[other1];?>" size="45" readonly="readonly" minlength="4"/></td>
                                                <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="right" valign="middle">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="instruction" type="text" class="new_textbox140_ar" id="instruction" value="<?php echo $res_arf[instruction];?>" readonly="readonly"></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?></td>
                                              <td align="center" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?></td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="material" type="text" class="new_textbox140_ar" id="material" value="<?php echo $res_arf[material];?>" readonly="readonly"></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?></td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="programme" type="text" class="new_textbox140_ar" id="programme" value="<?php echo $res_arf[programme];?>" readonly="readonly"></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?></td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="premisses" type="text" class="new_textbox140_ar" id="premisses" value="<?php echo $res_arf[premisses];?>" readonly="readonly"></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?></td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="administration" type="text" class="new_textbox140_ar" id="administration" value="<?php echo $res_arf[administration];?>" readonly="readonly"></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?></td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="25" align="right" valign="middle" class="leftmenu"><input name="other3" type="text" class="new_textbox140_ar" id="other3" value="<?php echo $res_arf[other3];?>"size="45" readonly="readonly" minlength="4"/></td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                              <td>&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                               <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                               <td align="left" valign="middle">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="center" bgcolor="#FFCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
                                            </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu"> :<?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                              
                                              
                                              <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
                                              </tr>
                                            <tr>
                                              <td align="left" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu"> : <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                                              <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="top" class="leftmenu">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?> </td>
                                              </tr>
                                            <tr>
                                              <td align="center" valign="middle">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                               <td align="left" valign="middle">&nbsp;</td>
                                              <td height="30" align="left" valign="middle" class="leftmenu"><a href="#"></a></td>
                                               <td>&nbsp;</td>
                                              </tr>
                                            </table>
											
                                          </form></td>
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
                                </table></td>
                            <td width="33" align="right" valign="top" >&nbsp;</td>
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
