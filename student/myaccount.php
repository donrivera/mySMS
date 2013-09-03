<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['students_uid']=="" || $_SESSION['students_user_type']!="Student")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

$students_id = $_SESSION[students_uid];

$res = $dbf->strRecordID("student","*","id='$students_id'");

include_once '../includes/language.php';

//Use currency
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
<script type="text/javascript" src="../js/dropdowntabs.js"></script>
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
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
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
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" class="logintext" ><?php echo constant("STUDENT_MYACCOUNT_MY_ACCOUNT");?></td>
                  <td width="22%">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp; </td>
                  <td width="8%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF"><table width="97%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td width="637" colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCC99;">
                    <tr>
                      <td width="6%" height="20" align="left" valign="middle">&nbsp;</td>
                      <td width="9%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td width="63%" align="left" valign="middle" class="menutext"></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td width="22%" rowspan="3" align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td align="left" valign="middle" class="menutext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16%" align="left" valign="middle"><span class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_YOURNAME");?> :</span></td>
                          <td width="71%" align="left" valign="middle"><?php echo $res["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></td>
						  <?php
						     if($res["photo"]!=''){
							  $photo="../sa/photo/".$res["photo"];
							 }else{
								 $photo="../images/noimage.jpg";
							 }
						  ?>
                          <td width="13%" rowspan="6" align="center" valign="middle" style="border-right:solid #FF9900;border-bottom:solid #FF9900;"><img width="80" height="90" src="<?php echo $photo;?>" /></td>
                          </tr>
                          <?php if($res["student_id"]>0) { ?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_STDUENTID");?>: </td>
                          <td align="left" valign="middle"><?php echo $res["student_id"];?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td align="left" valign="middle"><span class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_EMAIL");?> :</span></td>
                          <td align="left" valign="middle"><?php echo $res["email"];?></td>
                          </tr>
                        <tr>
                          <td align="left" valign="middle"><span class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?> :</span></td>
                          <td align="left" valign="middle"><?php echo $res["student_mobile"];?></td>
                          </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                        <tr>
                          <td height="18" align="left" valign="middle">&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                        </table></td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>                    
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td height="30" align="left" valign="middle" bgcolor="#E6E6E6" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td align="left" valign="middle">
                      <?php
					  $cl = 0;
					  $tb = 0;
                      foreach($dbf->fetchOrder('student_group_dtls',"student_id='$students_id'","") as $res_dtls) {
						  $course = $dbf->strRecordID("course","*","id='$res_dtls[course_id]'");
						  if($cl == 0) { $color = "#FF9900"; }
						  if($cl == 1) { $color = "#6699CC"; }
						  if($cl == 2) { $color = "#EDE9EC"; }
						  if($cl == 3) { $color = "#FAFDC4"; }
						  if($cl == 4) { $color = "#D8D6FE"; }
						  if($cl == 5) { $color = "#D8D6FE"; }						  
						  if($cl == 6) { $color = "#FDF1D7"; }
						  if($cl == 7) { $color = "#EDE9EC"; }
						  if($cl == 8) { $color = "#FAFDC4"; }
						  if($cl == 9) { $color = "#D8D6FE"; }
						  if($cl == 10) { $color = "#D8D6FE"; }
						  
						  if($tb == 0) { $tb_color = "#FFE6EA"; }
						  if($tb == 1) { $tb_color = "#FFFF99"; }
						  if($tb == 2) { $tb_color = "#EDE9EC"; }
						  if($tb == 3) { $tb_color = "#FAFDC4"; }
						  if($tb == 4) { $tb_color = "#D8D6FE"; }
						  if($tb == 5) { $tb_color = "#D8D6FE"; }						  
						  if($tb == 6) { $tb_color = "#FDF1D7"; }
						  if($tb == 7) { $tb_color = "#EDE9EC"; }
						  if($tb == 8) { $tb_color = "#FAFDC4"; }
						  if($tb == 9) { $tb_color = "#D8D6FE"; }
						  if($tb == 10) { $tb_color = "#D8D6FE"; }
					  ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : <?php echo $course["name"];?></td>
                          </tr>
                        <tr>
                          <td align="left" valign="middle">                            
                            <table width="100%" border="2" cellspacing="0" bordercolor="#FFCC00" cellpadding="0" style="border-collapse:collapse;">                              
                              <tr>
                                <td width="7%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                                <td width="27%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                                <td width="25%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTONDT");?></td>
                                <td width="17%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTMODE");?></td>
                                <td width="14%" align="right" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FEE");?></td>
                                <td width="10%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_STATUS");?></td>
                                </tr>
                                <?php																
								$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$res_dtls[course_id]' And student_id='$students_id'");
								if($res_enroll["ob_amt"]>0){
									$i = 1;
									$ptype = $dbf->strRecordID("common","*","id='$res_enroll[payment_type]'");
							 ?>
                                <tr>
                                <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?> </td>
                                <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($res_enroll["payment_date"]));?></td>
                                <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($res_enroll["payment_date"]));?></td>
                                <td align="center" class="sl_text"><?php echo $ptype[name]; ?></td>
                                <td align="right" class="sl_text"><?php echo $res_enroll["ob_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                                <td align="center"><img src="../images/tick.png" width="16" height="16"></td>
                                </tr>
                              <?php							  
								}
								$i++;
								foreach($dbf->fetchOrder('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='1'","") as $rest) {
								$ptype = $dbf->strRecordID("common","*","id='$rest[payment_type]'");
							 ?>
                              <tr>
                                <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?> </td>
                                <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["fee_date"]));?></td>
                                <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["paid_date"]));?></td>
                                <td align="center" class="sl_text"><?php echo $ptype[name]; ?></td>
                                <td align="right" class="sl_text"><?php echo $rest["paid_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                                <td align="center"><img src="../images/tick.png" width="16" height="16"></td>
                                </tr>
                              
                              <?php $i++; } ?>
                              
                              
                              </table>
                            
                            </td>
                          </tr>
                          <?php
							$i = 1;
							$num_future=$dbf->countRows('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='0'");
							
							if($num_future > 0)
							{
                          ?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FUTUREPAYMNT");?></td>
                          </tr>
                        <tr>
                          <td align="left" valign="middle">
                           
                          <table width="100%" border="2"  cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr class="leftmenu">
                              <td width="7%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                              <td width="27%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                              <td width="25%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTONDT");?></td>
                              <td width="17%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTMODE");?></td>
                              <td width="14%" align="right" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FEE");?></td>
                              <td width="10%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_STATUS");?></td>
                              </tr>
                            <?php
							$i = 1;
															
							foreach($dbf->fetchOrder('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='0'","") as $rest) {
							$ptype = $dbf->strRecordID("common","*","id='$rest[payment_type]'");
						 ?>
                            <tr>
                              <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?></td>
                              <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["fee_date"]));?></td>
                              <td align="center" valign="middle" class="sl_text">&nbsp;</td>
                              <td align="center" class="sl_text">&nbsp;</td>
                              <td align="right" class="sl_text"><?php echo $rest["fee_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                              <td align="center"><img src="../images/block.png" width="16" height="16"></td>
                              </tr>
                            <?php $i++; } ?>
                            </table>
                            
                            </td>
                          </tr>
                          <?php
							}
							?>
                        <tr>
                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                          </tr>
                        <tr>
                          <td align="left" valign="middle">
                          <table width="100%" border="2" bordercolor="#FFCC00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <?php
							$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
                            
							$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$res_dtls[course_id]' And student_id='$students_id' AND status='1'");
							
							$feeamt = $fee["SUM(paid_amt)"]+$res_enroll["ob_amt"];
							 
							$bal_amt = $camt - $feeamt;
						  ?>
                            <tr>
                              <td height="25" colspan="2" align="left" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_BALANCEINFO");?></td>
                              </tr>
                            <tr>
                              <td width="34%" height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_TOTALCOURSEFEES");?> : </td>
                              <td width="66%" class="sl_text"><?php echo $camt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                              </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_TEXT");?> : </td>
                              <td class="sl_text"><?php echo $feeamt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                              </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_BALANCEFEES");?> : </td>
                              <td class="sl_text"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        <br>
                        <?php
						$cl++;
						$tb++;
					  }
					  ?>
                        </td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>                                
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
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
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30">&nbsp;</td>
                  <td width="22%">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp; </td>
                  <td width="8%" align="right" class="logintext" ><?php echo constant("STUDENT_MYACCOUNT_MY_ACCOUNT");?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
            <tr>
              <td height="200" align="center" valign="top" bgcolor="#FFFFFF"><table width="97%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td width="637" colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="3" align="center" valign="top">
                    <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCC99;">
                      <tr>
                        <td width="4%" height="20" align="left" valign="middle">&nbsp;</td>
                        <td width="6%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td width="83%" align="left" valign="middle" class="menutext"></td>
                        <td width="7%" align="left" valign="middle" class="menutext"></td>
                        </tr>
                      <tr>
                        <td height="20" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle" class="menutext">
                        <?php
						     if($res["photo"]!=''){
							  $photo="../sa/photo/".$res["photo"];
							 }else{
								 $photo="../images/noimage.jpg";
							 }
						  ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="14%" rowspan="6" align="center" valign="middle"  style="border-right:solid #FF9900;border-bottom:solid #FF9900;"><img width="80" height="90" src="<?php echo $photo;?>" />
                            
                            </td>
                            <td width="67%" align="right" valign="middle" class="hometest_name"><?php echo $res["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?>&nbsp;</td>
                            <td width="19%" align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_YOURNAME");?></td>
                            </tr>
                          <?php if($res["student_id"]>0) { ?>
                          <tr>
                            <td align="right" valign="middle" class="hometest_name"><?php echo $res["student_id"];?>&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_STDUENTID");?></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td align="right" valign="middle" class="hometest_name"><?php echo $res["email"];?>&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_EMAIL");?></td>
                            </tr>
                          <tr>
                            <td align="right" valign="middle" class="hometest_name"><?php echo $res["student_mobile"];?>&nbsp;</td>
                            <td align="left" valign="middle" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_MYACCOUNT_MOBILENO");?></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                          <tr>
                            <td height="18" align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                        </table></td>
                        <td align="left" valign="middle" class="menutext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td height="20" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        </tr>                    
                      <tr>
                        <td height="30" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td height="30" align="right" valign="middle" bgcolor="#E6E6E6" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></td>
                        <td align="right" valign="middle" bgcolor="#E6E6E6" class="leftmenu">&nbsp;</td>
                        </tr>
                      <tr>
                        <td height="20" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="right" valign="middle">
                          <?php
					  $cl = 0;
					  $tb = 0;
                      foreach($dbf->fetchOrder('student_group_dtls',"student_id='$students_id'","") as $res_dtls) {
						  $course = $dbf->strRecordID("course","*","id='$res_dtls[course_id]'");
						  if($cl == 0) { $color = "#FF9900"; }
						  if($cl == 1) { $color = "#6699CC"; }
						  if($cl == 2) { $color = "#EDE9EC"; }
						  if($cl == 3) { $color = "#FAFDC4"; }
						  if($cl == 4) { $color = "#D8D6FE"; }
						  if($cl == 5) { $color = "#D8D6FE"; }						  
						  if($cl == 6) { $color = "#FDF1D7"; }
						  if($cl == 7) { $color = "#EDE9EC"; }
						  if($cl == 8) { $color = "#FAFDC4"; }
						  if($cl == 9) { $color = "#D8D6FE"; }
						  if($cl == 10) { $color = "#D8D6FE"; }
						  
						  if($tb == 0) { $tb_color = "#FFE6EA"; }
						  if($tb == 1) { $tb_color = "#FFFF99"; }
						  if($tb == 2) { $tb_color = "#EDE9EC"; }
						  if($tb == 3) { $tb_color = "#FAFDC4"; }
						  if($tb == 4) { $tb_color = "#D8D6FE"; }
						  if($tb == 5) { $tb_color = "#D8D6FE"; }						  
						  if($tb == 6) { $tb_color = "#FDF1D7"; }
						  if($tb == 7) { $tb_color = "#EDE9EC"; }
						  if($tb == 8) { $tb_color = "#FAFDC4"; }
						  if($tb == 9) { $tb_color = "#D8D6FE"; }
						  if($tb == 10) { $tb_color = "#D8D6FE"; }
					  ?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="25" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : <?php echo $course["name"];?></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle">
                                
                                <table width="100%" border="2" cellspacing="0" bordercolor="#FFCC00" cellpadding="0" style="border-collapse:collapse;">                                  <tr>
                                    <td width="10%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_STATUS");?></td>
                                    <td width="14%" align="right" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FEE");?></td>
                                    <td width="17%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTMODE");?></td>
                                    <td width="25%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTONDT");?></td>
                                    <td width="27%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                                    <td width="7%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                                    </tr>
                                  <?php
																
								$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$res_dtls[course_id]' And student_id='$students_id'");
								if($res_enroll["ob_amt"]>0){
									$i = 1;
									$ptype = $dbf->strRecordID("common","*","id='$res_enroll[payment_type]'");
							 	?>
                                  <tr>
                                    <td align="center"><img src="../images/tick.png" width="16" height="16"></td>
                                    <td align="right" class="sl_text"><?php echo $res_enroll["ob_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                                    <td align="center" class="sl_text"><?php echo $ptype[name]; ?></td>
                                    <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($res_enroll["payment_date"]));?></td>
                                    <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($res_enroll["payment_date"]));?></td>
                                    <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?> </td>
                                    </tr>
                                  <?php							  
								}
								$i++;
								foreach($dbf->fetchOrder('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='1'","") as $rest) {
								$ptype = $dbf->strRecordID("common","*","id='$rest[payment_type]'");
							 ?>
                                  <tr>
                                    <td align="center"><img src="../images/tick.png" width="16" height="16"></td>
                                    <td align="right" class="sl_text"><?php echo $rest["paid_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                                    <td align="center" class="sl_text"><?php echo $ptype[name]; ?></td>
                                    <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["paid_date"]));?></td>
                                    <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["fee_date"]));?></td>
                                    <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?> </td>
                                    </tr>                                  
                                  <?php $i++; } ?>
                                  </table>
                                
                                </td>
                              </tr>
                            <?php
							$i = 1;
							$num_future=$dbf->countRows('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='0'");
							
							if($num_future > 0)
							{
                          ?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FUTUREPAYMNT");?></td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle">
                                
                                <table width="100%" border="2"  cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                  <tr class="leftmenu">
                                    <td width="10%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_STATUS");?></td>
                                    <td width="14%" align="right" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_FEE");?></td>
                                    <td width="17%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTMODE");?></td>
                                    <td width="25%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTONDT");?></td>
                                    <td width="27%" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTDATE");?></td>
                                    <td width="7%" height="25" align="center" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                                    </tr>
                                  <?php
							$i = 1;
															
							foreach($dbf->fetchOrder('student_fees',"course_id='$res_dtls[course_id]' And student_id='$students_id' And status='0'","") as $rest) {
							$ptype = $dbf->strRecordID("common","*","id='$rest[payment_type]'");
						 ?>
                                  <tr>
                                    <td align="center"><img src="../images/block.png" width="16" height="16"></td>
                                    <td align="right" class="sl_text"><?php echo $rest["fee_amt"];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                                    <td align="center" class="sl_text">&nbsp;</td>
                                    <td align="center" valign="middle" class="sl_text">&nbsp;</td>
                                    <td align="center" valign="middle" class="sl_text"><?php echo date("d.M.Y",strtotime($rest["fee_date"]));?></td>
                                    <td height="25" align="center" valign="middle" class="sl_text"><?php echo $i.".";?></td>
                                    </tr>
                                  <?php $i++; } ?>
                                  </table>
                                
                                </td>
                              </tr>
                            <?php
							}
							?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle">
                                <table width="100%" border="2" bordercolor="#FFCC00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                  <?php
							$camt = $res_enroll["course_fee"]-$res_enroll["discount"]+$res_enroll["other_amt"];
                            
							$fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$res_dtls[course_id]' And student_id='$students_id' AND status='1'");
							
							$feeamt = $fee["SUM(paid_amt)"]+$res_enroll["ob_amt"];
							 
							$bal_amt = $camt - $feeamt;
						  ?>
                                  <tr>
                                    <td height="25" colspan="2" align="right" valign="middle" bgcolor="#FF9900" class="leftmenu"><?php echo constant("STUDENT_MYACCOUNT_BALANCEINFO");?></td>
                                    </tr>
                                  <tr>
                                    <td width="34%" height="25" align="right" valign="middle" class="shop2"><?php echo $res_currency[symbol];?><?php echo $camt;?>&nbsp;</td>
                                    <td width="66%" class="pedtext"><?php echo constant("STUDENT_MYACCOUNT_TOTALCOURSEFEES");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle" class="shop2"><?php echo $res_currency[symbol];?><?php echo $feeamt;?>&nbsp;</td>
                                    <td class="pedtext"><?php echo constant("STUDENT_MYACCOUNT_TEXT");?></td>
                                    </tr>
                                  <tr>
                                    <td height="25" align="right" valign="middle" class="shop2"><?php echo $res_currency[symbol];?><?php echo $bal_amt;?>&nbsp;</td>
                                    <td class="pedtext"><?php echo constant("STUDENT_MYACCOUNT_BALANCEFEES");?></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table>
                          <br>
                          <?php
						$cl++;
						$tb++;
					  }
					  ?>
                        </td>
                        <td align="right" valign="middle">&nbsp;</td>
                        </tr>
                      <tr>
                        <td height="20" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                  </tr>                                
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table>
          
        </td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
