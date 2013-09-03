<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$res_tran = $dbf->strRecordID("transfer_centre_to_centre", "*", "id='$_REQUEST[tran_id]'");
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>
<script language="javascript" type="text/javascript">
function check(){
	if(document.frm.status.value==""){
		document.getElementById('lbl_error').innerHTML="Select a Status.";
		document.frm.status.focus();
		return false;
	}
	if(document.frm.comment.value==""){
		document.getElementById('lbl_error').innerHTML="Enter the valid Comments.";
		document.frm.comment.focus();
		return false;
	}
}
</script>
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
.btn2{
background:url(../images/btn2.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
</style>
</head>
<body>
<?php if($_SESSION['lang']=='EN'){?>
<form id="frm" name="frm" method="post" action="center_to_center_process.php?action=update&tran_id=<?=$_REQUEST[tran_id];?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></td>
          <td width="19%">&nbsp;</td>
          <td width="11%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="440" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
			  <?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?>:</td>
              <td width="2%">&nbsp;</td>
              <td width="78%" align="left" valign="middle">&nbsp;
              <select name="status" class="combo" id="status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> Select </option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
              </select></td>
              </tr>
            <tr>
              <td align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle" class="nametext">Paid Amount : <?php echo $dbf->BalanceAmount($res_tran["student_id"], $res_tran["from_course_id"]);?></td>
            </tr>
            <tr>
              <td align="right" valign="top" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?> : &nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><span class="mymenutext">
                <textarea name="comment" id="comment" rows="3" cols="30" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea>
              </span></td>
            </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="97%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%" align="center" valign="middle">
			  <script language="JavaScript" type="text/javascript">
				function showsms(val){
					if(val == "3"){
						document.getElementById('smsid').style.display = "block";
					}else{
						document.getElementById('smsid').style.display = "none";
					}
				}
				</script>
                <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
              <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
            </tr>
            <tr>
              <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
              <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
            </tr>
            <!--<tr>
            <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
            <td align="left" valign="middle" class="mytext">Change SMS</td>
          </tr>-->
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <?php
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
								?>
              <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                <tr>
                  <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:400px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php } else{?>
<form id="frm" name="frm" method="post" action="center_to_center_process.php?action=update&tran_id=<?=$_REQUEST[tran_id];?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="70%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
          <td width="19%">&nbsp;</td>
          <td width="11%" align="center" valign="middle"><img src="../logo/logo-ar.png" width="100" height="30" /></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="440" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="78%" align="right" valign="middle">&nbsp;
              <select name="status" class="combo" id="status" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> <?php echo constant("SELECT");?> </option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
              </select></td>
              <td width="2%">&nbsp;</td>
              <td width="20%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
			  : <?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" class="nametext"><?php echo $dbf->BalanceAmount($res_tran["student_id"], $res_tran["from_course_id"]);?> : <?php echo constant('CD_SEARCH_INVOICE_PAIDAMOUNT');?></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
               <td align="right" valign="middle">
                <textarea name="comment" id="comment" rows="3" cols="30" style="border:solid 1px; text-align:right; background-color:#ECF1FF; border-color:#999999;"></textarea>
              </td>
              <td>&nbsp;</td>
              <td align="left" valign="top" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;"> : &nbsp;<?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></td>
            </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="97%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="94%" align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
              <td width="6%" align="center" valign="middle">
			  <script language="JavaScript" type="text/javascript">
				function showsms(val){
					if(val == "3"){
						document.getElementById('smsid').style.display = "block";
					}else{
						document.getElementById('smsid').style.display = "none";
					}
				}
				</script>
                <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
            </tr>
            <tr>
              <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
              <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
            </tr>
            <!--<tr>
            <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
            <td align="left" valign="middle" class="mytext">Change SMS</td>
          </tr>-->
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <?php
								$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
								?>
              <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                <tr>
                  <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:400px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right" valign="top" style="padding-right:8px;"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php }?>
</body>
</html>
