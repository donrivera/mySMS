<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
      <th width="10%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
      <th width="7%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEE");?></th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
      <th width="10%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
      <th width="10%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_FROM_STUDENT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_TO_STUDENT");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        $cond = '';
        if($_REQUEST[centre_id] == ''){
            $cond = "(m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And m.id=d.parent_id ";
        }else if($_REQUEST[centre_id] != ''){
            $cond = "m.centre_id='$_REQUEST[centre_id]' And (m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And m.id=d.parent_id ";
        }
        
        //Get Number of Rows
        $num=$dbf->countRows('transfer_student_to_student m,transfer_student_to_student_dtls d', $cond);
        
        //loop start
        foreach($dbf->fetchOrder('transfer_student_to_student m, transfer_student_to_student_dtls d', $cond ,"m.id","m.from_id,m.to_id,m.dated,d.*") as $transfer) {
        
        $student = $dbf->strRecordID("student","*","id='$transfer[student_id]'");
                        
        $group = $dbf->strRecordID("student_group","*","id='$transfer[from_id]'");
        $course = $dbf->strRecordID("course","*","id='$group[course_id]'");
        
        $student_enroll = $dbf->strRecordID("student_enroll","*","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
        $enroll = $student_enroll["enrolled_status"];
        $from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
		$from_group = $dbf->strRecordID("student_group","*","id='$transfer[from_id]'"); 
		
        $to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
        $to_group = $dbf->strRecordID("student_group","*","id='$transfer[to_id]'");
		$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$student_enroll[fee_id]'");
		
        $course_fee = $course_fees;
        $discount = $student_enroll["discount"];
        $en_amt = $course_fee - $discount;
        $paid_amt = $dbf->getDataFromTable("student_fee","SUM(paid_amt)","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
        $bal_amt = $en_amt - $paid_amt;
        ?>
        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $transfer["dated"];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student["first_name"];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $enroll;?> <?php echo $res_currency[symbol];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $course["name"];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $course_fee;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $discount;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $dbf->getDiscountPercent($course_fees, $discount);?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $paid_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $from_id;?> <?php echo $from_group["group_time"];?>-<?php echo $dbf->GetGroupTime($from_group["id"]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $to_id;?> <?php echo $to_group["group_time"];?>-<?php echo $dbf->GetGroupTime($to_group["id"]);?></td>
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
</table>