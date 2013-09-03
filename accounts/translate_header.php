<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

//Object initialization
$dbf = new User();
?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="topbg" align="left">
  <tr>
    <td height="46" align="left" valign="top" background="images/title.png" >
    </td>
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
		  if($page_name == "payment_manage.php" || $page_name =="challan_cond.php" || $page_name =="invoice_cond.php" || $page_name == "audit_history.php" || $_REQUEST['page'] == 'audit' || $page_name=="payment_history.php" || $page_name=="audit_history.php" || $page_name == "payment_history_edit.php" || $page_name == "move_to_beddebt.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="#" title="<?php echo constant("ADMIN_MENU_ACCOUNTS");?>" rel="accounts_dr"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_ACCOUNTS");?></span></a></li>
        
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
		  if($page_name == 'cancel_manage.php' || $page_name == 'cancel_status.php' || $page_name == "search.php" || $page_name == "view_student_comments_history_from_manage.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" title="<?php echo constant("ADMIN_MENU_STUDENT");?>" rel="mnu_enroll"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_STUDENT");?></span></a></li>
        <?php
		$mystyle = '';
		  if($page_name == "course_manage.php" || $page_name == "course_edit.php" || $page_name == "course_add.php")
		  {
			  $mystyle = 'style="background-color:#003399; background-image:none;"';
		  }
		  ?>
        <li><a <?php echo $mystyle;?> href="course_manage.php" title="<?php echo constant("ADMIN_MENU_COURSE");?>"><span <?php echo $mystyle;?>><?php echo constant("ADMIN_MENU_COURSE");?></span></a></li>
        
        <?php
	  $mystyle = '';
	  if($page_name == "student_to_student_manage.php" || $page_name == "student_to_student_add.php" || $page_name =="student_to_center_manage.php" || $page_name =="center_to_center_manage.php" || $page_name == "center_to_center_add.php"){
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="#" title="Groups" rel="rel_transfer"><span <?php echo $mystyle;?>><?php echo constant("SA_TRANSFER");?></span></a></li>
        
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
	  if($page_name == "calc_converter.php" || $page_name == "translate.php")
	  {
		  $mystyle = 'style="background-color:#003399; background-image:none;"';
	  }
	  ?>
        <li><a <?php echo $mystyle;?> href="calc_converter.php" title="Date Convertor" rel="conv" ><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_CONVERTER");?></span></a></li>
        
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
	  if($page_name == "report_transaction.php" || $page_name=="report_student_ledger.php" || $page_name == "report_student_ledger_search.php" || $page_name == "report_group_ledger.php" || $page_name=="report_discount.php" || $page_name == "report_center_to_center.php" || $page_name=="report_student_to_center.php" || $page_name == "report_enrolled.php" || $page_name=="report_sales_summary.php" || $page_name == "report_overdue.php" || $page_name == "report_baddebt.php" || $page_name == "report_credit_balance.php")
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
        <li><a <?php echo $mystyle;?> href="javascript:void(0);" rel="help"><span <?php echo $mystyle;?> ><?php echo constant("RE_MENU_HELP");?></span></a></li>
               
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
		
        <div id="mnu_reports" class="dropmenudiv_d">
        <a href="report_transaction.php"><?php echo constant("ACCOUNTANT_TRANS");?></a> 
		<a href="report_student_ledger_search.php"><?php echo constant("ACCOUNTANT_STUDENT_LEDGER");?></a>
        <a href="report_group_ledger.php"><?php echo constant("ACCOUNTANT_GROUP_LEDGER");?></a> 
		<a href="report_discount.php"><?php echo constant("ACCOUNTANT_DISCOUNTS");?></a>
        <a href="report_center_to_center.php"><?php echo constant("ACCOUNTANT_CE_CE");?></a>
        <a href="student_to_different_center_manage.php"><?php echo constant("SA_STUDENT_TO_CENTER");?></a>
		<a href="report_student_to_center.php"><?php echo constant("ACCOUNTANT_ST_CE");?></a>
        <a href="report_enrolled.php"><?php echo constant("ACCOUNTANT_EN_RE");?></a> 
		<a href="report_sales_summary.php"><?php echo constant("ACCOUNTANT_SUMMERY");?></a>
        <a href="report_overdue.php"><?php echo constant("ACCOUNTANT_OVERDUE");?></a> 
		<a href="report_baddebt.php"><?php echo constant("ACCOUNTANT_BADDEBT");?></a>
        <a href="report_credit_balance.php"><?php echo constant("ACCOUNTANT_CREDIT");?></a>
        </div>
        
        <!-- Transfer -->
        <div id="rel_transfer" class="dropmenudiv_d">
            <a href="student_to_student_manage.php"><?php echo constant("SA_STUDENT_TO_STUDENT");?></a>
            <!--<a href="student_to_center_manage.php"><?php //echo constant("SA_STUDENT_TO_CENTER");?></a>-->
            <a href="center_to_center_manage.php"><?php echo constant("SA_CENTER_CENTER");?></a>
        </div>
        
        <div id="mnu_enroll" class="dropmenudiv_d">
        <a href="search.php"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?></a> 
		<a href="cancel_manage.php"><?php echo constant("CANCELLATION_REQUEST");?></a>
        </div>
        
        <div id="certi_multi" class="dropmenudiv_d">
        <a href="certificate.php"><?php echo constant("SINGLE_CERTIFICATE");?></a> 
		<a href="certificate_multi.php"><?php echo constant("MULTIPLE_CERTIFICATE");?></a>
        </div>
        
        <div id="accounts_dr" class="dropmenudiv_d">
	  	<a href="payment_manage.php"><?php echo constant("ADMIN_MENU_TYPEOFPAYMENT");?></a>
		<a href="challan_cond.php"><?php echo constant("ADMIN_MENU_RECEIPT");?></a>
		<a href="invoice_cond.php"><?php echo constant("ADMIN_MENU_INVOICE");?></a>
        
        <a href="move_to_beddebt.php"><?php echo constant("AC_MOVETO_BED_DEBT");?></a>
		<a href="audit_history.php"><?php echo constant("STUDENT_AUDITDATA");?></a>
		<a href="payment_history.php"><?php echo constant("STUDENT_MYACCOUNT_PAYMENTHISTORY");?></a>
	  </div>
      
      <div id="vacation" class="dropmenudiv_d">
        <a href="vacation_teacher_manage.php"><?php echo constant("ADMIN_MENU_VAC_TEACHER");?></a>
        <a href="sick_leave_manage.php"><?php echo constant("CD_MENU_MANAGE_SICK_LEAVE");?></a>
        </div>
            
	 	<!--preference drop down menu -->
        <div id="prefer" class="dropmenudiv_d"> 
        <a href="password.php"><?php echo constant("ADMIN_MENU_CHANGE_PASSWORD");?></a>
        <a href="quicklink_manage.php"><?php echo constant("ADMIN_MENU_QUICK_LINKS");?></a>
        </div>
        <div id="help" class="dropmenudiv_d">
		<?php
        foreach($dbf->fetchOrder('help',"ac='1'","id") as $val) {
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
