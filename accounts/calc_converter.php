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

include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>
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
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
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
        <td width="79%" align="left" valign="top" style="border:solid 1px; border-color:#999;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;" ><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" align="left" valign="middle" class="centercolumntext"><?php echo constant("RECEPTION_CALC_CONVERTER_DATA_CONVERTER");?></td>
                  <td width="22%" id="lblname">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="200" align="center" valign="middle" bgcolor="#FFFFFF">
			<br>
			<table width="900" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#006600;">
              
              <tr>
                <td>&nbsp;</td>
                <td width="150" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
                <td width="167">&nbsp;</td>
                <td width="479">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td>
                <td colspan="3" align="left" valign="middle" class="bigerrortext"><table width="860" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="425" align="left" valign="top"><iframe height="230" width="420" src="calc_eng.php" style="border:none;"> </iframe></td>
                    <td width="10">&nbsp;</td>
                    <td width="425" align="left" valign="top"><iframe height="230" width="420" src="calc_hijri.php" style="border:none;"> </iframe></td>
                  </tr>
                </table></td>
                <td width="20">&nbsp;</td>
              </tr>
			  

              <tr>
                <td colspan="5">&nbsp;</td>
                </tr>
			 
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
                </tr>
            </table></td>
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
