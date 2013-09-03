<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

$currentFile = $_SERVER["PHP_SELF"];
$parts = explode('/', $currentFile);
$qry = $_SERVER['QUERY_STRING'];
if($qry != '') { $page = $parts[count($parts) - 1].'?'.$qry; }else{ $page = $parts[count($parts) - 1];}
$page = base64_encode($page);
$page_name = $parts[count($parts) - 1];
//Object initialization
$dbf = new User();
?>
<script type='text/javascript' src='../js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$("#testinput").autocomplete("autosuggest_tech.php?centre_id=<?php echo $_SESSION['centre_id'];?>", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});
</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="left">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" >
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
    </form></td>
  </tr>
  <tr >
    <td height="50" align="left" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs" >
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
	  if($page_name == "student_appoint_manage.php" || $page_name=="student_appoint_add.php" || $page_name=="student_appoint_edit.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="student_appoint_manage.php" title=""><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_APP");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "search.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="search.php" title="Search"><span <?php echo $mystyle;?> ><?php echo constant("MENU_STUDENT_SERVICES");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "group_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="group_manage.php" title=""><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_GROUPS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "report_teacher_board.php" || $page_name == "report_teacher_schedule.php" || $page_name == "report_student_awaiting.php" || $page_name == "report_group_to_finish.php" || $page_name == "report_certificate_not_collect.php" || $page_name == "report_absent_report.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Reports" rel="rpt_report"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Date Convertor" ><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
         
        
         <?php
	  $mystyle = '';
	  if($page_name == "alert.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li ><a <?php echo $mystyle;?> href="alert.php" title="Alert"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "arf_manage.php" || $page_name=="arf_view.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="arf_manage.php" title="ARF"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_ARF");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "sms.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="sms.php" title="SMS"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "email.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="email.php" title="e-Mail"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "centre_schedule.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="centre_schedule.php" title=""><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CS");?></span></a></li>
        <li><a href="#" title="" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="" rel="prefer"><span <?php echo $mystyle;?> ><?php echo constant("STUDENT_MENU_PREFERENCES");?></span></a></li> 
        <?php
	  $mystyle = '';
	  if($page_name == "help.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="center" rel="help"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_HELP");?></span></a></li>      
      </ul>
    </div>
        <br style="clear: left;" />
        <br class="IEonlybr" />

	  <!--Links drop down menu -->
        <div id="mnu_rel" class="dropmenudiv_d">
		<?php
		foreach($dbf->fetchOrder('links',"rep='1'","id") as $val) {
		?>
			<a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
		<?php } ?>
		</div>
		<div id="conv" class="dropmenudiv_d">
        	<a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
            <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
        </div>
		
		<!-- Report drop down menu -->                                                   
		<div id="rpt_report" class="dropmenudiv_d">
			<a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a>
			<a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
			<a href="report_student_awaiting.php"><?php echo constant("ADMIN_MENU_REPORTS_AWAIT");?></a>
			<a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
			<a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a>
			<a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>			
		</div>		
     
	 	<!--preference drop down menu -->
        <div id="prefer" class="dropmenudiv_d"> 
        <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        </div>
        <div id="help" class="dropmenudiv_d">
		<?php
        foreach($dbf->fetchOrder('help',"rep='1'","id") as $val) {
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
