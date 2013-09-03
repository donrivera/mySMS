<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="3%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="22%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
      <th width="18%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> / <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></th>
      <th width="19%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_COUNT_STU");?></th>
      <th width="21%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_EN_AMOUNT");?></th>
      <th width="17%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_BAL_AMOUNT");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        if($_REQUEST[group_id] == ''){
            $cond = "id > 0";
        }else{
            $group = "id = '$_REQUEST[group_id]'";
        }
        $num=$dbf->countRows('student_group', $group);
        //loop start
        foreach($dbf->fetchOrder('student_group', $group) as $valgroup) {
        
        //Count the number o students in student_group_dtls table
        $numofstudent = $dbf->countRows('student_group_dtls', "parent_id='$valgroup[id]'");
        
        //Get Enrollment Amount for a particular group
        $course_fee = 0;
        foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll) {
            if($course_fee == 0){
                $course_fee = $dbf->getDataFromTable("course_fee", "fees", "id='$enroll[fee_id]'");
            }else{
                $course_fee = $course_fee + $dbf->getDataFromTable("course_fee", "fees", "id='$enroll[fee_id]'");
            }
        }
        
        //Get Discount Amount for a particular group
        $en_amt = $dbf->getDataFromTable("student_enroll", "sum(discount)", "group_id='$valgroup[id]'");
        $other_amt = $dbf->getDataFromTable("student_enroll", "sum(other_amt)", "group_id='$valgroup[id]'");
        
        // Get Fees from student fees structure
        $paid_amt = 0;
        if($start_date != '' && $end_date != ''){
              $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
        }
        foreach($dbf->fetchOrder('student_group_dtls', "parent_id='$valgroup[id]'") as $dtls) {
            
            foreach($dbf->fetchOrder('student_fees', "student_id='$dtls[student_id]' And course_id='$dtls[course_id]' And status='1'".$date_condition) as $enroll) {
                if($paid_amt == 0){
                    $paid_amt = $enroll["paid_amt"];
                }else{
                    $paid_amt = $paid_amt + $enroll["paid_amt"];
                }
            }
        }
        
        $bal_amt = ($course_fee + $other_amt) - ($en_amt + $paid_amt);
        ?>
        
    <tr bgcolor="<?php echo $color;?>" >
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valgroup["group_name"];?> <?php echo $valgroup["group_time"];?>-<?php echo $dbf->GetGroupTime($valgroup["id"]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["start_date"]));?>&nbsp;/&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["end_date"]));?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $numofstudent;?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $course_fee;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" class="mycon">
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
          <tr class="lable1">
            <td width="5%" align="left" valign="middle" class="pedtext">&nbsp;</td>
            <td width="33%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
            <td width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></td>
            <td width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEE");?></td>
            <td width="9%" align="left" valign="middle" class="pedtext"><?php echo constant("ACCOUNTANT_DISOCUNT_AMOUNT");?></td>
            <td width="12%" align="left" valign="middle" class="pedtext"><?php echo DISCOUNT_PERCENT;?></td>
            <td width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></td>
            <td width="11%" align="left" valign="middle" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></td>
            <td width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_SEARCH_PRINT_INVOICE_BALANCE");?></td>
            </tr>
          <?php
          foreach($dbf->fetchOrder('student_enroll', "group_id='$valgroup[id]'") as $enroll_dtls) {
              
              //Student Name
              $student = $dbf->strRecordID("student","*","id='$enroll_dtls[student_id]'");
              $course_fees = $dbf->getDataFromTable("course_fee", "fees", "id='$enroll_dtls[fee_id]'");
              $e_amt = $course_fees  - $enroll_dtls["discount"];						  
              $e_amt1 = ($course_fees + $enroll_dtls["other_amt"]) - $enroll_dtls["discount"];
              
              //Receipt amt
              if($start_date != '' && $end_date != ''){
                  $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
              }
              $re_amt =$dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$enroll_dtls[student_id]' And course_id='$enroll_dtls[course_id]' And status='1'".$date_condition);
              $re_amt = $re_amt["SUM(paid_amt)"];
              $b_amt = $e_amt - $re_amt;
          ?>
          <tr bgcolor="<?php echo $color;?>">
            <td  align="center" valign="middle"></td>
            <td  align="left" valign="middle">&nbsp;<?php echo $student["first_name"];?></td>
            <td align="left" valign="middle">&nbsp;<?php echo date('d-M-Y',strtotime($enroll_dtls["enroll_date"]));?></td>
            <td align="right" valign="middle"><?php echo $course_fees;?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php echo $enroll_dtls["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php echo $dbf->getDiscountPercent($course_fees, $enroll_dtls["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php echo $e_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
            <td align="right" valign="middle"><?php echo $b_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
            </tr>
          <tr>
            <td colspan="9"  align="left" valign="middle" style="padding-top:2px; padding-left:2px; padding-bottom:2px;">
            <table width="65%" border="1" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
              <tr>
                <td width="7%" align="center" valign="middle" class="red_smalltext">Sl.</td>
                <td width="23%" align="left" valign="middle" class="red_smalltext">Payment Date</td>
                <td width="28%" align="left" valign="middle" class="red_smalltext"><?php echo constant("ACCOUNTANT_RE_NO");?></td>
                <td width="24%" align="left" valign="middle" class="red_smalltext">Payment Type</td>
                <td width="18%" align="right" valign="middle" class="red_smalltext">Payment Amount</td>
              </tr>
              <?php
              $sl = 1;
              if($start_date != '' && $end_date != ''){
                  $date_condition = " And (paid_date BETWEEN '$start_date' And '$end_date' )";
              }
              foreach($dbf->fetchOrder('student_fees', "student_id='$enroll_dtls[student_id]' And course_id='$enroll_dtls[course_id]' And status='1'".$date_condition) as $feedtls) {
              ?>
              <tr>
                <td align="center" valign="middle" class="mytext"><?php echo $sl;?></td>
                <td align="left" valign="middle" class="mytext"><?php echo $feedtls["paid_date"];?></td>
                <td align="left" valign="middle" class="mytext"><?php echo $feedtls["invoice_no"];?></td>
                <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("common", "name", "id='$feedtls[payment_type]'");?></td>
                <td align="right" valign="middle" class="mytext"><?php echo $feedtls["paid_amt"];?>&nbsp;<?php echo $res_currency["symbol"];?></td>
              </tr>
              <?php $sl++; } ?>
            </table>
            </td>
          </tr>
          <?php
          }
          ?>
        </table></td>
      </tr>  
    <?php
            $i = $i + 1;
            if($color=="#ECECFF"){
                $color = "#FBFAFA";
            }else{
                $color="#ECECFF";
            }
        }
        ?>            
</table>
<script type="text/javascript">
window.print();
</script>
