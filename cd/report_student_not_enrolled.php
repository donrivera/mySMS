<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');
include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
<!--*******************************************************************-->
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_word.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_csv.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_pdf.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_print.php?teacher=<?php echo $_REQUEST[teacher];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="99%" border="0" cellpadding="0" cellspacing="0">
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
        <td width="79%" align="left" valign="top">
        
        
        <form name="frm" id="frm" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="50%" height="30" align="left" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STUDENTNE");?></td>
                  <td width="7%"><span class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS");?></span> :</td>
                  <td width="22%" align="left">
                  <select name="teacher" id="teacher"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:110px;" onChange="javascript:document.frm.action='report_student_not_enrolled.php',document.frm.submit();">
                    <option value=""> Select Status </option>
                    <?php
						foreach($dbf->fetchOrder('student_status',"","name") as $val1) {	
					  ?>
                    <option value="<?php echo $val1[id];?>" <?php if($_REQUEST[teacher]==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
                    <?php
					   }
					   ?>
                  </select></td>
                  <td width="7%" align="left">&nbsp; </td>
                  <td width="14%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">
                  <th width="3%" height="29" align="center" valign="middle">&nbsp;</th>
                  <th width="13%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
                  <th width="7%" align="left" valign="middle" class="pedtext">&nbsp;</th>
                  <th width="17%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_MOBILENUMBER");?></th>
                  <th width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL");?></th>
                  <th width="8%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_DATEOFENQU");?></th>
                  <th width="14%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?></th>
                  <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LEADINFO");?></th>
                  <th width="16%" colspan="2" align="center" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_INTRESTEDIN");?></th>
                </tr>
				</thead>
                <?php
					if($_REQUEST[teacher]!=''){
						$cond = "s.id=c.student_id AND c.status_id='$_REQUEST[teacher]'";
					}else{
						$cond = "s.id=c.student_id";
					}
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student s,student_moving c',$cond,"");
					
					 //Loop start
					foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.id DESC","s.id","s.id") as $val) {
					
					$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
					
					//Get Course Name
					$course = "";
					foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
					
						$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
						if($course==''){
							$course  = $c[name];
						}else{
							$course  = $course.",".$c[name];
						}
					}
					
					//Get Lead Information
					$lead = '';
					foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
					
						$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
						if($lead==''){
							$lead  = $c[name];
						}else{
							$lead  = $lead.",".$c[name];
						}
					}
					
					//Register date
					if($val[register_date] == "0000-00-00"){
						$dt = '';
					}else{
						$dt = date('d-M-Y',strtotime($val_student[created_datetime]));
					}
					
					//Last comment
					$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
					$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");
				?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val_student[id];?>" style="cursor:pointer;"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></a></td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" align="center" valign="middle"><a href="sms_single.php?student_id=<?php echo $val["id"];?>&TB_iframe=true&amp;height=340&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/mobile.png" width="32" height="32" border="0"></a></td>
                      <td width="50%" align="center" valign="middle"><a href="email_single.php?student_id=<?php echo $val["id"];?>&TB_iframe=true&amp;height=380&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/message-icon.jpg" width="20" height="19" border="0"></a></td>
                    </tr>
                  </table></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[student_mobile];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[email];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dt;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $com["comments"];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $lead;?></td>
				  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $course;?></td>
                  <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }					  
					}
				  ?>
                </tr>
            </table></td>
          </tr>
           <?php
			if($num!=0){
			?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
			  
            </table></td>
                </tr>
                <?php }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>
        </table>
        </form>
        
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_word.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_csv.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_pdf.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_not_enrolled_print.php?teacher=<?php echo $_REQUEST[teacher];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>

  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top">
                
                
                <form name="frm" id="frm" method="post">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="49%" height="30" align="left" class="headingtext"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></td>
                  <td width="12%" align="left"><select name="teacher" id="teacher"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:110px;" onChange="javascript:document.frm.action='report_student_not_enrolled.php',document.frm.submit();">
                    <option value=""> Select Status </option>
                    <?php
						foreach($dbf->fetchOrder('student_status',"","name") as $val1) {	
					  ?>
                    <option value="<?php echo $val1[id];?>" <?php if($_REQUEST[teacher]==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
                    <?php
					   }
					   ?>
                  </select></td>
                  <td width="16%" align="left">&nbsp; : <span class="headingtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STATUS");?></span></td>
                  <td width="23%" align="right"><img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_STUDENTNE");?><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS");?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">
                  <th width="16%" align="center" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_INTRESTEDIN");?></th>
                  <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LEADINFO");?></th>
                  <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_LASTCOMT");?></th>
                  <th width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_DATEOFENQU");?></th>
                  <th width="10%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL");?></th>
                  <th width="17%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_NOT_ENROLLED_MOBILENUMBER");?></th>
                  <th width="7%" align="left" valign="middle" class="pedtext">&nbsp;</th>
                  <th width="13%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
                  <th width="3%" height="29" align="center" valign="middle">&nbsp;</th>
                </tr>
				</thead>
                <?php
					if($_REQUEST[teacher]!=''){
						$cond = "s.id=c.student_id AND c.status_id='$_REQUEST[teacher]' And s.centre_id='$_SESSION[centre_id]'";
					}else{
						$cond = "s.id=c.student_id And s.centre_id='$_SESSION[centre_id]'";
					}
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student s,student_moving c',$cond,"");
					
					 //Loop start
					foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.id DESC","s.id","s.id") as $val) {
					
					$val_student = $dbf->strRecordID("student","*","id='$val[id]'");
					
					//Get Course Name
					$course = "";
					foreach($dbf->fetchOrder('student_course',"student_id='$val[id]'","") as $valc) {
					
						$c = $dbf->strRecordID("course","name","id='$valc[course_id]'");
						if($course==''){
							$course  = $c[name];
						}else{
							$course  = $course.",".$c[name];
						}
					}
					
					//Get Lead Information
					$lead = '';
					foreach($dbf->fetchOrder('student_lead',"student_id='$val[id]'","") as $vall) {
					
						$c = $dbf->strRecordID("common","name","id='$vall[lead_id]'");
						if($lead==''){
							$lead  = $c[name];
						}else{
							$lead  = $lead.",".$c[name];
						}
					}
					
					//Register date
					if($val[register_date] == "0000-00-00"){
						$dt = '';
					}else{
						$dt = date('d-M-Y',strtotime($val_student[created_datetime]));
					}
					
					//Last comment
					$last_com = $dbf->getDataFromTable("student_comment", "MAX(id)", "student_id='$val[id]'");
					$com = $dbf->strRecordID("student_comment", "*", "id='$last_com'");
				?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
				  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $course;?></td>                  
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $lead;?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $com["comments"];?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dt;?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[email];?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[student_mobile];?></td>
                  <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" align="center" valign="middle"><a href="sms_single.php?student_id=<?php echo $val["id"];?>&TB_iframe=true&amp;height=340&amp;width=475&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/mobile.png" width="32" height="32" border="0"></a></td>
                      <td width="50%" align="center" valign="middle"><a href="email_single.php?student_id=<?php echo $val["id"];?>&TB_iframe=true&amp;height=380&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/message-icon.jpg" width="20" height="19" border="0"></a></td>
                    </tr>
                  </table></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_student[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }					  
					}
				  ?>
                </tr>
            </table></td>
          </tr>
           <?php
			if($num!=0){
			?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
			  
            </table></td>
                </tr>
                <?php }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>
        </table>
                  </form>
                
                </td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
