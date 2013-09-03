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
    <td height="30" align="right" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#e6e6e6" class="leftmenuborder">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <?php
	foreach($dbf->fetchOrder('quick_links',"module_name='Teacher' And user_id='$_SESSION[id]'","prec") as $val_quick)
	{
	//echo $val_quick[link_name];
	//echo '<br>';
		if($val_quick[links] == $filename){$class = 'myactivemenutext';}else{$class = 'mymenutext';}
		if($val_quick[links] == $filename){$img = "../images/arrow_small_right2.png";}else{$img = "../images/arrow_small_right4.png";}
		if($val_quick[link_name]=="Home") { $linkname = constant("ADMIN_MENU_HOME");} 
		else if($val_quick[link_name]=="My Group") { $linkname = constant("TE_MENU_MY_GROUP");} 
		else if($val_quick[link_name]=="My Schedules") { $linkname = constant("TE_MENU_MY_SCHEDULE");} 
		else if($val_quick[link_name]=="ePEDCARD") { $linkname = constant("TE_MENU_EPEDCARD");} 
		else if($val_quick[link_name]=="Progress Reports") { $linkname = constant("TE_MENU_PR");} 
		else if($val_quick[link_name]=="Certificate Reports") { $linkname = constant("TE_MENU_CR");} 
		else if($val_quick[link_name]=="ARF") { $linkname = constant("RE_MENU_ARF");} 
		else if($val_quick[link_name]=="Date Converter") { $linkname = constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");} 
		else if($val_quick[link_name]=="Language Converter") { $linkname = constant("STUDENT_TRANSLATE_LANGUAGE_CONVERTER");} 
		else if($val_quick[link_name]=="Help") { $linkname = constant("RE_MENU_HELP");} 
		else if($val_quick[link_name]=="Alerts") { $linkname = constant("ADMIN_MENU_ALERTS");} 
		else if($val_quick[link_name]=="Teacher(s) Schedule") { $linkname = constant("ADMIN_MENU_REPORTS_SCHEDULE");} 
		else if($val_quick[link_name]=="Groups To Finsh") { $linkname = constant("TEACHER_MENU_GRPFINISH");} 
		else if($val_quick[link_name]=="Absent Report") { $linkname = constant("ADMIN_MENU_REPORTS_ABSENT");} 
		else if($val_quick[link_name]=="Sick Leave") { $linkname = constant("TE_MENU_SL");} 
		else { $linkname = $val_quick[link_name]; }
		
		
	?>
      <tr>
        <td style="border-left:solid 2px; border-color:#CCC;">&nbsp;</td>
        <td width="248" align="right" valign="middle" class="<?php echo $class;?>"><a style="text-decoration:none;" href="<?php echo $val_quick[links];?>">
		<?php echo $linkname;?></a></td>
        <td width="32" height="30" align="center" valign="middle"><a href="<?php echo $val_quick[links];?>"><img src="<?php echo $img;?>" width="16" height="16" border="0" /></a></td>
      </tr>
      <tr>
        <td height="1" colspan="3" bgcolor="#cccccc"></td>
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
