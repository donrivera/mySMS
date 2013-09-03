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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <form name="frm" method="post" id="frm">
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
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
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("CD_CENTRE_SCHEDULE_TABLE_HEADING");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="35" align="left" valign="middle" >
            <?php //if($_REQUEST["course"] != ''){?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td width="36" align="center" valign="top"><a href="centre_schedule_table_word.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
                <td width="36" align="center" valign="top"><a href="centre_schedule_table_csv.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
                <td width="30" align="center" valign="top"><a href="centre_schedule_table_pdf.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
                <td width="36" align="center" valign="middle">&nbsp;</td>
              </tr>
            </table>
            <?php //} ?>
		  
            <table width="800" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
              <tr>
                <td width="157" height="25" align="right" valign="middle" bgcolor="#FBF3E6" class="pedtext"><?php echo constant("CD_CENTRE_SCHEDULE_TABLE_CHOOSELEVELCOURSE");?> :&nbsp;</td>
                <td width="173" align="left" valign="middle" bgcolor="#FBF3E6">
                  <select name="course" id="course" style="width:170px; border:solid 1px; border-color:#FFCC00;"  onChange="javascript:document.frm.action='centre_schedule_table.php',document.frm.submit();">
                    <option value="">--Select Level/Course--</option>
                    <?php
						foreach($dbf->fetchOrder('course',"","") as $ress2) {
					  ?>
                    <option value="<?php echo $ress2['id']?>"<?php if($ress2["id"]==$_REQUEST[course]) {?> selected="selected"<?php }?> > <?php echo $ress2['name'];?></option>
                    <?php }?>
                    </select>
                </td>
                <td width="468" align="left" valign="middle" bgcolor="#FBF3E6" class="red_smalltext"><?php echo constant("CD_CENTRE_SCHEDULE_TABLE_RECORDDISPLAYACCORDINGTOLEVEL");?></td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td align="left" valign="top">
            <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">            
              <tr>
                <td height="25" align="left" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("RECEPTION_GROUP_MANAGE_NAMETEACHER");?></td>
                <td align="left" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_GROUPNM");?></td>
                <td align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT");?></td>
                <td align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></td>
              </tr>
            <?php
			$color = "#ECECFF";
			//Get Number of Rows
			$num=$dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","");
			 
            //Loop start
			foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","id","") as $val){
			
			//Get no of students
			$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");
			
			//Get group name
			$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
			
			//Get course name
			$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
			
			//Get teacher name
			$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
			
			?>
              
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td width="240" height="25" align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_teacher[name];?></td>
                <td width="466" align="left" valign="middle" class="mycon">&nbsp;<?php echo $dbf->FullGroupInfo($val["id"]);?></td>
                <td width="127" align="center" valign="middle" class="mycon"><?php echo $val_no["COUNT(id)"];?></td>
                <td width="128" align="center" valign="middle" class="mycon"><?php echo $val[status];?></td>
              </tr>
            <?php 
			if($color=="#ECECFF")
				  {
					  $color = "#FBFAFA";
				  }
				  else
				  {
					  $color="#ECECFF";
				  }
			
			} ?>
            </table></td>
          </tr>
          <?php if($num==0) {?>
		  <tr>
            <td height="20" align="center" valign="middle" bgcolor="#FBF3E6" class="nametext"><?php echo constant("CD_CENTRE_SCHEDULE_ENDDATE_NORECFOUND");?></td>
          </tr>
          <?php } ?>
        </table></td>
      </tr>
    </table>
    </form>
    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
   <?php include '../footer.php';?>
