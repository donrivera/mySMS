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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

$res_dtls = $dbf->strRecordID("course","*","id='$_REQUEST[course_id]'");

include_once '../includes/language.php';

if($_REQUEST["action"] == "edit"){
	
	# Update status as 0 mean deactive the previous course fee
	$dbf->updateTable("course_fee", "status='0'", "course_id='$_REQUEST[course_id]'");
	
	# New course fees has been added
	$string = "course_id='$_REQUEST[course_id]',fees='$_REQUEST[course_fees]',status='1'";
	$dbf->insertSet("course_fee", $string);
	
	# set as header location
	header("Location:course_fee.php?course_id=$_REQUEST[course_id]");
	exit;
}

if($_REQUEST["action"] == "delete"){
	
	# delete the particular course fee
	$dbf->deleteFromTable("course_fee", "id='$_REQUEST[record_id]'");
	
	# set as header location
	header("Location:course_fee.php?course_id=$_REQUEST[course_id]");
	exit;
}

if($_REQUEST["action"] == "remove"){
	
	# Update status as 0 mean deactive the previous course fee
	$dbf->updateTable("course_fee", "status='0'", "course_id='$_REQUEST[course_id]'");
	
	# Update status as 1 mean active the current course fee
	$dbf->updateTable("course_fee", "status='1'", "id='$_REQUEST[record_id]'");
	
	# set as header location
	header("Location:course_fee.php?course_id=$_REQUEST[course_id]");
	exit;
}
?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]==''){
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$("#frm").validationEngine()
});

function PhoneNo(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90))){
		return false;
	}else{
		return true;
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_MENU_COURSE");?></td>
                <td width="22%" >&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"></td>
                <td width="8%" align="left"><a href="course_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <?php if($_REQUEST[msg]=="added") { ?>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                <tr>
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                  <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="nametext"><?php echo constant("COMMON_RECORDADDMSG");?></td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
            <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="top">
                        <form action="course_fee.php?action=edit" name="frm" method="post" id="frm" onSubmit="return validate();">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                            <tr>
                              <td width="7%">&nbsp;<input type="hidden" name="course_id" id="course_id" value="<?php echo $_REQUEST["course_id"];?>"></td>
                              <td width="29%">&nbsp;</td>
                              <td width="3%">&nbsp;</td>
                              <td width="27%">&nbsp;</td>
                              <td width="1%">&nbsp;</td>
                              <td width="33%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_MENU_COURSE");?> :&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" class="pedtext"><?php echo $res_dtls["name"];?></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COURSE_MANAGE_COURSEFEES");?>  : <span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input name="course_fees" type="text" class="validate[required] new_textbox1" id="course_fees" onKeyPress="return PhoneNo(event);" autocomplete="off"/></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="6" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="10" colspan="6" align="left" valign="middle"></td>
                            </tr>
                          </table>
                  		</form>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="top">
                        
                          <table width="100%" border="1" cellpadding="0" bordercolor="#999999" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="22" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">Sl.</td>
                              <td align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">Course Fee(s)</td>
                              <td colspan="3" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">Action</td>
                            </tr>
                            <?php
                            $k = 1;
							$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
							$num = $dbf->countRows("course_fee", "course_id='$_REQUEST[course_id]'");
							foreach($dbf->fetchOrder('course_fee',"course_id='$_REQUEST[course_id]'","id DESC") as $course_fee) {
							?>
                            <tr>
                              <td width="12%" height="21" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                              <td width="53%" align="left" valign="middle" class="mytext"><?php echo $course_fee["fees"];?>&nbsp;<?php echo $res_currency[symbol];?></td>
                              <td width="11%" align="center" valign="middle">
                              <?php if($course_fee["status"] == "1"){?>
                              <a href="course_fee.php?action=remove&course_id=<?php echo $_REQUEST["course_id"];?>&record_id=<?php echo $course_fee["id"];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Default"></a>
                              <?php }else{?>
                              <a href="course_fee.php?action=remove&course_id=<?php echo $_REQUEST["course_id"];?>&record_id=<?php echo $course_fee["id"];?>"><img src="../images/icon_key.gif" width="16" height="16" border="0" title="Set Default"></a>
                              <?php } ?>
                              </td>
                              <td width="12%" align="center" valign="middle"><a href="course_fee_edit.php?course_id=<?php echo $_REQUEST["course_id"];?>&edit_id=<?php echo $course_fee["id"];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit"></a></td>
                              <td width="12%" align="center" valign="middle"><a href="course_fee.php?action=delete&course_id=<?php echo $_REQUEST["course_id"];?>&record_id=<?php echo $course_fee["id"];?>"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete"></a></td>
                            </tr>
                            <?php
							$k++;
							}
							if($num == 0){
							?>
                            <tr>
                              <td height="25" colspan="5" align="center" valign="middle" class="red_smalltext">No course fees found !!!</td>
                            </tr>
                            <?php } ?>
                            </table>
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
   <?php include '../footer.php';?>
</table>
</body>
</html>
