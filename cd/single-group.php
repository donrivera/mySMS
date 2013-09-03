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

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
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
<!--For Pop Up Box-->
<script type="text/javascript" src="dropdowntabs.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />


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
<?php if ($_SESSION[lang] == "EN") { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td colspan="2" align="left" valign="top">
                  <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="35%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> : &nbsp;</td>
                    <td width="65%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" style="padding-top:3px; padding-bottom:3px;"><a href="search_adding_group.php?student_id=<?php echo $student[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=250&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                  </a>
                  <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td width="77%" height="22" align="right" valign="middle" class="pedtext">Adding for Another Group : &nbsp;</td>
                      <td width="23%" align="center" valign="middle" class="mytext"><a href="search_adding_group.php?student_id=<?php echo $student[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=250&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                  <?php //if($numg > 0 || $is_hold > 0) {?>
                  <img src="../images/group.png" width="16" height="16" border="0" title="Adding to Group">
                  <?php //} ?>
                </a></td>
                    </tr>
                  </table>
                  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                    <td width="42%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></td>
                    <td width="17%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="17%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                    <td width="12%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
                    <td width="8%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("RESULTS");?></td>
                  </tr>
                  <?php
				  $k = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"student_id='$student_id'","","") as $dtls){
					  $group = $dbf->strRecordID("student_group","*","id='$dtls[parent_id]'");
				  ?>
                  <tr>
                    <td height="22" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                    <td align="left" valign="middle" class="shop2">
					<?php echo $dbf->getDataFromTable("course","name","id='$group[course_id]'");?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");?></td>
                    <td align="center" valign="middle" class="mytext"><?php echo $group["status"];?></td>
                    <td align="center" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("teacher_progress_certificate","final_percent","course_id='$dtls[course_id]' And student_id='$student_id'");?>%</td>
                  </tr>
                  <?php $k++; } ?>
                </table></td>
              </tr>
             <!--<tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="6%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php //echo constant("STUDENT_MYACCOUNT_SL");?></td>
                    <td width="18%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php //echo constant("STUDENT_ADVISOR_GROUP_GROUP");?> / <?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="16%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php //echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                    <td width="19%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php //echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?> / <?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?></td>
                    <td width="19%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php //echo constant("CENTER");?></td>
                    <td width="13%" align="center" valign="middle" bgcolor="#CCCCCC"><?php //echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
                    <td width="9%" align="center" valign="middle" bgcolor="#CCCCCC"><?php //echo constant("RESULTS");?></td>
                  </tr>
                  <?php
				  $k = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"student_id='$student_id'","","") as $dtls){
					  $group = $dbf->strRecordID("student_group","*","id='$dtls[parent_id]'");
				  ?>
                  <tr>
                    <td height="22" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                    <td align="left" valign="middle" class="shop2">
					<?php //echo $group["group_name"].'  [ '.$dbf->getDataFromTable("course","name","id='$group[course_id]'").' ]';?></td>
                    <td align="left" valign="middle" class="shop2"><?php //echo $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");?></td>
                    <td align="left" valign="middle" class="shop2"><?php //echo $group["start_date"]. ' / '. $group["end_date"];?></td>
                    <td align="left" valign="middle" class="shop2"><?php //echo $dbf->getDataFromTable("centre","name","id='$group[centre_id]'");?></td>
                    <td align="center" valign="middle" class="mytext"><?php //echo $group["status"];?></td>
                    <td align="center" valign="middle" class="mytext"><?php //echo $dbf->getDataFromTable("teacher_progress_certificate","final_percent","course_id='$dtls[course_id]' And student_id='$student_id'");?>%</td>
                  </tr>
                  <?php $k++; } ?>
                </table></td>
              </tr>-->
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
		
		<form id="frm" name="frm" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="15%">&nbsp;</td>
                <td width="38%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="64%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="36%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
                  	</tr>
                </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" style="padding-top:3px; padding-bottom:3px;"><a href="search_adding_group.php?student_id=<?php echo $student[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=250&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                  </a>
                  <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      
                      <td width="33%" align="center" valign="middle" class="mytext"><a href="search_adding_group.php?student_id=<?php echo $student[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=250&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                  <?php //if($numg > 0 || $is_hold > 0) {?>
                  <img src="../images/group.png" width="16" height="16" border="0" title="Adding to Group">
                  <?php //} ?>
                </a></td>
                <td width="67%" height="22" align="center" valign="middle" class="pedtext">  &nbsp;:<?php echo $Arabic->en2ar('Adding for Another Group');?></td>
                    </tr>
                  </table>
                  </td>
                
                
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="8%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("RESULTS");?></td>
                    <td width="12%" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></td>
                    <td width="17%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></td>
                    <td width="17%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="42%" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></td>
                    <td width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
                  </tr>
                  <?php
				  $k = 1;
				  foreach($dbf->fetchOrder('student_group_dtls',"student_id='$student_id'","","") as $dtls){
					  $group = $dbf->strRecordID("student_group","*","id='$dtls[parent_id]'");
				  ?>
                  <tr>
                    <td align="center" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("teacher_progress_certificate","final_percent","course_id='$dtls[course_id]' And student_id='$student_id'");?>%</td>
                    <td align="center" valign="middle" class="mytext"><?php echo $group["status"];?></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");?></td>
                    <td align="right" valign="middle" class="shop2">
					<?php echo $dbf->getDataFromTable("course","name","id='$group[course_id]'");?></td>
                    <td align="right" valign="middle" class="shop2"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                    <td height="22" align="center" valign="middle" class="mytext"><?php echo $k;?></td>
                  </tr>
                  <?php $k++; } ?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</form>		</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