</table>
<?php } else{?>
<table style="margin-top:-15px;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <form name="frm" method="post" id="frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("CD_CENTRE_SCHEDULE_TABLE_HEADING");?></td>
                     </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="35" align="right" valign="middle" >
                    <?php //if($_REQUEST["course"] != ''){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="36" align="center" valign="middle">&nbsp;</td>
						<td width="30" align="center" valign="top"><a href="centre_schedule_table_pdf.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
						<td width="36" align="center" valign="top"><a href="centre_schedule_table_csv.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
						<td width="36" align="center" valign="top"><a href="centre_schedule_table_word.php?course=<?php echo $_REQUEST["course"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
						<td>&nbsp;</td>
					  </tr>
					</table>
					<?php //} ?>
					
                    <table width="800" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                      <tr>
                        <td width="468" align="right" valign="middle" bgcolor="#FBF3E6" class="red_smalltext"><?php echo constant("CD_CENTRE_SCHEDULE_TABLE_RECORDDISPLAYACCORDINGTOLEVEL");?></td>
                        <td width="173" align="left" valign="middle" bgcolor="#FBF3E6">
                          <select name="course" id="course" style="width:170px; border:solid 1px; border-color:#FFCC00;"  onChange="javascript:document.frm.action='centre_schedule_table.php',document.frm.submit();">
                            <option value="">--<?php echo constant("SELECT_LEVEL/COURSE");?>--</option>
                            <?php
						   foreach($dbf->fetchOrder('course',"","") as $ress2) {
					       ?>
                            <option value="<?php echo $ress2['id']?>"<?php if($ress2["id"]==$_REQUEST[course]) {?> selected="selected"<?php }?> > <?php echo $ress2['name'];?></option>
                            <?php }?>
                            </select>
                          </td>
                        <td width="157" height="25" align="left" valign="middle" bgcolor="#FBF3E6" class="pedtext">: <?php echo constant("CD_CENTRE_SCHEDULE_TABLE_CHOOSELEVELCOURSE");?></td>
                        </tr>
                      </table></td>
                  </tr>
                
                <tr>
                  <td align="left" valign="top">
                    <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">            
                      <tr>
                        <td align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("TEACHER_MY_GROUPS_STATUS");?></td>
                        <td align="center" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("CD_CENTRE_SCHEDULE_RANGEDATE_NOOFSTUDENT");?></td>
                        <td align="right" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_STUDENT_MANAGE_GROUPNM");?>&nbsp;</td>
                        <td height="25" align="right" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("RECEPTION_GROUP_MANAGE_NAMETEACHER");?>&nbsp;</td>
                      </tr>
                      <?php
						$color = "#ECECFF";
						//Get Number of Rows
						$num=$dbf->countRows('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","");
						 
						//Loop start
						foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And course_id='$_REQUEST[course]'","id","") as $val){
						
						//Get no of students
						$val_no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$val[id]'");
						
						//Get group name
						$val_group = $dbf->strRecordID("common","*","id='$val[group_id]'");
						
						//Get course name
						$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
						
						//Get teacher name
						$val_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
						
						?>
                      
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                        <td width="120" align="center" valign="middle"  class="mycon"><?php echo $val[status];?></td>
                        <td width="123" align="center" valign="middle"  class="mycon"><?php echo $val_no["COUNT(id)"];?></td>
                        <td width="455" align="right" valign="middle"  class="mycon"><?php echo $dbf->FullGroupInfo($val["id"]);?>&nbsp;</td>
                        <td width="257" height="25" align="right" valign="middle"  class="mycon"><?php echo $val_teacher[name];?>&nbsp;</td>
                      </tr>
                      <?php 
					if($color=="#ECECFF")
						  {
							  $color = "#FBFAFA";
						  }
						  else
						  {
							  $color="#ECECFF";
						  }
					
					} ?>
                      </table></td>
                  </tr>
                <?php if($num==0) {?>
                <tr>
                  <td height="20" align="center" valign="middle" bgcolor="#FBF3E6" class="nametext"><?php echo constant("CD_CENTRE_SCHEDULE_ENDDATE_NORECFOUND");?></td>
                  </tr>
                <?php } ?>
                </table></td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </form>
    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
   <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
