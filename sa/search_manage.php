<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])==''){
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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

$student_id = $_REQUEST['student_id'];
$course_id = $_REQUEST['course_id'];
$val_student = $dbf->strRecordID("student","*","id='$student_id'");
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
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
<script type="text/javascript" src="dropdowntabs.js"></script>

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]==''){
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
	$("#frm1").validationEngine()
});
</script>	
<!--JQUERY VALIDATION ENDS-->

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
</script>
<script type="text/javascript">
function show_payment(){
	var course = document.getElementById('course').value;
	var student_id = <?php echo $student_id;?>;
	
	if(course == ''){
		document.location.href='search_manage.php?student_id='+student_id;
	}else{
		document.location.href='search_manage.php?student_id='+student_id +"&course_id=" + course;
	}
}
</script>
<script language="javascript" type="text/javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
<script type="text/javascript">
function showtextbox(){
	 if(document.getElementById('trcomment').style.display == 'none'){
		 document.getElementById('trcomment').style.display = '';
	 }else if(document.getElementById('trcomment').style.display == ''){
		 document.getElementById('trcomment').style.display = 'none';
	 }
}
 
function gotfocus(){
  document.getElementById('course_fee').focus();
}

function checkDiscount(){	
	var discount = parseInt(document.getElementById('discount').value);
	var course_fee = parseInt(document.getElementById('course_fee').value);

	if(discount > 0){
		if(discount > course_fee){
			alert("Discount Amount should be less than Course Amount");
			document.getElementById('discount').value = 0;
		}
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-shadow: 5px 5px 5px #ccc;">
          <tr>
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="56%" height="30" class="logintext"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTADD");?></td>
                <td width="19%">&nbsp;</td>
                <td width="9%" align="left">&nbsp;</td>
                <td width="16%" align="center"><a href="search.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                    <td width="100%" class="amt_head" style="background:url(../images/left_mid_bg.png) repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="80%" align="left" valign="middle" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TOPTEXT");?></td>
                        <td width="20%" align="right" valign="middle"></td>
                      </tr>
                    </table></td>
                    <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                
                <script language="javascript" type="text/javascript">
				function chk(){
					if(document.getElementById('otheramt').value != '0'){
						if(document.getElementById('othertext').value == ''){
							alert("Enter comments for Other Amount");
							document.getElementById('othertext').focus();
							return false;
						}
					}
					var scount = document.getElementById('count').value;
					for(k = 1; k < scount; k++){
						
						var dt = "pdate"+k;
						dt = document.getElementById(dt).value;
						
						var s_price = "amt"+k;
						s_price = document.getElementById(s_price).value;
						
						if(dt != ''){
							if(s_price <= 0 || s_price == ''){
								alert("Enter Amount");
								//document.getElementById(s_price).focus();
								return false;
							}
						}
						if(s_price != ''){
							if(dt == ''){
								alert("Select Date");
								//document.getElementById(dt).focus();
								return false;
							}
						}
					}
				}
				</script>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                  <tr>
                    <td align="center" valign="top" bgcolor="#ffffff">
                    <form action="s1_process.php?action=search&amp;student_id=<?=$student_id;?>&amp;course_id=<?=$_REQUEST[course_id];?>" name="frm" method="post" id="frm" onSubmit="return chk();" >
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EBEBEB">
                        <tr>
                          <td width="2%">&nbsp;</td>
                          <td width="11%">&nbsp;</td>
                          <td width="42%">&nbsp;</td>
                          <td width="24%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <?php
                            if($val_student["photo"]!=''){
                                $photo = "photo/".$val_student["photo"];
                            }else{
                                $photo = "../images/noimage.jpg";
                            }						
							$res_grp = $dbf->strRecordID("student_group m,student_group_dtls d,student s","m.course_id","m.id=d.parent_id And s.id=d.student_id And s.id='$student_id' And m.status<>'Completed'");	
						  	$res_course = $dbf->strRecordID("course","*","id='$res_grp[course_id]'");						  
                            ?>
                          <td align="left" valign="top"><img src="<?php echo $photo;?>" width="100" height="100" oncontextmenu="return false;" /></td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top"><?php echo $dbf->VVIP_Icon($val_student["id"]);?></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" align="left" valign="top" class="lable1">&nbsp;<?php echo $val_student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" align="left" valign="top" class="mytext"><?php echo constant("STUDENT_MYACCOUNT_EMAIL");?> : <?php echo $val_student["email"];?></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" align="left" valign="top" class="mytext"><?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?> : <?php echo $val_student["student_mobile"];?></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="3"></td>
                          <td height="3" colspan="2" align="left" valign="top" class="mytext"></td>
                          <td></td>
                          <td align="left" valign="top"></td>
                        </tr>
                        <tr>
                          <td height="1"></td>
                          <td height="1" colspan="4" align="left" valign="top" bgcolor="#E2E6FE" class="mytext"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td height="30" colspan="2" align="left" valign="middle" bgcolor="#EBEBEB" class="mytext">&nbsp;</td>
                          <td bgcolor="#EBEBEB">&nbsp;</td>
                          <td align="left" valign="top" bgcolor="#EBEBEB">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td height="30" colspan="2" align="left" valign="middle" bgcolor="#EBEBEB" class="mytext">
                          
                          <table width="90%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="24%" align="right" valign="middle"><?php echo constant("SELECT_COURSE");?> :</td>
                              <td width="76%" align="left">
                              <select name="course" id="course" style="width:250px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                                <option value="">---Select---</option>
                                <?php
									foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
										$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
								  ?>
                                <option value="<?php echo $course['id'];?>" <?php if($_REQUEST[course_id]==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                                <?php } ?>
                              </select></td>
                            </tr>
                          </table></td>
                          <td bgcolor="#EBEBEB">&nbsp;</td>
                          <td align="left" valign="top" bgcolor="#EBEBEB">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="1"></td>
                          <td height="1" colspan="4" align="left" valign="top" bgcolor="#E2E6FE"></td>
                        </tr>
                        <?php														
							$val_student = $dbf->strRecordID("student","*","id='$student_id'");
							$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
							$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
						  ?>
                        <tr>
                          <td colspan="5" align="left" valign="top" style="padding-top:3px;">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0"  bgcolor="#EBEBEB">
                            <tr>
                              <td width="1%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td width="22%" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LEVELCOMPL");?> :</td>
                              <td width="0%">&nbsp;</td>
                              <td width="53%" align="left" valign="middle">
                              <select name="level" id="level" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" disabled="disabled" >
                                <option value=""></option>
                                <option value="1" <?php if($res_enroll["level_complete"]==1) { ?> selected="selected" <?php } ?>>Yes</option>
                                <option value="0" <?php if($res_enroll["level_complete"]==0) { ?> selected="selected" <?php } ?>>No</option>
                              </select></td>
                              <td width="24%" align="left" valign="middle"></td>
                            </tr>
                            <?php $course_fee = $dbf->getDataFromTable("course_fee","fees","course_id='$course_id' And status='1'"); ?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" ><input name="course_fee" type="text" class="new_textbox100" id="course_fee" value="<?php echo $course_fee;?>" readonly="readonly" /><?php echo $res_currency[symbol];?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?> :</td>
                              <td>&nbsp;</td>
                              <td colspan="2" rowspan="4" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="14%" height="28" align="left" valign="middle"><input name="discount" type="text" class="new_textbox100" id="discount" value="<?php echo $res_enroll["discount"];?>" onKeyPress="return isNumberKey(event);" onBlur="checkDiscount();"/></td>
                                  <td width="7%" align="left" valign="middle" class="mycon"><?php echo $res_currency[symbol];?></td>
                                  <td width="27%" align="left" valign="middle">&nbsp;</td>
                                  <td width="52%" rowspan="4" align="left" valign="top">
                                  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                    <?php			 
                                         $camt = $course_fees-$res_enroll["discount"]+$res_enroll["other_amt"];
                                         
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
                                </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle"><input name="otheramt" type="text" class="new_textbox100" id="otheramt" value="<?php echo $res_enroll["other_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
                                  <td align="left" valign="middle" class="mycon"><?php echo $res_currency[symbol];?></td>
                                  <td align="left" valign="middle"><input name="othertext" type="text" class="new_textbox190" id="othertext" value="<?php echo $res_enroll["othertext"];?>" /></td>
                                </tr>
                                <?php
								$opening_amt = $dbf->getDataFromTable('student_fees',"paid_amt","course_id='$course_id' And student_id='$student_id' And type='opening'");
								?>
                                <tr>
                                  <td height="28" align="left" valign="middle"><input name="payment" type="text" <?php if($opening_amt > 0){?> readonly="" <?php } ?> class="new_textbox100" id="payment" value="<?php echo $opening_amt;?>"  onKeyPress="return isNumberKey(event);"/></td>
                                  <td align="left" valign="middle" class="mycon"><?php echo $res_currency[symbol];?></td>
                                  <td align="left" valign="middle"><?php
								  $valno = $dbf->strRecordID("student_fees","MAX(id)","id <> (SELECT MAX(id) FROM student_fees WHERE student_id='$student_id') AND student_id='$student_id'");
								  $maxid = $valno["MAX(id)"];
								  
								  $valno = $dbf->strRecordID("student_fees","*","id='$maxid'");
								  $status = $valno["status"];
								
								$num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id'");
								$is_advance=$dbf->getDataFromTable('student_enroll',"discount","course_id='$course_id' And student_id='$student_id'");
								//if($num11 > 0 || $is_advance > 0 || $bal_amt <= 0) {
									if($course_id != '' && $student_id != ''){
									?>
								<a href="search_print_invoice.php?course_id=<?php echo $_REQUEST["course_id"];?>&amp;student_id=<?php echo $student_id;?>&amp;page=search_print_invoice.php&amp;TB_iframe=true&amp;height=600&amp;width=690&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
								  <input type="button" value="<?php echo constant("btn_prnt_inv_btn");?>" class="btn1" border="0" align="left" />
								  </a>
								<?php } ?></td>
                                </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle">
                                  <select name="ptype" id="ptype" class="validate[required]" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                    <option value="">---Select---</option>
                                    <?php
										foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                    <option value="<?php echo $resp['id'];?>" <?php if($resp["id"]==$res_enroll["payment_type"]) { ?> selected="selected" <?php } ?>><?php echo $resp['name'];?></option>
                                    <?php } ?>
                                  </select></td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_INITIPAY");?> : </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENTTYPE");?> : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="18" colspan="4" align="left" valign="top" class="leftmenu">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="22%" align="right" valign="middle" class="leftmenu"><?php echo constant("NOTE_FOR_INVOICE");?> : &nbsp;</td>
                                  <td width="78%" align="left" valign="middle"><input name="note" class="new_textbox690" type="text" id="note" value="<?php echo $res_enroll["invoice_note"];?>" /></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="18" colspan="4" align="left" valign="top" class="leftmenu">&nbsp;</td>
                            </tr>
                            <?php
                                //Check Initial Payment Amount  > 0 OR Payment Structure > 0
                                
                                //Get Structure of the Particular student with Course
                                $num_structure = $dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id'");                                
                                if($num_structure > 0){
                                ?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="18" colspan="4" align="left" valign="top" class="leftmenu"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="41%" height="25" align="left" valign="middle" bgcolor="#666666" class="logintext" >&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_GHTEXT");?></td>
                                  <td width="2%" bgcolor="#666666">&nbsp;</td>
                                  <td width="47%" bgcolor="#666666">&nbsp;</td>
                                  <td width="5%" align="center" valign="middle" bgcolor="#666666">&nbsp;</td>
                                  <td width="5%" align="center" valign="middle" bgcolor="#666666">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="18" colspan="4" align="left" valign="top" class="leftmenu"><table width="98%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                <tr>
                                  <td width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                                  <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                                  <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                                  <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                                  <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                                  <td width="11%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                                  <td width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_STATUS");?></td>
                                  <td width="6%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRINT");?></td>
                                  <td width="9%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENT");?></td>
                                  <td width="10%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext">
								  <?php echo constant("COMMON_ACTION");?></td>
                                </tr>
                                <?php                                    
                                    $j = 1;
                                    $fifo = $dbf->strRecordID("student_fees","*","course_id='$course_id' And student_id='$student_id' AND status='0' LIMIT 0,1");
                                    $fifo_id = $fifo["id"];
                                    
									//Get Course has been finished or not (If 0 = Not completed else Completed)
									$num_complete = $dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id And g.status='Completed' And g.course_id='$course_id' And d.student_id='$student_id'");
									
                                    foreach($dbf->fetchOrder('student_fees',"course_id='$course_id' And student_id='$student_id'","") as $vali) {
                                        
                                    $dt="";                                    
                                    $ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");                                    
                                    ?>
                                <tr>
                                  <td height="25" align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                                  <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                                  <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                                  <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                                  <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
                                  <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                                  <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
                                    &nbsp;&nbsp;</td>
                                  <td align="center" ><?php if($vali["paid_amt"]<=0) { ?>
                                    <img src="../images/block.png" width="16" height="16" title="Not Paid"/>
                                    <?php } else {?>
                                    <img src="../images/tick.png" width="16" height="16" title="Paid" />
                                    <?php }?></td>
                                  <td align="center" ><?php if($vali["paid_amt"]>0) { ?>
                                    <a href="search_print_challan_admission.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;fee_id=<?php echo $vali["id"];?>&amp;id=<?php echo $val_student["id"];?>&amp;page=search_print_challan_admission.php&amp;TB_iframe=true&amp;height=480&amp;width=675&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>" /></a>
                                    <?php } ?></td>
                                  <td align="center" >
                                    <?php
                                      //Check course_fees amount = paid amt
                                      if($vali["paid_amt"]!=$vali["fee_amt"]) {
										  
                                      	//FIFO Payment
                                       	//if($vali["id"]==$fifo_id) {
                                        
										//if course not completed
										if($num_complete == 0) {  
                                      ?>
                                    <a href="search_invoice.php?id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $_REQUEST[course_id];?>"><img src="../images/payment.png" width="16" height="16" border="0" title="Payment" /></a>
                                    <?php }}//} ?></td>
                                    
                                  <td align="center" >
                                    <?php
                                  if($vali["paid_amt"]=="0") {
									  
									  //if course not completed
								  		if($num_complete == 0) {
									  ?>
                                    <a href="s1_process.php?action=sch_del&amp;course_id=<?php echo $_REQUEST[course_id];?>&amp;ids=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>"> <img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                                    <?php }} ?></td>
                                </tr>
                                <?php $j++; } ?>
                              </table></td>
                            </tr>
                            <?php
                                }
								if($res_enroll["level_complete"]==0) {
                                ?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="50" colspan="4" align="left" valign="bottom" class="leftmenu"><table width="365" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="85%" height="25" align="left" valign="middle" bgcolor="#000033" class="logintext">&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TXT");?></td>
                                  <td width="7%" align="center" valign="middle" bgcolor="#000033"><img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/></td>
                                  <td width="8%" align="center" valign="middle" bgcolor="#000033"><img src="../images/minus1.png" width="18" height="18" onClick="del();"/></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="4" align="left" valign="middle" class="leftmenu"><table width="365" border="2" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                <tr>
                                  <td width="6%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="amt_head">&nbsp;</td>
                                  <td width="52%" align="left" valign="middle" bgcolor="#FF9900" class="pay_heading"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                                  <td width="30%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRICE");?></td>
                                  <td width="12%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td height="25" colspan="4" align="center" valign="middle"><div id="div1"> </div>
                                    <div style="clear:both;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate1" type="text" class="datepick new_textbox100" id="pdate1" readonly="readonly" size="45" minlength="4"/></td>
                                          <td width="30%" align="left" valign="middle"><input name="amt1" type="text" class="new_textbox100" id="amt1" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="20%" align="left" valign="middle">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div id="div2"> </div>
                                    <div style="clear:both;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate2" type="text" class="datepick new_textbox100" id="pdate2" readonly="readonly" size="45" minlength="4"/></td>
                                          <td width="30%" align="left" valign="middle"><input name="amt2" type="text" class="new_textbox100" id="amt2" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="20%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div id="div3"> </div>
                                    <div style="clear:both;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate3" type="text" class="datepick new_textbox100" id="pdate3" readonly="readonly" size="45" minlength="4"/></td>
                                          <td width="30%" align="left" valign="middle"><input name="amt3" type="text" class="new_textbox100" id="amt3" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="20%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div id="div4"> </div>
                                    <div style="clear:both;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate4" type="text" class="datepick new_textbox100" id="pdate4" size="45" readonly="readonly" minlength="4"/></td>
                                          <td width="30%" align="left" valign="middle"><input name="amt4" type="text" class="new_textbox100" id="amt4" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="20%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div id="div5"> </div>
                                    <div style="clear:both;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate5" type="text" class="datepick new_textbox100" id="pdate5" size="45" readonly="readonly" minlength="4"/></td>
                                          <td width="29%" align="left" valign="middle"><input name="amt5" type="text" class="new_textbox100" id="amt5" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="21%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <input name="count" type="hidden" id="count" value="6" />
                                    <?php for($i=6; $i<15;$i++){?>
                                    <div id="div<?php echo $i;?>" style="display:none;">
                                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                          <td width="5%">&nbsp;</td>
                                          <td width="45%" align="left" valign="middle"><input name="pdate<?php echo $i;?>" type="text" class="datepick new_textbox100" readonly="readonly" id="pdate<?php echo $i;?>" size="45" minlength="4"/></td>
                                          <td width="29%" align="left" valign="middle"><input name="amt<?php echo $i;?>" type="text" class="new_textbox100" id="amt<?php echo $i;?>" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                          <td width="21%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <?php } ?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <?php
								}
								?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="10" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_MATERIALRECI");?> : </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><table width="250" cellpadding="0" cellspacing="0">
                                <?php
                                    $x = 1;
                                    foreach($dbf->fetchOrder('common',"type='material type'","") as $resm) {
                                    $nn=$dbf->countRows('student_material',"course_id='$course_id' And student_id='$student_id' AND mate_id='$resm[id]'");
                                    ?>
                                <tr>
                                  <td width="20" align="left" valign="middle"><input type="checkbox" name="material<?php echo $x;?>" id="material<?php echo $x;?>" value="<?php echo $resm[id];?>" <?php if($nn>0) { ?> checked="checked" <?php } ?> /></td>
                                  <td width="228" align="left" valign="middle" class="mycon"><?php echo $resm[name];?></td>
                                </tr>
                                <?php $x++; } ?>
                                <input type="hidden" name="mcount" id="mcount" value="<?php echo $x-1;?>" />
                              </table></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT1");?> : </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="checkbox" name="web" id="web" value="1" <?php if($res_enroll["web"]==1) { ?> checked="checked" <?php } ?> /></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT2");?> : </td>
                              <td>&nbsp;</td>
                              <?php
                                //Check the progress generated has been added or not ?
                                $num_pr = $dbf->countRows('teacher_progress_course',"course_id='$course_id' And student_id='$student_id'");
                                ?>
                              <td align="left" valign="middle"><input type="checkbox" name="progress" id="progress" value="" disabled="disabled" <?php if($num_pr > 0) {?> checked="checked" <?php }?> /></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><label class="description" for="element_11"></label>
                                <span> </span><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT3");?> :</td>
                              <td></td>
                              <?php
								//Check the progress generated has been printed or not ?
								$num_ps = $dbf->countRows('teacher_progress_course',"print_status='1' And course_id='$course_id' And student_id='$student_id'");
								?>
                              <td align="left" valign="middle"><input name="prog_printed" id="prog_printed" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php }?>/>
                                <br /></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><label class="description" for="element_7"></label>
                                <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT4");?> : </td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><?php
                                    //Check the progress generated has been added or not ?
                                    $num_cg = $dbf->countRows('teacher_progress_certificate',"course_id='$course_id' And student_id='$student_id'");
                                    ?>
                                <input name="certificate" id="certificate" type="checkbox" value="" disabled="disabled" <?php if($num_cg > 0) {?> checked="checked" <?php } ?> /></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><label class="description" for="element_12"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT5");?> : </label></td>
                              <td>&nbsp;</td>
                              <?php
                                    //Check the progress generated has been printed or not ?
                                    $num_ps = $dbf->countRows('student_enroll',"certificate_collect='1' And course_id='$course_id' And student_id='$student_id'");
                                    ?>
                              <td align="left" valign="middle"><input name="certificate2" id="certificate2" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php } ?>/>
                                <br /></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_COMMENTS");?></label>
                                :</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle"><textarea name="textarea" id="textarea" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr style="display:none;">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle"><input type="button" value="<?php echo constant("btn_new_comments");?>" class="btn1" border="0" align="left" onClick="showtextbox();"/></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr id="trcomment" style="display:none">
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="top" class="leftmenu"><label class="description" for="element_7"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_NEWCOMMENT");?></label>
                                :</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left" valign="middle"><textarea name="newcomment" id="newcomment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">
							  <!--If course has been selected-->
							  <?php if($_REQUEST[course_id]!='') { ?>
                              
                              <!--If course has been not completed then SAVE button will be displayed-->
                              <?php
							  if($num_complete == 0) {
							  ?>
                                <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/>
                                <?php }} ?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>
                          </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </form></td>
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
            <td height="20" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
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
              <td width="79%" align="left" valign="top" style="box-shadow: 5px 5px 5px #ccc;">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" height="30" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                  <table width="100%" border="0" cellspacing="0">
              <tr>
              <td width="16%" align="center"><a href="search.php">
                    <input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" />
                  </a></td>
                  <td width="19%">&nbsp;</td>
                
                <td width="63%" height="30" class="logintext" align="right"><?php echo constant("CD_SEARCH_INVOICE_PAYMENTADD");?></td>
                <td width="2%" align="left">&nbsp;</td>
              </tr>
            </table>
                    </td>
                    
                  </tr>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                  </tr>
                <tr>
                  <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" class="amt_head" style="background:url(../images/left_mid_bg.png) repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="99%" align="right" valign="middle" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TOPTEXT");?></td>
                              <td width="1%" align="right" valign="middle"></td>
                              </tr>
                            </table></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top">
                        <script language="javascript" type="text/javascript">
						function chk(){
							if(document.getElementById('otheramt').value != '0'){
								if(document.getElementById('othertext').value == ''){
									alert("أدخل تعليق ل المبلغ أخرى");
									document.getElementById('othertext').focus();
									return false;
								}
							}
							var scount = document.getElementById('count').value;
							for(k = 1; k < scount; k++){
								
								var dt = "pdate"+k;
								dt = document.getElementById(dt).value;
								
								var s_price = "amt"+k;
								s_price = document.getElementById(s_price).value;
								
								if(dt != ''){
									if(s_price <= 0 || s_price == ''){
										alert("Enter Amount");
										//document.getElementById(s_price).focus();
										return false;
									}
								}
								if(s_price != ''){
									if(dt == ''){
										alert("Select Date");
										//document.getElementById(dt).focus();
										return false;
									}
								}
							}
						}
						</script>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;">
                          <tr>
                            <td align="center" valign="top" bgcolor="#ffffff">
                              <form action="s1_process.php?action=search&amp;student_id=<?=$student_id;?>&amp;course_id=<?=$_REQUEST[course_id];?>" name="frm" method="post" id="frm" onSubmit="return chk();" >
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EBEBEB">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <?php
								  
									if($val_student["photo"]!=''){
										$photo = "photo/".$val_student["photo"];
									}else{
										$photo = "../images/noimage.jpg";
									}							
									$res_grp = $dbf->strRecordID("student_group m,student_group_dtls d,student s","m.course_id","m.id=d.parent_id And s.id=d.student_id And s.id='$student_id' And m.status<>'Completed'");	
									$res_course = $dbf->strRecordID("course","*","id='$res_grp[course_id]'");
																		
									//Use currency
									$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
									$res_course = $dbf->strRecordID("course","*","id='$course_id'");
																
									$val_student = $dbf->strRecordID("student","*","id='$student_id'");
									$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
									$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
									$course_fee = $course_fees;
									?>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="15%" align="center" valign="middle"><?php echo $dbf->VVIP_Icon($student_id);?></td>
                                        <td width="70%" align="right" valign="middle"><img src="<?php echo $photo;?>" width="100" height="100" oncontextmenu="return false;" />                                        </td>
                                        <td width="10%" align="right" valign="middle"></td>
                                        <td width="5%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="leftmenu" style="padding-right:100px;"><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?> <?php echo $val_student["first_name"];?></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2" style="padding-right:100px;"><?php echo $val_student["email"];?> : <?php echo constant("STUDENT_MYACCOUNT_EMAIL");?></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2" style="padding-right:100px;"><?php echo $val_student["student_mobile"];?> : <?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2">
                                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="85%" height="30" align="right" valign="middle">
                                          <select name="course" id="course" style="width:250px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                                              <option value="">---<?php echo constant("SELECT");?>---</option>
                                              <?php
												foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
													$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
											  ?>
                                              <option value="<?php echo $course['id'];?>" <?php if($_REQUEST[course_id]==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                                              <?php } ?>
                                              </select></td>
                                          <td width="14%" align="left" class="leftmenu">: <?php echo constant("SELECT_COURSE");?></td>
                                          </tr>
                                        </table>
                                        </td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="3" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="20%">&nbsp;</td>
                                            <td width="20%" align="right" valign="middle">&nbsp;</td>
                                            <td width="20%" class="shop2">&nbsp;</td>
                                            <td width="29%" height="25" align="right" valign="middle">
                                            <select name="level" id="level" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" disabled="disabled" >
                                            <option value=""></option>
                                            <option value="1" <?php if($res_enroll["level_complete"]==1) { ?> selected="selected" <?php } ?>>Yes</option>
                                            <option value="0" <?php if($res_enroll["level_complete"]==0) { ?> selected="selected" <?php } ?>>No</option>
                                            </select>
                                            </td>
                                            <td width="11%" align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LEVELCOMPL");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td class="shop2">&nbsp;</td>
                                            <td height="25" align="right" valign="middle"><?php echo $res_currency[symbol];?>&nbsp;<input name="course_fee" type="text" class="new_textbox100_ar" id="course_fee" value="<?php echo $course_fee;?>" readonly="readonly" /></td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?></td>
                                          </tr>
                                          <tr>
                                            <td height="25" colspan="5" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td colspan="2" rowspan="4" align="left" valign="top" style="padding-left:20px;">
                                                <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                                <?php			 
												 $camt = $course_fees-$res_enroll["discount"]+$res_enroll["other_amt"];
												 
												 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
												 $feeamt = $fee["SUM(paid_amt)"];
												  
												 $bal_amt = $camt - $feeamt;
											
												//Use currency
												$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
												?>
                                                <tr>
                                                  
                                                  <td width="49%" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                                  <td width="51%" height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                                                  </tr>
                                                <tr>
                                                  
                                                  <td align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                                  <td height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> :</td>
                                                  </tr>
                                                <tr>
                                                  
                                                  <td align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                                  <td height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> :</td>
                                                  </tr>
                                                </table>
                                                </td>
                                                <td width="31%">&nbsp;</td>
                                                <td width="18%" height="25" align="right" valign="middle"><?php echo $res_currency[symbol];?>&nbsp;<input name="discount" type="text" class="new_textbox100_ar" id="discount" value="<?php echo $res_enroll["discount"];?>" onKeyPress="return isNumberKey(event);" onBlur="checkDiscount();"/></td>
                                                <td width="11%" align="left" valign="middle" class="leftmenu">: <?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></td>
                                              </tr>
                                              <tr>
                                                <td align="right"><input name="othertext" type="text" class="new_textbox190_ar" id="othertext" value="<?php echo $res_enroll["othertext"];?>" /></td>
                                                <td height="25" align="right" valign="middle"><input name="otheramt" type="text" class="new_textbox100_ar" id="otheramt" value="<?php echo $res_enroll["other_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
                                                <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                                              </tr>
                                              <tr>
                                                <td align="right" valign="middle">
                                                <?php
												  $valno = $dbf->strRecordID("student_fees","MAX(id)","id <> (SELECT MAX(id) FROM student_fees WHERE student_id='$student_id') AND student_id='$student_id'");
												  $maxid = $valno["MAX(id)"];
												  
												  $valno = $dbf->strRecordID("student_fees","*","id='$maxid'");
												  $status = $valno["status"];
													
												  $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id'");
													
												if($num11>0) { ?>
                                                <a href="search_print_invoice.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;student_id=<?php echo $student_id;?>&amp;page=search_print_invoice.php&amp;TB_iframe=true&amp;height=600&amp;width=690&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                                                  <input type="button" value="<?php echo constant("btn_prnt_inv_btn");?>" class="btn2" border="0" align="left" />
                                                  </a>
                                                <?php } ?>
                                                </td>
                                                <?php
												$opening_amt = $dbf->getDataFromTable('student_fees',"paid_amt","course_id='$course_id' And student_id='$student_id' And type='opening'");
												?>
                                                <td height="25" align="right" valign="middle"><input name="payment" type="text" class="new_textbox100_ar" id="payment" value="<?php echo $opening_amt;?>" <?php if($opening_amt > 0){?> readonly="" <?php } ?> onKeyPress="return isNumberKey(event);"/></td>
                                                <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_INITIPAY");?></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td height="25" align="right" valign="middle">
                                                <select name="ptype" id="ptype" class="validate[required]" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                                <option value="">---<?php echo constant("SELECT");?>---</option>
                                                <?php
													foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
												  ?>
                                                <option value="<?php echo $resp['id'];?>" <?php if($resp["id"]==$res_enroll["payment_type"]) { ?> selected="selected" <?php } ?>><?php echo $resp['name'];?></option>
                                                <?php } ?>
                                                </select>
                                                </td>
                                                <td align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENTTYPE");?></td>
                                              </tr>
                                            </table></td>
                                            </tr>
                                          <tr>
                                            <td height="25" colspan="5" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                
                                                <td width="89%" align="right" valign="middle">
                                                  <input name="note2" class="new_textbox690_ar" type="text" id="note2" value="<?php echo $res_enroll["invoice_note"];?>" /></td>
                                                  <td width="11%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("NOTE_FOR_INVOICE");?></td>
                                              </tr>
                                            </table></td>
                                            </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td class="shop2">&nbsp;</td>
                                            <td height="25" align="right" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          </tr>
                                          
                                          <tr>
                                            <td height="25" colspan="5" align="right" valign="middle">
                                            <table width="98%" border="0" cellspacing="0" cellpadding="0">
                                            <?php
											//Check Initial Payment Amount  > 0 OR Payment Structure > 0
											
											//Get Structure of the Particular student with Course
											$num_structure = $dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id'");
											
											if($num_structure > 0){ ?>
                                            <tr>                                              
                                              <td width="2%" bgcolor="#666666">&nbsp;</td>
                                              <td width="47%" bgcolor="#666666">&nbsp;</td>
                                              <td width="41%" height="25" align="right" valign="middle" bgcolor="#666666" class="logintext"> <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_GHTEXT");?>&nbsp;</td>
                                              </tr>
                                            </table>
                                            </td>
                                            </tr>
                                          <tr>
                                            <td height="25" colspan="5" align="right" valign="middle">
                                            <table width="98%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr>
                      <td align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("COMMON_ACTION");?></td>
                      <td width="9%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENT");?></td>
                      <td width="6%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRINT");?></td>
                      <td width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_STATUS");?></td>
                      <td width="11%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                      <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                      <td width="13%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                      <td width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                      </tr>
						<?php											
                        $j = 1;
                        $fifo = $dbf->strRecordID("student_fees","*","course_id='$course_id' And student_id='$student_id' AND status='0' LIMIT 0,1");
                        $fifo_id = $fifo["id"];
                        
                        //Get Course has been finished or not (If 0 = Not completed else Completed)
                        $num_complete = $dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id And g.status='Completed' And g.course_id='$course_id' And d.student_id='$student_id'");
                        
                        foreach($dbf->fetchOrder('student_fees',"course_id='$course_id' And student_id='$student_id'","") as $vali) {												
                        $dt="";											
                        $ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");
                        if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; }											
                        ?>
                        <tr>
                            <td align="center" >
                              <?php
                    		if($vali["paid_amt"]=="0") {
								
								  //if course not completed
									if($num_complete == 0) {
								  ?>
                              <a href="s1_process.php?action=sch_del&amp;course_id=<?php echo $_REQUEST[course_id];?>&amp;ids=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>"> <img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                              <?php }} ?></td>
                                    <td align="center" >
                                      <?php
										  //Check course_fees amount = paid amt
										  if($vali["paid_amt"]!=$vali["fee_amt"]) {
                                                                              
											//if course not completed
											if($num_complete == 0) {  
                                      		?>
                                      <a href="search_invoice.php?id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $_REQUEST[course_id];?>"><img src="../images/payment.png" width="16" height="16" border="0" title="Payment" /></a>
                                      <?php }} ?></td>
                                                <td align="center" ><?php if($vali["paid_amt"]>0) { ?>
                                                <a href="search_print_challan_admission.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;fee_id=<?php echo $vali["id"];?>&amp;id=<?php echo $val_student["id"];?>&amp;page=search_print_challan_admission.php&amp;TB_iframe=true&amp;height=480&amp;width=675&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>" /></a>
                                                <?php } ?></td>
                                                <td align="center" ><?php if($vali["paid_amt"]<=0) { ?>
                                                <img src="../images/block.png" width="16" height="16" title="Not Paid"/>
                                                <?php } else {?>
                                                <img src="../images/tick.png" width="16" height="16" title="Paid" />
                                                <?php }?></td>
                                                <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>&nbsp;&nbsp;</td>
                                                <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                                                <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                                                <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                                                <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                                                <td height="25" align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                                              </tr>
                                            <?php $j++; } ?>
                                            </table>
                                            </td>
                                          </tr>
                                          
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td class="shop2">&nbsp;</td>
                                            <td height="5" align="right" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          </tr>
                                          
                                          <?php } if($res_enroll["level_complete"]==0) { ?>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td height="25" colspan="2" align="right" valign="middle" class="shop2">
                                            <table width="365" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="85%" height="25" align="left" valign="middle" bgcolor="#000033" class="logintext">&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TXT");?></td>
                                              <td width="7%" align="center" valign="middle" bgcolor="#000033"><img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/></td>
                                              <td width="8%" align="center" valign="middle" bgcolor="#000033"><img src="../images/minus1.png" width="18" height="18" onClick="del();"/></td>
                                              </tr>
                                            </table>
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          </tr>                                          
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td height="25" colspan="2" align="right" valign="middle" class="shop2">
                                            <table width="365" border="2" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                            <tr>
                                              <td width="6%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="amt_head">&nbsp;</td>
                                              <td width="52%" align="left" valign="middle" bgcolor="#FF9900" class="pay_heading">
											  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                                              <td width="30%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading">
											  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRICE");?></td>
                                              <td width="12%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td height="25" colspan="4" align="center" valign="middle"><div id="div1"> </div>
                                                <div style="clear:both;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate1" type="text" class="datepick new_textbox100_ar" id="pdate1" readonly="readonly" size="45" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt1" type="text" class="new_textbox100_ar" id="amt1" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <div id="div2"> </div>
                                                <div style="clear:both;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate2" type="text" class="datepick new_textbox100_ar" id="pdate2" readonly="readonly" size="45" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt2" type="text" class="new_textbox100_ar" id="amt2" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <div id="div3"> </div>
                                                <div style="clear:both;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate3" type="text" class="datepick new_textbox100" id="pdate3" readonly="readonly" size="45" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt3" type="text" class="new_textbox100" id="amt3" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <div id="div4"> </div>
                                                <div style="clear:both;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate4" type="text" class="datepick new_textbox100" id="pdate4" size="45" readonly="readonly" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt4" type="text" class="new_textbox100" id="amt4" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <div id="div5"> </div>
                                                <div style="clear:both;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate5" type="text" class="datepick new_textbox100" id="pdate5" size="45" readonly="readonly" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt5" type="text" class="new_textbox100" id="amt5" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <input name="count" type="hidden" id="count" value="6" />
                                                <?php for($i=6; $i<15;$i++){?>
                                                <div id="div<?php echo $i;?>" style="display:none;">
                                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                      <td width="5%">&nbsp;</td>
                                                      <td width="45%" align="left" valign="middle"><input name="pdate<?php echo $i;?>" type="text" class="datepick new_textbox100" readonly="readonly" id="pdate<?php echo $i;?>" size="45" minlength="4"/></td>
                                                      <td width="31%" align="left" valign="middle"><input name="amt<?php echo $i;?>" type="text" class="new_textbox100" id="amt<?php echo $i;?>" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                                      <td width="19%" align="left">&nbsp;<?php echo $res_currency[symbol];?></td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                <?php } ?></td>
                                              </tr>
                                            </table>
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          </tr>
                                          <?php } ?>
                                        </table></td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="4" align="right" valign="middle">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="33%">&nbsp;</td>
                                            <td width="49%" height="22" align="right" valign="middle" class="shop2">
                                            <table width="250" align="right" cellpadding="0" cellspacing="0">
                                            <?php
											$x = 1;
											foreach($dbf->fetchOrder('common',"type='material type'","") as $resm) {
											$nn=$dbf->countRows('student_material',"course_id='$course_id' And student_id='$student_id' AND mate_id='$resm[id]'");
											?>
                                            <tr>                                              
                                              <td width="228" align="right" valign="middle" class="mycon"><?php echo $resm[name];?></td>
                                              <td width="20" align="left" valign="middle"><input type="checkbox" name="material<?php echo $x;?>" id="material<?php echo $x;?>" value="<?php echo $resm[id];?>" <?php if($nn>0) { ?> checked="checked" <?php } ?> /></td>
                                              </tr>
                                            <?php $x++; } ?>
                                            <input type="hidden" name="mcount" id="mcount" value="<?php echo $x-1;?>" />
                                            </table>
                                            </td>
                                            <td width="18%" align="left" valign="top" class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_MATERIALRECI");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle"><input type="checkbox" name="web" id="web" value="1" <?php if($res_enroll["web"]==1) { ?> checked="checked" <?php } ?> /></td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT1");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">
                                            <?php
											//Check the progress generated has been added or not ?
											$num_pr = $dbf->countRows('teacher_progress_course',"course_id='$course_id' And student_id='$student_id'");
											?>
                                		<input type="checkbox" name="progress" id="progress" value="" disabled="disabled" <?php if($num_pr > 0) {?> checked="checked" <?php }?> />
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT2");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">
											  <?php
                                              //Check the progress generated has been printed or not ?
											$num_ps = $dbf->countRows('teacher_progress_course',"print_status='1' And course_id='$course_id' And student_id='$student_id'");
											?>
                                    		<input name="prog_printed" id="prog_printed" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php }?>/>
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT3");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">
                                            <?php
											//Check the progress generated has been added or not ?
											$num_cg = $dbf->countRows('teacher_progress_certificate',"course_id='$course_id' And student_id='$student_id'");
											?>
                                            <input name="certificate" id="certificate" type="checkbox" value="" disabled="disabled" <?php if($num_cg > 0) {?> checked="checked" <?php } ?> />
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT4");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">
                                            <?php
											//Check the progress generated has been printed or not ?
											$num_ps = $dbf->countRows('student_enroll',"certificate_collect='1' And course_id='$course_id' And student_id='$student_id'");
											?>
                                    		<input name="certificate2" id="certificate2" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php } ?>/>
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT5");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">
                                            <textarea name="textarea" id="textarea" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; text-align:right;"></textarea>
                                            </td>
                                            <td align="left" valign="middle" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_COMMENTS");?></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="22" align="right" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle" class="leftmenu"> </td>
                                          </tr>
                                          <tr>
                                            <td align="center" valign="middle">
                                            <!--If course has been selected-->
                                            <?php if($_REQUEST[course_id]!='') { ?>
                                            
                                            <!--If course has been not completed then SAVE button will be displayed-->
                                            <?php					  							  
											  if($num_complete == 0) {
											  ?>
                                            <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/>
                                            <?php }} ?>
                                            </td>
                                            <td height="22" align="right" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                          </tr>
                                        </table>
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" valign="middle" class="shop2">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table></td>
                                    </tr>                                  
                                  </table>
                                </form></td>
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
                  <td height="20" bgcolor="#FFFFFF">&nbsp;</td>
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
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>
