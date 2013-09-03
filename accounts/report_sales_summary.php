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

//echo $dbf->GetStudentPaidAmount(112);
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
</script>
<!--UI JQUERY DATE PICKER-->

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->

<!--*******************************************************************-->

<script type="text/javascript">
function show_details(a){
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display==''){
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}else{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
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
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           10: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
			11: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
			8: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_sales_summary_report_word.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&radio=<?php echo $_REQUEST[radio];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_sales_summary_report_csv.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&radio=<?php echo $_REQUEST[radio];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_sales_summary_report_pdf.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&radio=<?php echo $_REQUEST[radio];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_sales_summary_report_print.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&radio=<?php echo $_REQUEST[radio];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="99%" border="0" cellpadding="0" cellspacing="0">
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ACCOUNTANT_SUMMERY");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp; </td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <form name="frm" id="frm" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" colspan="8" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td height="25" align="left" valign="middle" class="hometest_name"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> : </td>
                <td align="left" valign="middle">
                <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:21px; width:110px;">
                <option value="">--Select--</option>
                <?php foreach($dbf->fetchOrder('centre',"","name") as $valc) { ?>
                <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                <?php } ?>
                </select>
                </td>
                <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Date_Range" <?php if($_REQUEST["radio"]=="Date_Range") {?> checked="" <?php } ?>></td>
                <td width="5%" height="25" align="left" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                <td width="10%" align="left" valign="middle">
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>"/></td>
                <td width="3%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="9%" align="left" valign="middle">
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>"/></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input name="radio" type="radio" id="radio" value="Today" <?php if($_REQUEST["radio"]=="Today" || $_REQUEST["radio"] == '') {?> checked="" <?php } ?>></td>
                <td height="25" colspan="2" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_TODAY");?></td>
                <td width="3%" align="center" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="This Week" <?php if($_REQUEST["radio"]=="This Week") {?> checked="" <?php } ?>></td>
                <td width="9%" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_THISWEEK");?></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Last Week" <?php if($_REQUEST["radio"]=="Last Week") {?> checked="" <?php } ?>></td>
                <td height="25" colspan="2" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_LASTWEEK");?></td>
                <td width="3%" align="center" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="This Month" <?php if($_REQUEST["radio"]=="This Month") {?> checked="" <?php } ?>></td>
                <td width="9%" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_THISMONTH");?></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Last Month" <?php if($_REQUEST["radio"]=="Last Month") {?> checked="" <?php } ?>></td>
                <td height="25" colspan="2" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_LASTMONTH");?></td>
                <td width="3%" align="center" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Last 3 Months" <?php if($_REQUEST["radio"]=="Last 3 Months") {?> checked="" <?php } ?>></td>
                <td width="9%" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_THREEMONTH");?></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Last 6 Months" <?php if($_REQUEST["radio"]=="Last 6 Months") {?> checked="" <?php } ?>></td>
                <td height="25" colspan="2" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_SIXMONTH");?></td>
                <td width="3%" align="center" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="This Year" <?php if($_REQUEST["radio"]=="This Year") {?> checked="" <?php } ?>></td>
                <td width="9%" align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_THISYEAR");?></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="7%" align="right" valign="middle" class="hometest_name">
                <input type="radio" name="radio" id="radio" value="Last 3 Years" <?php if($_REQUEST["radio"]=="Last 3 Years") {?> checked="" <?php } ?>></td>
                <td height="25" colspan="2" align="left" valign="middle" class="hometest_name">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="left" valign="middle" class="hometest_name"><?php echo constant("ACCOUTANT_REPORT_SALES_SUMMARY_THREEYEAR");?>&nbsp; </td>
                      <td align="right" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                    </tr>
                </table></td>
                <td width="3%" align="center" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="9%" align="left" valign="middle">&nbsp;</td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="31%" align="left" valign="middle">&nbsp;</td>
                <td width="32%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" colspan="8" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" colspan="8" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="94%"><table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                      <tr>
                        <td width="5%" height="25" bgcolor="#CCCCCC">&nbsp;</td>
                        <td width="42%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_PAYMENT_MANAGE_PAYMENTTYPE");?></td>
                        <td width="53%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?></td>
                      </tr>
                      <?php
					$i = 1;
					$color="#ECECFF";
															
					//Conditions
					$start_date = '';
					$end_date = '';
					if($_REQUEST["radio"] == 'Date_Range'){
						$start_date = $_REQUEST[start_date];
						$end_date = $_REQUEST[end_date];
					}else if($_REQUEST["radio"] == 'Today'){
						$start_date = date('Y-m-d');
						$end_date = date('Y-m-d');
					}else if($_REQUEST["radio"] == 'This Week'){
						$start_date = $dbf->WeekStartDay(date('Y-m-d'));
						$end_date = $dbf->WeekEndDay(date('Y-m-d'));
					}else if($_REQUEST["radio"] == 'Last Week'){
						$start_date = $dbf->LastWeekStartDay();
						$end_date = $dbf->LastWeekEndDay();
					}else if($_REQUEST["radio"] == 'This Month'){
						$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
						$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
					}else if($_REQUEST["radio"] == 'Last Month'){
						$start_date = date("Y-m",strtotime("-1 Months"));
						$start_date = $start_date.'-01';
						
						$end_date = date("Y-m",strtotime("-1 Months"));
						$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
					}else if($_REQUEST["radio"] == 'Last 3 Months'){
						$start_date = date("Y-m",strtotime("-3 Months"));
						$start_date = $start_date.'-01';
						
						$end_date = date("Y-m",strtotime("-1 Months"));
						$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
					}else if($_REQUEST["radio"] == 'Last 6 Months'){
						$start_date = date("Y-m",strtotime("-6 Months"));
						$start_date = $start_date.'-01';
						
						$end_date = date("Y-m",strtotime("-1 Months"));
						$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
					}else if($_REQUEST["radio"] == 'This Year'){
						$start_date = date('Y').'-01-01';
						$end_date = date('Y').'-12-31';
					}else if($_REQUEST["radio"] == 'Last 3 Years'){
						$last = date('Y') - 3;
						$first = date('Y') - 1;
						$start_date = $last.'-01-01';
						$end_date = $first.'-12-31';
					}
					//echo $start_date;
					//echo '<br>';			
					//echo $end_date;
					//loop start
					foreach($dbf->fetchOrder('common',"type='payment type'","") as $valpay) {
						
						//Get Amount from Student Enrolled Table with enrolled_date according to payment Type
						if($_REQUEST[centre_id] != ''){
							$cond = "payment_type='$valpay[id]' And centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$start_date' And '$end_date')";
						}else{
							$cond = "payment_type='$valpay[id]' And (paid_date BETWEEN '$start_date' And '$end_date')";
						}
						//echo $cond;
						//echo '<br>';						
						$amount = $dbf->getDataFromTable("student_fees","SUM(paid_amt)", $cond);						
					?>
                      <tr>
                        <td align="center" valign="middle" class="mytext" height="22"><a href="javascript:void(0);" onClick="show_details('<?php echo $valpay[id];?>');"> <span id="plusArrow<?php echo $valpay[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
                        <td align="left" valign="middle" class="mytext"><?php echo $valpay["name"];?></td>
                        <td align="left" valign="middle" class="mytext"><?php echo $amount;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      </tr>
                      <tr style="display:none;" id="<?php echo $valpay[id];?>">
                        <td align="center" valign="middle" class="mytext" height="22">&nbsp;</td>
                        <td colspan="2" align="left" valign="middle" style="padding-top:2px; padding-bottom:2px; padding-left:2px;">
                        
                        <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#999999">
                            <tr class="pedtext">
                              <td width="27%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;Student Name</td>
                              <td width="18%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;Course</td>
                              <td width="9%" align="center" valign="middle" style="background-color:#DDDDDD;">Date</td>
                              <td width="9%" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo CD_SEARCH_PRINT_INVOICE_INVOICENO;?></td>
                              <td width="13%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("ACCOUNTANT_RE_NO");?></td>
                              <td width="12%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;New  / Re-Enroll</td>
                              <td align="right" valign="middle" style="background-color:#DDDDDD;">Amount&nbsp;</td>
                           </tr>
                           <?php
						$color1="#ECECFF";
						$j=1;		  
						foreach($dbf->fetchOrder('student_fees',"payment_type='$valpay[id]' And centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$start_date' And '$end_date')","paid_date") as $valinv){
						
						//Get student name
						$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						
						//Get Course fees			
						$res_course = $dbf->strRecordID("course","*","id='$valinv[course_id]'");
						
						$inv = $dbf->strRecordID("student_enroll","*","student_id='$valinv[student_id]' And course_id='$valinv[course_id]'");
						$enrolled_status = $inv["enrolled_status"];
						?>
						<tr onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
						  <td height="25" align="left" valign="middle"><a href="single-home.php?student_id=<?php echo $valinv[student_id];?>" style="cursor:pointer;">&nbsp;<?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($valinv["student_id"]));?></a></td>
						  <td align="left" valign="middle"><?php echo $res_course["name"]; ?></td>
						  <td align="center" valign="middle"><?php echo $valinv["paid_date"];?></td>
						  <td align="center" valign="middle"><?php echo $dbf->GetBillNo($valinv["student_id"], $valinv["course_id"]);?></td>
						  <td align="center" valign="middle"><?php echo $valinv["invoice_no"];?></td>
						  <td align="center" valign="middle"><?php echo $enrolled_status;?></td>
						  <td width="12%" align="right" valign="middle"><?php echo $valinv["paid_amt"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
						</tr>
                        <?php
						$j++;
						}
						?>
                    	<?php						
							if($color1=="#ECECFF")
							  {
								  $color1 = "#FBFAFA";
							  }
							  else
							  {
								  $color1="#ECECFF";
							  }
							$j++;
						?>
					  </table>
                        
                        </td>
                      </tr>
                      <?php
						  $i = $i + 1;
						  if($color=="#ECECFF"){
							  $color = "#FBFAFA";
						  }else{
							  $color="#ECECFF";
						  }					  
					}
				?>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            </form>
            </td>
          </tr>
          <tr>
          	<td height="25" colspan="9" align="center" valign="middle" bgcolor="#ffffff" class="nametext1">&nbsp;</td>
        </tr>
        </table>
        </td>
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
