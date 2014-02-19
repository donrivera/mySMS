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
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
      <th width="10%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
      <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
      <th width="7%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEE");?></th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
      <th width="10%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo "Balance";?></th>
      <th width="10%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo "From";?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo "To";?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        $start_date = $_REQUEST[start_date];
		$end_date = $_REQUEST[end_date];
        $cond = "(m.dated BETWEEN '$start_date' And '$end_date') ";
		if($_REQUEST[centre_id] != '')
		{$cond = "m.centre_id='$_REQUEST[centre_id]' And (m.dated BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') ";}
		//Get Number of Rows
		$num=$dbf->countRows('transfer_centre_to_centre m', $cond);
		//loop start
		foreach($dbf->fetchOrder('transfer_centre_to_centre m', $cond ,"","m.*") as $transfer) 
		{
			$course = $dbf->strRecordID("course","*","id='$transfer[from_course_id]'");
			$course_fees = $dbf->getDataFromTable("course_fee","fees","course_id='$transfer[from_course_id]'");
			$student_enroll = $dbf->strRecordID("student_enroll","*","student_id='$transfer[student_id]' And course_id='$group[course_id]'");
			$discount = $student_enroll["discount"];
			$status = $dbf->getDataFromTable("student_status","name","id='$transfer[from_status_id]'");
			$percentage=$dbf->getDiscountPercent($course_fees, $discount);
			$en_amt = $course_fee - $discount;
			$paid_amt = $dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$transfer[student_id]' And course_id='$transfer[from_course_id]'");
			$from=$dbf->getDataFromTable("centre","name","id=$transfer[centre_from]");
			$to=$dbf->getDataFromTable("centre","name","id=$transfer[centre_to]");
			$bal_amt = $en_amt - $paid_amt;
    ?>
        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $transfer["dated"];?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $dbf->printStudentName($transfer["student_id"]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $status;?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo (empty($course["name"])?"N/A":$course[name]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($course_fees)?"0":$course_fees."&nbsp;".$res_currency[symbol]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($discount)?"0":$discount."&nbsp;".$res_currency[symbol]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($discount)?"0":$percentage."&nbsp;".$res_currency[symbol]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($en_amt)?"0":$en_amt."&nbsp;".$res_currency[symbol]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($paid_amt)?"0":$paid_amt."&nbsp;".$res_currency[symbol]);?></td>
      <td align="right" valign="middle" class="mycon"><?php echo (empty($bal_amt)?"0":$en_amt."&nbsp;".$res_currency[symbol]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $from;?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $to;?></td>
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