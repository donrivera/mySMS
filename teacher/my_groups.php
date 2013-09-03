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

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_SESSION['ALERT_DISPLAY'] == ''){
$alert_count = $dbf->countRows("alerts", "teacher='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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
<!--TABLE SORTER-->

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!-- POP UP modal box -->
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.2.js"></script>
<link rel="stylesheet" href="../fancybox/jquery.fancybox-1.3.2.css" type="text/css" media="screen" />
<!-- POP UP modal box -->

</head>
<script language="JavaScript"> 
function show_a(row){
	 var d = "diva"+row;
	 if(document.getElementById(d).style.display == 'none'){
		 document.getElementById(d).style.display = '';
	 }else if(document.getElementById(d).style.display == ''){
		 document.getElementById(d).style.display = 'none';
	 }
 }
 
function validate(row){
	 var d = "msg"+row;
	 if(document.getElementById(d).value == ''){
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

var x = <?php echo $alert_count; ?>;
$(function(){
	if(x > 0){
	//var res="<div style='width:300px;height:200px;border:2px solid red;'class='post_review_main'> bye bye</div>";
	$.post("alert_page.php",{"choice":"alert_respose"},function(res){
		$.fancybox(res,{centerOnScroll:true,hideOnOverlayClick:false});
	});	
	}
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds

// Alert set 1 time by session
$_SESSION['ALERT_DISPLAY'] = 'TRUE';
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("TEACHER_MY_GROUPS_MYGROUPS");?></td>
                <td width="22%" id="lblname">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td height="15" colspan="3" align="center" valign="middle" >&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25" align="center" valign="middle" >&nbsp;</td>
                  <td height="25" align="left" valign="middle">
                    
                    <table width="450" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#FF6600" >
                      <tr>
                        <td width="12%" align="center" valign="middle" bgcolor="#F8F9FB" class="leftmenu"><?php echo constant("TEACHER_MY_GROUPS_NOTE");?> :</td>
                        <td width="30" align="center" valign="middle" class="contenttext" style="background-color:#FF0000;">&nbsp;</td>
                        <td width="26%" align="left" valign="middle" class="leftmenu" style="padding-left:5px;background-color:#F8F9FB;"><?php echo constant("TEACHER_MY_GROUPS_RED");?></td>
                        <td width="30" align="center" valign="middle" class="contenttext" style="padding-left:5px;background-color:orange;">&nbsp;</td>
                        <td width="25%" align="left" valign="middle" bgcolor="#F8F9FB" class="leftmenu" style="padding-left:5px;"><?php echo constant("TEACHER_MY_GROUPS_GREEN");?></td>
                        <td width="30" align="left" valign="middle" class="contenttext" style="padding-left:5px;background-color:#009900;">&nbsp;</td>
                        <td width="19%" align="left" valign="middle" bgcolor="#F8F9FB" class="leftmenu" style="padding-left:5px;"><?php echo constant("TEACHER_MY_GROUPS_COMPLETED");?></td>
                        </tr>
                      </table></td>
                  <td align="center" valign="middle" style="padding-left:5px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="5" colspan="3" align="center" valign="middle"></td>
                  </tr>
                <tr>
                  <td width="4%" height="25" align="center" valign="middle" >&nbsp;</td>
                  <td width="91%" height="25" align="center" valign="middle"  >
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA" class="tablesorter">
                      <thead>
                        <tr class="logintext">
                          <th width="4%" height="25" align="center" valign="middle">&nbsp;</th>
                          <th width="41%" align="left" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_GROUPNM");?></th>
                          <th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_TEXT");?></th>
                          <th width="16%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_NOUNIT");?></th>
                          <th width="10%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_CLASSROOM");?></th>
                          <th width="8%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></th>
                          </tr>
                        </thead>
                      <?php
					$color1 = "#ECECFF";
					$i = 1;
					
					//Get number of rows
                    $num=$dbf->countRows('student_group',"teacher_id='$_SESSION[uid]'","");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group',"teacher_id='$_SESSION[uid]'","id","") as $val){
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Get group name
					$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get units no
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");

					//Get Classroom Number
					$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
					
					?>
                      <tr  bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                        <td align="center" valign="middle"  class="contenttext"><?php echo $i;?></td>
                        <td height="22" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($val["id"]);?></td>
                        <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                        <td align="center" valign="middle"  class="contenttext" style="padding-left:5px;">
                          <?php echo $val_unit[name];?>&nbsp;<?php echo constant("TEACHER_MY_SCHEDULES_PERDAY");?></td>
                        <?php					
						$dt = "Starting from ".date("l",strtotime($val[start_date]))." - ".date("d-M-Y",strtotime($val[start_date]));
						$dt = $dt." - ".date("d-M-Y",strtotime($val[end_date]));//." - ".$val[group_time];
							
						if($val[room_id] != "0"){
							$no = $val_room["name"];
						}
						?>
                        <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $no;?></td>
                        <!-- Status --#009900 -->
                        <?php
					  if($val[status]=="Completed"){
						  $color = "#009900";
					  }else if($val[status]=="Continue"){
						  $color = "#FFA500";
					  }else{
						  $color = "#FF0000";
					  }
					  ?>
                        <td align="center" valign="middle" class="contenttext" style="padding-left:5px;">
                          <table width="20" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
                            <tr>
                              <td align="center" valign="middle" style="background-color:<?php echo $color;?>">&nbsp;</td>
                              </tr>
                            </table>                     
                          </td>
                        <?php
						  $i = $i + 1;
						  
						  if($color1=="#ECECFF"){
							  $color1 = "#FBFAFA";
						  }else{
							  $color1="#ECECFF";
						  }					  
					  }
					  ?>
                        </tr>
                      <?php
					if($num==0){
					}
					?>
                      </table></td>
                  <td width="5%" align="center" valign="middle" >&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25" colspan="3" align="center" valign="middle" class="contenttext">&nbsp;</td>
                  
                  </tr>
                <?php
					if($num==0){
					?>
                <tr>
                  <td height="25" colspan="3" align="center" valign="middle" class="nametext1"><?php echo constant("TEACHER_MY_GROUPS_ERRORMSG");?></td>
                  </tr>
                <?php
					}
					?>
                </table></td>
          </tr>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="right" valign="middle" class="logintext"><?php echo constant("TEACHER_MY_GROUPS_MYGROUPS");?>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="200" align="left" valign="top">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td height="15" colspan="3" align="center" valign="middle" >&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25" align="center" valign="middle" >&nbsp;</td>
                  <td height="25" align="right" valign="middle">
                    
                    <table width="450" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#FF6600" >
                      <tr>
                        <td width="19%" align="left" valign="middle" bgcolor="#F8F9FB" class="leftmenu" style="padding-left:5px;"><?php echo constant("TEACHER_MY_GROUPS_COMPLETED");?></td>
                        <td width="30" align="left" valign="middle" class="contenttext" style="padding-left:5px;background-color:#009900;">&nbsp;</td>
                        <td width="25%" align="left" valign="middle" bgcolor="#F8F9FB" class="leftmenu" style="padding-left:5px;"><?php echo constant("TEACHER_MY_GROUPS_GREEN");?></td>
                        <td width="30" align="center" valign="middle" class="contenttext" style="padding-left:5px;background-color:orange;">&nbsp;</td>
                        <td width="26%" align="left" valign="middle" class="leftmenu" style="padding-left:5px;background-color:#F8F9FB;"><?php echo constant("TEACHER_MY_GROUPS_RED");?></td>
                        <td width="30" align="center" valign="middle" class="contenttext" style="background-color:#FF0000;">&nbsp;</td>
                        <td width="12%" align="center" valign="middle" bgcolor="#F8F9FB" class="leftmenu"><?php echo constant("TEACHER_MY_GROUPS_NOTE");?></td>
                        </tr>
                      </table></td>
                  <td align="center" valign="middle" style="padding-left:5px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="5" colspan="3" align="center" valign="middle"></td>
                  </tr>
                <tr>
                  <td width="4%" height="25" align="center" valign="middle" >&nbsp;</td>
                  <td width="91%" height="25" align="center" valign="middle"  >
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#AAAAAA" class="tablesorter">
                      <thead>
                        <tr class="logintext">
                          <th width="8%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></th>
                          <th width="10%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_CLASSROOM");?></th>
                          <th width="16%" align="center" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_NOUNIT");?></th>
                          <th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_TEXT");?></th>
                          <th width="41%" align="left" valign="middle" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_GROUPNM");?></th>
                          <th width="4%" height="25" align="center" valign="middle">&nbsp;</th>
                          </tr>
                        </thead>
                      <?php
					$color1 = "#ECECFF";
					$i = 1;
					
					//Get number of rows
                    $num=$dbf->countRows('student_group',"teacher_id='$_SESSION[uid]'","");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group',"teacher_id='$_SESSION[uid]'","id","") as $val){
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Get group name
					$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get units no
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");

					//Get Classroom Number
					$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
					$dt = "Starting from ".date("l",strtotime($val[start_date]))." - ".date("d-M-Y",strtotime($val[start_date]));
					$dt = $dt." - ".date("d-M-Y",strtotime($val[end_date]));//." - ".$val[group_time];
						
					if($val[room_id] != "0"){
						$no = $val_room["name"];
					}
					if($val[status]=="Completed"){
						  $color = "#009900";
					  }else if($val[status]=="Continue"){
						  $color = "#FFA500";
					  }else{
						  $color = "#FF0000";
					  }					
					?>
                      <tr  bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                        
                        <td align="center" valign="middle" class="contenttext" style="padding-left:5px;">
                          <table width="20" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
                            <tr>
                              <td align="center" valign="middle" style="background-color:<?php echo $color;?>">&nbsp;</td>
                              </tr>
                            </table>                     
                          </td>
                          <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $no;?></td>
                          <td align="center" valign="middle"  class="contenttext">
                          <?php echo constant("TEACHER_MY_SCHEDULES_PERDAY");?>&nbsp;<?php echo $val_unit[name];?>
                        </td>
                          <td align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                          <td height="22" align="left" valign="middle"  class="contenttext" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($val["id"]);?></td>
                          <td align="center" valign="middle"  class="contenttext"><?php echo $i;?></td>
                        <?php
						  $i = $i + 1;
						  
						  if($color1=="#ECECFF"){
							  $color1 = "#FBFAFA";
						  }else{
							  $color1="#ECECFF";
						  }					  
					  }
					  ?>
                        </tr>
                      <?php
					if($num==0){
					}
					?>
                      </table></td>
                  <td width="5%" align="center" valign="middle" >&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25" colspan="3" align="center" valign="middle" >&nbsp;</td>
                  
                  </tr>
                <?php
					if($num==0){
					?>
                <tr>
                  <td height="25" colspan="3" align="center" valign="middle" class="nametext1"><?php echo constant("TEACHER_MY_GROUPS_ERRORMSG");?></td>
                  </tr>
                <?php
					}
					?>
                </table></td>
          </tr>
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
