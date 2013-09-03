<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
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


<script language="javascript" type="text/javascript">
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
}
</script>	
</head>
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
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION["lang"] == "EN") { ?>
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
                <td width="54%" height="30" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_VIEWGROUPSIZE");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="96%" height="30" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td class="nametext1"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_NOTE");?> :</td>
                    </tr>
                  <tr>
                    <td class="mytext" style="text-align:justify;"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT");?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="middle">
                
                	<form action="group_size_process.php" name="frm" method="post" id="frm">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" align="left" valign="middle">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
                          <tr class="leftmenu">
                            <td width="5%" height="25" align="center" valign="middle" bgcolor="#DDDDDD">&nbsp;</td>
                            <td width="24%" align="left" valign="middle" bgcolor="#DDDDDD" class="logintext"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT1");?></span></td>
                            <td width="25%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT2");?></span></td>
                            <td width="17%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_LENGTHOFCOURSES");?></span></td>
                            <td width="15%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT3");?></span></td>
                            <td width="14%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_AFTERRESIZE");?></span></td>
                            </tr>
                        <?php
						$i = 1;
                        $color="#ECECFF";
                        						
                        $num=$dbf->countRows('common',"type='group group'");
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
						$res_re = $dbf->strRecordID("centre_group_size","*","group_id='$val[id]' And centre_id='$_SESSION[centre_id]'");
						if($res_re[effect_units] == "0")
						{
							$re = "Flex";
						}
						else
						{
							$re = $res_s[effect_units];
						}
                        ?>
                          <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                            <td height="30" align="center" valign="middle" class="contenttext">&nbsp;
                              <input type="hidden" name="gid<?php echo $i;?>" id="gid<?php echo $i;?>" value="<?php echo $val[id];?>" /></td>
                            <td height="25" align="left" valign="middle"  class="mycon" style="padding-left:5px;"><?php echo $val[name];?></td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                            <input name="size_from<?php echo $i;?>" type="text" class="new_textbox40" id="size_from<?php echo $i;?>" value="<?php echo $sf;?>" readonly="readonly"/>
                              
                                <input name="size_to<?php echo $i;?>" type="text" class="new_textbox40" id="size_to<?php echo $i;?>" value="<?php echo $st;?>" readonly="readonly"/>
                                </td>
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
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                            
                            <input name="week_id<?php echo $i;?>" type="text" class="new_textbox100" id="week_id<?php echo $i;?>" value="<?php echo $unit_no;?>" readonly="readonly" />
                                                         
                              </td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;">
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
                              </span></td>
                            <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                              <input name="units<?php echo $i;?>2" type="text" class="new_textbox40" id="units<?php echo $i;?>2" value="<?php echo $re;?>" readonly="readonly"/>
                            </td>
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
                      <tr>
                        <td width="90%" align="right" valign="middle"></td>
                        <td width="10%" height="35" align="left" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
                  	</form>
                  
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="8%" align="left"><a href="home.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="54%" height="30" align="right" valign="middle" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_VIEWGROUPSIZE");?>&nbsp;</td>
                
                </tr>
              </table></td>
            </tr>
          <tr>
            <td height="450" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="96%" height="30" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td align="right" class="nametext1"> : <?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_NOTE");?></td>
                    </tr>
                  <tr>
                    <td align="right" class="mytext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT");?></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td align="left" valign="middle">
                  
                  <form action="group_size_process.php" name="frm" method="post" id="frm">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" align="left" valign="middle">
                          <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
                            <tr class="leftmenu">
                              <td width="5%" height="25" align="center" valign="middle" bgcolor="#DDDDDD">&nbsp;</td>
                              <td width="24%" align="right" valign="middle" bgcolor="#DDDDDD" class="logintext" style="padding-right:25px;"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT1");?></td>
                              <td width="25%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT2");?></td>
                              <td width="17%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_LENGTHOFCOURSES");?></td>
                              <td width="15%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_TEXT3");?></td>
                              <td width="14%" align="center" valign="middle" bgcolor="#DDDDDD" class="logintext"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_AFTERRESIZE");?></td>
                              </tr>
                            <?php
						$i = 1;
                        $color="#ECECFF";
                        						
                        $num=$dbf->countRows('common',"type='group group'");
                        foreach($dbf->fetchOrder('common',"type='group group'","id") as $val) {
						
						//Get value from group size
						$res_s = $dbf->strRecordID("group_size","*","group_id='$val[id]'");
						
						if($res_s[size_from] == "0" && $res_s[size_from] == "0"){
							$sf = "Flex";
						}else{
							$sf = $res_s[size_from];
						}
						if($res_s[size_from] == "0" && $res_s[size_from] == "0"){
							$st = "Flex";
						}else{
							$st = $res_s[size_to];
						}
						
						//Get value from group size after re-sizing with centre ID
						$res_re = $dbf->strRecordID("centre_group_size","*","group_id='$val[id]' And centre_id='$_SESSION[centre_id]'");
						if($res_re[effect_units] == "0"){
							$re = "Flex";
						}else{
							$re = $res_s[effect_units];
						}
                        ?>
                            <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                              <td height="30" align="center" valign="middle" class="contenttext">&nbsp;
                                <input type="hidden" name="gid<?php echo $i;?>" id="gid<?php echo $i;?>" value="<?php echo $val[id];?>" /></td>
                              <td height="25" align="right" valign="middle"  class="mycon" style="padding-left:5px;"><?php echo $val[name];?></td>
                              <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                                <input name="size_from<?php echo $i;?>" type="text" class="new_textbox40" id="size_from<?php echo $i;?>" value="<?php echo $sf;?>" readonly="readonly"/>
                                
                                <input name="size_to<?php echo $i;?>" type="text" class="new_textbox40" id="size_to<?php echo $i;?>" value="<?php echo $st;?>" readonly="readonly"/>
                                </td>
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
                              <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                                
                                <input name="week_id<?php echo $i;?>" type="text" class="new_textbox100_ar" id="week_id<?php echo $i;?>" value="<?php echo $unit_no;?>" readonly="readonly" />
                                
                                </td>
                              <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;">
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
                                </span></td>
                              <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                                <input name="units<?php echo $i;?>2" type="text" class="new_textbox40" id="units<?php echo $i;?>2" value="<?php echo $re;?>" readonly="readonly"/>
                                </td>
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
                      <tr>
                        <td width="90%" align="right" valign="middle"></td>
                        <td width="10%" height="35" align="left" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
                    </form>
                  
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
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
