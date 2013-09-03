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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<script type="text/javascript" src="dropdowntabs.js"></script>

<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

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
            <td height="450" align="left" valign="top" bgcolor="#e6e6e6">
            
            <form name="frm" id="frm" action="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" align="left" class="logintext"><?php echo constant("CD_SICK_LEAVE_MANAGE_MANAGELEAVE");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"></td>
                    <td width="8%" align="left">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="3%" align="left" valign="middle">&nbsp;</td>
                    <td width="7%" height="30" align="right" valign="middle" class="red_smalltext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :&nbsp;</td>
                    <td width="90%" height="40" align="left" valign="middle">
                    <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;" onchange="javascript:document.frm.action='sick_leave_manage.php',document.frm.submit();">
                      <option value="">--Select--</option>
                      <?php
						foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
					  ?>
                      <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="selected" <?php } ?>><?php echo $valc[name];?></option>
                      <?php
					   }
					   ?>
                    </select></td>
                  </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="tablesorter-demo">
                <thead>
                  <tr class="logintext">
                    <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                    <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></th>
                    <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></th>
                    <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></th>
                    <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?></th>
                    <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                    <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?></th>
                    </tr>
                  </thead>
                  <?php	
				  $color="#ECECFF";			
					$i =1;
					$num=$dbf->countRows('sick_leave',"centre_id='$_REQUEST[centre_id]' And sick_status='0'");
					$color = "#ECECFF";
					foreach($dbf->fetchOrder('sick_leave',"centre_id='$_REQUEST[centre_id]' And sick_status='0'","id DESC") as $val) {
					
					if($val[sick_status]== '0')
					{
						$status='Pending';
					}
					elseif($val[sick_status]== '1')
					{
						$status='Approved';
					}
					else
					{
						$status='Rejected';
					}
					//$last = "Unit No (".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
					$res_teacher=$dbf->strRecordID("teacher","*","id='$val[teacher_id]'") ;
				?>
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                    <td height="25" align="center" valign="middle" class="mycon" style="background-color:<?php echo $color;?>"><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><?php echo $res_teacher[name];?></td>
                    <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><?php echo $val[from_date];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><?php echo $val[to_date];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><?php echo $val[sick_reason];?></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><a href="../teacher/sickleave/<?php echo $val[sick_attachment];?>" target="_blank" style="text-decoration:none;"> <?php echo $val[sick_attachment];?></a></td>
                    <td align="left" valign="middle" class="mycon" style="padding-left:5px;background-color:<?php echo $color;?>"><?php echo $status;?></td>
                    </tr>
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
				
				if($num==0)
				{
				?>
                  <tr>
                    <td height="25" colspan="9" align="center" valign="middle" bgcolor="#F8F9FB"><span class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?></span></td>
                  </tr>
                  <?
					}
					?>
                  <tr>
                    <td height="25" colspan="9" align="left" valign="middle" bgcolor="#F8F9FB" class="pedtext" ><?php echo constant("CD_SICK_LEAVE_MANAGE_OTHERS");?></td>
                  </tr>
                </table></td>
              </tr>
			  <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF">
                <br />
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="tablesorter-demo">
                <thead>
                  <tr class="logintext">
                    <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                    <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></th>
                    <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></th>
                    <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></th>
                    <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?></th>
                    <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                    <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?></th>
                  </tr>
                  </thead>
                  <?php				
					$i =1;
					$num=$dbf->countRows('sick_leave',"centre_id='$_REQUEST[centre_id]' And sick_status!='0'");
					$color1 = "#ECECFF";
					foreach($dbf->fetchOrder('sick_leave',"centre_id='$_REQUEST[centre_id]' And sick_status!='0'","id DESC") as $val) {
					
					if($val[sick_status]== '0')
					{
						$status='Pending';
					}
					elseif($val[sick_status]== '1')
					{
						$status='Approved';
					}
					else
					{
						$status='Rejected';
					}
					//$last = "Unit No (".$reslast["unit"].") ,". date('d/m/Y',strtotime($reslast[dated]));
					$res_teacher=$dbf->strRecordID("teacher","*","id='$val[teacher_id]'") ;
				?>
                  <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                    <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" ><?php echo $res_teacher[name];?></td>
                    <td height="25" align="left" valign="middle" class="mycon" ><?php echo $val[from_date];?></td>
                    <td align="left" valign="middle" class="mycon" ><?php echo $val[to_date];?></td>
                    <td align="left" valign="middle" class="mycon" ><?php echo $val[sick_reason];?></td>
                    <td align="left" valign="middle" class="mycon" ><a href="../teacher/sickleave/<?php echo $val[sick_attachment];?>" target="_blank" style="text-decoration:none;"> <?php echo $val[sick_attachment];?></a></td>
                    <td align="left" valign="middle" class="mycon" ><?php echo $status;?></td>
                    
                  </tr>
                  <?php
				 	$i = $i + 1;
					  if($color1=="#ECECFF")
					  {
						  $color1 = "#FBFAFA";
					  }
					  else
					  {
						  $color1="#ECECFF";
					  }
				}
				if($num==0)
				{
				?>
                  <tr>
                    <td height="25" colspan="10" align="center" valign="middle" bgcolor="#F8F9FB"><span class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?></span></td>
                  </tr>
                  <?
					}
					?>
                  <tr>
                    <td height="25" colspan="10" align="center" valign="middle" bgcolor="#F8F9FB" >&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <?php if($_REQUEST[msg]=="invalid") { ?>
              <?php } ?>
			   <?php if($_REQUEST[msg]=="added") { ?>
              <?php } ?>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
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
   <?php include '../footer.php';?>
</table>
</body>
</html>
