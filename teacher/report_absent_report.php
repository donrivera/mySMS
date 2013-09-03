<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
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
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

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
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
          9: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
</script>
  <tr>
    <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="36" align="center" valign="middle"><a href="report_absent_report_word.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
          <td width="36" align="center" valign="middle"><a href="report_absent_report_csv.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
          <td width="36" align="center" valign="middle"><a href="report_absent_report_pdf.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
          <td width="36" align="center" valign="middle"><a href="report_absent_report_print.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
        </tr>
      </table></td>
      </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
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
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ADMIN_REPORT_ABSENT_REPORT_ABSENTREPORT");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp; </td>
                  <td width="10%" align="left"><a href="home.php"> 
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <form id="frm" name="frm" action="">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="80" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :&nbsp;</td>
                    <td width="128" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="75" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :&nbsp;</td>
                    <td width="141" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="71" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :&nbsp;</td>
                    <td width="108" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="57" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :&nbsp;</td>
                    <td width="123" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="186" align="right" valign="middle" bgcolor="#FFFFFF">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                  </tr>
                </table>
                </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME;?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_GROUP_TO_FINISH_LEVEL;?></th>
                  <th width="7%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_GROUP;?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME;?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_MOBILENO;?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS;?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_LASTATTAND;?></th>
                  <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT;?></th>
                </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And  s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 4.
					//"s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'"
					//loop start
					foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d', $condition ,"","d.*") as $val) {
					
					//Get Course
					$course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					$group_dtls = $dbf->strRecordID("student_group","*","id='$val[parent_id]'");
					//Get Total Absent
					$res_max = $dbf->strRecordID("ped_attendance","COUNT(id)","student_id='$val[student_id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$countid = $res_max["COUNT(id)"];
					
					//Get Last Attendance
					$res_max = $dbf->strRecordID("ped_attendance","MAX(id)","student_id='$val[student_id]' AND (shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A')");
					$maxid = $res_max["MAX(id)"];
					
					$reslast = $dbf->strRecordID("ped_attendance","*","id<'$maxid' AND student_id='$val[student_id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					$resp = $dbf->strRecordID("ped_attendance","*","student_id='$val[id]' AND (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
					
					//Get Name Of Groups
					$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
					$res2 = $dbf->strRecordID("common","*","id='$val[parent_id]'");
					
					//Get Name Of Teacher
					$res3 = $dbf->strRecordID("teacher","*","id='$_SESSION[uid]'");
					
					if($countid>0) {
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="left" valign="middle" class="contenttext"><?php echo $res[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></td>
                  <td align="left" valign="middle" class="contenttext"><?php echo $course[name];?></td>
                  <td align="left" valign="middle" class="contenttext"><?php echo $group_dtls[group_name];?></td>
                  <td align="left" valign="middle" class="contenttext"><?php echo $res3[name];?></td>
                  <td align="left" valign="middle" class="contenttext"><?php echo $res[student_mobile];?></td>
                  <td align="left" valign="middle" class="contenttext"><?php echo $res[email];?></td>
				  <?php
				  $last = '';
				  if($reslast["unit"] > 0){
				  		$last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
				  }
				  ?>
                  <td align="left" valign="middle" class="contenttext"><?php echo $last;?></td>
                  <td width="11%" align="center" valign="middle"><?php echo $countid;?></td>
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
            </table>
            </td>
          </tr>         
		  <?php
			if($i > 1){
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
				</table>
				</td>
			</tr>
			<?php
				}
				if($i <= 1){
				?>
			<tr>
			  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php } ?>		  
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:0px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <tr>
    <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="14">&nbsp;</td>
          <td width="30" align="center" valign="middle"><a href="report_absent_report_word.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
          <td width="27" align="center" valign="middle"><a href="report_absent_report_csv.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
          <td width="28" align="center" valign="middle"><a href="report_absent_report_pdf.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
          <td width="1154" align="left" valign="middle"><a href="report_absent_report_print.php?fname=<?php echo $_REQUEST["fname"];?>&stid=<?php echo $_REQUEST["stid"];?>&mobile=<?php echo $_REQUEST["mobile"];?>&email=<?php echo $_REQUEST["email"];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
        </tr>
      </table></td>
      </tr>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30"><a href="home.php"> 
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="35%" align="right" class="logintext"><?php echo constant("ADMIN_REPORT_ABSENT_REPORT_ABSENTREPORT");?><img src="../images/arrow_small_right2.png" width="16" height="16"> </td>
                </tr>
            </table></td>
          </tr>
          sdfg
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <form id="frm" name="frm" action="">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                      <td width="149" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="79" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                      <td width="109" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100_ar" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="93" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                      <td width="117" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="87" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                      <td width="115" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100_ar" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="77" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    </tr>
                  </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr>                  
                  <th width="12%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME ?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_GROUP_TO_FINISH_LEVEL?></th>
                  <th width="7%"  align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_GROUP;?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_TEACHERNAME?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_MOBILENO ?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_EMAILADDRESS ?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_LASTATTAND ?></th>
                  <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo ADMIN_REPORT_ABSENT_REPORT_TOTALABSENT ?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'  And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%' And  s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'";
					}
					//End 4.
					//"s.id=d.student_id And m.id=d.parent_id And m.teacher_id='$_SESSION[uid]'"
					//loop start
					foreach($dbf->fetchOrder('student s,student_group m,student_group_dtls d', $condition ,"","d.*") as $val) {
					
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
                  
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $course[name];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res2[name];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res3[name];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res[student_mobile];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res[email];?></td>
				  <?php
				  $last = '';
				  if($reslast["unit"] > 0){
				  		$last = "Unit(".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
				  }
				  ?>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $last;?></td>
                  <td width="11%" align="center" valign="middle"><?php echo $countid;?></td>
                  <td align="center" valign="middle" class="contenttext">&nbsp;</td>
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
         
		  <?php
				if($i > 1){
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
                    </table>
                    </td>
                </tr>
                <?php
					}
					if($i <= 1){
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php } ?>
		  
        </table>
        </td>
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