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

$student_id = $_REQUEST["ids"];
$course_id = $_REQUEST["course_id"];

$res_fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[fee_id]'");
	
$paid_date = $res_fee["paid_date"];
$fee_amt = $res_fee["paid_amt"];
$payment_type = $res_fee["payment_type"];
$student_id = $res_fee["student_id"];
$course_id = $res_fee["course_id"];

$val_student = $dbf->strRecordID("student","*","id='$student_id'");
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

<script language="javascript" type="text/javascript">
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
	});});
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

function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

function add(){
	var x = document.getElementById('count').value;
	var z='div'+x;
	document.getElementById(z).style.display = "block";
	x++;
	
	document.getElementById('count').value = x;
}
function del(){
		
	var x = document.getElementById('count').value;

	if(x==6){
		alert("You can not delete default row.");
		return false;
	}
	x = x - 1;
	var z='div'+x;
	document.getElementById(z).style.display = "none";	
	document.getElementById('count').value = x;
}

function validate(){
	if(document.getElementById('comment').value == ''){
		document.getElementById('comment').focus();
		return false;
	}else{
		document.getElementById('lblname').innerHTML = "";
	}
}
function isNumberKey(evt){
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
                <td width="54%" height="30" class="logintext"><?php echo constant("PAYMENT_EDIT_HEADER");?></td>
                <td width="22%" class="nametext1" ></td>
                <td width="8%" align="left">&nbsp;</td>
                <?php
                if($_REQUEST['page'] == 'audit'){
					$page = 'audit_history.php';
				}else{
					$page = 'payment_history.php';
				}
				?>
                <td width="8%" align="left"><a href="<?php echo $page;?>?centre_id=<?php echo $_REQUEST[centre_id];?>">
                <input type="button" value="<?php echo constant("btn_back_btn");?>" class="btn2" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top"></td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px; border:solid 1px; border-color:#999;">
            <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
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
                    <form action="payment_history_process.php?action=edit_payment&fee_id=<?=$_REQUEST[fee_id];?>&centre_id=<?=$_REQUEST[centre_id];?>&student_id=<?=$_REQUEST[ids];?>&course_id=<?=$_REQUEST[course_id];?>" name="frm" method="post" id="frm" onSubmit="return validate();">
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
                          <td colspan="4" align="left" valign="middle">
                          <table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                            <tr>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td height="30" align="center" valign="bottom"></td>
                              <td width="7%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="25%" height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?> :</span></td>
                              <td width="31%" align="left" valign="middle">
                              <input name="dated" type="text" class="new_textbox100 datepick" value="<?php echo $paid_date;?>" id="dated" /></td>
                              <td width="36%" rowspan="3" align="center" valign="middle">&nbsp;</td>
                              <td colspan="2" rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_FEES");?> :</td>
                              <td align="left" valign="middle">
                              <input name="amts" type="text" class="new_textbox100" id="amts" value="<?php echo $fee_amt;?>" maxlength="10" onKeyPress="return isNumberKey(event);"/>&nbsp;<?php echo $res_currency[symbol];?></td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle"><span class="leftmenu">&nbsp;<?php echo constant("CD_SEARCH_INVOICE_PAIDBY");?> : </span></td>
                              <td align="left" valign="middle"><span class="text_structure">
                                <select name="payment_type" id="payment_type" style="width:102px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                  <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                  <option value="<?php echo $resp['id']?>" <?php if($resp["id"]==$payment_type) { ?> selected="" <?php } ?>><?php echo $resp['name'] ?></option>
                                  <?php } ?>
                                </select>
                              </span></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COMMNAME");?>:</td>
                              <td colspan="2" align="left" valign="middle">
                              <textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"><?php echo $comments;?></textarea></td>
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
                        <td align="left">
						<?php
					   	  //To Show Payment History
					      $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id' AND paid_date!='0000-00-00'");
						  if($num11 > 0){
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
                              <td align="left" valign="middle"><?php echo $res_payment_info[paid_amt];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                            </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?> :</td>
                              <td align="left" valign="middle"><?php echo $res_enter["user_name"];?></td>
                            </tr>
                          </table>
                          <?php } ?></td>
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