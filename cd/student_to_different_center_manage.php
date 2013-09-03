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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

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
		  10: { sorter: false },
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
		  10: { sorter: false },
		  
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php } ?>
<!--*******************************************************************-->
</head>
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
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include'left_menu.php'?></td>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("SA_CENTER_CENTER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top">
            <form name="frm" id="frm" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#000000" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle">&nbsp;</th>
                <th width="5%" align="left" valign="middle" class="pedtext" >From :</th>
                <?php if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				?>
				<th width="12%" align="left" valign="middle" class="pedtext" >
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></th>
				 <th width="4%" align="left" valign="middle" class="pedtext" >To :</th>
                 <?php if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
                 <th width="10%" align="left" valign="middle" class="pedtext" >                 
                 <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/>
                 </th>
                 <th width="66%" colspan="3" align="left" valign="middle" class="pedtext" ><input type="image" src="../images/searchButton.png" width="50" height="22" /></th>
              </tr>
			  </thead>
              
            </table>
            </form>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                <th width="11%" align="left" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Students</th>
                <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
			  </thead>
              <?php					
					$i = 1;
					$color = "#ECECFF";
					
					$cond = '';
					if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != ''){
						$cond = "(dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else{
						$cond = "(dated BETWEEN '$start_date' And '$end_date')";
					}
					
                    $num=$dbf->countRows('transfer_different_centre',"centre_id='$_SESSION[centre_id]' And ".$cond,"");
					
					foreach($dbf->fetchOrder('transfer_different_centre',"centre_id='$_SESSION[centre_id]' And ".$cond,"id DESC ","*") as $transfer){
					
					//No. of students has been transfer
					$noofstudent = $dbf->countRows("transfer_different_centre_dtls","parent_id='$transfer[id]'");
					
					//Name of the students
					$student = '';
					foreach($dbf->fetchOrder('transfer_different_centre_dtls',"parent_id='$transfer[id]'","") as $dtls){
						if($student == ''){
							$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}else{
							$student = $student.'<br>'.$dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}
					}
					
					$centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
					$centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
					
					$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
					$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
					
					$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
					$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
					?>
              <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                <td align="center" valign="middle" >
                <?php if($transfer["status"] == 'Pending'){?>
                <a href="student_to_different_center_status.php?tran_id=<?php echo $transfer["id"];?>&page=student_to_different_center_status.php&amp;TB_iframe=true&amp;height=300&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/change_status2.png" width="16" height="16" border="0" title="Set Status" /></a>
                <a href="student_to_student_process.php?action=delete&amp;del_id=<?php echo $transfer[id];?>"  class="linktext" ></a>
                <?php } if($transfer["status"] == 'Rejected'){?><img src="../images/change_status2.png" width="16" height="16" border="0" title="Rejected" />
                <?php } if($transfer["status"] == 'Approved'){?><img src="../images/tickbox.png" width="16" height="16" border="0" title="Approved" />
                <?php } ?>
                </td>
                <?php
					$numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
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
			if($num!=0)
			{
			?>            
          <tr>
            <td>
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" valign="top" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
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
      <?php
		}
		if($num==0)
		{
		?>
	  <tr>
		<td height="30"  colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
	  </tr>
		<?php
		}
		?>
    </table>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
                    <table width="100%" border="0" cellspacing="0">
                      <tr>
                        <td width="8%" align="left">&nbsp;</td>
                        <td width="22%">&nbsp;</td>
                        <td width="8%" align="left">&nbsp;</td>
                        <td width="8%" align="left">&nbsp;</td>                        
                        <td width="54%" height="30" align="right" class="logintext"><?php echo constant("SA_CENTER_CENTER");?></td>
                        </tr>
                      </table></td>
                  </tr>
                <tr>
                  <td  align="left" valign="top">
                  <form name="frm" id="frm" >
                    <?php if($_REQUEST[start_date]!=''){
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
                    <table width="100%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#000000" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                      
                         <th width="66%" colspan="3" align="right" valign="middle" class="pedtext" >
                         <input type="image" src="../images/searchButtonar.png" width="50" height="22" /></th>
                         <th width="10%" align="right" valign="middle" class="pedtext" >                 
                         <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/>
                         </th>
                         <th width="4%" align="left" valign="middle" class="pedtext" >: <?php echo constant('ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO');?></th>
                         <th width="12%" align="right" valign="middle" class="pedtext" >
                        <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></th>
                         <th width="5%" align="left" valign="middle" class="pedtext" >: <?php echo constant('ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM');?></th>
                         <th width="3%" height="25" align="center" valign="middle">&nbsp;</th>
                      </tr>
                      </thead>
                      
                    </table>
            		</form>
                    <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                      <thead>
                        <tr class="logintext">
                          <th width="4%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                          <th width="10%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:20px;"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                          <th width="7%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                          <th width="10%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                          <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                          <th width="4%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                          <th width="16%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_STUDENTNAME");?></th>
                          <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                          <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                          <th width="8%" align="right" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                          <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                          </tr>
                        </thead>
                      <?php					
					$i = 1;
					$color = "#ECECFF";
					
					$cond = '';
					if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != ''){
						$cond = "(dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else{
						$cond = "(dated BETWEEN '$start_date' And '$end_date')";
					}
					
                    $num=$dbf->countRows('transfer_centre_to_centre',"centre_id='$_SESSION[centre_id]' And ".$cond,"");					
					foreach($dbf->fetchOrder('transfer_centre_to_centre',"centre_id='$_SESSION[centre_id]' And ".$cond,"id DESC ","*") as $transfer){
					
					//No. of students has been transfer
					$noofstudent = $dbf->countRows("transfer_centre_to_centre_dtls","parent_id='$transfer[id]'");
					
					//Name of the students
					$student = '';
					foreach($dbf->fetchOrder('transfer_centre_to_centre_dtls',"parent_id='$transfer[id]'","") as $dtls){
						if($student == ''){
							$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}else{
							$student = $student.'<br>'.$dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}
					}
					
					$centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
					$centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
					
					$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
					$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
					
					$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
					$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
					?>
                      <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                        <td align="center" valign="middle" >
                          <?php if($transfer["status"] == 'Pending'){?>
                          <a href="center_to_center_status.php?tran_id=<?php echo $transfer["id"];?>&page=center_to_center_status.php&amp;TB_iframe=true&amp;height=300&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/change_status2.png" width="16" height="16" border="0" title="Set Status" /></a>
                          <a href="student_to_student_process.php?action=delete&amp;del_id=<?php echo $transfer[id];?>"  class="linktext" ></a>
                          <?php } if($transfer["status"] == 'Rejected'){?><img src="../images/change_status2.png" width="16" height="16" border="0" title="Rejected" />
                          <?php } if($transfer["status"] == 'Approved'){?><img src="../images/tickbox.png" width="16" height="16" border="0" title="Approved" />
                          <?php } ?>
                          </td>                        
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                        <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                        <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>                        
                      <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                      <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
						<?php
                        $numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
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
			if($num!=0)
			{
			?>            
                <tr>
                  <td>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                      <tr>
                        <td width="76%" align="center">&nbsp;</td>
                        <td width="24%" align="left" valign="top" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
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
                  <?php
				}
				if($num==0)
				{
				?>
                      <tr>
                        <td height="30"  colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                        </tr>
                      <?php
				}
				?>
                </table>
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
