<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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
$res = $dbf->strRecordID("exam_vacation","*","id='$_REQUEST[id]'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#startdate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#enddate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<!--UI JQUERY DATE PICKER-->

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm.startdate.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select Start Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}
	
	if(document.frm.enddate.value == '')
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Select End Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}	
	
	if(document.frm.startdate.value>document.frm.enddate.value)
	{
		document.getElementById('lblerror').innerHTML = "<html><table width='200' border='0' cellspacing='0' cellpadding='0' style='border:solid 1px; border-color:#990000;'><tr><td width='14%' rowspan='2' align='center' valign='middle' bgcolor='#FFCCFF'><img src='../images/block.png' width='16' height='16' /></td><td width='6%' bgcolor='#FFCCFF'>&nbsp;</td><td width='80%' rowspan='2' bgcolor='#FFCCFF' class='nametext1'>Start Date should be greater than or equal to End Date. </td></tr><tr><td bgcolor='#FFCCFF'>&nbsp;</td></tr></table></html>";
		return false;
	}
	else
	{
		document.getElementById('lblerror').innerHTML = "";
	}	
}

function gotfocus()
{
	document.getElementById('name').focus();
}
</script>

</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>),gotfocus();">
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("VOCATION_EXAM");?></td>
                    <td width="22%" height="30">&nbsp;</td>
                    <td width="8%" height="30" align="left">&nbsp;</td>
                    <td width="8%" height="30" align="left">&nbsp;</td>
                    <td width="8%" height="30" align="left"><a href="vacation_exam_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                      <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("COMMON_RECORDALREADYAXIT");?> </td>
                    </tr>
                </table></td>
              </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                <?php if($_SESSION['lang']=='EN'){?>
                <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_CENTER_EDIT_VACATION");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="vacation_exam_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" onsubmit="return validate();">
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                  <td width="3%">&nbsp;</td>
                                  <td width="16%">&nbsp;</td>
                                  <td width="0%">&nbsp;</td>
                                  <td width="26%">&nbsp;</td>
                                  <td width="0%">&nbsp;</td>
                                  <td width="55%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?>   : <span class="nametext1">*</span></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">
                                    <select name="center" id="center" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;" disabled="disabled">
                                      <option value=""> Select Centre </option>
                                      <?php
									foreach($dbf->fetchOrder('centre',"","") as $resc) {
									  ?>
                                      <option value="<?php echo $resc['id'];?>" <?php if($res["centre_id"]==$resc["id"]) { ?> selected="selected" <?php } ?>><?php echo $resc['name'];?></option>
                                      <?php }?>
                                      </select></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle" id="lblerror">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_EXAM_ADD_EXAMNAME");?> :</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left" valign="middle">
                                  <input name="name" type="text" class="new_textbox1" id="name" size="45" value="<?php echo $res["name"];?>"/></td>
                                  <td>&nbsp;</td>
                                  <td rowspan="3" align="left" valign="top" >
                                    
                                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                      <tr>
                                        <td height="30" align="center" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_CENTER_EDIT_SCHEDULE");?></td>
                                        </tr>
                                      <tr>
                                        <td height="20" align="left" valign="middle">
                                          <?php
									  $teacher_id = $res["centre_id"];
									  
                                      foreach($dbf->fetchOrder('student_group',"centre_id='$teacher_id'","start_date DESC LIMIT 0,3","*","") as $val) {
                                          
                                          //Get group Name
                                          $res_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
                                          
                                      ?>
                                          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td height="20" align="left" valign="middle" bgcolor="#FFCC99" class="leftmenu" style="padding-left:5px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                                              </tr>
                                            <?php
                                        foreach($dbf->fetchOrder('student_group',"id='$val[id]' AND centre_id='$teacher_id'","id") as $val_c) {
                                            
                                            //Get Course Name
                                            $res_course = $dbf->strRecordID("course","*","id='$val_c[course_id]'");
                                        ?>
                                            <tr>
                                              <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo $res_course[name];?></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle" style="padding-right:5px;">
                                                <table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                                  <?php
												  $i = 1;
												  foreach($dbf->fetchOrder('student_group',"course_id='$val_c[course_id]' AND id='$val[id]' AND centre_id='$teacher_id'","id") as $val_dtls) {
												  ?>
                                                  <tr>
                                                    <td width="10%" height="20" align="center" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo $i;?> </td>
                                                    <?php
													  $s1 = date('M d',strtotime($val_dtls["start_date"]));
													  $s2 = date('M d',strtotime($val_dtls["end_date"]));
													  $dt = $s1." - ". $s2;
													  ?>
                                                    <td width="52%" bgcolor="#FFFFCC" class="mytext">
                                                      <?php echo $dt; ?>
                                                      </td>
                                                    </tr>
                                                  <?php
													}
													?>
                                                  </table>
                                                <br />
                                                </td>
                                              </tr>
                                            <?php
											  }
											   ?> 
                                            </table>
                                          <?php
										  }
										  ?>
                                          </td>
                                        </tr>
                                      <tr>
                                        <td height="0" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="top" class="leftmenu"> <?php echo constant("STUDENT_ADVISOR_PED_STARTDT");?> : <span class="nametext1">*</span></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">
                                  <input name="startdate" type="text" class="datepick new_textbox1" readonly="" id="startdate" size="45" value="<?php echo $res["frm"];?>"/></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="top" class="leftmenu"> <?php echo constant("CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE");?> : <span class="nametext1">*</span></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">
                                  <input name="enddate" type="text" class="datepick new_textbox1" readonly="" id="enddate" size="45" value="<?php echo $res["tto"];?>"/></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_VACATIONTYPE");?> : </td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top">
                                    <select name="type" id="type" style="width:153px; border:solid 1px; background-color:#ECF1FF; height:25px;border-color:#999999;">
                                      <option value="Annual">Annual</option>
                                      </select></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top" id="showsch">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
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
                <?php }else{?>
				<table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADMIN_CENTER_EDIT_VACATION");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="vacation_exam_process.php?action=edit&id=<?php echo $_REQUEST[id];?>" name="frm" method="post" id="frm" onsubmit="return validate();">
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr>
								 <td width="39%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="26%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="31%">&nbsp;</td>
                                  <td width="2%">&nbsp;</td>
                                 
                                  </tr>
                                <tr>
								<td align="left" valign="middle" id="lblerror">&nbsp;</td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                    <td align="right" valign="middle">
                                    <select name="center" id="center" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;" disabled="disabled">
                                      <option value=""> Select Centre </option>
                                      <?php
									foreach($dbf->fetchOrder('centre',"","") as $resc) {
									  ?>
                                      <option value="<?php echo $resc['id'];?>" <?php if($res["centre_id"]==$resc["id"]) { ?> selected="selected" <?php } ?>><?php echo $resc['name'];?></option>
                                      <?php }?>
                                      </select></td>
                                  <td align="right">&nbsp;</td>
								  <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></td>
                                
                                  <td>&nbsp;</td>
                                  
                                  </tr>
                                <tr>
								<td rowspan="3" align="left" valign="top" >
                                    
                                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
                                      <tr>
                                        <td height="30" align="center" valign="middle">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_CENTER_EDIT_SCHEDULE");?></td>
                                        </tr>
                                      <tr>
                                        <td height="20" align="left" valign="middle">
                                          <?php
									  $teacher_id = $res["centre_id"];
									  
                                      foreach($dbf->fetchOrder('student_group',"centre_id='$teacher_id'","id","*","") as $val) {
                                          
                                          //Get group Name
                                          $res_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
                                          
                                      ?>
                                          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td height="20" align="left" valign="middle" bgcolor="#FFCC99" class="leftmenu" style="padding-left:5px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                                              </tr>
                                            <?php
                                        foreach($dbf->fetchOrder('student_group',"group_id='$val[group_id]' AND centre_id='$teacher_id'","id") as $val_c) {
                                            
                                            //Get Course Name
                                            $res_course = $dbf->strRecordID("course","*","id='$val_c[course_id]'");
                                        ?>
                                            <tr>
                                              <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo $res_course[name];?></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="middle" style="padding-right:5px;">
                                                <table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
                                                  <?php
												  $i = 1;
												  foreach($dbf->fetchOrder('student_group',"course_id='$val_c[course_id]' AND group_id='$val[group_id]' AND centre_id='$teacher_id'","id") as $val_dtls) {
												  ?>
                                                  <tr>
                                                    <td width="10%" height="20" align="center" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo $i;?> </td>
                                                    <?php
													  $s1 = date('M d',strtotime($val_dtls["start_date"]));
													  $s2 = date('M d',strtotime($val_dtls["end_date"]));
													  $dt = $s1." - ". $s2;
													  ?>
                                                    <td width="52%" bgcolor="#FFFFCC" class="mytext">
                                                      <?php echo $dt; ?>
                                                      </td>
                                                    </tr>
                                                  <?php
													}
													?>
                                                  </table>
                                                <br />
                                                </td>
                                              </tr>
                                            <?php
											  }
											   ?> 
                                            </table>
                                          <?php
										  }
										  ?>
                                          </td>
                                        </tr>
                                      <tr>
                                        <td height="0" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                      </table>
                                  </td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								  <td align="right" valign="middle">
                                  <input name="name" type="text" class="new_textbox1" id="name" size="45" value="<?php echo $res["name"];?>"/></td>
                                 
                                  <td align="right" valign="middle">&nbsp;</td>
                                   <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VACATION_EXAM_ADD_EXAMNAME");?></td>
                                  <td>&nbsp;</td>
                                  
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								  <td align="right" valign="top">
                                  <input name="startdate" type="text" class="datepick new_textbox1" readonly="" id="startdate" size="45" value="<?php echo $res["frm"];?>"/></td>
                                  
                                  <td align="right">&nbsp;</td>
                                  <td height="28" align="left" valign="top" class="leftmenu"><span class="nametext1">*</span>  : <?php echo constant("STUDENT_ADVISOR_PED_STARTDT");?></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								  <td align="right" valign="top">
                                  <input name="enddate" type="text" class="datepick new_textbox1" readonly="" id="enddate" size="45" value="<?php echo $res["tto"];?>"/></td>
                                  
                                  <td align="right">&nbsp;</td>
                                  <td height="28" align="left" valign="top" class="leftmenu"><span class="nametext1">*</span> :  <?php echo constant("CD_REPORT_GROUP_TO_FINIFH_PDF_DATA_ENDDATE");?></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
								 <td align="left" valign="top" id="showsch">&nbsp;</td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								  <td align="right" valign="top">
                                    <select name="type" id="type" style="width:153px; border:solid 1px; background-color:#ECF1FF; height:25px;border-color:#999999;">
                                      <option value="Annual">Annual</option>
                                      </select></td>
                                  
                                  <td align="right">&nbsp;</td>
                                  <td height="28" align="left" valign="top" class="leftmenu"> : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_VACATIONTYPE");?></td>
                                  <td>&nbsp;</td>
                                 
                                  </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>                                 
                                  <td align="left" valign="middle" colspan="3"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                                 
                                  <td align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
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
				<?php }?>
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
