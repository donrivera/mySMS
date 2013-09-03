<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['students_user_type']!="Student")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

//Used currency
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="../js/dropdowntabs.js"></script>

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
</script>

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
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){ ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
        <td width="79%" align="left" valign="top">
        
        <form name="frm" id="frm" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></td>
                <td width="22%" height="30">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="42%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="38%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center" valign="middle"><table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
                  <tr class="leftmenu">
                    <td width="16%" height="25" align="left" valign="middle" bgcolor="#E1DDE0">&nbsp;<?php echo constant("STUDENT_AUDIT_FIELD");?></td>
                    <td width="19%" align="left" valign="middle" bgcolor="#E1DDE0">&nbsp;<?php echo constant("STUDENT_AUDIT_CHANGE_FROM");?></td>
                    <td width="18%" align="left" valign="middle" bgcolor="#E1DDE0">&nbsp;<?php echo constant("STUDENT_AUDIT_CHANGE_TO");?></td>
                    <td width="22%" align="left" valign="middle" bgcolor="#E1DDE0">&nbsp;<?php echo constant("STUDENT_AUDIT_BY_USER");?></td>
                    <td width="25%" align="left" valign="middle" bgcolor="#E1DDE0">&nbsp;<?php echo constant("STUDENT_AUDIT_DATE_TIME");?></td>
                    </tr>
                  <?php
					$firstcolor = '#D8D6FE';
					$seccolor = '#FEEDE7';
					foreach($dbf->fetchOrder('student_fee_edit_history',"student_id='$_SESSION[students_uid]'","") as $valh) {
						
						//Get student name
						$valuser1 = $dbf->strRecordID("user","*","id='$valh[by_user]'");
						
						//Get student name
						$valuser2 = $dbf->strRecordID("user","*","id='$valh[updated_by]'");
						
					?>
                  <tr onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td height="25" align="left" valign="middle" class="mycon">&nbsp;<?php echo $valh[fld_name];?></td>
                    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valh[chg_from];?></td>
                    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valh[chg_to];?></td>
                    <td align="left" valign="middle" bgcolor="#BFBFFF" class="mycon">&nbsp;<?php echo $valuser1[user_name];?></td>
                    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valh[date_time];?></td>
                    </tr>
                  <?php } ?>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>               
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        </form>
        
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="76%" align="right" valign="top">
                <form name="frm" id="frm" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                        <table width="100%" border="0" cellspacing="0">
                          <tr>
                            
                            <td width="22%" height="30">&nbsp;</td>
                            <td width="8%" height="30" align="left">&nbsp;</td>
                            <td width="8%" height="30" align="left">&nbsp;</td>
                            <td width="8%" height="30" align="left">&nbsp;</td>
                            <td width="54%" height="30" class="logintext" align="right"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></td>
                            </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="42%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="38%">&nbsp;</td>
                            <td width="5%">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="3" align="center" valign="middle">
                              <table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
                                <tr class="leftmenu">
                                  <td width="16%" height="25" align="right" valign="middle" bgcolor="#E1DDE0" style="padding-right:10px;">&nbsp;<?php echo constant("STUDENT_AUDIT_FIELD");?></td>
                                  <td width="19%" align="right" valign="middle" bgcolor="#E1DDE0" style="padding-right:10px;">&nbsp;<?php echo constant("STUDENT_AUDIT_CHANGE_FROM");?></td>
                                  <td width="18%" align="right" valign="middle" bgcolor="#E1DDE0" style="padding-right:10px;">&nbsp;<?php echo constant("STUDENT_AUDIT_CHANGE_TO");?></td>
                                  <td width="22%" align="right" valign="middle" bgcolor="#E1DDE0" style="padding-right:10px;">&nbsp;<?php echo constant("STUDENT_AUDIT_BY_USER");?></td>
                                  <td width="25%" align="right" valign="middle" bgcolor="#E1DDE0" style="padding-right:10px;">&nbsp;<?php echo constant("STUDENT_AUDIT_DATE_TIME");?></td>
                                  </tr>
                                <?php
								$firstcolor = '#D8D6FE';
								$seccolor = '#FEEDE7';
								foreach($dbf->fetchOrder('student_fee_edit_history',"student_id='$_SESSION[students_uid]'","") as $valh) {
									
									//Get student name
									$valuser1 = $dbf->strRecordID("user","*","id='$valh[by_user]'");
									
									//Get student name
									$valuser2 = $dbf->strRecordID("user","*","id='$valh[updated_by]'");
									
								?>
                                <tr onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                                  <td height="25" align="right" valign="middle" class="mycon">&nbsp;<?php echo $valh[fld_name];?></td>
                                  <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $valh[chg_from];?></td>
                                  <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $valh[chg_to];?></td>
                                  <td align="right" valign="middle" bgcolor="#BFBFFF" class="mycon">&nbsp;<?php echo $valuser1[user_name];?></td>
                                  <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $valh[date_time];?></td>
                                  </tr>
                                <?php } ?>
                              </table></td>
                            <td>&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>               
                    <tr>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table>
                  </form>
              </td>
              <td width="3%" align="right" valign="top">&nbsp;</td>
              <td width="19%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
              </tr>
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
<?php } ?>
</body>
</html>
