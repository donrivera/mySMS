<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
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

include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');
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
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },            
        } 
    })			
		.tablesorterPager({container: $("#pager"), size: 50});
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
        <?php //if($_REQUEST[start_date] != '' && $_REQUEST[start_date] != ''){ ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_eped_status_report_word.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_eped_status_report_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_eped_status_report_pdf.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_eped_status_report_print.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
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
                  <td width="39%" height="30" class="headingtext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("LIS_EPED_STATUS");?> </td>
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
                <td height="25" colspan="7" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                </tr>
              <tr>
                <td width="8%" height="25" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
                <td width="9%" align="left" valign="middle"><input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                <td width="4%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
                <td width="8%" align="left" valign="middle"><input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                <td width="7%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?> : &nbsp;</td>
                <td width="5%" align="left" valign="middle">
                <select name="status" id="status">
                <option value=""></option>
                <option value="X" <?php if($_REQUEST[status]=="X") { ?> selected="selected" <?php } ?>>X</option>
                <option value="E" <?php if($_REQUEST[status]=="E") { ?> selected="selected" <?php } ?>>E</option>
                <option value="S" <?php if($_REQUEST[status]=="S") { ?> selected="selected" <?php } ?>>S</option>
                <option value="B" <?php if($_REQUEST[status]=="B") { ?> selected="selected" <?php } ?>>B</option>
                <option value="V" <?php if($_REQUEST[status]=="V") { ?> selected="selected" <?php } ?>>V</option>
                <option value="A" <?php if($_REQUEST[status]=="A") { ?> selected="selected" <?php } ?>>A</option>
                <option value="L" <?php if($_REQUEST[status]=="L") { ?> selected="selected" <?php } ?>>L</option>
                </select>
                </td>
                <td width="59%" align="left" valign="middle">
                  <input type="image" src="../images/searchButton.png" width="50" height="22">
                </td>
              </tr>
              <tr>
                <td height="5" colspan="7" align="left" valign="middle">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="5%" height="30" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="80%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("LIS_COUNT");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";					
					$num=$dbf->countRows('student_fees', $group);
					$days = $dbf->dateDiff($_REQUEST[start_date],$_REQUEST[end_date]);
					
					$status = $_REQUEST[status];
					
					//loop start
					for($k = 0; $k <= $days; $k++){
						if($k == 0){
							$st = $_REQUEST[start_date];
						}else{
							$st = date('Y-m-d',strtotime(date("Y-m-d", strtotime($st)) . "1 day"));
						}
						$no_stu = $dbf->countRows("ped_attendance","(shift1='$status' OR shift2='$status' OR shift3='$status' OR shift4='$status' OR shift5='$status' OR shift6='$status' OR shift7='$status' OR shift8='$status' OR shift9='$status') And attend_date='$st'");
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon">
                  <a href="javascript:void(0);" onClick="show_details('<?php echo "kk".$k;?>');"> <span id="plusArrow<?php echo "kk".$k;?>"><img src="../images/plus.gif" border="0" /></span></a>
                  </td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $st;?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $no_stu;?></td>
                  </tr>
                <tr style="display:none;" id="<?php echo "kk".$k;?>">
                  <td align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="mycon">
                  <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                    <tr class="lable1">
                      <td width="4%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                      <td width="23%" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></td>
                      <td width="13%" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                      <td width="41%" align="left" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></td>
                      <td width="19%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("LIS_TOTAL_OF_STATUS");?></td>
                    </tr>
                    <?php
					  $j = 1;
					  foreach($dbf->fetchOrder('ped_attendance', "(shift1='$status' OR shift2='$status' OR shift3='$status' OR shift4='$status' OR shift5='$status' OR shift6='$status' OR shift7='$status' OR shift8='$status' OR shift9='$status') And attend_date='$st'") as $enroll_dtls) {
						  
						  //Student Name
						  $student = $dbf->strRecordID("student","*","id='$enroll_dtls[student_id]'");
						  $teacher = $dbf->strRecordID("teacher","*","id='$enroll_dtls[teacher_id]'");
						  $group = $dbf->strRecordID("student_group","*","id='$enroll_dtls[group_id]'");
						  $unit = $dbf->countRows("ped_units","material_overed<>'' And group_id='$enroll_dtls[group_id]'");
					  ?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td align="center" valign="middle"><?php echo $j;?></td>
                      <td align="left" valign="middle">&nbsp;<?php echo $student["first_name"];?>&nbsp;<?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td align="left" valign="middle">&nbsp;<?php echo $teacher["name"];?></td>
                      <td align="left" valign="middle"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                      <td align="center" valign="middle"><?php echo $unit;?>&nbsp;</td>
                    </tr>
                    <?php
						$j++;
					  }
					  ?>
                  </table></td>
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
            </table>
            </td>
          </tr>         
		  <?php
			if($i <= 1){
			?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
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