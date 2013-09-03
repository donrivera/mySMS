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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

</head>
<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen"/>
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
          6: {  sorter: false },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 15});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
          0: {  sorter: false },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 15});
});
</script>
<?php } ?>
<!--*******************************************************************-->

</head>
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
            <td height="30" bgcolor="#FFA938" class="logintext"  style="background:url(../images/footer_repeat.png) repeat-x;padding-left:10px;"><?php echo constant("CD_AUTO_SEARCH_HEADING");?>
</td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="1" cellpadding="0" bordercolor="#000000" cellspacing="0" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
              <thead>
                <tr class="logintext">
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTNAME");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?></th>
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">Latest Status</th>
                  <th colspan="6" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
              </thead>
              <?php
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student',"family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '%$_REQUEST[testinput]%' OR student_first_name LIKE '%$_REQUEST[testinput]%' OR first_name1 LIKE '%$_REQUEST[testinput]%'");
				foreach($dbf->fetchOrder('student',"family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '%$_REQUEST[testinput]%' OR student_first_name LIKE '%$_REQUEST[testinput]%' OR first_name1 LIKE '%$_REQUEST[testinput]%'","id DESC ") as $val){
						 
					$num_comment=$dbf->countRows('student_comment',"student_id='$val[id]'");
					$valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
					
					$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$val[id]'");
					$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
					$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
			  ?>
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='s_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php if($val[student_id] > 0) { echo $val[student_id]; } ?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $moving["name"];?></td>
                <td width="4%" align="center" valign="middle" ><?php echo $dbf->VVIP_Icon($val["id"]);?></td>
                <?php
				  $numg=$dbf->countRows('student_moving',"student_id='$val[id]' And status_id='2'");
				  $num_group=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
				  ?>
                <td width="3%" align="center" valign="middle" ><a href="search_adding_group.php?student_id=<?php echo $val[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=230&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                  <?php //if($numg > 0) {?>
                  <img src="../images/group.png" width="16" height="16" border="0" title="Adding to Group">
                  <?php //} ?>
                </a></td>
                <td width="3%" align="center" valign="middle" ><a href="search_manage.php?id=<?php echo $val[id];?>">
                  <?php if($num_group > 0) { ?>
                  <img src="../images/additional.png"  border="0" title="Adding additional Information">
                  <?php } else { ?>
                  <img src="../images/ex-btn.png" width="16" height="16" border="0" title="Adding additional Information">
                  <?php } ?>
                </a></td>
                <td width="3%" align="center" valign="middle" ><?php if($num_comment!=0){?>
                  <a href="view_student_comments_history_from_manage.php?ids=<?php echo $val[id]; ?>"><img src="../images/comments.png" width="20" height="20" border="0" title="View Comments"></a>
                  <?php }else {?>
                  <img src="../images/comments-no.png" title="No comments" />
                  <?php } ?></td>
                <td width="4%" align="center" valign="middle" ><a href="s_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                <td width="4%" align="center" valign="middle" ><a href="authonication.php?student_id=<?php echo $val[id];?>" onClick="javascript:openWindow(this.href);return false;" ><img src="../images/home.png" width="16" height="16" border="0" title="Go to Student Home page"></a></td>
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
            <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
                        <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                        <select name="select" class="pagesize">
                          <option selected="selected"  value="15">15</option>
                          <option value="25">25</option>
                          <option  value="50">50</option>
                        </select>
                </div></td>
              </tr>
            </table></td>
          </tr>
              <?php
					if($num==0)
					{
					?>
              <tr>
                <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
              </tr>
              <?php
					}
					?>
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
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" align="right" valign="middle" bgcolor="#FFA938" class="logintext"  style="background:url(../images/footer_repeat.png) repeat-x;padding-left:10px;"><?php echo constant("CD_AUTO_SEARCH_HEADING");?>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" valign="top" bgcolor="#FFFFFF">
                    <table width="100%" border="1" cellpadding="0" bordercolor="#000000" cellspacing="0" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                      <thead>
                        <tr class="logintext">
                            <th colspan="6" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                            <th width="10%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:1px;"><?php echo $Arabic->en2ar('Latest Status');?></th>
                            
                            <th width="14%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_EMAILADDRESS");?></th>
                            <th width="15%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTID");?></th>
                            <th width="13%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_MOBILENO");?></th>
                            
                            <th width="21%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("STUDENT_ADVISOR_HOME_S_MANAGE_STUDENTNAME");?></th>
                            <th width="5%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                            
                          </tr>
                        </thead>
                      <?php
					$i = 1;
					$color = "#ECECFF";
					$num=$dbf->countRows('student',"family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '%$_REQUEST[testinput]%' OR student_first_name LIKE '%$_REQUEST[testinput]%'");
					foreach($dbf->fetchOrder('student',"family_name LIKE '$_REQUEST[fname]%' OR family_name1 LIKE '$_REQUEST[fname]%' OR first_name LIKE '%$_REQUEST[testinput]%' OR student_first_name LIKE '%$_REQUEST[testinput]%' OR first_name1 LIKE '%$_REQUEST[testinput]%'","id DESC ") as $val){					 
					
					$num_comment=$dbf->countRows('student_comment',"student_id='$val[id]'");
					$valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
					
					$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$val[id]'");
					$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
					$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
					$numg=$dbf->countRows('student_moving',"student_id='$val[id]' And status_id='2'");
					$num_group=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
			        ?>
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='s_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                        <td width="4%" align="center" valign="middle" ><?php echo $dbf->VVIP_Icon($val["id"]);?></td>
                        <td width="4%" align="center" valign="middle" ><a href="search_adding_group.php?student_id=<?php echo $val[id];?>&page=search_adding_group.php&amp;TB_iframe=true&amp;height=230&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox">
                          <?php //if($numg > 0) {?>
                          <img src="../images/group.png" width="16" height="16" border="0" title="Adding to Group">
                          <?php //} ?>
                          </a></td>
                        <td width="4%" align="center" valign="middle" ><a href="search_manage.php?id=<?php echo $val[id];?>">
                          <?php if($num_group > 0) { ?>
                          <img src="../images/additional.png"  border="0" title="Adding additional Information">
                          <?php } else { ?>
                          <img src="../images/ex-btn.png" width="16" height="16" border="0" title="Adding additional Information">
                          <?php } ?>
                          </a></td>
                        <td width="4%" align="center" valign="middle" ><?php if($num_comment!=0){?>
                          <a href="view_student_comments_history_from_manage.php?ids=<?php echo $val[id]; ?>"><img src="../images/comments.png" width="20" height="20" border="0" title="View Comments"></a>
                          <?php }else {?>
                          <img src="../images/comments-no.png" title="No comments" />
                          <?php } ?></td>
                        <td width="4%" align="center" valign="middle" ><a href="s_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                        <td width="4%" align="center" valign="middle" ><a href="authonication.php?student_id=<?php echo $val[id];?>" onClick="javascript:openWindow(this.href);return false;" ><img src="../images/home.png" width="16" height="16" border="0" title="Go to Student Home page"></a></td>
                        <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $moving["name"];?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php if($val[student_id] > 0) { echo $val[student_id]; } ?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
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
                  </tr>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                      <td width="76%" height="25" align="center">&nbsp;</td>
                      <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
                        <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                        <select name="select" class="pagesize">
                          <option selected="selected"  value="15">15</option>
                          <option value="25">25</option>
                          <option  value="50">50</option>
                          </select>
                        </div></td>
                      </tr>
                    </table></td>
                  </tr>
                <?php
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
                  </tr>
                <?php
					}
					?>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
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
