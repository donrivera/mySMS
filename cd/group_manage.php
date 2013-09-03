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

//echo $s = date('H:i:s',strtotime("3:30 PM"));

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
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

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
            // assign the secound column (we start counting zero) 
           0: { sorter: false }, 
			1: { sorter: false }, 
			10: { sorter: false },            
        } 
    })			
		.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
           0: { sorter: false }, 
			9: { sorter: false },   
	        10: { sorter: false },   
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<?php } ?>
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

<script language="javascript" type="text/javascript">
function setvalue(pid,sid,cid,type,val){
	
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lblset').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblset').innerHTML=c;
		}
	}

	ajaxRequest.open("GET", "group_course_process.php?action=setstatus&" + "&pid=" + pid + "&sid=" + sid + "&cid=" + cid + "&type=" + type + "&val=" + val, true);
	ajaxRequest.send(null); 
}
</script>

<script type="text/javascript">
function gotfocus(){
  document.getElementById('name').focus();
}
</script>

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
    <td align="left" valign="top">
    
    <form name="frm" id="frm" method="post">
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="29%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_MANAGE_GROUPING");?></td>
                <td width="27%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%" align="right" valign="middle" class="logintext">Status : &nbsp;</td>
                    <td width="70%" align="left" valign="middle">
                      <select name="group_status" id="group_status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="javascript:document.frm.action='group_manage.php',document.frm.submit();">
                        <option value="All">-- All --</option>
                        <option value="Not Started" <?php if($_REQUEST["group_status"] == "Not Started") { ?> selected="selected" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($_REQUEST["group_status"] == "Continue" || $_REQUEST["group_status"] == "") { ?> selected="selected" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($_REQUEST["group_status"] == "Completed") { ?> selected="selected" <?php } ?>>Completed</option>
                      </select>
                     </td>
                  </tr>
                </table></td>
                <td width="23%" align="left">&nbsp;</td>
                <td width="7%" align="left">&nbsp;</td>
                <td width="14%" align="left"><a href="group_course.php"><input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
              <thead>
                <tr class="logintext">
                  <th width="1%" height="6%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></th>
                  <th width="8%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_GROUP_MANAGE_NOUNITS");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPSTART");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPEND");?></th>
                  <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_GROUPTIME");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_GROUP_MANAGE_CLASSROOM");?></th>
                  <th width="4%"colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ACTION_CAPTION_DELETE");?></th>
                </tr>
              </thead>
              <?php
			     $k=1;
					$i = 1;
					$color = "#ECECFF";
					
					$cond = '';
					if($_REQUEST["group_status"] != ""){
						if($_REQUEST["group_status"] != "All"){
							$cond = " And status='$_REQUEST[group_status]'";
						}
					}else{
						$cond = " And status='Continue'";
					}

					//Get number of rows
                    $num=$dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $val){
										
					//Get group name
					$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Get teacher name
					$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					
					//Get Classroom Number
					$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
					
					//Get Unit
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");
					
			        $num_dtls=$dbf->countRows('student_group_dtls',"parent_id='$val[id]' And student_id in (select id from student)");
					?>
              <tr bgcolor="<?php echo $color;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td width="1%" height="6%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
                <td width="3%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
                <td width="11%" align="center" valign="middle" class="mycon" style="padding-left:5px;">
                <a href="group_manage_chart.php?group_id=<?php echo $val[id];?>&page=group_manage_chart.php&amp;TB_iframe=true&amp;height=440&amp;width=402&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox " style="text-decoration:none;"><?php echo $val[group_name]." [".$num_dtls."]";?></a>
                </td>
                <td width="12%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                <td width="15%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_teacher[name];?></td>
                <td width="8%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_unit[name];?> <?php echo constant("RECEPTION_GROUP_MANAGE_UNITDAY");?></td>
                <?php
				if($val[room_id] > 0){
					$no = $val_room["name"];
				}else{
					$no = "";
				}
				?>
                <td width="11%" align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo date('d-M-Y',strtotime($val[start_date]));?></td>
                <td width="11%" align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo date('d-M-Y',strtotime($val[end_date]));?></td>
                <td width="12%" align="center" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $val[group_time];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                <td width="12%" height="25" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no;?></td>
                <td width="4%" align="center" valign="middle" style="background-color:<?php echo $color;?>" ><a href="group_course_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')">
                  <?php if($num_dtls <=0 ) { ?>
                  <img src="../images/delete.png"width="16" height="16" border="0" title="Delete" />
                  <?php } ?>
                </a></td>
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
				  ?>
              </tr>
              <tr style="display:none;" id="<?php echo $val[id];?>">
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" colspan="9" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;"><?php if($num_dtls <=0 ) { ?>
                  <table width="400" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TEXT2");?></td>
                    </tr>
                  </table>
                  <?php
                }
				else
				{	
				?>
                  <table width="900" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr class="pedtext">
                      <td width="4%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                      <td width="21%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></td>
                      <td width="11%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTID");?></td>
                      <td width="14%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></td>
                      <td width="15%" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></td>
                      <td colspan="2" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PAYMENTTYPE");?>&nbsp;</td>
                      <td width="9%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_BOOKRECEIV");?></td>
                      <td width="6%" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("VIP");?></td>
                    </tr>
                    <?php
					//Get currency
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
						
					$color1="#ECECFF";
					$j=1;				  
					foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$val[id]'","id") as $valinv){
						
						//Get student name
						$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						
						//Get Course fees			
						$res_course = $dbf->strRecordID("course","*","id='$valinv[course_id]'");								 
														
						//Get initial payment
						$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
						
						//Total Course Fee (Course fee - Discount + Other Amt) 
						$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
						
						//Get Total Payment from structure
						$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$valinv[course_id]' And student_id='$valinv[student_id]' AND status='1'");
						$feeamt = $fee["SUM(paid_amt)"];
						  
						$bal_amt = $camt - $feeamt;
						
						//Get the number of student in a group
						$is_student = $dbf->countRows('student',"id='$valinv[student_id]'");						
						
						$is_book_received = $dbf->countRows("student_material", "course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
					if($is_student > 0)
					{
					?>
                    <tr bgcolor="<?php echo $color1;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                      <td align="center" valign="middle"><?php echo $j;?></td>
                      <td align="left" valign="middle"><a href="single-home.php?student_id=<?php echo $val_student[id];?>" style="cursor:pointer;"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></a></td>
                      <td align="left" valign="middle"><?php if($val_student[student_id]>0) { echo $val_student[student_id]; } ?></td>
                      <td align="left" valign="middle"><?php echo $val_student[student_mobile];?></td>
                      <td align="left" valign="middle"><?php echo $val_student[email];?></td>
                      <td width="10%" align="center" valign="middle"><?php if($bal_amt>0) { echo "Partial Payment <br> (".$bal_amt." ".$res_currency["symbol"].")"; } else if($bal_amt<0){ echo "Paid Excess ".abs($bal_amt).'&nbsp;'.$res_currency[symbol];}?></td>
                      <td width="10%" align="center" valign="middle"><?php if($bal_amt==0 && $feeamt>0) { echo "Full Payment"; } ?></td>
                      
                      <td align="center" valign="middle">
                      <input type="checkbox" disabled="disabled" name="book2" <?php if($is_book_received > 0){?> checked="checked" <?php }?> /></td>
                      <td align="center" valign="middle"><?php echo $dbf->VVIP_Icon($val_student["id"]);?></td>
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
						
						}
						$j++;
					}
					?>
                  </table>
                  <?php
				}
				?></td>
              </tr>
              <?php
			  $k++;
				}
				?>
            </table></td>
          </tr>
		  <?php if($num > 0) { ?>
          <tr>
              <td height="300" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
                <tr>
                  <td width="76%" align="center">&nbsp;</td>
                  <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                    <input name="text" type="text" class="pagedisplay trans" size="5" readonly="readonly" style="border:solid 1px; border-color:#FFCC00;"/>
                    <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                    <select name="select" class="pagesize">
                      <option selected="selected"  value="10">10</option>
                      <option value="25">25</option>
                      <option  value="50">50</option>
                    </select>
                  </div></td>
                </tr>
                <?php
			   }
				if($num==0){
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
      </tr>
    </table>
    </form>
    </td>
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
                  <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="15%" align="left"><a href="group_course.php"><input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="9%">&nbsp;</td>
                      <td width="10%" align="left">&nbsp;</td>
                      <td width="24%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    
                    <td width="70%" align="right" valign="middle">
                      <select name="group_status" id="group_status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="javascript:document.frm.action='group_manage.php',document.frm.submit();">
                        <option value="All">-- <?php echo constant("CD_CENTRE_SCHEDULE_All");?> --</option>
                        <option value="Not Started" <?php if($_REQUEST["group_status"] == "Not Started") { ?> selected="selected" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($_REQUEST["group_status"] == "Continue" || $_REQUEST["group_status"] == "") { ?> selected="selected" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($_REQUEST["group_status"] == "Completed") { ?> selected="selected" <?php } ?>>Completed</option>
                      </select>
                     </td>
                     <td width="30%" align="center" valign="middle" class="logintext"> : <?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
                  </tr>
                </table></td>
                      <td width="6%" align="left">&nbsp;</td>                      
                      <td width="36%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_MANAGE_GROUPING");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td  align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">                        
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ACTION_CAPTION_DELETE");?></th>
                        
                        
                        <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_GROUP_MANAGE_NOUNITS");?></th>
                        <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPSTART");?></th>
                        <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_TEACHER_OVERTIME_REPORT_GROUPTIME");?></th>
                        <th width="10%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPEND");?></th>
                        <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_GROUP_MANAGE_CLASSROOM");?></th>
                        <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></th>
                        <th width="10%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></th>
                        <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                        <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                        <th width="3%" height="6%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                        </tr>
                      </thead>
                    <?php
			     	$k=1;
					$i = 1;
					$color = "#ECECFF";
					
					$cond = '';
					if($_REQUEST["group_status"] != ""){
						if($_REQUEST["group_status"] != "All"){
							$cond = " And status='$_REQUEST[group_status]'";
						}
					}else{
						$cond = " And status='Continue'";
					}

					//Get number of rows
                    $num=$dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'".$cond,"","") as $val){
										
					//Get group name
					$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Get teacher name
					$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					
					//Get Classroom Number
					$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
					
					//Get Unit
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");
					
			        $num_dtls=$dbf->countRows('student_group_dtls',"parent_id='$val[id]' And student_id in (select id from student)");
					?>
                    <tr bgcolor="<?php echo $color;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td width="4%" align="center" valign="middle" style="background-color:<?php echo $color;?>" ><a href="group_course_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')">
                        <?php if($num_dtls <=0 ) { ?>
                        <img src="../images/delete.png"width="16" height="16" border="0" title="Delete" />
                        <?php } ?>
                        </a></td>
                      
                      
                      <td width="11%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_unit[name];?> <?php echo constant("RECEPTION_GROUP_MANAGE_UNITDAY");?></td>
						<?php
                        if($val[room_id] != "0"){
                        	$no = $val_room["name"];
                        }else{
                        	$no = "";
                        }
                        ?>
                      <td width="12%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val[start_date]));?></td>
                      <td width="12%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[group_time];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                      <td width="10%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val[end_date]));?></td>
                      <td width="11%" height="25" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no;?></td>
                      <td width="11%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_teacher[name];?></td>
                      <td width="10%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                      <td width="12%" align="center" valign="middle" class="mycon" style="padding-left:5px;">
                        <a href="group_manage_chart.php?group_id=<?php echo $val[id];?>&page=group_manage_chart.php&amp;TB_iframe=true&amp;height=440&amp;width=402&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox " style="text-decoration:none;"><?php echo $val[group_name]." [".$num_dtls."]";?></a>
                        </td>
                        <td width="4%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
                        <td width="3%" height="6%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
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
				  ?>
                      </tr>
                    <tr style="display:none;" id="<?php echo $val[id];?>">
                      
                      
                      <td height="25" colspan="9" align="right"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;"><?php if($num_dtls <=0 ) { ?>
                        <table width="400" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TEXT2");?></td>
                            </tr>
                          </table>
                        <?php } else { ?>
                        <table width="900" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr class="pedtext">
                            <td width="5%" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;</td>
                            <td width="9%" height="25" align="center" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_BOOKRECEIV");?></td>
                                                                                    
                            <td colspan="2" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PAYMENTTYPE");?>&nbsp;</td>
                            <td width="18%" align="right" valign="middle" style="background-color:#DDDDDD;padding-right:25px;">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></td>
                            <td width="13%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;padding-right:25px;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></td>
                            <td width="11%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;padding-right:25px;" >&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTID");?></td>                        
                            <td width="20%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;padding-right:25px;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></td>
                            <td width="4%" align="right" valign="middle" style="background-color:#DDDDDD;padding-right:25px;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                            </tr>
                          <?php
					//Get currency
					$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
						
					$color1="#ECECFF";
					$j=1;				  
					foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$val[id]'","id") as $valinv){
						
						//Get student name
						$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						
						//Get Course fees			
						$res_course = $dbf->strRecordID("course","*","id='$valinv[course_id]'");								 
														
						//Get initial payment
						$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
						
						//Total Course Fee (Course fee - Discount + Other Amt) 
						$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
						
						//Get Total Payment from structure
						$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$valinv[course_id]' And student_id='$valinv[student_id]' AND status='1'");
						$feeamt = $fee["SUM(paid_amt)"];
						  
						$bal_amt = $camt - $feeamt;
						
						//Get the number of student in a group
						$is_student = $dbf->countRows('student',"id='$valinv[student_id]'");						
						$is_book_received = $dbf->countRows("student_material", "course_id='$valinv[course_id]' And student_id='$valinv[student_id]'");
						if($is_student > 0){?>
                          <tr bgcolor="<?php echo $color1;?>" onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                            <td align="center" valign="middle"><?php echo $dbf->VVIP_Icon($val_student["id"]);?></td>
                            <td align="center" valign="middle">
                            <input type="checkbox" disabled="disabled" name="book" <?php if($is_book_received > 0){?> checked="checked" <?php }?> />
                            </td>                            
                            <td width="10%" align="center" valign="middle"><?php if($bal_amt>0) { echo "Partial Payment <br> (".$bal_amt." ".$res_currency["symbol"].")"; } else if($bal_amt<0){ echo "Paid Excess ".abs($bal_amt).'&nbsp;'.$res_currency[symbol];}?></td>
                            <td width="10%" align="center" valign="middle"><?php if($bal_amt==0 && $feeamt>0) { echo "Full Payment"; } ?></td>  
                            <td align="right" valign="middle"><?php echo $val_student[email];?></td>
                            <td align="right" valign="middle"><?php echo $val_student[student_mobile];?></td>
                            <td align="right" valign="middle"><?php if($val_student[student_id]>0) { echo $val_student[student_id]; } ?></td>                          
                            <td align="right" valign="middle"><a href="javascript:void(0);" onclick="window.open('authonication.php?student_id=<?php echo $val[id];?>','_blank');" style="cursor:pointer;"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></a></td>
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
						
						}
						$j++;
					}
					?>
                          </table>
                        <?php } ?>
                </td>
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                      </tr>
                    <?php
			  $k++;
					}
					?>
                    </table></td>
                  </tr>
                <?php
					if($num!=0)
					{
					?>
                
                <tr>
                  <td height="300" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
                    <tr>
                      <td width="76%" align="center">&nbsp;</td>
                      <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="readonly" style="border:solid 1px; border-color:#FFCC00;"/>
                        <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                        <select name="select" class="pagesize">
                          <option selected="selected"  value="10">10</option>
                          <option value="25">25</option>
                          <option  value="50">50</option>
                          </select>
                        </div></td>
                      </tr>
                    <?php
			   }
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
