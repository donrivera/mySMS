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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];

if($_REQUEST['action'] == 'delete1'){
	$dbf->deleteFromTable("transfer_student_to_student", "id='$_REQUEST[del_id]'");
	$dbf->deleteFromTable("transfer_student_to_student_dtls", "parent_id='$_REQUEST[del_id]'");
	header("Location:single-transfer.php?student_id=$student_id");
	exit;
}
if($_REQUEST['action'] == 'delete2'){
	$dbf->deleteFromTable("transfer_different_centre", "id='$_REQUEST[del_id]'");
	$dbf->deleteFromTable("transfer_different_centre_dtls", "parent_id='$_REQUEST[del_id]'");
	header("Location:single-transfer.php?student_id=$student_id");
	exit;
}
if($_REQUEST['action'] == 'delete3'){
	$dbf->deleteFromTable("transfer_centre_to_centre", "id='$_REQUEST[del_id]'");
	$dbf->deleteFromTable("transfer_centre_to_centre_dtls", "parent_id='$_REQUEST[del_id]'");
	header("Location:single-transfer.php?student_id=$student_id");
	exit;
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
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
            <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
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
                  <?php if($student["student_id"] > 0) { ?>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                  </tr>
                  <?php } ?>
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
                <td align="left" class="pedtext" style="padding-top:3px; padding-bottom:3px;">Student - To-  Student Transfer</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle" height="30">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th width="4%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    <th width="9%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="12%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="15%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="6%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                    <th width="15%" align="left" valign="middle" bgcolor="#ccc" class="pedtext">Student Name</th>
                    <th width="26%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                    <th width="9%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="4%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
              <?php					
					$i = 1;
					$color = "#ECECFF";					
					foreach($dbf->fetchOrder('transfer_student_to_student m,transfer_student_to_student_dtls d',"m.id=d.parent_id And d.student_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","m.*") as $transfer){
					
					//No. of students has been transfer
					$noofstudent = $dbf->countRows("transfer_student_to_student_dtls","parent_id='$transfer[id]'");
					
					//Name of the students
					$student = '';
					foreach($dbf->fetchOrder('transfer_student_to_student_dtls',"parent_id='$transfer[id]'","") as $dtls){
						if($student == ''){
							$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}else{
							$student = $student.'<br>'.$dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}
					}
					
					$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
					$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
					
					$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
					$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
					?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete1&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>
                    <?php
                        $numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
                        $i = $i + 1;
                        if($color=="#ECECFF"){
                          $color = "#FBFAFA";
                        }else{
                          $color="#ECECFF";
                        }
                  }
                  ?>
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
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="pedtext">Student - To - Center Transfer</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle" height="30">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th width="3%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    <th width="11%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="8%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                    <th width="9%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="10%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                    <th width="10%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="4%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                    <th width="14%" align="left" valign="middle" bgcolor="#ccc" class="pedtext">Student Name(s)</th>
                    <th width="16%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                    <th width="8%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="7%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php					
                        $i = 1;
                        $color = "#ECECFF";                        
                        foreach($dbf->fetchOrder('transfer_different_centre m,transfer_different_centre_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","*") as $transfer){
                        
                        //No. of students has been transfer
                        $noofstudent = $dbf->countRows("transfer_different_centre_dtls","parent_id='$transfer[id]'");
                        
                        //Name of the students
						$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");

                        $centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
                        $centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
                        
                        $from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
						$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
						
                        $to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
						$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
                        ?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete2&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>
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
              <tr>
                <td>&nbsp;</td>
                <td class="pedtext">Center - To - Center Transfer</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle" height="30">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="middle">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th width="5%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    <th width="12%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="11%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                    <th width="11%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="12%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                    <th width="12%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="18%" align="left" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                    <th width="12%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="7%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php					
                        $i = 1;
                        $color = "#ECECFF";                        
                        foreach($dbf->fetchOrder('transfer_centre_to_centre m,transfer_centre_to_centre_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","m.*") as $transfer){
                                                
						//Name of the students
						$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						                        
                        $centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
                        $centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
                        
                        $from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
						$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
						
                        $to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
						$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
                        ?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($froup_from["id"]);?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete3&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>
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
                </table>
                </td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="middle">&nbsp;</td>
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
            <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
              </tr>
              <tr>
                
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
                    <td height="22" align="left" valign="middle" class="pedtext">&nbsp;: Add Date</td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>                
                <td align="center" valign="middle"><?php echo $dbf->VVIP_Big_Icon($_REQUEST["student_id"]);?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
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
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" class="pedtext" style="padding-top:3px; padding-bottom:3px;"><?php echo $Arabic->en2ar('Student - To-  Student Transfer');?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>                
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th width="4%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    <th width="9%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="21%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?>&nbsp;</th>
                    <th width="18%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
                    <th width="7%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                    <th width="15%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="13%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="9%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="4%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    </tr>
                  </thead>
              <?php					
					$i = 1;
					$color = "#ECECFF";					
					foreach($dbf->fetchOrder('transfer_student_to_student m,transfer_student_to_student_dtls d',"m.id=d.parent_id And d.student_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","m.*") as $transfer){
					
					//No. of students has been transfer
					$noofstudent = $dbf->countRows("transfer_student_to_student_dtls","parent_id='$transfer[id]'");
					
					//Name of the students
					$student = '';
					foreach($dbf->fetchOrder('transfer_student_to_student_dtls',"parent_id='$transfer[id]'","") as $dtls){
						if($student == ''){
							$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}else{
							$student = $student.'<br>'.$dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						}
					}
					
					$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
					$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
					
					$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
					$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
					?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                                        
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete1&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?>&nbsp;</td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                    <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                    <?php
                        $numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
                        $i = $i + 1;
                        if($color=="#ECECFF"){
                          $color = "#FBFAFA";
                        }else{
                          $color="#ECECFF";
                        }
                  }
                  ?>
                  </tr>              
            </table>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" valign="middle" height="30" class="pedtext" style="padding-top:3px; padding-bottom:3px;"><?php echo $Arabic->en2ar('Center - To - Center Transfer');?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="left" valign="top">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>                    
                    <th width="7%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    <th width="8%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="16%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                    <th width="14%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
                    <th width="4%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                    <th width="10%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="10%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                    <th width="9%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="8%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                    <th width="11%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="3%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    </tr>
                  </thead>
                  <?php					
                        $i = 1;
                        $color = "#ECECFF";                        
                        foreach($dbf->fetchOrder('transfer_different_centre m,transfer_different_centre_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","*") as $transfer){
                        
                        //No. of students has been transfer
                        $noofstudent = $dbf->countRows("transfer_different_centre_dtls","parent_id='$transfer[id]'");
                        
                        //Name of the students
						$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");

                        $centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
                        $centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
                        
                        $from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
						$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
						
                        $to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
						$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
                        ?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete2&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>                    
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $student;?></td>
                    <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
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
                </table>
                </td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>                
                <td align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" valign="middle" height="30" class="pedtext" style="padding-top:3px; padding-bottom:3px; padding-right:2px;"><?php echo $Arabic->en2ar('Center - To - Center Transfer');?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                
                <td colspan="4" align="left" valign="middle">
                <table width="99%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr>
                    <th width="7%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    <th width="12%" align="center" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                    <th width="18%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                    <th width="12%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TOGROUP");?></th>
                    <th width="12%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_TO");?></th>
                    <th width="11%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROMGROUP");?></th>
                    <th width="11%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_CENTER_FROM");?></th>
                    <th width="12%" align="right" valign="middle" bgcolor="#ccc" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                    <th width="5%" height="25" align="center" valign="middle" bgcolor="#ccc">&nbsp;</th>
                    </tr>
                  </thead>
                  <?php					
                        $i = 1;
                        $color = "#ECECFF";                        
                        foreach($dbf->fetchOrder('transfer_centre_to_centre m,transfer_centre_to_centre_dtls d',"m.id=d.parent_id And d.student_id='$student_id' And m.centre_id='$_SESSION[centre_id]'","m.id DESC ","m.*") as $transfer){
                                                
						//Name of the students
						$student = $dbf->getDataFromTable("student","first_name","id='$dtls[student_id]'");
						                        
                        $centre_from= $dbf->getDataFromTable("centre","name","id='$transfer[centre_from]'");
                        $centre_to = $dbf->getDataFromTable("centre","name","id='$transfer[centre_to]'");
                        
                        $from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
						$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
						
                        $to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
						$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
                        ?>
                  <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    
                    <td align="center" valign="middle" >
                    <?php if($transfer["status"] == 'Pending'){?>
                    <a href="single-transfer.php?action=delete3&student_id=<?php echo $student_id;?>&del_id=<?php echo $transfer[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a>
                    <?php } ?>
                    </td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_to;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $centre_from;?></td>
                    <td align="right" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>                    
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
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
                </table>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="left" valign="middle">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</form></td>
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
