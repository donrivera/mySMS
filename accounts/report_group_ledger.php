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
        headers: {  
          9: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
      <tr>
        <td align="left" height="25" valign="top">
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_group_ledger_report_word.php?group_id=<?php echo $_REQUEST[group_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&group_status=<?php echo $_REQUEST[group_status];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_group_ledger_report_csv.php?group_id=<?php echo $_REQUEST[group_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&group_status=<?php echo $_REQUEST[group_status];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_group_ledger_report_pdf.php?group_id=<?php echo $_REQUEST[group_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&group_status=<?php echo $_REQUEST[group_status];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_group_ledger_report_print.php?group_id=<?php echo $_REQUEST[group_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&group_status=<?php echo $_REQUEST[group_status];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table>
        
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">    
    <form name="frm" id="frm" method="post">
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
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ACCOUNTANT_GROUP_LEDGER");?> </td>
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
                <td height="25" colspan="9" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="6%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?> : &nbsp;</td>
                <td width="17%" align="left" valign="middle">
                <select name="group_id" id="group_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:180px;">
                  <option value=""> All Groups </option>
                  <?php
					foreach($dbf->fetchOrder('student_group',"","group_name") as $val_group_dtls) {
				  ?>
                  <option value="<?php echo $val_group_dtls[id];?>"<?php if($_REQUEST[group_id]==$val_group_dtls["id"]){?> selected="selected"<?php } ?>><?php echo $val_group_dtls['group_name'] ?>, <?php echo date('d/m/Y',strtotime($val_group_dtls['start_date']));?> - <?php echo date('d/m/Y',strtotime($val_group_dtls['end_date'])) ?>, <?php echo $val_group_dtls["group_start_time"];?>-<?php echo $val_group_dtls["group_end_time"];?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
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
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                
                <td width="9%" align="left" valign="middle">
                
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/></td>
                <td width="19%" align="left" valign="middle" class="hometest_name">
					Status:
					<select name="group_status" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:100px;" onChange="javascript:document.frm.action='report_group_ledger.php',document.frm.submit();">
						<option value="">Select</option>
						<option value="Not Started"<?php if($_REQUEST["group_status"] == "Not Started") { ?> selected="selected" <?php } ?>>Not Started</option>
                        <option value="Continue"<?php if($_REQUEST["group_status"] == "Continue") { ?> selected="selected" <?php } ?>>Active - In Progress</option>
                        <option value="Completed"<?php if($_REQUEST["group_status"] == "Completed") { ?> selected="selected" <?php } ?>>Completed</option>
					</select>
				</td>
                <td width="27%" align="left" valign="middle">
					<!--<input type="image" src="../images/searchButton.png" width="50" height="22">-->
					<a href="report_group_ledger.php"><input type="image" src="../images/searchButton.png" width="50" height="22"></a>
				</td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="3%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> / <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_COUNT_STU");?></th>
                  <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_EN_AMOUNT");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_BAL_AMOUNT");?></th>
                  </tr>
				</thead>
                <?php
					$group_status=$_REQUEST[group_status];
					
					$i = 1;
					$color="#ECECFF";
					if($_REQUEST[group_id] != '' && $group_status!=''){$group = "id='$_REQUEST[group_id]' AND status='$group_status'";}
					elseif($_REQUEST[group_id] == '' && $group_status!=''){$group="status='$group_status'";}
					elseif($_REQUEST[group_id] != '' && $group_status==''){$group="id='$_REQUEST[group_id]'";}
					elseif($group_status ==''){$group = "id > 0";}
					elseif($_REQUEST[group_id] == ''){$group = "id > 0";}
					else{$group = "id = '$_REQUEST[group_id]'";}
					$num=$dbf->countRows('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'");
					
					//loop start
					foreach($dbf->fetchOrder('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'","group_name") as $valgroup) {
					
					//Count the number o students in student_group_dtls table
					$numofstudent = $dbf->countRows('student_group_dtls', "parent_id='$valgroup[id]'");
					
					//Get Enrollment Amount for a particular group
					$course_fee = 0;
					foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll) {
						if($course_fee == 0){
							$course_fee = $dbf->getDataFromTable("course_fee", "fees", "id='$enroll[fee_id]'");
						}else{
							$course_fee = $course_fee + $dbf->getDataFromTable("course_fee", "fees", "id='$enroll[fee_id]'");
						}
					}
					
					//Get Discount Amount for a particular group
					$en_amt = $dbf->getDataFromTable("student_enroll", "sum(discount)", "group_id='$valgroup[id]'");
					$other_amt = $dbf->getDataFromTable("student_enroll", "sum(other_amt)", "group_id='$valgroup[id]'");
					
					// Get Fees from student fees structure
					$paid_amt = 0;
					if($start_date != '' && $end_date != ''){
						  $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
					}
					foreach($dbf->fetchOrder('student_group_dtls', "parent_id='$valgroup[id]'") as $dtls) {
						
						foreach($dbf->fetchOrder('student_fees', "student_id='$dtls[student_id]' And course_id='$dtls[course_id]' And status='1'".$date_condition) as $enroll) {
							if($paid_amt == 0){
								$paid_amt = $enroll["paid_amt"];
							}else{
								$paid_amt = $paid_amt + $enroll["paid_amt"];
							}
						}
					}
					
					$bal_amt = ($course_fee + $other_amt) - ($en_amt + $paid_amt);
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon">
                  <a href="javascript:void(0);" onClick="show_details('<?php echo "kk".$valgroup["id"];?>');"> <span id="plusArrow<?php echo "kk".$valgroup["id"];?>"><img src="../images/plus.gif" border="0" /></span></a>
                  </td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valgroup["group_name"];?> <?php echo $dbf->printClassTimeFormat($valgroup["group_start_time"],$valgroup["group_end_time"]);?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["start_date"]));?>&nbsp;/&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["end_date"]));?></td>
                  <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $numofstudent;?></td>
                  <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $course_fee;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                </tr>
                <tr style="display:none;" id="<?php echo "kk".$valgroup["id"];?>">
                  <td colspan="6" align="center" valign="middle" class="mycon">
                  
                  <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr class="lable1">
                        <td width="3%" align="left" valign="middle" class="pedtext">&nbsp;</td>
                        <td width="29%" align="left" valign="middle" class="pedtext"><?php echo ADMIN_VIEW_COMMENTS_MANAGE_STUDENT;?></td>
                        <td width="9%" align="left" valign="middle" class="pedtext"><?php echo ADMIN_NEWS_MANAGE_DATE;?></td>
                        <td width="9%" align="center" valign="middle" class="pedtext"><?php echo CD_SEARCH_PRINT_INVOICE_INVOICENO;?></td>
                        <td width="9%" align="left" valign="middle" class="pedtext"><?php echo ADMIN_COURSE_MANAGE_COURSEFEE;?></td>
                        <td width="10%" align="left" valign="middle" class="pedtext"><?php echo ACCOUNTANT_DISOCUNT_AMOUNT;?></td>
                        <td width="12%" align="left" valign="middle" class="pedtext"><?php echo DISCOUNT_PERCENT;?></td>
                        <td width="12%" align="left" valign="middle" class="pedtext"><?php echo ACCOUNTANT_EN_AMT;?></td>
                        <td width="10%" align="left" valign="middle" class="pedtext"><?php echo ACCOUNTANT_REPT_AMT;?></td>
                        <td width="9%" align="left" valign="middle" class="pedtext"><?php echo CD_SEARCH_PRINT_INVOICE_BALANCE;?></td>
                        </tr>
                      <?php
					  foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll_dtls) {
						  
						  //Student Name
						  $student = $dbf->strRecordID("student","*","id='$enroll_dtls[student_id]'");
						  $course_fees = $dbf->getDataFromTable("course_fee", "fees", "id='$enroll_dtls[fee_id]'");
						  $e_amt = $course_fees  - $enroll_dtls["discount"];						  
						  $e_amt1 = ($course_fees + $enroll_dtls["other_amt"]) - $enroll_dtls["discount"];
						  
						  //Receipt amt
						  if($start_date != '' && $end_date != ''){
							  $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
						  }
						  $re_amt =$dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$enroll_dtls[student_id]' And course_id='$enroll_dtls[course_id]' And status='1'".$date_condition);
						  $re_amt = $re_amt["SUM(paid_amt)"];
						  $b_amt = $e_amt - $re_amt;
					  ?>
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                        <td  align="center" valign="middle">
                        <a href="javascript:void(0);" onClick="show_details('<?php echo "dtls".$valgroup["id"].'-'.$enroll_dtls["id"];?>');"> <span id="plusArrow<?php echo "dtls".$valgroup["id"].'-'.$enroll_dtls["id"];?>"><img src="../images/plus.gif" border="0" /></span></a>
                        </td>
                        <td  align="left" valign="middle">&nbsp;<a href="single-home.php?student_id=<?php echo $student["id"];?>" style="cursor:pointer;"><?php echo $student[first_name]."&nbsp;".$student[father_name]."&nbsp;".$student[family_name]."&nbsp;(".$student[family_name1]."&nbsp;".$student[grandfather_name1]."&nbsp;".$student[father_name1]."&nbsp;".$student[first_name1].")";?></a></td>
                        <td align="left" valign="middle">&nbsp;<?php echo date('d-M-Y',strtotime($enroll_dtls["enroll_date"]));?></td>
                        <td align="center" valign="middle"><?php echo $dbf->GetBillNo($enroll_dtls["student_id"], $enroll_dtls["course_id"]);?></td>
                        <td align="right" valign="middle"><?php echo $course_fees;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td align="right" valign="middle"><?php echo $enroll_dtls["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td align="right" valign="middle"><?php echo number_format($dbf->getDiscountPercent($course_fees, $enroll_dtls["discount"]),2);?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td align="right" valign="middle"><?php echo $e_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td align="right" valign="middle"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td align="right" valign="middle"><?php echo $b_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        </tr>
                      <tr style="display:none;" id="<?php echo "dtls".$valgroup["id"].'-'.$enroll_dtls["id"];?>">
                        <td colspan="10"  align="left" valign="middle" style="padding-top:2px; padding-left:2px; padding-bottom:2px;">
                        <table width="65%" border="1" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="7%" align="center" valign="middle" bgcolor="#CCCCCC" class="red_smalltext">Sl.</td>
                            <td width="23%" align="left" valign="middle" bgcolor="#CCCCCC" class="red_smalltext">Payment Date</td>
                            <td width="28%" align="left" valign="middle" bgcolor="#CCCCCC" class="red_smalltext"><?php echo constant("ACCOUNTANT_RE_NO");?></td>
                            <td width="24%" align="left" valign="middle" bgcolor="#CCCCCC" class="red_smalltext">Payment Type</td>
                            <td width="18%" align="right" valign="middle" bgcolor="#CCCCCC" class="red_smalltext">Payment Amount</td>
                          </tr>
                          <?php
						  $sl = 1;
						  if($start_date != '' && $end_date != ''){
							  $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
						  }
						  //echo "student_id='$enroll_dtls[student_id]' And course_id='$enroll_dtls[course_id]' And status='1'".$date_condition;
						  foreach($dbf->fetchOrder('student_fees', "student_id='$enroll_dtls[student_id]' And course_id='$enroll_dtls[course_id]' And status='1'".$date_condition) as $feedtls) {
						  ?>
                          <tr>
                            <td align="center" valign="middle" bgcolor="#FFFFFF" class="mytext"><?php echo $sl;?></td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF" class="mytext"><?php echo $feedtls["paid_date"];?></td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF" class="mytext"><?php echo $feedtls["invoice_no"];?></td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF" class="mytext"><?php echo $dbf->getDataFromTable("common", "name", "id='$feedtls[payment_type]'");?></td>
                            <td align="right" valign="middle" bgcolor="#FFFFFF" class="mytext"><?php echo $feedtls["paid_amt"];?>&nbsp;<?php echo $res_currency["symbol"];?></td>
                          </tr>
                          <?php $sl++; } ?>
                        </table>
                        </td>
                      </tr>
                      <?php
					  }
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
         
		  <?php
			if($num > 1){
			?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle" >
                   <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
                      <tr>
                        <td width="76%" height="25" align="center">&nbsp;</td>
                        <td width="24%" height="25" align="left" >
                        <div id="pager" class="pager" style="text-align:left; padding-top:10px;">
                        <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/>
                        <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                          <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                          <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/>
                          <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
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
                  <td height="25" colspan="9" align="center" valign="middle"  class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
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
