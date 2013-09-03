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
		  0: { 
                sorter: false 
            }, 
          9: { 
                sorter: false 
            }, 
           10: { 
                sorter: false 
            },
			11: { 
                sorter: false 
            },
			8: { 
                sorter: false 
            },
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 25});
	});
</script>
      <tr>
        <td align="left" height="25" valign="top">
        <?php //if($_REQUEST[centre_id] != '' && $_REQUEST[start_date] !='' && $_REQUEST[end_date]) { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_credit_balance_report_word.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_credit_balance_report_csv.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_credit_balance_report_pdf.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_credit_balance_report_print.php?centre_id=<?php echo $_REQUEST[centre_id];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
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
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ACCOUNTANT_CREDIT");?> </td>
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
                <td width="6%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :&nbsp;</td>
                <td width="20%" align="left" valign="middle">
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
                <td width="6%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                <td width="9%" align="left" valign="middle">
                <?php if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				?>
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></td>
                <td width="6%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="10%" align="left" valign="middle">
                <?php if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/></td>
                <td width="8%" align="left" valign="middle" class="hometest_name"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                <td width="8%" align="left" valign="middle">&nbsp;</td>
                <td width="27%" align="left" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                      <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="33%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
                      <th width="29%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                      <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></th>
                      <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_STATUS");?></th>
                      </tr>
                  </thead>
                  <?php
			     	$k=1;
					$i = 1;
					$color = "#ECECFF";
											
					//Loop start
					foreach($dbf->fetchOrder('student', "centre_id='$_REQUEST[centre_id]'","","") as $valstudent){
					
					$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$valstudent[id]'");
					$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
					$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
					
					$total_course_fees = 0;
					foreach($dbf->fetchOrder('student_group_dtls', "student_id='$valstudent[id]'","","") as $dtls){						
						$total_course_fees = $total_course_fees + $dbf->BalanceAmount($dtls["student_id"],$dtls["course_id"]);						
					}
					
					if($total_course_fees < 0){									
					?>
                  <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td width="4%" height="25" align="center" valign="middle" class="contenttext">
                    <a href="javascript:void(0);" onClick="show_details('<?php echo $valstudent[id];?>');"> <span id="plusArrow<?php echo $valstudent[id];?>">
                    <img src="../images/plus.gif" border="0" /></span></a></td>
                    <td width="5%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
                    <td width="33%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $valstudent[id];?>"><?php echo $valstudent[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($valstudent["id"]));?></a></td>
                    <td width="29%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[email];?></td>
                    <td width="19%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[student_mobile];?></td>
                    <td width="10%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $moving["name"];?></td>
                    <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }
				  ?>
                  </tr>
                   
                  <tr style="display:none;" id="<?php echo $valstudent[id];?>">
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" colspan="4" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
                    
                    <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <?php
                    //Loop start
					$chk = 'first';
					foreach($dbf->fetchOrder('student_group_dtls',"centre_id='$_REQUEST[centre_id]' And student_id='$valstudent[id]'","","") as $val_s_course){
						
						$course = $dbf->strRecordID("course","*","id='$val_s_course[course_id]'");
						$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]'");
						
						$paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]' And status='1'");
						
						$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
						$course_fee = ($course_fees - $res_enroll["discount"]) + $res_enroll["other_amt"];
						$paid_amt = $paid["SUM(paid_amt)"];
						$bal_amt = $course_fee - $paid_amt;
						if($bal_amt < 0){
						if($chk == 'first'){
                    ?>
                      <tr>
                        <td height="20" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                        <td align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">Group</td>
                        <td align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">Course</td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Discount</td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo DISCOUNT_PERCENT;?></td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Course Fee</td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Paid Amount</td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Balance amount</td>
                      </tr>
                      <?php } $chk = ''; ?>
                      <tr>
                        <td width="2%" height="20" align="center" valign="middle">
                            <a href="javascript:void(0);" onClick="show_details('<?php echo 'c'.$val_s_course[id];?>');"> <span id="plusArrow<?php echo 'c'.$val_s_course[id];?>">
                                <img src="../images/plus.gif" border="0" /></span>
                            </a>
                        </td>
                        <td width="32%" align="left" valign="middle" class="shop2"><?php echo $dbf->FullGroupInfo($val_s_course["parent_id"]);?></td>
                        <td width="18%" align="left" valign="middle" class="shop2"><?php echo $course["name"];?></td>
                        <td width="8%" align="right" valign="middle" class="shop2"><?php echo $res_enroll["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td width="9%" align="right" valign="middle" class="shop2"><?php echo $dbf->getDiscountPercent($course_fees, $res_enroll["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td width="9%" align="right" valign="middle" class="shop2"><?php echo $course_fees;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td width="10%" align="right" valign="middle" class="shop2"><?php echo $paid_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                        <td width="12%" align="right" valign="middle" class="shop2"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      </tr>
                      <tr style="display:none;" id="<?php echo 'c'.$val_s_course[id];?>">
                        <td align="center" valign="middle">&nbsp;</td>
                        <td colspan="7" align="left" valign="middle">
                        <table width="90%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="6%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                            <td width="18%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                            <td width="18%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                            <td width="19%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                            <td width="23%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                            </tr>
                          <?php
							$j = 1;							
							foreach($dbf->fetchOrder('student_fees',"course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]' And status='1'","") as $vali) {
							
							$dt="";
							$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");				
							?>
                          <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;" >
                            <td align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                            <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                            <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                            <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
                            <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                            <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
                              &nbsp;&nbsp;</td>
                            </tr>
                          <?php $j++; } ?>
                        </table></td>
                        </tr>                      
                      <?php
						}
					}
					?>                      
                    </table>
                    
                    </td>
                  </tr>                 
                  
                  <?php
			  		$k++;
					}
					$total_course_fees = 0;
				}
				?>
                </table>
            </td>
          </tr>         
		  <?php
				if($i > 1)
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
                            <option  value="10">10</option>
                            <option selected="selected" value="25">25</option>
                            <option  value="50">50</option>
                          </select>
                        </div></td>
                      </tr>  
                    </table>
                    </td>
                </tr>
                <?php
					}
					if($i <= 1){
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
