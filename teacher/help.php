<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_SESSION['ALERT_DISPLAY'] == ''){
$alert_count = $dbf->countRows("alerts", "teacher='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
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

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!-- POP UP modal box -->
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.2.js"></script>
<link rel="stylesheet" href="../fancybox/jquery.fancybox-1.3.2.css" type="text/css" media="screen" />
<!-- POP UP modal box -->

</head>
<script language="JavaScript"> 
function show_a(row){
	 var d = "diva"+row;
	 if(document.getElementById(d).style.display == 'none'){
		 document.getElementById(d).style.display = '';
	 }else if(document.getElementById(d).style.display == ''){
		 document.getElementById(d).style.display = 'none';
	 }
 }
 
function validate(row){
	 var d = "msg"+row;
	 if(document.getElementById(d).value == ''){
		 return false;
	 }
} 
</script>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}

var x = <?php echo $alert_count; ?>;
$(function(){
	if(x > 0){
	//var res="<div style='width:300px;height:200px;border:2px solid red;'class='post_review_main'> bye bye</div>";
	$.post("alert_page.php",{"choice":"alert_respose"},function(res){
		$.fancybox(res,{centerOnScroll:true,hideOnOverlayClick:false});
	});
	
	}
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds

// Alert set 1 time by session
$_SESSION['ALERT_DISPLAY'] = 'TRUE';
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_HELP_MANAGE_MANAGE_HELP");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td  align="left" valign="top">&nbsp;</td>
           </tr>
           <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="3%" scope="col">&nbsp;</th>
                <th width="28%" height="25" align="left" valign="middle" class="mymenutext" scope="col"><?php echo $res_help[title];?></th>
                <th width="69%" align="left" valign="top" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th colspan="2" align="left" valign="top"><?php echo $res_help["descr"];?></th>
                </tr>
            </table></td>
          </tr> 
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="right" class="logintext"><?php echo constant("ADMIN_HELP_MANAGE_MANAGE_HELP");?>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
           <tr>
             <td  align="left" valign="top">&nbsp;</td>
           </tr>
           <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
                <th width="69%" align="left" valign="top" scope="col">&nbsp;</th>
                <th width="28%" height="25" align="right" valign="middle" class="mymenutext" scope="col"><?php echo $res_help[title];?></th>
                <th width="3%" scope="col">&nbsp;</th>
              </tr>
              <tr>
                
                <th colspan="2" align="right" valign="top"><?php echo $res_help["descr"];?></th>
                <th scope="col">&nbsp;</th>
                </tr>
            </table></td>
          </tr> 
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
