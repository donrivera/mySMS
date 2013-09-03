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
require '../I18N/Arabic.php';
include("../includes/saudismsNET-API.php");

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
$course_id =  $_REQUEST['course_id'];

if($_REQUEST['action']=='sch_del'){
	$dbf->deleteFromTable("student_fees","id='$_REQUEST[schid]'");	
	header("Location:single-payment.php?student_id=$student_id&course_id=$course_id");
}

if($_REQUEST['action']=='search'){
	
	//Current date and time
	$dt = date('Y-m-d h:m:s');
	
	//Current date and time
	$c_dt = date('Y-m-d');
	
	//Get data from student_enroll for checking the whether initial fee has been changed or not
	$res_en = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");	
	
	$string="other_amt='$_POST[otheramt]',othertext='$_POST[othertext]',web='$_POST[web]',discount='$_POST[discount]'";
	$dbf->updateTable("student_enroll",$string,"course_id='$course_id' And student_id='$student_id'");
	
	//For record the previous data with current data if any changes with the any field
	if($res_en[other_amt] != $_POST[otheramt]){
		
		$string2="fld_name='Other Amount',chg_from='$res_en[other_amt]',chg_to='$_POST[otheramt]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);
	}
	
	if($res_en[payment_type] != $_POST[ptype]){
		
		$res_com_from = $dbf->strRecordID("common","*","id='$res_en[payment_type]'");
		$res_com_to = $dbf->strRecordID("common","*","id='$_REQUEST[payment_type]'");
		
		$string2="fld_name='Payment Type',chg_from='$res_com_from[name]',chg_to='$res_com_to[name]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";
		
		$dbf->insertSet("student_fee_edit_history",$string2);		
	}
	
	if($res_en[discount] != $_POST[discount]){
		
		$string2="fld_name='Discount  Amount',chg_from='$res_en[discount]',chg_to='$_POST[discount]',by_user='$_SESSION[id]',date_time='$dt',student_id='$student_id',centre_id='$_SESSION[centre_id]',create_date='$c_date'";		
		$dbf->insertSet("student_fee_edit_history",$string2);		
	}
	//=================================================================================
	
	
	//insert into student_comment table	
	$newcomment=mysql_real_escape_string($_POST[newcomment]);
	if($newcomment!=''){
		$string2="student_id='$student_id',user_id='$_SESSION[id]',comments='$newcomment',date_time='$dt'";
		$dbf->insertSet("student_comment",$string2);
	}
	
	//Delete from student material table
	$dbf->deleteFromTable("student_material","course_id='$course_id' And student_id='$student_id'");
	
	//Insert in student material table
	//---------------------------------------------------
	$totrow_cont = $_REQUEST['mcount'];

	for($i=1; $i<=$totrow_cont;$i++){
		$name = "material".$i;
		$name = $_REQUEST[$name];
		
		if($name != ""){
			$string="student_id='$student_id',course_id='$course_id',mate_id='$name'";
			$dbf->insertSet("student_material",$string);
		}
	}
	//----------------------------------------------------
	
	//Insert in student course_fees table
	$tot = $_REQUEST['count'];

	for($k=1; $k<=$tot;$k++){
		$name = "pdate".$k;
		$name = $_REQUEST[$name];
		
		$amt = "amt".$k;
		$amt = $_REQUEST[$amt];
		
		if($name != "" && $amt != ""){
		$string="student_id='$student_id',course_id='$course_id',fee_date='$name',fee_amt='$amt',created_date='$dt',created_by='$_SESSION[id]',centre_id='$_SESSION[centre_id]'";
			$dbf->insertSet("student_fees",$string);
		}
	}
	//----------------------------------------------------
	
	header("Location:single-payment.php?student_id=$student_id&course_id=$course_id");
	exit;
}
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
</script>
<!--UI JQUERY DATE PICKER-->

<script type="text/javascript">
function show_payment(){
	var course = document.getElementById('course').value;
	var student_id = <?php echo $student_id;?>;
	
	if(course == ''){
		document.location.href='single-payment.php?student_id='+student_id;
	}else{
		document.location.href='single-payment.php?student_id='+student_id +"&course_id=" + course;
	}
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

	if(x==2){
		alert("You can not delete default row.");
		return false;
	}
	x = x - 1;
	var z='div'+x;
	document.getElementById(z).style.display = "none";	
	document.getElementById('count').value = x;
}

