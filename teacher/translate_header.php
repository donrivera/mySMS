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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="center">
  <tr>
    <td height="46" align="right" valign="top" background="images/title.png" >
    
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
	  if($page_name == "calc_converter.php" || $page_name == "translate.php")
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
		
        
      <script type="text/javascript">
		//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
		tabdropdown.init("glowmenu", "auto")
		</script>
    </td>
  </tr>
</table>
