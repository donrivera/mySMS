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

include '../includes/FusionCharts.php';
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

<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  
  <tr>
    <td align="left" valign="top">
	<form name="frm" id="frm" method="post" action="">
	<table width="98%" border="0" cellpadding="0" cellspacing="0">
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
                  <td width="34%" height="30" align="left" class="logintext">
                  <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ADMIN_MENU_REPORTS_GROUP_GRADE");?></td>
                  <td width="19%" class="logintext">&nbsp;</td>
                  <td width="31%" align="left"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENT");?> : <?php echo $dbf->getDataFromTable("student", "first_name", "id='$_REQUEST[student_id]'");?> <?php echo $Arabic->en2ar($dbf->StudentName($_REQUEST["student_id"]));?>
                    </td>
                  <td width="8%" align="left"></td>
                  <td width="8%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top" bgcolor="#FFFFFF">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30">&nbsp;</td>
                  <td width="36" align="center" valign="middle"><a href="report_student_group_grade_word.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                  <img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
                  <td width="36" align="center" valign="middle"><a href="report_student_group_grade_csv.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                  <img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
                  <td width="36" align="center" valign="middle"><a href="report_student_group_grade_pdf.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                  <img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
                  <td width="36" align="center" valign="middle"><a href="report_student_group_grade_print.php?student_id=<?php echo $_REQUEST["student_id"];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
                </tr>
            </table></td>
              </tr>
              <tr>
              <?php
			 $res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
			 ?>
                <td align="left" valign="top" style="padding-top:40px;">
                                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
                  <tr>
                    <td height="25" colspan="3" align="center" valign="middle" bgcolor="#CCCCCC"><span class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?></span></td>
                    </tr>
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="37%">&nbsp;</td>
                    <td width="57%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?> :</td>
                    <td align="left" valign="middle"><span class="lable1"><?php echo $res[first_name]; ?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_IDNO");?> :</td>
                    <td align="left" valign="middle"><span class="lable1"><?php echo $res[student_id]; ?></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL");?> :</td>
                    <td align="left" valign="middle"><span class="lable1"><?php echo $res[email]; ?></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle" class="pedtext">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                </table></td>
                <td align="center" valign="middle" class="logintext"></td>
                <td width="675" rowspan="4" align="left" valign="top">
				<?php
				
				echo $strXML1="<chart palette='1' caption='Student Group Grade' shownames='1' showvalues='1' numberPrefix='' sYAxisValuesDecimals='2' connectNullData='0' PYAxisName='Percentage' SYAxisName='Quantity' numDivLines='4' formatNumberScale='0'>
					<categories>";
					
					//All courses of the particular student
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student_id]'","id") as $val) {
					
					$course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					$name = $course[name];
					
						$strXML1.="<category label='$name'/>";
						
					}
						
					$strXML1.="</categories>";
					//========================================
					
					$strXML1.="<dataset seriesName='' color='FFCC00' showValues='1'>";
					
					//Get Percentage of the particular student					
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student_id]'","id") as $val1){
					
						$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$_REQUEST[student_id]' And course_id='$val1[course_id]'");						
						$percent = $per["final_percent"];
					
						$strXML1.="<set value='$percent'/>";
						
						}
						
					$strXML1.="</dataset>";
					
					
					
					
					
					//=========================================
					
					
					$strXML1.="<dataset seriesName='' color='33CC00' showValues='0' parentYAxis='S'>";
					
					//Get Percentage of the particular student					
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student_id]'","id") as $val1){
					
						$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$_REQUEST[student_id]' And course_id='$val1[course_id]'");						
						$percent = $per["final_percent"];
					
						$strXML1.="<set value='$percent'/>";
						
						}
						
					$strXML1.="</dataset>
				</chart>";
				echo renderChartHTML("../FusionCharts/Charts/MSColumn3DLineDY.swf", "", $strXML1, "myNext",620, 270);
				?>
                
                </td>
              </tr>
              <tr>
                <td height="5" align="left" valign="top"></td>
                <td height="5" align="left" valign="middle" class="lable1"></td>
                </tr>
			  
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="1" bordercolor="#999" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                  <tr>
                    <td width="8%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                    <td width="31%" align="left" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
                    <td width="27%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE");?></td>
                    <td width="34%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE");?></td>
                  </tr>
                  <?php					
					$i = 1;
					
					$num=$dbf->countRows('grade');
					foreach($dbf->fetchOrder('student_course',"student_id='$res[id]'","id DESC") as $val) {
					
					$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					if($res_course[name] !='') {
						
					//Get percentage
					$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$val[course_id]' And student_id='$_REQUEST[student_id]'");					
					$mark = $res_per[final_percent];
										
					//Get Average
					$grade = $dbf->strRecordID("grade","*","(tto>='$mark' And frm<='$mark')");
					$grade_name = $grade[name];
					?>
                  <tr>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $mark;?>%</td>
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $grade_name;?></td>
                    <?php
					}
					  $i = $i + 1;
					  }
					  ?>
                  </tr>
                  <?php
					if($num==0)
					{
					?>
                  <tr>
                    <td height="25" colspan="4" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                  <?php
					}
					?>
                </table></td>
                <td align="left" valign="middle">&nbsp;</td>
                </tr>
			  
              <tr>
                <td width="358" align="left" valign="top">&nbsp;</td>
                <td width="10">&nbsp;</td>
                </tr>
            </table>
			</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
	</form></td>
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
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  
  <tr>
    <td align="left" valign="top">
	<form name="frm" id="frm" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr class="logintext">
                      
                      <td width="19%" class="headingtext">&nbsp;</td>
                      <td width="31%" align="left">
                        <?php echo $dbf->getDataFromTable("student", "first_name", "id='$_REQUEST[student_id]'");?> <?php echo $Arabic->en2ar($dbf->StudentName($_REQUEST["student_id"]));?> : <?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENT");?></td>
                      <td width="8%" align="left">&nbsp; </td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="34%" height="30" align="right" class="headingtext"><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?> <img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTGG");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="200" align="left" valign="top" bgcolor="#FFFFFF">
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="10" height="30">&nbsp;</td>
                              <td width="37" align="center" valign="middle"><a href="report_student_group_grade_word.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                              <img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
                              <td width="36" align="center" valign="middle"><a href="report_student_group_grade_csv.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                              <img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
                              <td width="29" align="center" valign="middle"><a href="report_student_group_grade_pdf.php?student_id=<?php echo $_REQUEST["student_id"];?>">
                              <img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
                              <td width="479" align="left" valign="middle"><a href="report_student_group_grade_print.php?student_id=<?php echo $_REQUEST["student_id"];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
                            </tr>
                        </table>
                        </td>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        </tr>
                      <tr>
                        <?php
					 $res = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
					 ?>
                        <td width="614" rowspan="4" align="right" valign="top">
                          <?php
				
				echo $strXML1="<chart palette='1' caption='Student Group Grade' shownames='1' showvalues='1' numberPrefix='' sYAxisValuesDecimals='2' connectNullData='0' PYAxisName='Percentage' SYAxisName='Quantity' numDivLines='4' formatNumberScale='0'>
					<categories>";
					
					//All courses of the particular student
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student_id]'","id") as $val) {
					
					$course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					$name = $course[name];
					
						$strXML1.="<category label='$name'/>";
						
					}
						
					$strXML1.="</categories>";
					//========================================
					
					$strXML1.="<dataset seriesName='' color='FFCC00' showValues='1'>";
					
					//Get Percentage of the particular student					
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student]'","id") as $val1){
					
						$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$_REQUEST[student_id]' And course_id='$val1[course_id]'");						

						$percent = $per["final_percent"];
					
						$strXML1.="<set value='$percent'/>";
						
						}
						
					$strXML1.="</dataset>";			
									
					
					
					//=========================================
					
					
					$strXML1.="<dataset seriesName='' color='33CC00' showValues='0' parentYAxis='S'>";
					
					//Get Percentage of the particular student					
					foreach($dbf->fetchOrder('student_group_dtls',"student_id='$_REQUEST[student_id]'","id") as $val1){
					
						$per = $dbf->strRecordID("teacher_progress_certificate","*","student_id='$_REQUEST[student_id]' And course_id='$val1[course_id]'");						
						$percent = $per["final_percent"];
					
						$strXML1.="<set value='$percent'/>";
						
						}
						
					$strXML1.="</dataset>
				</chart>";
				echo renderChartHTML("../FusionCharts/Charts/MSColumn3DLineDY.swf", "", $strXML1, "myNext",620, 270);
				?>
                          
                          </td>
                        <td align="center" valign="middle" class="logintext"></td>
                        <td align="left" valign="top" style="padding-top:40px;">
                          
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
                            <tr>
                              <td height="25" colspan="3" align="center" valign="middle" bgcolor="#CCCCCC"><span class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?></span></td>
                              </tr>
                            <tr>
                              <td width="47%">&nbsp;</td>
                              <td width="47%">&nbsp;</td>
                              <td width="6%">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="right" valign="middle"><span class="lable1"><?php echo $res[first_name]; ?> <?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></span></td>
                              <td align="left" valign="middle" class="pedtext"> : <?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="right" valign="middle"><span class="lable1"><?php echo $res[student_id]; ?></span></td>
                              <td align="left" valign="middle" class="pedtext"> : <?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_IDNO");?></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle"><span class="lable1"><?php echo $res[email]; ?></span></td>
                              <td align="left" valign="middle" class="pedtext"> : <?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_EMAIL");?></td>
                               <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle" class="pedtext">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              </tr>
                            </table></td>
                        
                        </tr>
                      <tr>
                        <td height="5" align="left" valign="top"></td>
                        <td height="5" align="left" valign="middle" class="lable1"></td>
                        </tr>
                      
                      <tr>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="top">
                          <table width="100%" border="1" bordercolor="#999" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="34%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_GRADE");?></td>
                              <td width="27%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_PERCENTAGE");?></td>
                              <td width="31%" align="right" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></td>
                               <td width="8%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                              </tr>
                            <?php					
							$i = 1;
							
							$num=$dbf->countRows('grade');
							foreach($dbf->fetchOrder('student_course',"student_id='$res[id]'","id DESC") as $val) {
							
							$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
							
							if($res_course[name] !='') {
								
							//Get percentage
							$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$val[course_id]' And student_id='$_REQUEST[student_id]'");					
							$mark = $res_per[final_percent];
												
							//Get Average
							$grade = $dbf->strRecordID("grade","*","(tto>='$mark' And frm<='$mark')");
							$grade_name = $grade[name];
							?>
                            <tr> 
                            <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $grade_name;?></td>                             
                              <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $mark;?>%</td>
                              
                              <td height="25" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $res_course[name];?></td>
                              <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                              <?php
								}
								  $i = $i + 1;
								  }
								  ?>
								  </tr>
										<?php
								if($num==0)
								{
								?>
                            <tr>
                              <td height="25" colspan="4" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                              </tr>
                            <?php
							}
							?>
                            </table></td>
                        
                        </tr>
                      
                      <tr>
                        <td width="78" align="left" valign="top">&nbsp;</td>
                        <td width="308">&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                <tr>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
	</form></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>


</body>
</html>
