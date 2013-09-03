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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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
          2: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
<!--*******************************************************************-->

<script type="text/javascript">
function errorconfirm()
{
	alert("Record can't be deleted as it has been used in the other part of Application.")
}
function errorconfirm_edit()
{
	alert("Record can't be edit as it has been used in the other part of Application.")
}
</script>

</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
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
<body onload="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_COMM_SETUP");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="home.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
			  <tr>
                <td bgcolor="#FFFFFF" align="center" valign="top">
                <form action="comments_process.php?action=insert" name="frm" method="post" id="frm">
                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="20%" height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_ATTEND");?></td>
                    <td width="7%" align="center" valign="middle" class="leftmenu"><?php echo constant("ADMIN_COMMENTS_MANAGE_POINTS");?></td>
                    <td width="73%" align="left" valign="middle" class="leftmenu"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att1" type="text" class="new_textbox40" id="att1" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Attendance'");?>
                    <td height="35" align="left" valign="top"><textarea name="attc1" id="attc1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att2" type="text" class="new_textbox40" id="att2" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Attendance'");?>
                    <td height="35" align="left" valign="top"><textarea name="attc2" id="attc2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att3" type="text" class="new_textbox40" id="att3" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Attendance'");?>
                    <td height="35" align="left" valign="top"><textarea name="attc3" id="attc3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att4" type="text" class="new_textbox40" id="att4" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Attendance'");?>
                    <td height="35" align="left" valign="top"><textarea name="attc4" id="attc4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="top"><input name="att5" type="text" class="new_textbox40" id="att5" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Attendance'");?>
                    <td height="40" align="left" valign="top"><textarea name="attc5" id="attc5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("STUDENT_PROGRESS_REPORT_PARTICIPATION");?></td>
                    <td align="center" valign="middle"><input name="part1" type="text" class="new_textbox40" id="part1" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Participation'");?>
                    <td height="40" align="left" valign="middle"><textarea name="part1" id="part1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="part2" type="text" class="new_textbox40" id="part2" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Participation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="part2" id="part2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Participation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="part3" id="part3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Participation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="part4" id="part4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Participation'");?>
                    <td height="40" align="left" valign="middle"><textarea name="part5" id="part5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_PED_HOMEWORK");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Homework'");?>
                    <td height="40" align="left" valign="middle"><textarea name="home1" id="home1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Homework'");?>
                    <td height="35" align="left" valign="middle"><textarea name="home2" id="home2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Homework'");?>
                    <td height="35" align="left" valign="middle"><textarea name="home3" id="home3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Homework'");?>
                    <td height="35" align="left" valign="middle"><textarea name="home4" id="home4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Homework'");?>
                    <td height="40" align="left" valign="middle"><textarea name="home5" id="home5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_FLUENCY");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Fluency'");?>
                    <td height="40" align="left" valign="middle"><textarea name="flu1" id="flu1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Fluency'");?>
                    <td height="35" align="left" valign="middle"><textarea name="flu2" id="flu2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Fluency'");?>
                    <td height="35" align="left" valign="middle"><textarea name="flu3" id="flu3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Fluency'");?>
                    <td height="35" align="left" valign="middle"><textarea name="flu4" id="flu4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Fluency'");?>
                    <td height="40" align="left" valign="middle"><textarea name="flu5" id="flu5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_PRONOUN");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Pronunciation'");?>
                    <td height="40" align="left" valign="middle"><textarea name="pro1" id="pro1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Pronunciation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="pro2" id="pro2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Pronunciation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="pro3" id="pro3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Pronunciation'");?>
                    <td height="35" align="left" valign="middle"><textarea name="pro4" id="pro4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Pronunciation'");?>
                    <td height="40" align="left" valign="middle"><textarea name="pro5" id="pro5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_GRAMMER");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Grammer'");?>
                    <td height="40" align="left" valign="middle"><textarea name="gra1" id="gra1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Grammer'");?>
                    <td height="35" align="left" valign="middle"><textarea name="gra2" id="gra2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Grammer'");?>
                    <td height="35" align="left" valign="middle"><textarea name="gra3" id="gra3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Grammer'");?>
                    <td height="35" align="left" valign="middle"><textarea name="gra4" id="gra4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Grammer'");?>
                    <td height="40" align="left" valign="middle"><textarea name="gra5" id="gra5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_VOCABU");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Vocabulary'");?>
                    <td height="40" align="left" valign="middle"><textarea name="voc1" id="voc1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Vocabulary'");?>
                    <td height="35" align="left" valign="middle"><textarea name="voc2" id="voc2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Vocabulary'");?>
                    <td height="35" align="left" valign="middle"><textarea name="voc3" id="voc3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Vocabulary'");?>
                    <td height="35" align="left" valign="middle"><textarea name="voc4" id="voc4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Vocabulary'");?>
                    <td height="40" align="left" valign="middle"><textarea name="voc5" id="voc5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="3" align="center" valign="middle" bgcolor="#AAAAAA"></td>
                    </tr>
                  <tr>
                    <td height="25" align="center" valign="middle" class="leftmenu"><?php echo constant("TEACHER_REPORT_TEACHER_COMPREHENSION");?></td>
                    <td align="center" valign="middle"><input name="textfield6" type="text" class="new_textbox40" id="textfield6" value="1" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='1' And type='Comprehension'");?>
                    <td height="40" align="left" valign="middle"><textarea name="comp1" id="comp1" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield7" type="text" class="new_textbox40" id="textfield7" value="2" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='2' And type='Comprehension'");?>
                    <td height="35" align="left" valign="middle"><textarea name="comp2" id="comp2" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield8" type="text" class="new_textbox40" id="textfield8" value="3" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='3' And type='Comprehension'");?>
                    <td height="35" align="left" valign="middle"><textarea name="comp3" id="comp3" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield9" type="text" class="new_textbox40" id="textfield9" value="4" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='4' And type='Comprehension'");?>
                    <td height="35" align="left" valign="middle"><textarea name="comp4" id="comp4" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td align="center" valign="middle"><input name="textfield10" type="text" class="new_textbox40" id="textfield10" value="5" /></td>
                    <?php $res_com = $dbf->strRecordID("comment","*","id='5' And type='Comprehension'");?>
                    <td height="35" align="left" valign="middle"><textarea name="comp5" id="comp5" style="width:550px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $res_com["comment"];?></textarea></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1" border="0" align="left" /></td>
                  </tr>
                </table>
                </form>
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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
</body>
</html>