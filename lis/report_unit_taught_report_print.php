<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="2%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
                  <th width="7%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_STU_EN_AR");?></th>
                  <th width="8%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_PAYMENT_AMOUNT");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_NEW_EN");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                  <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("LIS_DISCOUNT_AMOUNT");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_EN_AMT");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_REPT_AMT");?></th>
                  <th width="8%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_SEARCH_INVOICE_BALANCEAMOUNT");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
										
					//loop start
					foreach($dbf->fetchOrder('student_enroll',"payment_date<>'0000-00-00' And (payment_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')","payment_date") as $valenroll) {
					
					//Check whether it is for New-Enrollment or Re-enrollment
					$enroll = $valenroll["enrolled_status"];
					
					//Get Student Name
					$group = $dbf->strRecordID("student_group","*","id='$valenroll[group_id]'");
					//Get Student Name
					$student = $dbf->strRecordID("student","*","id='$valenroll[student_id]'");
					//Get Course Name
					$course = $dbf->strRecordID("course","*","id='$valenroll[course_id]'");
					
					$en_amt = $valenroll[course_fee] - $valenroll[discount];
					$re_amt = $dbf->strRecordID("student_fees","SUM(paid_amt)","student_id='$valenroll[student_id]' And course_id='$valenroll[course_id]'");
					$re_amt = $en_amt - $re_amt["SUM(paid_amt)"];
					$bal_amt = $en_amt - $re_amt;
					if($bal_amt <= 0){
					?>                    
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td align="center" valign="middle" class="mycon">&nbsp;</td>
                      <td align="left" valign="middle" class="mycon"><?php echo $valenroll[payment_date];?></td>
                      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td align="right" valign="middle" class="mycon"><?php echo $valenroll["course_fee"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $enroll;?> <?php echo $res_currency[symbol];?></td>
                      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $group["group_name"];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?></td>
                      <td align="right" valign="middle" class="mycon"><?php echo $valenroll["course_fee"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon"><?php echo $en_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon"><?php echo $re_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <td align="right" valign="middle" class="mycon"><?php echo $bal_amt;?>&nbsp;<?php echo $res_currency[symbol];?></td>
                      <?php
                              $i = $i + 1;
                              if($color=="#ECECFF")
                              {
                                  $color = "#FBFAFA";
                              }else{
                                  $color="#ECECFF";
                              }
                        }
                  }
                  ?>
                  </tr>               
            </table>

<script type="text/javascript">
window.print();
</script>
