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
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" colspan="6" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
    <td height="25" align="left" valign="middle" class="hometest_name"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> : </td>
    <td align="left" valign="middle"><?php echo $dbf->getDataFromTable("centre","name","id='$_REQUEST[centre_id]'"); ?></td>
    <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="right" valign="middle" class="hometest_name">&nbsp;</td>
  </tr>
  <?php if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != '') { ?>
  <tr>
    <td width="7%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
    <td width="5%" height="25" align="left" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
    <td width="10%" align="left" valign="middle"><?php echo $_REQUEST[start_date];?></td>
    <td width="3%" align="right" valign="middle" class="hometest_name"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
    <td width="9%" align="left" valign="middle"><?php echo $_REQUEST[end_date];?></td>
    <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr>
    <td width="7%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
    <td height="25" colspan="2" align="left" valign="middle" class="hometest_name"><?php echo $_REQUEST[radio];?></td>
    <td width="3%" align="center" valign="middle" class="hometest_name">&nbsp;</td>
    <td width="9%" align="left" valign="middle" class="hometest_name">&nbsp;</td>
    <td width="3%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="6" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="6" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="94%"><table width="450" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
          <tr>
            <td width="11%" height="25" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="40%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_PAYMENT_MANAGE_PAYMENTTYPE");?></td>
            <td width="49%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?></td>
          </tr>
          <?php
        $i = 1;
        $color="#ECECFF";
        $range_option=$_REQUEST["radio"];
		switch($range_option)
		{
			case 'Date_Range':		{
										$start_date = $_REQUEST[start_date];
										$end_date = $_REQUEST[end_date];
									}break;
			case 'Today':			{
										$start_date = date('Y-m-d');
										$end_date = date('Y-m-d');
									}break;
			case 'This Week':		{
										$start_date = $dbf->WeekStartDay(date('Y-m-d'));
										$end_date = $dbf->WeekEndDay(date('Y-m-d'));
									}break;
			case 'Last Week':		{
										$start_date = $dbf->LastWeekStartDay();
										$end_date = $dbf->LastWeekEndDay();
									}break;
			case 'This Month':		{
										$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
										$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
									}break;
			case 'Last Month':		{
										$start_date = date("Y-m",strtotime("-1 Months"));
										$start_date = $start_date.'-01';
										$end_date = date("Y-m",strtotime("-1 Months"));
										$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
									}break;
			case 'Last 3 Months':	{
										$start_date = date("Y-m",strtotime("-3 Months"));
										$start_date = $start_date.'-01';
										$end_date = date("Y-m",strtotime("-1 Months"));
										$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
									}break;
			case 'Last 6 Months':	{
										$start_date = date("Y-m",strtotime("-6 Months"));
										$start_date = $start_date.'-01';
										$end_date = date("Y-m",strtotime("-1 Months"));
										$end_date = $end_date.'-'.cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-1 Months")), date("Y",strtotime("-1 Months")));
									}break;
			case 'This Year':		{
										$start_date = date('Y').'-01-01';
										$end_date = date('Y').'-12-31';
									}break;
			case 'Last 3 Years':	{
										$last = date('Y') - 3;
										$first = date('Y') - 1;
										$start_date = $last.'-01-01';
										$end_date = $first.'-12-31';
									}break;
			#case '':	{}break;
			#case '':	{}break;
			default:	{$start_date = date('Y-m-d');$end_date = date('Y-m-d');}break;
		}
        //echo $start_date;
        //echo '<br>';			
        //echo $end_date;
        //loop start
        foreach($dbf->fetchOrder('common',"type='payment type'","") as $valpay) {
                        
            //Get Amount from Student fees Table with paid_date according to payment Type
            if($_REQUEST[centre_id] != ''){
                $cond = "payment_type='$valpay[id]' And centre_id='$_REQUEST[centre_id]' And (paid_date BETWEEN '$start_date' And '$end_date') And status='1'";
            }else{
                $cond = "payment_type='$valpay[id]' And (paid_date BETWEEN '$start_date' And '$end_date') And status='1'";
            }
            $amount = $dbf->getDataFromTable("student_fees","SUM(paid_amt)", $cond);
			
		?>
          <tr>
            <td align="center" valign="middle" class="mytext" height="22"><?php echo $i;?></td>
            <td align="left" valign="middle" class="mytext"><?php echo $valpay["name"];?></td>
            <td align="left" valign="middle" class="mytext"><?php echo $amount;?> <?php echo $res_currency[symbol];?></td>
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
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
window.print();
</script>
