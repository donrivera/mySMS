<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

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
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
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
            <td height="30" align="left" valign="middle" class="centercolumntext"style="background:url(../images/footer_repeat.png) repeat-x;padding-left:10px;"><?php echo constant("CD_AUTO_SEARCH_HEADING");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
            <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#DFF2DB" class="tablesorter" id="tablesorter-demo">
             <thead>
              <tr class="pedtext">
                <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="21%" align="left" valign="middle" class="pedtext" > <?php echo constant("ADMIN_STUDENT_MANAGE_NAMEOFSTUDENT");?></th>
                <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                <th width="6%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>
                <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_CONTACTNUMBER");?></th>
                <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></th>
                <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_S2_COUNTRY");?></th>
                <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_ACTION");?></th>
              </tr>
              </thead>
              <?php					
					$color = "#ECECFF";
					$i = 1;
					$num=$dbf->countRows('student',"centre_id='$_SESSION[centre_id]' And (first_name like '$_REQUEST[testinput]%' OR student_first_name like '$_REQUEST[testinput]%')");
					foreach($dbf->fetchOrder('student',"centre_id='$_SESSION[centre_id]' And (first_name like '$_REQUEST[testinput]%' OR student_first_name like '$_REQUEST[testinput]%')","") as $val) {
					?>
              <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td height="25" align="center" valign="middle" class="contenttext" ><?php echo $i;?></td>
                <td align="left" valign="middle"  class="contenttext" ><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                <td align="left" valign="middle"  class="contenttext" ><?php echo $val[email];?></td>
                <td align="left" valign="middle"  class="contenttext" ><?php echo $val[age];?></td>
                <td align="left" valign="middle" class="contenttext" ><?php echo $val[student_mobile];?></td>
                <td align="left" valign="middle"  class="contenttext" ><?php echo $val[student_comment];?></td>
                <td align="left" valign="middle"  class="contenttext" >
                <?php
				foreach($dbf->fetchOrder('countries',"id='$val[country_id]'","") as $val1) {
				 echo $val1[value];
				}
				?>
                </td>
                <td height="25" align="center" valign="middle"  class="contenttext" ><a href="auto_search_view.php?id=<?php echo $val[id];?>"><img src="../images/view_icon.png" width="16" height="16" border="0" title="View"/></a></td>
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
              <?php if($num==0) {?>
              <tr>
                <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
              </tr>
              <?php } ?>              
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
 <?php include '../footer.php';?>
</table>
</body>
</html>
