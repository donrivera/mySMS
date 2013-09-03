<?php
ob_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$filename = $parts[count($parts) - 1];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" align="left" valign="middle" bgcolor="#FFA938" class="centercolumntext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#e6e6e6" class="leftmenuborder">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <?php
	foreach($dbf->fetchOrder('quick_links',"module_name='Accountant' And user_id='$_SESSION[id]'","prec") as $val_quick)
	{
		if($val_quick[links] == $filename){$class = 'myactivemenutext';}else{$class = 'mymenutext';}
		if($val_quick[links] == $filename){$img = "../images/arrow_small_right.png";}else{$img = "../images/arrow_small_right1.png";}
		if($val_quick[link_name]=="Home") { $linkname = constant("ADMIN_MENU_HOME");} 
		else if($val_quick[link_name]=="Students") { $linkname = constant("ADMIN_MENU_STUDENT");} 
		else if($val_quick[link_name]=="Search") { $linkname = constant("RE_MENU_SEARCH");} 
		else if($val_quick[link_name]=="Groups") { $linkname = constant("RE_MENU_GROUPS");} 
		else if($val_quick[link_name]=="Teacher Board") { $linkname = constant("ADMIN_MENU_REPORTS_BOARD");} 
		else if($val_quick[link_name]=="Teacher(s) Schedule") { $linkname = constant("ADMIN_MENU_REPORTS_SCHEDULE");} 
		else if($val_quick[link_name]=="Student Awatng A Course") { $linkname = constant("ADMIN_MENU_HOME");} 
		else if($val_quick[link_name]=="Groups To Fnish") { $linkname = constant("TEACHER_MENU_GRPFINISH");} 
		else if($val_quick[link_name]=="Certificate not Collected") { $linkname = constant("ADMIN_MENU_REPORTS_COLLECT");} 
		else if($val_quick[link_name]=="Absent Report") { $linkname = constant("ADMIN_MENU_REPORTS_ABSENT");} 
		else if($val_quick[link_name]=="Date Converter") { $linkname = constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");} 
		else if($val_quick[link_name]=="Language Converter") { $linkname = constant("STUDENT_TRANSLATE_LANGUAGE_CONVERTER");} 
		else if($val_quick[link_name]=="Help") { $linkname = constant("RE_MENU_HELP");} 
		else if($val_quick[link_name]=="Alerts") { $linkname = constant("ADMIN_MENU_ALERTS");} 
		else if($val_quick[link_name]=="SMS") { $linkname = constant("ADMIN_MENU_SMS");} 
		else if($val_quick[link_name]=="E-Mail") { $linkname = constant("ADMIN_MENU_EMAIL");} 
		else if($val_quick[link_name]=="Centre Schedule") { $linkname = constant("RE_MENU_CS");} 
		else { $linkname = $val_quick[link_name]; }
	?>
      <tr>
        <td width="5">&nbsp;</td>
        <td width="25" align="center" valign="middle"><a href="<?php echo $val_quick[links];?>"><img src="<?php echo $img;?>" width="16" height="16" border="0" /></a></td>
        <td height="30" align="left" valign="middle" style="border-right:solid 2px; border-color:#CCC;" class="<?php echo $class;?>"><a style="text-decoration:none;" href="<?php echo $val_quick[links];?>"><?php echo $linkname;?></a></td>
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
