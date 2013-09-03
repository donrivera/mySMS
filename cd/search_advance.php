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

$student_id = $_REQUEST["student_id"];
$course_id = $_REQUEST["course_id"];

$val_student = $dbf->strRecordID("student","*","id='$student_id'");
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});

$(function() {
	$( ".datepickFuture" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});


$(function() {
	$( ".datepickPast" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		maxDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});	
<!--UI JQUERY DATE PICKER-->

</script>
<script language="javascript" type="text/javascript">
function validate(){
	if(document.frm.dated.value == ''){		
		document.frm.dated.focus();
		return false;
	}else{
		document.getElementById('lblname').innerHTML = "";
	}
	if(document.getElementById('comment').value == ''){
		document.getElementById('comment').focus();
		return false;
	}
}

function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

function getAdvance(){
	var course_id = document.getElementById('course_id').value;	
	document.location.href='search_advance.php?student_id='+<?php echo $_REQUEST["student_id"];?>+'&course_id='+course_id;
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
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTADD");?></td>
                <td width="22%" class="nametext1" ></td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="search.php"><input type="button" value="<?php echo constant("btn_back_btn");?>" class="btn2" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                    <td width="100%" class="amt_head" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTRECEIVE");?> <?php echo $val_student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                    <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                  <tr>
                    <td width="58%" align="center" valign="top" bgcolor="#EBEBEB">
                      
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="51%" height="50" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="30%" align="right" valign="middle" class="leftmenu">Course :&nbsp;</td>
                            <td width="70%" align="left" valign="middle">&nbsp;<select name="course_id" id="course_id" style="width:202px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="getAdvance();">
                              <option value="">Select Course</option>
                                <?php
									foreach($dbf->fetchOrder('student_course',"student_id='$student_id' And course_id > 0","") as $rescourse) {
										$crs = $dbf->strRecordID("course", "*", "id='$rescourse[course_id]'");
								?>
                                <option value="<?php echo $crs['id'];?>" <?php if($crs["id"] == $_REQUEST["course_id"]) {?> selected="" <?php } ?>><?php echo $crs['name'] ?></option>
                                <?php } ?>
                              </select></td>
                          </tr>
                        </table></td>
                        <td width="49%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#999999">
                          <tr class="mymenutext">
                            <td width="7%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">Sl</td>
                            <td width="25%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;Advance Date</td>
                            <td width="27%" align="right" valign="middle" bgcolor="#CCCCCC">Amount&nbsp;</td>
                            <td width="20%" align="center" valign="middle" bgcolor="#CCCCCC">Payment Type</td>
                            </tr>
                          <?php
						  $m = 1;
						  $is_advance_exist = $dbf->countRows("student_fees", "student_id='$student_id' And course_id='$course_id' And type='advance'");
						  foreach($dbf->fetchOrder('student_fees', "student_id='$student_id' And course_id='$course_id' And type='advance'" ,"") as $adv){
						  ?>
                          <tr>
                            <td height="22" align="center" valign="middle" class="mytext"><?php echo $m;?></td>
                            <td align="left" valign="middle" class="mytext">&nbsp;<?php echo $adv["paid_date"];?></td>
                            <td align="right" valign="middle" class="mytext">&nbsp;<?php echo $adv["paid_amt"];?> <?php echo $res_currency[symbol];?>&nbsp;</td>
                            <td align="center" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("common", "name", "id='$adv[payment_type]'");?></td>
                            </tr>
                          <?php $m++; } ?>
                          <?php if($is_advance_exist == 0){?>
                          <tr>
                            <td height="22" colspan="4" align="center" valign="middle" class="red_smalltext">No advance yet !!!</td>
                          </tr>
                          <?php } ?>
                        </table></td>
                        <td align="left" valign="top">
                        <?php if($_REQUEST["course_id"] != ""){?>
                        <form action="s1_process.php?action=advance" name="frm" method="post" id="frm" onSubmit="return validate();">
                        <table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                              <tr>
                                <td height="30" align="left" valign="middle">&nbsp;</td>
                                <td>&nbsp;<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>"></td>
                                <td width="7%">&nbsp;<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>"></td>
                                </tr>
                              <tr>
                                <td width="25%" height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?> :</span></td>
                                <td width="24%" align="left" valign="middle"><input name="dated" type="text" class="datepickFuture new_textbox100" readonly="" id="dated"/></td>
                                <td rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_FEES");?> :</span></td>
                                <td align="left" valign="middle">
                                <input name="amts" type="text"  class="new_textbox100" id="amts" onKeyPress="return isNumberKey(event);"/>
                                </td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_PAIDBY");?> : </span></td>
                                <td align="left" valign="middle"><span class="text_structure">
                                  <select name="payment_type" id="payment_type" style="width:102px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                    <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                    <option value="<?php echo $resp['id']?>" ><?php echo $resp['name'] ?></option>
                                    <?php } ?>
                                    </select>
                                  </span></td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("ADMIN_COMMNAME");?>:</td>
                                <td align="left" valign="middle"><textarea name="comment" id="comment" rows="5" cols="30" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" colspan="3" align="center" valign="middle">
                                  <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="6%" align="center" valign="middle">
                                        <script language="JavaScript" type="text/javascript">
										function showsms(val){
											if(val == "3"){
												document.getElementById('smsid').style.display = "block";
											}else{
												document.getElementById('smsid').style.display = "none";
											}
										}
				                    </script>
                                        <input name="sms" type="radio" id="radio" value="1" checked="checked" onChange="showsms(this.value)" /></td>
                                      <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onChange="showsms(this.value)" /></td>
                                      <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                                      <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <?php
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
										?>
                                      <td align="left" valign="middle" class="mytext">
                                        <table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                          <tr>
                                            <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table>
                                </td>
                                </tr>
                              </table>
                        </form>
                        <?php } ?>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      </table></td>
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
          </tr>
          <tr>
            <td height="90" bgcolor="#FFFFFF">&nbsp;</td>
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
                  <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="8%" align="right"><a href="search.php"><input type="button" value="<?php echo constant("btn_back_btn");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%" class="nametext1" ></td>
                      <td width="8%" align="left">&nbsp;</td>
                      
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTADD");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                  </tr>
                <tr>
                  <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" align="right" class="amt_head" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTRECEIVE");?> <?php echo $val_student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#EBEBEB">
                      
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="51%" height="50" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            
                            <td width="70%" align="right" valign="middle">&nbsp;<select name="course_id" id="course_id" style="width:202px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="getAdvance();">
                              <option value="">Select Course</option>
                                <?php
									foreach($dbf->fetchOrder('student_course',"student_id='$student_id' And course_id > 0","") as $rescourse) {
										$crs = $dbf->strRecordID("course", "*", "id='$rescourse[course_id]'");
								?>
                                <option value="<?php echo $crs['id'];?>" <?php if($crs["id"] == $_REQUEST["course_id"]) {?> selected="" <?php } ?>><?php echo $crs['name'] ?></option>
                                <?php } ?>
                              </select></td>
                              <td width="30%" align="left" valign="middle" class="leftmenu">&nbsp;: <?php echo ADMIN_GROUP_MANAGE_COURSE ?></td>
                          </tr>
                        </table></td>
                        <td width="49%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#999999">
                          <tr class="mymenutext">
                            <td width="20%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo ADMIN_PAYMENT_MANAGE_PAYMENTTYPE ?></td>
                            <td width="27%" align="right" valign="middle" bgcolor="#CCCCCC"><?php echo ADMIN_DASHBOARD_AMOUNT ?>&nbsp;</td>
                            <td width="25%" align="right" valign="middle" bgcolor="#CCCCCC"><?php echo $Arabic->en2ar('Advance Date');?>&nbsp;</td>
                            <td width="7%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo ADMIN_SMS_PARAMETER_TEMPLETE_SL_NO ?></td>
                            </tr>
                          <?php
						  $m = 1;
						  $is_advance_exist = $dbf->countRows("student_fees", "student_id='$student_id' And course_id='$course_id' And type='advance'");
						  foreach($dbf->fetchOrder('student_fees', "student_id='$student_id' And course_id='$course_id' And type='advance'" ,"") as $adv){
						  ?>
                          <tr>
                            <td align="center" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("common", "name", "id='$adv[payment_type]'");?></td>
                            <td align="left" valign="middle" class="mytext">&nbsp;<?php echo $adv["paid_amt"];?> <?php echo $res_currency[symbol];?>&nbsp;</td>
                            <td align="right" valign="middle" class="mytext"><?php echo $adv["paid_date"];?>&nbsp;</td>
                            <td height="22" align="center" valign="middle" class="mytext"><?php echo $m;?></td>
                            </tr>
                          <?php $m++; } ?>
                          <?php if($is_advance_exist == 0){?>
                          <tr>
                            <td height="22" colspan="4" align="center" valign="middle" class="red_smalltext"><?php echo $Arabic->en2ar('!!! No advance yet');?></td>
                          </tr>
                          <?php } ?>
                        </table></td>
                        <td align="left" valign="top">
                        <?php if($_REQUEST["course_id"] != ""){?>
                        <form action="s1_process.php?action=advance" name="frm" method="post" id="frm" onSubmit="return validate();">
                        <table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                              <tr>
                                <td height="30" align="left" valign="middle">&nbsp;</td>
                                <td>&nbsp;<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>"></td>
                                <td width="6%">&nbsp;<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>"></td>
                                </tr>
                              <tr>
                                <td width="73%" height="28" align="right" valign="middle">
                                  <input name="dated" type="text" class="datepickFuture new_textbox100" readonly="" id="dated"/></td>
                                <td width="21%" align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                                <td rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="middle"><input name="amts" type="text"  class="new_textbox100" id="amts" onKeyPress="return isNumberKey(event);"/></td>
                                <td align="left" valign="middle" class="leftmenu">: <?php echo constant("CD_SEARCH_INVOICE_FEES");?></td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="middle"><select name="payment_type2" id="payment_type2" style="width:102px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                    <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                    <option value="<?php echo $resp['id']?>" ><?php echo $resp['name'] ?></option>
                                    <?php } ?>
                                  </select></td>
                                <td align="left" valign="middle" class="leftmenu">: <?php echo constant("CD_SEARCH_INVOICE_PAIDBY");?>;</td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="top"><textarea name="comment2" id="comment2" rows="5" cols="30" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                                <td align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_COMMNAME");?></td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="left" valign="middle">&nbsp;</td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                <td align="left" valign="middle">&nbsp;</td>
                                <td>&nbsp;</td>
                                </tr>
                              <tr>
                                <td height="28" colspan="3" align="center" valign="middle">
                                  <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="6%" align="center" valign="middle">
                                        <script language="JavaScript" type="text/javascript">
										function showsms(val){
											if(val == "3"){
												document.getElementById('smsid').style.display = "block";
											}else{
												document.getElementById('smsid').style.display = "none";
											}
										}
				                    </script>
                                        <input name="sms" type="radio" id="radio" value="1" checked="checked" onChange="showsms(this.value)" /></td>
                                      <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onChange="showsms(this.value)" /></td>
                                      <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                                      <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <?php
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
										?>
                                      <td align="left" valign="middle" class="mytext">
                                        <table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                          <tr>
                                            <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table>
                                </td>
                                </tr>
                              </table>
                        </form>
                        <?php } ?>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      </table>
                      
                      </td>
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
                  </tr>
                <tr>
                  <td height="90" bgcolor="#FFFFFF">&nbsp;</td>
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
