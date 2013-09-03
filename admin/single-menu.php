<?php
$student_id = $_REQUEST['student_id'];

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$page = $parts[count($parts) - 1];
?>
  <style>
  .sbutton{background:url(../images/sbutton.png) no-repeat;width:208px; height:25px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px; color:#FFF;}
  .sbutton a{color:#FFF;text-decoration:none;}
	  
  .sbuttonh{background:url(../images/sbuttonh.png) no-repeat;width:206px; height:25px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px; color:#FFF;}
  .sbuttonh a{color:#FFF;text-decoration:none;}
	</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13%">&nbsp;</td>
            <?php if($page == "single-home.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td width="87%" height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-home.php?student_id=<?php echo $student_id;?>"><?php echo constant("ADMIN_MENU_HOME");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td width="13%">&nbsp;</td>
            <?php if($page == "single-myprofile.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td width="87%" height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-myprofile.php?student_id=<?php echo $student_id;?>"><?php echo constant("ADMIN_NEWS_MANAGE_INFORMATION");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-payment.php" || $page == "single-payment-edit.php" || $page == "single-payment-made.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-payment.php?student_id=<?php echo $student_id;?>"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMENT");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-comments.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-comments.php?student_id=<?php echo $student_id;?>"><?php echo constant("CD_EP_CLASS_CANCEL_COMMENTS");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-sms.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-sms.php?student_id=<?php echo $student_id;?>"><?php echo constant("SMS_AND_EMAIL");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-group.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-group.php?student_id=<?php echo $student_id;?>"><?php echo constant("TE_MENU_MY_GROUP");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-transfer.php" || $page == "single-student_to_student_add.php" || $page == "single-center_to_center_add.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-transfer.php?student_id=<?php echo $student_id;?>"><?php echo constant("SA_TRANSFER");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-cancel.php" || $page == "single-cancel-add.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-cancel.php?student_id=<?php echo $student_id;?>"><?php echo constant("CANCELLATION_REQUEST");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-appoint.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-appoint.php?student_id=<?php echo $student_id;?>"><?php echo constant("STUDENT_APPOINT");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-hold.php" || $page == "single-hold-add.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-hold.php?student_id=<?php echo $student_id;?>"><?php echo constant("STUDENT_ADVISOR_AUDITING_ONHOLD");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-cycle.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-cycle.php?student_id=<?php echo $student_id;?>"><?php echo constant("STUDENT_ADVISOR_AUDITING_TXT");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-audit.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-audit.php?student_id=<?php echo $student_id;?>"><?php echo constant("AUDIT_AND_HISTORY");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-p-report.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-p-report.php?student_id=<?php echo $student_id;?>"><?php echo constant("TE_MENU_PR");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-certificate.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-certificate.php?student_id=<?php echo $student_id;?>"><?php echo constant("ADMIN_MENU_CERTIFICATE");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-certificate-audit.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-certificate-audit.php?student_id=<?php echo $student_id;?>"><?php echo constant("TEACHER_REPORT_TEACHER_CERTIFICATE_AUDIT");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-password.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-password.php?student_id=<?php echo $student_id;?>"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php if($page == "single-reports.php" || $page == "single-arf.php"){ $class="sbuttonh"; }else{ $class = "sbutton"; } ?>
            <td height="26" align="center" valign="middle" class="<?php echo $class;?>"><a href="single-reports.php?student_id=<?php echo $student_id;?>"><?php echo constant("ADMIN_MENU_REPORTS");?></a></td>
          </tr>
          <tr>
            <td height="2"></td>
            <td height="2" align="left" valign="middle"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="40" align="left" valign="middle">&nbsp;</td>
          </tr>
        </table>