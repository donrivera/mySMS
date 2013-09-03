<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

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
          //6: {sorter: false}, 
          7: { sorter: false },
		  //0: { sorter: false },
		  //4: { sorter: false },
		  //5: { sorter: false },
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
$count = $res_logout[name]+1; // Set timeout period in seconds
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
        <td width="19%" align="left" valign="top"><?php include'left_menu.php'?></td>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("SA_STUDENT_TO_STUDENT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" >
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                <th width="11%" align="left" valign="middle" bgcolor="#DDDDDD" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_DATE");?></th>
                <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_FROM");?></th>
                <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_TO");?></th>
                <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("CD_STUDENT_TRANSFER_NO");?></th>
                <th width="46%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?></th>
                <th width="5%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
			  </thead>
              <?php					
					$i = 1;
					$color = "#ECECFF";
                    $num=$dbf->countRows('transfer_student_to_student',"","");
					
					foreach($dbf->fetchOrder('transfer_student_to_student',"","id DESC ","*") as $transfer){
					
					//No. of students has been transfer
					$dtls = $dbf->strRecordID("transfer_student_to_student_dtls","COUNT(id)","parent_id='$transfer[id]'");					
					$noofstudent = $dtls["COUNT(id)"];
					
					$from_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[from_id]'");
					$group_from = $dbf->getDataFromTable("student_group","*","id='$transfer[from_id]'");
					
					$to_id = $dbf->getDataFromTable("student_group","group_name","id='$transfer[to_id]'");
					$group_to = $dbf->getDataFromTable("student_group","*","id='$transfer[to_id]'");
					?>
              <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td height="25" align="center" valign="middle" class="mycon" ><?php echo $i;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[dated];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $from_id;?> <?php echo $group_from["group_time"];?>-<?php echo $dbf->GetGroupTime($group_from["id"]);?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $to_id;?> <?php echo $group_to["group_time"];?>-<?php echo $dbf->GetGroupTime($group_to["id"]);?></td>
                <td align="center" valign="middle" class="mycon"><?php echo $noofstudent;?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:2px;"><?php echo $transfer[comment];?></td>
                <td align="center" valign="middle" class="mycon" ><?php echo $transfer[status];?></td>
                <td align="center" valign="middle" >
                <?php if($transfer["status"] == 'Pending'){?>
                <a href="student_to_student_status.php?tran_id=<?php echo $transfer["id"];?>&page=student_to_student_status.php&amp;TB_iframe=true&amp;height=300&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/change_status2.png" width="16" height="16" border="0" title="Set Status" /></a>
                <a href="student_to_student_process.php?action=delete&amp;del_id=<?php echo $transfer[id];?>"  class="linktext" ></a>
                <?php } if($transfer["status"] == 'Rejected'){?><img src="../images/change_status2.png" width="16" height="16" border="0" title="Rejected" />
                <?php } if($transfer["status"] == 'Approved'){?><img src="../images/tickbox.png" width="16" height="16" border="0" title="Approved" />
                <?php } ?>
                </td>
                <?php
					$numg=$dbf->countRows('student_group_dtls',"student_id='$val[id]'");
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
			if($num!=0)
			{
			?>            
          <tr>
            <td>
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" valign="top" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
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
                <td height="30"  colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
				<?php
				}
				?>
        </table></td>
      </tr>
    </table>
    </td>
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
