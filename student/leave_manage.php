<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['students_uid']=="" || $_SESSION['students_user_type']!="Student")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("student_vacation","id='$_REQUEST[id]'");
	header("Location:leave_manage.php");
}
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
<script type="text/javascript" src="../js/dropdowntabs.js"></script>

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<?php if($_SESSION[lang] == "EN") { ?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          4: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })	
		.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
    <?php } else{?>
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
		.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
    <?php }?>
<!--*******************************************************************-->
<script type="text/javascript">
  
function errorconfirm(){
	alert("Record can't be deleted as it has been used in the other part of Application.")
}
</script>

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
<?php if($_SESSION[lang] == "EN") { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_student.php';?></td>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("MANAGE_LEAVE");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="leave_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#e6e6e6">
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			  <thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVEFROM");?></th>
			    <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVETO");?></th>
				<th width="58%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_REASON");?></th>
                <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
              </tr>
			  </thead>
              <?php
					
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student_vacation',"student_id='$_SESSION[uid]'");
				foreach($dbf->fetchOrder('student_vacation',"student_id='$_SESSION[uid]'","id") as $val) {
			  ?>
              
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='leave_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
              
                <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d/m/Y',strtotime($val[frm]));?></td>
				  <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d/m/Y',strtotime($val[tto]));?></td>
				    <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[reason];?></td>
				      <?php if($val[status]=='0') { $status = "Pending"; } else { $status = "Approved"; }?>
                    <td width="8%" align="center" valign="middle"><?php echo $status;?></td>
                  <td width="4%" align="center" valign="middle"><a href="leave_edit.php?id=<?php echo $val[id];?>"> <?php if($val[status]=='0') {?>
                  <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /> <?php } ?> </a></td>
          		<td width="4%" align="center" valign="middle"><a href="leave_manage.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')">
                <?php if($val[status]=='0') {?>
                <img src="../images/delete.png" width="16" height="16" border="0" title="Delete" />
                <?php } ?>
                </a></td>
				<?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#E7FEEA";
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
                <td height="25" colspan="6" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30"><a href="leave_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="right" class="logintext"><?php echo constant("MANAGE_LEAVE");?>&nbsp;&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#e6e6e6">
              <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr class="logintext">
                  	<th colspan="3" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                    
                    <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVEFROM");?></th>
                    <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVETO");?></th>
                    <th width="55%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("STUDENT_LEAVE_MANAGE_REASON");?></th>
                    <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                    </tr>
                  </thead>
                <?php					
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student_vacation',"student_id='$_SESSION[uid]'");
				foreach($dbf->fetchOrder('student_vacation',"student_id='$_SESSION[uid]'","id") as $val) {
			  ?>                
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='leave_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                  
                  <?php if($val[status]=='0') { $status = "Pending"; } else { $status = "Approved"; }?>
                  <td width="5%" align="center" valign="middle"><a href="leave_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')">
                    <?php if($val[status]=='0') {?>
                    <img src="../images/delete.png" width="16" height="16" border="0" title="Delete" />
                    <?php } ?>
                    </a></td>
                  <td width="4%" align="center" valign="middle"><a href="leave_edit.php?id=<?php echo $val[id];?>"> <?php if($val[status]=='0') {?>
                    <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /> <?php } ?> </a></td>
                  <td width="8%" align="center" valign="middle"><?php echo $status;?></td>                  
                  
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d/m/Y',strtotime($val[frm]));?></td>
                  <td height="25" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d/m/Y',strtotime($val[tto]));?></td>
                  <td height="25" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[reason];?></td>
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  
                  <?php
					  $i = $i + 1;
					   if($color=="#ECECFF")
					  {
						  $color = "#E7FEEA";
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
            <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
             
              </table></td>
            </tr>
        </table></td>
      </tr>
       <?php
			   }
					if($num==0)
					{
					?>
              <tr>
                <td height="25" colspan="6" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
              <?php
					}
					?>
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
