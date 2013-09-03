<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';

include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$student_id = $_REQUEST['student_id'];
$course_id = $_REQUEST['course_id'];
$enroll = $dbf->strRecordID("student_enroll",'*',"student_id='$student_id' And course_id='$course_id'");
$course = $dbf->strRecordID("course",'*',"id='$course_id'");
$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");

$course_fee = $course_fees;
$discount = $enroll["discount"];
$other_amt = $enroll["other_amt"];

$en_amt = $course_fee - $discount;
$course_fee_final = $en_amt + $other_amt;

$fee = $dbf->strRecordID("student_fees",'SUM(paid_amt)',"student_id='$student_id' And course_id='$course_id' And status='1'");
$paid_amt = $fee["SUM(paid_amt)"];
$bal_amt = $course_fee_final - $paid_amt;
?>
<link href="glowtabs.css" rel="stylesheet" type="text/css">
<?php if($_SESSION[lang]=="EN"){?>
<table width="250" border="1" cellspacing="0" cellpadding="0" bordercolor="#9999FF" style="border-collapse:collapse;">
  <tr>
    <td width="54%" height="20" align="right" valign="middle" class="mycon"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : &nbsp;</td>
    <td width="46%" align="left" valign="middle" class="shop2">&nbsp;<?php echo $course["name"];?></td>
  </tr>
  <tr class="mycon">
    <td colspan="2" align="center" valign="middle"><u class="mymenutext"><?php echo constant("CD_HOLD_STATUS_PAYMENT_DTL");?></u> &nbsp;</td>
  </tr>
  <tr>
    <td width="54%" align="right" valign="middle" class="mycon"> <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?>: &nbsp;</td>
    <td width="46%" align="left" valign="middle" bgcolor="#999999" class="shop2">&nbsp;<?php echo $course_fee;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"><?php echo constant("CD_HOLD_STATUS_DIS");?> : &nbsp;</td>
    <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $discount;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"><?php echo constant("ACCOUNTANT_EN_AMT");?>: &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFF99" class="shop2">&nbsp;<?php echo $en_amt;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"><?php echo constant("CD_HOLD_STATUS_OTHER_AMOUNT");?> : &nbsp;</td>
    <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $other_amt;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"> <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?>: &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#9D9DFF" class="shop2">&nbsp;<?php echo $course_fee_final;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"><?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?>: &nbsp;</td>
    <td align="left" valign="middle" class="shop2" >&nbsp;<?php echo $paid_amt;?> <?php echo $res_currency[symbol];?></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="mycon"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#006699" class="logintext" >&nbsp;<?php echo $bal_amt;?> <?php echo $res_currency[symbol];?></td>
  </tr>
</table>
<?php } else{?>
<table width="250" border="1" cellspacing="0" cellpadding="0" bordercolor="#9999FF" style="border-collapse:collapse;">
  <tr>
  <td width="46%" align="right" valign="middle" class="shop2" style="padding-right:3px;">&nbsp;<?php echo $course["name"];?></td>
    <td width="54%" height="20" align="left" valign="middle" class="mycon">&nbsp; : <?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
    
  </tr>
  <tr class="mycon">
    <td colspan="2" align="center" valign="middle"><u class="mymenutext"><?php echo constant("CD_HOLD_STATUS_PAYMENT_DTL");?></u> &nbsp;</td>
  </tr>
  <tr>
  <td width="46%" align="right" valign="middle" bgcolor="#999999" class="shop2" style="padding-right:3px;">&nbsp;<?php echo $course_fee;?> <?php echo $res_currency[symbol];?></td>
    <td width="54%" align="left" valign="middle" class="mycon">&nbsp;:  <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?></td>
    
  </tr>
  <tr>
  <td align="right" valign="middle" class="shop2" style="padding-right:4px;">&nbsp;<?php echo $discount;?> <?php echo $res_currency[symbol];?></td>
    <td align="left" valign="middle" class="mycon">&nbsp;: <?php echo constant("CD_HOLD_STATUS_DIS");?> </td>
    
  </tr>
  <tr>
   <td align="right" valign="middle" bgcolor="#FFFF99" class="shop2" style="padding-right:4px;">&nbsp;<?php echo $en_amt;?> <?php echo $res_currency[symbol];?></td>
    <td align="left" valign="middle" class="mycon"> &nbsp;: <?php echo constant("ACCOUNTANT_EN_AMT");?></td>
   
  </tr>
  <tr>
  <td align="right" valign="middle" class="shop2" style="padding-right:4px;">&nbsp;<?php echo $other_amt;?> <?php echo $res_currency[symbol];?></td>
    <td align="left" valign="middle" class="mycon"> &nbsp;: <?php echo constant("CD_HOLD_STATUS_OTHER_AMOUNT");?></td>
    
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#9D9DFF" class="shop2" style="padding-right:3px;">&nbsp;<?php echo $course_fee_final;?> <?php echo $res_currency[symbol];?></td>
  <td align="left" valign="middle" class="mycon" style="padding-right:4px;">&nbsp;: <?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?></td>

    
    
  </tr>
  <tr>
   <td align="right" valign="middle" class="shop2" style="padding-right:4px;" >&nbsp;<?php echo $paid_amt;?> <?php echo $res_currency[symbol];?></td>
    <td align="left" valign="middle" class="mycon" style="padding-right:3px;">&nbsp;: <?php echo constant("CD_SEARCH_INVOICE_PAIDAMOUNT");?></td>
   
  </tr>
  <tr>
  <td align="right" valign="middle" bgcolor="#006699" class="logintext" >&nbsp;<?php echo $bal_amt;?> <?php echo $res_currency[symbol];?></td>
    <td align="left" valign="middle" class="mycon">&nbsp;: <?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?> </td>
    
  </tr>
</table>
<?php }?>
