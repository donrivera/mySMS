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
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 15});
	});
	</script>
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
            <td height="30" bgcolor="#FFA938" class="amt_head"  style="background:url(../images/footer_repeat.png) repeat-x;padding-left:10px;"><?php echo constant("CD_AUTO_SEARCH_HEADING");?></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
              <thead>
                <tr class="logintext">
                  <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_STUDENT_MANAGE_NAMEOFSTUDENT");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                  <th width="6%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_CONTACTNUMBER");?></th>
                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_COUNTRY");?></th>
                  <th colspan="3" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_ACTION");?></th>
                </tr>
              </thead>
              <?php
				$auto_search=$_REQUEST[testinput];
				#$auto_search=explode(" ",$_REQUEST[testinput]);
				#$fname=$auto_search[0];
				#$father_name=$auto_search[1];
				#$family_name=$auto_search[2]." ".$auto_search[3];
				$sql_string=$dbf->genericQuery("SELECT * 
												FROM student 
												WHERE centre_id='$_SESSION[centre_id]' 
												AND (concat_ws(' ',first_name,father_name,family_name)
												LIKE '%$auto_search%')");
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student',"(family_name='$family_name' AND father_name='$father_name' AND first_name LIKE '$fname')  And centre_id='$_SESSION[centre_id]'");
				#foreach($dbf->fetchOrder('student',"(family_name='$family_name' AND father_name='$father_name' AND first_name LIKE '$fname')  And centre_id='$_SESSION[centre_id]'","id DESC ") as $val){
				foreach($sql_string as $val){
					$num_comment=$dbf->countRows('student_comment',"student_id='$val[id]'");
					$valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
					
					$status_id = $dbf->getDataFromTable("student_moving", "MAX(id)", "student_id='$val[id]'");
					$status_id = $dbf->getDataFromTable("student_moving", "status_id", "id='$status_id'");
					$moving = $dbf->strRecordID("student_status","*","id='$status_id'");
					?>
              <tr bgcolor="<?php echo $color;?>"  onmouseover="this.bgColor='#FDE6D0'" onmouseout="this.bgColor='<?php echo $color;?>'" onclick="javascript:window.location.href='auto_search_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="contenttext" style=""><?php echo $i;?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dbf->printStudentName($val["id"]);?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
                <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[age];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php
				foreach($dbf->fetchOrder('countries',"id='$val[country_id]'","") as $val1) {
				 echo $val1[value];
				}
				 ?></td>
                <?php
				  $numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
				  ?>
                <td width="6%" align="center" valign="middle" class="contenttext" style="padding-left:5px;"></td>
                <td width="6%" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><a href="auto_search_edit.php?id=<?php echo $val[id];?>"><span class="contenttext" style="padding-left:5px;background-color:<?php echo $color;?>"><img src="../images/edit_icon.png" width="16" height="16" border="0" title="Edit" /></span></a><a href="auto_search_edit.php?id=<?php echo $val[id]; ?>"></a></td>
                <td width="6%" height="25" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><a href="auto_search_view.php?id=<?php echo $val[id]; ?>"><img src="../images/view_icon.png" border="0"  title="View"/></a><a href="auto_search_view.php?id=<?php echo $val[id]; ?>"></a></td>
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
          <tr>
            <td align="left" valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="readonly" style="border:solid 1px; border-color:#999999;"/>
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
            <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?></td>
          </tr>
          <?php
					}
					?>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
 <?php include '../footer.php';?>
</table>
</body>
</html>
