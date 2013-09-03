<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
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
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          6: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<!--*******************************************************************-->

<script type="text/javascript">
function errorconfirm()
{
	alert("Record can't be deleted as it has been used in the other part of Application.")
}
</script>

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
<body onLoad="countdown_init(<?php echo $count;?>);">
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
            <td height="0" align="left" valign="middle" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_USER_MANAGE_MANAGE_USER");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="user_add.php"> <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <form id="frm" name="frm" action="">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu" ><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :&nbsp;</td>
                  <td width="160" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox140" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                  <td width="87" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :&nbsp;</td>
                  <td width="168" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox140" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                  <td width="59" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :&nbsp;</td>
                  <td width="259" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox140" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                  <td width="199" align="right" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                </tr>
              </table>
            </form>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="97%" height="30" align="left" valign="middle" class="leftmenu">Centre Directors</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_MENU_CENTRE");?></th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                        <th width="11%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                        </tr>
                      </thead>
                    <?php					
					$i = 1;
					$color = "#ECECFF";
					
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "user_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "user_name LIKE '$_REQUEST[fname]%' AND mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "user_name LIKE '$_REQUEST[fname]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "user_name LIKE '$_REQUEST[fname]%' AND mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id<>'1'";
					}
					//End 4.
					
					$num=$dbf->countRows('user', $condition);
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Center Director'","id DESC") as $val) {
						
						//Get centre name
						$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_centre[name];?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td width="8%" align="center" valign="middle">                        
						<?php if($val["user_status"]==0) { ?>                      
                        <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>">
                        <img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
						
						<?php } else { ?>
                        <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>">
                        <img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
						<?php } ?>                        
                      </td>
                      <td width="4%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                      <td width="4%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                      <?php
					  $i = $i + 1;
					  if($color=="#ECECFF") {
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
                <td height="30" align="left" valign="middle" class="leftmenu">Student Advisors</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_MENU_CENTRE");?></th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                        <th width="11%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                        </tr>
                      </thead>
                    <?php					
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Student Advisor'","id DESC") as $val) {
					
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_centre[name];?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td width="8%" align="center" valign="middle">                        
						<?php if($val["user_status"]==0) { ?>
                        
                        <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>">
                        <img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
						
						<?php } else { ?>
                        
                        <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>">
                        <img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
						<?php } ?>
                        
                      </td>
                      <td width="4%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                      <td width="4%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                      <?php
					  $i = $i + 1;
					  
					    if($color=="#ECECFF") {
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
                <td height="30" align="left" valign="middle" class="leftmenu">Teachers</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_MENU_CENTRE");?></th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                        <th width="11%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                      </tr>
                    </thead>
                    <?php
					$i = 1;
					$color = "#ECECFF";					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Teacher'","id DESC") as $val) {
						# Get All centre of a particular Teacher						
						$centre_name = '';
						foreach($dbf->fetchOrder('teacher_centre', "teacher_id='$val[uid]'","") as $centre){
							$cen = $dbf->getDataFromTable("centre", "name", "id='$centre[centre_id]'");
							if($centre_name == ''){
								$centre_name = $cen;
							}else{
								$centre_name = $centre_name.','.$cen;
							}
						}
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $centre_name;?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td width="8%" align="center" valign="middle">
                        
						<?php if($val["user_status"]==0) { ?>
                        
                        <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>">
                        <img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
						
						<?php } else { ?>
                        <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>">
                        <img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
						<?php } ?>
                        
                      </td>
                      <td width="4%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                      <?php
					  $num_sg=$dbf->countRows('student_group',"teacher_id='$val[uid]'");
					  if($num_sg > 0)
					  {
						  ?>
                          <td width="4%" align="center" valign="middle" style="background-color:<?php echo $color;?>" >
                          <img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>"  style="cursor:pointer;" onClick="errorconfirm();"/></td>
                          <?php
					  }else{
					  ?>
                      <td width="4%" align="center" valign="middle" style="background-color:<?php echo $color;?>" ><a href="user_process.php?t=t&action=delete&amp;id=<?php echo $val["id"];?>&uid=<?php echo $val["uid"];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                      <?php
					  }
					  
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
                <td height="30" align="left" valign="middle" class="leftmenu">Receptionists</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_MENU_CENTRE");?></th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                        <th width="11%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                        </tr>
                      </thead>
                    <?php		
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Receptionist'","id DESC") as $val) {
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_centre[name];?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td width="8%" align="center" valign="middle">
                        <?php if($val["user_status"]==0) { ?>
                        
                        <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>">
                        <img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
						
						<?php } else { ?>
                        
                        <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>">
                        <img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
						<?php } ?>
                        
                      </td>
                      <td width="4%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                      <td width="4%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
                <td height="30" align="left" valign="middle" class="leftmenu">Students</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_MENU_CENTRE");?></th>
                        <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                        <th width="11%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                        </tr>
                      </thead>
                    <?php					
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Student'","id DESC") as $val) {
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_centre[name];?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td width="8%" align="center" valign="middle">
                        <?php if($val["user_status"]==0) { ?><a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a><?php } else { ?><a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a><?php } ?>
                      </td>
                      <td width="4%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                      <td width="4%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
                <td height="30" align="left" valign="middle" class="leftmenu">LIS</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table2" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                      <th width="13%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                      <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                      <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                      <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php					
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='LIS'","id DESC") as $val) {
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                    <td width="5%" align="center" valign="middle"><?php if($val["user_status"]==0) { ?>
                      <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
                      <?php } else { ?>
                      <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
                      <?php } ?></td>
                    <td width="6%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                    <td width="6%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
              <tr>
                <td height="30" align="left" valign="middle" class="leftmenu">LIS Manager</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table3" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                      <th width="13%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                      <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                      <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                      <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php					
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='LIS Manager'","id DESC") as $val) {
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                    <td width="5%" align="center" valign="middle"><?php if($val["user_status"]==0) { ?>
                      <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
                      <?php } else { ?>
                      <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
                      <?php } ?></td>
                    <td width="6%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                    <td width="6%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
              <tr>
                <td height="30" align="left" valign="middle" class="leftmenu">Accountant</td>
              </tr>
              <tr>
                <td align="left" valign="top">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table4" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_NAMEOFUSER");?></th>
                      <th width="13%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                      <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                      <th width="26%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                      <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php					
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user', $condition. " And user_type='Accountant'","id DESC") as $val) {
					//Get centre name
					$res_centre = $dbf->strRecordID("centre","*","id='$val[center_id]'");
					?>
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='user_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                    <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                    <td width="6%" align="center" valign="middle"><?php if($val["user_status"]==0) { ?>
                      <a href="user_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User."></a>
                      <?php } else { ?>
                      <a href="user_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User."></a>
                      <?php } ?></td>
                    <td width="6%" align="center" valign="middle"><a href="user_edit.php?id=<?php echo $val[id];?>"><img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                    <td width="6%" align="center" valign="middle"><a href="user_process.php?action=delete&amp;id=<?php echo $val[id];?>" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
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
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"></td>
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
