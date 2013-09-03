<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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

<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#000000">
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ALERT");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#FFFFFF">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
					<tr>
					  <td width="3">&nbsp;</td>
					  <td width="476" height="50">&nbsp;</td>
					  <td width="47" align="left" valign="top">&nbsp;</td>
					  <td width="492" align="left" valign="middle" class="home_head_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="6%" align="left" valign="middle"><img src="../images/Info.png" width="16" height="16" /></td>
                            <td width="1%">&nbsp;</td>
                            <td width="93%" align="left" valign="middle"> <?php echo constant("CD_ALERT_LATEST_INFORMATION");?> </td>
						  </tr>
					  </table></td>
					</tr>
					
					<tr>
					  <td width="3" align="left" valign="top">&nbsp;</td>
					  <td align="center" valign="top"><div id="dataDisplay">
					   <?php
							$i = 1;
							foreach($dbf->fetchOrder('alerts',"cen_dr='1' AND status='0'","id DESC") as $val) {
							?>
					    <table width="450" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                            <td width="4">&nbsp;</td>
                            <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="26%" align="left" valign="middle" class="hometest_name"><?php echo constant("CD_ALERT_POSTEDBYADMIN");?> </td>
                                  <td width="74%" align="left" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                                </tr>
                                <tr>
                                  <td height="5"></td>
                                  <td height="5"></td>
                                </tr>
                                <?php
								 $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                                <?php if($val["imp"]=="1") { ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="14%" align="left" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_MARKAS");?> : </td>
                                        <td width="9%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                                        <td width="77%" align="left" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_IMPORTANT");?></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("CD_ALERT_MSGTYPE");?> : <?php echo $valm["name"];?></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top" class="tabledetailtext"><?php echo $val["imp_info"];?></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="10" colspan="3"></td>
                          </tr>
                          <tr>
                            <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                          </tr>
                        </table>
						<?php $i++; } ?></div></td>
					  <td align="left" valign="top">&nbsp;</td>
					  <td align="left" valign="top"><div id="DisplayInfo">
					  
					    <?php
							$i = 1;
							foreach($dbf->fetchOrder('news',"cen_dr='1' AND status='0'","id DESC") as $val) {
							?>
					    <table width="450" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                            <td width="4">&nbsp;</td>
                            <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="26%" align="left" valign="middle" class="hometest_name"><?php echo constant("CD_ALERT_POSTEDBYADMIN");?></td>
                                  <td width="74%" align="left" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                                </tr>
                                <tr>
                                  <td height="5"></td>
                                  <td height="5"></td>
                                </tr>
                               <?php
								 $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                                <?php if($val["imp"]=="1") { ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="15%" align="left" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_MARKAS");?> : </td>
                                        <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                                        <td width="79%" align="left" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_IMPORTANT");?></td>
                                      </tr>
									  
                                  </table></td>
                                </tr>
                                 <?php } ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("CD_ALERT_MSGTYPE");?> : <?php echo $valm["name"];?></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="left" valign="top" class="tabledetailtext"><?php echo $val["imp_info"];?></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="10" colspan="3"></td>
                          </tr>
                          <tr>
                            <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                          </tr>
                        </table>
						<?php $i++; } ?>
					  </div></td>
					</tr>
                  </table>
			</td>
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
   <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
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
                <tr bgcolor="#000000">
                  <td align="right" height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ALERT");?></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" bgcolor="#FFFFFF">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                      <tr>
                        <td width="3">&nbsp;</td>
                        <td width="476" height="50">&nbsp;</td>
                        <td width="47" align="left" valign="top">&nbsp;</td>
                        <td width="492" align="left" valign="middle" class="home_head_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="93%" align="right" valign="middle"> <?php echo constant("CD_ALERT_LATEST_INFORMATION");?> </td>
                            <td width="1%">&nbsp;</td>
                            <td width="6%" align="right" valign="middle"><img src="../images/Info.png" width="16" height="16" /></td>
                           </tr>
                          </table></td>
                        </tr>
                      
                      <tr>
                        <td width="3" align="left" valign="top">&nbsp;</td>
                        <td align="center" valign="top"><div id="dataDisplay">
                          <?php
							$i = 1;
							foreach($dbf->fetchOrder('alerts',"cen_dr='1' AND status='0'","id DESC") as $val) {
							?>
                          <table width="450" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  
                                  <td width="74%" align="right" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                                  <td width="26%" align="right" valign="middle" class="hometest_name"><?php echo constant("CD_ALERT_POSTEDBYADMIN");?> </td>
                                  </tr>
                                <tr>
                                  <td height="5"></td>
                                  <td height="5"></td>
                                  </tr>
                                <?php
								 $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                                <?php if($val["imp"]=="1") { ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="77%" align="right" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_IMPORTANT");?></td>
                                      <td width="9%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                                      <td width="14%" align="right" valign="middle" class="hometest_time"> : <?php echo constant("CD_ALERT_MARKAS");?></td>
                                      
                                      </tr>
                                    </table></td>
                                  </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="2" align="right" valign="top" class="hometest_time"><?php echo $valm["name"];?> : <?php echo constant("CD_ALERT_MSGTYPE");?></td>
                                  </tr>
                                <tr>
                                  <td colspan="2" align="right" valign="top" class="tabledetailtext"><?php echo $val["imp_info"];?></td>
                                  </tr>
                                </table></td>
                              <td width="4">&nbsp;</td>
                              <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                              
                              </tr>
                            <tr>
                              <td height="10" colspan="3"></td>
                              </tr>
                            <tr>
                              <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                              </tr>
                            </table>
                          <?php $i++; } ?></div></td>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><div id="DisplayInfo">
                          
                          <?php
							$i = 1;
							foreach($dbf->fetchOrder('news',"cen_dr='1' AND status='0'","id DESC") as $val) {
							?>
                          <table width="450" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  
                                  <td width="74%" align="right" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
                                  <td width="26%" align="right" valign="middle" class="hometest_name"><?php echo constant("CD_ALERT_POSTEDBYADMIN");?></td>
                                  </tr>
                                <tr>
                                  <td height="5"></td>
                                  <td height="5"></td>
                                  </tr>
                                <?php
								 $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
                                <?php if($val["imp"]=="1") { ?>
                                <tr>
                                  <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="79%" align="right" valign="middle" class="hometest_time"><?php echo constant("CD_ALERT_IMPORTANT");?></td>
                                      <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16" /></td>
                                      <td width="15%" align="right" valign="middle" class="hometest_time"> : <?php echo constant("CD_ALERT_MARKAS");?></td>
                                      
                                      </tr>
                                    
                                    </table></td>
                                  </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="2" align="right" valign="top" class="hometest_time"><?php echo $valm["name"];?> : <?php echo constant("CD_ALERT_MSGTYPE");?></td>
                                  </tr>
                                <tr>
                                  <td colspan="2" align="right" valign="top" class="tabledetailtext"><?php echo $val["imp_info"];?></td>
                                  </tr>
                                </table></td>
                              <td width="4">&nbsp;</td>
                              <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
                              
                              </tr>
                            <tr>
                              <td height="10" colspan="3"></td>
                              </tr>
                            <tr>
                              <td height="1" colspan="3" bgcolor="#d8dfea"></td>
                              </tr>
                            </table>
                          <?php $i++; } ?>
                          </div></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
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
   <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
