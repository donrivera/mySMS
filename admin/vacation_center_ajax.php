<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
$startdate = $_REQUEST[startdate];
$enddate = $_REQUEST[enddate];
$teacher_id = $_REQUEST[teacher];

if($teacher_id == "")
{
	?>
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td height="20" align="right" valign="middle" class="leftmenu" style="padding-right:5px;">&nbsp;</td>
        </tr>
        <tr>
        <td height="20" align="right" valign="middle" class="leftmenu" style="padding-right:5px;">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCCFF;">
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#FFFF99" class="nametext1"><?php echo constant("ADMIN_VACATION_CENTRE_AJAX_SELECTCENTER");?></td>
          </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td align="right" valign="middle" style="padding-right:5px;"></td>
        </tr>
    </table>
    <?php
	exit;
}

$num=$dbf->countRows('student_group',"centre_id='$teacher_id'");
if($num <= 0)
{
	?>
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td height="20" align="right" valign="middle" class="leftmenu" style="padding-right:5px;">&nbsp;</td>
        </tr>
        <tr>
        <td height="20" align="right" valign="middle" class="leftmenu" style="padding-right:5px;">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCCFF;">
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#FFFF99" class="nametext1"><?php echo constant("ADMIN_VACATION_CENTRE_AJAX_NOSCHEDULE");?></td>
          </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td align="right" valign="middle" style="padding-right:5px;"></td>
        </tr>
    </table>
    <?php
	exit;
}


if($teacher_id > 0)
{
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
    <tr>
      <td height="30" align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_CENTER_EDIT_SCHEDULE");?></td>
    </tr>
    <tr>
      <td height="20" align="left" valign="middle">
      <?php
      foreach($dbf->fetchOrder('student_group',"centre_id='$teacher_id'","id","*","") as $val) {
		  
		  //Get group Name
		  $res_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
		  
      ?>
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" align="left" valign="middle" bgcolor="#FFCC99" class="leftmenu" style="padding-left:5px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
        </tr>
        <?php
		foreach($dbf->fetchOrder('student_group',"group_id='$val[group_id]' AND centre_id='$teacher_id'","id") as $val_c) {
			
			//Get Course Name
			$res_course = $dbf->strRecordID("course","*","id='$val_c[course_id]'");
		?>
        <tr>
          <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo $res_course[name];?></td>
        </tr>
        <tr>
          <td align="right" valign="middle" style="padding-right:5px;">
          <table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
          <?php
		  $i = 1;
		  foreach($dbf->fetchOrder('student_group',"course_id='$val_c[course_id]' AND group_id='$val[group_id]' AND centre_id='$teacher_id'","id") as $val_dtls) {
		  ?>
            <tr>
              <td width="10%" height="20" align="center" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo $i;?> </td>
              <?php
			  $s1 = date('M d',strtotime($val_dtls["start_date"]));
			  $s2 = date('M d',strtotime($val_dtls["end_date"]));
			  $dt = $s1." - ". $s2;
			  ?>
              <td width="52%" bgcolor="#FFFFCC" class="mytext">
              <?php echo $dt; ?>
              </td>
            </tr>
            <?php
			}
			?>
          </table>
          <br />
          </td>
        </tr>
        <?php
	  }
       ?> 
      </table>
      <?php
	  }
	  ?>
      </td>
    </tr>
    <tr>
      <td height="0" align="left" valign="middle">&nbsp;</td>
    </tr>
    </table>
<?php
}
else
{
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8faed" style="border:solid 1px #a8b56c;">
    <tr>
      <td height="30" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
        <tr>
          <td width="87%" height="25" align="center" valign="middle" bgcolor="#FFDDD7" class="red_smalltext"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_TEXT");?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20" align="center" valign="middle" bgcolor="#666666" class="logintext"><?php echo constant("ADMIN_VACATION_CENTRE_AJAX_SHOWSCHEDULE");?></td>
    </tr>
    <tr>
      <td height="20" align="left" valign="middle"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" align="left" valign="middle" bgcolor="#FFCC99" class="leftmenu" style="padding-left:5px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_G1");?></td>
        </tr>
        <tr>
          <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSA");?></td>
        </tr>
        <tr>
          <td align="right" valign="middle" style="padding-right:5px;"><table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
            <tr>
              <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
              <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
              <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSB");?></td>
    </tr>
    <tr>
      <td height="0" align="right" valign="middle" style="padding-right:5px;"><table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
        <tr>
          <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
          <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
        </tr>
        <tr>
          <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
          <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="0" align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td height="0" align="left" valign="middle"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" align="left" valign="middle" bgcolor="#FFCC99" class="leftmenu" style="padding-left:5px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_G2");?></td>
        </tr>
        <tr>
          <td height="20" align="left" valign="middle" class="leftmenu" style="padding-left:15px;"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_CLASSA");?></td>
        </tr>
        <tr>
          <td align="right" valign="middle" style="padding-right:5px;"><table width="90%" border="1" cellspacing="0" bordercolor="#FFCC99" cellpadding="0" style="border-collapse:collapse;">
            <tr>
              <td width="10%" height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK1");?></td>
              <td width="52%" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN1_7");?></td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle" bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_WEEK2");?></td>
              <td bgcolor="#FFFFCC" class="mytext"><?php echo constant("ADMIN_VACATION_CENTRE_ADD_JAN8_14");?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="0" align="left" valign="middle">&nbsp;</td>
    </tr>
</table>
  <?php
}
	  
?>