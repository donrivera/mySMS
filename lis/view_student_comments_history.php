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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

if($_REQUEST[action] == "send"){
	
	//Comment or Message
	$comments = mysql_real_escape_string($_REQUEST[msg]);
	
	//Date and Time
	$dt = date('Y-m-d h:m:s');
	
	//insert query here
	$string="student_id='$_REQUEST[student]',user_id='$_SESSION[id]',comments='$comments',date_time='$dt'";	
	$id = $dbf->insertSet("student_comment",$string);
	
	//Set to Header Location
	header("Location:view_student_comments_history.php?student=$_REQUEST[student]");
}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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

</head>
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

function save(){
	
	var msg = document.getElementById('msg').value;
	if(msg == ''){
		window.location.href='view_student_comments_history.php?student='+<?php echo $_REQUEST[student];?>;
	}else{
		window.location.href='view_student_comments_history.php?action=send&msg='+msg+'&student='+<?php echo $_REQUEST[student];?>;
	}
}
function onEnter(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode	
	if(charCode == 13){
		save();
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <form name="frm" id="frm" method="post">
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
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
            <td bgcolor="#b4b4b4"  style="background:url(../images/footer_repeat.png) repeat-x;">
            
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="23%" height="30" class="logintext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE");?></td>
                <td width="12%" align="left" valign="middle" class="logintext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_OPTION");?></td>
                <td width="39%" align="left">
                <select name="student" id="student" style="border:solid 1px; border-color:#999999; background-color:#ECF1FF; width:187px;" onChange="javascript:document.frm.action='view_student_comments_history.php',document.frm.submit();">
               
                <option value=""> Select Student </option>
                  <?php
					foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]'","") as $res) {
					  ?>
                  <option value="<?php echo $res['id']?>" <?php if($res["id"]==$_REQUEST["student"]) { ?> selected="selected" <?php }?>><?php echo $res['first_name'];?> <?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></option>
                  <?php }?>
                </select></td>
                <td width="26%" align="right"><a href="home.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <?php
			  $res_student = $dbf->strRecordID("student","*","id='$_REQUEST[student]'");
			  ?>
              <tr>
                <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding-top:10px;"><table width="650" border="1" cellspacing="0" bordercolor="#336699" cellpadding="0">
                  <tr>
                    <td height="30" align="center" valign="middle" class="loginheading" style="background-image:url(../images/phone-mid.png); "><?php echo $res_student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                    </tr>
                  </table></td>
              </tr>                   
              <tr>
                <td align="center" valign="middle" bgcolor="#FFFFFF">
                <table width="650" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#336699;">
                  <tr>
                  <?php
                  $num=$dbf->countRows('student_comment',"student_id='$_REQUEST[student]'");
                  ?>
                    <td align="center" valign="top" style="padding-top:5px;">
                    <?php
					if($num > 0) {
					?>
                    <table width="648" border="0" cellspacing="0" cellpadding="0">
                      <?php
					  $i = 0;
					  foreach($dbf->fetchOrder('student_comment',"student_id='$_REQUEST[student]'","id") as $resc) {
					  
					  //Get user name
					  $user = $dbf->strRecordID("user","*","id='$resc[user_id]'");
					  
						if ($i % 2) {
							?>
                            <tr>
                        <td width="313" align="left" valign="middle">
                        <!-- Green -->
                          <table width="99%" border="0" cellspacing="0" cellpadding="0" >
                            <tr>
                              <td width="34" align="left" valign="top"><img src="../images/1leftgrbg.png" width="34" height="15" /></td>
                              <td background="../images/1midgrbg.png" class="shop2"><?php echo constant("STUDENT_HOME_POSTEDBY");?> : <?php echo $user[user_name];?></td>
                              <td width="9" align="right" valign="top" bgcolor="#C8EF54"><img src="../images/1right_grbg.png" width="9" height="9" /></td>
                            </tr>
                            <tr>
                              <td background="../images/1left_mid.png">&nbsp;</td>
                              <td align="left" valign="middle" bgcolor="#C8EF54" class="shop1"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?> : <?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?></td>
                              <td bgcolor="#C8EF54">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><img src="../images/1right_bot_bg.png" width="34" height="43" /></td>
                              <td align="left" valign="top" background="../images/1bot_mid.png" class="shop2"><?php echo $resc["comments"];?></td>
                              <td><img src="../images/1right_bot.png" width="11" height="43" /></td>
                            </tr>
                          </table></td>
                        <td width="235" align="left" valign="middle">&nbsp;</td>
                      </tr>
                            <?php
						} else {
							?>                            
                      		<tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="right" valign="middle">
                        <!-- Gray -->
                          <table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="12"><img src="../images/left_topgrey.png" width="12" height="10" /></td>
                              <td background="../images/top_mid_grey.png"></td>
                              <td width="28" align="left" valign="top"><img src="../images/right_top_grey.png" width="28" height="10" /></td>
                            </tr>
                            <tr>
                              <td background="../images/left_mid_grey.png">&nbsp;</td>
                              <td align="left" valign="middle" class="shop2"><?php echo constant("STUDENT_HOME_POSTEDBY");?> : <?php echo $user[user_name];?></td>
                              <td background="../images/right_midgrey.png">&nbsp;</td>
                            </tr>
                            <tr>
                              <td background="../images/left_mid_grey.png">&nbsp;</td>
                              <td align="left" valign="middle" class="shop1"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?> : <?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?></td>
                              <td background="../images/right_midgrey.png">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><img src="../images/left_bot_grey.png" width="12" height="44" /></td>
                              <td align="left" valign="top" background="../images/bot_mid_grey.png" class="shop2"><?php echo $resc["comments"];?></td>
                              <td align="left"><img src="../images/right_bot_grey.png" width="28" height="44" /></td>
                            </tr>
                          </table></td>
                      </tr>
                            <?php
						}
					  ?>
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"></td>
                        <td align="left" valign="middle"></td>
                      </tr>
                      <?php $i++; } ?>
                    </table>
                    <?php
					}
					else
					{
					?>
                    <br />
					<table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
                      <tr>
                        <td width="39" align="center" valign="middle" bgcolor="#FFF1DF"><img src="../images/news.jpeg" width="18" height="21" /></td>
                        <td width="311" align="left" valign="middle" bgcolor="#FFF1DF"><?php echo constant("NO_COMMENTS");?></td>
                        </tr>
                    </table>
                    <br />
					<?php } ?>
                    </td>
                  </tr>
                  <?php if($_REQUEST[student]!='') { ?>
                  <tr>
                    <td height="40" align="center" valign="middle" style="background-image:url(../images/phone-mid.png); ">
                    <table width="630" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="490" height="40" align="left" valign="middle">
                        <textarea name="msg" id="msg" style="width:580px; height:35px; border:solid 1px; border-color:#699;background-color:#E6F7FF;" onkeypress="onEnter(event);"></textarea></td>
                        <td width="40" align="center" valign="middle">
                        <img src="../images/smile.png" width="23" height="33" onclick="save();" title="<?php echo constant("btn_send_btn");?>" style="cursor:pointer;"/></td>
                      </tr>
                    </table></td>
                  </tr>
                  <?php } ?>
                </table></td>
              </tr>                    
			  <tr>
				<td bgcolor="#FFFFFF" colspan="3"></td>
              </tr>
              <tr>
                <td  align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>

</body>
</html>