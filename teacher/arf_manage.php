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
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
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
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <?php if($_SESSION[lang]=="EN"){?>
	<script type="text/javascript">
        $(function() {
            $("#sort_table")
                .tablesorter({ 
            headers: 
			{ 
				0:{sorter:false},
				6:{sorter:false},
				7:{sorter:false},
			} 
        })			
        .tablesorterPager({container: $("#pager"), size: 15});
        });
    </script>
    <?php }else{ ?>
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
        .tablesorterPager({container: $("#pager"), size: 15});
        });
    </script>
    <?php }?>
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="headingtext"><h1><?php echo constant("TEACHER_ARF_MANAGE_MANAGE_ARF");?></h1></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"></td>
                <td width="8%" align="left"><a href="arf_add.php">
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">              
              <tr>
                <td align="left" valign="top">
                <form id="frm" name="frm" action="">
                <table width="100%" height="36" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="71" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :&nbsp;</td>
                    <td width="155" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="81" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :&nbsp;</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="68" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :&nbsp;</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="58" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :&nbsp;</td>
                    <td width="113" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="164" align="right" valign="middle" bgcolor="#FFFFFF">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                  </tr>
                </table>
                </form>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTDATE");?></th>
                      <th width="23%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?></th>
                      <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONOWENER");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTTO");?></th>
					  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo "Status";?></th>
                      <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php
				  $i = 1;
					$color="#ECECFF";
					$teacher_id=$_SESSION[id];
					//Concate the Condition
					$condition = $dbf->getSearchStrings($_REQUEST["fname"],$_REQUEST["stid"],$_REQUEST["mobile"],$_REQUEST["email"], $centre_id,"s."," And s.id=c.student_id AND c.teacher_id='$teacher_id'");
					//End 4.					
					$num=$dbf->countRows('student s, arf c', $condition);
					foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) 
					{	
						$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
				  ?>
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='arf_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[dated];?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_student[first_name]."&nbsp;".$res_student[father_name]."&nbsp;".$res_student[family_name]."&nbsp;(".$res_student[first_name1]."&nbsp;".$res_student[father_name1]."&nbsp;".$res_student[grandfather_name1]."&nbsp;".$res_student[family_name1].")";?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[action_owner];?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[arf_function];?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[arf_function1];?></td>
					<td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo "Submitted";?></td>
                    <td width="4%" align="center" valign="middle"><a href="arf_print.php?id=<?php echo $val[id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/></a></td>
                    <td width="5%" align="center" valign="middle"><a href="arf_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" border="0" title="Edit" /></a></td>
                    <td width="5%" align="center" valign="middle"><a href="arf_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                    <?php
					  $i = $i + 1;
					  if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
					  }
					  ?>
                  </tr>
                </table></td>
              </tr>
              <?php
				if($num> 0)
				{
				?>
                  <tr>
                    <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
				}
				if($num==0)
				{
				?>
              <tr>
                <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?php
                }
                ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:0px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="60%" height="30"><a href="arf_add.php">
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="8%">&nbsp;</td>
                <td width="32%" align="right" class="headingtext"><?php echo constant("TEACHER_ARF_MANAGE_MANAGE_ARF");?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">              
              <tr>
                <td align="left" valign="top">
                <form id="frm" name="frm" action="">
                <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="157" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                      <td width="112" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="80" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                      <td width="102" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100_ar" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="101" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                      <td width="112" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="77" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                      <td width="102" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100_ar" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="82" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    </tr>
                  </table>
                </form>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                  <thead>
                    <tr class="logintext">
                      
                      <th height="25" colspan="3" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                      <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTTO");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTBY");?></th>
                      <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONOWENER");?></th>
                      <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_REPORTDATE");?></th>
                      <th width="4%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_PARAMETER_TEMPLETE_SL_NO");?></th>
                      </tr>
                  </thead>
                  <?php
				  $i = 1;
					$color="#ECECFF";
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "d.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%) AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id>'0'";
					}
					
					$condition = $condition."  And s.id=c.student_id";
					
					//End 4.					
					$num=$dbf->countRows('student s, arf c', $condition);
					foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) {
																
					$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
				  ?>
                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='arf_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                    <td width="4%" align="center" valign="middle"><a href="arf_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="<?php echo ACTION_CAPTION_DELETE ?>" /></a></td>
                    <td width="4%" align="center" valign="middle"><a href="arf_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" border="0" title="<?php echo EDIT?>" /></a></td>
                    <td width="3%" align="center" valign="middle"><a href="arf_print.php?id=<?php echo $val[id];?>" target="_blank">
                      <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"/></a></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[report_to];?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[report_by];?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[action_owner];?></td>
                    <td align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res_student[first_name]."&nbsp;".$res_student[father_name]."&nbsp;".$res_student[family_name]."&nbsp;(".$res_student[first_name1]."&nbsp;".$res_student[father_name1]."&nbsp;".$res_student[grandfather_name1]."&nbsp;".$res_student[family_name1].")";?></td>
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $val[dated];?></td>
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

                </table></td>
              </tr>
              <?php
				if($num> 0)
				{
				?>
                  <tr>
                        <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
				}
				if($num==0)
				{
				?>
                  <tr>
                    <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                  <?php
					}
					?>
            </table></td>
          </tr>
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