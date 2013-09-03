<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$i = 1;
foreach($dbf->fetchOrder('alerts',"(rep='1' AND status='0') OR audience='1'","id DESC LIMIT 0,10") as $val) {
?>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<table width="450" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
	  <td width="4">&nbsp;</td>
	  <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="26%" align="left" valign="middle" class="hometest_name"><?php echo constant("STUDENT_ADVISOR_ALERT_POSTEDBYADMIN");?>  </td>
			<td width="74%" align="left" valign="middle" class="hometest_time"><?php echo date("l, M Y",strtotime($val["dt"]));?>&nbsp;,<?php echo $val["tm"];?></td>
		  </tr>
		  <tr>
			<td height="5"></td>
			<td height="5"></td>
		  </tr>
		  <?php $valm = $dbf->strRecordID("common","*","id='$val[alert_id]'"); ?>
		  <?php if($val["imp"]=="1") { ?>
		  <tr>
		    <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11%" align="left" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_MARKAS");?> : </td>
                <td width="6%" align="center" valign="middle" class="hometest_time"><img src="../images/important.png" width="16" height="16"></td>
                <td width="83%" align="left" valign="middle" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_IMPORTANT");?></td>
              </tr>
            </table></td>
	    </tr>
		<?php } ?>
		  <tr>
		    <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("STUDENT_ADVISOR_ALERT_MSGTYPE");?> : <?php echo $valm["name"];?></td>
	    </tr>
		  <tr>
			<td colspan="2" align="left" valign="top" class="tabledetailtext"><?php echo $val["imp_info"];?></td>
		  </tr>
	  </table></td>
	</tr>
	<tr>
	  <td height="10" colspan="3"></td>
	</tr>
	<tr>
	  <td height="1" colspan="3" bgcolor="#d8dfea"></td>
	</tr>
</table>
<?php $i++; } ?>