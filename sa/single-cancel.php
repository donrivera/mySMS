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
include("../includes/saudismsNET-API.php");

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
//$studentid = $_REQUEST['student_id'];
$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
$course_id =  $_REQUEST['course_id'];
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
<script type="text/javascript" src="../modal/thickbox.js"></script>
<script type="text/javascript">
function show_payment(){
	var course = document.getElementById('course').value;
	var student_id = <?php echo $student_id;?>;
	
	if(course == ''){
		document.location.href='single-payment.php?student_id='+student_id;
	}else{
		document.location.href='single-payment.php?student_id='+student_id +"&course_id=" + course;
	}
}
function add(){
	var x = document.getElementById('count').value;
	var z='div'+x;
	document.getElementById(z).style.display = "block";
	x++;
	
	document.getElementById('count').value = x;
}
function del(){
		
	var x = document.getElementById('count').value;

	if(x==2){
		alert("You can not delete default row.");
		return false;
	}
	x = x - 1;
	var z='div'+x;
	document.getElementById(z).style.display = "none";	
	document.getElementById('count').value = x;
}
</script>
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
<?php if($_SESSION[lang]=="EN"){?>
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
                <td align="center" valign="middle" height="30"><a href="single-cancel-add.php?student_id=<?php echo $student_id;?>">
                <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" />
                </a></td>
              </tr>
              <tr>
              <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">
                <form id="frm" name="frm" method="post" action="">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    <td width="7%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_REQUEST_DATE");?></td>
                    <td width="15%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></td>
                    <td width="16%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="16%" align="center" bgcolor="#CCCCCC"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    <td width="11%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_REASON_FOR_CANCEL");?></td>
                    <td width="12%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_CD_CANCEL_STATUS");?></td>
                    <td width="13%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_ADMIN_CANCEL_STATUS");?></td>
                  </tr>
                  <?php
				  	 $num=$dbf->countRows("student_cancel","student_id='$student_id'");
				  	  foreach($dbf->fetchOrder("student_cancel","student_id='$student_id'") as $valcancel) {
					  $res_student = $dbf->strRecordID("student","*","id='$valcancel[student_id]'");
					  $dtls = $dbf->strRecordID("student_group_dtls","*","student_id='$valcancel[student_id]'");
					  $group = $dbf->strRecordID("student_group","*","id='$dtls[parent_id]'");
					  
				  ?>
                  <tr>
                    <td height="28"><?php echo $valcancel[dated];?></td>
                    <td align="left" valign="middle" class="shop2"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                    <td align="left" valign="middle" class="shop2">
					<?php echo $dbf->getDataFromTable("course","name","id='$group[course_id]'");?></td>
                    <td><?php echo $res_student[student_mobile];?></td>
                    <td><?php echo $valcancel[comment];?></td>
                    <?php
					if($valcancel["cd_comment"]!=''){
						$comment = $valcancel["cd_status"].'<br>'.$valcancel["cd_comment"].'<br>'.$valcancel["cd_dated"];
					}else{
						$comment = $valcancel["cd_status"];
					}
					?>
                    <td><?php echo $comment;?></td>
                    <?php
					if($valcancel["admin_comment"]!=''){
						$comment = $valcancel["admin_status"].'<br>'.$valcancel["admin_comment"].'<br>'.$valcancel["admin_dated"];
					}else{
						$comment = $valcancel["admin_status"];
					}
					?>
                    <td><?php echo $comment;?></td>
                  </tr>
                  <?php }?>
                  <tr>
                  
                    <td colspan="7"><?php
                    if($num==0){
                    ?>
                    <table width="100%">
                  <tr>
                    <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr></table>
                  <?php
                    }
                    ?></td>
                
              </tr>
                </table>
                <br/>
                </form>
                <?php //} ?>
                
                </td>
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
		
		<form id="frm" name="frm" method="post" action="single-payment.php?action=search&student_id=<?=$student_id;?>&course_id=<?=$course_id;?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="32%" align="center" valign="middle">&nbsp;</td>
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
                <td align="center" valign="middle" height="30"><a href="single-cancel-add.php?student_id=<?php echo $student_id;?>">
                <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" />
                </a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;">
                  <tr class="pedtext">
                    
                    <td width="15%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></td>
                    <td width="16%" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                    <td width="16%" align="center" bgcolor="#CCCCCC"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    <td width="11%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_REASON_FOR_CANCEL");?></td>
                    <td width="12%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_CD_CANCEL_STATUS");?></td>
                    <td width="13%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_ADMIN_CANCEL_STATUS");?></td>
                    <td width="7%" align="center" bgcolor="#CCCCCC"><?php echo constant("SA_REQUEST_DATE");?></td>
                  </tr>
                  <?php
				  	 $num=$dbf->countRows("student_cancel","student_id='$student_id'");
				  	  foreach($dbf->fetchOrder("student_cancel","student_id='$student_id'") as $valcancel) {
					  $res_student = $dbf->strRecordID("student","*","id='$valcancel[student_id]'");
					  $dtls = $dbf->strRecordID("student_group_dtls","*","student_id='$valcancel[student_id]'");
					  $group = $dbf->strRecordID("student_group","*","id='$dtls[parent_id]'");
					  
				  ?>
                  <tr>
                    
                    <td align="right" valign="middle" class="shop2"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                    <td align="right" valign="middle" class="shop2">
					<?php echo $dbf->getDataFromTable("course","name","id='$group[course_id]'");?></td>
                    <td align="right"><?php echo $res_student[student_mobile];?></td>
                    <td align="right"><?php echo $valcancel[comment];?></td>
                    <?php
					if($valcancel["cd_comment"]!=''){
						$comment = $valcancel["cd_status"].'<br>'.$valcancel["cd_comment"].'<br>'.$valcancel["cd_dated"];
					}else{
						$comment = $valcancel["cd_status"];
					}
					?>
                    <td align="right"><?php echo $comment;?></td>
                    <?php
					if($valcancel["admin_comment"]!=''){
						$comment = $valcancel["admin_status"].'<br>'.$valcancel["admin_comment"].'<br>'.$valcancel["admin_dated"];
					}else{
						$comment = $valcancel["admin_status"];
					}
					?>
                    <td align="right"><?php echo $comment;?></td>
                    <td height="28" align="right"><?php echo $valcancel[dated];?></td>
                  </tr>
                  <?php }?>
                  <tr>
                  
                    <td colspan="7"><?php
                    if($num==0){
                    ?>
                    <table width="100%">
                  <tr>
                    <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr></table>
                  <?php
                    }
                    ?></td>
                
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
<?php }?>
</body>
</html>
