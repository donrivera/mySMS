<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
    <thead>
    <tr class="logintext">
      <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
      <th width="11%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
      <th width="12%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
      <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEE");?></th>
      <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_COURSE_MANAGE_DISCOUNT");?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo DISCOUNT_PERCENT;?></th>
      <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
      <th width="8%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
      </tr>
    </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
        
        //Get Number of Rows
        $num=$dbf->countRows('student_enroll',"(enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
        $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
		
        //loop start
        foreach($dbf->fetchOrder('student_enroll',"(enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","enroll_date") as $valenroll) {
            
        $enroll = $valenroll["enrolled_status"];
		
        //Get Student Name
        $group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
        //Get Student Name
        $student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
        //Get Course Name
        $course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
        
		$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$valenroll[fee_id]'");
		$en_amt = $course_fees - $valenroll[discount];
		
        $re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]' And status='1'");
        $re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
        ?>        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?></td>
      <td align="center" valign="middle" class="mycon"><?php echo $enroll;?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $group[group_name];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $course[name];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $valenroll[course_fee];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $valenroll[discount];?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $dbf->getDiscountPercent($course_fees, $valenroll["discount"]);?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
      <td align="right" valign="middle" class="mycon"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
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