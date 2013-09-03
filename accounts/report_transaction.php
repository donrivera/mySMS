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
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
$count = $res_logout["name"]; // Set timeout period in seconds
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
          5: {// disable it by setting the property sorter to false 
                sorter: false
            }, 
           
        } 
    })			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
      <tr>
        <td align="left" height="25" valign="top">
        <?php //if($_REQUEST[centre_id] != '' && $_REQUEST[start_date] != '' && $_REQUEST[end_date] != '') { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_transaction_report_word.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&payment_type=<?php echo $_REQUEST[payment_type];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_transaction_report_csv.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&payment_type=<?php echo $_REQUEST[payment_type];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_transaction_report_pdf.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&payment_type=<?php echo $_REQUEST[payment_type];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_transaction_report_print.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&payment_type=<?php echo $_REQUEST[payment_type];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table>
        <?php //} ?>            
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <form name="frm" id="frm" >
    <table width="99%" border="0" cellpadding="0" cellspacing="0">
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
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ACCOUNTANT_TRANS");?></td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left"> </td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" colspan="9" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="7%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :&nbsp;</td>
                <td width="21%" align="left" valign="middle">
                <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                  <option value="">-- All Centre --</option>
                  <?php
					foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
				  ?>
                  <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> :&nbsp;</td>
                <?php if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				?>
                <?php if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
                <td width="9%" align="left" valign="middle">                
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></td>
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> :&nbsp; </td>
                <td width="10%" align="left" valign="middle">
                
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/></td>
                <td width="10%" align="right" valign="middle" class="hometest_name"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENTTYPE");?>:&nbsp;</td>
                <td width="12%" align="left" valign="middle">
                <select name="payment_type" id="payment_type" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:110px;">
                <option value=""> Payment Type </option>
                  <?php
					foreach($dbf->fetchOrder('common',"type='payment type'","name") as $valp) {	
				  ?>
                  <option value="<?php echo $valp[id];?>" <?php if($valp["id"]==$_REQUEST["payment_type"]){?> selected="" <?php } ?>><?php echo $valp[name];?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="21%" align="left" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="3%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
                  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_NEWS_MANAGE_DATE;?></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_NEW_EN;?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_STU_EN_AR;?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_REPORT_STUDENT_AWAITING_LEVEL;?></th>
                  <th width="9%" align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_DASHBOARD_AMOUNT;?></th>
                  <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_PAYMENT_MANAGE_PAYMENTTYPE;?></th>
                  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo CD_SEARCH_PRINT_INVOICE_INVOICENO;?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_RE_NO;?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					$cond = '';
					if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] == ''){
						$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] == ''){
						$cond = "centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] != ''){
						$cond = "centre_id='$_REQUEST[centre_id]' And payment_type='$_REQUEST[payment_type]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] != ''){
						$cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And payment_type='$_REQUEST[payment_type]'";
					}
									
					//Get Number of Rows
					$num=$dbf->countRows('student_fees',$cond);
					
					//loop start
					foreach($dbf->fetchOrder('student_fees', $cond." And status='1'" ,"paid_date") as $valfee) {
					
					//Check whether it is for New-Enrollment or Re-enrollment
					$student_enroll = $dbf->strRecordID('student_enroll',"*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
					$enroll = $student_enroll["enrolled_status"];
					
					//Get Student Name
					$student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
					//Get Course Name
					$course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
					//Get Payment Type
					$ptype = $dbf->strRecordID("common","*","id='$valfee[payment_type]'");
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valfee[paid_date];?></td>
                  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $enroll;?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $student[id];?>"><?php echo $student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></a></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valfee[paid_amt];?> <?php echo $res_currency[symbol];?></td>
                  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $ptype[name];?></td>
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dbf->GetBillNo($valfee["student_id"], $valfee["course_id"]);?></td>
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $valfee["invoice_no"];?></td>
                  <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }
				  }
				  ?>
                </tr>
               
            </table></td>
          </tr>
		  <?php
			if($num > 1)
			{
			?>
			 <tr>
			  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				  <tr>
					<td width="76%" height="25" align="center">&nbsp;</td>
					<td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
					  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
					  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
					  <select name="select" class="pagesize">
						<option selected="selected"  value="10">10</option>
						<option value="25">25</option>
						<option  value="50">50</option>
					  </select>
					</div></td>
				  </tr>  
				</table>
				</td>
			</tr>
			<?php
			}					
			if($num <= 0){
			?>
			<tr>
			  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php
			}
			?>		  
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
</body>
</html>
