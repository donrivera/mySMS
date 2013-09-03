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
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
			0: { sorter: false },
			1: { sorter: false },   
            6: { sorter: false },
        }
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
			0: { sorter: false },
			1: { sorter: false },   
            6: { sorter: false },
        }
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php } ?>
<!--*******************************************************************-->

<script language="Javascript" type="text/javascript">
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
<script type="text/javascript">
function show_details(a)
{
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
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_word.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_csv.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_pdf.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_not_collect_print.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
        <td width="79%" align="left" valign="top">
        <form name="frm" id="frm" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="30%" height="30" class="logintext">
                  <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></td>
                  <td width="15%" align="right" valign="middle" class="logintext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_PERIODFROM");?>  :&nbsp; </td>
                  <td width="10%" align="left">
                  <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                  <td width="3%" align="center"><span class="logintext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_TO");?></span> :&nbsp; </td>
                  <td width="28%" align="left" valign="middle">
                  <table width="200" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100" align="left" valign="middle">
                      <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                      <td width="100" align="left" valign="middle" style="padding-left:5px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1" border="0" align="left" /></td>
                    </tr>
                  </table></td>
                  <td width="14%" align="left">&nbsp;</td>
                </tr>
            </table>            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
				<th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></th>
                <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></th>
                <th width="28%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>
                </tr>
			  </thead>
              <?php
			    $k=1;
				$i = 1;
				$color = "#ECECFF";
				
				if($_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
					$cond="certificate_collect='0' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And centre_id='$_SESSION[centre_id]'";
				}else{
					$cond="certificate_collect='0' And centre_id='$_SESSION[centre_id]'";
				}

				//Get number of rows
				$num=$dbf->countRows('student_enroll', $cond);
				
				//Get currency
				$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
				
				//Loop start
				foreach($dbf->fetchOrder('student_enroll', $cond ,"","") as $val1){
					$val = $dbf->strRecordID("student","*","id='$val1[student_id]'");	
					$num_dtls=$dbf->countRows('student_enroll',"certificate_collect='0' And student_id='$val[id]'");				
				?>
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td width="3%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');">
                <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span>
                </a></td>
                <td width="5%" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
				<td width="18%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?> <?php echo " [".$num_dtls."]";?></td>
                <td width="18%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                <td width="28%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                <td width="7%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[age];?></td>
                <?php
				if($val["photo"]!=''){
					$photo = "../sa/photo/".$val["photo"];
				}else{
					$photo = "../images/noimage.jpg";
				}
				?>
                <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }
				  ?>
              </tr>
              <tr style="display:none;" id="<?php echo $val[id];?>">
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" colspan="4" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
                <?php if($num_dtls>0) { ?>
                <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="6%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                    <td width="23%" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
                    <td width="16%" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="14%" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?></td>
                    <td width="15%" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("CD_SEARCH_PRINT_INVOICE_INVOICENO");?></td>
                    <td align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("CD_SEARCH_PRINT_INVOICE_BALANCE");?>&nbsp;</td>
                    <td width="12%" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></td>
                  </tr>
                  <?php
					$color1="#ECECFF";
					$j=1;				  
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$val[id]'","id") as $valinv)
					{
						//Get group Dtls
						$val_group = $dbf->strRecordID("student_group","*","id='$valinv[parent_id]'");
														
						//Get Course Name
						$res_course = $dbf->strRecordID("course","*","id='$val_group[course_id]'");
						
						//Get Teacher Name
						$res_teacher = $dbf->strRecordID("teacher","*","id='$val_group[teacher_id]'");
						
						//Get Invoice Number
						$res_enroll = $dbf->strRecordID("student_enroll","*","group_id='$val_group[id]' And course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
						
						//Total Course Fee (Course fee - Discount + Other Amt) 
						$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
						
						//Get Total Payment from structure
						$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$valinv[course_id]' And student_id='$valinv[student_id]' AND status='1'");
						$feeamt = $fee["SUM(paid_amt)"];
						  
						$bal_amt = $camt - $feeamt;						
					?>
                  <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                    <td align="center" valign="middle"><?php echo $j;?></td>
                    <td align="left" valign="middle"><?php echo $val_group[group_name];?> <?php echo $val_group["group_time"];?>-<?php echo $dbf->GetGroupTime($val_group["id"]);?></td>
                    <td align="left" valign="middle"><?php echo $res_course[name];?></td>
                    <td align="left" valign="middle"><?php echo $res_teacher[name];?></td>
                    <td align="center" valign="middle"><?php echo $dbf->GetBillNo($valinv["student_id"], $valinv["course_id"]);?></td>
                    <td width="14%" align="center" valign="middle"><?php echo $bal_amt.'&nbsp;'.$res_currency[symbol];?></td>
                    <td align="center" valign="middle"><?php echo $val_group[status];?></td>
                  </tr>
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
					}
					?>
                </table>
                <?php } ?>
                </td>
                </tr>
              <?php
			  		$k++;

				}
				?>
            </table>            
            </td>
          </tr>         
		  <?php
				if($num!=0)
				{
				?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
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
              
            </table></td>
                </tr>
                <?php }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>
               
        </table>
        </form>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else {?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_word.php"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_csv.php"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_certificate_not_collect_pdf.php"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_not_collect_print.php" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                  <table width="100%" border="0" cellspacing="0">
                        <tr class="logintext">
                          
                          <td width="27%" align="left" valign="middle">
                            <table width="256" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="148" align="left" valign="middle" style="padding-left:5px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn2" border="0" align="left" /></td>
                                <td width="108" align="right" valign="middle">
                                  <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80_ar" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                                </tr>
                              </table></td>
                              <td width="8%" align="left"><span class="headingtext"> :&nbsp;<?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_TO");?></span> </td>
                              <td width="9%" align="left">
                            <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80_ar" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                          <td width="1%" align="left">&nbsp;</td>
                          <td width="30%" align="left" valign="middle" class="headingtext">:&nbsp;<?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_PERIODFROM");?></td>
                          <td width="25%" height="30" align="right" class="headingtext">
                          <img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></td>
                          </tr>
                        </table>                        
                  </td>
                  </tr>
                <tr>
                  <td align="left" valign="top" bgcolor="#FFFFFF">
                    
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                      <thead>
                        <tr class="logintext">
                          <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></th>
                          <th width="28%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                          <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>                          <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></th>
                          <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                          <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                          </tr>
                        </thead>
                      <?php
			    $k=1;
				$i = 1;
				$color = "#ECECFF";

				//Get number of rows
				$num=$dbf->countRows('student_enroll',"centre_id='$_SESSION[centre_id]' And certificate_collect='0'","");
				
				//Get currency
				$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
				
				//Loop start
				foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]'","","") as $val){
					$num_dtls=$dbf->countRows('student_enroll',"certificate_collect='0' And student_id='$val[id]'");
					if($num_dtls>0) {
				?>
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                         <?php if($val["photo"]!=''){
						$photo = "../sa/photo/".$val["photo"];
				        }else{
						$photo = "../images/noimage.jpg";
				        }
				        ?>
                        <td width="18%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                        <td width="28%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                        <td width="7%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[age];?></td>
                        <td width="18%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?> <?php echo " [".$num_dtls."]";?></td>
                        <td width="5%" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
                        <td width="3%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');">
                          <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span>
                          </a></td>
                        <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }
				     ?>
                        </tr>
                      <tr style="display:none;" id="<?php echo $val[id];?>">
                        <td height="25" colspan="4" align="right"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
                          <?php if($num_dtls>0) { ?>
                          <table width="800" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr class="pedtext">
                              
                              <td width="13%" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                              <td width="12%" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_TEACHER");?></td>
                              <td width="21%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("CD_SEARCH_PRINT_INVOICE_INVOICENO");?></td>
                              <td align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("CD_SEARCH_PRINT_INVOICE_BALANCE");?>&nbsp;</td>
                              <td width="12%" align="right" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></td>
                             <td width="12%" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>

                              <td width="5%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                              </tr>
                            <?php
							$color1="#ECECFF";
							$j=1;				  
							foreach($dbf->fetchOrder('student_group_dtls',"student_id='$val[id]'","id") as $valinv)
							{
								//Get group Dtls
								$val_group = $dbf->strRecordID("student_group","*","id='$valinv[parent_id]'");
																
								//Get Course Name
								$res_course = $dbf->strRecordID("course","*","id='$val_group[course_id]'");
								
								//Get Teacher Name
								$res_teacher = $dbf->strRecordID("teacher","*","id='$val_group[teacher_id]'");
								
								//Get Invoice Number
								$res_enroll = $dbf->strRecordID("student_enroll","*","group_id='$val_group[id]' And course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
								
								//Total Course Fee (Course fee - Discount + Other Amt) 
								$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
								
								//Get Total Payment from structure
								$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$valinv[course_id]' And student_id='$valinv[student_id]' AND status='1'");
								$feeamt = $fee["SUM(paid_amt)"];
								  
								$bal_amt = $camt - $feeamt;
								
							?>
                            <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                              
                              
                              <td align="right" valign="middle"><?php echo $res_course[name];?></td>
                              <td align="right" valign="middle"><?php echo $res_teacher[name];?></td>
                              <td align="center" valign="middle"><?php echo $dbf->GetBillNo($valinv["student_id"], $valinv["course_id"]);?></td>
                              <td width="14%" align="center" valign="middle"><?php echo $bal_amt.'&nbsp;'.$res_currency[symbol];?></td>
                              <td align="right" valign="middle"><?php echo $val_group[status];?></td>
                              <td align="right" valign="middle"><?php echo $val_group[group_name];?> <?php echo $val_group["group_time"];?>-<?php echo $dbf->GetGroupTime($val_group["id"]);?></td>
                              <td align="center" valign="middle"><?php echo $j;?></td>
                              </tr>
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
							}
							?>
                            </table>
                          <?php } ?>
                          </td>
                          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                          <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                        </tr>
                      <?php
					}
			  		$k++;
				}
				?>
                      </table>            
                    </td>
                  </tr>         
                <?php
				if($num!=0)
				{
				?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
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
                      
                      </table></td>
                  </tr>
                <? }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                <?php
					}
					?>
                
                </table></td>
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
  <?php include '../footer.php';?>
</table>
<?php }?>

</body>
</html>
