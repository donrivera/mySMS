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
          4: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
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
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
    <?php }?>
<!--*******************************************************************-->
<script type="text/javascript">
  
  function errorconfirm()
	{
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
<?php if($_SESSION[lang]=="EN"){?>
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
            <td align="left" valign="middle" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="centercolumntext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_MANAGE_STUDENT_APPOINTMENT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="center"><a href="student_appoint_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#e6e6e6">
			<form name="frm" id="frm" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%" height="22" align="center" valign="middle"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10%" align="left" valign="middle">Note :</td>
                    <td width="5%" align="left" valign="middle"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User." /></td>
                    <td width="39%" align="left" valign="middle" class="mycon">&nbsp;Active</td>
                    <td width="5%" align="left" valign="middle"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User." /></td>
                    <td width="41%" align="left" valign="middle" class="mycon">&nbsp;De-Active</td>
                  </tr>
                </table></td>
                <td width="8%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="26%">&nbsp;</td>
                <td width="20%">&nbsp;</td>
              </tr>
            </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			  <thead>
                <tr class="logintext">
                  <th height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?></th>
                  <th align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?></th>
                  <th align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></th>
                  <th colspan="4" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
			  </thead>
              <?php				
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student_appointment',"centre_id='$_SESSION[centre_id]'");
				foreach($dbf->fetchOrder('student_appointment',"centre_id='$_SESSION[centre_id]'","student_id") as $val) {
				$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
			  ?>
                    
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='student_appoint_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
              
                <td width="3%" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                <td width="9%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[dated];?></td>
				  <td width="31%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $dbf->printStudentName($res["id"]);?></td>
				    <td width="39%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[comments];?></td>
				    <td width="6%" align="center" valign="middle"><?php if($val["status"]==1) { ?>
				      <a href="student_appoint_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User." /></a>
				      <?php } else { ?>
				      <a href="student_appoint_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User." /></a>
				      <?php } ?></td>
				    <td width="4%" align="center" valign="middle"><a href="student_appoint_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
          				
				<?php
					  $num_sg=$dbf->countRows('group_size',"week_id='$val[id]'");
					  if($num_sg > 0)
					  {
						  ?>
                          <td width="4%" align="center" valign="middle"><a href="" onClick="errorconfirm();"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a></td>
                          <?php
					  }
					  else
					  {
					  ?>
                      <td width="4%" align="center" valign="middle"><a href="student_appoint_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a></td>
                      <?php
					  }
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
                <td height="25" colspan="6" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?
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
            <td align="left" valign="middle" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30"><a href="student_appoint_add.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="center" class="centercolumntext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_MANAGE_STUDENT_APPOINTMENT");?></td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#e6e6e6">
              <form name="frm" id="frm" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%" height="22" align="center" valign="middle">&nbsp;</td>
                <td width="8%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td width="36%" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="41%" align="right" valign="middle" class="mycon"><?php echo $Arabic->en2ar('De-Active');?>&nbsp;</td>
                    <td width="5%" align="left" valign="middle"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User." /></td>
                    <td width="39%" align="right" valign="middle" class="mycon"><?php echo $Arabic->en2ar('Active');?>&nbsp;</td>
                    <td width="5%" align="left" valign="middle"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User." /></td>
                    <td width="11%" align="left" valign="middle">&nbsp;: <?php echo $Arabic->en2ar('Note');?></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            </form>
              <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr class="logintext">
                  	<th colspan="3" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>                    
                    <th align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_DATE");?></th>                    
                    <th align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></th>
                    <th align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_STUDENTNAME");?></th>
                    <th height="25" align="right" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                    </tr>
                  </thead>
                <?php				
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student_appointment',"centre_id='$_SESSION[centre_id]'");
				foreach($dbf->fetchOrder('student_appointment',"centre_id='$_SESSION[centre_id]'","student_id") as $val) {
				$res = $dbf->strRecordID("student","*","id='$val[student_id]'");
			  ?>
                
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='student_appoint_edit.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                  
                  <td width="6%" align="center" valign="middle"><?php if($val["status"]==1) { ?>
                    <a href="student_appoint_process.php?action=block&amp;id=<?php echo $val[id];?>"><img src="../images/tick.png" width="16" height="16" border="0" title="Click to de-active the User." /></a>
                    <?php } else { ?>
                    <a href="student_appoint_process.php?action=unblock&amp;id=<?php echo $val[id];?>"><img src="../images/block.png" width="16" height="16" border="0" title="Click to Active the User." /></a>
                    <?php } ?></td>
                    <?php
					  $num_sg=$dbf->countRows('group_size',"week_id='$val[id]'");
					  if($num_sg > 0){
						  ?>
                          <td width="4%" align="center" valign="middle"><a href="" onClick="errorconfirm();"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a></td>
                          <?php } else { ?>
                  <td width="4%" align="center" valign="middle"><a href="student_appoint_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onClick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png" width="16" height="16" border="0" title="Delete" /></a></td>
                  <?php } ?>
                  
                  <td width="4%" align="center" valign="middle"><a href="student_appoint_edit.php?id=<?php echo $val[id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a></td>
                  <td width="9%" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[dated];?></td>
                  <td width="42%" height="25" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[comments];?></td>
                   <td width="28%" align="right" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res["id"]));?></td>
                  <td width="3%" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  
                  
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
            <td > <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
