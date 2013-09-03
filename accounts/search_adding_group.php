<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$student_id = $_REQUEST['student_id'];

$centre_id = $dbf->getDataFromTable("student", "centre_id", "id='$student_id'")
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
	if(document.frm.group.value=="")
	{
		document.getElementById('lbl_error').innerHTML="Select a group.";
		document.frm.group.focus();
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
<?php if($_SESSION[lang]=="EN"){?>
<form id="frm" name="frm" method="post" action="search_adding_group_process.php?student_id=<?=$student_id;?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="21%" align="left" valign="middle" class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></td>
          <td width="68%"  align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"> &nbsp;<?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_ADDTEXT");?></td>
          <td width="11%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="380" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="31%" align="right" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
			  <?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_GROUPNM");?>:</td>
              <td width="3%">&nbsp;</td>
              
              <td width="66%" align="left" valign="middle">
              <select name="group" class="combo" id="group" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> Select Group </option>
                <?php
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And status<>'Completed'","") as $res_g) {
					$course = $dbf->strRecordID("course","name","id='$res_g[course_id]'");
					$already_taught = $dbf->countRows("student_group_dtls","student_id='$student_id' And course_id='$res_g[course_id]'");
					if($already_taught == 0){
				  ?>
                <option value="<?php echo $res_g['id']?>"><?php echo $res_g['group_name'].' ['.$course["name"].']';?></option>
                <?php }} ?>
              </select></td>
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
<form id="frm" name="frm" method="post" action="search_adding_group_process.php?student_id=<?=$student_id;?>" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="6%" align="left" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
          <td width="73%" align="right"  style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_ADDTEXT");?>&nbsp;</td>
          <td width="21%" align="right" valign="middle"><img src="../logo/logo-ar.png" width="100" height="30" /></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="right" valign="middle"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="380" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" class="red_smalltext">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="66%" align="right" valign="middle">
              <select name="group" class="combo" id="group" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> <?php echo constant("SELECT_GROUP");?> </option>
                <?php
				foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id' And status<>'Completed'","") as $res_g) {
					$course = $dbf->strRecordID("course","name","id='$res_g[course_id]'");
					$already_taught = $dbf->countRows("student_group_dtls","student_id='$student_id' And course_id='$res_g[course_id]'");
					if($already_taught == 0){
				  ?>
                <option value="<?php echo $res_g['id']?>"><?php echo $res_g['group_name'].' ['.$course["name"].']';?></option>
                <?php }} ?>
              </select></td>
              <td width="3%">&nbsp;</td>
              <td width="31%" align="left" valign="middle" class="leftmenu" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
			  :<?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_GROUPNM");?></td>              
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
