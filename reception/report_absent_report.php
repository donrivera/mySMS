<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
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
}?>
<script type="text/javascript" src="dropdowntabs.js"></script>


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
		  0: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 	 
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
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_word.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_csv.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_pdf.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_absent_report_print.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <form name="frm" id="frm">
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
                  <td width="38%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_ABSENTREPORT");?> </td>
                  <td width="7%" align="right" valign="middle" class="logintext">&nbsp;</td>
                  <td width="21%" align="left">&nbsp;</td>
                  <td width="11%" align="center">&nbsp;</td>
                  <td width="9%" align="left">&nbsp;</td>
                  <td width="14%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="71" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :</td>
                    <td width="155" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="81" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="68" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="58" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :</td>
                    <td width="113" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="164" align="right" valign="middle" bgcolor="#FFFFFF">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                  </tr>
                </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="2%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_LEVEL");?></th>
                  <th width="7%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_MOBILENO");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_LASTATTAND");?></th>
                  <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT");?></th>
                </tr>
				</thead>
                <?php
					$centre_id = $_SESSION[centre_id];
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%'  And centre_id='$centre_id'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$centre_id'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id>'0' And centre_id='$centre_id'";
					}
					//End 4.
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student', $condition);					
					//loop start
					foreach($dbf->fetchOrder('student', $condition ,"first_name") as $val) {
					
					//Get Course
					$g = $dbf->strRecordID("student_group_dtls","*","student_id='$val[id]'");
					
					$course = $dbf->strRecordID("course","*","id='$g[course_id]'");
					
					//Get Total Absent
					$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$countid = $res_max["COUNT(id)"];
					
					//Get Last Attendance
					$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$maxid = $res_max["MAX(id)"];
					
					$reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					$resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					
					//Get Name Of Groups
					$res = $dbf->strRecordID("student","*","id='$resp[student_id]'");
					$res2 = $dbf->strRecordID("common","*","id='$resp[group_id]'");
					
					//Get Name Of Teacher
					$res3 = $dbf->strRecordID("teacher","*","id='$resp[teacher_id]'");
					
					if($countid>0) {
					?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
                  <td height="30" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res2[name];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res3[name];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[student_mobile];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[email];?></td>
				  <?php
				  $last = '';
				  if($reslast["unit"] > 0){
				  		$last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
				  }
				  ?>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $last;?></td>
                  <td width="11%" align="center" valign="middle" ><?php echo $countid;?></td>
                  <?php
						  $i = $i + 1;
						  if($color=="#ECECFF"){
							  $color = "#FBFAFA";
						  }else{
							  $color="#ECECFF";
						  }					  
					  }
				  }
				  ?>
                </tr>               
            </table></td>
          </tr>         
		  <?php	if($i > 1){?>
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
                    </table>
                    </td>
                </tr>
                <?php
					}
					
					if($i <= 1)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
					}
					?>		  
        </table></td>
      </tr>
    </table>
    </form>
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
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_word.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_csv.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_absent_report_pdf.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_absent_report_print.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="10%" align="left">&nbsp;</td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp; </td>
                  
					<td width="39%" height="30" class="logintext" align="right"><img src="../images/arrow_small_right4.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/arrow_small_right2.png" width="16" height="16"> <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_ABSENTREPORT");?> </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                      <td width="149" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="79" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                      <td width="109" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100_ar" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="93" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                      <td width="117" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="87" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                      <td width="115" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100_ar" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="77" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    </tr>
                  </table>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_LEVEL");?></span></th>
                  <th width="7%" height="30" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_GROUP");?></span></th>
                  <th width="13%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME");?></span></th>
                  <th width="15%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_MOBILENO");?></span></th>
                  <th width="17%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS");?></span></th>
                  <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_LASTATTAND");?></span></th>
                  <th align="center" valign="middle" bgcolor="#99CC99" class="menutext"><span class="pedtext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT");?></span></th>
				  <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="menutext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></span></th>
				  <th width="2%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                </tr>
				</thead>
                <?php
					$centre_id = $_SESSION[centre_id];
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%'  And centre_id='$centre_id'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'  And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND student_id LIKE '$_REQUEST[stid]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE  '$_REQUEST[stid]%' AND email LIKE '%$_REQUEST[email]%' And centre_id='$centre_id'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE '$_REQUEST[stid]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_id LIKE '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_id LIKE  '$_REQUEST[stid]%' AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%' And centre_id='$centre_id'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id>'0' And centre_id='$centre_id'";
					}
					//End 4.
					
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('student', $condition);					
					//loop start
					foreach($dbf->fetchOrder('student', $condition ,"first_name") as $val) {
					
					//Get Course
					$g = $dbf->strRecordID("student_group_dtls","*","student_id='$val[id]'");
					$course = $dbf->strRecordID("course","*","id='$g[course_id]'");
					
					//Get Total Absent
					$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$countid = $res_max["COUNT(id)"];
					
					//Get Last Attendance
					$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$maxid = $res_max["MAX(id)"];
					
					$reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					$resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					
					//Get Name Of Groups
					$res = $dbf->strRecordID("student","*","id='$resp[student_id]'");
					$res2 = $dbf->strRecordID("common","*","id='$resp[group_id]'");
					
					//Get Name Of Teacher
					$res3 = $dbf->strRecordID("teacher","*","id='$resp[teacher_id]'");
					
					if($countid>0) {
					?>
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
                  <td height="30" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res2[name];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res3[name];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[student_mobile];?></td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res[email];?></td>
				  <?php
				  $last = '';
				  if($reslast["unit"] > 0)
				  {
				  		$last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
				  }
				  ?>
                  <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $last;?></td>
                  <td width="11%" align="center" valign="middle" bgcolor="#F8F9FB"><?php echo $countid;?></td>
				  <td height="25" align="right" valign="middle" class="mycon"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
				  <td height="25" align="center" valign="middle" class="mycon">&nbsp;</td>
                  <?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
					  
					  }
					  }
					  ?>
                </tr>
               
            </table></td>
          </tr>
         
		  <?php
					if($i > 1)
					{
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
                    </table>                    </td>
                </tr>
                <?php
					}
					
					if($i <= 1)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?
					}
					?>
		  
        </table></td>
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
