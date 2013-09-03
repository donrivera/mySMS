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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

//Used currency
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
$centre_id = $_SESSION["centre_id"];
$start_date = $_REQUEST["start_date"];
$end_date = $_REQUEST["end_date"];
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

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#start_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#end_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
<!--UI JQUERY DATE PICKER-->

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
        <td align="left" height="25" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_management_word.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_management_csv.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_management_pdf.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_management_print.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table>
        </td>
      </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
        <td width="2%">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
        <form name="frm" id="frm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("MANAGEMENT_REPORT");?></td>
                <td width="22%" height="30">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="56%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%" align="left" valign="middle">&nbsp;</td>
                    <td width="12%" height="30" align="right" valign="middle" class="mymenutext">&nbsp;</td>
                    <td width="22%" align="left" valign="middle">&nbsp;</td>
                    <td width="12%" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                    <td width="17%" align="left" valign="middle"><input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                    <td width="9%" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                    <td width="18%" align="left" valign="middle"><input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                    <td width="9%" align="right" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                    </tr>
                  </table></td>
                <td width="1%">&nbsp;</td>
                <td width="38%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="center" valign="middle">
                <table width="60%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="left" valign="middle" class="lable1"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?>&nbsp;:&nbsp;&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $_REQUEST[start_date];?>&nbsp;/&nbsp;<?php echo $_REQUEST[end_date];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_APPOINTMENT");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_INTERVIEW_CONDUCTED");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","status='1' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_NEW_ENROLL");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					//loop start
					$enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re == 1){
							$enroll = $enroll + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $enroll;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_RE_ENROLL");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					//loop start
					$re_enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re > 1){
							$re_enroll = $re_enroll + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $re_enroll;?></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_NEW_AND_RE_ENROLL");?>&nbsp;:&nbsp;&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $enroll+$re_enroll;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_CERTIFICATE_ISSUED");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$no_of_certificat = 0;
					foreach($dbf->fetchOrder('teacher_progress_certificate', "(print_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_certificat = $no_of_certificat + 1;
						}
					}					
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_certificat;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_PROGRESS_ISSUED");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$no_of_progress = 0;
					foreach($dbf->fetchOrder('teacher_progress', "(progress_report_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_progress = $no_of_progress + 1;
						}
					}					
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_progress;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$no_of_attand = 0;
					foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_attand = $no_of_attand + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_attand;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='Yes' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_STUDENT_CANCEL");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$cancel = $dbf->strRecordID("student_cancel","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$cancel = $cancel["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $cancel;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_STUDENT_TRANSFER");?>&nbsp;:&nbsp;&nbsp;</td>
                    <td align="center" valign="middle" class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_GROUP_TRANSFER");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Continue' And (created_datetime BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_GROUP_COMPLETED");?>&nbsp;:&nbsp;&nbsp;</td>
                    <?php
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Completed' And (completed_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_TOTAL_SALE");?> :&nbsp;&nbsp;</td>
                    <td align="center" valign="top" style="padding-top:2px; padding-bottom:2px;">
                    <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                    <?php
					$total = 0;
					foreach($dbf->fetchOrder('common',"type='payment type'","id DESC") as $valpay) {						
						
						# it is sum amount from fees structures 
						$amts = $dbf->strRecordID("student_fees","SUM(paid_amt)","payment_type='$valpay[id]' And centre_id='$centre_id' And (paid_date BETWEEN '$start_date' And '$end_date')");
						$amts = $amts["SUM(paid_amt)"];
						
						$total = $total + $amts;
												
						# Get Discount of a particular date
						$discount_amts = $dbf->getDataFromTable("student_enroll","SUM(discount)","payment_type='$valpay[id]' And centre_id='$centre_id' And (payment_date BETWEEN '$start_date' And '$end_date')");
						
						$amts = $discount_amts;
						$total = $total + $amts;					
						?>
                      <tr class="mymenutext">
                        <td width="51%" align="center" valign="middle"><?php echo $valpay["name"];?></td>
                        <td width="49%" align="center" valign="middle" class="pedtext"><?php echo $amts;?> <?php echo $res_currency[symbol];?></td>
                      </tr>
                      <?php } ?>
                      <tr class="mymenutext">
                        <td height="20" colspan="2" align="center" valign="middle"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?> : <?php echo $total;?> <?php echo $res_currency[symbol];?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_TEACH_UNIT");?> :&nbsp;&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext">
                    <?php
					$unit = 0;
					foreach($dbf->fetchOrder('student_group g,ped_attendance a',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')","","a.unit","a.unit") as $valpay) {
						$unit = $unit + 1;
					}
						echo $unit;?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_SMS_SENT");?> :&nbsp;&nbsp;</td>
                    <?php
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_EMAIL_SENT");?> :&nbsp;&nbsp;</td>
                    <?php
					$email = $dbf->strRecordID("email_history","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$email = $email["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $email;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("MANAGE_LISM_REPORT_ARF_LOGGED");?> :&nbsp;&nbsp;</td>
                    <?php
					$arf = $dbf->strRecordID("arf","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$arf = $arf["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $arf;?></td>
                  </tr>
                </table></td>
              </tr>                
              </table></td>
          </tr>               
          <tr>
            <td bgcolor="#FFFFFF" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        </form>
        
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
        <td width="79%" align="left" valign="top">
          
          <form name="frm" id="frm">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                  <table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="22%" height="30">&nbsp;</td>
                      <td width="8%" height="30" align="left">&nbsp;</td>
                      <td width="8%" height="30" align="left">&nbsp;</td>
                      <td width="8%" height="30" align="left">&nbsp;</td>
                      <td width="54%" height="30" class="logintext" align="right"><?php echo constant("MANAGEMENT_REPORT");?></td>
                      </tr>
                    </table></td>
                </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="38%">&nbsp;</td>
                        <td width="1%">&nbsp;</td>
                          <td width="56%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                             <td width="9%" align="right" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                              <td width="18%" align="right" valign="middle"><input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80_ar" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                              <td width="9%" align="left" valign="middle" class="mymenutext"> :&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?></td>
                               <td width="17%" align="right" valign="middle"><input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80_ar" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
    
                              <td width="12%" align="left" valign="middle" class="mymenutext"> :&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?></td>
                              <td width="22%" align="left" valign="middle">&nbsp;</td>
                              <td width="12%" height="30" align="right" valign="middle" class="mymenutext">&nbsp;</td>
                              <td width="1%" align="left" valign="middle">&nbsp;</td>
                              </tr>
                            </table></td>
                      
                    </tr>
                    <tr>
                      <td colspan="4" align="center" valign="middle">
                        <table width="60%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $_REQUEST[start_date];?>&nbsp;/&nbsp;<?php echo $_REQUEST[end_date];?></td>
                            <td width="61%" height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></td>
                            <td width="6%">&nbsp;</td>
                            </tr>
                          <tr>
                            <?php
							$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$appoint = $appoint["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_APPOINTMENT");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","status='1' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$appoint = $appoint["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_INTERVIEW_CONDUCTED");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							//loop start
							$enroll = 0;
							foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
														
								//Check whether it is for New-Enrollment or Re-enrollment
								$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
								if($num_re == 1){
									$enroll = $enroll + 1;
								}
							}
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $enroll;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_NEW_ENROLL");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							//loop start
							$re_enroll = 0;
							foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
														
								//Check whether it is for New-Enrollment or Re-enrollment
								$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
								if($num_re > 1){
									$re_enroll = $re_enroll + 1;
								}
							}
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $re_enroll;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_RE_ENROLL");?></td>
                            <td align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $enroll+$re_enroll;?></td>
                            <td width="61%" height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_NEW_AND_RE_ENROLL");?></td>
                            <td width="6%">&nbsp;</td>
                            </tr>
                          <tr>                            
                            <?php
							$no_of_certificat = 0;
							foreach($dbf->fetchOrder('teacher_progress_certificate', "(print_date BETWEEN '$start_date' And '$end_date')") as $cer) {
								$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
								$c_id = $centre_grp["centre_id"];
								if($c_id == $centre_id){
									$no_of_certificat = $no_of_certificat + 1;
								}
							}					
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $no_of_certificat;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_CERTIFICATE_ISSUED");?></td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <?php
							$no_of_progress = 0;
							foreach($dbf->fetchOrder('teacher_progress', "(progress_report_date BETWEEN '$start_date' And '$end_date')") as $cer) {
								$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
								$c_id = $centre_grp["centre_id"];
								if($c_id == $centre_id){
									$no_of_progress = $no_of_progress + 1;
								}
							}					
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $no_of_progress;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_PROGRESS_ISSUED");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$no_of_attand = 0;
							foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
								$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
								$c_id = $centre_grp["centre_id"];
								if($c_id == $centre_id){
									$no_of_attand = $no_of_attand + 1;
								}
							}
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $no_of_attand;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='Yes' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$sms = $sms["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?></td>
                            <td align="left">&nbsp;</td>
                          </tr>
                          <tr>                            
                            <?php
							$cancel = $dbf->strRecordID("student_cancel","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$cancel = $cancel["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $cancel;?></td>
                            <td width="61%" height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_CANCEL");?></td>
                            <td width="6%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle" class="pedtext">&nbsp;</td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_TRANSFER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$group = $dbf->strRecordID("student_group","COUNT(id)","status='Continue' And (created_datetime BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$group = $group["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_GROUP_TRANSFER");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$group = $dbf->strRecordID("student_group","COUNT(id)","status='Completed' And (completed_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$group = $group["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_GROUP_COMPLETED");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="top" style="padding-top:2px; padding-bottom:2px;">
                              <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                                <?php
								$total = 0;
								foreach($dbf->fetchOrder('common',"type='payment type'","id DESC") as $valpay) {						
								$amts = $dbf->strRecordID("student_fees","SUM(paid_amt)","payment_type='$valpay[id]' And centre_id='$centre_id'");
								$amts = $amts["SUM(paid_amt)"];
								$total = $total + $amts;
								?>
                                <tr class="mymenutext">
                                  <td width="49%" align="center" valign="middle" class="pedtext"><?php echo $amts;?></td>
                                  <td width="51%" align="center" valign="middle"><?php echo $valpay["name"];?></td>
                                  </tr>
                                <?php } ?>
                                <tr class="mymenutext">
                                  <td height="20" colspan="2" align="center" valign="middle"><?php echo $total;?> : <?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?></td>
                                  </tr>
                                </table></td>
                             <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_TOTAL_SALE");?></td>
                             <td align="left">&nbsp;</td>    
                          </tr>
                          <tr>
                            <td width="33%" align="center" valign="middle" class="pedtext">
                              <?php
								$unit = 0;
								foreach($dbf->fetchOrder('student_group g,ped_attendance a',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')","","a.unit","a.unit") as $valpay) {
									$unit = $unit + 1;
								}
									echo $unit;?>
                              </td>
                              <td width="61%" height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_TEACH_UNIT");?></td>
                              <td width="6%">&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$sms = $sms["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_SMS_SENT");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$email = $dbf->strRecordID("email_history","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$email = $email["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $email;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_EMAIL_SENT");?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <?php
							$arf = $dbf->strRecordID("arf","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
							$arf = $arf["COUNT(id)"];
							?>
                            <td align="center" valign="middle" class="pedtext"><?php echo $arf;?></td>
                            <td height="25" align="left" class="lable1">&nbsp;:&nbsp;<?php echo constant("MANAGE_LISM_REPORT_ARF_LOGGED");?></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>                
                    </table></td>
                </tr>               
              <tr>
                <td bgcolor="#FFFFFF" align="right">&nbsp;</td>
                </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </table>
            </form>
          
        </td>
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
