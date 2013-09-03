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
	$("#testinput").autocomplete("autosuggest_tech.php?centre_id=<?php echo $_SESSION['centre_id'];?>", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
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
        <td width="2%" align="left" valign="middle"><input type="image" src="images/search.png" alt="add_btn" width="30" height="27" title="Search"/></td>
        <td width="3%" align="center" valign="middle"><a href="lang_change.php?lang=AR&page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
        <td width="5%" align="left" valign="middle"><a href="lang_change.php?lang=EN&page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
      </tr>
    </table>
    </form></td>
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
        <li><a <?php echo $mystyle;?> href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
                
      
         <?php
	  $mystyle = '';
	  if($page_name == "search.php" || $page_name == "view_student_comments_history_from_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="search.php" title="Search"><span <?php echo $mystyle;?>><?php echo constant("MENU_STUDENT_SERVICES");?></span></a></li>
                 
          <?php
		$mystyle = '';
		  if($page_name == "certificate.php" || $page_name == "certificate_multi.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>" rel="certi_multi"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "ped.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="ped.php" title="ePEDCARD" rel=""><span <?php echo $mystyle;?>><?php echo constant("TE_MENU_EPEDCARD");?></span></a></li>
        
        
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
		  if($page_name == "vacation_center_manage.php" || $page_name == "vacation_teacher_manage.php" || $page_name == "vacation_exam_manage.php" || $page_name=="vacation_student_manage.php" || $page_name=="sick_leave_manage.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_VAC_LEAVE");?>" rel="vacation"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_VAC_LEAVE");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page_name == "calc_converter.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Converter" rel="conv"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        

        
         <?php
		$mystyle = '';
		  if($page_name == "alert1_manage.php" || $page_name == "alert1_add.php" || $page_name == "alert1_edit.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
		<li><a <?php echo $mystyle;?> href="alert1_manage.php" title="<?php echo constant("ADMIN_MENU_ALERTS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        
        <?php
		$mystyle = '';
		  if($page_name == "news_manage.php" || $page_name == "news_add.php" || $page_name == "news_edit.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="news_manage.php" title="<?php echo constant("ADMIN_MENU_NEWS");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_NEWS");?></span></a></li>		 
        
         <?php
	  $mystyle = '';
	  if($page_name == "home.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
                          
		 <?php
	  $mystyle = '';
	  if($page_name == "password.php" || $page_name=="quicklink_manage.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>        
        <li><a <?php echo $mystyle;?> href="#" title="preferences" rel="prefer"><span <?php echo $mystyle;?>><?php echo constant("TE_MENU_PRE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "report_unit_taught.php" || $page_name=="report_eped_status.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?> 
        <li><a <?php echo $mystyle;?> href="#" title="" rel="mnu_reports"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
      <?php
	  $mystyle = '';
	  if($page_name == "help.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Help" rel="help"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_HELP");?></span></a></li>
        
      </ul>
    </div>
    <br style="clear: left;" />
    <br class="IEonlybr" />
	
    <div id="vacation" class="dropmenudiv_d">
        <a href="vacation_teacher_manage.php"><?php echo constant("ADMIN_MENU_VAC_TEACHER");?></a>
        <a href="sick_leave_manage.php"><?php echo constant("CD_MENU_MANAGE_SICK_LEAVE");?></a>
        </div>
    
    <div id="conv" class="dropmenudiv_d">
        <a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
        <!--<a href="translate.php"><?php //echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a>--> 
    </div>
     
     <div id="mnu_reports" class="dropmenudiv_d">
        <a href="report_unit_taught.php"><?php echo constant("LIS_UNITS_TAUGHT");?></a> 
		<a href="report_eped_status.php"><?php echo constant("LIS_EPED_STATUS");?></a>        
     </div>
     
     <!--Links drop down menu -->
    <div id="mnu_rel" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('links',"stu_ad='1'","id") as $val) {
    ?>
        <a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
    <?php } ?>
    </div>
	
    <div id="certi_multi" class="dropmenudiv_d">
    <a href="certificate.php"><?php echo constant("SINGLE_CERTIFICATE");?></a> 
    <a href="certificate_multi.php"><?php echo constant("MULTIPLE_CERTIFICATE");?></a>
    </div>
    
	<!--preference drop down menu -->
   <div id="prefer" class="dropmenudiv_d">
        <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
   </div>
   
    <div id="help" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('help',"lis='1'","id") as $val) {
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
