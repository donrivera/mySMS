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
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
          6: { sorter: false },
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
          6: { sorter: false },
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<?php } ?>
<!--*******************************************************************-->

<script type="text/javascript">
function errorconfirm(){
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
<?php if($_SESSION[lang] == "EN"){?>
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
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="user_manage_print.php?fname=<?php echo $_REQUEST[fname];?>&mobile=<?php echo $_REQUEST[mobile];?>&email=<?php echo $_REQUEST[email];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            
            <form id="frm" name="frm" action="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="97%" height="5" align="left" valign="middle" class="leftmenu"></td>
              </tr>
              <tr>
                <td align="left" valign="top">
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
                  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
                        <th width="22%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                        <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                        <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                        <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?></th>
                        </tr>
                      </thead>
                    <?php
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
									
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user',$condition." And user_type='Student' And center_id='$_SESSION[centre_id]'","id DESC") as $val) {
					
					$pass = base64_decode(base64_decode($val["password"]));
					?>
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                      <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                      <td align="left" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $pass;?></td>
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
              </table>
            </form>
            </td>
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
<?php }else{?>
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="8%" height="30" align="center"><a href="user_manage_print.php?fname=<?php echo $_REQUEST[fname];?>&mobile=<?php echo $_REQUEST[mobile];?>&email=<?php echo $_REQUEST[email];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
                <td width="58%">&nbsp;</td>
                <td width="34%" align="right" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS");?>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
              
              <form id="frm" name="frm" action="">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="97%" height="5" align="left" valign="middle" class="leftmenu"></td>
                    </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="150" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                        <td width="149" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                        <td width="79" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                        <td width="109" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100_ar" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                        <td width="93" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp; : <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                        <td width="117" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                        <td width="87" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                        <td width="115" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100_ar" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                        <td width="77" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">&nbsp;: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                        </tr>
                      </table>
                      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                        <thead>
                          <tr class="logintext">
                            <th width="22%" height="25" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_USER_MANAGE_EMAIL");?></th>
                            <th width="20%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_USER_MANAGE_MOBILENO");?></th>
                            <th width="15%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_USER_MANAGE_USERID");?></th>
                            <th width="15%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_TEACHER1_MANAGE_PASSWORD");?></th>
                            <th width="24%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
                            <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                            </tr>
                          </thead>
                        <?php
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
									
					$i = 1;
					$color = "#ECECFF";
					
					foreach($dbf->fetchOrder('user',$condition." And user_type='Student' And center_id='$_SESSION[centre_id]'","id DESC") as $val) {
					
					$pass = base64_decode(base64_decode($val["password"]));
					?>
                        <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                          
                          
                          <td align="right" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[email];?></td>
                          <td align="right" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[mobile];?></td>
                          <td align="right" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $val[user_id];?></td>
                          <td align="right" valign="middle" class="tabledetailtext" style="padding-left:5px;"><?php echo $pass;?></td>
                          <td height="25" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[user_name];?></td>
                          <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
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
                  </table>
                </form>
              </td>
            </tr>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            </tr>
        </table></td>
      </tr>
    </table>
        
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
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
