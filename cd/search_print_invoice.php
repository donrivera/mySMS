<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$Arabic = new I18N_Arabic('Transliteration');

$student_id = $_REQUEST[student_id];
$course_id = $_REQUEST[course_id];

$val = $dbf->strRecordID("student","*","id='$student_id'");
$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$course_id' And student_id='$student_id'");
$res_course = $dbf->strRecordID("course","*","id='$course_id'");
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="633">&nbsp;</td>
    <td width="30" align="right" valign="middle"><a href="javascript:window.print();"><img src="../images/print.png" width="16" height="16" /></a></td>
    <td width="37" align="right" valign="middle" style="padding-right:7px;"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle">
    <table width="670" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="178" align="left" valign="middle">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" align="left" valign="middle" class="nametext"><img src="../images/logo.png" alt="logo" width="105" height="30" /></td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="nametext">The Berlitz Language Center</td>
          </tr>
          <tr>
            <td align="left" valign="middle" class="hometest_name">Al Ahsa - Saudi Arabia</td>
          </tr>
        </table>
        </td>
        
        <td width="44" align="center" valign="middle">&nbsp;</td>
        <td width="208" height="50" align="center" valign="middle" class="login_header"><?php echo $Arabic->en2ar($dbf->getDataFromTable("course","name","id='$course_id'"));?></td>
        <td width="75" align="center" valign="middle">&nbsp;</td>
        <td width="165" align="center" valign="middle">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" align="right" valign="middle" class="heading"><img src="../logo/logo-ar.png" width="105" height="30" /></td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="heading">&nbsp;<?php echo $Arabic->en2ar('The Berlitz Language Center');?></td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="hometest_name"><?php echo $Arabic->en2ar('Al Ahsa - Soudi Arabia');?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"></td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top" class="chtext"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border:solid 1px; border-color:#66F;">
          <tr class="smalltext">
            <td width="51%" height="25" align="left" valign="middle" bgcolor="#FFF2F7">&nbsp;Name</td>
            <td width="49%" align="right" valign="middle" bgcolor="#FFF2F7"><?php echo $Arabic->en2ar('Name');?>&nbsp;</td>
          </tr>
          <tr class="suc_msg">
            <td height="70" align="left" valign="top" bgcolor="#FFF2F7">&nbsp;<?php echo $val["first_name"];?><br />
              <br />
              Mobile :</td>
            <td align="right" valign="top" bgcolor="#FFF2F7"><?php echo $Arabic->en2ar($val["first_name"]);?>&nbsp;<br />
              <br />
              <?php echo $val["student_mobile"];?></td>
          </tr>
        </table></td>
        <td align="center" valign="top" class="suc_msg"><?php echo $dbf->GetBillNo($student_id, $course_id);?></td>
        <td colspan="2" align="left" valign="top">
        <table width="100%" border="1" bordercolor="#6666FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          <tr class="smalltext">
            <td width="31%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Invoice No');?><br />
              Invoice No</td>
            <td width="30%" height="25" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Date');?><br />
              Date</td>
            <td width="39%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Status/Type');?><br />
              Status/Type</td>
          </tr>
          <tr class="suc_msg">
            <td align="center" valign="top" class="forgottext"><?php echo $dbf->GetBillNo($student_id, $course_id);?></td>
            <td height="20" align="center" valign="top" class="forgottext"><?php echo date('d/m/Y');?></td>
            <?php
			if($dbf->countRows("student_moving","student_id='$student_id' And course_id='$course_id'") > 0){
				$status = $dbf->strRecordID("student_moving","*","student_id='$student_id' And course_id='$course_id'");
				$status = $dbf->getDataFromTable("student_status","name","id='$status[status_id]'");
			}else{
				$status = $dbf->strRecordID("student_moving","*","student_id='$student_id'");
				$status = $dbf->getDataFromTable("student_status","name","id='$status[status_id]'");
			}
			
			$no_course = $dbf->countRows("student_group_dtls","student_id='$student_id'");
			if($no_course == 1){
				$enroll = " /<br />New-Enroll";
			}else if($no_course > 1){
				$enroll = " /<br />Re-Enroll";
			}
			?>
            <td align="center" valign="top" class="forgottext"><?php echo $status;?><?php echo $enroll;?></td>
          </tr>
        </table>
        <br />
        <table width="100%" border="1" bordercolor="#6666FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          <tr class="smalltext">
            <td width="31%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Date');?><br />
              Date</td>
            <td width="30%" height="25" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Order');?><br />
              Order</td>
            <td width="39%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo $Arabic->en2ar('Future Payment');?><br />
              Future Payment</td>
          </tr>
          <tr class="suc_msg">
            <td align="center" valign="top"><?php echo date('d/m/Y');?></td>
            <td height="20" align="center" valign="top">
            <?php
            $cur_date = date('Y-m-d');
			if($dbf->countRows("student_fees","id","fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id'") > 0){
			echo $first_pay = $dbf->getDataFromTable("student_fees", "fee_amt", "fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id' LIMIT 0,1");
			}
			?>
            </td>
            <td align="center" valign="top">
            <?php
			if($dbf->countRows("student_fees","id","fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id'") > 0){
			echo $first_pay = $dbf->getDataFromTable("student_fees", "fee_date", "fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id' LIMIT 0,1");
			}
			?></td>
          </tr>
        </table>
        </td>
        </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" colspan="5" align="center" valign="middle">
        <table width="100%" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#6666FF" style="border-collapse:collapse;">
          <tr>
            <td width="15%" height="25" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('Net Amount');?><br />
              Net Amount</td>
            <td width="16%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('Pay Mode');?><br />
              Pay Mode</td>
            <td width="14%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('Payment Date');?><br />
              Payment Date</td>
            <td width="5%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('Qty');?><br />
              Qty</td>
            <td width="44%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('Course Name');?><br />
              Course Name</td>
            <td width="6%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext"><?php echo $Arabic->en2ar('No');?><br />
              No</td>
          </tr>
          <?php
			$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");			
			$j = 1;				
			foreach($dbf->fetchOrder('student_fees',"paid_amt>0 And course_id='$course_id' And student_id='$student_id'","") as $vali) {
			$dt="";
			$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");
			?>
          <tr>
            <td height="25" align="right" valign="middle" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"]; echo $res_currency[symbol];}?>&nbsp;</td>
            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
            <td align="center" class="text_structure"><?php if($vali["paid_date"]!="0000-00-00") { echo $dt = $vali["paid_date"]; } ?></td>
            <td align="center" class="text_structure">1&nbsp;&nbsp;</td>
            <td align="center" class="text_structure"><?php echo $res_course[name];?>&nbsp;</td>
            <td align="center" bordercolor="#009900" class="text_structure" >.<?php echo $j;?></td>
          </tr>
          <?php $j++; } ?>
          <?php
		  	 $course_dtls = $dbf->strRecordID("course","*","id='$course_id'");
			 $fee_id = $dbf->getDataFromTable("student_enroll","fee_id","course_id='$course_id' And student_id='$student_id'");
			 $course_fees = $dbf->getDataFromTable("course_fee","fees","id='$fee_id'");
			 $camt = $course_fees;
									 
			 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1'");
			 $feeamt = $fee["SUM(paid_amt)"];
			  
		  	 $net_amt = $camt - $res_enroll["discount"];			 
			 $bal_amt = $camt - ($feeamt + $res_enroll["discount"]);
			?>
          <tr>
            <td height="100" align="right" valign="middle" class="text_structure"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30" align="center" valign="middle" class="smalltext"><?php echo $feeamt;?> <?php echo $res_currency[symbol];?></td>
              </tr>
              <tr>
                <td align="center" valign="middle" class="smalltext"><?php echo $Arabic->en2ar('Paid Amount');?><br />
                  Paid Amount</td>
              </tr>
            </table></td>
            <td colspan="5" align="left" valign="top" class="text_structure">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="3%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="17%">&nbsp;</td>
                <td width="59%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle" class="smalltext">Grand Total :</td>
                <td align="left" valign="middle" class="menutext"><?php echo $camt;?> <?php echo $res_currency[symbol];?></td>
                <td align="left" valign="middle" class="smalltext"><?php echo $Arabic->en2ar('Grand Total');?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle" class="smalltext">Net Amount :</td>
                <td align="left" valign="middle" class="menutext"><?php echo $net_amt;?> <?php echo $res_currency[symbol];?></td>
                <td align="left" valign="middle" class="smalltext"><?php echo $Arabic->en2ar('Paid Amount');?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle" class="smalltext">Balance to Pay :</td>
                <td align="left" valign="middle" class="menutext"><?php echo $bal_amt;?> <?php echo $res_currency[symbol];?></td>
                <td align="left" valign="middle" class="smalltext"><?php echo $Arabic->en2ar('Balance to Pay');?></td>
              </tr>
            </table></td>
            </tr>
          
        </table></td>
      </tr>
	<?php
    $fee = $dbf->strRecordID("student_fees","*","id='$_REQUEST[fee_id]'");
    $amt = $fee["fee_amt"];
    $comm = $fee["comments"];
    ?>
      <tr>
        <td height="30" colspan="5" align="right" valign="middle" class="chtext"><?php echo $Arabic->en2ar($res_enroll["invoice_note"]);?> : Note &nbsp;</td>
      </tr>      
      <tr>
        <td height="30" colspan="5" align="center" valign="middle" class="chtext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr class="menutext">
            <td width="33%" height="70" align="center" valign="bottom"><?php echo $Arabic->en2ar("Reciever's Signature / Name");?><br />
              Reciever's Signature / Name</td>
            <td width="36%" align="center" valign="bottom"><?php echo $Arabic->en2ar("Student Advisor's Signature / Name");?><br />
              Student Advisor's Signature / Name</td>
            <td width="31%" align="center" valign="bottom"><?php echo $Arabic->en2ar('Issued From');?><br />
              Issued From</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="center" valign="middle" bgcolor="#6666FF" class="chtext"></td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="right" valign="middle" class="chtext" style="padding-right:10px;">
		<?php echo $dbf->getDataFromTable("conditions","name","type='Invoice'");?></td>
        </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="left" valign="middle" class="chtext"><table width="250" border="0" cellspacing="0" cellpadding="0">
          <tr class="smalltext">
            <td width="158" align="center"><?php echo $dbf->getDataFromTable("centre","cen_tel_no","id='$res_enroll[centre_id]'");?>&nbsp; : <?php echo $Arabic->en2ar('Center');?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="5" align="left" valign="middle" class="chtext">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
