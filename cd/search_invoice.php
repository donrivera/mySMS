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

$val_student = $dbf->strRecordID("student","*","id='$_REQUEST[id]'");
$res_fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'");

$student_id = $_REQUEST[id];
$course_id = $res_fee[course_id];

$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
$res_course = $dbf->strRecordID("course","*","id='$course_id'");
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

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
function validate()
{
	if(document.frm.dated.value == '')
	{		
		document.frm.dated.focus();
		return false;
	}
	else
	{
		document.getElementById('lblname').innerHTML = "";
	}
}
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
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
                <td width="8%" align="left"><a href="search_manage.php?id=<?php echo $_REQUEST[id];?>&course_id=<?php echo $_REQUEST[course_id];?>"><input type="button" value="<?php echo constant("btn_back_btn");?>" class="btn2" border="0" align="left" /></a></td>
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
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                  <tr>
                    <td width="58%" align="center" valign="top" bgcolor="#EBEBEB">
                    <form action="s1_process.php?action=invoice&id=<?=$_REQUEST[id];?>&amp;schid=<?=$_REQUEST[schid];?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                      <?php $val = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'"); ?>
                      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td width="4%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="24%">&nbsp;</td>
                          <td width="50%"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="4" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="4" align="left" valign="middle"><table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td height="30" align="center" valign="bottom"><span class="lable1"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></span></td>
                              <td width="7%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="25%" height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?> :</span></td>
                              <td width="24%" align="left" valign="middle"><input name="dated" type="text" class="datepickFuture new_textbox100" readonly="" id="dated" size="45" minlength="4"/></td>
                              <td width="43%" rowspan="3" align="center" valign="middle"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                <?php			 
								 $camt = $course_fees - $res_enroll["discount"] + $res_enroll["other_amt"];
								 
								 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								 $feeamt = $fee["SUM(paid_amt)"];
								  
								 $bal_amt = $camt - $feeamt;
							
								 //Use currency
								 $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
								 ?>
                                <tr>
                                  <td width="62%" height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                                  <td width="38%" align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                                <tr>
                                  <td height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> :</td>
                                  <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                                <tr>
                                  <td height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> :</td>
                                  <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                              </table></td>
                              <td colspan="2" rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_FEES");?> :</span></td>
                              <td align="left" valign="middle">
                              <input name="amt" type="amts"  class="new_textbox100" id="amts" size="45" minlength="4" value="<?php echo $val["fee_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
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
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COMMNAME");?>:</td>
                              <td colspan="2" align="left" valign="middle"><textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="10" colspan="5" align="left" valign="middle"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/>
                            <a href="search_print_invoice.php?id=<?php echo $val["id"];?>&page=search_print_invoice.php&amp;TB_iframe=true&amp;height=420&amp;width=375&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"></a></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="5" align="left" valign="middle"></td>
                        </tr>
                      </table>
                    </form></td>
                    <td width="42%" align="center" valign="top" bgcolor="#EBEBEB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="35">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="35">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><?php 
					   //To Show Payment Hstory
					      $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id' AND paid_date!='0000-00-00'");
						  if($num11>=1)
						  {
					   ?>
                          <table width="80%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                            <?php
								$res_payment = $dbf->strRecordID("student_fees","MAX(id)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								$lastpaymnt=$res_payment["MAX(id)"];
								$res_payment_info= $dbf->strRecordID("student_fees","*","id='$lastpaymnt'");
								$res_enter= $dbf->strRecordID("user","*","id='$res_payment_info[created_by]'");
						  		?>
                            <tr>
                              <td height="25" colspan="2" align="left" valign="middle" class="mymenutext"><?php echo constant("LAST_PAYMENT_HISTORY");?></td>
                            </tr>
                            <tr>
                              <td width="38%" height="25" align="left" valign="middle" class="pedtext"><?php echo constant("PAYMENT_DATE");?> :</td>
                              <td width="62%" align="left" valign="middle"><?php echo $res_payment_info[fee_date]?></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("LAST_PAYMENT");?> :</td>
                              <td align="left" valign="middle"><?php echo $res_payment_info[paid_date];?></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> :</td>
                              <td align="left" valign="middle"><?php echo $res_payment_info[paid_amt];?> <?php echo $res_currency[symbol];?></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?> :</td>
                              <td align="left" valign="middle"><?php echo $res_enter["user_name"];?></td>
                            </tr>
                          </table>
                          <?php }?></td>
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
                      <td width="8%" align="right"><a href="search_manage.php?id=<?php echo $_REQUEST[id];?>&course_id=<?php echo $_REQUEST[course_id];?>"><input type="button" value="<?php echo constant("btn_back_btn");?>" class="btn2" border="0" align="left" /></a></td>
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
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td width="58%" align="center" valign="top" bgcolor="#EBEBEB">
                            <form action="s1_process.php?action=invoice&id=<?=$_REQUEST[id];?>&amp;schid=<?=$_REQUEST[schid];?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                              <?php $val = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'"); ?>
                              <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" >
                                <tr>
                                  <td width="4%">&nbsp;</td>
                                  <td width="21%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="24%">&nbsp;</td>
                                  <td width="50%"></td>
                                  </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="4" align="left" valign="middle"><table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                                    <tr>
                                      <td align="left" valign="middle">&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td height="30" align="center" valign="bottom"><span class="lable1"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></span></td>
                                      <td width="7%">&nbsp;</td>
                                      <td width="1%">&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td width="25%" height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?> :</span></td>
                                      <td width="24%" align="left" valign="middle"><input name="dated" type="text" class="datepickFuture new_textbox100_ar" readonly="" id="dated" size="45" minlength="4"/></td>
                                      <td width="43%" rowspan="3" align="center" valign="middle"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                        <?php
										 $camt = $course_fees - $res_enroll["discount"] + $res_enroll["other_amt"];
										 
										 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
										 $feeamt = $fee["SUM(paid_amt)"]+$res_enroll["ob_amt"];
										  
										 $bal_amt = $camt - $feeamt;
									
										//Use currency
										$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
										?>
                                        <tr>
                                          <td width="49%" height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon"><?php echo $res_currency[symbol];?><?php echo $camt;?></td>
                                          <td width="51%" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">: <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?></td>
                                          </tr>
                                        <tr>
                                          <td height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon"><?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                          <td align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">: <?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
                                          </tr>
                                        <tr>
                                          <td height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                          <td align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">: <?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></td>
                                          </tr>
                                        </table></td>
                                      <td colspan="2" rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_FEES");?> :</span></td>
                                      <td align="left" valign="middle">
                                        <input name="amt" type="amts"  class="new_textbox100_ar" id="amts" size="45" minlength="4" value="<?php echo $val["fee_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
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
                                      <td>&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COMMNAME");?>:</td>
                                      <td colspan="2" align="left" valign="middle"><textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; text-align:right; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      </tr>
                                    <tr>
                                      <td height="28" align="left" valign="middle">&nbsp;</td>
                                      <td align="left" valign="middle">&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="5" align="left" valign="middle"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/>
                                    <a href="search_print_invoice.php?id=<?php echo $val["id"];?>&page=search_print_invoice.php&amp;TB_iframe=true&amp;height=420&amp;width=375&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"></a></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="5" align="left" valign="middle"></td>
                                  </tr>
                                </table>
                              </form></td>
                          <td width="42%" align="center" valign="top" bgcolor="#EBEBEB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="35">&nbsp;</td>
                              </tr>
                            <tr>
                              <td width="35">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left"><?php 
							   //To Show Payment Hstory
							  $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id' AND paid_date!='0000-00-00'");
							  if($num11>=1){ ?>
                                <table width="80%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                  <?php
								$res_payment = $dbf->strRecordID("student_fees","MAX(id)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								$lastpaymnt=$res_payment["MAX(id)"];
								$res_payment_info= $dbf->strRecordID("student_fees","*","id='$lastpaymnt'");
								$res_enter= $dbf->strRecordID("user","*","id='$res_payment_info[created_by]'");
						  		?>
                                  <tr>
                                    <td height="25" colspan="2" align="left" valign="middle" class="mymenutext"><?php echo constant("LAST_PAYMENT_HISTORY");?></td>
                                    </tr>
                                  <tr>
                                    <td width="38%" height="25" align="right" valign="middle"><?php echo $res_payment_info[fee_date]?></td>
                                    <td width="62%" align="left" valign="middle" class="pedtext"><?php echo constant("PAYMENT_DATE");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle"><?php echo $res_payment_info[paid_date];?></td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("LAST_PAYMENT");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle"><?php echo $res_payment_info[paid_amt];?></td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle"><?php echo $res_enter["user_name"];?></td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?></td>
                                    </tr>
                                  </table>
                                <?php } else{?>
                                <table width="80%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                  <?php
									$res_std = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
									?>
                                  <tr>
                                    <td height="25" colspan="2" align="left" valign="middle" class="mymenutext"><?php echo constant("LAST_PAYMENT_HISTORY");?></td>
                                    </tr>
                                  <tr>
                                    <td width="38%" height="25" align="right" valign="middle"><?php echo $res_std[payment_date]?></td>
                                    <td width="62%" align="left" valign="middle" class="pedtext"><?php echo constant("PAYMENT_DATE");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle"><?php echo $res_std[payment_date];?></td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("LAST_PAYMENT");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle"><?php echo $res_std[ob_amt];?></td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle">
									<?php
									  $res_user = $dbf->strRecordID("user","*","id='$res_std[created_by]'");
									  echo $res_user["user_name"];
									  ?>
                          			</td>
                                    <td align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?></td>
                                    </tr>
                                  </table>
                                <?php }?></td>
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
