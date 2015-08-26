<?php
ob_start();
session_start();
include_once '../includes/invoice_ar.php';
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
$enroll_dtl=$dbf->getInvoiceCode($student_id,$course_id);
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
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="633">&nbsp;</td>
    <td width="30" align="right" valign="middle"><div id='print_icon'><a href="javascript:print_page();"><img src="../images/print.png" width="16" height="16" /></a></div></td>
    <td width="37" align="right" valign="middle" style="padding-right:7px;"><div id='close_icon'><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></div></td>
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
        <td width="208" height="50" align="center" valign="middle" class="login_header">
			<?php 
					#$course=$dbf->getDataFromTable("course","name","id='$course_id'");
					#$print_course = explode("-", $course);
					echo "Customer Enrollment Inovice";
					echo "<BR/>";
					echo INVOICE_TITLE;
			?>
		</td>
        <td width="75" align="center" valign="middle">&nbsp;</td>
        <td width="165" align="center" valign="middle">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" align="right" valign="middle" class="heading"><img src="../logo/logo-ar.png" width="105" height="30" /></td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="heading">&nbsp;<?php echo INVOICE_THE_BERLITZ_LANGUAGE_CENTER;?></td>
          </tr>
          <tr>
            <td align="right" valign="middle" class="hometest_name"><?php echo INVOICE_AL_AHSA_SAUDI_ARABIA;?></td>
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
            <td width="71%" height="25" align="left" valign="middle" bgcolor="#FFF2F7">&nbsp;Name of Customer</td>
            <td width="29%" align="right" valign="middle" bgcolor="#FFF2F7"><?php echo INVOICE_STUDENT_NAME;?>&nbsp;</td>
          </tr>
          <tr class="suc_msg">
			<td width="40%" align="left" valign="top" bgcolor="#FFF2F7">
				<?php echo $val['first_name']."&nbsp;".$val['father_name']."&nbsp;".$val['family_name'];?>
			</td>
			<td width="60%" align="left" valign="top" bgcolor="#FFF2F7">
				<?php echo $val['first_name1']."&nbsp;".$val['father_name1']."&nbsp;".$val['family_name1']."&nbsp;";?>
			</td>
          </tr>
		  <tr class="smalltext">
            <td width="71%" height="25" align="left" valign="middle" bgcolor="#FFF2F7">&nbsp;Mobile Number</td>
            <td width="29%" align="right" valign="middle" bgcolor="#FFF2F7"><?php echo INVOICE_STUDENT_MOBILE_NUMBER;?>&nbsp;</td>
          </tr>
		  <tr class="suc_msg">
			<td width="50%" align="left" valign="top" bgcolor="#FFF2F7"><?php echo $val["student_mobile"];?></td>
			<td width="50%" align="left" valign="top" bgcolor="#FFF2F7">&nbsp;</td>
		  </tr>
		</table></td>
        <td align="center" valign="top" class="suc_msg"><?php echo $dbf->GetBillNo($student_id, $course_id);?></td>
        <td colspan="2" align="left" valign="top">
        <table width="100%" border="1" bordercolor="#6666FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          <tr class="smalltext">
            <td width="31%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_STUDENT_INVOICE_NO;//$Arabic->en2ar('Invoice No');?><br />
              Agreement No</td>
            <td width="30%" height="25" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_DATE;//$Arabic->en2ar('Date');?><br />
              Date Issued</td>
            <td width="39%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_STATUS_TYPE;//$Arabic->en2ar('Status/Type');?><br />
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
            <td width="31%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_DATE;?><br/>Payment Plan Date</td>
            <td width="30%" height="25" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_ORDER;?><br/>Student ID</td>
            <td width="39%" align="center" valign="middle" bgcolor="#DED2FF"><?php echo INVOICE_FUTURE_PAYMENT;?><br/>Future Payment Date</td>
          </tr>
          <tr class="suc_msg">
            <td align="center" valign="top"><?php echo date('d/m/Y');?></td>
            <td height="20" align="center" valign="top">
            <?php
            $cur_date = date('Y-m-d');
			if($dbf->countRows("student_fees","id","fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id'") > 0){
			//echo $first_pay = $dbf->getDataFromTable("student_fees", "fee_amt", "fee_date > '$cur_date' And student_id='$student_id' And course_id='$course_id' LIMIT 0,1");
			echo $first_pay = $dbf->getDataFromTable("student", "student_id", "id='$student_id'");
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
            <td width="15%" height="25" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_INSTALLMENTS_RECEIVED;?><br />Installments Received
			</td>
            <td width="16%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_PAY_MODE;?><br />Payment Mode
			</td>
            <td width="14%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_PAYMENT_DATE;?><br />Payment Date
			</td>
			<!--
            <td width="5%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_QTY;?><br />Qty
			</td>
			-->
            <td width="44%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_COURSE_NAME;?><br />Course Name & Level
			</td>
            <td width="6%" align="center" valign="middle" bgcolor="#DED2FF" class="smalltext">
				<?php echo INVOICE_NO;?><br />No
			</td>
          </tr>
          <?php
			$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");			
			$j = 1;
			 	
			foreach($dbf->fetchOrder('student_fees',"course_id='$course_id' And student_id='$student_id' And invoice_sl LIKE '$enroll_dtl%'","") as $vali) {
			$dt="";
			$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");
			?>
          <tr>
            <td height="25" align="right" valign="middle" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"]; echo $res_currency[symbol];}?>&nbsp;</td>
            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
            <td align="center" class="text_structure"><?php if($vali["paid_date"]!="0000-00-00") { echo $dt = $vali["paid_date"]; } ?></td>
            <!--<td align="center" class="text_structure">1&nbsp;&nbsp;</td>-->
            <td align="center" class="text_structure"><?php echo $res_course[name];?>&nbsp;</td>
            <td align="center" bordercolor="#009900" class="text_structure" >.<?php echo $j;?></td>
          </tr>
          <?php $j++; } ?>
          <?php
		  	 $course_dtls = $dbf->strRecordID("course","*","id='$course_id'");
			 $get_fee_id = $dbf->getDataFromTable("student_enroll","course_id","course_id='$course_id' And student_id='$student_id'");
			 $get_fee_by_advance=$dbf->getDataFromTable("student_fees","course_id","course_id='$course_id' And student_id='$student_id' And invoice_sl LIKE '$enroll_dtl%'");
			 $fee_id=(empty($get_fee_id)?$get_fee_by_advance:$get_fee_id);
			 $course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$fee_id'");
			 $camt = $course_fees;
			  
			 $fee = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$course_id' And student_id='$student_id' AND status='1' And invoice_sl LIKE '$enroll_dtl%'");
			 $feeamt = $fee["SUM(paid_amt)"];
			 $discount_student_fee=$dbf->getDataFromTable('student_fees',"discount","course_id='$course_id' And student_id='$student_id' And invoice_sl LIKE '$enroll_dtl%'");
			 $discount_student_fee_wo_eid=$dbf->getDataFromTable('student_fees',"discount","course_id='$course_id' And student_id='$student_id' And type='advance'");
			 #$discount_student_payment=(empty($res_enroll["discount"])?$discount_student_fee:$res_enroll["discount"]);
			 if($res_enroll["level_complete"]==1 && $discount_student_fee_wo_eid==1){$discount_student_payment=$discount_student_fee_wo_eid;}
			 elseif($res_enroll["level_complete"]==1 && empty($res_enroll["discount"])){$discount_student_payment=$discount_student_fee;}
			 elseif(empty($res_enroll["discount"])){$discount_student_payment=$discount_student_fee;}
			 else{$discount_student_payment=$res_enroll["discount"];}
			 $other_amt = $dbf->getDataFromTable("student_enroll","other_amt","course_id='$course_id' And student_id='$student_id''");
			 $net_amt = $camt - $discount_student_payment + $other_amt;			 
			 $bal_amt = $camt - ($feeamt + $discount_student_payment);
			?>
          <tr>
            <td height="100" align="right" valign="middle" class="text_structure"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30" align="center" valign="middle" class="smalltext"><?php echo $feeamt;?> <?php echo $res_currency[symbol];?></td>
              </tr>
              <tr>
                <td align="center" valign="middle" class="smalltext"><?php echo INVOICE_PAID_AMOUNT;//$Arabic->en2ar('Paid Amount');?><br />
                  Total Paid Amount to Date</td>
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
                <td align="left" valign="middle" class="smalltext"><?php echo INVOICE_GRAND_TOTAL;//$Arabic->en2ar('Grand Total');?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle" class="smalltext">Net Amount :</td>
                <td align="left" valign="middle" class="menutext"><?php echo $net_amt;?> <?php echo $res_currency[symbol];?></td>
                <td align="left" valign="middle" class="smalltext"><?php echo INVOICE_NET_AMOUNT;#INVOICE_PAID_AMOUNT$Arabic->en2ar('Paid Amount');?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle" class="smalltext">Balance to Pay :</td>
                <td align="left" valign="middle" class="menutext"><?php echo $bal_amt;?> <?php echo $res_currency[symbol];?></td>
                <td align="left" valign="middle" class="smalltext"><?php echo INVOICE_BALANCE_TO_PAY;//$Arabic->en2ar('Balance to Pay');?></td>
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
        <td height="30" colspan="5" align="right" valign="middle" class="chtext"><?php echo $res_enroll["invoice_note"];?> : Note &nbsp;<?php echo INVOICE_NOTE;?></td>
      </tr>      
      <tr>
        <td height="30" colspan="5" align="center" valign="middle" class="chtext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr class="menutext">
            <td width="33%" height="70" align="center" valign="bottom"><?php echo INVOICE_RECEIVER_SIGNATURE_NAME;//$Arabic->en2ar("Reciever's Signature / Name");?><br />
              Receiver's Signature / Name</td>
            <td width="36%" align="center" valign="bottom"><?php echo INVOICE_STUDENT_ADVISOR_SIGNATURE_NAME;//$Arabic->en2ar("Student Advisor's Signature / Name");?><br />
              Registrar's Signature / Name</td>
            <td width="31%" align="center" valign="bottom">
				<?php echo INVOICE_ISSUED_FROM;?><br />
				Issued From<br/>
				<?php echo $dbf->getDataFromTable("centre","name","id='$_SESSION[centre_id]'");?>
				</td>
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
		<br/><br/><br/>
		<?php //echo $dbf->getDataFromTable("conditions","name","type='Invoice'");?></td>
        </tr>
      <tr>
        <td align="center" valign="middle" class="chtext">&nbsp;</td>
        <td colspan="3" align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="left" valign="middle" class="chtext"><table width="250" border="0" cellspacing="0" cellpadding="0">
          <tr class="smalltext">
            <td width="158" align="center"><?php echo $dbf->getDataFromTable("centre","cen_tel_no","id='$res_enroll[centre_id]'");?>&nbsp; : <?php echo INVOICE_CENTER;?></td>
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
