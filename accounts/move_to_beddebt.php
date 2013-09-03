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

if($_REQUEST["action"] == "update"){
	
	$amt = base64_decode(base64_decode($_REQUEST['berlitz']));
	$dt = date('Y-m-d');
	
	$str = "beddebt_amt='$amt',beddebt_date='$dt'";
	$dbf->updateTable("student_enroll", $str ,"student_id='$_REQUEST[student_id]' And course_id='$_REQUEST[course_id]'");
	
	header("Location:move_to_beddebt.php?centre_id=$_REQUEST[centre_id]&start_date=$_REQUEST[start_date]&end_date=$_REQUEST[end_date]");
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

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

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
    </table></td>
  </tr>
  <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { sorter: false  },
			8: { sorter: false },
			7: { sorter: false  },
			6: { sorter: false  },
			5: { sorter: false },
			4: { sorter: false },
			3: { sorter: false }
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
</script>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="headingtext"><?php echo constant("AC_MOVETO_BED_DEBT");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp;</td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" colspan="9" align="left" valign="middle" class="leftmenu">&nbsp;<u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="7%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :&nbsp;</td>
                <td width="19%" align="center" valign="middle">
                <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:180px;">
                  <option value="">-- All Centre --</option>
                  <?php
					foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
				  ?>
                  <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                <td width="9%" align="left" valign="middle"><input name="start_date" readonly="" type="text" class="validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                <td width="5%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="8%" align="left" valign="middle"><input name="end_date" readonly="" type="text" class="validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                <td width="8%" align="left" valign="middle" class="hometest_name"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                <td width="12%" align="left" valign="middle">&nbsp;</td>
                <td width="27%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
                  <th width="12%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSENAME");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
                  <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
                  <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
                  <th width="11%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
                  <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_30_DAYS");?></th>
                  <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_60_DAYS");?></th>
                  <th width="5%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student_enroll e,student_group g',"e.centre_id='$_REQUEST[centre_id]' And g.id=e.group_id And g.status='Completed' And (e.enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
					
					$bed_debt_day = $dbf->getDataFromTable("conditions","name","type='Bed Debt'");
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
					
					//loop start
					foreach($dbf->fetchOrder('student_enroll e,student_group g',"e.centre_id='$_REQUEST[centre_id]' And g.id=e.group_id And g.status='Completed' And (e.enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","e.enroll_date","e.*") as $valfee) {
					
					$student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
					$course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
					$group = $dbf->strRecordID("student_group","*","id='$valfee[group_id]'");					
					
					$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valfee[fee_id]'");
					$en_amt = ($course_fees - $valfee["discount"]) + $valfee["other_amt"];
					
					$discount_percent = $dbf->getDiscountPercent($course_fees, $valfee["discount"]);
					
					$paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valfee[student_id]' And course_id='$valfee[course_id]' And status='1'");
					$paid = $paid["SUM(paid_amt)"];
					
					$bal_amt = $dbf->BalanceAmount($valfee["student_id"],$valfee["course_id"]);
															
					$pay_days = date('Y-m-d',strtotime(date("Y-m-d", strtotime($group["end_date"])) . "$bed_debt_day day"));
					$pay_days = $dbf->dateDiff($pay_days,date('Y-m-d'));
					if($bal_amt > 0 && $pay_days > 0){						
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td align="left" valign="middle" class="mycon">&nbsp;<a href="single-home.php?student_id=<?php echo $student[id];?>"><?php echo $student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></a></td>
                      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $group["group_name"];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?></td>
                      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $course["name"];?></td>
                      <td align="right" valign="middle" class="mycon" ><?php echo $valfee["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon" ><?php echo $dbf->getDiscountPercent($course_fees, $valfee["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon" ><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon" ><?php echo $paid;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon" ><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="center" valign="middle" class="mycon" >
                      <?php
                      if($pay_days <= 30){
                          echo $pay_days;
                      }
                      ?>
                      </td>
                      <td align="center" valign="middle" class="mycon" >
                      <?php
                      if($pay_days > 30){
                          echo $pay_days;
                      }
                      ?>
                      </td>
                      <td align="center" valign="middle" class="mycon" >
                      <?php
                      if($valfee["beddebt_amt"] > 0){
                          ?>
                          <img src="../images/tick.png" width="16" height="16" title="Already Bad Debt">
                          <?php
                      }else{
                          ?>
                          <a href="move_to_beddebt.php?action=update&student_id=<?php echo $valfee["student_id"];?>&course_id=<?php echo $valfee["course_id"];?>&berlitz=<?php echo base64_encode(base64_encode($bal_amt));?>&centre_id=<?php echo $_REQUEST["centre_id"];?>&start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/tickbox.png" width="16" height="16" border="0" title="Click here to Move to Bad Debt"></a>
                          <?php
                      }				  
                      ?>
                      </td>
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
               		<?php
					} // Balance amount > 0
					?>
            </table>
            </td>
          </tr>
         
		  <?php
			if($num > 1){
			?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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