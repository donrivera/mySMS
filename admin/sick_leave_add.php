<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

include 'application_top.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" >
function showOption(id){
	if(id=='1'){
		document.getElementById("tr1").style.display ='';
	}else{
		document.getElementById("tr1").style.display ='none';
	}
}
</script>
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;
width:165px;
height:25px;
font-family:Arial, Helvetica, sans-serif;
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
.mytext{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
color:#336699;
font-weight:normal;
padding-left:2px;
}
</style>
</head>
<body>
<form id="frm" name="frm" method="post" action="sick_leave_process.php" >
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="22%" align="left" valign="middle"><span class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></span></td>
          <td width="67%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("CD_SICK_LEAVE_ADD_LEAVESTATUS");?></td>
          <td width="11%" align="center" valign="middle"><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST[id];?>" /><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer" title="Close"/></td>
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
          <td width="306" height="30" id="lbl_error" style="font-family:Arial, Helvetica, sans-serif; color:#FF0000; font-weight:normal; font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              	<td width="31%" height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"> <?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?>: <span style="color:#FF0000; font-weight:bold;">*&nbsp;</span></td>
              	<td width="3%">&nbsp;</td>
              	<td width="66%" align="left" valign="middle">
				  <select name="status" id="status" style="width:150px; border:solid 1px; border-color:#FF9900;" onchange="showOption(this.value)">
				  <option value="1">Approved</option>
				  <option value="2">Rejected</option>
				  </select>
				 </td>
              </tr>
             <tr>
              	<td height="5" colspan="3" align="right" valign="middle"></td>
             </tr>
			 <tr id="tr1" style="display:''">
			 	<td width="31%" height="30" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:bold; font-size:12px;"><?php echo constant("CD_SICK_LEAVE_ADD_OPTION");?> : <span style="color:#FF0000; font-weight:bold;">*&nbsp;</span></td>
              	<td width="3%">&nbsp;</td>
              	<td  width="66%" align="left" valign="middle">
					<select name="option" id="option" style="width:150px; border:solid 1px; border-color:#FF9900;">
					  <option value="1">Substitute Teacher</option>
					  <option value="2">Class Cancelled</option>
					</select>
				</td>
             </tr>
            </table>
			</td>
        </tr>
        <tr>
          <td height="1" colspan="3" ></td>
        </tr>
        <tr>
          <td height="30" colspan="3"></td>
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
              <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onchange="showsms(this.value)" /></td>
              <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
            </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                <tr>
                  <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:280px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off">Your leave has been XXXXXXXX</textarea></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" colspan="3"></td>
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
</body>
</html>
