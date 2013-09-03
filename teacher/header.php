<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$qry = $_SERVER['QUERY_STRING'];
if($qry != '') { $page = $parts[count($parts) - 1].'?'.$qry; }else{ $page = $parts[count($parts) - 1];}
$page = base64_encode($page);
$page_name = $parts[count($parts) - 1];
?>
<script type='text/javascript' src='../js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$("#testinput").autocomplete("autosuggest_tech.php", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="right" valign="top" background="images/title.png" >
    <form action="auto_search.php" method="post" name="search_frm" id="search_frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="41%" align="right" id="DisplayInfo"></td>
        <td width="2%">&nbsp;</td>
        <td width="47%" align="right" valign="middle" style="padding-left:250px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="43%" align="right" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="left" style="display:'';">
              <tr>
                <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_BIGGER");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_RESET");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_SMALLER");?></b></a></td>
              </tr>
            </table></td>
            <td width="57%" align="right" valign="middle"><div id="suggest" style="width:300px;"> <span class="leftmenu"><?php echo constant("RE_MENU_SEARCH");?></span>:
              <input name="testinput" type="text" class="searchtext" id="testinput" onblur="fill(this.value);" onkeyup="suggest(this.value);" autocomplete="off" value="<?php echo $_REQUEST[testinput];?>" />
              <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="arrow.png" style="position: relative; right:10px;" alt="upArrow" />
                <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
              </div>
            </div></td>
          </tr>
        </table></td>
        <td width="2%" align="left" valign="middle"><input type="image"src="images/search.png" alt="add_btn" width="30" height="27" title="Search"/></td>
        <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
        <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul>
        
        <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "my_groups.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="my_groups.php" title="Rule / Regulation"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_MY_GROUP");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "my_schedules.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="my_schedules.php" title=""><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_MY_SCHEDULE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "ped.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="ped.php" title=""><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_EPEDCARD");?></span></a></li>        
        
        <?php
	  $mystyle = '';
	  if($page_name == "report_teacher_progress.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="report_teacher_progress.php" title="Progress Reports"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PR");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "report_center_director.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="report_center_director.php" title="Certificate Reports"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_CR");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "arf_manage.php" || $page_name == "arf_add.php" || $page_name == "arf_edit.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="arf_manage.php" title="Action Request Forms"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_ARF");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "manage_sick_leave.php" || $page_name=="sick_leave.php" )
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="manage_sick_leave.php" title="Sick Leave" ><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_SL");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Date Convertor" rel="conv"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
        
        
        <?php
	  $mystyle = '';
	  if($page_name == "alert.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="alert.php" title="Alert"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
		
        <?php
	  $mystyle = '';
	  if($page_name == "report_absent_report.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="report_absent_report.php" title="Abasent Report"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></span></a></li>
        
      
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="" rel="pre"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PRE");?></span></a></li>
        <?php
	  $mystyle = '';
	  if($page_name == "help.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="" rel="help"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_HELP");?></span></a></li>
        </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />
         <div id="conv" class="dropmenudiv_d">
        	<a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
            <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
        </div>
        
		 <!--link  down menu -->
		<div id="mnu_rel" class="dropmenudiv_d">
		<?php
		foreach($dbf->fetchOrder('links',"teacher='1'","id") as $val) {
		?>
			<a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
		<?php } ?>
		</div>
		
        <!-- Report drop down menu -->                                                   
		<div id="rpt_report" class="dropmenudiv_d">
			<a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
			<a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
			<a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>		
		</div>
		
		<div id="pre" class="dropmenudiv_d"> 
            <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
            <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        </div>
		
        <div id="help" class="dropmenudiv_d">
		<?php
        foreach($dbf->fetchOrder('help',"teacher='1'","id") as $val) {
        ?>
            <a href="help.php?id=<?php echo $val[id]; ?>"><?php echo $val["title"];?></a>
        <?php } ?>
      </div>
      <script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
