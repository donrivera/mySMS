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

<!--table sorter ***************************************************** -->
<?php if($_SESSION[lang]=="EN"){?>
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
            // assign the secound column (we start counting zero) 
         0: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 15});
	});
</script>
<?php } ?>
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
$count = $res_logout[name]+1; // Set timeout period in seconds
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("SA_MENU_ARF_REPORTS");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp; </td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top">
            
            <form id="frm" name="frm" action="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="left" valign="top" >
                <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="71" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :</td>
                    <td width="155" height="36" align="left" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="81" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="68" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="58" height="36" align="right" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :</td>
                    <td width="113" height="36" align="left" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="164" align="right" valign="middle" bgcolor="#FFFFFF">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                  </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTDATE");?></th>
                      <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></th>
                      <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWENER");?></th>
                      <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></th>
                      <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTTO");?></th>
                      <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    </tr>
                  </thead>
                  <?php
				  $i = 1;
					$color="#ECECFF";					
					$centre_id = $_SESSION['centre_id'];
					
					$condition = $dbf->getSearchStrings($_REQUEST["fname"],$_REQUEST["stid"],$_REQUEST["mobile"],$_REQUEST["email"], $centre_id,"s."," And s.id=c.student_id");

					//End 4.					
					$num=$dbf->countRows('student s, arf c', $condition);
					foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) {
																
					$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
					?>
                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='arf_view.php?student_id=<?php echo $val["id"];?>'" style="cursor:pointer;">
                    <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[dated];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[student_id];?>" style="cursor:pointer;"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></a></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[action_owner];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[report_by];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[report_to];?></td>
                    <td align="center" valign="middle"><a href="arf_view.php?student_id=<?php echo $val[id];?>">
                    <img src="images/search.png" width="20" height="20" border="0" title="<?php echo ICON_VIEW ?>" /></a></td>
                    <td width="5%" align="center" valign="middle"><a href="arf_print.php?student_id=<?php echo $val[id];?>" target="_blank">
                    <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>" /></a></td>
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
              <?php if($num> 0) { ?>
              <tr>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left"><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
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
                    <?php } if($num==0){?>
                  <tr>
                    <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                  <?php } ?>
                </table>
                </form>
                </td>
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
                  <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                       <td width="8%" align="left">&nbsp;</td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp; </td>
                      <td width="54%" height="30" class="logintext" align="right"><?php echo constant("SA_MENU_ARF_REPORTS");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" >
                  
                  <form id="frm" name="frm" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF">
                      <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="152" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu"><input type="submit" name="submit2" id="submit2" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                      <td width="117" height="36" align="right" valign="middle" bgcolor="#FFFFFF" ><input name="fname" type="text" class="new_textbox100_ar" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                      <td width="81" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                      <td width="102" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="stid" type="text" class="new_textbox100_ar" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="99" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                      <td width="114" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="mobile" type="text" class="new_textbox100_ar" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                      <td width="66" height="36" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                      <td width="102" height="36" align="right" valign="middle" bgcolor="#FFFFFF"><input name="email" type="text" class="new_textbox100_ar" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                      <td width="92" align="left" valign="middle" bgcolor="#FFFFFF" class="leftmenu">: <?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    </tr>
                  </table>
                      <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                        <thead>
                          <tr class="logintext">
                           
                            <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("COMMON_ACTION");?></th>
                            <th width="16%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></th>
                            <th width="17%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWENER");?></th>
                            <th width="20%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?></th>
                            <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTTO");?></th>
                            
                            <th width="17%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTDATE");?></th>
                             <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                            </tr>
                          </thead>
                        <?php					
						$i = 1;
						$color="#ECECFF";					
						$centre_id = $_SESSION['centre_id'];
						$condition = $dbf->getSearchStrings($_REQUEST["fname"],$_REQUEST["stid"],$_REQUEST["mobile"],$_REQUEST["email"], $centre_id,"s."," And s.id=c.student_id");
						
						//End 4.					
						$num=$dbf->countRows('student s, arf c', $condition);
						foreach($dbf->fetchOrder('student s, arf c', $condition ,"c.dated desc") as $val) {
																	
						$res_student = $dbf->strRecordID("student","*","id='$val[student_id]'");
					?>
                        
                        <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='arf_view.php?student_id=<?php echo $val[id];?>'" style="cursor:pointer;">
                         <td align="center" valign="middle"><a href="arf_view.php?student_id=<?php echo $val[id];?>">
                         <img src="images/search.png" width="20" height="20" border="0" title="<?php echo ICON_VIEW ?>" /></a></td>
                          <td width="5%" align="center" valign="middle"><a href="arf_print.php?student_id=<?php echo $val[id];?>" target="_blank">
                            <img src="../images/print.png" width="16" height="16" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>" /></a></td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[action_owner];?></td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[report_by];?></td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[report_to];?></td>
                         
                             <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[dated];?></td>
                            <td align="right" valign="middle" class="mycon"><?php echo $i;?></td>
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
                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
                    <?
					}
					?>
                    </table>
                    </form>
                    </td>
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>