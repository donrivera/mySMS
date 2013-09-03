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
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
                  <th width="11%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="9%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
                  <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
                  <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					$cond = '';
					if($_REQUEST[start_date]!=''){
						$start_date = $_REQUEST[start_date];
					}else{
						$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
					}
					if($_REQUEST[end_date]!=''){
						$end_date = $_REQUEST[end_date];
					}else{
						$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
					}
					if($_REQUEST["discount_from"] == ''){
						$discount_from = 100;
					}else{
						$discount_from = $_REQUEST["discount_from"];
					}
					if($_REQUEST["discount_to"] == ''){
						$discount_to = 500;
					}else{
						$discount_to = $_REQUEST["discount_to"];
					}
					if($discount_from == '0' && $discount_to == '0'){
						$cond = "(enroll_date BETWEEN '$start_date' And '$end_date')";
					}else if($discount_from != '' && $discount_to != ''){
						$cond = "(discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
					}else{
						$cond = "(enroll_date BETWEEN '$start_date' And '$end_date') And (discount BETWEEN '$discount_from' And '$discount_to') And (enroll_date BETWEEN '$start_date' And '$end_date')";
					}
					
					//Get Number of Rows
					$num=$dbf->countRows('student_enroll', $cond);
					
					//loop start
					foreach($dbf->fetchOrder('student_enroll', $cond,"enroll_date") as $valenroll) {
					
					//Get Student Name
					$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
					
					//Get Course Name
					$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
					
					//Check whether it is for New-Enrollment or Re-enrollment
					$enroll = $valenroll["enrolled_status"];
										
					//Get Group Name
					$group = $dbf->strRecordID("student_group","*","id='$valenroll[course_id]'");
					$course_fees = $dbf->getDataFromTable("course_fee", "fees", "id='$valenroll[fee_id]'");
					
					//Enrollment Amount
					$en_amt = $course_fees;
					
					$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
					$re_amt = $re_amt["SUM(paid_amt)"];
										
					$bal_amt = $en_amt - $re_amt - $valenroll["discount"];
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo date('d-M-Y',strtotime($valenroll[payment_date]));?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $course[name];?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $enroll;?></td>
                  <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                  <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $valenroll[discount];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo $dbf->getDiscountPercent($course_fees, $valenroll["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="mycon"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <td align="right" valign="middle" class="contenttext"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                  <?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
				  }
				  ?>
                </tr>
               
            </table>
<script type="text/javascript">
window.print();
</script>
