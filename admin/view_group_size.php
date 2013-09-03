<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_VIEW_GROUP_SIZE");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="96%" height="30" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td class="nametext1" style="padding-left:5px;"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_NOTE");?> :</td>
                    </tr>
                  <tr>
                    <td style="text-align:justify;padding-left:5px;"><span class="mytext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_TEXT");?></span></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="middle">
                	<?php
					 foreach($dbf->fetchOrder('centre',"","name") as $centre) {
                	?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%" colspan="2" align="left" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle" style="padding-left:5px;">
                        <table width="300" border="1" bordercolor="#666666" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="47" height="25" align="left" valign="middle" bgcolor="#999999" class="logintext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?></td>
                            <td width="245" align="left" valign="middle" bgcolor="#999999" class="logintext"><?php echo $centre[name];?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle" style="padding-left:5px;">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA">
                          <tr class="leftmenu">
                            <td width="5%" height="25" align="center" valign="middle" bgcolor="#DDDDDD" >&nbsp;</td>
                            <td width="24%" align="left" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_NAMEOFGROUP");?></td>
                            <td width="25%" align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_SIZEOFGROUP");?></td>
                            <td width="17%" align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_LENGTHOFCOURSES");?></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_UNITSETBY");?></td>
                            <td width="14%" align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_AFTER");?></td>
                          </tr>
                        <?php
						 
						$i = 1;
                        $color = "#ECECFF";
                        
                        foreach($dbf->fetchOrder('common',"type='group group'","id") as $val) {
						
						//Get value from group size
						$res_s = $dbf->strRecordID("group_size","*","group_id='$val[id]'");
						
						if($res_s[size_from] == "0" && $res_s[size_from] == "0")
						{
							$sf = "Flex";
						}
						else
						{
							$sf = $res_s[size_from];
						}
						if($res_s[size_from] == "0" && $res_s[size_from] == "0")
						{
							$st = "Flex";
						}
						else
						{
							$st = $res_s[size_to];
						}
						
						//Get value from group size after re-sizing with centre ID
						$num_g=$dbf->countRows('centre_group_size',"group_id='$val[id]' And centre_id='$centre[id]'");
						if($num_g>0)
						{
							$res_re = $dbf->strRecordID("centre_group_size","*","group_id='$val[id]' And centre_id='$centre[id]'");
							if($res_re[effect_units] == "0" && $res_re[units] == "0")
							{
								$re = "Flex";
							}
							else
							{
								$re = $res_s[effect_units];
							}
						}
						else
						{
							$re = '';
						}
                        ?>
                          <tr  bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                            <td height="30" align="center" valign="middle"  class="contenttext">&nbsp;</td>
                            <td height="25" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $val[name];?></td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;"><input name="size_from<?php echo $i;?>" type="text" class="new_textbox40" id="size_from<?php echo $i;?>" value="<?php echo $sf;?>" readonly="readonly"/>
                              <input name="size_to<?php echo $i;?>" type="text" class="new_textbox40" id="size_to<?php echo $i;?>" value="<?php echo $st;?>" readonly="readonly"/></td>
                            <?php
								if($res_s[units] != "0")
								{
									$unit_no = ($res_s[units] / 10)." weeks";
								}
								else
								{
									$unit_no = "Flex";
								}
								?>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;"><input name="week_id<?php echo $i;?>" type="text" class="new_textbox1" id="week_id<?php echo $i;?>" value="<?php echo $unit_no;?>" readonly="readonly" /></td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                              <?php
							if($res_s[units] == "0")
							{
								$u = "Flex";
							}
							else
							{
								$u = $res_s[units];
							}
							?>
                              <input name="units<?php echo $i;?>" type="text" class="new_textbox40" id="units<?php echo $i;?>" value="<?php echo $u;?>" readonly="readonly"/>
                            </td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;"><input name="units<?php echo $i;?>2" type="text" class="new_textbox40" id="units<?php echo $i;?>2" value="<?php echo $re;?>" readonly="readonly"/></td>
                            <?php
                          $i = $i + 1;
						  if($color=="#ECECFF")
						  {
							  $color = "#FBFAFA";
						  }
						  else
						  {
							  $color="#ECECFF";
						  }
						  
                          }
                          ?>
                            <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>" />
                          </tr>
                        </table></td>
                      </tr>
                      </table>
                  	<?php
					 }
					 ?>
                  </td>
              </tr>
              
              
              <tr>
                <td align="left" valign="middle">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
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
