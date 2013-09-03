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
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
          4: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
          0: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php } ?>
<!--*******************************************************************-->
<script type="text/javascript">  
function errorconfirm(){
	alert("Record can't be deleted as it has been used in the other part of Application.")
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
<body onload="countdown_init(<?php echo $count;?>);">
 <?php if($_SESSION['lang']=='EN'){?>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_MANAGE_STUDENT_APPOINTMENT");?> </td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="student_appoint_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" >
			<form name="frm" id="frm" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%" height="22" align="center" valign="middle"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10%" align="left" valign="middle">Note :</td>
                    <td width="5%" align="left" valign="middle" bgcolor="#FF0000" style="border:solid 1px;">&nbsp;</td>
                    <td width="39%" align="left" valign="middle" class="mycon">&nbsp;Appointment Pending</td>
                    <td width="5%" align="left" valign="middle" bgcolor="#3366FF" style="border:solid 1px;">&nbsp;</td>
                    <td width="41%" align="left" valign="middle" class="mycon">&nbsp;Appointment Finished</td>
                  </tr>
                </table></td>
                <td width="8%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="26%">&nbsp;</td>
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
                <td height="22" align="center" valign="middle">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="56%" align="right" valign="middle">Display only future appointment</td>
                    <td width="27%" align="left" valign="middle">
                    <?php if($_REQUEST["future"] == "1"){
						$is_future = "0";
					}else{
						$is_future = "1";
					}
					?>
                    <input type="checkbox" name="future" id="future" value="<?php echo $is_future;?>" <?php if($_REQUEST["future"]=="1"){?> checked="checked" <?php }?> />
                    </td>
                    <td width="17%" align="right" valign="middle">Note :</td>
                  </tr>
                </table>                
                </td>
                <td align="center" valign="middle">
                <select name="status" id="status" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; border:solid 1px;">
                <option value="Both" <?php if($_REQUEST["status"] == "Both"){?> selected="selected" <?php }?>>Both</option>
                <option value="Red" <?php if($_REQUEST["status"] == "Red"){?> selected="selected" <?php }?>>Red</option>
                <option value="Blue" <?php if($_REQUEST["status"] == "Blue"){?> selected="selected" <?php }?>>Blue</option>
                </select></td>
                <td align="left" valign="middle"><input type="submit" value="Search" class="btn_yes" border="0" align="left" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			  <thead>
              <tr class="logintext">
                <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?> </th>
			    <th width="30%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
				<th width="39%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></th>
                <th colspan="5" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("COMMON_ACTION");?></th>
              </tr>
			  </thead>
              <?php			
				$i = 1;
				$color="#ECECFF";
				$dated = date('Y-m-d');
				if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Red"){
					$cond = " And dated > '$dated' And action_status='0'";
				}else if($_REQUEST["future"] == "" && $_REQUEST["status"] == "Red"){
					$cond = " And action_status='0'";
				}else if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Blue"){
					$cond = " And dated > '$dated' And action_status='1'";
				}else if($_REQUEST["future"] == "" && $_REQUEST["status"] == "Blue"){
					$cond = " And action_status='1'";					
				}else if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Both"){
					$cond = " And dated > '$dated'";
				}else{
					$cond = "";
				}
				$num=$dbf->countRows('student_appointment',"user_id='$_SESSION[id]' And centre_id='$_SESSION[centre_id]'".$cond);
				foreach($dbf->fetchOrder('student_appointment',"user_id='$_SESSION[id]' And centre_id='$_SESSION[centre_id]'".$cond,"dated DESC") as $val) {
				$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
				?>
                
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" >
                <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[dated];?></td>
				  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $res[id];?>" style="cursor:pointer;"><?php echo $res[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></a></td>
				    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[comments];?></td>
				    <td width="4%" align="center" valign="middle">
                    <?php
					if($val["action_status"] == 0){
						$bg = '#FF0000';
						$title = 'Appointment Pending';
					}else{
						$bg = '#0066FF';
						$title = 'Appointment Finished';
					}
					?>
                    <a href="student_appoint_process.php?action=setstatus&aid=<?php echo $val["id"];?>">
                    <table width="50%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
				      <tr>
				        <td height="5" align="center" valign="middle" bgcolor="<?php echo $bg;?>" title="<?php echo $title;?>"></td>
				        </tr>
				    </table>
                    </a>
                    </td>
				    <td width="5%" align="center" valign="middle"><?php if($val["status"]==0) { ?>
				      <a href="student_appoint_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User." /></a>
				      <?php } else { ?>
				      <a href="student_appoint_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User." /></a>
				      <?php } ?></td>
				    <td width="4%" align="center" valign="middle"><a href="student_appoint_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
          				
				<td width="4%" align="center" valign="middle"><a href="student_appoint_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
			<?php
            if($num!=0){
            ?>              
          <tr>
            <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
			   <?php
			   }
				if($num==0){
				?>
              <tr>
                <td height="25" colspan="6" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?>  </td>
              </tr>
              <?php
				}
				?>
              </table></td>
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
<?php } else {?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top" style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                 <td width="8%" align="right"><a href="student_appoint_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
               
                  <td width="54%" height="30" align="right" class="logintext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_MANAGE_STUDENT_APPOINTMENT");?> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" >
			<form name="frm" id="frm" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%" height="22" align="center" valign="middle">&nbsp;</td>
                <td width="8%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td width="36%" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="41%" align="right" valign="middle" class="mycon"><?php echo $Arabic->en2ar('Appointment Finished');?>&nbsp;</td>
                    <td width="5%" align="left" valign="middle" bgcolor="#3366FF" style="border:solid 1px;">&nbsp;</td>
                    <td width="39%" align="right" valign="middle" class="mycon"><?php echo $Arabic->en2ar('Appointment Pending');?>&nbsp;</td>
                    <td width="5%" align="left" valign="middle" bgcolor="#FF0000" style="border:solid 1px;">&nbsp;</td>
                    <td width="11%" align="left" valign="middle">&nbsp;: <?php echo $Arabic->en2ar('Note');?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="22" align="center" valign="middle">
                
                                
                </td>
                <td align="left" valign="middle">&nbsp;</td>
                <td align="right" valign="middle"><input type="submit" value="<?php echo RE_MENU_SEARCH ?>" class="btn_no" border="0" align="left" /></td>
                <td align="right" valign="middle">
                <select name="status" id="status" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; border:solid 1px;">
                <option value="Both" <?php if($_REQUEST["status"] == "Both"){?> selected="selected" <?php }?>>Both</option>
                <option value="Red" <?php if($_REQUEST["status"] == "Red"){?> selected="selected" <?php }?>>Red</option>
                <option value="Blue" <?php if($_REQUEST["status"] == "Blue"){?> selected="selected" <?php }?>>Blue</option>
                </select>
                </td>
                <td align="left" valign="middle">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="17%" align="left" valign="middle">&nbsp;<?php echo $Arabic->en2ar(': Note');?></td>
                    
                    <td width="12%" align="right" valign="middle">
                    <?php if($_REQUEST["future"] == "1"){
						$is_future = "0";
					}else{
						$is_future = "1";
					}
					?>
                   <input type="checkbox" name="future" id="future" value="<?php echo $is_future;?>" <?php if($_REQUEST["future"]=="1"){?> checked="checked" <?php }?> />
                    </td>
                    <td width="71%" align="left" valign="middle"><?php echo $Arabic->en2ar('Display only future appointment');?></td>
                  </tr>
                </table>
                
                </td>
              </tr>
            </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			  <thead>
              <tr class="logintext">
                <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo COMMON_ACTION;?></th>
			    <th width="32%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;">
				<?php echo RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT;?></th>
				<th width="35%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;">
				<?php echo RECEPTION_S_MANAGE_STUDENTNAME;?></th>                
                <th width="11%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;">
				<?php echo RECEPTION_STUDENT_APPOINT_MANAGE_DATE;?> </th>
                <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
              </tr>
			  </thead>
              <?php			
				$i = 1;
				$color="#ECECFF";
				
				$dated = date('Y-m-d');
				if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Red"){
					$cond = " And dated > '$dated' And action_status='0'";
				}else if($_REQUEST["future"] == "" && $_REQUEST["status"] == "Red"){
					$cond = " And action_status='0'";
				}else if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Blue"){
					$cond = " And dated > '$dated' And action_status='1'";
				}else if($_REQUEST["future"] == "" && $_REQUEST["status"] == "Blue"){
					$cond = " And action_status='1'";					
				}else if($_REQUEST["future"] == "1" && $_REQUEST["status"] == "Both"){
					$cond = " And dated > '$dated'";
				}else{
					$cond = "";
				}
				
				$num=$dbf->countRows('student_appointment',"user_id='$_SESSION[id]' And centre_id='$_SESSION[centre_id]'".$cond);
				foreach($dbf->fetchOrder('student_appointment',"user_id='$_SESSION[id]' And centre_id='$_SESSION[centre_id]'".$cond,"dated DESC") as $val) {
				$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
				?>
                
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='student_appoint_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                <td width="4%" align="center" valign="middle"><?php if($val["status"]==0) { ?>
                <a href="student_appoint_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="<?php echo $Arabic->en2ar('Click to de-active the User');?>" /></a>
                <?php } else { ?>
                <a href="student_appoint_process.php?action=unblock&amp;id=<?php echo $val["id"];?>"><img src="../images/block.png" width="16" height="16" border="0" title="<?php echo $Arabic->en2ar('Click to Active the User');?>" /></a>
                <?php } ?></td>
				<td width="5%" align="center" valign="middle"><a href="student_appoint_edit.php?id=<?php echo $val["id"];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="<?php echo EDIT?>" /></a></td>          				
				<td width="4%" align="center" valign="middle"><a href="student_appoint_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
				<td width="4%" align="center" valign="middle">                
                <?php
				if($val["action_status"] == 0){
					$bg = '#FF0000';
					$title = $Arabic->en2ar('Appointment Pending');
				}else{
					$bg = '#0066FF';
					$title = $Arabic->en2ar('Appointment Finished');
				}
				?>
				<a href="student_appoint_process.php?action=setstatus&aid=<?php echo $val["id"];?>">
				<table width="50%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
				  <tr>
					<td height="5" align="center" valign="middle" bgcolor="<?php echo $bg;?>" title="<?php echo $title;?>"></td>
					</tr>
				</table>
				</a>
                
                </td>                
				<td align="right" valign="middle" class="mycon" ><?php echo $val["comments"];?></td>
				<td align="right" valign="middle" class="mycon" >
				<a href="single-home.php?student_id=<?php echo $res["id"];?>" style="cursor:pointer;">
				<?php echo $res["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></a></td>				    
                <td align="right" valign="middle" class="mycon"><?php echo $val["dated"];?></td>
                <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
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
            </table></td>
          </tr>
			<?php
            if($num!=0){
            ?>              
          <tr>
            <td> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <?php
			   }
				if($num==0){
				?>
              <tr>
                <td height="25" colspan="6" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?>  </td>
              </tr>
              <?php
				}
				?>
        </table></td>
        <td width="2%">&nbsp;</td>
        
        <td width="19%" align="left" valign="top"><?php include 'left_menu_right.php';?></td>
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
<?php }?>
</body>
</html>
