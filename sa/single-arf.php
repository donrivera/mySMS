<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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

$student_id = $_REQUEST['student_id'];

if($_REQUEST['action']=='edit'){
	
	$pwd = base64_encode(base64_encode($_POST[oldpassword]));	
	$newpwd = base64_encode(base64_encode($_POST[newpassword]));
	
	$num=$dbf->countRows('user',"password='$pwd' AND uid='$student_id'");
	if($num>0){
		
		$string="password='$newpwd'";
		$dbf->updateTable("user",$string,"id='$student_id'");
		
		header("Location:single-password.php?msg=added");
		exit;
	}else{
		
		header("Location:single-password.php?msg=invalid");
		exit;
	}
}
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
<script language="javascript" type="text/javascript">
function check(){
	if(document.getElementById('oldpassword').value == ''){
		document.getElementById('lbl1').innerHTML = 'Enter old password';
		document.getElementById('oldpassword').focus();
		return false;
	}
	if(document.getElementById('newpassword').value == ''){
		document.getElementById('lbl2').innerHTML = 'Enter new password';
		document.getElementById('newpassword').focus();
		return false;
	}
	if(document.getElementById('confirmpassword').value == ''){
		document.getElementById('lbl3').innerHTML = 'Enter current password';
		document.getElementById('confirmpassword').focus();
		return false;
	}
	if(document.getElementById('newpassword').value != document.getElementById('confirmpassword').value){
		document.getElementById('lbl3').innerHTML = 'Password not match';
		document.getElementById('newpassword').focus();
		return false;
	}
}
</script>
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
<?php if($_SESSION[lang] == "EN") { ?>
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
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-reports.php?student_id=<?php echo $_REQUEST[student_id];?>">
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
                <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="25%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> :</td>
                    <td width="75%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <?php if($student["student_id"] > 0){?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "photo/".$student["photo"];
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top" class="leftmenu">&nbsp;ARF Reports</td>
              </tr>
              <?php
			  $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
			  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                
                <table width="97%" border="0" cellspacing="0" cellpadding="0" style=" border:solid 1px; border-color:#CCCCCC;">
                  <tr>
                    <td width="98">&nbsp;</td>
                    <td width="106" height="30" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?> :</td>
                    <td width="232" class="mytext"><?php echo $res_std[first_name]; ?> <?php echo $Arabic->en2ar($dbf->StudentName($res_std["id"]));?></td>
                    <td width="18">&nbsp;</td>
                    <td width="85">&nbsp;</td>
                    <td width="227" align="left" valign="middle">
                    <a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="Print"/></a>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :</td>
                    <td align="left" valign="middle"  class="mytext"><?php echo $res_arf[dated];?>
                      
                    </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_NR");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[nr];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?> :</td>
                    <td align="left" valign="middle"  class="mytext"><?php echo $res_arf[action_owner];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[report_by];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?> :</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[report_to];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?> : </td>
                    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[customer];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td width="85" align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[reception2];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[teacher];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LCD");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[lcd];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[reception1];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LIS");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[lis];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"<?php echo $res_arf[cs1];?>></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[cs2];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[other1];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[other2];?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?> : </td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[instruction];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[material];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[programme];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[premisses];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[administration];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
                    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[other3];?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
                    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu">&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?> </td>
                    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle" class="leftmenu"><a href="#"></a></td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                </table>
                
                </td>
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
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
              <td width="18%" align="left"><a href="single-reports.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
              
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                  <td width="25%" height="30" align="right" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
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
                <td width="21%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "photo/".$student["photo"];
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
                      <td width="63%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="37%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
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
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                
                <td colspan="4" align="right" valign="top" class="leftmenu">&nbsp;<?php echo $Arabic->en2ar('ARF Reports');?></td>
              </tr>
              <?php
			  $res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
			  $res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="9%" height="30" align="center" valign="middle"><a href="arf_print.php?id=<?php echo $_REQUEST[id];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="Print"/></a></td>
                    <td width="34%" align="right" valign="middle">&nbsp;</td>
                    <td width="14%" align="left" valign="middle">&nbsp;</td>
                    <td width="27%" align="right" valign="middle"><span class="leftmenu"><?php echo $res_std[first_name]; ?> <?php echo $Arabic->en2ar($dbf->StudentName($res_std["id"]));?></span></td>
                    <td width="16%" align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[nr];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_NR");?></td>
                    <td align="right" valign="middle"><span class="leftmenu"><?php echo $res_arf[dated];?></span></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><span class="leftmenu"><?php echo $res_arf[action_owner];?></span></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[report_to];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[report_by];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[reception2];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[customer];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[lcd];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_LCD");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[teacher];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[lis];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_LIS");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[reception1];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[cs2];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[cs1];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_CS");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[other2];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                    <td align="right" valign="middle"><?php echo $res_arf[other1];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[instruction];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[material];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[programme];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[premisses];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[administration];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle"><?php echo $res_arf[other3];?></td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="40%">&nbsp;</td>
                          <td width="60%" height="25" align="left" valign="middle" bgcolor="#FFCCCC"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?>&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?></td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">: <?php echo constant("RECEPTION_ARF_MANAGE_DATE");?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="right" valign="middle" class="leftmenu">&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;<?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?></td>
                  </tr>
                </table></td>
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
        </table>		</td>
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
