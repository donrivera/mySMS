<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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
          2: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
<!--*******************************************************************-->

<script type="text/javascript">
function errorconfirm()
{
	alert("Record can't be deleted as it has been used in the other part of Application.")
}
function errorconfirm_edit()
{
	alert("Record can't be edit as it has been used in the other part of Application.")
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
<style>
.mytextarea{width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;}
</style>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_SMS_PARAMETER_TEMPLETE_SMS_PARA_TEMP");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"></td>
                <td width="8%" align="left"><a href="home.php">
                <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" >
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">              
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
			  <tr>
                <td bgcolor="#FFFFFF" align="center" valign="top">
                <form action="sms_parameter_process.php?action=insert" name="frm" method="post" id="frm">
                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="5%" height="25" align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td width="7%" align="center" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_PARAMETER_TEMPLETE_SL_NO");?></td>
                    <td width="55%" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_SMS_PARAMETER_TEMPLETE_TEMPLATE");?></td>
                    <td width="33%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att1" type="text" class="new_textbox40" id="att1" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='13'");?>
                    <td height="40" align="left" valign="top">
                    <textarea name="attc13" id="attc13" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    <td rowspan="19" align="left" valign="top">
                    <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                      <tr class="pedtext">
                        <td width="17%" height="22" align="center" valign="middle" bgcolor="#CCCCCC">Sl</td>
                        <td width="36%" align="center" valign="middle" bgcolor="#CCCCCC">Value</td>
                        <td width="47%" align="center" valign="middle" bgcolor="#CCCCCC">Field</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">1</td>
                        <td align="center" valign="middle">%teacher%</td>
                        <td align="center" valign="middle">Teacher Name</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">2</td>
                        <td align="center" valign="middle">%course_name%</td>
                        <td align="center" valign="middle">Course Name</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">3</td>
                        <td align="center" valign="middle">%date%</td>
                        <td align="center" valign="middle">Date</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">4</td>
                        <td align="center" valign="middle">%first_name%</td>
                        <td align="center" valign="middle">Student Name</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">5</td>
                        <td align="center" valign="middle">%fee_amt%</td>
                        <td align="center" valign="middle">Fee Amount</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">6</td>
                        <td align="center" valign="middle">%startdate%</td>
                        <td align="center" valign="middle">Start Date</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">7</td>
                        <td align="center" valign="middle">%enddate%</td>
                        <td align="center" valign="middle">End Date</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">8</td>
                        <td align="center" valign="middle">%unit%</td>
                        <td align="center" valign="middle">No.Units</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">9</td>
                        <td align="center" valign="middle">%std%</td>
                        <td align="center" valign="middle">No.of Students</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">10</td>
                        <td align="center" valign="middle">%grp%</td>
                        <td align="center" valign="middle">Group</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">11</td>
                        <td align="center" valign="middle">%unt_fnd%</td>
                        <td align="center" valign="middle">Finished Units</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">12</td>
                        <td align="center" valign="middle">%nos%</td>
                        <td align="center" valign="middle">No. of Students</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">13</td>
                        <td align="center" valign="middle">%ufin%</td>
                        <td align="center" valign="middle">No.of Units</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">14</td>
                        <td align="center" valign="middle">%u%</td>
                        <td align="center" valign="middle">No.of Units</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">15</td>
                        <td align="center" valign="middle">%no_of_students%</td>
                        <td align="center" valign="middle">No. of Students</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">16</td>
                        <td align="center" valign="middle">%ad_amt%</td>
                        <td align="center" valign="middle">Advance Amount</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">17</td>
                        <td align="center" valign="middle">%amount%</td>
                        <td align="center" valign="middle">Amount</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">18</td>
                        <td align="center" valign="middle">%at_count%</td>
                        <td align="center" valign="middle">No.of Days</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">19</td>
                        <td align="center" valign="middle">%grade_name%</td>
                        <td align="center" valign="middle">Grade Name</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">20</td>
                        <td align="center" valign="middle">%final_grade%</td>
                        <td align="center" valign="middle">Percentage</td>
                      </tr>
                      <tr class="mytext">
                        <td height="22" align="center" valign="middle">21</td>
                        <td align="center" valign="middle">%status%</td>
                        <td align="center" valign="middle">Status</td>
                      </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att2" type="text" class="new_textbox40" id="att2" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='14'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc14" id="attc14" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att3" type="text" class="new_textbox40" id="att3" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='15'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc15" id="attc15" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att4" type="text" class="new_textbox40" id="att4" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='16'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc16" id="attc16" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att5" type="text" class="new_textbox40" id="att5" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='17'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc17" id="attc17" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att6" type="text" class="new_textbox40" id="att6" value="6" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='18'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc18" id="attc18" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att7" type="text" class="new_textbox40" id="att7" value="7" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='19'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc19" id="attc19" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att8" type="text" class="new_textbox40" id="att8" value="8" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='20'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc20" id="attc20" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="9" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='21'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc21" id="attc21" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att10" type="text" class="new_textbox40" id="att10" value="10" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='22'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc22" id="attc22" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att1" type="text" class="new_textbox40" id="att1" value="11" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='23'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc23" id="attc23" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att2" type="text" class="new_textbox40" id="att2" value="12" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='24'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc24" id="attc24" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att3" type="text" class="new_textbox40" id="att3" value="13" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='25'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc25" id="attc25" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att4" type="text" class="new_textbox40" id="att4" value="14" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='26'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc26" id="attc26" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att5" type="text" class="new_textbox40" id="att5" value="15" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='27'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc27" id="attc27" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att6" type="text" class="new_textbox40" id="att6" value="16" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='28'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc28" id="attc28" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att7" type="text" class="new_textbox40" id="att7" value="17" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='29'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc29" id="attc29" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att8" type="text" class="new_textbox40" id="att8" value="18" /></td>
                    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='30'");?>
                    <td height="40" align="left" valign="top">
                      <textarea name="attc30" id="attc30" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
                    </tr>
				  <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="19" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='31'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    
                    
                    
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="20" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='32'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="21" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='33'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="22" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='34'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="23" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='35'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="24" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='36'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="25" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='37'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc31" id="attc31" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="26" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='40'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc40" id="attc40" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="27" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='41'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc41" id="attc41" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="28" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='42'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc42" id="attc42" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
                    <tr>
				    <td align="center" valign="middle">&nbsp;</td>
				    <td align="center" valign="top"><input name="att9" type="text" class="new_textbox40" id="att9" value="29" /></td>
				    <?php $res_com = $dbf->strRecordID("sms_templete","*","id='43'");?>
				    <td height="40" align="left" valign="top">
				      <textarea name="attc43" id="attc43" class="mytextarea" autocomplete="off"><?php echo $res_com["contents"];?></textarea></td>
				    </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                </form>
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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
</body>
</html>