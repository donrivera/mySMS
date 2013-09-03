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
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$centre_id = $_SESSION['centre_id'];
?>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
    <tr>
      <td height="20" colspan="2" align="right" valign="middle" style="padding-right:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="35" align="left" valign="middle"><span class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></span></td>
          <td align="right" valign="middle"><a href="single-sms-details-print.php?student_id=<?php echo $_REQUEST["student_id"];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" /></a></td>
          <td width="30" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><table width="650" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
        <tr>
          <td height="30" align="center" valign="middle" bgcolor="#FEF7D8">
          <table width="620" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
            <tr class="passwordtext">
              <td width="46" height="25" align="center" valign="middle">Sl.</td>
              <td width="135" align="left" valign="middle">Sent Date/Time</td>
              <td width="276" align="left">Message Details</td>
              <td width="87" align="center">Sent By</td>
              <td width="76" align="center" valign="middle" >Automatic</td>
            </tr>
            <?php
			echo '<span class="login_header1">Recipient Name : '.$dbf->getDataFromTable("student","first_name","id='$_REQUEST[student_id]'");
			$i = 1;
			foreach($dbf->fetchOrder('sms_history m,sms_history_dtls d',"m.id=d.parent_id And d.student_id='$_REQUEST[student_id]'","d.id","m.*") as $res_temp) {
				if($res_temp["user_id"] == 0){
					$by = 'CRON';
				}else{
					$by = $dbf->getDataFromTable("user","user_name","id='$res_temp[user_id]''");
				}
			?>
            <tr class="tabledetailtext">
              <td height="22" align="center" valign="middle"><?php echo $i;?></td>
              <td align="left" valign="middle"><?php echo date("d l, M Y",strtotime($res_temp["dated"]));?></td>
              <td align="left" valign="middle">&nbsp;<?php echo $res_temp["msg"];?></td>
              <td align="center" valign="middle">&nbsp;<?php echo $by;?></td>
              <td align="center" valign="middle"><?php if($res_temp["automatic"] == '') { echo ''; }else { echo 'Yes'; } ?></td>
            </tr>
            <?php $i++; } ?>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td width="19%" align="left" valign="middle" class="leftmenu">&nbsp;</td>
      <td width="66%" align="left" valign="middle">&nbsp;</td>
    </tr>
</table>