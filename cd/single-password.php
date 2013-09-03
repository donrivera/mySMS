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

$student_id = $_REQUEST['student_id'];

if($_REQUEST['action']=='edit'){
	
	$newpwd = base64_encode(base64_encode($_POST["newpassword"]));
	
	$res_st = $dbf->strRecordID("student","*","id='$student_id'");
	
	$is_exist = $dbf->countRows('user',"user_type='Student' And uid='$student_id'");
	if($is_exist > 0){
		
		$string="user_id='$_REQUEST[uid]',password='$newpwd'";
		$dbf->updateTable("user",$string,"user_type='Student' And uid='$student_id'");
		
	}else{
		
		$cr_date = date('Y-m-d H:i:s A');
					
		$string="user_type='Student',email='$res_st[email]',user_id='$_REQUEST[uid]',password='$newpwd',user_name='$res_st[first_name]',mobile='$res_st[student_mobile]',uid='$student_id',center_id='$res_st[centre_id]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
				
		$dbf->insertSet("user",$string);
					
	}
	
	//Mail to particular user
	$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");

	//To
	$to = $res_st[email];
	
	//From
	$from = $res_admin[email];
	
	$u = $_POST["uid"];
	$p = $_POST["newpassword"];
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From:".$from."\n";
	$body='<table border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(109, 146, 201);" width="662">
			<tbody>
				<tr>
					<td bgcolor="#FF9900" colspan="2" height="80"><img alt="" src="'.$res_logo[name].'" style="width: 105px; height: 30px;" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><table width="56%" height="97"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
						<tr>
						  <th height="28" colspan="2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#FFFFFF" scope="col"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="9%" height="30" align="center" valign="middle" >&nbsp;</td>
							  <td width="91%" height="30" align="left" valign="middle"  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#000000">Your Login Information</td>
							</tr>
						  </table></th>
		  </tr>
						  <tr>
							<td >&nbsp;</td>
							<td height="20" align="left"  style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000066; font-weight:bold"><span class="style6">Username: <span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;"> '.$u.' </span></span></td>
						  </tr>
						  <tr>
							<td width="9%" >&nbsp;</td>
							<td width="91%" height="20" align="left"  style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000066; font-weight:bold"><span class="style6">Password: '.$p.'</span></td>
						  </tr>
						  </table></td>
						</tr>
						<tr>
							<td>
								</td>
							<td>
						<span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">Thank you,<br />
						B</span></span><span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">erliz AlAhsa, a Dar Al-Khibra Human Resourses Development Company</span></span></td>
				</tr>
				<tr>
					<td>&nbsp;
						</td>
					<td>&nbsp;
						</td>
				</tr>
			</tbody>
		</table>';
				
	$subject = "Your login details";
	mail($to,$subject,$body,$headers);
	
	//Start Save Mail	
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Student',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='SA to Student',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	header("Location:single-password.php?student_id=$student_id&msg=added");
	exit;
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
	
	if(document.getElementById('uid').value == ''){
		document.getElementById('uid').focus();
		return false;
	}
	if(document.getElementById('newpassword').value == ''){
		document.getElementById('newpassword').focus();
		return false;
	}
	if(document.getElementById('confirmpassword').value == ''){
		document.getElementById('confirmpassword').focus();
		return false;
	}
	if(document.getElementById('newpassword').value != document.getElementById('confirmpassword').value){
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

$user_pwd = $dbf->strRecordID('user',"*","user_type='Student' And uid='$student_id'");
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="center" valign="top">
                <form action="single-password.php?action=edit&student_id=<?=$_REQUEST["student_id"];?>" name="frm" method="post" id="frm" onSubmit="return check();" >
                <table width="70%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                  <tr>
                    <td>&nbsp;</td>
                    <td height="30" colspan="3" align="center" valign="middle">
                    <?php if($_REQUEST['msg']=="added"){ ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" class="mymenutext">&nbsp;<?php echo constant("ADMIN_USER_MANAGE_PWDMSG");?></td>
                      </tr>
                    </table>
                    <?php
                    }
					if($_REQUEST['msg']=="invalid"){ ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" class="red_smalltext">&nbsp;<?php echo constant("TEACHER_PASSWORD_INVALIDPWD");?></td>
                      </tr>
                    </table>
                    <?php } ?>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="12%">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="37%">&nbsp;</td>
                    <td width="24%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_USER_MANAGE_USERID");?> : <span class="nametext1">*</span></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><input name="uid" type="text" class="validate[required] new_textbox190" id="uid" value="<?php echo $user_pwd["user_id"];?>" /></td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_PASSWORD_NEWPASSWORD");?> : <span class="nametext1">*</span></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><input name="newpassword" type="password" class="new_textbox190" id="newpassword" size="45" minlength="4"/></td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl2">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_PASSWORD_CONFIRMPASSWORD");?> : <span class="nametext1">*</span></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><input name="confirmpassword" type="password" class="new_textbox190" id="confirmpassword" size="45" minlength="4"/></td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="10" colspan="5" align="left" valign="middle"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="10" colspan="5" align="left" valign="middle"></td>
                  </tr>
                </table>
                </form>
                </td>
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
                <td width="25%" height="30" align="left" class="logintext"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
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
                <td colspan="4" align="center" valign="top">
                <form action="single-password.php?action=edit&student_id=<?=$_REQUEST["student_id"];?>" name="frm" method="post" id="frm" onSubmit="return check();" >
                <table width="70%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#CCC;">
                  <tr>
                    <td>&nbsp;</td>
                    <td width="38%" height="30" align="left" valign="middle"><?php if($_REQUEST['msg']=="added"){ ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="mymenutext"><?php echo constant("ADMIN_USER_MANAGE_PWDMSG");?></td>
                          </tr>
                        </table>
                      <?php } ?>
                        <?php if($_REQUEST['msg']=="invalid"){ ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="red_smalltext"><?php echo constant("TEACHER_PASSWORD_INVALIDPWD");?></td>
                          </tr>
                        </table>
                      <?php } ?>
                    </td>
                    <td>&nbsp;</td>
                    <td height="30" align="left" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="14%">&nbsp;</td>
                    <td width="38%">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="21%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle"><input name="uid" type="text" class="validate[required] new_textbox190_ar" id="uid" value="<?php echo $user_pwd["user_id"];?>" /></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;<span class="nametext1">*</span> : <?php echo constant("ADMIN_USER_MANAGE_USERID");?>&nbsp;</td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl1">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle"><input name="newpassword" type="password" class="new_textbox190_ar" id="newpassword" size="45" minlength="4"/></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;<span class="nametext1">*</span> : <?php echo constant("ADMIN_PASSWORD_NEWPASSWORD");?>&nbsp;</td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl2">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="28" align="left" valign="middle"><input name="confirmpassword" type="password" class="new_textbox190_ar" id="confirmpassword" size="45" minlength="4"/></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;<span class="nametext1">*</span> : <?php echo constant("ADMIN_PASSWORD_CONFIRMPASSWORD");?>&nbsp;</td>
                    <td align="left" valign="middle" class="red_smalltext" id="lbl3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="10" colspan="5" align="left" valign="middle"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                    <td height="25" align="left" valign="middle" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="10" colspan="5" align="left" valign="middle"></td>
                  </tr>
                </table>
                </form>                </td>
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
