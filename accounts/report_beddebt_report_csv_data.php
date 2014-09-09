<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="8%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
      <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSENAME");?></th>
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
        $sql=$dbf->genericQuery("
									SELECT SUM(sf.paid_amt) as total_paid,(se.course_fee - (SUM(sf.paid_amt) + se.discount)) as bad_debt,se.*
									FROM student_enroll se
									LEFT JOIN student_fees sf ON sf.student_id=se.student_id AND sf.course_id=se.course_id
									WHERE se.centre_id='$_REQUEST[centre_id]' AND (se.enroll_date between '$_REQUEST[start_date]' AND '$_REQUEST[end_date]')
									GROUP BY se.student_id,sf.student_id
									HAVING bad_debt > 0
									ORDER BY se.enroll_date
								");
		#$num=$dbf->countRows('student_enroll',"centre_id='$_REQUEST[centre_id]' And beddebt_amt > 0 And (enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
        $num=count($sql);
        //loop start
        #foreach($dbf->fetchOrder('student_enroll',"centre_id='$_REQUEST[centre_id]' And beddebt_amt > 0 And (enroll_date between '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","payment_date") as $valfee) {
        foreach($sql as $valfee) {
        $student = $valfee[student_id];#$dbf->strRecordID("student","*","id='$valfee[student_id]'");
        $course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
        $group = $dbf->strRecordID("student_group","*","id='$valfee[group_id]'");
        
        //Check whether it is for New-Enrollment or Re-enrollment
        $enroll = $valfee["enrolled_status"];		
        
		$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valfee[fee_id]'");
        $en_amt = ($course_fees - $valfee["discount"]) + $valfee["other_amt"];
        
        $paid = $valfee[total_paid];#$dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valfee[student_id]' And course_id='$valfee[course_id]' And status='1'");
		#$paid = $paid["SUM(paid_amt)"];
        
        $bal_amt = $dbf->BalanceAmount($valfee["student_id"],$valfee["course_id"]);
        $days = $dbf->dateDiff($group["end_date"],date('Y-m-d'));
        ?>        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valfee[enroll_date];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $dbf->printStudentName($student);?></td>
      <td align="center" valign="middle" class="mycon" ><?php echo $enroll;?></td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $dbf->FullGroupInfo($group['id']);?></td>
      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $course["name"];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $valfee["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $dbf->getDiscountPercent($course_fees, $valfee["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon" ><?php echo $paid;?>&nbsp;<?php echo $res_currency[symbol];?></td>
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
</table>