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
function isNumberKey(evt){
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
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_MANAGE_GROUP_SIZE");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"></td>
                <td width="8%" align="left"><a href="group_size_add.php">
                <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="96%" height="30" align="left" valign="bottom">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td class="nametext1"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_NOTE");?></td>
                    </tr>
                  <tr>
                    <td style="text-align:justify;" class="mytext"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_TEXT");?></td>
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
                          <tr class="pedtext">
                            <td width="4%" height="25" align="center" valign="middle" bgcolor="#DDDBE8">&nbsp;</td>
                            <td width="21%" align="left" valign="middle" bgcolor="#DDDBE8"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_GROUPTYPE");?></td>
                            <td width="30%" align="center" valign="middle" bgcolor="#DDDBE8"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_SIZEOFGROUP");?></td>
                            <td width="20%" align="center" valign="middle" bgcolor="#DDDBE8"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LENGTHCOURSE");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#DDDBE8"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_UNITS");?></td>
                            <td width="5%" align="left" valign="middle" bgcolor="#DDDBE8">&nbsp;</td>
                            <td width="4%" align="left" valign="middle" bgcolor="#DDDBE8">&nbsp;</td>
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
                        ?>
                          <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='group_size_edit.php?ids=<?php echo $val[id];?>'" style="cursor:pointer;">
                            <td height="30" align="center" valign="middle" class="contenttext">&nbsp;
                              <input type="hidden" name="gid<?php echo $i;?>" id="gid<?php echo $i;?>" value="<?php echo $val[id];?>" /></td>
                            <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[name];?></td>
                            <td align="center" valign="middle" class="contenttext" style="padding-left:5px;">
                            <input name="size_from<?php echo $i;?>" type="text" class="new_textbox40" id="size_from<?php echo $i;?>" value="<?php echo $sf;?>" onkeypress="return isNumberKey(event);" maxlength="3" /> <!--onblur="show_error(<?php //echo $i;?>),show_save(<?php //cho $i;?>);"-->
                              
                                <input name="size_to<?php echo $i;?>" type="text" class="new_textbox40" id="size_to<?php echo $i;?>" value="<?php echo $st;?>"  onkeypress="return isNumberKey(event);"  maxlength="3"/>
                                </td>
                                <?php
								if($res_s[units] != "0"){
									$unit_no = ($res_s[units] / 10)." weeks";
								}else{
									$unit_no = "Flex";
								}
								?>
                            <td align="center" valign="middle" class="contenttext" style="padding-left:5px;">                            
                          <input name="week_id<?php echo $i;?>" type="text" class="new_textbox12" id="week_id<?php echo $i;?>" value="<?php echo $unit_no;?>" readonly="readonly" />
                                       
                              </td>
                            <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><span class="contenttext" style="padding-left:5px;">
                            <?php
							if($res_s[units] == "0"){
								$u = "Flex";
							}else{
								$u = $res_s[units];
							}
							?>
                              <input name="units<?php echo $i;?>" type="text" class="new_textbox40" id="units<?php echo $i;?>" value="<?php echo $u;?>" onkeypress="return isNumberKey(event);" maxlength="3" />
                              </span></td>
                            <td align="center" valign="middle" class="contenttext">
                            <a href="group_size_edit.php?ids=<?php echo $val[id];?>">
                            <?php
							//Check in student_group table whether id is used or not
							$num_group=$dbf->countRows('student_group',"group_id='$val[id]'");
							if($num_group == 0) {
                            ?>
                            <img src="../images/edit.gif" width="16" height="16" border="0" />
                            <?php
							}
							?>
                            </a></td>
                            <td align="center" valign="middle" class="contenttext">
                            <a href="group_size_process.php?ids=<?php echo $val[id];?>&action=del">
                            <?php
							//Check in student_group table whether id is used or not
							$num_group=$dbf->countRows('student_group',"group_id='$val[id]'");
							if($num_group == 0) {
                            ?>
                            <img src="../images/delete.png" width="16" height="16" border="0" />
                            <?php
							}
							?>
                            </a></td>
                            <?php
							  $i = $i + 1;							  
							  if($color=="#ECECFF"){
								  $color = "#FBFAFA";
							  }else{
								  $color="#ECECFF";
							  }				  
                          }
                          ?>
                          <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>" />
                            </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td width="90%" align="right" valign="middle">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="6%" id="showsave"><input type="hidden" name="lblsave" id="lblsave" value="0"></td>
                              <td width="80%" align="left" valign="middle" id="lblshow">&nbsp;</td>
                              <td width="15%" align="right" valign="middle">
                              
                              </td>
                            </tr>
                          </table></td>
                        <td width="10%" height="35" align="left" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
                  	</form>
                  
                  </td>
              </tr>
              <tr style="display:none;">
                <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td width="90%" class="nametext1"><?php echo constant("STUDENT_ADVISOR_VIEW_GROUPSIZE_NOTE");?> :</td>
                    <td width="10%" height="35" align="left" valign="middle" class="nametext1">&nbsp;</td>
                    </tr>
                  <tr>
                    <td style="text-align:justify;"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_TEXT1");?></td>
                    <td style="text-align:justify;">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <tr style="display:none;">
                <td align="left" valign="middle">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
                  <tr class="leftmenu">
                    <td width="5%" height="25" align="center" valign="middle" bgcolor="#F4F4F4" >&nbsp;</td>
                    <td width="8%" align="center" valign="middle" bgcolor="#F4F4F4" class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_CLASSSIZE");?></td>
                    <td width="12%" align="center" valign="middle" bgcolor="#F4F4F4" class="leftmenu" ><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_STDINCLASS");?></td>
                    <td width="75%" align="center" valign="middle" bgcolor="#666666" >
                    
                    <table width="100%" border="0" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td height="30" colspan="9" align="center" valign="middle" bgcolor="#F4F4F4" class="leftmenu" style="border-bottom:solid 1px; border-color:#999999;"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_EACHLEVEL");?></td>
                        </tr>
                      <tr>
                        <td width="10%" height="30" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_BERENG");?></span><span class="whitetext_12"><br /> 
                          <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_TEXT3");?></span></td>
                        <td width="11%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_FOUNDENG");?></span> <span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_PHONICS");?></span></td>
                        <td width="10%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_TIMEZONE");?></span> <span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LEVELAGE");?></span></td>
                        <td width="10%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_ENGLISHBEAT");?></span> <span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LEVELAGE1");?></span></td>
                        <td width="12%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_ENGLISHBEATSTART");?></span><span class="logintext"><br />
                        </span> <span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_AGE8");?></span></td>
                        <td width="13%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_KIDSENGLISH");?></span><br /><span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LEVELAGE2");?></span></td>
                        <td width="13%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_KIDSENGLISH1");?></span><span class="whitetext_12"><br />
                          <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_LEVELAGE3");?></span></td>
                        <td width="11%" align="center" valign="middle" bgcolor="#F4F4F4" style="border-right:solid 1px; border-color:#999999;"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_TOFEL");?></span> <span class="whitetext_12"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_PREP");?></span></td>
                        <td width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><span class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_IELTS");?></span> <span class="whitetext_12"><br />
                          <?php echo constant("ADMIN_GROUP_SIZE_MANAGE_PREP");?></span></td>
                        </tr>
                      </table></td>
                    </tr>
                  <?php					
					$i = 1;
					$num=$dbf->countRows('common',"type='group group'");
					foreach($dbf->fetchOrder('common',"type='group group'","id") as $val) {
					
						//Get Course for particular Group
						$strcourse = '';
						foreach($dbf->fetchOrder('group_list',"commonid='$val[id]'","") as $valcourse)
						{
							$str = $dbf->strRecordID("course","*","id='$valcourse[course_id]'");
							if($strcourse == '')
							{							
								$strcourse = $str["name"];
							}
							else
							{
								$strcourse = $strcourse.' , '.$str["name"];
							}
						}
						
						//Get Unit of the Group
						$unit1 = $dbf->strRecordID("group_size","*","group_id='$val[id]'");
						
						if($unit1[units] == '0')
						{
							$u = '';
						}
						else
						{
							$u = $unit1[units];
						}
						
						//Get student
						if($unit1[size_from] == $unit1[total_size])
						{
							$s = $unit1[total_size];
						}
						else
						{
							$s = $unit1[size_from] ."-". $unit1[size_to];
						}
						if($s == '0')
						{
							$s = '';
						}
						
					?>
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="30" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[name];?></td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $s;?></td>
                    <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" >
                    <table width="100%" border="0" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="10%" height="30" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;"><?php echo $u;?></td>
                        <td width="11%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="12%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="13%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="13%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="11%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle">&nbsp;</td>
                      </tr>
                    </table></td>
                    <?php
					  $i = $i + 1;
					  }
					  ?>
                    </tr>
                  <?php
					if($num==0)
					{
					?>
                  <?php
					}
					?>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#999999">
                  <tr class="leftmenu">
                    <td height="25" colspan="3" align="center" valign="middle" bgcolor="#F4F4F4" >&nbsp;</td>
                    <td width="75%" align="center" valign="middle" bgcolor="#666666" >
                      
                      <table width="100%" border="0" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td width="100%" height="30" colspan="9" align="center" valign="middle" bgcolor="#F4F4F4" class="leftmenu"><?php echo constant("ADMIN_GROUP_SIZE_MANAGE_STDCOURSELEN");?></td>
                          </tr>
                      </table></td>
                    </tr>
                  <?php					
					$i = 1;
					$num=$dbf->countRows('common',"type='group group'");
					foreach($dbf->fetchOrder('common',"type='group group'","id") as $val) {
					
						//Get Course for particular Group
						$strcourse = '';
						foreach($dbf->fetchOrder('group_list',"commonid='$val[id]'","") as $valcourse)
						{
							$str = $dbf->strRecordID("course","*","id='$valcourse[course_id]'");
							if($strcourse == '')
							{							
								$strcourse = $str["name"];
							}
							else
							{
								$strcourse = $strcourse.' , '.$str["name"];
							}
						}
						
						//Get Unit of the Group
						$unit1 = $dbf->strRecordID("group_size","*","group_id='$val[id]'");
						
						if($unit1[units] == '0')
						{
							$u = '';
						}
						else
						{
							$u = $unit1[units]/10;
						}
						
						//Get student
						if($unit1[size_from] == $unit1[total_size])
						{
							$s = $unit1[total_size];
						}
						else
						{
							$s = $unit1[size_from] ."-". $unit1[size_to];
						}
						if($s == '0')
						{
							$s = '';
						}
					?>
                  <tr>
                    <td width="5%" height="30" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td width="8%" height="30" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[name];?></td>
                    <td width="12%" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $s;?></td>
                    <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" >
                    <table width="100%" border="0" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="10%" height="30" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;"><?php echo $u;?></td>
                        <td width="11%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="12%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="13%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="13%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="11%" align="center" valign="middle" style="border-right:solid 1px; border-color:#999999;">&nbsp;</td>
                        <td width="10%" align="center" valign="middle">&nbsp;</td>
                      </tr>
                    </table></td>
                    <?php
					  $i = $i + 1;
					  }
					  ?>
                    </tr>
                  <?php
					if($num==0)
					{
					?>
                  <?php
					}
					?>
                </table>
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
