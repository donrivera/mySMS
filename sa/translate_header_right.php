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
<script>
function suggest(inputString){
	
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		$('#testinput').addClass('load');
			$.post("autosuggest_tech.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#testinput').removeClass('load');
				}
			});
		}
	}

	function fill(thisValue) {
		$('#testinput').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 600);
		
		if(document.getElementById('testinput').value != document.getElementById('tid').value){
			document.getElementById('tid').value = thisValue;			
		}
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" >
    <form action="auto_search.php" method="post" name="search_frm" id="search_frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="41%" align="left" id="DisplayInfo"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30" align="center" valign="middle"><a href="lang_change.php?lang=EN&amp;page=<?php echo $page;?>"><img src="../images/english.png" alt="English" width="24" height="24" border="0" title="English" /></a></td>
            <td width="24" align="center" valign="middle"><a href="lang_change.php?lang=AR&amp;page=<?php echo $page;?>"><img src="../images/favicon.ico" alt="Arabic" width="24" height="18" border="0" title="Arabic"/></a></td>
            <td width="30" align="center" valign="middle"><input type="image" src="images/search.png" alt="add_btn" width="30" height="27" title="Search"/></td>
            <td width="10" align="left" valign="middle">&nbsp;</td>
            <td width="150" align="left" valign="middle">
            <div id="suggest" style="width:300px;"><input name="testinput" type="text" class="searchtext" id="testinput" onblur="fill(this.value);" onkeyup="suggest(this.value);" autocomplete="off" value="<?php echo $_REQUEST[testinput];?>" />&nbsp; : <span class="leftmenu"><?php echo constant("RE_MENU_SEARCH");?></span>
              <div style="position: absolute;left:1px;top:0px;margin: 26px 0px 0px 0px;width: 230px;padding:0px;background-color:#C8C8C8;border-top: 3px solid #C8C8C8;color: #fff;
	text-align:left;display:none;" id="suggestions">
                <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
              </div>
            </div>  
            </td>
            <td width="60" align="left" valign="middle">
              
              </td>
            <td width="5" align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle"><table width="150" border="0" cellspacing="0" cellpadding="0" align="left" style="display:'';">
              <tr>
                <td align="center" valign="middle"><a href="font_change.php?font=big&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_BIGGER");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=reset&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_RESET");?></b></a></td>
                <td align="center" valign="middle"><a href="font_change.php?font=small&amp;page=<?php echo $page;?>"><b><?php echo constant("COMMON_HEADER_SMALLER");?></b></a></td>
              </tr>
            </table></td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
            </tr>
        </table></td>
        </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="right" valign="top" background="images/title.png" ><div id="glowmenu" class="glowingtabs">
      <ul style="float:right;">
        <li><a href="home.php" title="<?php echo constant("ADMIN_MENU_HOME");?>"><span><?php echo constant("ADMIN_MENU_HOME");?></span></a></li>
                 
        <li><a href="student_manage.php" title="Quick Add" rel=""><span <?php echo $mystyle;?>><?php echo constant("SA_MENU_QUICKADD");?></span></a></li>
        <?php
	  $mystyle = '';
	  if($page == "s1.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Students" rel="rpt_student"><span <?php echo $mystyle;?> ><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <li><a href="search.php" title="Search"><span><?php echo constant("RE_MENU_SEARCH");?></span></a></li>
        <li><a href="#" title="Groups" rel="rel_group"><span><?php echo constant("RE_MENU_GROUPS");?></span></a></li>
        <li><a href="#" title="Reports" rel="rpt_report"><span><?php echo constant("ADMIN_MENU_REPORTS");?></span></a></li>
        
         <?php
	  $mystyle = '';
	  if($page == "translate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Converter" rel="conv"><span <?php echo $mystyle;?>><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
        
        <li><a href="#" title="Help"><span><?php echo constant("RE_MENU_HELP");?></span></a></li>
        <li><a href="alert.php" title="Alerts"><span><?php echo constant("ADMIN_MENU_ALERTS");?></span></a></li>
        <li><a href="sms.php" title="SMS"><span><?php echo constant("ADMIN_MENU_SMS");?></span></a></li>
		<li><a href="email.php" title="email"><span><?php echo constant("ADMIN_MENU_EMAIL");?></span></a></li>
        <li><a href="centre_schedule.php" title="Centre Schedule"><span><?php echo constant("RE_MENU_CS");?></span></a></li>
        <li><a href="ped.php" title="ePEDCARD" rel=""><span><?php echo constant("TE_MENU_EPEDCARD");?></span></a></li>
        <li><a <?php echo $mystyle;?> href="report_teacher_progress.php" title="Progress Reports"><span <?php echo $mystyle;?> ><?php echo constant("TE_MENU_PR");?></span></a></li>
        <li><a href="#" title="Links" rel="mnu_rel"><span><?php echo constant("ADMIN_MENU_LINKS");?></span></a></li>
        <li><a href="certificate.php" title="<?php echo constant("ADMIN_MENU_CERTIFICATE");?>"><span><?php echo constant("ADMIN_MENU_CERTIFICATE");?></span></a></li>
        <li><a href="#" title="preferences" rel="prefer"><span><?php echo constant("TE_MENU_PRE");?></span></a></li>        
      </ul>
    </div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="43%" align="right" valign="middle">&nbsp;</td>
          <td width="57%" align="right" valign="middle"></td>
        </tr>
      </table>
      <br style="clear: left;" />
    <br class="IEonlybr" />
	
    <div id="lbl_progress_rpt" class="dropmenudiv_d">
    	<a href="report_group_progress.php"><?php echo constant("SINGLE_GROUP");?></a> 
        <a href="report_teacher_progress.php"><?php echo constant("STUDENT_WISE");?></a>  
    </div>
    <div id="conv" class="dropmenudiv_d">
        <a href="calc_converter.php"><?php echo constant("STUDENT_CALC_CONVERTER_DATA_CONVERTER");?></a> 
        <a href="translate.php"><?php echo constant("ADMIN_MENU_LANGUAGE_CONVERTER");?></a> 
    </div>
      
      <div id="certi_multi" class="dropmenudiv_d">
        <a href="certificate.php"><?php echo constant("SINGLE_CERTIFICATE");?></a> 
		<a href="certificate_multi.php"><?php echo constant("MULTIPLE_CERTIFICATE");?></a>
        </div>
      
	<!--RSeport drop down menu -->                                                   
	<div id="rpt_report" class="dropmenudiv_d">
        <a href="report_teacher_board.php"><?php echo constant("ADMIN_MENU_REPORTS_BOARD");?></a>
        <a href="report_teacher_schedule.php"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></a>
        <a href="report_student_awaiting.php"><?php echo constant("ADMIN_MENU_REPORTS_AWAIT");?></a>
        <a href="report_group_to_finish.php"><?php echo constant("ADMIN_MENU_REPORTS_FINISH");?></a>
        <a href="report_certificate_not_collect.php"><?php echo constant("ADMIN_MENU_REPORTS_COLLECT");?></a>
        <a href="report_absent_report.php"><?php echo constant("ADMIN_MENU_REPORTS_ABSENT");?></a>
        <a href="report_teacher_leave_report.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?></a>
        <a href="report_teacher_capacity.php"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_CAPACITY");?></a>
        <a href="report_certificate_report.php"><?php echo constant("ADMIN_MENU_REPORTS_SUMMARY");?></a>
        <a href="report_freq_customer_report.php"><?php echo constant("ADMIN_MENU_REPORTS_CUSTOMER");?></a>
        <a href="report_student_group_grade.php"><?php echo constant("ADMIN_MENU_REPORTS_GROUP_GRADE");?></a>
        <a href="report_student_not_enrolled.php"><?php echo constant("ADMIN_MENU_REPORTS_NOT_ENROLLED");?></a>
        <a href="report_student_on_hold.php"><?php echo constant("ADMIN_MENU_REPORTS_ON_HOLD");?></a>
        <a href="view_student_comments_history.php"><?php echo constant("ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY");?></a>
        <a href="report_student_cycle.php"><?php echo constant("REPORT_STUDENT_LIFE_CYCLE");?></a>
	</div>
     
    <!-- grouping -->
    <div id="rel_group" class="dropmenudiv_d">
        <a href="group_course.php"><?php echo constant("SA_MENU_WIZARD_BASED");?></a>
        <a href="group_quick.php"><?php echo constant("QUICK_ADD_GROUP");?></a>
        <a href="group_manage.php"><?php echo constant("SA_MENU_GROUP");?></a>        
        <a href="view_group_size.php"><?php echo constant("SA_MENU_GROUP_SIZE");?></a>
    </div>
    
    <!-- Transfer -->
    <div id="rel_transfer" class="dropmenudiv_d">
        <a href="student_to_student_manage.php"><?php echo constant("SA_STUDENT_TO_STUDENT");?></a>
        <!--<a href="student_to_center_manage.php"><?php //echo constant("SA_STUDENT_TO_CENTER");?></a>-->
        <a href="center_to_center_manage.php"><?php echo constant("SA_CENTER_CENTER");?></a>
    </div>
         
	<!--student drop down menu -->
    <div id="rpt_student" class="dropmenudiv_d"> 
        <a href="s_age.php"><?php echo constant("CD_MENU_WIZBASESTD");?></a>
        <a href="s_classic.php"><?php echo constant("SA_MENU_CLASSIC");?></a>
        <a href="student_appoint_manage.php"><?php echo constant("SA_MENU_APPOINT");?></a>
        <a href="arf_manage.php"><?php echo constant("ACTION_ARF_REPORT");?></a>
        <a href="cancel_manage.php"><?php echo constant("CANCELLATION_REQUEST");?></a>
        <a href="hold_manage.php"><?php echo constant("MANAGE_ONHOLD");?></a>
        <a href="single-student.php"><?php echo constant("STUDENT_INFORMATON");?></a>
	</div>
     <!--Links drop down menu -->
    <div id="mnu_rel" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('links',"stu_ad='1'","id") as $val) {    ?>
        <a href="http://<?php echo $val["links"];?>" target="_blank"><?php echo $val["title"];?></a>
    <?php } ?>
    </div>

	<!--preference drop down menu -->
   <div id="prefer" class="dropmenudiv_d">
        <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        <a href="user_manage.php"><?php echo constant("STUDENT_CREDENT");?></a>
   </div>
   
    <div id="help" class="dropmenudiv_d">
    <?php
    foreach($dbf->fetchOrder('help',"","id") as $val) {
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
