<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">          
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25" colspan="6" align="left" valign="middle" class="leftmenu">&nbsp;</td>
      </tr>
      <tr>
        <td width="10%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_DASHBOARD_STUDENT");?> :&nbsp;</td>
        <td width="25%" align="left" valign="middle">
          <?php
            foreach($dbf->fetchOrder('student',"id='$_REQUEST[student_id]'","first_name") as $valc) {
                echo $valc[first_name]." ".$Arabic->en2ar($dbf->StudentName($valc["id"]));
            }
           ?></td>
        <td width="14%" align="left" valign="middle">&nbsp;</td>
        <td width="16%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
        <td width="6%" align="center" valign="middle">&nbsp;</td>
        <td width="29%" align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="6" align="left" valign="middle">&nbsp;</td>
        </tr>
    </table>
    <?php
    $num = $dbf->countRows("student_group_dtls", "student_id='$_REQUEST[student_id]'");
    foreach($dbf->fetchOrder('student_group m,student_group_dtls d', "m.id=d.parent_id And d.student_id='$_REQUEST[student_id]'" ,"m.id","m.start_date,m.end_date,m.id,d.*") as $valfee) {
        $enroll = $dbf->strRecordID("student_enroll", "*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
        $course = $dbf->strRecordID("course", "*", "id='$valfee[course_id]'");
        $course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valfee[fee_id]'");
        
        $cr_tot = $course_fees + $enroll["other_amt"];
        $dr_tot = $enroll["discount"];
    ?>
    <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
      <tr>
        <td width="14%" height="25" align="right" valign="middle" class="leftmenu">Group Name :</td>
        <td width="52%" align="left" valign="middle" class="shop2">&nbsp;<span class="shop1"><?php echo $dbf->FullGroupInfo($valfee["parent_id"]);?></span></td>
        <td width="9%">&nbsp;</td>
        <td width="19%" align="center" valign="middle" class="shop1">&nbsp;</td>
        <td width="6%" align="left" valign="middle"></td>
      </tr>
      <tr>
        <td height="25" align="right" valign="middle" class="leftmenu">Course / Level :</td>
        <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $course["name"];?></td>
        <td>&nbsp;</td>
        <td align="center" valign="middle" class="mytext"></td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="center" valign="middle" class="leftmenu">
        <table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
          <tr class="shop1">
            <td width="7%" height="25" align="center" valign="middle" bgcolor="#EEEEEE">Sl</td>
            <td width="45%" align="left" valign="middle" bgcolor="#EEEEEE">Particulars</td>
            <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Date</td>
            <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Receipt Amount</td>
            <td width="16%" align="center" valign="middle" bgcolor="#EEEEEE">Course Fees</td>
          </tr>
          <tr class="shop2">
            <td height="22" align="center" valign="middle">1</td>
            <td align="left" valign="middle">&nbsp;Course Fee</td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="right" valign="middle">&nbsp;</td>
            <td align="right" valign="middle"><?php echo $course_fees;?>&nbsp;<?php echo $res_currency[symbol];?></td>
          </tr>
          <tr class="shop2">
            <td height="22" align="center" valign="middle">2</td>
            <td align="left" valign="middle">&nbsp;Discount</td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="right" valign="middle"><?php echo $enroll["discount"];?>&nbsp;[<?php echo $dbf->getDiscountPercent($course_fees, $enroll["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?>%]</td>
            <td align="right" valign="middle">&nbsp;</td>
          </tr>
          <tr class="shop2">
            <td height="22" align="center" valign="middle">3</td>
            <td align="left" valign="middle">&nbsp;Other Amount</td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="right" valign="middle">&nbsp;</td>
            <td align="right" valign="middle"><?php echo $enroll["other_amt"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
          </tr>
          <?php
          $k = 4;
            foreach($dbf->fetchOrder('student_fees', "status='1' And student_id='$valfee[student_id]' And course_id='$valfee[course_id]'" ,"id") as $feedtls){
            $dr_tot = $dr_tot + $feedtls["paid_amt"];
            ?>
          <tr class="shop2">
            <td height="22" align="center" valign="middle"><?php echo $k;?></td>
            <td align="left" valign="middle">&nbsp;<i>Ref.No</i> <?php echo $feedtls["invoice_no"];?></td>
            <td align="center" valign="middle">&nbsp;<?php if($feedtls["paid_date"] != '0000-00-00') { echo date('d/M/Y',strtotime($feedtls["paid_date"])); }?></td>
            <td align="right" valign="middle"><?php echo $feedtls["paid_amt"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle">&nbsp;</td>
          </tr>
          <?php $k++; } ?>
          <tr class="shop2">
            <td height="22" colspan="3" align="right" valign="middle" class="shop1">Total :</td>
            <td align="right" valign="middle" bgcolor="#EEEEEE"><?php echo $dr_tot;?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle" bgcolor="#EEEEEE"><?php echo $cr_tot;?>&nbsp;<?php echo $res_currency[symbol];?></td>
          </tr>
          <?php if($dr_tot != $cr_tot){ ?>
          <tr class="shop2">
            <td height="22" colspan="3" align="right" valign="middle" class="shop1"><?php if($dr_tot < $cr_tot) { ?> Balance <?php }else{?> Refund <?php } ?>:</td>
            <td align="right" valign="middle"><?php if($dr_tot < $cr_tot){ echo $cr_tot - $dr_tot; } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php if($dr_tot > $cr_tot){ echo abs($dr_tot - $cr_tot); } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
          </tr>
          <?php } ?>
          <?php if($dr_tot != $cr_tot){ ?>
          <tr class="shop2">
            <td height="22" colspan="3" align="right" valign="middle" class="shop1">Total : </td>
            <td align="right" valign="middle"><?php if($dr_tot < $cr_tot){ echo $cr_tot; } else { echo $dr_tot; } ?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php if($dr_tot > $cr_tot){ echo $dr_tot; } else { echo $cr_tot; }?>&nbsp;<?php echo $res_currency[symbol];?></td>
          </tr>
          <?php } ?>
        </table></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
    </table>
    <br>
    <?php } ?>    
    </td>
  </tr>
  <?php		
        if($num == 0 && $num_ad == 0){
        ?>
        <tr>
          <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
        </tr>
        <?php
        }
        ?>		  
</table>