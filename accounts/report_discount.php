<?php
ob_start();
session_start();
if(!isset($_COOKIE['cook_username']))
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

<!--table sorter ***************************************************** -->
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: {  
          9: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
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

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
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
      <tr>
        <td align="left" height="25" valign="top">
        <?php //if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != ''){ ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_discount_report_word.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&discount_from=<?php echo $_REQUEST[discount_from];?>&discount_to=<?php echo $_REQUEST[discount_to];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_discount_report_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&discount_from=<?php echo $_REQUEST[discount_from];?>&discount_to=<?php echo $_REQUEST[discount_to];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_discount_report_pdf.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&discount_from=<?php echo $_REQUEST[discount_from];?>&discount_to=<?php echo $_REQUEST[discount_to];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_discount_report_print.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&discount_from=<?php echo $_REQUEST[discount_from];?>&discount_to=<?php echo $_REQUEST[discount_to];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ACCOUNTANT_DISCOUNTS");?> </td>
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" colspan="7" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="8%" height="25" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                <?php
                if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
                <td width="10%" align="left" valign="middle">                
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></td>
                <td width="6%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="9%" align="left" valign="middle">                
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/></td>
                <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="33%" align="left" valign="middle"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="38%" class="hometest_name">Discount From / To :</td>
                    <?php
					if($_REQUEST["discount_from"] == ''){
						$discount_from = 100;
					}else{
						$discount_from = $_REQUEST["discount_from"];
					}
					if($_REQUEST["discount_to"] == ''){
						$discount_to = 500;
					}else{
						$discount_to = $_REQUEST["discount_to"];
					}					
					?>
                    <td width="31%" align="left">
                    <input name="discount_from" type="text" class="new_textbox80" id="discount_from" value="<?php echo $discount_from;?>" onKeyPress="return isNumberKey(event);" />
                    &nbsp;&nbsp;</td>
                    <td width="31%" align="left">
                    <input name="discount_to" type="text" class="new_textbox80" id="discount_to" value="<?php echo $discount_to;?>" onKeyPress="return isNumberKey(event);" /></td>
                    </tr>
                </table></td>
                <td width="31%" align="left" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
              </tr>
              <tr>
                <td height="5" colspan="7" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
                  <th width="11%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="9%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
                  <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
                  <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					$cond = '';
					if($_REQUEST["discount_from"] == ''){
						$discount_from = 100;
					}else{
						$discount_from = $_REQUEST["discount_from"];
					}
					if($_REQUEST["discount_to"] == ''){
						$discount_to = 600;
					}else{
						$discount_to = $_REQUEST["discount_to"];
					}
					if($discount_from == '0' && $discount_to == '0'){
						$cond = "(enroll_date BETWEEN '$start_date' And '$end_date')";
					}else if($discount_from != '' && $discount_to != ''){
						$cond = "(discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
					}else{
						$cond = "(enroll_date BETWEEN '$start_date' And '$end_date') And (discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
					}
					//echo $cond;
					//Get Number of Rows
					$num=$dbf->countRows('student_enroll', $cond);
					
					//loop start
					foreach($dbf->fetchOrder('student_enroll', $cond,"enroll_date") as $valenroll) {
					
					//Get Student Name
					$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
					
					//Get Course Name
					$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
					
					//Check whether it is for New-Enrollment or Re-enrollment
					$enroll = $valenroll["enrolled_status"];
										
					//Get Group Name
					$group = $dbf->strRecordID("student_group","*","id='$valenroll[course_id]'");
					$course_fees = $dbf->getDataFromTable("course_fee", "fees", "id='$valenroll[fee_id]'");
					
					//Enrollment Amount
					$en_amt = $course_fees;
					
					$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
					$re_amt = $re_amt["SUM(paid_amt)"];
										
					$bal_amt = $en_amt - $re_amt - $valenroll["discount"];
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo date('d-M-Y',strtotime($valenroll[payment_date]));?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<a href="single-home.php?student_id=<?php echo $student[id];?>"><?php echo $student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></a></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $course[name];?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $enroll;?></td>
                  <td align="left" valign="middle" class="mycon"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo number_format($valenroll[discount],0);?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo number_format($dbf->getDiscountPercent($course_fees, $valenroll["discount"]),0);?>%</td>
                  <td align="right" valign="middle" class="mycon"><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="contenttext"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
				  }
				  ?>
                </tr>
               
            </table></td>
          </tr>         
		  <?php
			if($num > 0)
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