function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}
</script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />
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
<?php if ($_SESSION[lang] == "EN") { ?>
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
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
		
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
              </tr>
              <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
              <tr>
                <td>&nbsp;</td>
                
                <td colspan="2" align="left" valign="top">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="25%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> :</td>
                    <td width="75%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <?php if($student["student_id"] > 0){?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4" align="left" valign="top">
                <form id="frm" name="frm" method="post" action="single-payment.php?action=search&student_id=<?=$student_id;?>&course_id=<?=$course_id;?>">
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td height="30" colspan="2" align="left" valign="middle" class="mytext"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="26%" align="left" valign="middle" class="pedtext"><?php echo constant("SELECT_COURSE");?> :</td>
                        <td width="74%" align="left">
                        <select name="course" id="course" style="width:200px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
                          <option value="">---Select---</option>
                          <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                          <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                          <?php } ?>
                        </select></td>
                      </tr>
                    </table></td>
                    <td width="27%">&nbsp;</td>
                    <td width="18%" align="center" valign="top"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
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
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="1%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td width="24%" height="28" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LEVELCOMPL");?> :</td>
                        <td width="1%">&nbsp;</td>
                        <td width="36%" align="left" valign="middle" class="mytext">
                        <?php if($res_enroll["level_complete"]==1) { ?> Yes <?php }else{?> No <?php } ?>
                        </td>
                        <td width="38%" rowspan="2" align="center" valign="middle">&nbsp;</td>
                        </tr>
                      <?php
						$res_course = $dbf->strRecordID("course","*","id='$course_id'");
						$course_fee = $course_fees;
						?>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle" class="mytext" ><input name="course_fee" type="text" class="new_textbox100" id="course_fee" value="<?php echo $course_fee;?>" readonly="readonly" /></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?> :</td>
                        <td>&nbsp;</td>
                        <td colspan="2" rowspan="4" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="17%" height="28" align="left" valign="middle" class="mytext"><input name="discount" type="text" class="new_textbox100" id="discount" value="<?php echo $res_enroll["discount"];?>" onKeyPress="return isNumberKey(event);" onBlur="checkDiscount();"/></td>
                            <td width="30%" align="left" valign="middle">&nbsp;</td>
                            <td width="53%" rowspan="4" align="left" valign="top">
                            <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                              <?php			 
								 $camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
								 
								 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								 $feeamt = $fee["SUM(paid_amt)"];
								  
								 $bal_amt = $camt - $feeamt;
							
								//Use currency
								$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
								?>
                              <tr>
                                <td width="62%" height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                                <td width="38%" align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                              <tr>
                                <td height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> :</td>
                                <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                              <tr>
                                <td height="25" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> :</td>
                                <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><input name="otheramt" type="text" class="new_textbox100" id="otheramt" value="<?php echo $res_enroll["other_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
                            <td align="left" valign="middle"><input name="othertext" type="text" class="new_textbox190" id="othertext" value="<?php echo $res_enroll["othertext"];?>" /></td>
                          </tr>
                          <?php
						  $opening_amt = $dbf->getDataFromTable('student_fees',"paid_amt","course_id='$course_id' And student_id='$student_id' And type='opening'");
						  ?>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><input name="payment" type="text" class="new_textbox100" id="payment" value="<?php echo $opening_amt;?>"  maxlength="20" onKeyPress="return isNumberKey(event);"/></td>
                            <td align="center" valign="middle">
                              <?php
							  $valno = $dbf->strRecordID("student_fees","MAX(id)","id <> (SELECT MAX(id) FROM student_fees WHERE student_id='$student_id') AND student_id='$student_id'");
							  $maxid = $valno["MAX(id)"];							  
							  $valno = $dbf->strRecordID("student_fees","*","id='$maxid'");
							  $status = $valno["status"];								
							  $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id'");
								
							if($num11>0) { ?>
                              <a href="search_print_invoice.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;student_id=<?php echo $student_id;?>&amp;page=search_print_invoice.php&amp;TB_iframe=true&amp;height=600&amp;width=690&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                                <input type="button" value="<?php echo constant("btn_prnt_inv_btn");?>" class="btn1" border="0" align="left" />
                                </a>
                              <?php } ?></td>
                            </tr>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><select name="ptype" id="ptype" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                              <option>---Select---</option>
                                <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
								  ?>
                                <option value="<?php echo $resp['id'];?>" <?php if($resp["id"]==$res_enroll["payment_type"]) { ?> selected="selected" <?php } ?>>
								<?php echo $resp['name'];?></option>
                                <?php } ?>
                            </select></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="left" valign="middle" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_INITIPAY");?> : </td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENTTYPE");?> :</td>
                        <td>&nbsp;</td>
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
                            <td width="41%" height="25" align="left" valign="middle" class="pedtext" >&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_GHTEXT");?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="47%">&nbsp;</td>
                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="18" colspan="4" align="left" valign="top" class="leftmenu">
                        <table width="98%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="5%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                            <td width="14%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                            <td width="14%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                            <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                            <td width="6%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRINT");?></td>
                            <td width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENT");?></td>
                            <td colspan="2" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("COMMON_ACTION");?></td>
                            </tr>
                          <?php							
							$j = 1;
							$fifo = $dbf->strRecordID("student_fees","*","course_id='$course_id' And student_id='$student_id' AND status='0' LIMIT 0,1");
							$fifo_id = $fifo["id"];
							
							//Get Course has been finished or not (If 0 = Not completed else Completed)
							$num_complete = $dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id And g.status='Completed' And g.course_id='$course_id' And d.student_id='$student_id'");
							
							foreach($dbf->fetchOrder('student_fees',"course_id='$course_id' And student_id='$student_id'","") as $vali){								
							$dt="";							
							$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");
							
							?>
                          <tr class="mytext">
                            <td height="25" align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                            <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                            <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                            <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
                            <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                            <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
                              &nbsp;&nbsp;</td>
                            <td align="center" ><?php if($vali["paid_amt"]>0) { ?>
                              <a href="search_print_challan_admission.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;fee_id=<?php echo $vali["id"];?>&amp;id=<?php echo $val_student["id"];?>&amp;page=search_print_challan_admission.php&amp;TB_iframe=true&amp;height=440&amp;width=675&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"><img src="../images/print.png" width="16" height="16" border="0" title="Print" /></a>
                              <?php } ?></td>
                              <td align="center" >
								  <?php
                                      //Check course_fees amount = paid amt
                                      if($vali["paid_amt"]!=$vali["fee_amt"]) {
                                      
                                      //FIFO Payment
                                       if($vali["id"]==$fifo_id) {
                                        
										//if course not completed
										if($num_complete == 0) {  
                                      ?>
                                    <a href="single-payment-made.php?student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $course_id;?>"><img src="../images/payment.png" width="16" height="16" border="0" title="Payment" /></a>
                                    <?php }}} ?></td>
                              <td align="center" >
								  <?php
                                  if($vali["paid_amt"]!="0") {
									  
									  //if course not completed
								  	if($num_complete == 0) {
								  ?>
                                    <a href="single-payment-edit.php?student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $course_id;?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a>
                                    <?php }} ?></td>
                                    
                                    
                                  <td align="center" >
								  <?php
                                  if($vali["paid_amt"]=="0") {
									  
									  //if course not completed
								  		if($num_complete == 0) {
									  ?>
                                    <a href="single-payment.php?action=sch_del&amp;course_id=<?php echo $course_id;?>&amp;student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a>
                                    <?php }} ?></td>
                            </tr>
                          <?php $j++; } ?>
                          </table></td>
                        </tr>
                      <?php
                                }
								if($res_enroll["level_complete"]==0) {
                                ?>
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
                        <td height="28" colspan="3" align="left" valign="top" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="41%" height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_MATERIALRECI");?> : </td>
                            <td width="59%" align="left" valign="top">
                            <table width="250" cellpadding="0" cellspacing="0">
                          <?php
							$x = 1;
							foreach($dbf->fetchOrder('common',"type='material type'","") as $resm) {
							$nn=$dbf->countRows('student_material',"course_id='$course_id' And student_id='$_REQUEST[id]' AND mate_id='$resm[id]'");
							?>
                          <tr>
                            <td width="20" align="left" valign="middle"><input type="checkbox" name="material<?php echo $x;?>" id="material<?php echo $x;?>" value="<?php echo $resm[id];?>" <?php if($nn>0) { ?> checked="checked" <?php } ?> /></td>
                            <td width="228" align="left" valign="middle" class="shop2"><?php echo $resm[name];?></td>
                            </tr>
                          <?php $x++; } ?>
                          <input type="hidden" name="mcount" id="mcount" value="<?php echo $x-1;?>" />
                          </table>
                            </td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT1");?> : </td>
                            <td align="left" valign="top"><input type="checkbox" name="web" id="web" value="1" <?php if($res_enroll["web"]==1) { ?> checked="checked" <?php } ?> /></td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT2");?> : </td>
                            <td align="left" valign="top"><input type="checkbox" name="progress" id="progress" value="" disabled="disabled" <?php if($num_pr > 0) {?> checked="checked" <?php }?> /></td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT3");?> :</td>
                            <td align="left" valign="top"><input name="prog_printed" id="prog_printed" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php }?>/></td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT4");?> : </td>
                            <?php
							//Check the progress generated has been added or not ?
							$num_cg = $dbf->countRows('teacher_progress_certificate',"course_id='$course_id' And student_id='$student_id'");
							?>
                            <td align="left" valign="top">
                              <input name="certificate" id="certificate" type="checkbox" value="" disabled="disabled" <?php if($num_cg > 0) {?> checked="checked" <?php } ?> /></td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT5");?> : </td>
                            <td align="left" valign="top"><input name="certificate2" id="certificate2" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php } ?>/></td>
                            </tr>
                          <tr>
                            <td height="22" align="left" valign="top" class="leftmenu">&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_COMMENTS");?> :</td>
                            <td align="left" valign="top" style="padding-left:3px;"><textarea name="textarea" id="textarea" rows="2" cols="25" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                          </tr>
                          </table></td>
                        <td align="left" valign="top">
                          <table width="265" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
                            <tr>
                              <td width="85%" height="25" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TXT");?></td>
                              <td width="7%" align="center" valign="middle" bgcolor="#ccc"><img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/></td>
                              <td width="8%" align="center" valign="middle" bgcolor="#ccc"><img src="../images/minus1.png" width="18" height="18" onClick="del();"/></td>
                              </tr>
                            </table>
                          <table width="265" border="2" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="2%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="amt_head">&nbsp;</td>
                              <td width="43%" align="left" valign="middle" bgcolor="#FF9900" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                              <td width="40%" align="center" valign="middle" bgcolor="#FF9900" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRICE");?></td>
                              <td width="15%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading">&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="25" colspan="4" align="center" valign="middle">
                                <div id="div1"> </div>
                                <div style="clear:both;">
                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                    <tr>
                                      <td width="2%">&nbsp;</td>
                                      <td width="44%" align="left" valign="middle"><input name="pdate1" type="text" class="datepick new_textbox100" id="pdate1" readonly="readonly" size="45" minlength="4"/></td>
                                      <td width="47%" align="left" valign="middle"><input name="amt1" type="text" class="new_textbox100" id="amt1" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                      <td width="7%" align="center">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
                                <input name="count" type="hidden" id="count" value="2" />
                                <?php for($i=2; $i<15;$i++){?>
                                <div id="div<?php echo $i;?>" style="display:none;">
                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                    <tr>
                                      <td width="2%">&nbsp;</td>
                                      <td width="44%" align="left" valign="middle"><input name="pdate<?php echo $i;?>" type="text" class="datepick new_textbox100" readonly="readonly" id="pdate<?php echo $i;?>" size="45" minlength="4"/></td>
                                      <td width="47%" align="left" valign="middle"><input name="amt<?php echo $i;?>" type="text" class="new_textbox100" id="amt<?php echo $i;?>" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                      <td width="7%" align="center">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
                                <?php } ?></td>
                              </tr>
                            </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="top" class="leftmenu"></td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="35" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="bottom">
                          <!--If course has been selected-->
                          <?php if($_REQUEST[course_id]!='') {                          
                          //If course has been not completed then SAVE button will be displayed-->
                          if($num_complete == 0) {?>
                            <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/>
                          <?php }} ?></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                  </tr>
                  </table>
                </form>                
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		
		</td>
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
				
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="63%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="37%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
                  </tr>
                </table>
                </td>
                </tr>
              
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="right" valign="top">
                <form id="frm" name="frm" method="post" action="single-payment.php?action=search&student_id=<?=$student_id;?>&course_id=<?=$course_id;?>">
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="2%">&nbsp;</td>
                    <td width="18%" height="30" align="left" valign="middle" class="mytext"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                    <td width="37%">&nbsp;</td>
                    <td width="43%" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="74%" height="30" align="right" valign="middle"><select name="course" id="course" style="width:200px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" dir="rtl" onChange="show_payment();">
                              <option value="">---<?php echo constant("SELECT");?>---</option>
                              <?php
							foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","") as $rescourse) {
								$course = $dbf->strRecordID("course","*","id='$rescourse[course_id]'");
						  ?>
                              <option value="<?php echo $course['id'];?>" <?php if($course_id==$course["id"]) { ?> selected="selected" <?php } ?>><?php echo $course['name'];?></option>
                              <?php } ?>
                          </select></td>
                          <td width="26%" align="right" class="pedtext">&nbsp; : <?php echo constant("SELECT_COURSE");?>&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="2%" height="1"></td>
                    <td height="1" colspan="3" align="left" valign="top" bgcolor="#E2E6FE"></td>
                    </tr>
                  <?php					
					$val_student = $dbf->strRecordID("student","*","id='$student_id'");
					$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
					$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
				  ?>
                  <tr>
                    <td colspan="4" align="left" valign="top" style="padding-top:3px;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="1%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td width="24%" height="28" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LEVELCOMPL");?> :</td>
                        <td width="1%">&nbsp;</td>
                        <td width="36%" align="left" valign="middle" class="mytext">
                        <?php if($res_enroll["level_complete"]==1) { ?> Yes <?php }else{?> No <?php } ?>                        </td>
                        <td width="38%" rowspan="2" align="center" valign="middle">&nbsp;</td>
                        </tr>
                      <?php
						$res_course = $dbf->strRecordID("course","*","id='$course_id'");
						$course_fee = $course_fees;
						?>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> :</td>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle" class="mytext" ><input name="course_fee" type="text" class="new_textbox100_ar" id="course_fee" value="<?php echo $course_fee;?>" readonly="readonly" /></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?> :</td>
                        <td>&nbsp;</td>
                        <td colspan="2" rowspan="4" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="17%" height="28" align="left" valign="middle" class="mytext"><input name="discount" type="text" class="new_textbox100_ar" id="discount" value="<?php echo $res_enroll["discount"];?>" onKeyPress="return isNumberKey(event);" onBlur="checkDiscount();"/></td>
                            <td width="30%" align="left" valign="middle"></td>
                            <td width="53%" rowspan="4" align="left" valign="top"><table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                              <?php
								 $camt = $course_fees - $res_enroll["discount"]+$res_enroll["other_amt"];
								 
								 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								 $feeamt = $fee["SUM(paid_amt)"];
								
								 $bal_amt = $camt - $feeamt;
							
								//Use currency
								$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
								?>
                              <tr>
                                <td width="38%" height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                <td width="56%" align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">&nbsp; : <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?></td>
                              </tr>
                              <tr>
                                <td height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                <td align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">&nbsp; : <?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
                              </tr>
                              <tr>
                                <td height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                <td align="left" valign="middle" bgcolor="#A9CFFE" class="pedtext">&nbsp; : <?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></td>
                              </tr>
                            </table></td>
                            </tr>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><input name="otheramt" type="text" class="new_textbox100_ar" id="otheramt" value="<?php echo $res_enroll["other_amt"];?>" onKeyPress="return isNumberKey(event);"/></td>
                            <td align="left" valign="middle"><input name="othertext" type="text" class="new_textbox190_ar" id="othertext" value="<?php echo $res_enroll["othertext"];?>" /></td>
                          </tr>
                          <?php
						  $opening_amt = $dbf->getDataFromTable('student_fees',"paid_amt","course_id='$course_id' And student_id='$student_id' And type='opening'");
						  ?>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><input name="payment" type="text" class="new_textbox100_ar" id="payment" value="<?php echo $opening_amt;?>"  maxlength="20" onKeyPress="return isNumberKey(event);"/></td>
                            <td align="center" valign="middle">
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
                              <?php } ?></td>
                            </tr>
                          <tr>
                            <td height="28" align="left" valign="middle" class="mytext"><select name="ptype" id="ptype" style="width:103px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                              <option>---<?php echo constant("SELECT");?>---</option>
                                <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
								  ?>
                                <option value="<?php echo $resp['id'];?>" <?php if($resp["id"]==$res_enroll["payment_type"]) { ?> selected="selected" <?php } ?>>
								<?php echo $resp['name'];?></option>
                                <?php } ?>
                            </select></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_INITIPAY");?> : </td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENTTYPE");?> :</td>
                        <td>&nbsp;</td>
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
                            <td width="41%" height="25" align="left" valign="middle" class="pedtext" >&nbsp; <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_GHTEXT");?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="47%">&nbsp;</td>
                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="18" colspan="4" align="left" valign="top" class="leftmenu"><table width="98%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td colspan="2" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("COMMON_ACTION");?></td>
                            <td width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENT");?></td>
                            <td width="6%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRINT");?></td>
                            <td width="14%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                            <td width="13%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                            <td width="14%" align="right" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                            <td width="5%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                          </tr>
                          <?php							
							$j = 1;
							$fifo = $dbf->strRecordID("student_fees","*","course_id='$course_id' And student_id='$student_id' AND status='0' LIMIT 0,1");
							$fifo_id = $fifo["id"];
							
							//Get Course has been finished or not (If 0 = Not completed else Completed)
							$num_complete = $dbf->countRows('student_group g,student_group_dtls d',"g.id=d.parent_id And g.status='Completed' And g.course_id='$course_id' And d.student_id='$student_id'");
							
							foreach($dbf->fetchOrder('student_fees',"course_id='$course_id' And student_id='$student_id'","") as $vali){								
							$dt="";							
							$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");
							
							?>
                          <tr class="mytext">
                            <td align="center" ><?php
                                  if($vali["paid_amt"]!="0") {
									  
									  //if course not completed
								  	if($num_complete == 0) {
								  ?>
                                <a href="single-payment-edit.php?student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $course_id;?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a>
                                <?php }} ?></td>
                            <td align="center" ><?php
                                  if($vali["paid_amt"]=="0") {
									  
									  //if course not completed
								  		if($num_complete == 0) {
									  ?>
                                <a href="single-payment.php?action=sch_del&amp;course_id=<?php echo $course_id;?>&amp;student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a>
                                <?php }} ?></td>
                            <td align="center" ><?php
                                      //Check course_fees amount = paid amt
                                      if($vali["paid_amt"]!=$vali["fee_amt"]) {
                                      
                                      //FIFO Payment
                                       if($vali["id"]==$fifo_id) {
                                        
										//if course not completed
										if($num_complete == 0) {  
                                      ?>
                                <a href="single-payment-made.php?student_id=<?php echo $student_id;?>&amp;schid=<?php echo $vali["id"];?>&amp;course_id=<?php echo $course_id;?>"><img src="../images/payment.png" width="16" height="16" border="0" title="Payment" /></a>
                                <?php }}} ?></td>
                            <td align="center" ><?php if($vali["paid_amt"]>0) { ?>
                                <a href="search_print_challan_admission.php?course_id=<?php echo $_REQUEST[course_id];?>&amp;fee_id=<?php echo $vali["id"];?>&amp;id=<?php echo $val_student["id"];?>&amp;page=search_print_challan_admission.php&amp;TB_iframe=true&amp;height=440&amp;width=675&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"><img src="../images/print.png" width="16" height="16" border="0" title="Print" /></a>
                                <?php } ?></td>
                            <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                            <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
                            <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                            <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
                              &nbsp;&nbsp;</td>
                            <td align="right" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                            <td align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                          </tr>
                          <?php $j++; } ?>
                        </table></td>
                        </tr>
                      <?php
                                }
								if($res_enroll["level_complete"]==0) {
                                ?>
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
                        <td height="28" colspan="3" align="left" valign="top" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="41%" height="22" align="left" valign="top"><table width="250" cellpadding="0" cellspacing="0">
                          <?php
							$x = 1;
							foreach($dbf->fetchOrder('common',"type='material type'","") as $resm) {
							$nn=$dbf->countRows('student_material',"course_id='$course_id' And student_id='$_REQUEST[id]' AND mate_id='$resm[id]'");
							?>
                          <tr>
                            <td width="228" align="right" valign="middle" class="shop2"><?php echo $resm[name];?> &nbsp;</td>
                            <td width="20" align="left" valign="middle"><input type="checkbox" name="material<?php echo $x;?>" id="material<?php echo $x;?>" value="<?php echo $resm[id];?>" <?php if($nn>0) { ?> checked="checked" <?php } ?> /></td>
                            </tr>
                          <?php $x++; } ?>
                          <input type="hidden" name="mcount" id="mcount" value="<?php echo $x-1;?>" />
                          </table></td>
                            <td width="59%" align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_MATERIALRECI");?>&nbsp; </td>
                            </tr>
                          <tr>
                            <td height="22" align="right" valign="top"><input type="checkbox" name="web" id="web" value="1" <?php if($res_enroll["web"]==1) { ?> checked="checked" <?php } ?> /></td>
                            <td align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT1");?>&nbsp; </td>
                            </tr>
                          <tr>
                            <td height="22" align="right" valign="top"><input type="checkbox" name="progress" id="progress" value="" disabled="disabled" <?php if($num_pr > 0) {?> checked="checked" <?php }?> /></td>
                            <td align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT2");?>&nbsp; </td>
                            </tr>
                          <tr>
                            <td height="22" align="right" valign="top"><input name="prog_printed" id="prog_printed" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php }?>/></td>
                            <td align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT3");?>&nbsp;</td>
                          </tr>
                          <tr>
						  	<?php
							//Check the progress generated has been added or not ?
							$num_cg = $dbf->countRows('teacher_progress_certificate',"course_id='$course_id' And student_id='$student_id'");
							?>
                            <td height="22" align="right" valign="top">
                              <input name="certificate" id="certificate" type="checkbox" value="" disabled="disabled" <?php if($num_cg > 0) {?> checked="checked" <?php } ?> /></td>
                            <td align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT4");?>&nbsp;</td>
                            </tr>
                          <tr>
                            <td height="22" align="right" valign="top"><input name="certificate2" id="certificate2" type="checkbox" value="" disabled="disabled" <?php if($num_ps > 0) {?> checked="checked" <?php } ?>/></td>
                            <td align="left" valign="top" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_LTEXT5");?>&nbsp;</td>
                            </tr>
                          <tr>
                            <td height="22" align="right" valign="top"><textarea name="textarea" id="textarea" rows="2" cols="25" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; text-align:right;"></textarea></td>
                            <td align="left" valign="top" style="padding-left:3px;" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_COMMENTS");?>&nbsp;</td>
                          </tr>
                          </table></td>
                        <td align="left" valign="top">
                          <table width="265" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
                            <tr>
                              <td width="85%" height="25" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_TXT");?></td>
                              <td width="7%" align="center" valign="middle" bgcolor="#ccc"><img src="../images/plus-circle.png" width="20" height="20" onClick="add();"/></td>
                              <td width="8%" align="center" valign="middle" bgcolor="#ccc"><img src="../images/minus1.png" width="18" height="18" onClick="del();"/></td>
                              </tr>
                            </table>
                          <table width="265" border="2" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="2%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="amt_head">&nbsp;</td>
                              <td width="43%" align="left" valign="middle" bgcolor="#FF9900" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                              <td width="40%" align="center" valign="middle" bgcolor="#FF9900" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PRICE");?></td>
                              <td width="15%" align="center" valign="middle" bgcolor="#FF9900" class="pay_heading">&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="25" colspan="4" align="center" valign="middle">
                                <div id="div1"> </div>
                                <div style="clear:both;">
                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                    <tr>
                                      <td width="2%">&nbsp;</td>
                                      <td width="44%" align="left" valign="middle"><input name="pdate1" type="text" class="datepick new_textbox100_ar" id="pdate1" readonly="readonly" size="45" minlength="4"/></td>
                                      <td width="47%" align="left" valign="middle"><input name="amt1" type="text" class="new_textbox100_ar" id="amt1" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                      <td width="7%" align="center">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
                                <input name="count" type="hidden" id="count" value="2" />
                                <?php for($i=2; $i<15;$i++){?>
                                <div id="div<?php echo $i;?>" style="display:none;">
                                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                    <tr>
                                      <td width="2%">&nbsp;</td>
                                      <td width="44%" align="left" valign="middle"><input name="pdate<?php echo $i;?>" type="text" class="datepick new_textbox100" readonly="readonly" id="pdate<?php echo $i;?>" size="45" minlength="4"/></td>
                                      <td width="47%" align="left" valign="middle"><input name="amt<?php echo $i;?>" type="text" class="new_textbox100" id="amt<?php echo $i;?>" maxlength="6" onKeyPress="return isNumberKey(event);"/></td>
                                      <td width="7%" align="center">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
                                <?php } ?></td>
                              </tr>
                            </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="28" align="left" valign="top" class="leftmenu"></td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td height="35" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="bottom">
                          <!--If course has been selected-->
                          <?php if($_REQUEST[course_id]!='') {                          
                          //If course has been not completed then SAVE button will be displayed-->
                          if($num_complete == 0) {?>
                            <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/>
                          <?php }} ?></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                  </tr>
                  </table>
                </form>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
