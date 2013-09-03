<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$filename = $parts[count($parts) - 1];

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" align="left" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
    <?php echo constant("ADMIN_MENU_QUICK_LINKS");?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#e6e6e6" class="leftmenuborder">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <?php
	foreach($dbf->fetchOrder('quick_links',"module_name='Student' And user_id='$_SESSION[id]'","prec") as $val_quick)
	{
		if($val_quick[links] == $filename){	$class = 'myactivemenutext';} else { $class = 'mymenutext';}
		if($val_quick[links] == $filename){$img = "../images/arrow_small_right.png";}else{$img = "../images/arrow_small_right1.png";}
		if($val_quick[link_name]=="Home"){ $linkname = constant("ADMIN_MENU_HOME");} 
		else if($val_quick[link_name]=="My Account"){ $linkname = constant("ADMIN_MENU_MY_ACCOUNT");}
		else if($val_quick[link_name]=="My Schedule"){ $linkname = constant("STUDENT_MENU_MY_SCHEDULE");}
		else if($val_quick[link_name]=="Progress/Certifcates Grade") { $linkname = constant("STUDENT_MENU_PROGCERTGRADE");}
		else if($val_quick[link_name]=="Teacher Leave Report") { $linkname = constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");}
		else if($val_quick[link_name]=="Language Converter") { $linkname = constant("ADMIN_MENU_LANGUAGE_CONVERTER");}
		else if($val_quick[link_name]=="Alerts") { $linkname = constant("ADMIN_MENU_ALERTS");}
		else { $linkname = $val_quick[link_name];}		
	?>
      <tr>
        <td width="5" >&nbsp;</td>
        <td width="25" align="center" valign="middle"><a href="<?php echo $val_quick[links];?>"><img src="<?php echo $img;?>" width="16" height="16" border="0" /></a></td>
        <td height="30" align="left" valign="middle" style="border-right:solid 2px; border-color:#CCC;" class="<?php echo $class;?>">
        <a style="text-decoration:none;" href="<?php echo $val_quick[links];?>">
		<?php 
		echo $linkname;
		?>
        </a></td>
      </tr>
      <tr>
        <td height="1" colspan="3" bgcolor="#ccc"></td>
        </tr>
    <?php } ?>      
    </table></td>
  </tr>
  <tr>
    <td height="200" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
