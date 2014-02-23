<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
	<thead>
		<th width="6%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
		<th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
		<th width="7%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_PAYMENT_AMOUNT");?></th>
		<th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
		<th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
		<th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPSTART");?><br><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPEND");?></th>
		<th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("LIS_DISCOUNT_AMOUNT");?></th>
		<th width="8%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
		<th width="8%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo "Balance";?></th>
	</thead>
    <?php
		$i = 1;
		$color="#ECECFF";
										
		//loop start
		foreach($dbf->fetchOrder('student_enroll',"enroll_date<>'0000-00-00' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","enroll_date") as $valenroll) 
		{
					
			$enroll = $valenroll["enrolled_status"];
					
			//Get Student Name
			$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
			//Get Student Name
			$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
			//Get Course Name
			$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
			$payment=$dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]'");
			$en_amt = $valenroll[course_fee] - $valenroll[discount];
			$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
			$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
			$bal_amt = $en_amt - $re_amt;
			if($bal_amt > 0)
			{
	?>                    
				<tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
					<td align="left" valign="middle" class="mycon"><?php echo $valenroll[enroll_date];?></td>
					<td align="left" valign="middle" class="mycon">&nbsp;<?php echo $dbf->printStudentName($student[id]);?></td>
					<td align="right" valign="middle" class="mycon"><?php echo $payment;?>&nbsp;<?php echo $res_currency[symbol];?></td>
					<td align="center" valign="middle" class="mycon">&nbsp;<?php echo $enroll;?></td>
					<td align="left" valign="middle" class="mycon">&nbsp;<?php echo $group["group_name"];?> <?php echo $dbf->printClassTimeFormat($group["group_start_time"],$group["group_end_time"]);?></td>
					<td align="center" valign="middle" class="mycon"><?php echo $group["start_date"].'<br>'.$group["end_date"];?></td>
					<td align="right" valign="middle" class="mycon"><?php echo $valenroll["discount"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
					<td align="right" valign="middle" class="mycon"><?php echo $valenroll['course_fee'];?>&nbsp;<?php echo $res_currency[symbol];?></td>
					<td align="right" valign="middle" class="mycon"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
				<?php
					$i = $i + 1;
					if($color=="#ECECFF")
					{
						$color = "#FBFAFA";
					}else{$color="#ECECFF";}
			}
        }
                ?>
                </tr>               
</table>