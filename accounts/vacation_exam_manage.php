<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
include_once '../includes/language.php';

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
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

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
          5: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="54%" height="30" align="left" class="headingtext"><?php echo constant("ADMIN_VACATION_EXAM_MANAGE_MANAGEEXAM");?> </td>
                <td width="22%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#e6e6e6">
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000"  class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
                <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_VACATION_EXAM_ADD_EXAMNAME");?> </th>
				<th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_VACATION_EXAM_ADD_VACATIONFROM");?> </th>
			    <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_VACATION_EXAM_ADD_VACATIONEND");?></th>
                <th width="25%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_VACATION_EXAM_MANAGE_EXAMTYPE");?> </th>
                </tr>
			  </thead>
              <?php
					$i = 1;
					$color = "#ECECFF";
					$num=$dbf->countRows('exam_vacation',"");
					foreach($dbf->fetchOrder('exam_vacation',"","id DESC") as $val) {	
					
					//Get Centre Name
					$res = $dbf->strRecordID("centre","*","id='$val[centre_id]'");
					
					//Check status
					if($val[status] == '0')
					{
						$status = 'Pending';
					}
					else if($val[status] == '1')
					{
						$status = 'Approved';
					}
					else if($val[status] == '2')
					{
						$status = 'Rejected';
					}
									
					?>
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='vacation_exam_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res[name];?></td>
                <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[name];?></td>
				  <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val[frm]));?></td>
				    <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val[tto]));?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[type];?></td>
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
					if($num!=0)
					{
					?>
             
          <tr>
            <td> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
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
					if($num==0)
					{
					?>
              <tr>
                <td height="25" colspan="7" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?> </td>
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
</body>
</html>
