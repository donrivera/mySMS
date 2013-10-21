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
        <?php //if($_REQUEST[student_id] != '' && $_REQUEST[start_date] !='' && $_REQUEST[end_date]) { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_student_ledger_report_word.php?student_id=<?php echo $_REQUEST[student_id];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_ledger_report_csv.php?student_id=<?php echo $_REQUEST[student_id];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_ledger_report_pdf.php?student_id=<?php echo $_REQUEST[student_id];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_ledger_report_print.php?student_id=<?php echo $_REQUEST[student_id];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ACCOUNTANT_STUDENT_LEDGER");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp; </td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
              <tr>
                <td height="25" colspan="9" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="10%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_DASHBOARD_STUDENT");?> :&nbsp;</td>
                <td width="20%" align="left" valign="middle">
                <select name="student_id" id="student_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:180px;">
                  <option value=""> Students </option>
                  <?php
					foreach($dbf->fetchOrder('student',"first_name<>'' And id in (select student_id from student_enroll)","first_name") as $valc) {	
				  ?>
                  <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["student_id"]){?> selected="" <?php } ?>>
						<?php echo $valc[first_name]."&nbsp;".$valc[father_name]."&nbsp;".$valc[family_name]."&nbsp;(".$valc[family_name1]."&nbsp;".$valc[grandfather_name1]."&nbsp;".$valc[father_name1]."&nbsp;".$valc[first_name1].")";?>
				  </option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="6%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> :&nbsp;</td>
                <td width="11%" align="left" valign="middle">
                <?php if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				?>
               	<input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></td>
                <td width="4%" align="right" valign="middle" class="hometest_name">
				<?php if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
				<?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="10%" align="left" valign="middle">
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/></td>
                <td width="12%" align="right" valign="middle" class="hometest_name"><?php echo constant("ACCOUNTANT_BAL_AMOUNT_GREATER");?>:&nbsp;</td>
                <td width="2%" align="center" valign="middle"><input type="checkbox" name="balance" id="balance" value="balance" <?php if($_REQUEST[balance]=='balance'){?> checked="checked" <?php } ?>></td>
                <td width="25%" align="left" valign="middle"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" colspan="9" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="10%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_DASHBOARD_STUDENT");?> :&nbsp;</td>
                <td width="18%" align="left" valign="middle">
                <select name="student_id" id="student_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:180px;">
                  <option value=""> Students </option>
                  <?php
					foreach($dbf->fetchOrder('student',"first_name<>''","first_name") as $valc) {
				  ?>
                  <option value="<?php echo $valc["id"];?>" <?php if($valc["id"]==$_REQUEST["student_id"]){?> selected="" <?php } ?>><?php echo $valc[first_name]."&nbsp;".$valc[father_name]."&nbsp;".$valc[family_name]."&nbsp;(".$valc[family_name1]."&nbsp;".$valc[grandfather_name1]."&nbsp;".$valc[father_name1]."&nbsp;".$valc[first_name1].")";?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="8%" align="left" valign="middle" class="hometest_name"><input type="image" src="../images/searchButton.png" width="50" height="22">                  &nbsp;</td>
                <td width="11%" align="left" valign="middle">&nbsp;</td>
                <td width="4%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="10%" align="left" valign="middle">&nbsp;</td>
                <td width="12%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                <td width="2%" align="center" valign="middle">&nbsp;</td>
                <td width="25%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <?php
			$num = $dbf->countRows("student_group_dtls", "student_id='$_REQUEST[student_id]'");
			foreach($dbf->fetchOrder('student_group m,student_group_dtls d', "m.id=d.parent_id And d.student_id='$_REQUEST[student_id]'" ,"m.id","m.start_date,m.end_date,m.id,d.*") as $valfee) {
				$enroll = $dbf->strRecordID("student_enroll", "*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
				$course = $dbf->strRecordID("course", "*", "id='$valfee[course_id]'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
				
				$cr_tot = $course_fees + $enroll["other_amt"];
				$dr_tot = $enroll["discount"];
			?>
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td width="14%" height="25" align="right" valign="middle" class="leftmenu">Group Name :</td>
                <td width="52%" align="left" valign="middle" class="shop2">&nbsp;<span class="shop1"><?php echo $dbf->FullGroupInfo($valfee["parent_id"]);?></span></td>
                <td width="9%">&nbsp;</td>
                <td width="19%" align="center" valign="middle" class="shop1">&nbsp;</td>
                <td width="6%" align="left" valign="middle"></td>
              </tr>
              <tr>
                <td height="25" align="right" valign="middle" class="leftmenu">Course / Level :</td>
                <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $course["name"];?></td>
                <td>&nbsp;</td>
                <td align="center" valign="middle" class="mytext">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="leftmenu">Invoice No :</td>
                <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $dbf->GetBillNo($valfee["student_id"],$valfee["course_id"]);?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" colspan="5" align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="middle" class="leftmenu">
                <table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                  <tr class="shop1">
                    <td width="7%" height="25" align="center" valign="middle" bgcolor="#EEEEEE">Sl</td>
                    <td width="45%" align="left" valign="middle" bgcolor="#EEEEEE">Particulars</td>
                    <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Date</td>
                    <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Amount</td>
                    <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Course Fees</td>
                  </tr>
                  <tr class="shop2">
                    <td height="22" align="center" valign="middle">1</td>
                    <td align="left" valign="middle">&nbsp;Course Fee</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $course_fees;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  </tr>
                  <tr class="shop2">
                    <td height="22" align="center" valign="middle">2</td>
                    <td align="left" valign="middle">&nbsp;Discount</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <?php
					$discount = $dbf->getDiscountPercent($course_fees, $enroll["discount"]);
					?>
                    <td align="right" valign="middle"><?php echo $enroll["discount"];?>&nbsp;[<?php if($discount > 0){echo number_format($discount,2);}?>&nbsp;<?php echo $res_currency[symbol];?>%]</td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr class="shop2">
                    <td height="22" align="center" valign="middle">3</td>
                    <td align="left" valign="middle">&nbsp;Other Amount</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $enroll["other_amt"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  </tr>
                  <?php
				  $k = 4;
					foreach($dbf->fetchOrder('student_fees', "status='1' And student_id='$valfee[student_id]' And course_id='$valfee[course_id]'" ,"id") as $feedtls){
					$dr_tot = $dr_tot + $feedtls["paid_amt"];
					?>
                  <tr class="shop2">
                    <td height="22" align="center" valign="middle"><?php echo $k;?></td>
                    <td align="left" valign="middle">&nbsp;<i>Ref.No</i> <?php echo $feedtls["invoice_no"];?></td>
                    <td align="center" valign="middle">&nbsp;<?php if($feedtls["paid_date"] != '0000-00-00') { echo date('d/M/Y',strtotime($feedtls["paid_date"])); }?></td>
                    <td align="right" valign="middle"><?php echo $feedtls["paid_amt"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <?php $k++; } ?>
                  <tr class="shop2">
                    <td height="22" colspan="3" align="right" valign="middle" class="shop1">Total :</td>
                    <td align="right" valign="middle" bgcolor="#EEEEEE"><?php echo $dr_tot;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                    <td align="right" valign="middle" bgcolor="#EEEEEE"><?php echo $cr_tot;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  </tr>
                  <?php if($dr_tot != $cr_tot){ ?>
                  <tr class="shop2">
                    <td height="22" colspan="3" align="right" valign="middle" class="shop1"><?php if($dr_tot < $cr_tot) { ?> Balance <?php }else{?> Refund <?php } ?>:</td>
                    <td align="right" valign="middle"><?php if($dr_tot < $cr_tot){ echo $cr_tot - $dr_tot; } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
                    <td align="right" valign="middle"><?php if($dr_tot > $cr_tot){ echo abs($dr_tot - $cr_tot); } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  </tr>
                  <?php } ?>
                  <?php if($dr_tot != $cr_tot){ ?>
                  <tr class="shop2">
                    <td height="22" colspan="3" align="right" valign="middle" class="shop1">Total : </td>
                    <td align="right" valign="middle"><?php if($dr_tot < $cr_tot){ echo $cr_tot; } else { echo $dr_tot; } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
                    <td align="right" valign="middle"><?php if($dr_tot > $cr_tot){ echo $dr_tot; } else { echo $cr_tot; }?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  </tr>
                  <?php } ?>
                </table></td>
                </tr>
              <tr>
                <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
            </table>
            <br>
            <?php } ?>
                        
            </td>
          </tr>         
		  <?php		
				if($num == 0 && $num_ad == 0){
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
