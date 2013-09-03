<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

$centre_id = $_REQUEST["centre_id"];
$start_date = $_REQUEST["start_date"];
$end_date = $_REQUEST["end_date"];
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="56%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" align="left" valign="middle">&nbsp;</td>
        <td width="12%" height="30" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> : &nbsp;</td>
        <td width="22%" align="left" valign="middle">
            <?php
            foreach($dbf->fetchOrder('centre',"","name") as $valc) {
			if($valc["id"]==$_REQUEST["centre_id"]){
				echo $valc[name];
           	}
			}
           ?></td>
        <td width="12%" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : &nbsp;</td>
        <td width="20%" align="left" valign="middle"><?php echo $_REQUEST[start_date];?></td>
        <td width="6%" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : &nbsp;</td>
        <td width="18%" align="left" valign="middle"><?php echo $_REQUEST[end_date];?></td>
        <td width="9%" align="right" valign="middle"></td>
        </tr>
      </table></td>
    <td width="1%">&nbsp;</td>
    <td width="38%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
              <tr>
                <td colspan="4" align="center" valign="middle">
                <table width="60%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("ADMIN_NEWS_MANAGE_DATE");?> :&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $_REQUEST[start_date];?>&nbsp;/&nbsp;<?php echo $_REQUEST[end_date];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_APPOINTMENT");?>:&nbsp;</td>
                    <?php
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_INTERVIEW_CONDUCTED");?> :&nbsp;</td>
                    <?php
					$appoint = $dbf->strRecordID("student_appointment","COUNT(id)","status='1' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$appoint = $appoint["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $appoint;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_NEW_ENROLL");?> :&nbsp;</td>
                    <?php
					//loop start
					$enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re == 1){
							$enroll = $enroll + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $enroll;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_RE_ENROLL");?>:&nbsp;</td>
                    <?php
					//loop start
					$re_enroll = 0;
					foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
												
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')");
						if($num_re > 1){
							$re_enroll = $re_enroll + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $re_enroll;?></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_NEW_AND_RE_ENROLL");?> :&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext"><?php echo $enroll+$re_enroll;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_CERTIFICATE_ISSUED");?> :&nbsp;</td>
                    <?php
					$no_of_certificat = 0;
					foreach($dbf->fetchOrder('teacher_progress_certificate', "(print_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_certificat = $no_of_certificat + 1;
						}
					}					
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_certificat;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_PROGRESS_ISSUED");?> :&nbsp;</td>
                    <?php
					$no_of_progress = 0;
					foreach($dbf->fetchOrder('teacher_progress', "(progress_report_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_progress = $no_of_progress + 1;
						}
					}					
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_progress;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?> :&nbsp;</td>
                    <?php
					$no_of_attand = 0;
					foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
						$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]'");
						$c_id = $centre_grp["centre_id"];
						if($c_id == $centre_id){
							$no_of_attand = $no_of_attand + 1;
						}
					}
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $no_of_attand;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_ABSENT");?>:&nbsp;</td>
                    <?php
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='Yes' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_CANCEL");?>:&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_STUDENT_TRANSFER");?>&nbsp;</td>
                    <td align="center" valign="middle" class="pedtext">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp; <?php echo constant("MANAGE_LISM_REPORT_GROUP_TRANSFER");?>&nbsp;</td>
                    <?php
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Continue' And (created_datetime BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_GROUP_COMPLETED");?>:&nbsp;</td>
                    <?php
					$group = $dbf->strRecordID("student_group","COUNT(id)","status='Completed' And (completed_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$group = $group["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $group;?></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                    <td height="25" align="right" valign="top" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_TOTAL_SALE");?> :&nbsp;</td>
                    <td align="center" valign="top" style="padding-top:2px; padding-bottom:2px;">
                    <table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" style="border-collapse:collapse;">
                    <?php
					$total = 0;
					foreach($dbf->fetchOrder('common',"type='payment type'","id DESC") as $valpay) {						
						$amts = $dbf->strRecordID("student_fees","SUM(paid_amt)","payment_type='$valpay[id]' And centre_id='$centre_id'");
						$amts = $amts["SUM(paid_amt)"];
						$total = $total + $amts;
						?>
                      <tr class="mymenutext">
                        <td width="51%" align="center" valign="middle"><?php echo $valpay["name"];?></td>
                        <td width="49%" align="center" valign="middle" class="pedtext"><?php echo $amts;?> <?php echo $res_currency[symbol];?></td>
                      </tr>
                      <?php } ?>
                      <tr class="mymenutext">
                        <td height="20" colspan="2" align="center" valign="middle"><?php echo constant("CD_REPORT_TEACHER_PROGRESS_TOTAL");?> : <?php echo $total;?> <?php echo $res_currency[symbol];?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="61%" height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_TEACH_UNIT");?> :&nbsp;</td>
                    <td width="33%" align="center" valign="middle" class="pedtext">
                    <?php
                        $res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')");
						$no_student = $res["COUNT(a.id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_SMS_SENT");?>:&nbsp;</td>
                    <?php
					$sms = $dbf->strRecordID("sms_history","COUNT(id)","automatic='' And (dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$sms = $sms["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $sms;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_EMAIL_SENT");?>:&nbsp;</td>
                    <?php
					$email = $dbf->strRecordID("email_history","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$email = $email["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $email;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="25" align="right" valign="middle" class="lable1">&nbsp;<?php echo constant("MANAGE_LISM_REPORT_ARF_LOGGED");?>:&nbsp;</td>
                    <?php
					$arf = $dbf->strRecordID("arf","COUNT(id)","(dated BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'");
					$arf = $arf["COUNT(id)"];
					?>
                    <td align="center" valign="middle" class="pedtext"><?php echo $arf;?></td>
                  </tr>
                </table></td>
              </tr>                
              </table>