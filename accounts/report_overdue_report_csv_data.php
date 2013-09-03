<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
      <th width="11%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_PAYMENT_AMOUNT");?></th>
      <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
      <th width="8%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
      <th width="8%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
      <th width="8%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
      <th width="7%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_30_DAYS");?></th>
      <th width="7%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_60_DAYS");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        //Get Number of Rows
        $num=$dbf->countRows('student_enroll',"centre_id='$_REQUEST[centre_id]'");
        
        //loop start
        foreach($dbf->fetchOrder('student_fees',"centre_id='$_REQUEST[centre_id]' And (fee_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","fee_date") as $valfee) {
        
        $student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
        $course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
        $group_id = $dbf->getDataFromTable("student_group_dtls","parent_id","student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
        $group = $dbf->strRecordID("student_group","*","id='$group_id'");
        
        $re_en =$dbf->strRecordID('student_enroll',"*","student_id='$valfee[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
        $course_fees = $dbf->getDataFromTable("course_fee","fees","id='$re_en[fee_id]'");
        $enroll = $re_en["enrolled_status"];
				
        $en_amt = $course_fees - $re_en["discount"];
        $bal_amt = $en_amt - $valfee[paid_amt];
        
        $days = $dbf->dateDiff($valfee[fee_date],$valfee[paid_date]);		
        
        if($days > 29){
        ?>
        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valfee[fee_date];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $valfee[fee_amt];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="left" valign="middle" class="mycon" ><?php echo $enroll;?> <?php echo $res_currency[symbol];?></td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $group["group_name"];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $re_en["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $dbf->getDiscountPercent($course_fees, $re_en["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $valfee[paid_amt];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="center" valign="middle" class="mycon" >
      <?php
      if($days <= 30){
          echo $days;
      }
      ?>
      </td>
      <td align="center" valign="middle" class="mycon" >
      <?php
      if($days > 30){
          echo $days;
      }
      ?>
      </td>
      <?php
          $i = $i + 1;
          if($color=="#ECECFF"){
              $color = "#FBFAFA";
          }else{
              $color="#ECECFF";
          }
      }
      ?>
    </tr>   
        <?php
        } // Days
        ?>
</table>