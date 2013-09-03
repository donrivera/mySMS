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
include("../includes/saudismsNET-API.php");
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
$course_id =  $_REQUEST['course_id'];
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

if($_REQUEST['action']=='invoice'){
	
	$dt = date('Y-m-d h:m:s');
	$comments = mysql_real_escape_string($_POST[comment]);
	
	$string="paid_date='$_POST[dated]',	payment_type='$_POST[payment_type]',paid_amt='$_REQUEST[amt]',status='1',comments='$comments',fee_amt='$_REQUEST[amt]',created_date=NOW(),created_by='$_SESSION[id]'";
	
	$dbf->updateTable("student_fees",$string,"id='$_REQUEST[schid]'");
	
	// insert into student_comment table	
	if($comments != ''){
		$string1="student_id='$student_id',user_id='$_SESSION[id]',comments='$comments',date_time='$dt'";
		$dbf->insertSet("student_comment",$string1);
	}
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	$mobile_no = '';
	
	$mobile_no = $dbf->getDataFromTable("student","student_mobile","id='$student_id'");
	$amt = $_REQUEST["amt"];
	
	if($mobile_no != ''){
		
		// Your username
		$UserName=UrlEncoding($sms_gateway[user]);
		
		// Your password
		$UserPassword=UrlEncoding($sms_gateway[password]);
		
		// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
		//$Numbers=UrlEncoding("966000000000,966111111111");
		$Numbers=UrlEncoding($mobile_no);
		
		// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
		$Originator=UrlEncoding($sms_gateway[your_name]);
		
		// Your Message in English or arabic or both.
		// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
		
		//$msg = "You have paid ".$amt." for initial payment";
		$sms = $_REQUEST['sms'];
		if($sms == "1" || $sms == "3"){
			if($sms == "1"){
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
			}else if($sms == "3"){
				$sms_cont = $_REQUEST['contents'];
			}
			$sms_cont = str_replace('%first_name%',$student_mobile["first_name"],$sms_cont);
			$msg = str_replace('%ad_amt%',$amt,$sms_cont);
			
			$Message=$msg;
		
			// Storing Sending result in a Variable.
			if($sms_gateway["status"]=='Enable'){
				SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
			
				$cr_date = date('Y-m-d H:i:s A');
				$string="dated='$cr_date',user_id='$_SESSION[id]',msg='$msg',send_to='Student',type='0',centre_id='$_SESSION[centre_id]',automatic='Yes',msg_from='For Payment',mobile='$mobile_no',page_full_path='$_SERVER[REQUEST_URI]'";
				$sms_id = $dbf->insertSet("sms_history",$string);
				
				$string="parent_id='$sms_id',student_id='$student_id'";
				$dbf->insertSet("sms_history_dtls",$string);
			}
		}		
	}
	
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
<?php if($_SESSION[lang] == "EN") { ?>
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
                <td width="18%" align="right"><a href="single-payment.php?student_id=<?php echo $_REQUEST[student_id];?>&course_id=<?php echo $_REQUEST[course_id];?>">
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
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
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
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td height="30" colspan="2" align="left" valign="middle" class="mytext">&nbsp;</td>
                    <td width="27%">&nbsp;</td>
                    <td width="18%" align="center" valign="top"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                    </tr>
                  <tr>
                    <td height="1"></td>
                    <td height="1" colspan="4" align="left" valign="top" bgcolor="#E2E6FE"></td>
                    </tr>
                  <tr>
                    <td colspan="5" align="left" valign="top" style="padding-top:3px;">&nbsp;</td>
                  </tr>
                  </table></td>
              </tr>
              <?php
				$val_student = $dbf->strRecordID("student","*","id='$student_id'");
				$res_fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'");
								
				$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
				$res_course = $dbf->strRecordID("course","*","id='$course_id'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
				?>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="71%" align="left" valign="top">
                      
                      <form action="single-payment-made.php?action=invoice&ids=<?=$student_id;?>&amp;schid=<?=$_REQUEST[schid];?>&course_id=<?=$course_id;?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="4%">&nbsp;</td>
                            <td colspan="4" align="left" valign="middle">
                              <table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                                <tr>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td height="30" align="center" valign="bottom"><span class="lable1"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></span></td>
                                  <td width="7%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td width="25%" height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?> : &nbsp;</td>
                                  <td width="24%" align="left" valign="middle">
                                    <input name="dated" type="text" class="datepick new_textbox100" readonly="" value="<?php echo $res_fee["fee_date"];?>" id="dated" /></td>
                                  <td width="43%" rowspan="3" align="center" valign="middle">
                                    <table width="94%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                      <?php
										 $camt = $course_fees - $res_enroll["discount"] + $res_enroll["other_amt"];
										 
										 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
										 $feeamt = $fee["SUM(paid_amt)"];
										  
										 $bal_amt = $camt - $feeamt;
									
										//Use currency
										$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
										?>
                                      <tr>
                                        <td width="56%" height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?> : &nbsp;</td>
                                        <td width="44%" align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      <tr>
                                        <td height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> : &nbsp;</td>
                                        <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      <tr>
                                        <td height="25" align="right" valign="middle" bgcolor="#A9CFFE" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
                                        <td align="left" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                                        </tr>
                                      </table></td>
                                  <td colspan="2" rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("CD_SEARCH_INVOICE_FEES");?> : &nbsp;</td>
                                  <td align="left" valign="middle">
                                    <input name="amt" type="text" class="new_textbox100" id="amts" value="<?php echo $res_fee["fee_amt"];?>" maxlength="10" onKeyPress="return isNumberKey(event);"/></td>
                                  </tr>
                                <tr>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("CD_SEARCH_INVOICE_PAIDBY");?> : &nbsp;</td>
                                  <td align="left" valign="middle">
                                    <select name="payment_type" id="payment_type" style="width:102px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                      <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                      <option value="<?php echo $resp['id']?>" <?php if($resp["id"]==$val["payment_type"]) { ?> selected="" <?php } ?>><?php echo $resp['name'] ?></option>
                                      <?php } ?>
                                      </select>
                                    </td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="right" valign="middle" class="leftmenu">&nbsp;<?php echo constant("ADMIN_COMMNAME");?> : &nbsp;</td>
                                  <td colspan="2" align="left" valign="middle">
                                    <textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF;"><?php echo $val[comments];?></textarea></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle">&nbsp;</td>
                                  <td colspan="3" align="left" valign="middle">
                                  <table width="89%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
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
                                      <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                        <tr>
                                          <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    </table></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle">&nbsp;</td>
                                  <td colspan="3" align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                </table></td>
                            </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td width="21%" height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="24%" align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/>
                              <a href="search_print_invoice.php?id=<?php echo $val["id"];?>&page=search_print_invoice.php&amp;TB_iframe=true&amp;height=420&amp;width=375&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"></a></td>
                            <td width="50%">&nbsp;</td>
                          </tr>
                          </table>
                        </form>
                      
                      </td>
                    <td width="29%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left">
                          <?php 
					   	//To Show Payment Hstory
					      $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id' AND paid_date!='0000-00-00'");
						  if($num11>=1){
					   ?>
                          <table width="95%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                            <?php
								$res_payment = $dbf->strRecordID("student_fees","MAX(id)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								$lastpaymnt=$res_payment["MAX(id)"];
								$res_payment_info= $dbf->strRecordID("student_fees","*","id='$lastpaymnt'");
								$res_enter= $dbf->strRecordID("user","*","id='$res_payment_info[created_by]'");
						  		?>
                            <tr>
                              <td height="25" colspan="2" align="left" valign="middle" bgcolor="#F1E8FF" class="mymenutext"><?php echo constant("LAST_PAYMENT_HISTORY");?></td>
                              </tr>
                            <tr>
                              <td width="54%" height="25" align="right" valign="middle" class="pedtext"><?php echo constant("PAYMENT_DATE");?> : &nbsp;</td>
                              <td width="46%" align="left" valign="middle" class="mytext"><?php echo $res_payment_info[fee_date]?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="pedtext"><?php echo constant("LAST_PAYMENT");?> : &nbsp;</td>
                              <td align="left" valign="middle" class="mytext"><?php echo $res_payment_info[paid_date];?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?> : &nbsp;</td>
                              <td align="left" valign="middle" class="mytext"><?php echo $res_payment_info[paid_amt];?> <?php echo $res_currency[symbol];?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?> : &nbsp;</td>
                              <td align="left" valign="middle" class="mytext"><?php echo $res_enter["user_name"];?></td>
                              </tr>
                            </table>
                          <?php }?></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
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
                <td width="18%" height="30" align="right"><a href="single-payment.php?student_id=<?php echo $_REQUEST[student_id];?>&course_id=<?php echo $_REQUEST[course_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="25%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
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
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
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
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1%">&nbsp;</td>
                      <td height="30" colspan="2" align="left" valign="middle" class="mytext"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                      <td width="26%">&nbsp;</td>
                      <td width="54%" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="74%" height="30" align="right" valign="middle"><select name="course" id="course" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_payment();">
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
                </table></td>
              </tr>              
              <?php
				$val_student = $dbf->strRecordID("student","*","id='$student_id'");
				$res_fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[schid]'");
								
				$res_enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
				$res_course = $dbf->strRecordID("course","*","id='$course_id'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
				?>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="71%" align="left" valign="top">
                      
                      <form action="single-payment-made.php?action=invoice&ids=<?=$student_id;?>&amp;schid=<?=$_REQUEST[schid];?>&course_id=<?=$course_id;?>" name="frm" method="post" id="frm" onSubmit="return validate();">
                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="4%">&nbsp;</td>
                            <td colspan="4" align="left" valign="middle">
                              <table width="97%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
                                <tr>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td height="30" align="center" valign="bottom"><span class="lable1"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></span></td>
                                  <td width="7%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td width="24%" height="28" align="right" valign="middle"><input name="dated" type="text" class="datepick new_textbox100" readonly="" value="<?php echo $res_fee["fee_date"];?>" id="dated" /></td>
                                  <td width="25%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                                  <td width="43%" rowspan="3" align="center" valign="middle">
                                    <table width="94%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                                      <?php			 
										 $camt = $course_fees - $res_enroll["discount"] + $res_enroll["other_amt"];
										 
										 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
										 $feeamt = $fee["SUM(paid_amt)"];
										  
										 $bal_amt = $camt - $feeamt;
									
										//Use currency
										$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
										?>
                                      <tr>
                                        <td width="44%" height="25" align="right" valign="middle" bgcolor="#F1E8FF" class="mycon">&nbsp;<?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
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
                                  <td colspan="2" rowspan="2" align="left" valign="top" id="lblname">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="right" valign="middle"><input name="amt" type="text" class="new_textbox100" id="amts" value="<?php echo $res_fee["fee_amt"];?>" maxlength="10" onKeyPress="return isNumberKey(event);"/></td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_SEARCH_INVOICE_FEES");?></td>
                                </tr>
                                <tr>
                                  <td height="28" align="right" valign="middle"><select name="payment_type" id="payment_type" style="width:102px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                      <?php
									foreach($dbf->fetchOrder('common',"type='payment type'","") as $resp) {
									  ?>
                                      <option value="<?php echo $resp['id']?>" <?php if($resp["id"]==$val["payment_type"]) { ?> selected="" <?php } ?>><?php echo $resp['name'] ?></option>
                                      <?php } ?>
                                      </select></td>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("CD_SEARCH_INVOICE_PAIDBY");?></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" colspan="3" align="right" valign="middle" class="leftmenu"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#cccccc;">
  <tr>
    <td width="70%" height="28" align="right" valign="middle"><textarea name="comment" id="comment" rows="5" cols="40" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; text-align:right;"><?php echo $val[comments];?></textarea></td>
    <td width="47%" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("ADMIN_COMMNAME");?></td>
  </tr>
</table></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle">&nbsp;</td>
                                  <td colspan="3" align="left" valign="middle">
                                  <table width="89%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
                                    <tr>
                                      <td width="94%" align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
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
                                      </tr>
                                    <tr>
                                      <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
                                      <td align="left" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onChange="showsms(this.value)" /></td>
                                      </tr>
                                    <tr>
                                      <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
                                      <td align="left" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                                      </tr>
                                    <tr>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <?php
										$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='31'");
										?>
                                      <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                                        <tr>
                                          <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    </table></td>
                                  <td>&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="28" align="left" valign="middle">&nbsp;</td>
                                  <td colspan="3" align="left" valign="middle">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                </table></td>
                            </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td width="21%" height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="24%" align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/>
                              <a href="search_print_invoice.php?id=<?php echo $val["id"];?>&page=search_print_invoice.php&amp;TB_iframe=true&amp;height=420&amp;width=375&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox"></a></td>
                            <td width="50%">&nbsp;</td>
                          </tr>
                          </table>
                        </form>                      </td>
                    <td width="29%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left">
                          <?php 
					   	//To Show Payment Hstory
					      $num11=$dbf->countRows('student_fees',"course_id='$course_id' And student_id='$student_id' AND paid_date!='0000-00-00'");
						  if($num11>=1){
					   ?>
                          <table width="95%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                            <?php
								$res_payment = $dbf->strRecordID("student_fees","MAX(id)","course_id='$course_id' And student_id='$student_id' AND status='1'");
								$lastpaymnt=$res_payment["MAX(id)"];
								$res_payment_info= $dbf->strRecordID("student_fees","*","id='$lastpaymnt'");
								$res_enter= $dbf->strRecordID("user","*","id='$res_payment_info[created_by]'");
						  		?>
                            <tr>
                              <td height="25" colspan="2" align="left" valign="middle" bgcolor="#F1E8FF" class="mymenutext"><?php echo constant("LAST_PAYMENT_HISTORY");?></td>
                              </tr>
                            <tr>
                              <td width="54%" height="25" align="right" valign="middle" class="mytext"><?php echo $res_payment_info[fee_date]?></td>
                              <td width="46%" align="left" valign="middle" class="pedtext">&nbsp; : <?php echo constant("PAYMENT_DATE");?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="mytext"><?php echo $res_payment_info[paid_date];?></td>
                              <td align="left" valign="middle" class="pedtext">&nbsp; : <?php echo constant("LAST_PAYMENT");?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="mytext"><?php echo $res_payment_info[paid_amt];?> <?php echo $res_currency[symbol];?></td>
                              <td align="left" valign="middle" class="pedtext">&nbsp; : <?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
                              </tr>
                            <tr>
                              <td height="25" align="right" valign="middle" class="mytext"><?php echo $res_enter["user_name"];?></td>
                              <td align="left" valign="middle" class="pedtext">&nbsp; : <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_ENTRY_BY");?></td>
                              </tr>
                            </table>
                          <?php } ?></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
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
        </table>		</td>
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
