<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
<tr class="logintext">
  <th width="3%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_NEWS_MANAGE_DATE;?></th>
  <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_NEW_EN;?></th>
  <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_STU_EN_AR;?></th>
  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_REPORT_STUDENT_AWAITING_LEVEL;?></th>
  <th width="9%" align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_DASHBOARD_AMOUNT;?></th>
  <th width="9%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ADMIN_PAYMENT_MANAGE_PAYMENTTYPE;?></th>
  <th width="9%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo CD_SEARCH_PRINT_INVOICE_INVOICENO;?></th>
  <th width="12%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo ACCOUNTANT_RE_NO;?></th>
  </tr>
</thead>
<?php
    $i = 1;
    $color="#ECECFF";
    
    $cond = '';
    if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] == ''){
        $cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
    }else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] == ''){
        $cond = "centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
    }else if($_REQUEST[centre_id] != '' && $_REQUEST[payment_type] != ''){
        $cond = "centre_id='$_REQUEST[centre_id]' And payment_type='$_REQUEST[payment_type]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
    }else if($_REQUEST[centre_id] == '' && $_REQUEST[payment_type] != ''){
        $cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]') And payment_type='$_REQUEST[payment_type]'";
    }
                    
    //Get Number of Rows
    $num=$dbf->countRows('student_fees',$cond);
    
    //loop start
    foreach($dbf->fetchOrder('student_fees', $cond." And status='1'" ,"paid_date") as $valfee) {
    
    //Check whether it is for New-Enrollment or Re-enrollment
    $student_enroll = $dbf->strRecordID('student_enroll',"*", "student_id='$valfee[student_id]' And course_id='$valfee[course_id]'");
    $enroll = $student_enroll["enrolled_status"];
    
    //Get Student Name
    $student = $dbf->strRecordID("student","*","id='$valfee[student_id]'");
    //Get Course Name
    $course = $dbf->strRecordID("course","*","id='$valfee[course_id]'");
    //Get Payment Type
    $ptype = $dbf->strRecordID("common","*","id='$valfee[payment_type]'");
    ?>                    
<tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
  <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valfee[paid_date];?></td>
  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $enroll;?></td>
  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $student[first_name];?></td>
  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valfee[paid_amt];?> <?php echo $res_currency[symbol];?></td>
  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $ptype[name];?></td>
  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dbf->GetBillNo($valfee["student_id"], $valfee["course_id"]);?></td>
  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $valfee["invoice_no"];?></td>
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