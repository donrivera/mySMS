<?php
ob_start();
session_start();
include_once '../includes/receipt_ar.php';
include_once '../includes/class.Main.php';
include_once '../includes/language.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

$student_id = $_REQUEST[id];
$course_id = $_REQUEST[course_id];

$val = $dbf->strRecordID("student","*","id='$_REQUEST[id]'");
$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$_REQUEST[id]'");
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
$fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[fee_id]'");
?>
<script language="javascript" type="text/javascript">
function print_page() 
{
    var PrintControl = document.getElementById("print_icon");
    var CloseControl = document.getElementById("close_icon");
	PrintControl.style.visibility = "hidden";
	CloseControl.style.visibility = "hidden";
    window.print();
	PrintControl.style.visibility = "visible";
	CloseControl.style.visibility = "visible";
}
</script>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="605">&nbsp;</td>
    <td width="31" align="center" valign="middle"><div id='print_icon'><a href="javascript:print_page();"><img src="../images/print.png" width="16" height="16" /></a></div></td>
    <td width="39" align="right" valign="middle" style="padding-right:7px;">
		<div id='close_icon'>
		<img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/>
		</div>
	</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle">
    <table width="670" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
      <tr>
        <td width="179" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="middle" class="heading"><?php echo RECEIPT_THE_BERLITZ_LANGUAGE_CENTER;?></td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="hometest_name"><?php echo RECEIPT_AL_AHSA_SAUDI_ARABIA;?></td>
          </tr>
        </table></td>
        <td width="123" align="center" valign="middle"><img src="../logo/logo-ar.png" width="105" height="30" /></td>
        <td width="57" height="50">&nbsp;</td>
        <td width="105" align="center" valign="middle"><img src="../images/logo.png" alt="logo" width="105" height="30" /></td>
        <td width="206" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="middle" class="heading">The Berlitz Language Center</td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="hometest_name">Al Ahsa - Saudi Arabia</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="chtext"></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle" class="login_header"><?php echo RECEIPT_CONTRACT_AND_RECEIPT;//$Arabic->en2ar('CONTRACT and RECEIPT');?></td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="top" class="login_header">RECEIPT</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" colspan="5" align="center" valign="middle" style="border-top:solid 1px; border-bottom:solid 1px; border-color:#999;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="7%" height="50">&nbsp;</td>
            <td width="24%" class="suc_msg"><?php echo $fee["invoice_no"];?></td>
            <td width="34%" class="suc_msg">Receipt No. / <?php echo RECEIPT_NO;//$Arabic->en2ar('Receipt No');?></td>
            <td width="17%" align="center" valign="middle" class="suc_msg">
            <?php echo date('d/m/Y',strtotime($fee["paid_date"]));?>
            </td>
            <td width="18%" class="suc_msg">Date / <?php echo RECEIPT_DATE;//$Arabic->en2ar('Date');?></td>
          </tr>
        </table></td>
        </tr>
        <?php
		$amt = $fee["fee_amt"];
		$comm = $fee["comments"];
		$course_name = $dbf->getDataFromTable("course","name","id='$course_id'");
		?>
      <tr>
        <td height="30" colspan="5" align="center" valign="middle" class="chtext"><table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="180" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="48" height="30">&nbsp;</td>
                <td width="230">&nbsp;</td>
				
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td class="suc_msg"><!--<?php echo $amt;?> <?php echo $res_currency[symbol];?> /--->&nbsp;</td>
              </tr>
              <tr>
                <td height="30" >&nbsp;</td>
                <td align="left" width="230" valign="top" class="suc_msg">(<?php echo $dbf->convert_number_to_words($amt);?>)</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td align="left">
					<!--
					<table width="60%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
					<tr>
						<td align="center" class="smalltext"><?php# echo $dbf->getDataFromTable("common","name","id='$fee[payment_type]'");?>&nbsp;</td>
					</tr>
					</table>
					-->
				</td>
              </tr>
            </table></td>
            <td width="375"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <!--
			  <tr>
                <td width="201" align="left" valign="middle" class="suc_msg">
					<?php #echo $val['first_name']."&nbsp;".$val['father_name']."&nbsp;".$val['family_name'];?>
					&nbsp;
					<?php #echo "(".$val['first_name1']."&nbsp;".$val['father_name1']."&nbsp;".$val['grandfather_name1']."&nbsp;".$val['family_name1'].")";?>
				<br /><br />
                  <?php #echo $val["student_mobile"];?></td>
                <td width="10">&nbsp;</td>
                <td height="30" align="right" valign="middle" class="smalltext">Received From / <?php #echo RECEIPT_RECEIVE_FROM;//$Arabic->en2ar('Received From');?>
				<br /><br />
                  Mobile Number / <?php echo RECEIPT_MOBILE;?></td>
              </tr>
			  -->
			  <tr>
				<td align="right" valign="middle" class="suc_msg">
					<?php echo $val['first_name']."&nbsp;".$val['father_name']."&nbsp;".$val['family_name'];?>
					&nbsp;
					<?php echo "(".$val['first_name1']."&nbsp;".$val['father_name1']."&nbsp;".$val['grandfather_name1']."&nbsp;".$val['family_name1'].")";?>
				</td>
				<td>&nbsp;</td>
				<td height="30" align="right" valign="middle" class="smalltext">
					Received From / <?php echo RECEIPT_RECEIVE_FROM;//$Arabic->en2ar('Received From');?>
				</td>
			  </tr>
			   <tr>
				<td align="right" valign="middle" class="suc_msg">
					 <?php echo $val["student_mobile"];?>
				</td>
				<td>&nbsp;</td>
				<td height="30" align="right" valign="middle" class="smalltext">
					 Mobile Number / <?php echo RECEIPT_MOBILE;?>
				</td>
			  </tr>
              <tr>
                <td align="right" valign="middle" class="suc_msg"><?php echo $amt;?> <?php echo $res_currency[symbol];?> /-</td>
                <td>&nbsp;</td>
                <td height="30" align="right" valign="middle" class="smalltext">Amount Paid / <?php echo RECEIPT_AMOUNT;//$Arabic->en2ar('Amount');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="suc_msg"><?php echo $course_name;?></td>
                <td>&nbsp;</td>
                <td height="40" align="right" valign="middle" class="smalltext">Course & Level / <?php echo RECEIPT_COURSE;//$Arabic->en2ar('Course');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="suc_msg"><?php echo $dbf->getDataFromTable("common","name","id='$fee[payment_type]'"); ?></td>
                <td>&nbsp;</td>
                <td height="30" align="right" valign="middle" class="smalltext">Payment Mode / <?php echo RECEIPT_ON_ACCOUNT;//$Arabic->en2ar('On Account');?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="suc_msg"><?php echo $comm;?></td>
                <td>&nbsp;</td>
                <td width="152" height="30" align="right" valign="middle" class="smalltext">Details / <?php echo RECEIPT_DETAILS;//$Arabic->en2ar('Details');?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="right" valign="middle" class="chtext" style="padding-right:5px;">
			<br/><br/><br/>
			<?php echo $dbf->getDataFromTable("conditions","name","type='Challan'");?>
		</td>
      </tr>

      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="left" valign="middle" bgcolor="#CCCCCC" class="chtext"></td>
      </tr>
      <tr>
        <td colspan="4" align="left" valign="middle" class="chtext">
			<table width="250" border="0" cellspacing="0" cellpadding="0">
				<tr class="smalltext">
					<td width="160" height="25" align="center"><?php echo $dbf->getDataFromTable("centre","cen_tel_no","id='$res_enroll[centre_id]'");?>&nbsp; : <?php echo RECEIPT_CENTER;?></td>
				</tr>
			</table>
		</td>
		<td colspan="1" align="center" valign="middle" class="chtext"><font class="smalltext"><?php echo $dbf->getDataFromTable("centre","name","id='$_SESSION[centre_id]'");?></font></td>
		</tr>
      <tr>
        <td height="5" colspan="5" align="left" valign="middle" class="chtext"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>