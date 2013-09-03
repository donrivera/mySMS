<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#startdate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#enddate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<!--UI JQUERY DATE PICKER-->

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
              <td width="36" align="center" valign="middle"><a href="report_statistic_word.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_csv.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_pdf.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_prnt.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">

    <table width="99%" border="0" cellpadding="0" cellspacing="0">
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="54%" height="30" align="left" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_STATISTIC");?></td>
                  <td width="22%" height="30" align="left">&nbsp;</td>
                  <td width="8%" height="30" align="left">&nbsp;</td>
                  <td width="8%" height="30" align="left">&nbsp; </td>
                  <td width="8%" height="30" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
            
            <form name="frm" id="frm">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <?php
			
				if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
					
					  $cond1="s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))";
				}else{
					$cond1="s.centre_id='$_SESSION[centre_id]'";
				}
				
			   //Get no. of students
				$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)",$cond1);
				$val_student1 = $dbf->strRecordID("student_group s,group_size gs","*",$cond1);
				$val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
	
				$val_std= $dbf->strRecordID("student","*","id='$val_student[student_id]' and level_complete='1'");
				?>       
                <tr>
                  <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                    <tr>
                      <td width="123" height="35" align="right" valign="middle" bgcolor="#FBF3E6" class="pedtext"><?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?>:&nbsp;</td>
                      <td width="87" align="left" valign="middle" bgcolor="#FBF3E6"><input name="startdate" type="text" class="datepick new_textbox80" id="startdate" value="<?php echo $_REQUEST[startdate];?>" /></td>
                      <td width="75" align="right" valign="middle" bgcolor="#FBF3E6" class="pedtext"> <?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?>:&nbsp;</td>
                      <td width="90" align="left" valign="middle" bgcolor="#FBF3E6"><input name="enddate" type="text" class="datepick new_textbox80" id="enddate" value="<?php echo $_REQUEST[enddate];?>" /></td>
                      <td width="223" align="left" valign="middle" bgcolor="#FBF3E6" class="red_smalltext"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1" border="0" align="left" /></td>
                    </tr>
                  </table>
                  <br>
                  </td>
                </tr>
                <tr>
                  <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1">
                  
                  <table width="600" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#FFCC00;" >
                    <tr>
                      <td width="52" height="30"></td>
                      <td width="536" class="leftmenu"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT1");?> :<span class="red_smalltext">&nbsp;					  
                       <?php
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
							echo number_format($val_student["SUM(gs.units)"],0);
						}
						?>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30"></td>
                      <td class="leftmenu"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT2");?> :<span class="red_smalltext">&nbsp;
					   <?php
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
							echo number_format($val_no_course['COUNT(course_id)'],0);
						}
						?>
                      </span></td>
                    </tr>
                    <tr>
                      <td height="30"></td>
                      <td class="leftmenu"><table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF99CC;">
                        <tr>
                          <td height="30" colspan="3" bgcolor="#FFFFCC" class="lable1">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT3");?></td>
                          </tr>
                          
                        <tr class="pedtext">
                          <td width="47%" height="30" align="left" valign="middle" bgcolor="#FF6600">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT4");?></td>
                          <td width="29%" align="left" valign="middle" bgcolor="#FF6600" ><?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?></td>
                          <td width="24%" align="left" valign="middle" bgcolor="#FF6600" ><?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?></td>
                        </tr>
                         <tr>
                          <td colspan="3" align="left" valign="middle" >
                          <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#FF6600" style="border-collapse:collapse;">                          <?php
					   	if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
							
							$cond="status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))";
						}else{
							$cond="";
						}
						
                       	//Get Number of Rows
						$num = $dbf->countRows('student_group',$cond);
						
						if($cond != ""){
							
							//Loop start
							foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
	
							//Get course name
							$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");						
						?>
                            <tr class="red_smalltext">
                              <td width="47%" height="25" align="left" valign="middle">&nbsp; <?php echo $val_course[name]; ?></td>
                              <td width="29%" align="left" valign="middle">&nbsp; <?php echo $val[start_date]; ?></td>
                              <td width="24%" align="left" valign="middle">&nbsp; <?php echo $val[end_date]; ?></td>
                            </tr>
                        <?php }} ?>                            
                          </table>
                          </td>

                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="lable1"></td>
                          <td align="left" valign="middle" class="lable1"></td>
                          <td align="left" valign="middle" class="lable1"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <?php
					$val_student_com = $dbf->strRecordID("student_course","*","course_id='$val[course_id]'");
					
					//$val_student_no = $dbf->strRecordID("student_course","COUNT(student_id)","course_id='$val[course_id]'");
					$val_student_no = $dbf->strRecordID("student_group g,student_group_dtls d","COUNT(d.student_id)","g.id=d.parent_id And g.status='Completed' And g.course_id='$val[course_id]' And (start_date <= '$_REQUEST[enddate]' And end_date >= '$_REQUEST[startdate]')");					
					?>
                    <tr>
                      <td height="30"></td>
                      <td class="leftmenu"><?php echo constant("ADMIN_REPORT_STATISTIC_TXT5");?> :<span class="red_smalltext">&nbsp;					  
					   <?php
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
							echo number_format($val_student_no['COUNT(d.student_id)'],0);
						}
						?>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" >&nbsp;</td>
                </tr>
            </table>
            </form>            
            </td>
          </tr>
        </table></td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else{?>
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
              <td width="36" align="center" valign="middle"><a href="report_statistic_word.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_csv.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_pdf.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_statistic_prnt.php?startdate=<?php echo $_REQUEST[startdate];?>&enddate=<?php echo $_REQUEST[enddate];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>

              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr class="logintext">
                      <td width="22%" height="30" align="left">&nbsp;</td>
                      <td width="8%" height="30" align="left">&nbsp;</td>
                      <td width="8%" height="30" align="left">&nbsp; </td>
                      <td width="8%" height="30" align="left"><a href="home.php"></a></td>
                      <td width="54%" height="30" align="right" class="headingtext"><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_STATISTIC");?> <img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_STATISTIC_STATISTICREPORT");?></td>

                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="200" align="left" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                    
                    <form name="frm" id="frm" >
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        <?php			
						if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
							
							$cond1="s.status='Completed' And gs.group_id=s.group_id And ((s.start_date >='$_REQUEST[startdate]' AND s.start_date <='$_REQUEST[enddate]') OR (s.end_date >='$_REQUEST[startdate]' AND s.end_date <='$_REQUEST[enddate]'))";
						}else{
							$cond1="s.centre_id='$_SESSION[centre_id]'";
						}
						
					   //Get no. of students
						$val_student = $dbf->strRecordID("student_group s,group_size gs","SUM(gs.units)",$cond1);
						$val_student1 = $dbf->strRecordID("student_group s,group_size gs","*",$cond1);
						$val_no_course = $dbf->strRecordID("student_group","COUNT(course_id)","course_id='$val_student1[course_id]'");
			
						$val_std= $dbf->strRecordID("student","*","id='$val_student[student_id]' and level_complete='1'");
						?>                        
                        <tr>
                          <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1">
                          <table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                            <tr>                              
                              <td width="223" align="right" valign="middle" bgcolor="#FBF3E6" class="red_smalltext">
                              <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn2" border="0" align="left" /></td>
                              <td width="90" align="right" valign="middle" bgcolor="#FBF3E6">
                              <input name="enddate" type="text" class="datepick new_textbox80_ar" id="enddate" value="<?php echo $_REQUEST[enddate];?>" /></td>
                              <td width="75" align="left" valign="middle" bgcolor="#FBF3E6" class="pedtext"> &nbsp;:&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?></td>
                              <td width="87" align="right" valign="middle" bgcolor="#FBF3E6">
                              <input name="startdate" type="text" class="datepick new_textbox80_ar" id="startdate" value="<?php echo $_REQUEST[startdate];?>" /></td>
                              <td width="123" height="35" align="left" valign="middle" bgcolor="#FBF3E6" class="pedtext">&nbsp;:&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?></td>
                              </tr>
                            </table>
                            <br>
                            </td>
                          </tr>
                        <tr>
                          <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1">
                            <table width="600" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#FFCC00;" >
                              <tr>
                                <td width="536" align="right" class="leftmenu"><span class="red_smalltext">&nbsp;  
                                <?php
								if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
                                	echo number_format($val_student["SUM(gs.units)"],0);
								  }
								  ?>
                                  </span> : <?php echo constant("ADMIN_REPORT_STATISTIC_TXT1");?></td>
                                   <td width="52" height="30"></td>
                                </tr>
                              <tr>                                
                                <td align="right" class="leftmenu"><span class="red_smalltext">&nbsp;
                                <?php
								if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
									echo number_format($val_no_course['COUNT(course_id)'],0);
                                }
								?>
                                </span> : <?php echo constant("ADMIN_REPORT_STATISTIC_TXT2");?></td>
                                <td height="30"></td>
                              </tr>
                              <tr>                                
                                <td align="right" class="leftmenu">
                                <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF99CC;">
                                  <tr>
                                    <td height="30" colspan="3" align="right" bgcolor="#FFFFCC" class="lable1">&nbsp;
									<?php echo constant("ADMIN_REPORT_STATISTIC_TXT3");?></td>
                                  </tr>                                  
                                  <tr class="pedtext">
                                    <td width="24%" align="right" valign="middle" bgcolor="#FF6600" ><?php echo constant("ADMIN_REPORT_STATISTIC_ENDDAT");?></td>
                                    <td width="29%" align="right" valign="middle" bgcolor="#FF6600" ><?php echo constant("ADMIN_REPORT_STATISTIC_STARTDAT");?></td>
                                    <td width="47%" height="30" align="right" valign="middle" bgcolor="#FF6600">&nbsp;<?php echo constant("ADMIN_REPORT_STATISTIC_TXT4");?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" align="left" valign="middle" >
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#FF6600" style="border-collapse:collapse;">
                                        <?php
									   if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
											  $cond="status='Completed' And ((start_date >='$_REQUEST[startdate]' AND start_date <='$_REQUEST[enddate]') OR (end_date >='$_REQUEST[startdate]' AND end_date <='$_REQUEST[enddate]'))";
										}else{
											$cond="";
										}
										
									   	//Get Number of Rows
										$num=$dbf->countRows('student_group',$cond);
										
										if($cond != ""){
											
											//Loop start
											foreach($dbf->fetchOrder('student_group',$cond,"id","") as $val){
					
											//Get course name
											$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");										
										?>
                                        <tr class="red_smalltext">
                                          <td width="24%" align="right" valign="middle">&nbsp; <?php echo $val[end_date]; ?></td>
                                          <td width="29%" align="right" valign="middle">&nbsp; <?php echo $val[start_date]; ?></td>
                                          <td width="47%" height="25" align="right" valign="middle">&nbsp; <?php echo $val_course[name]; ?></td>
                                        </tr>
                                        <?php }} ?>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" class="lable1"></td>
                                        <td align="left" valign="middle" class="lable1"></td>
                                        <td align="left" valign="middle" class="lable1"></td>
                                    </tr>
                                  </table></td>
                                  <td height="30"></td>
                                </tr>
                              <?php
							$val_student_com = $dbf->strRecordID("student_course","*","course_id='$val[course_id]'");
							//$val_student_no = $dbf->strRecordID("student_course","COUNT(student_id)","course_id='$val[course_id]'");
							$val_student_no = $dbf->strRecordID("student_group g,student_group_dtls d","COUNT(d.student_id)","g.id=d.parent_id And g.status='Completed' And g.course_id='$val[course_id]' And (start_date <= '$_REQUEST[enddate]' And end_date >= '$_REQUEST[startdate]')");
							
							?>
                              <tr>
                                <td align="right" class="leftmenu"><span class="red_smalltext">&nbsp;
                                  <?php
									if($_REQUEST[startdate] !='' && $_REQUEST[enddate] !=''){
										echo number_format($val_student_no['COUNT(d.student_id)'],0);
									}
									?>
                                  </span> : <?php echo constant("ADMIN_REPORT_STATISTIC_TXT5");?></td>
                                  <td height="30"></td>
                                </tr>
                              </table></td>
                          </tr>
                        <tr>
                          <td height="25" colspan="2" align="center" valign="middle" bgcolor="#F8F9FB" >&nbsp;</td>
                          </tr>
                        </table>
                      </form>                    
                    </td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
